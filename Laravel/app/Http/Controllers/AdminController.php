<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // دالة لإنشاء مستخدم جديد
    public function createUser(Request $request)
    {
        // التحقق من البيانات المدخلة
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // إضافة حقول أخرى حسب الحاجة
        ]);

        // إنشاء المستخدم الجديد
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return response()->json($user, 201); // إرجاع المستخدم الجديد مع حالة 201
    }
    public function logout(Request $request)
    {
        Auth::logout(); // تسجيل الخروج
        $request->session()->invalidate(); // تعطيل الجلسة الحالية
        $request->session()->regenerateToken(); // تجديد التوكن

        return response()->json(['message' => 'تم تسجيل الخروج بنجاح']);
    }
}
