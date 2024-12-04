<?php

namespace App\Http\Controllers;

use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('instructor.categories.create')
                             ->withErrors($validator)
                             ->withInput();
        }

        // تخزين الصورة إذا كانت موجودة
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('public/categories/' . $request->name, $imageName); // تخزين الصورة داخل مجلد الفئة
        }

        // إنشاء الفئة
        CourseCategory::create([
            'name' => $request->name,
            'image' => $imagePath,  // حفظ مسار الصورة
            'description' => $request->description,  // حفظ الوصف
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('instructor.categories.edit', $id)
                             ->withErrors($validator)
                             ->withInput();
        }

        // جلب الفئة بناءً على المعرف
        $category = CourseCategory::findOrFail($id);

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

        // حذف الصورة المرتبطة بالفئة
        if ($category->image && Storage::exists($category->image)) {
            Storage::delete($category->image);
        }

        // حذف الفئة
        $category->delete();

        return redirect()->route('instructor.categories.index')
                         ->with('success', 'Category deleted successfully.');
    }
}
