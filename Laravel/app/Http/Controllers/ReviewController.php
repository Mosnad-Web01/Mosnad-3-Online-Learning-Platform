<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    
    /**
     * عرض جميع التقييمات.
     */
    public function index()
    {
        $reviews = Review::with(['course', 'instructor', 'student'])->get();
        return response()->json($reviews, 200);
    }

    /**
     * عرض تقييم معين بناءً على الـ ID.
     */
    public function show($id)
    {
        $review = Review::with(['course', 'instructor', 'student'])->find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        return response()->json($review, 200);
    }

    /**
     * إنشاء تقييم جديد.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'instructor_id' => 'required|exists:users,id',
            'student_id' => 'required|exists:users,id',
            'course_rating' => 'required|integer|min:1|max:5',
            'instructor_rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $review = Review::create($request->all());
        return response()->json($review, 201);
    }

    /**
     * تحديث تقييم موجود.
     */
    public function update(Request $request, $id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'course_id' => 'sometimes|exists:courses,id',
            'instructor_id' => 'sometimes|exists:users,id',
            'student_id' => 'sometimes|exists:users,id',
            'course_rating' => 'sometimes|integer|min:1|max:5',
            'instructor_rating' => 'sometimes|integer|min:1|max:5',
            'review_text' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $review->update($request->all());
        return response()->json($review, 200);
    }

    /**
     * حذف تقييم.
     */
    public function destroy($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $review->delete();
        return response()->json(['message' => 'Review deleted successfully'], 200);
    }

    /**
 * عرض جميع التقييمات المرتبطة بكورس معين.
 */
public function getReviewsByCourse($courseId)
{
    $reviews = Review::with(['instructor', 'student'])
        ->where('course_id', $courseId)
        ->get();

    if ($reviews->isEmpty()) {
        return response()->json(['message' => 'No reviews found for this course'], 404);
    }

    return response()->json($reviews, 200);
}

/**
 * عرض جميع التقييمات المرتبطة بأستاذ معين.
 */
public function getReviewsByInstructor($instructorId)
{
    $reviews = Review::with(['course', 'student'])
        ->where('instructor_id', $instructorId)
        ->get();

    if ($reviews->isEmpty()) {
        return response()->json(['message' => 'No reviews found for this instructor'], 404);
    }

    return response()->json($reviews, 200);
}
    /**
     * عرض جميع التقييمات المرتبطة بطالب معين.
     */
    public function getReviewsByStudent($studentId)
    {
        $reviews = Review::with(['course', 'instructor'])
            ->where('student_id', $studentId)
            ->get();

        if ($reviews->isEmpty()) {
            return response()->json(['message' => 'No reviews found for this student'], 404);
        }

        return response()->json($reviews, 200);
    }


    public function getTopReviews()
    {
        $reviews = Review::with('student', 'course')
            ->orderBy('course_rating', 'desc') 
            ->limit(3) 
            ->get();

        return view('reviews.index', compact('reviews'));
    }

    // public function getTopReviews(Request $request)
    // {
    //     $limit = $request->query('limit', 10); // تحديد عدد التقييمات (افتراضي: 10)
    //     $reviews = Review::with(['course', 'instructor', 'student'])
    //         ->orderBy('course_rating', 'desc') // ترتيب بناءً على تقييم الكورس
    //         ->orderBy('instructor_rating', 'desc') // ترتيب ثانوي بناءً على تقييم الأستاذ
    //         ->limit($limit)
    //         ->get();

    //     if ($reviews->isEmpty()) {
    //         return response()->json(['message' => 'No top reviews found'], 404);
    //     }

    //     return response()->json($reviews, 200);
    // }

    /**
     * عرض التقييمات ضمن نطاق زمني.
     */
    public function getReviewsByDateRange(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $reviews = Review::with(['course', 'instructor', 'student'])
            ->whereBetween('created_at', [$request->start_date, $request->end_date])
            ->get();

        if ($reviews->isEmpty()) {
            return response()->json(['message' => 'No reviews found in the specified date range'], 404);
        }

        return response()->json($reviews, 200);
    }

    /**
     * عرض التقييمات بتفاصيل مختصرة.
     */
    public function getBriefReviews()
    {
        $reviews = Review::select('id', 'course_id', 'instructor_id', 'student_id', 'course_rating', 'instructor_rating', 'created_at')
            ->with(['course:id,name', 'instructor:id,name', 'student:id,name'])
            ->get();

        if ($reviews->isEmpty()) {
            return response()->json(['message' => 'No reviews found'], 404);
        }

        return response()->json($reviews, 200);
    }
}