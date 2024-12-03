<?php

namespace App\Http\Controllers;

use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InstructorCategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        // جلب الفئات
        $categories = CourseCategory::all();

        return view('instructor.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('instructor.categories.create');
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:course_categories,name',
        ]);

        if ($validator->fails()) {
            return redirect()->route('instructor.categories.create')
                             ->withErrors($validator)
                             ->withInput();
        }

        // إنشاء الفئة
        CourseCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('instructor.categories.index')
                         ->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit($id)
    {
        // جلب الفئة بناءً على المعرف
        $category = CourseCategory::findOrFail($id);

        return view('instructor.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in the database.
     */
    public function update(Request $request, $id)
    {
        // التحقق من صحة البيانات
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:course_categories,name,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->route('instructor.categories.edit', $id)
                             ->withErrors($validator)
                             ->withInput();
        }

        // جلب الفئة بناءً على المعرف
        $category = CourseCategory::findOrFail($id);

        // تحديث الفئة
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('instructor.categories.index')
                         ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from the database.
     */
    public function destroy($id)
    {
        // جلب الفئة بناءً على المعرف
        $category = CourseCategory::findOrFail($id);

        // حذف الفئة
        $category->delete();

        return redirect()->route('instructor.categories.index')
                         ->with('success', 'Category deleted successfully.');
    }
}
