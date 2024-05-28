<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
/*
|   Create register function to accept the request from register route to the UserController to register
|   The user but first check if the provided data is valid to register the user.
*/
    public function register(Request $request) {
        $user = $request->user;
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);
    }

/*
|   create login function to accept the request from login route to the UserController to login the user
|   and also check if the user already exist in database or not, after that perform the function
|   accordingly to the request.
*/
    public function login(Request $request) {
        $token = $request->token;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer-Token',
        ], 201);
    }

/*
|   logout function to logout the User from the Application so that after the logout the user can't perform
|   any action in our application
*/
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
           'message' => 'User logged out successfully',
        ], 201);
    }
}
