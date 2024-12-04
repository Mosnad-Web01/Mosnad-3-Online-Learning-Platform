<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\CourseUser;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    /**
     * تسجيل الطالب في دورة.
     */
    public function enroll(Request $request, $courseId)
    {
        $userId = Auth::id();

        // التحقق من الدورة
        $course = Course::findOrFail($courseId);

        // التحقق إذا كان الطالب مسجلاً بالفعل
        $existingEnrollment = Enrollment::where('student_id', $userId)
            ->where('course_id', $courseId)
            ->first();

        if ($existingEnrollment) {
            return response()->json(['message' => 'Already enrolled in this course'], 400);
        }

        // التحقق من حالة الدفع إذا كانت الدورة مدفوعة
        if ($course->is_free) {
            $paymentStatus = CourseUser::where('user_id', $userId)
                ->where('course_id', $courseId)
                ->value('payment_status');

            if ($paymentStatus !== 'free') {
                return response()->json(['message' => 'Payment required for this course'], 403);
            }
        }

        // تسجيل الطالب
        $enrollment = Enrollment::create([
            'student_id' => $userId,
            'course_id' => $courseId,
        ]);

        return response()->json(['message' => 'Enrollment successful', 'enrollment' => $enrollment], 200);
    }

    /**
     * تحديث تقدم الطالب في الدورة.
     */
    public function updateProgress(Request $request, $courseId)
    {
        $userId = Auth::id();

        // جلب التسجيل
        $enrollment = Enrollment::where('student_id', $userId)
            ->where('course_id', $courseId)
            ->firstOrFail();

        // تحديث نسبة التقدم
        $progress = $request->input('progress');

        if ($progress < 0 || $progress > 100) {
            return response()->json(['message' => 'Invalid progress value'], 400);
        }

        $enrollment->progress = $progress;

        // إذا اكتملت الدورة، تسجيل تاريخ الإتمام
        if ($progress == 100 && !$enrollment->completion_date) {
            $enrollment->completion_date = now();
        }

        $enrollment->save();

        return response()->json(['message' => 'Progress updated successfully', 'enrollment' => $enrollment], 200);
    }
}
