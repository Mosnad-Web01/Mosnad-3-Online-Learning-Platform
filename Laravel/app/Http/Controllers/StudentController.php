<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    // دالة لحساب تقدم الطالب
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

        // استخدام ProgressController لحساب التقدم
        $progressController = new ProgressController();
        foreach ($instructor->courses as $course) {
            $course->students = $course->students->unique('id'); // إزالة التكرار
        
            foreach ($course->students as $student) {
                $enrollmentId = $student->pivot->id;
                // حساب التقدم باستخدام ProgressController
                $progress = $progressController->calculateProgress($enrollmentId);
        
                // تأكد من أن التقدم ليس NULL قبل التحديث
                if ($progress !== null) {
                    // تحديث التقدم في الجدول الوسيط (pivot)
                    $student->pivot->update(['progress' => $progress]);
                } else {
                    // إذا كان التقدم NULL، يمكنك تعيين قيمة افتراضية مثل 0
                    $student->pivot->update(['progress' => 0]);
                }
            }
        }


        // عرض الصفحة مع البيانات
        return view('instructor.students.index', compact('instructor'));
    }
}
