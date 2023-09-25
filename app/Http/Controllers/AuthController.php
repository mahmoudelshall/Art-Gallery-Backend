<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AdminLoginRequest;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function UserRegister(UserRegisterRequest $request)
    {
        $user = $request->userRegister();

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'data' => $user,
        ], 201);
    }

    public function UserLogin(UserLoginRequest $request)
    {
        $auth = $request->UserLogin();

        return response()->json([
            'success' => true,
            'message' => 'User logged in successfully',
            'data' => $auth,
        ], 200);
        
        
    }
    public function AdminLogin(AdminLoginRequest $request)
    {
        $auth = $request->AdminLogin();

        return $auth;
        // return response()->json([
        //     'success' => true,
        //     'message' => 'User logged in successfully',
        //     'data' => $auth,
        // ], 200);
        
    }
    // user->tokens()->delete(); 
    public function logout(Request $request)
    {
    //    // Auth::logout();
    //    $request->user()->currentAccessToken()->delete();
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'User logout successfully',
    //     ], 200);
     //return $request->Authorization;
    //  $token = $request->user()->token();
    //  //return $token;
    //  $token->revoke();
    //  $response = ['message' => 'You have been successfully logged out!'];
    //  return response($response, 200);

    // $user = $request->user();

    // if ($user !== null) {
    // $user->currentAccessToken()->delete();; 
    $request->user()->currentAccessToken()->delete();
        return response([
            'message' => 'You have been successfully logged out.',
        ], 200);
    }
    
}
