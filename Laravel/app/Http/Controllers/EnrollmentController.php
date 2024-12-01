<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function index()
    {
        // عرض جميع التسجيلات مع العلاقات
        return Enrollment::with(['course', 'student', 'completions'])->get();
    }

    public function store(Request $request)
    {
        // تحقق من أن الطالب الذي يحاول التسجيل هو نفسه الطالب المسجل دخولًا
        $student = Auth::user();  // الحصول على الطالب من التوكن
        if (!$student) {
            return response()->json(['error' => 'Unauthorized'], 403);  // الطالب غير مصرح له
        }

        // تحقق من صحة البيانات المدخلة
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'student_id' => 'required|exists:users,id|unique:enrollments,student_id,NULL,id,course_id,' . $request->course_id,
        ]);

        // التأكد من أن الطالب الذي يحاول التسجيل هو نفسه الذي يتم استخدامه في التوكن
        if ($student->id !== $validated['student_id']) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // إنشاء تسجيل جديد
        $enrollment = Enrollment::create($validated);

        return response()->json(['message' => 'Enrollment created successfully', 'enrollment' => $enrollment], 201);
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $student = Auth::user();
        if (!$student) {
            return response()->json(['error' => 'Unauthorized'], 403);  // الطالب غير مصرح له
        }

        // التحقق من أن الطالب هو نفسه الطالب المرتبط بهذا التسجيل
        if ($student->id !== $enrollment->student_id && $student->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // تحقق من صحة البيانات المدخلة
        $validated = $request->validate([
            'progress' => 'nullable|integer|min:0|max:100',
            'completion_date' => 'nullable|date',
        ]);

        // تحديث بيانات التسجيل
        $enrollment->update($validated);

        return response()->json(['message' => 'Enrollment updated successfully', 'enrollment' => $enrollment], 200);
    }


    public function destroy(Enrollment $enrollment)
    {
        // حذف التسجيل
        $enrollment->delete();

        return response()->json(['message' => 'Enrollment deleted successfully'], 200);
    }

    public function checkEnrollment(Request $request, $courseId)
    {
        // التحقق من صحة الطلب
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
        ]);

        $studentId = $validated['student_id'];

        // التحقق من وجود تسجيل
        $isEnrolled = Enrollment::where('course_id', $courseId)
            ->where('student_id', $studentId)
            ->exists();

        return response()->json(['isEnrolled' => $isEnrolled], 200);
    }
}
