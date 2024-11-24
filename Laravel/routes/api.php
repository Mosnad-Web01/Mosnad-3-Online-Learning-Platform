<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseCategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonCompletionController;
use App\Http\Controllers\CourseUserController;
use App\Http\Controllers\PaymentController;

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


// Routes for Enrollments (Course Tracking)
Route::prefix('enrollments')->group(function () {
    Route::get('/', [EnrollmentController::class, 'index']); // عرض جميع التسجيلات مع تقدمها
    Route::post('/', [EnrollmentController::class, 'store']); // تسجيل طالب في دورة
    Route::put('{enrollment}', [EnrollmentController::class, 'update']); // تحديث تقدم دورة أو تاريخ الإتمام
    Route::delete('{enrollment}', [EnrollmentController::class, 'destroy']); // حذف تسجيل
});

// Routes for Lesson Completions (Lesson Tracking)
Route::prefix('lesson-completions')->group(function () {
    Route::get('/', [LessonCompletionController::class, 'index']); // عرض جميع إكمالات الدروس
    Route::post('/', [LessonCompletionController::class, 'store']); // تسجيل إكمال درس لطالب
    Route::delete('{lessonCompletion}', [LessonCompletionController::class, 'destroy']); // حذف إكمال درس
});
// Routes for Course User (Enrollment)
Route::prefix('course-user')->group(function () {
    Route::post('/', [CourseUserController::class, 'store']);  // تسجيل دورة جديدة
    Route::get('/', [CourseUserController::class, 'index']);   // عرض جميع التسجيلات
    Route::get('{id}', [CourseUserController::class, 'show']);  // عرض تسجيل معين
    Route::put('{id}', [CourseUserController::class, 'update']); // تحديث تسجيل معين
    Route::delete('{id}', [CourseUserController::class, 'destroy']); // حذف تسجيل
});

// Routes for Payments
Route::prefix('payments')->group(function () {
    Route::post('/', [PaymentController::class, 'store']);  // إضافة دفعية
    Route::get('/', [PaymentController::class, 'index']);   // عرض جميع المدفوعات
    Route::get('{id}', [PaymentController::class, 'show']);  // عرض دفعة معينة
    Route::put('{id}', [PaymentController::class, 'update']); // تحديث دفعة
    Route::delete('{id}', [PaymentController::class, 'destroy']); // حذف دفعة
});
