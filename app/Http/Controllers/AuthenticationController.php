<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class AuthenticationController extends Controller
{
    //
    public function index (): JsonResponse 
    {
        return response()->json([
            "message" => "this is auth-service authentication controller.",
            "success" => true
        ],200);
    }

    public function login (Request $request): JsonResponse 
    {
        try {
            $credentials = $request->only("username", "password");
            
            if (! $token = auth()->attempt($credentials)) {
                return response()->json([
                    "message" => "Login failed.",
                    "reason" => "Invalid username or password.",
                    "success" => false,
                ], 401);
            }

            return $this->respondWithToken($token, auth()->user());
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Login failed.",
                "reason" => $e->getMessage(),
                "success" => false,
            ], 500);
        }
    }

    public function refreshToken (Request $request): JsonResponse 
    {
        return response()->json([
            "message" => "this is auth-service authentication controller.",
            "success" => true
        ],200);
    }

    protected function respondWithToken(mixed $token, User $user): JsonResponse 
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $user
        ], 200);
    }
}
