<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

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
    
            // Return a successful login response with the user data and cookies
            return response()->json([
                'message' => 'Login successful.',
                'user' => $data['user'],
            ])
            ->cookie('XSRF-TOKEN', $data['xsrf_token'], 60 * 24, '/', null, false, false)
            ->cookie('user', json_encode([
                'name' => $data['user']['name'],
                'email' => $data['user']['email'],
            ]), 60);
    
        } catch (\Exception $e) {
            // Handle exceptions (e.g., blocked users) and return a 403 Forbidden response
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }
    
    // Logout function
    public function logout(Request $request)
    {
        try {
            // تسجيل الخروج
            Auth::logout();
            
            // حذف الجلسة من قاعدة البيانات
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            // إعادة استجابة النجاح
            return response()->json(['message' => 'Logged out successfully'], 200)
                ->withCookie(cookie()->forget('XSRF-TOKEN'))
                ->withCookie(cookie()->forget('laravel_session'));
        } catch (\Exception $e) {
            // تسجيل الأخطاء
            \Log::error($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

}
