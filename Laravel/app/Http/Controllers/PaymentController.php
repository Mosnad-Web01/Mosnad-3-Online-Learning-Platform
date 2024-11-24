<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Models\CourseUser;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // إضافة دفعية جديدة
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_user_id' => 'required|exists:course_user,id',
            'amount' => 'required|numeric',
            'status' => 'required|in:pending,completed,failed',
            'payment_date' => 'required|date',
        ]);

        $payment = Payment::create([
            'user_id' => $request->user_id,
            'course_user_id' => $request->course_user_id,
            'amount' => $request->amount,
            'status' => $request->status,
            'payment_date' => $request->payment_date,
        ]);

        return response()->json(['message' => 'Payment successfully created', 'data' => $payment], 201);
    }

    // عرض جميع المدفوعات
    public function index()
    {
        $payments = Payment::with('user', 'courseUser')->get();
        return response()->json($payments);
    }

    // عرض دفعة معينة
    public function show($id)
    {
        $payment = Payment::with('user', 'courseUser')->findOrFail($id);
        return response()->json($payment);
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
