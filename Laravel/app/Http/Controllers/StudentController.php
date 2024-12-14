<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProgressController; // استدعاء الكنترولر الآخر
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // تعريف الخاصية العامة
    protected $progressController;

    // تهيئة المتغير في الباني
    public function __construct()
    {
        $this->progressController = new ProgressController();
    }

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
        foreach ($instructor->courses as $course) {
            $course->students = $course->students->unique('id'); // إزالة التكرار

            foreach ($course->students as $student) {
                $enrollmentId = $student->pivot->id;
                // حساب التقدم باستخدام ProgressController
                $progress = $this->progressController->calculateProgress($enrollmentId);

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

   
    
    public function show($courseId, $studentId, Request $request)
{
    // استدعاء الدالة من ProgressController
    $data = $this->progressController->getStudentProgressData($request, $courseId, $studentId);

    // عرض الفيو وتمرير البيانات له
    return view('progress.course', $data);
}

    public function showChart($courseId, Request $request)
    {
        $data = $this->progressController->getCourseProgressData($request, $courseId);

        // إرسال المتغير إلى الـ view
        return view('progress.chart', [
            'lessonProgress' => $data['lessonProgress'],
            'lessonCounts' => $data['lessonCounts'],  // تمرير lessonCounts إلى الـ view
        ]);

    }
}

