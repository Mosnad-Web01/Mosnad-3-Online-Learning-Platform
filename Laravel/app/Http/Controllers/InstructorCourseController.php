<?php


namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InstructorCourseController extends Controller
{
    // Display all courses for Admin or courses created by the instructor
    public function index()
    {
        // If the user is Admin, show all courses, otherwise show only the instructor's courses
        if (Auth::user()->role == 'Admin') {
            $courses = Course::all();  // Admin can see all courses
        } else {
            $courses = Course::where('instructor_id', Auth::user()->id)->get();  // Instructor sees only their courses
        }

        return view('instructor.courses.index', compact('courses'));
    }

    // Show the form for creating a new course
    public function create()
    {
        // Get all categories for course selection
        $categories = \App\Models\CourseCategory::all();  // Correctly import the model
        return view('instructor.courses.create', compact('categories'));
    }

    // Store a newly created course in the database
    public function store(Request $request)
    {
       // Validate the incoming data
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
            'category_id' => 'required|exists:course_categories,id',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'language' => 'nullable|string|max:50',
            'requirements' => 'nullable|string',
            'learning_outcomes' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle image upload if present
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('public/courses', $imageName);
        }

        // Create the course with validated data
        $course = Course::create([
            'course_name' => $validated['course_name'],
            'description' => $validated['description'],
            'level' => $validated['level'],
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'instructor_id' => Auth::id(),
            'language' => $validated['language'],
            'requirements' => $validated['requirements'],
            'learning_outcomes' => $validated['learning_outcomes'],
            'image' => $imagePath,
        ]);

        // Redirect back with a success message
        return redirect()->route('instructor.courses.index')
                         ->with('success', 'Course created successfully.');
    }

    // Show the form for editing the specified course
    public function edit($id)
    {
        // Find the course by its ID and the current instructor's ID
        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);
        
        // Get all categories for the course
        $categories = \App\Models\CourseCategory::all();  
        return view('instructor.courses.edit', compact('course', 'categories'));
    }

    // Update the specified course in the database
    public function update(Request $request, $id)
    {
        // Find the course by its ID and the current instructor's ID
        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);

        // Validate the updated data
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

        // Handle image upload if present
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($course->image && Storage::exists($course->image)) {
                Storage::delete($course->image);
            }

            // Upload the new image
            $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('public/courses/' . $course->course_name, $imageName);
            $course->image = $imagePath;
        }

        // Update the course with the validated data
        $course->update($request->only([
            'course_name', 'description', 'level', 'category_id', 'price',
            'start_date', 'end_date', 'language', 'requirements', 'learning_outcomes', 'image'
        ]));

        // Redirect back with success message
        return redirect()->route('instructor.courses.index')->with('success', 'Course updated successfully.');
    }

    // Remove the specified course from the database
    public function destroy($id)
    {
        // Find the course by its ID and the current instructor's ID
        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);

        // Delete the course image if it exists
        if ($course->image && Storage::exists($course->image)) {
            Storage::delete($course->image);
        }

        // Delete the course from the database
        $course->delete();
        return redirect()->route('instructor.courses.index')->with('success', 'Course deleted successfully.');
    }
}

// namespace App\Http\Controllers;

// use App\Models\Course;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage;

// class InstructorCourseController extends Controller
// {


// public function index()
// {
//     // استخدام Auth::user() بدلاً من auth()->user()
//     $courses = Course::where('instructor_id', Auth::user()->id)->get();

//     return view('instructor.courses.index', compact('courses'));
// }
//     /**
//      * Show the form for creating a new course.
//      */
//     public function create()
//     {
//         $categories = \App\Models\CourseCategory::all(); // استيراد النموذج بشكل صحيح
//         return view('instructor.courses.create', compact('categories'));
//     }

//     /**
//      * Store a newly created course in the database.
//      */
//     public function store(Request $request)
//     {
//         // Validate incoming data
//         $validated = $request->validate([
//             'course_name' => 'required|string|max:255',
//             'description' => 'required|string',
//             'level' => 'required|in:Beginner,Intermediate,Advanced',
//             'category_id' => 'required|exists:course_categories,id',
//             'price' => 'required|numeric|min:0',
//             'start_date' => 'required|date|before_or_equal:end_date',
//             'end_date' => 'required|date|after_or_equal:start_date',
//             'language' => 'nullable|string|max:50',
//             'requirements' => 'nullable|string',
//             'learning_outcomes' => 'nullable|string',
//             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//         ]);

//         // Handle image upload
//         $imagePath = null;
//         if ($request->hasFile('image')) {
//             $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
//             $imagePath = $request->file('image')->storeAs('public/courses', $imageName);
//         }

//         // Create the course
//         $course = Course::create([
//             'course_name' => $validated['course_name'],
//             'description' => $validated['description'],
//             'level' => $validated['level'],
//             'category_id' => $validated['category_id'],
//             'price' => $validated['price'],
//             'start_date' => $validated['start_date'],
//             'end_date' => $validated['end_date'],
//             'instructor_id' => Auth::id(),
//             'language' => $validated['language'],
//             'requirements' => $validated['requirements'],
//             'learning_outcomes' => $validated['learning_outcomes'],
//             'image' => $imagePath,
//         ]);

//         // Redirect back with success message
//         return redirect()->route('instructor.courses.index')
//                          ->with('success', 'Course created successfully.');
//     }

//     /**
//      * Show the form for editing the specified course.
//      */
//     public function edit($id)
//     {
//         $course = Course::where('instructor_id', Auth::id())->findOrFail($id);
//     $categories = \App\Models\CourseCategory::all();  // إضافة هذا السطر لاسترجاع الفئات
//     return view('instructor.courses.edit', compact('course', 'categories'));  // تمرير الفئات
//     }

//     /**
//      * Update the specified course in the database.
//      */
//     public function update(Request $request, $id)
//     {
//         $course = Course::where('instructor_id', Auth::id())->findOrFail($id);

//         $request->validate([
//             'course_name' => 'required|string|max:255',
//             'description' => 'required|string',
//             'level' => 'required|in:Beginner,Intermediate,Advanced',
//             'category_id' => 'required|exists:course_categories,id',
//             'price' => 'required|numeric',
//             'start_date' => 'required|date',
//             'end_date' => 'required|date',
//             'language' => 'nullable|string',
//             'requirements' => 'nullable|string',
//             'learning_outcomes' => 'nullable|string',
//             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//         ]);

//         // التعامل مع الصورة إذا كانت مرفوعة
//         if ($request->hasFile('image')) {
//             if ($course->image && Storage::exists($course->image)) {
//                 Storage::delete($course->image);
//             }

//             $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
//             $imagePath = $request->file('image')->storeAs('public/courses/' . $course->course_name, $imageName);
//             $course->image = $imagePath;
//         }

//         // تحديث الدورة
//         $course->update($request->only([
//             'course_name', 'description', 'level', 'category_id', 'price',
//             'start_date', 'end_date', 'language', 'requirements', 'learning_outcomes', 'image'
//         ]));

//         return redirect()->route('instructor.courses.index')->with('success', 'Course updated successfully.');
//     }

//     /**
//      * Remove the specified course from the database.
//      */
//     public function destroy($id)
//     {
//         $course = Course::where('instructor_id', Auth::id())->findOrFail($id);

//         if ($course->image && Storage::exists($course->image)) {
//             Storage::delete($course->image);
//         }

//         $course->delete();
//         return redirect()->route('instructor.courses.index')->with('success', 'Course deleted successfully.');
//     }
// }
