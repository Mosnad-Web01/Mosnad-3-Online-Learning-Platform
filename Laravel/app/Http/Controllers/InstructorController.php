<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorController extends Controller
{
    // دالة لعرض الدورات التي يدرسها المعلم الحالي
    public function myCourses()
    {
        // الحصول على المستخدم المصادق عليه (المعلم)
        $instructor = Auth::user();

        // جلب الدورات التي يدرسها المعلم
        $courses = Course::where('instructor_id', $instructor->id)->get();

        // إرجاع الدورات كـ JSON
        return response()->json($courses);
    }
}
