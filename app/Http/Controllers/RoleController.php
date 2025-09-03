<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('permission:View Roles')->only('index');
        $this->middleware('permission:Edit Roles')->only('edit');
        $this->middleware('permission:Add Roles')->only('create');
        $this->middleware('permission:Delete Roles')->only('destroy');
    }




    public function index() {
        
      
      $roles = Role::orderBy('id','desc')->get(); 
      $permissions = Permission::orderBy('id','desc')->get();
      return view('roles.index',compact('roles','permissions'));

    }
    public function create() {
        if (!auth()->user()->can('Add Roles')) {
            return redirect()->route('roles.index')->with('error', 'Permission Denied');
        }
      $permission = Permission::orderBy('name','desc')->get();
      return view('roles/create',['permissions' => $permission]);

    }
    public function store(Request $request) {
        if (!auth()->user()->can('Add Roles')) {
            return redirect()->route('roles.index')->with('error', 'Permission Denied');
        }
        $validator = Validator::make($request->all(),[ 
            'name' => 'required|unique:roles'
        ]);

        if ($validator->passes()) {

            $role = Role::create(['name'=>$request->name]);
            if (!empty($request->permissions)) {
                foreach ($request->permissions as  $permission) {
                   $role->givePermissionTo($permission);
              }
            }


            return redirect()->route('roles.index')->with('success','Role Added successfully');
        }
        else {
            return redirect()->route('roles.index')->withErrors($validator)->withInput();
        }
    }
    public function edit($id) {
        if (!auth()->user()->can('Edit Roles')) {
            return redirect()->route('roles.index')->with('error', 'Permission Denied');
        }
        $editRole = Role::findOrFail($id);
        $hasPermissions = $editRole->permissions->pluck('name');
        $permissions = Permission::all();
    
        return view('roles.edit', [
            'editRole' => $editRole,
            'hasPermission' => $hasPermissions,
            'permissions' => $permissions
        ]);
    }
    
    public function update(Request $request, $id) {
        $role = Role::findOrFail($id);
    
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $id
        ]);
    
        if ($validator->passes()) {
            // Update role name
            $role->name = $request->name;
    
            // Sync permissions
            if (!empty($request->permissions)) {
                $role->syncPermissions($request->permissions);
            } else {
                $role->syncPermissions([]); // Remove all permissions if none selected
            }
    
            // Save changes
            $role->save();
    
            // Redirect to the roles index with success message
            return redirect()->route('roles.index')->with('success', 'Role updated successfully');
        } else {
            // Redirect back to the edit form with errors and input data
            return redirect()->route('roles.index')->with('error', $validator);
        }
    }
    
    public function destroy(Request $request) {
        if (!auth()->user()->can('Delete Roles')) {
            return redirect()->route('roles.index')->with('error', 'Permission Denied');
        }

        $id = $request->id;
        $role = Role::find($id);
       
        if ($role == null) {
         
            return redirect()->route('roles.index')->with('error', 'Role Not found');
            
         }
  
         $role->delete();
         return redirect()->route('roles.index')->with('success', 'Role deleted successfully');

    }



    public function getData(Request $request) {
        if ($request->ajax()) {
            $roles = Role::with('permissions')->select(['id', 'name'])->get();
    
            return datatables()->of($roles)
            ->addColumn('permissions', function ($row) {
                return $row->permissions->map(function ($permission) {
                    return '<span class="badge bg-label-success my-1">' . $permission->name . '</span>';
                })->implode(' ');
            })
            ->addColumn('action', function ($row) {
                if (auth()->user()->can('Edit Roles') && auth()->user()->can('Delete Roles')) {
                    return '<div class="dropdown">
                            
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item edit-role" href="#" 
                           data-id="' . $row->id . '" 
                           data-bs-toggle="modal" 
                           data-bs-target="#editModal">
                           <i class="bx bx-edit-alt me-1"></i> Edit
                        </a>
                        <button type="button" class="dropdown-item delete-role" data-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bx bx-trash me-1"></i> Delete
                        </button>
                    </div>
                </div>';
                }
                
            }
            )
            ->rawColumns(['permissions', 'action'])
            ->make(true);
        
        
        }
    }

    public function bulkDelete(Request $request)
{
    $ids = $request->input('ids'); // Array of selected role IDs
    if (!empty($ids)) {
        Role::whereIn('id', $ids)->delete();  // Delete roles with the selected IDs
    }
    
    return response()->json(['success' => 'Roles deleted successfully!']);
}

}


