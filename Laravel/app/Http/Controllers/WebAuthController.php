<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class WebAuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // عرض صفحة تسجيل المستخدم
    public function showRegister()
    {
        return view('auth.signup');
    }

    // معالجة تسجيل المستخدم
public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'role' => 'required|in:instructor,student,admin',
    ]);

    // إنشاء المستخدم
    $user = User::create([
        'name' => $request['name'],
        'email' => $request['email'],
        'password' => Hash::make($request['password']),
        'role' => $request['role'],
        'is_suspended' => 0,
    ]);

    // تسجيل الدخول للمستخدم
    Auth::login($user);
    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard')->with('success', 'Welcome to the admin dashboard!');
        case 'instructor':
            return redirect()->route('instructor.dashboard')->with('success', 'Welcome to the instructor dashboard!');
        case 'student':
            return redirect()->route('student.dashboard')->with('success', 'Welcome to the student dashboard!');
        default:
            return redirect('/')->with('success', 'User registered successfully.');
    }
    // إرجاع استجابة JSON مع رابط الإعادة
    return response()->json([
        'message' => 'User registered successfully.',
        'redirect_url' => route($user->role . '.dashboard'),
    ], 201);
}

    // عرض صفحة تسجيل الدخول
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // معالجة تسجيل الدخول
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $credentials['is_suspended'] = 0;

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
            ]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // معالجة تسجيل الخروج
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
