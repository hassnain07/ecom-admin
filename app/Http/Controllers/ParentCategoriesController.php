<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Models\Categories;
use App\Models\ParentCategories;
use Illuminate\Http\Request;

class ParentCategoriesController extends Controller
{
     public function __construct()
    {
        $this->middleware('permission:Add Parent Category')->only('create');
        $this->middleware('permission:Edit Parent Category')->only('edit');
        $this->middleware('permission:View Parent Category')->only('index');
        $this->middleware('permission:Delete Parent Category')->only('destroy');
    }
    public function index()
    {
        return view('parentCategories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('parentCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:categories,category_name',
            ], [
                'name.required' => 'The category name is required.',
                'name.string' => 'The category name must be a valid text.',
                'name.max' => 'The category name cannot exceed 255 characters.',
                'name.unique' => 'This category name already exists.',
            ]);

            // Save category
            $category = new ParentCategories();
            $category->name = $validated['name'];
            $category->save();

            return redirect()
                ->route('parentCategories.index')
                ->with('success', 'Category added successfully');
        } catch (\Exception $e) {
            // Log the actual error for debugging
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
        $category = ParentCategories::findOrFail($id);
        return view('parentCategories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:parent_categories,name,' . $id,
            ], [
                'name.required' => 'The category name is required.',
                'name.string'   => 'The category name must be a valid text.',
                'name.max'      => 'The category name cannot exceed 255 characters.',
                'name.unique'   => 'This category name already exists.',
            ]);

            // Find and update category
            $category = ParentCategories::findOrFail($id);
            $category->name = $validated['name'];
            $category->save();

            return redirect()
                ->route('parentCategories.index')
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
        $category = ParentCategories::find($id);
        if ($category == null) {

            return redirect()->route('parentCategories.index')->with('error','Category Not Found');
            
        }else {
            $category->delete();
            return redirect()->route('parentCategories.index')->with('success','Category deleted successfully');

        }
    }

   public function getCategories(Request $request)
    {
        if ($request->ajax()) {
            $parentCategories = ParentCategories::select(['id', 'name'])
                ->orderBy('id', 'desc');

            return datatables()->of($parentCategories)
                ->addIndexColumn() // Sr No
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="form-check-input user-checkbox" value="' . $row->id . '">';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="' . route('parentCategories.edit', $row->id) . '">
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
            ParentCategories::whereIn('id', $ids)->delete();  // Delete users with the selected IDs
        }
        
        return response()->json(['success' => 'categories deleted successfully!']);
    }
}
