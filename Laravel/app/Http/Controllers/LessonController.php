<?php


namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class LessonController extends Controller
{
    /**
     * Store a newly created lesson.
     */
    public function store(Request $request, $courseId)
    {
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
     * Update the specified lesson.
     */
    public function update(Request $request, $courseId, $lessonId)
    {
        $lesson = Lesson::where('course_id', $courseId)->findOrFail($lessonId);

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
        $lesson = Lesson::where('course_id', $courseId)->findOrFail($lessonId);

        // Delete the video if it exists
        if ($lesson->video_url && Storage::exists($lesson->video_url)) {
            Storage::delete($lesson->video_url);
        }

        $lesson->delete();
        return response()->json(['message' => 'Lesson deleted successfully'], Response::HTTP_OK);
    }

    /**
     * Display a listing of the lessons.
     */
    public function index($courseId)
    {
        // Fetch all lessons for a specific course
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
     * Display the specified lesson.
     */
    public function show($courseId, $lessonId)
    {
        $lesson = Lesson::where('course_id', $courseId)->find($lessonId);
        if ($lesson) {
            // If video exists, generate the URL to access it
            if ($lesson->video_url) {
                $lesson->video_url = asset('storage/' . $lesson->video_url);
            }

            return response()->json($lesson, Response::HTTP_OK);
        }
        return response()->json(['message' => 'Lesson not found'], Response::HTTP_NOT_FOUND);
    }
}
