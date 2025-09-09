<?php

namespace App\Http\Controllers;
use Firebase\JWT\JWT;

use App\Models\WebUsers;
use Hash;
use Illuminate\Http\Request;
use Validator;

class WebUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    // ✅ Validate input
    $validator = Validator::make($request->all(), [
        'userName'     => 'required|string|min:3|max:255',
        'email'    => 'required|string|email|max:255|unique:web_users,email',
        'password' => 'required|string|min:5',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors'  => $validator->errors(),
        ], 422);
    }

    // ✅ Create user
    $user = WebUsers::create([
        'name'     => $request->userName,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // ✅ Generate JWT token
    $payload = [
        'id'    => $user->id,
        'email' => $user->email,
        'iat'   => time(),
        'exp'   => time() + 60 * 60 * 24, // expires in 1 day
    ];

    $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

    // ✅ Return response
    return response()->json([
        'success' => true,
        'message' => 'User created successfully',
        'user'    => [
            'id'       => $user->id,
            'userName' => $user->name, // match frontend naming
            'email'    => $user->email,
        ],
        'token' => $token,
    ], 201);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
