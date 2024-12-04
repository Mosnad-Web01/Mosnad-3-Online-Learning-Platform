<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminCourseController extends Controller
{
    /**
     * Display a listing of all courses.
     */
    public function index()
    {
        // عرض جميع الكورسات بغض النظر عن المعلم المرتبط بها
        $courses = Course::all();

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        $categories = \App\Models\CourseCategory::all();
        $instructors = \App\Models\User::where('role', 'instructor')->get(); // افتراض وجود حقل role
        return view('admin.courses.create', compact('categories', 'instructors'));
    }

    /**
     * Store a newly created course in the database.
     */
    public function store(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
            'category_id' => 'required|exists:course_categories,id',
            'price' => 'required|numeric|min:0',
            'is_free' => 'required|boolean',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'language' => 'nullable|string|max:50',
            'requirements' => 'nullable|string',
            'learning_outcomes' => 'nullable|string',
            'instructor_id' => 'required|exists:users,id', // تحقق من وجود المدرب
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('public/courses', $imageName);
        }

        // Create the course
        Course::create(array_merge($validated, [
            'image' => $imagePath,
        ]));

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Course created successfully.');
    }


    /**
     * Show the form for editing the specified course.
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $categories = \App\Models\CourseCategory::all();
        $instructors = \App\Models\User::where('role', 'instructor')->get(); // افتراض وجود حقل role
        return view('admin.courses.edit', compact('course', 'categories', 'instructors'));
    }

    /**
     * Update the specified course in the database.
     */
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
            'category_id' => 'required|exists:course_categories,id',
            'price' => 'required|numeric',
            'is_free' => 'required|boolean',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'language' => 'nullable|string',
            'requirements' => 'nullable|string',
            'learning_outcomes' => 'nullable|string',
            'instructor_id' => 'required|exists:users,id', // تحقق من وجود المدرب
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($course->image && Storage::exists($course->image)) {
                Storage::delete($course->image);
            }

            $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('public/courses', $imageName);
            $validated['image'] = $imagePath;
        }

        $course->update($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }


    /**
     * Remove the specified course from the database.
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        // حذف الدروس المرتبطة بالدورة
        $course->lessons()->delete(); // افترض أن هناك علاقة بين Course و Lesson

        // حذف الصورة إذا كانت موجودة
        if ($course->image && Storage::exists($course->image)) {
            Storage::delete($course->image);
        }

        // حذف الدورة
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }
}
