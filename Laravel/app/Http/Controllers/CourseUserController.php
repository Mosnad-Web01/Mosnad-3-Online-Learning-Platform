<?php

namespace App\Http\Controllers;

use App\Models\CourseUser;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseUserController extends Controller
{
    // إضافة تسجيل دورة للطالب
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $courseUser = CourseUser::create([
            'user_id' => $request->user_id,
            'course_id' => $request->course_id,
        ]);

        return response()->json(['message' => 'Course enrollment created successfully', 'data' => $courseUser], 201);
    }

    // عرض جميع التسجيلات (منح الطلاب الدورات)
    public function index()
    {
        $courseUsers = CourseUser::with('user', 'course')->get();
        return response()->json($courseUsers);
    }

    // عرض تسجيل معين
    public function show($id)
    {
        $courseUser = CourseUser::with('user', 'course')->findOrFail($id);
        return response()->json($courseUser);
    }

    // تحديث تسجيل الدورة
    public function update(Request $request, $id)
    {
        $courseUser = CourseUser::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $courseUser->update([
            'user_id' => $request->user_id,
            'course_id' => $request->course_id,
        ]);

        return response()->json(['message' => 'Course enrollment updated successfully', 'data' => $courseUser]);
    }

    // حذف تسجيل الدورة
    public function destroy($id)
    {
        $courseUser = CourseUser::findOrFail($id);
        $courseUser->delete();

        return response()->json(['message' => 'Course enrollment deleted successfully']);
    }
}
