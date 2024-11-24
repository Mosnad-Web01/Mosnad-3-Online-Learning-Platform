<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class InstructorCourseController extends Controller
{
    /**
     * Show the list of courses for the authenticated instructor.
     */
    public function index()
    {
        // الحصول على الدورات التي أنشأها المدرس الحالي
        $courses = Course::where('instructor_id', Auth::id())->with(['category', 'lessons'])->get();

        // إضافة رابط الصورة لكل دورة إذا كانت موجودة
        foreach ($courses as $course) {
            if ($course->image) {
                $course->image_url = asset('storage/' . $course->image);
            }
        }

        // عرض الدورات على الصفحة
        return view('instructor.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        // يمكنك إضافة الكود اللازم لتحميل الفئات أو أي معلومات تحتاجها في النموذج
        return view('instructor.courses.create');
    }

    /**
     * Store a newly created course in the database.
     */
    public function store(Request $request)
    {
        // إعادة استخدام نفس المنطق للتحقق من المدخلات كما في `CourseController`
        $request->validate([
            'course_name' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
            'category_id' => 'required|exists:course_categories,id',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'instructor_id' => 'required|exists:users,id',
            'language' => 'nullable|string',
            'requirements' => 'nullable|string',
            'learning_outcomes' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // تحميل الصورة إذا كانت موجودة
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('public/courses/' . $request->course_name, $imageName);
        }

        // إنشاء الدورة الجديدة
        $course = Course::create([
            'course_name' => $request->course_name,
            'description' => $request->description,
            'level' => $request->level,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'instructor_id' => Auth::id(), // الحصول على المعرف الخاص بالمدرس الحالي
            'language' => $request->language,
            'requirements' => $request->requirements,
            'learning_outcomes' => $request->learning_outcomes,
            'image' => $imagePath,
        ]);

        return redirect()->route('instructor.courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit($id)
    {
        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);
        return view('instructor.courses.edit', compact('course'));
    }

    /**
     * Update the specified course in the database.
     */
    public function update(Request $request, $id)
    {
        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);

        $request->validate([
            'course_name' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
            'category_id' => 'required|exists:course_categories,id',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'language' => 'nullable|string',
            'requirements' => 'nullable|string',
            'learning_outcomes' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // التعامل مع الصورة إذا كانت مرفوعة
        if ($request->hasFile('image')) {
            if ($course->image && Storage::exists($course->image)) {
                Storage::delete($course->image);
            }

            $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('public/courses/' . $course->course_name, $imageName);
            $course->image = $imagePath;
        }

        // تحديث الدورة
        $course->update($request->only([
            'course_name', 'description', 'level', 'category_id', 'price',
            'start_date', 'end_date', 'language', 'requirements', 'learning_outcomes', 'image'
        ]));

        return redirect()->route('instructor.courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified course from the database.
     */
    public function destroy($id)
    {
        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);

        if ($course->image && Storage::exists($course->image)) {
            Storage::delete($course->image);
        }

        $course->delete();
        return redirect()->route('instructor.courses.index')->with('success', 'Course deleted successfully.');
    }
}
