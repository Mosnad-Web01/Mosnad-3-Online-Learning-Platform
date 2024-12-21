<?php

namespace App\Http\Controllers;

use App\Models\LessonProgress;
use App\Models\Lesson;
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
    
    if (!$enrollment) {
        return response()->json(['error' => 'User is not enrolled in this course'], 400);
    }

    $lesson = Lesson::where('course_id', $courseId)->where('id', $lessonId)->first();
    if (!$lesson) {
        return response()->json(['error' => 'Lesson not found'], 404);
    }

    $progress = LessonProgress::updateOrCreate(
        ['enrollment_id' => $enrollment->id, 'lesson_id' => $lessonId],
        ['started_at' => now()]
    );

    return response()->json(['message' => 'Lesson started successfully'], 200);
    // return redirect()->route('lesson.show', ['courseId' => $courseId, 'lessonId' => $lessonId])->with('error', 'Progress not found');

}

    
    public function completeLesson(Request $request, $courseId, $lessonId)
    {
        $enrollmentId = $request->input('enrollment_id'); // إرسال رقم التسجيل من الطلب
    
        // تحقق من أن السجل موجود وحدثه
        $progress = LessonProgress::where('enrollment_id', $enrollmentId)
            ->where('lesson_id', $lessonId)
            ->first();
    
        if ($progress) {
            $progress->update(['completed_at' => now()]);
            return redirect()->route('lesson.show', ['courseId' => $courseId, 'lessonId' => $lessonId])->with('message', 'Lesson completed!');
        }
    
        return redirect()->route('lesson.show', ['courseId' => $courseId, 'lessonId' => $lessonId])->with('error', 'Progress not found');
    }
    public function showLesson(Request $request, $courseId, $lessonId)
    {
        $lesson = Lesson::where('course_id', $courseId)->where('id', $lessonId)->first();
    
        if ($lesson) {
            // إذا تم العثور على الدرس، قم بإرجاع البيانات كـ JSON
            return response()->json([
                'title' => $lesson->title,
                'content' => $lesson->content,
                'video_url' => $lesson->video_url,
            ]);
        }
    
        return response()->json(['error' => 'Lesson not found'], 404);
    }
    
}
