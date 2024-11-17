<?php

namespace App\Http\Controllers;

use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CourseCategoryController extends Controller
{
    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:course_categories,name',
        ]);

        // Create the category record
        $category = CourseCategory::create([
            'name' => $request->name,
        ]);

        return response()->json($category, Response::HTTP_CREATED);
    }

    /**
     * Display a listing of the categories.
     */
    public function index()
{
    // جلب جميع الفئات
    $categories = CourseCategory::all();

    // إرجاع الفئات في استجابة JSON مع حالة HTTP OK
    return response()->json($categories, Response::HTTP_OK);
}

    /**
     * Display the specified category.
     */
    public function show($id)
    {
        $category = CourseCategory::find($id);

        if ($category) {
            return response()->json($category, Response::HTTP_OK);
        }

        return response()->json(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, $id)
    {
        $category = CourseCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:50|unique:course_categories,name,' . $category->id,
        ]);

        // Update category record
        $category->update([
            'name' => $request->name,
        ]);

        return response()->json($category, Response::HTTP_OK);
    }

    /**
     * Remove the specified category.
     */
    public function destroy($id)
    {
        $category = CourseCategory::findOrFail($id);

        // Delete the category
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully'], Response::HTTP_OK);
    }
}
