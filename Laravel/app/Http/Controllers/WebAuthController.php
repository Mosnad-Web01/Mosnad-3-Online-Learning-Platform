<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;

class WebAuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return view('auth.login'); // عرض صفحة تسجيل الدخول
    }

    public function login(Request $request)
    {
        $data = $this->authService->login($request->only('email', 'password'));

        return redirect()->route('dashboard') // تحويل المستخدم إلى لوحة التحكم بعد تسجيل الدخول
            ->with('success', 'Login successful.');
    }

    public function logout()
    {
        $this->authService->logout();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class LoginController extends Controller
// {
//     // عرض صفحة تسجيل الدخول
//     public function create()
//     {
//         return view('auth.login'); // تأكد من وجود ملف العرض المناسب
//     }

//     // معالجة تسجيل الدخول
//    // app/Http/Controllers/LoginController.php
//    public function login(Request $request)
//    {
//        // تحقق من صحة المدخلات
//        $credentials = $request->validate([
//            'email' => 'required|email',
//            'password' => 'required',
//        ]);

//        // محاولة تسجيل الدخول
//        if (Auth::attempt($credentials)) {
//            $request->session()->regenerate();

//            // استرجاع المستخدم بعد تسجيل الدخول
//            $user = Auth::user();

//            // تحقق من وجود الدور
//            if ($user && $user->role) {
//                if ($user->role === 'admin') {
//                    return redirect()->route('admin.dashboard');
//                } elseif ($user->role === 'instructor') {
//                    return redirect()->route('instructor.dashboard');
//                } else {
//                    return redirect()->route('home');
//                }
//            } else {
//                // في حال لم يكن هناك دور للمستخدم
//                return redirect()->route('home');
//            }
//        }

//        // إعادة توجيه إذا كانت بيانات الدخول خاطئة
//        return back()->withErrors([
//            'email' => 'The provided credentials do not match our records.',
//        ]);
//    }


// }

