<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;

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
    public function index()
    {
        // الحصول على المستخدم المصادق عليه
        $user = Auth::user();
    
        // التحقق من أن المستخدم لديه دور المعلم
        if (!$user || $user->role !== 'Instructor') {
            return redirect()->back()->with('error', 'Access denied.');
        }
    
        // استخراج بيانات المعلم مع دوراته وطلابه
        $instructor = User::with(['courses.students'])->find($user->id);
    
        if (!$instructor) {
            return redirect()->back()->with('error', 'Instructor not found.');
        }
    
        // عرض الصفحة مع البيانات
        return view('instructor.students.index', compact('instructor'));
    }
    
     // دالة لتسجيل الخروج
     public function logout(Request $request)
     {
         Auth::logout(); // تسجيل الخروج
         $request->session()->invalidate(); // تعطيل الجلسة الحالية
         $request->session()->regenerateToken(); // تجديد التوكن

         return response()->json(['message' => 'تم تسجيل الخروج بنجاح']);
     }
}
