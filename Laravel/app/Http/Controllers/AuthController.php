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

    // Registration function
    public function register(Request $request)
    {
        $user = $this->authService->register($request->all());

        return response()->json([
            'message' => 'User registered successfully.',
            'user' => $user,
        ], 201);
    }

    // Login function
    public function login(Request $request)
    {
        try {
            // Attempt to log the user in
            $data = $this->authService->login($request->only('email', 'password'));

            // Return a successful login response with the user data and XSRF-TOKEN
            return response()->json([
                'message' => 'Login successful.',
                'user' => $data['user'],
            ])->cookie('XSRF-TOKEN', $data['xsrf_token'], 60 * 24, '/', null, false, false);

        } catch (\Exception $e) {
            // Handle exceptions (e.g., blocked users) and return a 403 Forbidden response
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    // Logout function
    public function logout()
    {
        // Call the AuthService to handle logout
        $message = $this->authService->logout();

        // Clear the XSRF-TOKEN cookie after logout
        return response()->json($message)->cookie('XSRF-TOKEN', '', -1);
    }
}
