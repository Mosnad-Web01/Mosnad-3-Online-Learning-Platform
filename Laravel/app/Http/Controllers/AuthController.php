<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// app/Http/Controllers/AuthController.php


use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // تسجيل مستخدم جديد
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        // تعيين دور للمستخدم بعد إنشائه
        $role = Role::where('name', 'student')->first(); // تعيين دور "student"
        $user->roles()->attach($role); // إضافة الدور للمستخدم
    
        // إنشاء التوكن
        $token = $user->createToken('auth_token')->plainTextToken;
    
        // إرجاع الاستجابة مع التوكن
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }
    
    // تسجيل الدخول
    public function login(Request $request)
{
    // التحقق من صحة البيانات المدخلة

    $request->validate([
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ]);

    // التحقق من بيانات المستخدم
    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $user = User::where('email', $request->email)->firstOrFail();

    // إنشاء التوكن
    $token = $user->createToken('auth_token')->plainTextToken;

    // تخزين التوكن في HttpOnly Cookie
    return response()->json([
        'message' => 'Login successful',
    ])->cookie('token', $token, 60*24, '/', '', false, true); // التوكن في cookie
}

    // تسجيل الخروج
    public function logout(Request $request)
    {
        // حذف التوكن من الـ cookies
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });
    
        // حذف التوكن من cookie
        return response()->json(['message' => 'Logged out successfully'])->cookie('token', '', -1); // حذف التوكن
    }
    
}
