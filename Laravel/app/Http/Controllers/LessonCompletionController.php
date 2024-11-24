<?php

namespace App\Http\Controllers;

use App\Models\LessonCompletion;
use Illuminate\Http\Request;

class LessonCompletionController extends Controller
{
    public function index()
    {
        return LessonCompletion::with(['enrollment', 'lesson'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        return LessonCompletion::create($validated);
    }

    public function destroy(LessonCompletion $lessonCompletion)
    {
        $lessonCompletion->delete();
        return response()->noContent();
    }
}
