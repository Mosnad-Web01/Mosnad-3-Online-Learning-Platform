<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        return Enrollment::with(['course', 'student', 'completions'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'student_id' => 'required|exists:users,id',
        ]);

        return Enrollment::create($validated);
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'progress' => 'nullable|integer|min:0|max:100',
            'completion_date' => 'nullable|date',
        ]);

        $enrollment->update($validated);

        return $enrollment;
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return response()->noContent();
    }
}
