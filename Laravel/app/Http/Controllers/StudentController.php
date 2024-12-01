<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;



class StudentController extends Controller
{
    public function register(Request $request)
    {
        // تحقق من البيانات المدخلة
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:8',
        ]);

        // إنشاء طالب
        $student = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
           'password' => Hash::make($validated['password']),
            'role' => 'student', // تحديد الدور كطالب
        ]);

        return response()->json(['message' => 'Student registered successfully', 'student' => $student], 201);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $student = User::where('email', $validated['email'])->first();

        if (!$student) {
            return response()->json(['error' => 'Email not found'], 404);
        }

        if (!Hash::check($validated['password'], $student->password)) {
            return response()->json(['error' => 'Incorrect password'], 401);
        }

        // إذا كان الدخول صحيحًا
        $token = $student->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'student' => $student,
            'token' => $token,
        ]);
    }



    public function show($id)
    {
        $student = User::where('role', 'student')->find($id);

        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        return response()->json($student, 200);
    }

    public function update(Request $request, $id)
    {
        $student = User::where('role', 'student')->find($id);

        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        // التأكد من أن المستخدم الحالي لديه الصلاحيات
        if ($student->id !== Auth::id() && Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|max:100',
            'email' => 'sometimes|required|email|unique:users,email,' . $student->id,
            'password' => 'sometimes|required|min:8',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $student->update($validated);

        return response()->json(['message' => 'Student updated successfully', 'student' => $student], 200);
    }


    public function destroy($id)
    {
        $student = User::where('role', 'student')->find($id);

        // التأكد من أن المستخدم الحالي يملك الحساب
        if (!$student || $student->id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized or Student not found'], 403);
        }

        $student->delete();

        return response()->json(['message' => 'Student deleted successfully'], 200);
    }
    public function logout(Request $request)
    {
        // إذا كان المستخدم مسجل دخوله باستخدام التوكن
        $request->user()->tokens->each(function ($token) {
            $token->delete(); // حذف جميع التوكنات المرتبطة بالمستخدم
        });

        return response()->json(['message' => 'Logout successful'], 200);
    }

    public function getCurrentStudent(Request $request)
    {
        // الحصول على المستخدم المسجل حاليًا باستخدام التوكن
        $student = Auth::user();

        // التحقق من أن المستخدم مسجل دخول عبر التوكن
        if (!$student) {
            return response()->json(['error' => 'No user is logged in'], 401);
        }

        return response()->json($student, 200);
    }

}
