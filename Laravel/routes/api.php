<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseCategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;

/*
|----------------------------------------------------------------------
| API Routes
|----------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes for Categories
Route::prefix('categories')->group(function () {
    Route::post('/', [CourseCategoryController::class, 'store']);
    Route::get('/', [CourseCategoryController::class, 'index']);  // تعديل هنا
    Route::get('{id}', [CourseCategoryController::class, 'show']);
    Route::put('{id}', [CourseCategoryController::class, 'update']);
    Route::delete('{id}', [CourseCategoryController::class, 'destroy']);
});

// Routes for Courses
Route::prefix('courses')->group(function () {
    Route::post('/', [CourseController::class, 'store']);
    Route::get('/', [CourseController::class, 'index']);
    Route::get('{id}', [CourseController::class, 'show']);
    Route::put('{id}', [CourseController::class, 'update']);
    Route::delete('{id}', [CourseController::class, 'destroy']);
});

Route::prefix('courses/{courseId}/lessons')->name('courses.lessons.')->group(function () {
    Route::post('/', [LessonController::class, 'store'])->name('store');
    Route::get('/', [LessonController::class, 'index'])->name('index');
    Route::get('{lessonId}', [LessonController::class, 'show'])->name('show');
    Route::put('{lessonId}', [LessonController::class, 'update'])->name('update');
    Route::delete('{lessonId}', [LessonController::class, 'destroy'])->name('destroy');
});


