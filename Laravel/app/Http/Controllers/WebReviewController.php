<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\ReviewReply;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class WebReviewController extends Controller
{
    public function storeReply(Request $request, Review $review)
    {
        $validated = $request->validate([
            'reply_text' => 'required|string|max:500',
        ]);

        // إضافة الرد على المراجعة
        $reply = new ReviewReply();
        $reply->review_id = $review->id;
        $reply->user_id = Auth::id();
        $reply->reply_text = $validated['reply_text'];
        $reply->save();

        return redirect()->back()->with('success', 'Reply added successfully!');
    }

    // تخزين الرد على الرد
    public function storeReplyToReply(Request $request, ReviewReply $reply)
    {
        $validated = $request->validate([
            'reply_text' => 'required|string|max:500',
        ]);

        // إضافة رد على رد آخر
        $childReply = new ReviewReply();
        $childReply->review_id = $reply->review_id;
        $childReply->user_id = Auth::id();
        $childReply->reply_text = $validated['reply_text'];
        $childReply->parent_id = $reply->id;
        $childReply->save();

        return redirect()->back()->with('success', 'Reply to reply added successfully!');
    }
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $user = Auth::user();
    
        if ($user->role === 'Instructor') {
            $courses = Course::where('instructor_id', $user->id)
                ->withCount('reviews') // جلب عدد المراجعات
                ->with(['reviews' => function ($query) {
                    $query->select('course_id', 'course_rating'); // جلب التقييمات فقط
                }])
                ->get();
        } elseif ($user->role === 'Admin') {
            $courses = Course::withCount('reviews') // جلب عدد المراجعات
                ->with(['reviews' => function ($query) {
                    $query->select('course_id', 'course_rating'); // جلب التقييمات فقط
                }])
                ->get();
        } else {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }
    
        return view('reviews.index', compact('courses'));
    }
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    // جلب الدورات والمدرسين لإظهارهم في النموذج
    $courses = Course::all(); 
    $instructors = User::where('role', 'Instructor')->get();

    // عرض نموذج الإنشاء
    return view('reviews.create', compact('courses', 'instructors'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'course_id' => 'required|exists:courses,id',
        'instructor_id' => 'required|exists:users,id',
        'course_rating' => 'required|integer|between:1,5',
        'instructor_rating' => 'required|integer|between:1,5',
        'review_text' => 'nullable|string|max:500',
    ]);

    // التحقق إذا كان الطالب قد أضاف مراجعة سابقة لنفس الدورة
    $existingReview = Review::where('course_id', $request->course_id)
        ->where('student_id', Auth::id())
        ->first();

    if ($existingReview) {
        return redirect()->back()
            ->with('error', 'You have already submitted a review for this course.');
    }

    // إضافة المراجعة الجديدة
    $validated['student_id'] = auth()->id();
    Review::create($validated);

    return redirect()->route('reviews.index')->with('success', 'Review added successfully!');
}


    /**
     * Display the specified resource.
     */
    public function show(Review $review)
{
    return view('reviews.show', compact('review'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Review $review)
    {
        // جلب الدورات والمدرسين لإظهارهم في النموذج
        $courses = Course::all();
        $instructors = User::where('role', 'Instructor')->get();
    
        // التحقق إذا كانت هناك مراجعة موجودة لنفس الطالب ونفس الدورة
        $existingReview = Review::where('course_id', $request->course_id)
            ->where('student_id', Auth::id())
            ->first();
   dd($existingReview); 
        if ($existingReview && $existingReview->id !== $review->id) {
            return redirect()->route('courses.show', $request->course_id)
                ->with('error', 'You have already submitted a review for this course.');
        }
    
        // عرض نموذج التعديل مع المراجعة المختارة
        return view('reviews.edit', compact('review', 'courses', 'instructors'));
    }
    


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
{
    $validated = $request->validate([
        'course_rating' => 'required|integer|between:1,5',
        'instructor_rating' => 'required|integer|between:1,5',
        'review_text' => 'nullable|string|max:500',
    ]);

    $review->update($validated);

    return redirect()->route('reviews.index')->with('success', 'Review updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();
    
        return redirect()->route('reviews.index')->with('success', 'Review deleted successfully!');
    }
    
}
