<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthenticationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'signup']]);
    }

    public function signup (Request $request): JsonResponse
    {
        try {


            $data = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string|min:8'
            ]);

            $user = User::where('email', $data['email'])->first();

            if ($user) {
                return response()->json([
                    'message' => 'Email already exists'
                ], 400);
            }

            $hashed_password = Hash::make($data['password']);

            $new_user = new User([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $hashed_password,
            ]);
            $new_user->save();

            $token = auth()->login($new_user);

            return response()->json([
                'message' => 'Successfully hit the signup endpoint',
                'token' => $token
            ], 201);
        }
        catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'errors' => str($e)
            ], 500);
        }
    }

    public function login (Request $request) {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8'
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || Hash::check($user['password'], $data['password'])) {
            return response()->json([
                'message' => 'Invalid user or password'
            ], 400);
        }

        $token = auth()->login($user);

        return response()->json([
            'message' => 'Successfully hit the login endpoint',
            'token' => $token
        ]);
    }
}
