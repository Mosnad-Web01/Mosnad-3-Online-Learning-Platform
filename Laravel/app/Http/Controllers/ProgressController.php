<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LessonProgress;
use App\Models\Enrollment;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ProgressController extends Controller
{
    /**
     * عرض تقدم الطالب مع الصفحات المحددة.
     *
     * @param int $enrollmentId
     * @param string|null $startDate
     * @param string|null $endDate
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStudentProgress($enrollmentId, $startDate = null, $endDate = null)
    {
        // استعلام لاسترجاع الدروس المكتملة بناءً على التسجيل والتواريخ (إذا كانت موجودة)
        $query = LessonProgress::where('enrollment_id', $enrollmentId);
        
        // إذا تم تحديد تاريخ البداية والنهاية
        if ($startDate && $endDate) {
            $query->whereBetween('completed_at', [$startDate, $endDate]);
        }
        // إذا لم يتم تحديد تواريخ، استخدم الشهر الحالي
        else {
            $query->whereMonth('completed_at', now()->month)
                  ->whereYear('completed_at', now()->year);
        }

        // إضافة التحديد لاختيار الحقول الضرورية فقط
        $query->select('lesson_id', 'progress', 'completed_at', 'enrollment_id');
        
        // إضافة التصفية عبر الصفحات (pagination)
        $completedLessons = $query->paginate(10);  // يمكنك تحديد العدد حسب رغبتك (هنا 10 دروس لكل صفحة)

        // حساب إجمالي مدة الدروس المكتملة
        $totalDurationInSeconds = $completedLessons->sum(function ($lesson) {
            return strtotime($lesson->completed_at) - strtotime($lesson->created_at);
        });

        // تحويل المدة من ثواني إلى دقائق
        $totalDurationInMinutes = round($totalDurationInSeconds / 60);

        // العودة بالتفاصيل
        return response()->json([
            'total_lessons_completed' => $completedLessons->count(),
            'total_duration_in_minutes' => $totalDurationInMinutes,
            'progress_percentage' => $this->calculateProgressPercentage($enrollmentId),
            'lessons' => $completedLessons, // العودة بالصفحات مع الدروس المكتملة
        ]);
    }

    /**
     * حساب نسبة التقدم بناءً على الدروس المكتملة.
     *
     * @param int $enrollmentId
     * @return float
     */
    public function calculateProgressPercentage($enrollmentId)
    {
        // حساب عدد الدروس المكتملة
        $completedLessonsCount = LessonProgress::where('enrollment_id', $enrollmentId)
            ->whereNotNull('completed_at') // تحقق من أن الحقل `completed_at` غير فارغ
            ->count();

        // العثور على الدورة التي ينتمي إليها الطالب
        $enrollment = Enrollment::find($enrollmentId);
        $totalLessons = Lesson::where('course_id', $enrollment->course_id)->count();

        // حساب التقدم بالنسبة المئوية
        return $totalLessons > 0 ? round(($completedLessonsCount / $totalLessons) * 100, 2) : 0;
    }

    /**
     * حساب التقدم للطالب بناءً على معرف التسجيل (enrollment_id).
     *
     * @param int $enrollmentId
     * @return float
     */
    public function calculateProgress($enrollmentId)
    {
        // حساب عدد الدروس المكتملة
        $completedLessons = LessonProgress::where('enrollment_id', $enrollmentId)
            ->whereNotNull('completed_at') // تحقق من أن الحقل `completed_at` غير فارغ
            ->count();

        // العثور على الدورة التي ينتمي إليها الطالب
        $enrollment = Enrollment::find($enrollmentId);
        $totalLessons = Lesson::where('course_id', $enrollment->course_id)->count();

        // حساب التقدم
        return $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;
    }
    public function getStudentProgressData(Request $request, $courseId, $studentId)
{
    // الحصول على التاريخ المحدد إذا كان موجودًا
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    
    // تحديد الفترة الزمنية المطلوبة
    if ($request->input('period') == 'monthly') {
        $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
    } elseif ($request->input('period') == 'weekly') {
        $startDate = Carbon::now()->startOfWeek()->format('Y-m-d');
        $endDate = Carbon::now()->endOfWeek()->format('Y-m-d');
    }

    // إذا لم يتم تحديد التواريخ، استخدم التواريخ الافتراضية
    if (!$startDate) {
        $startDate = Carbon::now()->subMonth()->format('Y-m-d');  // الشهر الماضي
    }
    if (!$endDate) {
        $endDate = Carbon::now()->format('Y-m-d');  // التاريخ الحالي
    }

    // استعلام التقدم الخاص بالطالب في الدورة
    $lessonProgress = LessonProgress::with(['user', 'lesson.course.instructor'])
        ->whereHas('enrollment', function ($query) use ($courseId, $studentId) {
            $query->where('course_id', $courseId)
                  ->where('student_id', $studentId);  // تغيير user_id إلى student_id أو العمود الصحيح
        })
        ->whereNotNull('completed_at') 
        ->selectRaw('lesson_progress.*, TIMESTAMPDIFF(SECOND, created_at, completed_at) as total_duration_seconds')
        ->paginate(10);
    // إرجاع البيانات
    return compact('lessonProgress', 'courseId', 'startDate', 'endDate');
}



    /**
     * تحديث تقدم الطالب في درس معين وتحديث تاريخ انتهاء الدورة.
     *
     * @param Request $request
     * @param int $lessonId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $lessonId)
    {
        $studentId = Auth::id();

        // تحقق من أن الطالب مسجل في الدورة
        $isEnrolled = Enrollment::where('student_id', $studentId)
            ->where('course_id', $request->course_id)
            ->exists();

        if (!$isEnrolled) {
            return response()->json(['message' => 'You are not enrolled in this course'], 403);
        }

        // تحديث تقدم الدرس
        $progress = LessonProgress::updateOrCreate(
            ['student_id' => $studentId, 'lesson_id' => $lessonId],
            ['progress' => $request->progress, 'completed_at' => $request->progress == 100 ? now() : null]
        );

        // إذا كان التقدم 100%، قم بتحديث تاريخ انتهاء الدورة
        if ($request->progress == 100) {
            $lesson = Lesson::find($lessonId);
            $lesson->completed_at = now();
            $lesson->save();
        }

        return response()->json($progress);
    }
}
