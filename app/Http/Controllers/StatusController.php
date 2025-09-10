<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Models\Categories;
use App\Models\statuses;
use Illuminate\Http\Request;

class StatusController extends Controller
{
        public function index()
    {
        return view('status.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('status.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:statuses,name',
            ], [
                'name.required' => 'The status name is required.',
                'name.string' => 'The status name must be a valid text.',
                'name.max' => 'The status name cannot exceed 255 characters.',
                'name.unique' => 'This status name already exists.',
            ]);

            // Save category
            $status = new statuses();
            $status->name = $validated['name'];
            $status->label = $request->label;
            $status->save();

            return redirect()
                ->route('status.index')
                ->with('success', 'Status added successfully');
        } catch (\Exception $e) {
            // Log the actual error for debugging
            \Log::error('Status store error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while saving the status. Please try again.');
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
        $status = statuses::findOrFail($id);
        return view('status.edit',compact('status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ], [
                'name.required' => 'The status name is required.',
                'name.string' => 'The status name must be a valid text.',
                'name.max' => 'The status name cannot exceed 255 characters.',
                'name.unique' => 'This status name already exists.',
            ]);

            // Find and update status
            $status = statuses::findOrFail($id);
            $status->name = $validated['name'];
            $status->label = $request->label;
            $status->save();

            return redirect()
                ->route('status.index')
                ->with('success', 'Status updated successfully');
        } catch (\Exception $e) {
            \Log::error('Status update error', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString(),
            ]);

            // For debugging (only in local environment)
            if (app()->environment('local')) {
                dd($e); // dumps full exception on screen
            }

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while updating the status. Please try again.');
        }

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $status = statuses::find($id);
        if ($status == null) {

            return redirect()->route('status.index')->with('error','Status Not Found');
            
        }else {
            $status->delete();
            return redirect()->route('status.index')->with('success','Status deleted successfully');

        }
    }

    public function getStatuses(Request $request)
    {
        if ($request->ajax()) {
            $status = statuses::select(['id','name','label']);
    
            return datatables()->of($status)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('status.edit', $row->id) . '">
                                <i class="bx bx-edit-alt me-1"></i> Edit
                            </a>
                            <button type="button" class="dropdown-item delete-button" data-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="bx bx-trash me-1"></i> Delete
                            </button>
                        </div>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    


    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids'); // Array of selected user IDs
        if (!empty($ids)) {
            statuses::whereIn('id', $ids)->delete();  // Delete users with the selected IDs
        }
        
        return response()->json(['success' => 'Status deleted successfully!']);
    }
}
