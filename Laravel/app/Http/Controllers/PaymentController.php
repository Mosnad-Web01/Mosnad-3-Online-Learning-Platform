<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Models\CourseUser;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;


class PaymentController extends Controller
{
    // إضافة دفعية جديدة
    public function store(Request $request)
    {
        $validator = $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_user_id' => 'required|exists:course_user,id',
            'amount' => 'required|numeric',
            'status' => 'required|in:pending,completed,failed',
            'payment_date' => 'required|date',
        ]);

        try {
            $payment = Payment::create($request->all());
            return response()->json(['message' => 'Payment successfully created', 'data' => $payment], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create payment', 'details' => $e->getMessage()], 500);
        }
    }

    // عرض جميع المدفوعات
    public function index()
    {
        $payments = Payment::with('user', 'courseUser')->get();
        return response()->json($payments);
    }

    // عرض دفعة معينة
    public function showPaymentPage($courseId)
{
    // تحقق مما إذا كان المستخدم مسجلاً دخوله
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
    }

    $course = Course::findOrFail($courseId);

    // استرجاع course_user المرتبط بالـ course و الـ user
    $courseUser = CourseUser::where('course_id', $courseId)
                            ->where('user_id', Auth::user()->id)  // assuming the user is logged in
                            ->firstOrFail();

    return view('courses.payment', compact('course', 'courseUser'));
}


    // تحديث دفعة معينة
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $request->validate([
            'amount' => 'required|numeric',
            'status' => 'required|in:pending,completed,failure',
            'payment_date' => 'required|date',
        ]);

        $payment->update([
            'amount' => $request->amount,
            'status' => $request->status,
            'payment_date' => $request->payment_date,
        ]);

        return response()->json(['message' => 'Payment updated successfully', 'data' => $payment]);
    }

    // حذف دفعة
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return response()->json(['message' => 'Payment deleted successfully']);
    }
}
