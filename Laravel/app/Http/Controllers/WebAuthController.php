<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    // معالج تسجيل الدخول
    public function login(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // جلب المستخدم الحالي

            // تأكد من أن المستخدم يحتوي على علاقة الأدوار
            if ($user->roles->isNotEmpty()) {
                $role = $user->roles->first()->name;  // استخراج أول دور للمستخدم
            } else {
                // في حال لم يكن للمستخدم أي دور
                $role = 'guest'; // أو يمكنك تخصيص هذا حسب احتياجك
            }

            // إرسال الاستجابة مع الدور
            return response()->json([
                'message' => 'Login successful',
                'role' => $role,  // إضافة الدور
                'user' => $user   // إضافة معلومات المستخدم (اختياري)
            ]);
        } else {
            // في حال فشل تسجيل الدخول
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    // معالج تسجيل الخروج
    public function logout()
    {
        $this->authService->logout();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
