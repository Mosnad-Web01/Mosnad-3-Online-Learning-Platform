<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InstructorLessonController extends Controller
{
    public function index($courseId)
    {
        $course = Course::where('instructor_id', Auth::id())->findOrFail($courseId);
        $lessons = $course->lessons; // جلب الدروس المرتبطة بالدورة
        return view('instructor.lessons.index', compact('course', 'lessons'));
    }

    public function create($courseId)
    {
        $course = Course::where('instructor_id', Auth::id())->findOrFail($courseId);
        return view('instructor.lessons.create', compact('course'));
    }

    public function store(Request $request, $courseId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'video_url' => 'nullable|file|mimes:mp4,avi,mkv|max:10240', // Validation for video file
        ]);

        // Handle video upload
        $videoPath = null;
        if ($request->hasFile('video_url')) {
            // Generating a unique name for the video file
            $videoName = uniqid() . '.' . $request->file('video_url')->getClientOriginalExtension();
            // Storing the video file in the 'public/lessons/videos' directory
            $videoPath = $request->file('video_url')->storeAs('public/lessons/videos', $videoName);
        }

        // Create the lesson
        $lesson = Lesson::create([
            'course_id' => $courseId,
            'title' => $request->title,
            'content' => $request->content,
            'video_url' => $videoPath, // Save the path to the video
        ]);

        return redirect()->route('instructor.lessons.index', $courseId)->with('success', 'Lesson created successfully.');
    }

    public function edit($courseId, $lessonId)
    {
        $course = Course::where('instructor_id', Auth::id())->findOrFail($courseId);
        $lesson = $course->lessons()->findOrFail($lessonId);
        return view('instructor.lessons.edit', compact('course', 'lesson'));
    }

    public function update(Request $request, $courseId, $lessonId)
    {
        $lesson = Lesson::where('course_id', $courseId)->findOrFail($lessonId);
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'video_url' => 'nullable|file|mimes:mp4,avi,mkv|max:10240', // Validate the video format
        ]);

        // Handle video upload and deletion
        if ($request->hasFile('video_url')) {
            // Delete the old video if it exists
            if ($lesson->video_url && Storage::exists($lesson->video_url)) {
                Storage::delete($lesson->video_url);
            }

            // Upload the new video
            $videoName = uniqid() . '.' . $request->file('video_url')->getClientOriginalExtension();
            $videoPath = $request->file('video_url')->storeAs('public/lessons/videos', $videoName);
            $lesson->video_url = $videoPath; // Update the video path
        }

        // Update the lesson's title and content
        $lesson->update($request->only(['title', 'content']));

        return redirect()->route('instructor.lessons.index', $courseId)->with('success', 'Lesson updated successfully.');
    }

    public function destroy($courseId, $lessonId)
    {
        $lesson = Lesson::where('course_id', $courseId)->findOrFail($lessonId);

        // Delete the video if it exists
        if ($lesson->video_url && Storage::exists($lesson->video_url)) {
            Storage::delete($lesson->video_url);
        }

        $lesson->delete();
        return redirect()->route('instructor.lessons.index', $courseId)->with('success', 'Lesson deleted successfully.');
    }
}
