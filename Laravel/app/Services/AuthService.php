<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function register(array $data)
    {
        // التحقق من صحة البيانات
        validator($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ])->validate();

        // إنشاء المستخدم
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // تعيين الدور الافتراضي
        $role = Role::where('name', 'student')->first();
        $user->roles()->attach($role);

        return $user;
    }

    public function login(array $credentials)
    {
        // التحقق من صحة البيانات
        validator($credentials, [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ])->validate();

        // محاولة تسجيل الدخول
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages(['email' => 'Invalid credentials.']);
        }

        $user = Auth::user();

        // إنشاء XSRF-TOKEN
        $xsrfToken = csrf_token();

        return [
            'user' => $user,
            'xsrf_token' => $xsrfToken,
        ];
    }

    public function logout()
    {
        Auth::logout();

        return [
            'message' => 'Logged out successfully.',
        ];
    }
}
