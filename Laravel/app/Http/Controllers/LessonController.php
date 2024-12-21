<?php


namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Course;
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
            'video_url' => 'nullable|file|mimes:mp4,avi,mkv|max:10240',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'files.*' => 'nullable|file|max:5120', // 5MB max per file
        ]);

        // Handle video upload
        $videoPath = null;
        if ($request->hasFile('video_url')) {
            $videoPath = $request->file('video_url')->store('public/lessons/videos');
        }

        // Handle images upload
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('public/lessons/images');
            }
        }

        // Handle files upload
        $filePaths = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filePaths[] = $file->store('public/lessons/files');
            }
        }

        // Create the lesson
        $lesson = Lesson::create([
            'course_id' => $courseId,
            'title' => $request->title,
            'content' => $request->content,
            'video_url' => $videoPath,
            'images' => json_encode($imagePaths), // Save as JSON
            'files' => json_encode($filePaths),   // Save as JSON
            'order' => $request->order,
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
        'video_url' => 'nullable|file|mimes:mp4,avi,mkv|max:10240',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'files.*' => 'nullable|file|max:5120',
    ]);

    // Handle video update
    if ($request->hasFile('video_url')) {
        if ($lesson->video_url && Storage::exists($lesson->video_url)) {
            Storage::delete($lesson->video_url);
        }
        $lesson->video_url = $request->file('video_url')->store('public/lessons/videos');
    }

    // Handle images update
    if ($request->hasFile('images')) {
        if ($lesson->images) {
            foreach (json_decode($lesson->images) as $imagePath) {
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
            }
        }
        $imagePaths = [];
        foreach ($request->file('images') as $image) {
            $imagePaths[] = $image->store('public/lessons/images');
        }
        $lesson->images = json_encode($imagePaths);
    }

    // Handle files update
    if ($request->hasFile('files')) {
        if ($lesson->files) {
            foreach (json_decode($lesson->files) as $filePath) {
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
            }
        }
        $filePaths = [];
        foreach ($request->file('files') as $file) {
            $filePaths[] = $file->store('public/lessons/files');
        }
        $lesson->files = json_encode($filePaths);
    }

    // Update other fields
    $lesson->update($request->only(['title', 'content', 'order']));

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
        $lessons = Lesson::where('course_id', $courseId)->get();
        $course = Course::findOrFail($courseId);


        foreach ($lessons as $lesson) {
            if ($lesson->video_url) {
                $lesson->video_url = asset('storage/' . str_replace('public/', '', $lesson->video_url));
            }
            $lesson->images = $lesson->images ? array_map(fn($path) => asset('storage/' . str_replace('public/', '', $path)), json_decode($lesson->images)) : [];
            $lesson->files = $lesson->files ? array_map(fn($path) => asset('storage/' . str_replace('public/', '', $path)), json_decode($lesson->files)) : [];
        }

        return view('lessons.index', compact('lessons', 'courseId', 'course'));
    }


public function show($courseId, $lessonId)
{
    $lesson = Lesson::where('course_id', $courseId)->findOrFail($lessonId);

    if ($lesson->video_url) {
        $lesson->video_url = asset('storage/' . $lesson->video_url);
    }
    $lesson->images = $lesson->images ? array_map(fn($path) => asset('storage/' . $path), json_decode($lesson->images)) : [];
    $lesson->files = $lesson->files ? array_map(fn($path) => asset('storage/' . $path), json_decode($lesson->files)) : [];

    return response()->json($lesson, Response::HTTP_OK);
}


}
