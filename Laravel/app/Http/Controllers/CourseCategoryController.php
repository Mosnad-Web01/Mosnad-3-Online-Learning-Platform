<?php

namespace App\Http\Controllers;

use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // التحقق من الصورة
            'description' => 'nullable|string|max:255', // التحقق من الوصف
        ]);

        // تخزين الصورة إذا كانت موجودة
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('public/categories/' . $request->name, $imageName); // تخزين الصورة داخل مجلد خاص بالفئة
        }

        // إنشاء السجل الخاص بالفئة
        $category = CourseCategory::create([
            'name' => $request->name,
            'image' => $imagePath,  // حفظ مسار الصورة
            'description' => $request->description,  // حفظ الوصف
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string|max:255',
        ]);

        // تخزين الصورة الجديدة إذا كانت موجودة
        $imagePath = $category->image; // حفظ المسار الحالي
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($imagePath && Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }

            $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('public/categories/' . $category->name, $imageName); // تخزين الصورة داخل مجلد الفئة
        }

        // تحديث الفئة
        $category->update([
            'name' => $request->name,
            'image' => $imagePath,  // تحديث مسار الصورة
            'description' => $request->description,  // تحديث الوصف
        ]);

        return response()->json($category, Response::HTTP_OK);
    }

    /**
     * Remove the specified category.
     */
    public function destroy($id)
    {
        $category = CourseCategory::findOrFail($id);

        // حذف الصورة المرتبطة بالفئة
        if ($category->image && Storage::exists($category->image)) {
            Storage::delete($category->image);
        }

        // حذف الفئة
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully'], Response::HTTP_OK);
    }
}
