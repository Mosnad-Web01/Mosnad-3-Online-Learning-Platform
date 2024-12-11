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

        // حفظ البيانات في قاعدة البيانات
        $lesson = Lesson::create([
            'course_id' => $courseId,
            'title' => $request->title,
            'content' => $request->content,
            'video_path' => $videoPath,
            'images' => json_encode($images),
            'files' => json_encode($files),
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('instructor.lessons.index', $courseId)
                         ->with('success', 'Lesson created successfully.');
    }


    public function edit($courseId, $lessonId)
{
    $course = Course::where('instructor_id', Auth::id())->findOrFail($courseId);
    $lesson = $course->lessons()->findOrFail($lessonId);

    // التأكد من أن البيانات من النوع string قبل استخدام json_decode
    if (is_string($lesson->images)) {
        $lesson->images = json_decode($lesson->images, true) ?? [];
    } else {
        $lesson->images = $lesson->images ?? [];
    }

    if (is_string($lesson->files)) {
        $lesson->files = json_decode($lesson->files, true) ?? [];
    } else {
        $lesson->files = $lesson->files ?? [];
    }

    return view('instructor.lessons.edit', compact('course', 'lesson'));
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

    // التعامل مع الفيديو
    if ($request->hasFile('video')) {
        // حذف الفيديو القديم إذا كان موجوداً
        if ($lesson->video_path && Storage::exists($lesson->video_path)) {
            Storage::delete($lesson->video_path);
        }
        // رفع الفيديو الجديد
        $lesson->video_path = $request->file('video')->store('lessons/videos');
    }

    // التعامل مع الصور
    if ($request->hasFile('images')) {
        $images = json_decode($lesson->images, true) ?? [];
        // حذف الصور القديمة من التخزين
        foreach ($images as $image) {
            if (Storage::exists($image['path'])) {
                Storage::delete($image['path']);
            }
        }

        // رفع الصور الجديدة
        $newImages = [];
        foreach ($request->file('images') as $image) {
            $imagePath = $image->store('lessons/images');
            $newImages[] = ['path' => $imagePath];
        }

        // حفظ الصور الجديدة في قاعدة البيانات
        $lesson->images = json_encode($newImages);
    }

    // التعامل مع الملفات
    if ($request->hasFile('files')) {
        $files = json_decode($lesson->files, true) ?? [];
        // حذف الملفات القديمة من التخزين
        foreach ($files as $file) {
            if (Storage::exists($file['path'])) {
                Storage::delete($file['path']);
            }
        }

        // رفع الملفات الجديدة
        $newFiles = [];
        foreach ($request->file('files') as $file) {
            $filePath = $file->store('lessons/files');
            $newFiles[] = ['path' => $filePath];
        }

        // حفظ الملفات الجديدة في قاعدة البيانات
        $lesson->files = json_encode($newFiles);
    }

    // تحديث باقي البيانات في قاعدة البيانات
    $lesson->update([
        'title' => $request->title,
        'content' => $request->content,
        'order' => $request->order ?? 0,
    ]);

    return redirect()->route('instructor.lessons.index', $courseId)->with('success', 'Lesson updated successfully.');
}


    public function destroy($courseId, $lessonId)
    {
        $lesson = Lesson::where('course_id', $courseId)->findOrFail($lessonId);

        if ($lesson->video_path && Storage::exists($lesson->video_path)) {
            Storage::delete($lesson->video_path);
        }

        $images = json_decode($lesson->images, true);
        if ($images) {
            foreach ($images as $image) {
                if (Storage::exists($image['path'])) {
                    Storage::delete($image['path']);
                }
            }
        }

        $files = json_decode($lesson->files, true);
        if ($files) {
            foreach ($files as $file) {
                if (Storage::exists($file['path'])) {
                    Storage::delete($file['path']);
                }
            }
        }

        $lesson->delete();

        return redirect()->route('instructor.lessons.index', $courseId)->with('success', 'Lesson deleted successfully.');
    }

}
