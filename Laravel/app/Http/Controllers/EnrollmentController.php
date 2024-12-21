<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\CourseUser;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonCompletion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class EnrollmentController extends Controller
{
    /**
     * التحقق إذا كان الطالب مسجلاً في دورة.
     */
    private function isStudentEnrolled($userId, $courseId)
    {
        return Enrollment::where('student_id', $userId)
            ->where('course_id', $courseId)
            ->exists();
    }

    /**
     * تسجيل الطالب في دورة.
     */
    public function enroll(Request $request, $courseId)
    {
        $userId = Auth::id();

        // التحقق من وجود الدورة
        $course = Course::findOrFail($courseId);

        // التحقق إذا كان الطالب مسجلاً بالفعل
        if ($this->isStudentEnrolled($userId, $courseId)) {
            return response()->json(['message' => 'Already enrolled in this course'], 400);
        }

        // التحقق من حالة الدفع إذا كانت الدورة مدفوعة
        if (!$course->is_free) {
            // التحقق من حالة الدفع إذا لم تكن الدورة مجانية
            $paymentStatus = CourseUser::where('user_id', $userId)
                ->where('course_id', $courseId)
                ->value('payment_status');

            if ($paymentStatus !== 'paid') {
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

        // التحقق من تسجيل الطالب في الدورة
        $enrollment = Enrollment::where('student_id', $userId)
            ->where('course_id', $courseId)
            ->firstOrFail();

        // التحقق من صحة نسبة التقدم
        $progress = $request->input('progress');
        if (!is_numeric($progress) || $progress < 0 || $progress > 100) {
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

    /**
     * الحصول على جميع تسجيلات الطالب.
     */
    public function getStudentEnrollments()
    {
        $userId = Auth::id();
        $enrollments = Enrollment::with('course')->where('student_id', $userId)->get();

        return response()->json(['enrollments' => $enrollments], 200);
    }

    /**
     * الحصول على تسجيل معين.
     */
    public function getEnrollment($courseId)
    {
        $userId = Auth::id();

        // التحقق من تسجيل الطالب في الدورة
        $enrollment = Enrollment::with('course')
            ->where('student_id', $userId)
            ->where('course_id', $courseId)
            ->firstOrFail();

        return response()->json(['enrollment' => $enrollment], 200);
    }
    public function handleEnrollment($courseId)
    {
        $userId = 7; // تعيين معرف الطالب إلى 7 للتجربة

        // التحقق من وجود الدورة
        $course = Course::findOrFail($courseId);

        // التحقق إذا كان الطالب مسجلاً بالفعل
        if ($this->isStudentEnrolled($userId, $courseId)) {
            return redirect()->route('course.lessons', ['courseId' => $courseId]);
        }

        // إذا لم يكن مسجلاً، تحقق من سعر الدورة
        if ($course->price == 0) {
            // تسجيل الطالب تلقائياً إذا كانت الدورة مجانية
            Enrollment::create([
                'student_id' => $userId,
                'course_id' => $courseId,
            ]);

            return redirect()->route('course.lessons', ['courseId' => $courseId]);
        }

        // إذا كانت الدورة مدفوعة
        return redirect()->route('payment.page', ['courseId' => $courseId]);
    }

    public function completeLesson(Request $request, $courseId, $lessonId)
    {
        $userId = Auth::id();

        // تسجيل العملية في السجل
        Log::info('Updating progress for lesson ID: ' . $lessonId);

        // التحقق من تسجيل الطالب في الدورة
        $enrollment = Enrollment::where('student_id', $userId)
            ->where('course_id', $courseId)
            ->firstOrFail();

        // التحقق إذا كان الطالب قد أكمل الدرس بالفعل
        $existingCompletion = LessonCompletion::where('enrollment_id', $enrollment->id)
            ->where('lesson_id', $lessonId)
            ->first();

        if (!$existingCompletion) {
            // إذا لم يكن قد أكمل الدرس من قبل، نقوم بإضافته إلى الجدول
            LessonCompletion::create([
                'enrollment_id' => $enrollment->id,
                'lesson_id' => $lessonId,
            ]);
        }

        // تحديث تقدم الطالب
        $completedLessonsCount = LessonCompletion::where('enrollment_id', $enrollment->id)->count();
        $totalLessonsCount = Lesson::where('course_id', $courseId)->count();

        $progress = ($completedLessonsCount / $totalLessonsCount) * 100;
        $enrollment->progress = $progress;

        // إذا اكتملت الدورة، تسجيل تاريخ الإتمام
        if ($progress == 100 && !$enrollment->completion_date) {
            $enrollment->completion_date = now();
        }

        $enrollment->save();

        // إرجاع التقدم الحالي
        return response()->json(['message' => 'Lesson completed and progress updated', 'progress' => $progress], 200);
    }





}
