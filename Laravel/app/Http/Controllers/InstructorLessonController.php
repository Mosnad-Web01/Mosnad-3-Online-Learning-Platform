<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Course; // استيراد موديل الدورة
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class InstructorLessonController extends Controller
{
    /**
     * Constructor to apply authentication middleware and authorization.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the lessons for a specific course.
     */
    public function index($courseId)
    {
        // تحقق من أن الدورة تخص المدرس الحالي
        $course = Course::where('id', $courseId)->where('user_id', auth()->id())->first();

        if (!$course) {
            return response()->json(['message' => 'Unauthorized or course not found'], Response::HTTP_FORBIDDEN);
        }

        // Fetch all lessons for the specific course
        $lessons = Lesson::where('course_id', $courseId)->get();

        // Add video URL to each lesson if available
        foreach ($lessons as $lesson) {
            if ($lesson->video_url) {
                $lesson->video_url = asset('storage/' . $lesson->video_url);
            }
        }

        // Return lessons in a JSON response
        return response()->json($lessons, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new lesson.
     */
    public function create($courseId)
    {
        // تحقق من أن الدورة تخص المدرس الحالي
        $course = Course::where('id', $courseId)->where('user_id', auth()->id())->first();

        if (!$course) {
            return response()->json(['message' => 'Unauthorized or course not found'], Response::HTTP_FORBIDDEN);
        }

        // Show the form or response for creating a new lesson (can be an API response or a view)
        return response()->json(['message' => 'Show lesson creation form'], Response::HTTP_OK);
    }

    /**
     * Store a newly created lesson.
     */
    public function store(Request $request, $courseId)
    {
        // تحقق من أن الدورة تخص المدرس الحالي
        $course = Course::where('id', $courseId)->where('user_id', auth()->id())->first();

        if (!$course) {
            return response()->json(['message' => 'Unauthorized or course not found'], Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'video_url' => 'nullable|file|mimes:mp4,avi,mkv|max:10240', // Validation for video file
        ]);

        // Handle video file upload if provided
        $videoPath = null;
        if ($request->hasFile('video_url')) {
            $videoName = uniqid() . '.' . $request->file('video_url')->getClientOriginalExtension();
            $videoPath = $request->file('video_url')->storeAs('public/lessons/videos', $videoName); // Store video with a unique name
        }

        // Create the lesson record
        $lesson = Lesson::create([
            'course_id' => $courseId,
            'title' => $request->title,
            'content' => $request->content,
            'video_url' => $videoPath, // Store the video path
        ]);

        return response()->json($lesson, Response::HTTP_CREATED);
    }

    /**
     * Show the form for editing the specified lesson.
     */
    public function edit($courseId, $lessonId)
    {
        // تحقق من أن الدورة والدروس تخص المدرس الحالي
        $course = Course::where('id', $courseId)->where('user_id', auth()->id())->first();
        $lesson = Lesson::where('course_id', $courseId)->find($lessonId);

        if (!$course || !$lesson) {
            return response()->json(['message' => 'Unauthorized or lesson not found'], Response::HTTP_FORBIDDEN);
        }

        // Show the form or response for editing the lesson (can be an API response or a view)
        return response()->json(['message' => 'Show lesson edit form'], Response::HTTP_OK);
    }

    /**
     * Update the specified lesson.
     */
    public function update(Request $request, $courseId, $lessonId)
    {
        // تحقق من أن الدورة والدروس تخص المدرس الحالي
        $course = Course::where('id', $courseId)->where('user_id', auth()->id())->first();
        $lesson = Lesson::where('course_id', $courseId)->findOrFail($lessonId);

        if (!$course) {
            return response()->json(['message' => 'Unauthorized or course not found'], Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'video_url' => 'nullable|file|mimes:mp4,avi,mkv|max:10240', // Validation for video file
        ]);

        // Handle video file upload and deletion if provided
        if ($request->hasFile('video_url')) {
            // Delete the old video if it exists
            if ($lesson->video_url && Storage::exists($lesson->video_url)) {
                Storage::delete($lesson->video_url);
            }

            $videoName = uniqid() . '.' . $request->file('video_url')->getClientOriginalExtension();
            $videoPath = $request->file('video_url')->storeAs('public/lessons/videos', $videoName); // Store video with a unique name
            $lesson->video_url = $videoPath;
        }

        // Update lesson record
        $lesson->update($request->only(['title', 'content'])); // Update only title and content

        return response()->json($lesson, Response::HTTP_OK);
    }

    /**
     * Remove the specified lesson.
     */
    public function destroy($courseId, $lessonId)
    {
        // تحقق من أن الدورة والدروس تخص المدرس الحالي
        $course = Course::where('id', $courseId)->where('user_id', auth()->id())->first();
        $lesson = Lesson::where('course_id', $courseId)->findOrFail($lessonId);

        if (!$course) {
            return response()->json(['message' => 'Unauthorized or course not found'], Response::HTTP_FORBIDDEN);
        }

        // Delete the video if it exists
        if ($lesson->video_url && Storage::exists($lesson->video_url)) {
            Storage::delete($lesson->video_url);
        }

        $lesson->delete();
        return response()->json(['message' => 'Lesson deleted successfully'], Response::HTTP_OK);
    }
}
