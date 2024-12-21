<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Enrollment;
use App\Models\CourseCategory;
use App\Models\LessonCompletion;
use Illuminate\Support\Facades\Auth;

class StudentCourseController extends Controller
{
    /**
     * عرض جميع الدورات التي سجل فيها الطالب.
     */
    public function index()
    {
        $userId = Auth::id();
        $enrollments = Enrollment::with('course.category') // جلب الدورات مع الفئات المرتبطة
            ->where('student_id', $userId)
            ->get();

        return view('student.courses.index', compact('enrollments'));
    }

    /**
     * عرض تفاصيل الدورة والدروس المرتبطة بها.
     */
    public function show($courseId)
    {
        $userId = Auth::id();
        // التحقق من تسجيل الطالب في الدورة
        $enrollment = Enrollment::where('student_id', $userId)
            ->where('course_id', $courseId)
            ->firstOrFail();

        // الحصول على الدورة والدروس المرتبطة بها
        $course = Course::with('lessons')->findOrFail($courseId);
        $lessons = $course->lessons;
        $completedLessons = LessonCompletion::where('enrollment_id', $enrollment->id)
            ->pluck('lesson_id')->toArray();

        return view('student.courses.show', compact('course', 'lessons', 'completedLessons'));
    }

    /**
     * عرض تقدم الطالب في الدورة.
     */
    public function showProgress($courseId)
    {
        $userId = Auth::id();
        // التحقق من تسجيل الطالب في الدورة
        $enrollment = Enrollment::where('student_id', $userId)
            ->where('course_id', $courseId)
            ->firstOrFail();

        return response()->json([
            'progress' => $enrollment->progress,
            'completion_date' => $enrollment->completion_date
        ]);
    }

    /**
     * إتمام درس من الدورة وتحديث التقدم.
     */
    public function completeLesson(Request $request, $courseId, $lessonId)
    {
        $userId = Auth::id();
        // التحقق من تسجيل الطالب في الدورة
        $enrollment = Enrollment::where('student_id', $userId)
            ->where('course_id', $courseId)
            ->firstOrFail();

        // التحقق إذا كان الطالب قد أكمل الدرس بالفعل
        $existingCompletion = LessonCompletion::where('enrollment_id', $enrollment->id)
            ->where('lesson_id', $lessonId)
            ->first();

        if (!$existingCompletion) {
            // إضافة إتمام الدرس إلى الجدول
            LessonCompletion::create([
                'enrollment_id' => $enrollment->id,
                'lesson_id' => $lessonId,
            ]);
        }

        // تحديث التقدم
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

    /**
     * تصفية الدورات حسب الفئة.
     */
    public function filterByCategory(Request $request)
    {
        $categoryId = $request->input('category_id');
        $userId = Auth::id();

        $courses = Course::whereHas('category', function($query) use ($categoryId) {
            $query->where('id', $categoryId);
        })
        ->whereHas('enrollments', function($query) use ($userId) {
            $query->where('student_id', $userId);
        })
        ->get();

        return view('student.courses.index', compact('courses'));
    }
}
