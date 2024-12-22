<?php

namespace App\Http\Controllers;

use App\Models\LessonProgress;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class LessonProgressController extends Controller
{
    public function index()
    {
        return LessonProgressController::with(['enrollment', 'lesson'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        return LessonProgressController::create($validated);
    }

    public function destroy(LessonProgressController $lessonCompletion)
    {
        $lessonCompletion->delete();
        return response()->noContent();
    }
    public function startLesson(Request $request, $courseId, $lessonId)
    {
        $userId = auth()->id(); 

        $enrollment = Enrollment::where('student_id', $userId)->where('course_id', $courseId)->first();
    
        $progress = LessonProgress::updateOrCreate(
            ['enrollment_id' => $enrollment->id, 'lesson_id' => $lessonId],
            ['started_at' => now()]
        );
    
        // لا تحتاج إلى `user_id` لأنك تعمل باستخدام `enrollment_id`
        // return redirect()->route('lesson.show', ['courseId' => $courseId, 'lessonId' => $lessonId]);
    }
    
    public function completeLesson(Request $request, $courseId, $lessonId)
    {
        $enrollmentId = $request->input('enrollment_id'); // إرسال رقم التسجيل من الطلب
        $userId = auth()->id(); 

        $enrollment = Enrollment::where('student_id', $userId)->where('course_id', $courseId)->first();
    
        // تحقق من أن السجل موجود وحدثه
        $progress = LessonProgress::where('enrollment_id', $enrollment->id)
            ->where('lesson_id', $lessonId)
            ->first();
    
        if ($progress) {
            $progress->update(['completed_at' => now()]);
            return redirect()->route('lesson.show', ['courseId' => $courseId, 'lessonId' => $lessonId])->with('message', 'Lesson completed!');
        }
    
        // return redirect()->route('lesson.show', ['courseId' => $courseId, 'lessonId' => $lessonId])->with('error', 'Progress not found');
    }

}
