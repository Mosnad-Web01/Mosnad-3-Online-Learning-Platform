<?php

namespace App\Http\Controllers;

use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = CourseCategory::all(); // جلب جميع الفئات
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:course_categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.categories.create')
                ->withErrors($validator)
                ->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('public/categories/' . $request->name, $imageName);
        }

        CourseCategory::create([
            'name' => $request->name,
            'image' => $imagePath,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = CourseCategory::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:course_categories,name,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.categories.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $category = CourseCategory::findOrFail($id);
        $imagePath = $category->image;

        if ($request->hasFile('image')) {
            if ($imagePath && Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }

            $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('public/categories/' . $category->name, $imageName);
        }

        $category->update([
            'name' => $request->name,
            'image' => $imagePath,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = CourseCategory::findOrFail($id);

        if ($category->image && Storage::exists($category->image)) {
            Storage::delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
