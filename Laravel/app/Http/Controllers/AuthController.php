<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $user = $this->authService->register($request->all());

        return response()->json([
            'message' => 'User registered successfully.',
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $data = $this->authService->login($request->only('email', 'password'));

        return response()->json([
            'message' => 'Login successful.',
            'user' => $data['user'],
        ])->cookie('XSRF-TOKEN', $data['xsrf_token'], 60 * 24, '/', null, false, false);
    }

    public function logout()
    {
        $message = $this->authService->logout();

        return response()->json($message)->cookie('XSRF-TOKEN', '', -1);
    }
}
