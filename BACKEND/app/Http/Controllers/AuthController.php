<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Trait\ApiTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiTrait;

    public function login(Request $request) {
        $data = $this->validateRequest($request, [
            'username' => 'required|exists:users,username',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data))
        {
            return response()->json([
                'message' => 'Wrong password'
            ], 401);
        }

        $user = auth()->user();
        $token = $user->createToken('accessToken')->plainTextToken;
        return response()->json([
            'message' => "Login success",
            'token' => $token,
            'user' => $user
        ], 200);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logout success'
        ], 200);
    }

    public function register(Request $request)
    {
        $data = $this->validateRequest($request, [
            'full_name' => 'required',
            'username' => 'required|unique:users,username|min:3|alpha_dash',
            'password' => 'required|min:6',
            'bio' => 'required|max:100',
            'is_private' => 'boolean'
        ]);

        $data['password'] = Hash::make($data['password']);
        
        $user = User::create($data);
        
        $token = $user->createToken('accessToken')->plainTextToken;
        return response()->json([
            'message' => "Register success",
            'token' => $token,
            'user' => $user
        ], 200);
    }
}
