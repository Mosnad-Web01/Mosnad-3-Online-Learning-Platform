<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;


class AuthService
{
    public function register(array $data)
    {
        // التحقق من صحة البيانات
        validator($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:instructor,student,admin', // التحقق من الدور

        ])->validate();

        // إنشاء المستخدم
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'is_suspended' => 0, // تعيين حالة الإيقاف إلى 0 (غير موقوف)
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
        if ($user->is_suspended) {
            return response()->json([
                
                'message' => 'Your account is suspended. Reason: ' . $user->suspension_reason
            ], 403);
        }
        // إنشاء XSRF-TOKEN
        $xsrfToken = csrf_token();

        return [
            'user' => $user,
            'xsrf_token' => $xsrfToken,
        ];
    }


    // دالة لتسجيل الخروج
    public function logout(Request $request) // Ensure this matches the calling context
    {
        if ($request->isMethod('post')) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->with('message', 'Logged out successfully.');
        }

        abort(405); // Method Not Allowed
    }
    }
