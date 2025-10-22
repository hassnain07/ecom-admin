<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Models\Categories;
use App\Models\ParentCategories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:View Categories')->only('index');
        $this->middleware('permission:Edit Categories')->only('edit');
        $this->middleware('permission:Add Categories')->only('create');
        $this->middleware('permission:Delete Categories')->only('destroy');
    }
    public function index()
    {
        return view('categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parent = ParentCategories::all();
        return view('categories.create',compact('parent'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // ✅ Validate input
            $validated = $request->validate([
                'category_name' => 'required|string|max:255',
                'parent_id' => 'nullable|exists:parent_categories,id',
            ], [
                'category_name.required' => 'The category name is required.',
                'category_name.string' => 'The category name must be valid text.',
                'category_name.max' => 'The category name cannot exceed 255 characters.',
                'category_name.unique' => 'This category name already exists.',
                'parent_id.exists' => 'The selected parent category does not exist.',
            ]);

            // ✅ Save category
            $category = new Categories();
            $category->category_name = $validated['category_name'];
            $category->parent_category_id = $validated['parent_id'] ?? null;
            $category->save();

            return redirect()
                ->route('categories.index')
                ->with('success', 'Category added successfully.');
        } catch (\Exception $e) {
            // Log for debugging
            \Log::error('Category store error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while saving the category. Please try again.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)

    {
        $category = Categories::findOrFail($id);
        $parentCategories = ParentCategories::select('id', 'name')->get(); // assuming model name = ParentCategories

        return view('categories.edit', compact('category', 'parentCategories'));
    }


    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, $id)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'category_name' => 'required|string|max:255' . $id,
                'parent_id'     => 'nullable|exists:parent_categories,id', // validate parent category
            ], [
                'category_name.required' => 'The category name is required.',
                'category_name.string'   => 'The category name must be valid text.',
                'category_name.max'      => 'The category name cannot exceed 255 characters.',
                'category_name.unique'   => 'This category name already exists.',
                'parent_id.exists'       => 'The selected parent category is invalid.',
            ]);

            // Find and update the category
            $category = Categories::findOrFail($id);
            $category->category_name = $validated['category_name'];
            $category->parent_category_id = $request->parent_id ?? null; // assign parent category if selected
            $category->save();

            return redirect()
                ->route('categories.index')
                ->with('success', 'Category updated successfully');
        } catch (\Exception $e) {
            \Log::error('Category update error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while updating the category. Please try again.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Categories::find($id);
        if ($category == null) {

            return redirect()->route('categories.index')->with('error','Category Not Found');
            
        }else {
            $category->delete();
            return redirect()->route('categories.index')->with('success','Category deleted successfully');

        }
    }

   public function getCategories(Request $request)
    {
        if ($request->ajax()) {
            $categories = Categories::select('categories.id', 'categories.category_name', 'parent_categories.name as parent_category_name')
                ->leftJoin('parent_categories', 'categories.parent_category_id', '=', 'parent_categories.id');

            return datatables()->of($categories)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="form-check-input user-checkbox" value="' . $row->id . '">';
                })
                ->addColumn('action', function ($row) {
                    return '<div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('categories.edit', $row->id) . '">
                                <i class="bx bx-edit-alt me-1"></i> Edit
                            </a>
                            <button type="button" class="dropdown-item delete-button" data-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="bx bx-trash me-1"></i> Delete
                            </button>
                        </div>
                    </div>';
                })
                ->rawColumns(['checkbox', 'action'])
                ->make(true);
        }
    }
    


    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids'); // Array of selected user IDs
        if (!empty($ids)) {
            Categories::whereIn('id', $ids)->delete();  // Delete users with the selected IDs
        }
        
        return response()->json(['success' => 'categories deleted successfully!']);
    }
}
