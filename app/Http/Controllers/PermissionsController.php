<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::orderBy('id','desc')->get();
        return view('permissions.index',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[ 
            'name' => 'required|unique:permissions|min:3'
        ]);

        if ($validator->passes()) {
           
            Permission::create(['name'=>$request->name]);
            return redirect()->route('permissions.index')->with('success','Permission Added successfully');
        }
        else {
            return redirect()->route('permissions.index')->withInput()->withErrors($validator);
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
    public function edit(string $id,Request $request)
    {
        $permissions = Permission::findOrFail($id);
        $showModal = $request->query('show_modal', false);
        return view('permissions.edit',['permission' => $permissions, 'showModal' => $showModal]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request);
        $id = $request->permission_id;
        $permissions = Permission::findOrFail($id);

        $validator = Validator::make($request->all(), [ 
            'name' => 'required|min:3|unique:permissions,name,' . $id,
        ]);        

        if ($validator->passes()) {
           
            $permissions->name = $request->name;
            $permissions->save();
            return redirect()->route('permissions.index')->with('success','Permission Updated successfully');
        }
        else {
            return redirect()->route('permissions.index')->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request) {
        
        $id = $request->id;
        $permission = Permission::find($id);
        if ($permission == null) {
           
            return redirect()->route('permissions.index')->with('error','Permission Not Found');
        }
        else {
            $permission->delete();
            return redirect()->route('permissions.index')->with('success','Permission Deleted Successfully');
        }
 
     }

     public function getData(Request $request) {
        if ($request->ajax()) {
            $permissions = Permission::select(['id', 'name'])->get();
    
            return datatables()->of($permissions)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#basicModalEdit-' . $row->id . '">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </a>
                                <button type="button" class="dropdown-item delete-permission" data-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="bx bx-trash me-1"></i> Delete
                                </button>
                            </div>
                        </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
        
        }
    }
    
}
