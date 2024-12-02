<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
class CourseController extends Controller
{
    /**
     * Store a newly created course.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
            'category_id' => 'required|exists:course_categories,id',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'instructor_id' => 'required|exists:users,id',
            'language' => 'nullable|string', // التحقق من حقل اللغة
            'requirements' => 'nullable|string', // التحقق من حقل المتطلبات
            'learning_outcomes' => 'nullable|string', // التحقق من حقل نتائج التعلم
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // التحقق من الصورة
        ]);

        // Handle image upload if provided
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('public/courses/' . $request->course_name, $imageName); // Store image with a unique name inside the course folder
        }

        // Create the course record
        $course = Course::create([
            'course_name' => $request->course_name,
            'description' => $request->description,
            'level' => $request->level,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'instructor_id' => $request->instructor_id,
            'language' => $request->language, // إضافة اللغة
            'requirements' => $request->requirements, // إضافة المتطلبات
            'learning_outcomes' => $request->learning_outcomes, // إضافة نتائج التعلم
            'image' => $imagePath, // حفظ مسار الصورة
        ]);

        return response()->json($course, Response::HTTP_CREATED);
    }

    /**
     * Update the specified course.
     */
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'course_name' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
            'category_id' => 'required|exists:course_categories,id',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'instructor_id' => 'required|exists:users,id',
            'language' => 'nullable|string', // التحقق من حقل اللغة
            'requirements' => 'nullable|string', // التحقق من حقل المتطلبات
            'learning_outcomes' => 'nullable|string', // التحقق من حقل نتائج التعلم
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // التحقق من الصورة
        ]);

        // Handle image upload and deletion if provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($course->image && Storage::exists($course->image)) {
                Storage::delete($course->image);
            }

            $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('public/courses/' . $course->course_name, $imageName); // Store image with a unique name inside the course folder
            $course->image = $imagePath;
        }

        // Update course record
        $course->update($request->only([
            'course_name', 'description', 'level', 'category_id', 'price',
            'start_date', 'end_date', 'instructor_id', 'language', 'requirements', 'learning_outcomes', 'image'
        ]));

        return response()->json($course, Response::HTTP_OK);
    }

    /**
     * Remove the specified course.
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        // Delete the image if it exists
        if ($course->image && Storage::exists($course->image)) {
            Storage::delete($course->image);
        }

        $course->delete();
        return response()->json(['message' => 'Course deleted successfully'], Response::HTTP_OK);
    }

    /**
     * Get all courses with category, instructor, and lessons.
     */
    // public function index(Request $request)
    // {
    //     $user = $request->user();

    //     if (!$user) {
    //         return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
    //     }

    //     if ($user->role === 'student') {
    //         $courses = $user->courses()->with(['category', 'instructor', 'lessons'])->get();
    //     } elseif ($user->role === 'instructor') {
    //         $courses = $user->createdCourses()->with(['category', 'instructor', 'lessons'])->get();
    //     } else {
    //         $courses = Course::with(['category', 'instructor', 'lessons'])->get();
    //     }

    //     // إضافة رابط الصورة
    //     foreach ($courses as $course) {
    //         if ($course->image) {
    //             $course->image_url = asset('storage/' . $course->image);
    //         }
    //     }

    //     return response()->json($courses, Response::HTTP_OK);
    // }
    // ------Code for test Token-----
    // $xsrfTokenFromHeader = $request->header('X-XSRF-TOKEN');
    // $xsrfTokenFromCookie = $request->cookie('XSRF-TOKEN');

    // if ($xsrfTokenFromHeader == $xsrfTokenFromCookie) {
    //     // إذا لم يتطابق التوكن، يمكن إرجاع رد خطأ
    //     return response()->json(['message' => 'Invalid CSRF token',
    //     'xsrfTokenFromHeader'=>$xsrfTokenFromHeader,
    //     'xsrfTokenFromCookie'=>$xsrfTokenFromCookie,
    //     'Auth::check():'=>Auth::check(),
    //     'Auth::user():'=>Auth::user(),

    //      ], 403);
    // }
    public function index(Request $request)
 {

    // جلب جميع الكورسات مع العلاقات المرتبطة
    $courses = Course::with(['category', 'instructor', 'lessons'])->get();

    // إضافة رابط للصورة لكل دورة إذا كانت موجودة
    foreach ($courses as $course) {
        if ($course->image) {
            $course->image_url = asset('storage/' . $course->image);
        }
    }

    // إعادة الكورسات في استجابة JSON
    return response()->json($courses, Response::HTTP_OK);
}



    /**
     * Display the specified course.
     */
    public function show($id)
    {
        $course = Course::with(['category', 'instructor', 'lessons'])->find($id);
        if ($course) {
            if ($course->image) {
                $course->image_url = asset('storage/' . $course->image);
            }

            return response()->json($course, Response::HTTP_OK);
        }
        return response()->json(['message' => 'Course not found'], Response::HTTP_NOT_FOUND);
    }
    public function home()
    {
        $courses = Course::latest()->take(6)->get(); // جلب آخر 6 كورسات
        return view('home', compact('courses'));
    }
    public function showDetails($id)
{
    // جلب الدورة مع الفئة، المدرب، والدروس
    $course = Course::with(['category', 'instructor', 'lessons'])->findOrFail($id);

    // إضافة رابط الصورة إذا كانت موجودة
    if ($course->image) {
        $course->image_url = asset('storage/' . $course->image);
    }

    // إعادة العرض مع البيانات
    return view('courses.show', compact('course'));
}

}
