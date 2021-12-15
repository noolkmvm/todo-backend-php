<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $ttl = request(['remember_me']) == true ? env('JWT_REMEMBER_TTL') : config('jwt.ttl');

        if (!$token = Auth::setTTL($ttl)->attempt($request->all())) {
            return $this->respondUnAuthenticated();
        }

        return $this->respondWithToken($token);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $request['password'] = Hash::make($request['password']);
        User::create($request->all());

        return $this->respondWithSuccess(['message' => 'User successfully registered']);
    }

    public function user(): JsonResponse
    {
        return $this->respondWithSuccess(Auth::user());
    }

    public function logout(): JsonResponse
    {
        Auth::logout();

        return $this->respondWithSuccess(['message' => 'Successfully logged out']);
    }

    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(Auth::refresh());
    }

    protected function respondWithToken(string $token): JsonResponse
    {
        return $this->respondWithSuccess([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory('api')->getTTL() * 60,
        ]);
    }
}
