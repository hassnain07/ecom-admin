<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class UserController extends Controller{
    public function __construct()
    {
        $this->middleware('permission:View Users')->only('index');
        $this->middleware('permission:Edit Users')->only('edit');
        // $this->middleware('permission:Add Users')->only('create');
        $this->middleware('permission:Delete Users')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('id','desc')->get();
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::orderBy('id','desc')->get();
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


       $validator = Validator::make($request->all(),[ 
            'name' => 'required|min:3',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:5',
            'confirm_password' => 'required|min:5|same:password'
        ]);

       
        if ($validator->passes()) {

            // $role = Role::create(['name'=>$request->name]);
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();  
            if (!empty($request->roles)) {
                $user->syncRoles($request->roles);
            }else {
                $user->syncRoles([]);
            }

            return redirect()->route('users.index')->with('success','User Added successfully');
        }
        else {

         
            return redirect()->route('users.create')->withInput()->withErrors($validator);
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
        $user = User::findOrFail($id);
        $roles = Role::orderBy('id','desc')->get();
        $hasRoles = $user->roles->pluck('id');
        return view('users.edit',compact('user','roles','hasRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(),[ 
            'name' => 'required|min:2',
            'email' => 'required|unique:users,email,"'.$id.'"|min:3'
        ]);

        if ($validator->passes()) {

            // $role = Role::create(['name'=>$request->name]);
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password != null) {
                $user->password = $request->password;
            }
            $user->save();  
            if (!empty($request->roles)) {
                $user->syncRoles($request->roles);
            }else {
                $user->syncRoles([]);
            }


            return redirect()->route('users.index')->with('success','User Updated successfully');
        }
        else {
            return redirect()->route('users.edit')->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if ($user == null) {

            return redirect()->route('users.index')->with('error','User Not Found');
            
        }else {
            $user->delete();
            return redirect()->route('users.index')->with('success','User deleted successfully');

        }
    }

    public function getUsersData(Request $request)
{
    if ($request->ajax()) {
        $users = User::with('roles')->select(['id', 'name', 'email']); // Adjust as per your database

            return datatables()->of($users)
        ->addIndexColumn() // Adds automatic row numbering
        ->addColumn('roles', function ($row) {
            return $row->roles->map(function ($role) {
                return '<span class="badge bg-label-primary">' . $role->name . '</span>';
            })->implode(' ');  // Join the badges with a space in between
        })
        ->addColumn('action', function ($row) {

            if (auth()->user()->can('Edit Users') && auth()->user()->can('Delete Users') ) {
                return '<div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="'.route('users.edit', $row->id).'">
                        <i class="bx bx-edit-alt me-1"></i> Edit
                    </a>
                    <button type="button" class="dropdown-item delete-button" data-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bx bx-trash me-1"></i> Delete
                    </button>
                </div>
            </div>';
            }
            
        }
        )
        ->rawColumns(['roles','action']) // Make the action column raw HTML
        ->make(true);

        }
}


    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids'); // Array of selected user IDs
        if (!empty($ids)) {
            User::whereIn('id', $ids)->delete();  // Delete users with the selected IDs
        }
        
        return response()->json(['success' => 'Users deleted successfully!']);
    }

}
