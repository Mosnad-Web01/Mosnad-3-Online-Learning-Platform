<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\LessonProgress;

class ProgressController extends Controller
{
    /**
     * حساب نسبة التقدم لطالب معين بناءً على معرف التسجيل (enrollment_id)
     *
     * @param int $enrollmentId
     * @return float
     */
    public function calculateProgress($enrollmentId)
    {
        // تأكد من حساب التقدم بشكل صحيح
        // هذه مجرد مثال، يمكنك تعديلها حسب الطريقة التي تحسب بها التقدم
        $completedLessons = LessonProgress::where('enrollment_id', $enrollmentId)
            ->whereNotNull('completed_at')
            ->count();
    
        $totalLessons = Lesson::whereHas('course', function ($query) use ($enrollmentId) {
            $query->whereHas('enrollments', function ($query) use ($enrollmentId) {
                $query->where('id', $enrollmentId);
            });
        })->count();
    
        // حساب التقدم
        return $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;
    }
    
}

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\LessonProgress; // افتراضياً Model مرتبط
// use App\Models\Enrollment; // للتأكد من تسجيل الطالب
// use Illuminate\Support\Facades\Auth; // إذا كنت تعتمد على المصادقة

// class ProgressController extends Controller
// {
//     // عرض تقدم الطالب في جميع الدروس الخاصة بكورس
//     public function index($courseId)
//     {
//         $studentId = Auth::id(); // افتراضياً الطالب مسجل دخول
//         $progress = LessonProgress::where('student_id', $studentId)
//                                   ->whereHas('lesson', function ($query) use ($courseId) {
//                                       $query->where('course_id', $courseId);
//                                   })
//                                   ->get();
//         return response()->json($progress);
//     }

//     // تحديث تقدم الطالب في درس معين
//     public function update(Request $request, $lessonId)
//     {
//         $studentId = Auth::id();
        
//         // تحقق من أن الطالب مسجل في الكورس
//         $isEnrolled = Enrollment::where('student_id', $studentId)
//                                 ->where('course_id', $request->course_id)
//                                 ->exists();

//         if (!$isEnrolled) {
//             return response()->json(['message' => 'You are not enrolled in this course'], 403);
//         }

//         // تحديث تقدم الدرس
//         $progress = LessonProgress::updateOrCreate(
//             ['student_id' => $studentId, 'lesson_id' => $lessonId],
//             ['progress' => $request->progress, 'is_completed' => $request->progress == 100]
//         );

//         return response()->json($progress);
//     }
// }


//     /**
//      * Show the form for creating a new resource.
//      */
//     public function create()
//     {
//         //
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(Request $request)
//     {
//         //
//     }

//     /**
//      * Display the specified resource.
//      */
//     public function show(string $id)
//     {
//         //
//     }

//     /**
//      * Show the form for editing the specified resource.
//      */
//     public function edit(string $id)
//     {
//         //
//     }

    

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(string $id)
//     {
//         //
//     }
// }
