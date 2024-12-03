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
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['student', 'instructor', 'admin'])],
            'full_name' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bio' => 'nullable|string',
        ]);

        // إنشاء المستخدم
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // إذا تم إرسال بيانات الصورة، قم بتحميلها
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture');

            // تحقق من نوع الصورة فعلاً
            if (!in_array($profilePicture->getClientMimeType(), ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml'])) {
                return back()->withErrors(['profile_picture' => 'The profile picture must be a valid image file.']);
            }

            // تخزين الصورة
            $profilePicturePath = $profilePicture->storeAs('uploads', time() . '.' . $profilePicture->getClientOriginalExtension(), 'public');
        }

        // إنشاء ملف التعريف
        $user->profile()->create([
            'full_name' => $request->full_name,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'profile_picture' => $profilePicturePath,
            'bio' => $request->bio,
        ]);

        return redirect()->route('login')->with('success', 'Account created successfully!');
    }
}
