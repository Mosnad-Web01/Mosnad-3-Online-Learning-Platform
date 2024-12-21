<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Review;
use App\Models\Course;
class HomeController extends Controller
{
    public function index(): Factory|View
    {
        return view('home');
    }
    public function home(): Factory|View
    {
        $topCourses = Course::orderBy('average_rating', 'desc')->take(10)->get();
        $topInstructors = User::whereHas('instructorReviews')
            ->withAvg('instructorReviews', 'instructor_rating')
            ->orderBy('instructor_reviews_avg_instructor_rating', 'desc')
            ->take(10)->get();
        $topReviews = Review::with('student', 'course')
            ->orderBy('course_rating', 'desc')
            ->take(10)->get();
    
            return view('home', compact('topCourses', 'topInstructors', 'topReviews'));
        }
}
