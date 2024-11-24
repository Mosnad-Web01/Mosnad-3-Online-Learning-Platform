<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SignupController extends Controller
{
    // دالة لعرض نموذج التسجيل
    public function create()
    {
        return view('auth.signup');
    }

    // دالة لتخزين البيانات في قاعدة البيانات
    public function store(Request $request)
    {
        // تحقق من صحة المدخلات
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',  // تأكد من استخدام confirmed هنا
            'role' => ['required', Rule::in(['student', 'instructor', 'admin'])],
        ]);

        // إنشاء المستخدم
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,  // تعيين الدور
        ]);

        return redirect()->route('login')->with('success', 'Account created successfully!');
    }
}
