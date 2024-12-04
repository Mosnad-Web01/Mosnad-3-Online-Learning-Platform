<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminLessonController extends Controller
{
    public function index($courseId)
    {
        $course = Course::findOrFail($courseId); // جلب الدورة بدون تقييد المدرب
        $lessons = $course->lessons;
        return view('admin.lessons.index', compact('course', 'lessons'));
    }

    public function create($courseId)
    {
        $course = Course::findOrFail($courseId);
        return view('admin.lessons.create', compact('course'));
    }

    public function store(Request $request, $courseId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video' => 'nullable|file|mimes:mp4,avi,mkv|max:10240',
            'images.*' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
            'files.*' => 'nullable|file|max:5120',
            'order' => 'nullable|integer',
        ]);

        $videoPath = null;
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store("lessons/$courseId/videos");
        }

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store("lessons/$courseId/images");
                $images[] = $imagePath;
            }
        }

        $files = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filePath = $file->store("lessons/$courseId/files");
                $files[] = $filePath;
            }
        }

        Lesson::create([
            'course_id' => $courseId,
            'title' => $request->title,
            'content' => $request->content,
            'video_path' => $videoPath,
            'images' => json_encode($images),
            'files' => json_encode($files),
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.lessons.index', $courseId)
                         ->with('success', 'Lesson created successfully.');
    }


    public function edit($courseId, $lessonId)
    {
        $course = Course::findOrFail($courseId);
        $lesson = $course->lessons()->findOrFail($lessonId);

        // Convert stored JSON fields to arrays only if they are not already arrays
        $lesson->images = is_string($lesson->images) ? json_decode($lesson->images, true) ?? [] : $lesson->images;
        $lesson->files = is_string($lesson->files) ? json_decode($lesson->files, true) ?? [] : $lesson->files;

        return view('admin.lessons.edit', compact('course', 'lesson'));
    }


    public function update(Request $request, $courseId, $lessonId)
    {
        $lesson = Lesson::where('course_id', $courseId)->findOrFail($lessonId);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video' => 'nullable|file|mimes:mp4,avi,mkv|max:10240',
            'images.*' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
            'files.*' => 'nullable|file|max:5120',
            'order' => 'nullable|integer',
        ]);

        // Handling video file
        if ($request->hasFile('video')) {
            if ($lesson->video_path && Storage::exists($lesson->video_path)) {
                Storage::delete($lesson->video_path);
            }
            $lesson->video_path = $request->file('video')->store("lessons/$courseId/videos");
        }

        // Handling images
        if ($request->hasFile('images')) {
            $existingImages = is_string($lesson->images) ? json_decode($lesson->images, true) ?? [] : $lesson->images;
            // Delete old images
            foreach ($existingImages as $image) {
                if (Storage::exists($image)) {
                    Storage::delete($image);
                }
            }

            $newImages = [];
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store("lessons/$courseId/images");
                $newImages[] = $imagePath;
            }
            $lesson->images = json_encode($newImages);
        }

        // Handling files
        if ($request->hasFile('files')) {
            $existingFiles = is_string($lesson->files) ? json_decode($lesson->files, true) ?? [] : $lesson->files;
            // Delete old files
            foreach ($existingFiles as $file) {
                if (Storage::exists($file)) {
                    Storage::delete($file);
                }
            }

            $newFiles = [];
            foreach ($request->file('files') as $file) {
                $filePath = $file->store("lessons/$courseId/files");
                $newFiles[] = $filePath;
            }
            $lesson->files = json_encode($newFiles);
        }

        // Update other lesson attributes
        $lesson->update([
            'title' => $request->title,
            'content' => $request->content,
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.lessons.index', $courseId)
                         ->with('success', 'Lesson updated successfully.');
    }


    public function destroy($courseId, $lessonId)
    {
        $lesson = Lesson::where('course_id', $courseId)->findOrFail($lessonId);

        // حذف الفيديو
        if ($lesson->video_path && Storage::exists($lesson->video_path)) {
            Storage::delete($lesson->video_path);
        }

        // حذف الصور
        $images = is_string($lesson->images) ? json_decode($lesson->images, true) : $lesson->images;
        if ($images) {
            foreach ($images as $image) {
                if (Storage::exists($image)) {
                    Storage::delete($image);
                }
            }
        }

        // حذف الملفات
        $files = is_string($lesson->files) ? json_decode($lesson->files, true) : $lesson->files;
        if ($files) {
            foreach ($files as $file) {
                if (Storage::exists($file)) {
                    Storage::delete($file);
                }
            }
        }

        // حذف الدرس
        $lesson->delete();

        return redirect()->route('admin.lessons.index', $courseId)
                         ->with('success', 'Lesson deleted successfully.');
    }




}
