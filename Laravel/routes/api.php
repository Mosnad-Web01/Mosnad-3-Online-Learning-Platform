<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseCategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\UserProfileController;

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

// مسارات عامة لا تتطلب مصادقة
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);



// مسارات تتطلب مصادقة باستخدام Sanctum
Route::middleware('auth:sanctum')->group(function () {
    // معلومات المستخدم العام
    Route::get('/user', [UserController::class, 'show']);
    Route::post('/logout', [AuthController::class, 'logout']);
  // ملف تعريف المستخدم

  Route::middleware('auth:sanctum')->group(function () {
      Route::get('/user-profiles', [UserProfileController::class, 'index']); // عرض جميع الـ Profiles
      Route::post('/user-profiles', [UserProfileController::class, 'store']); // إضافة Profile جديد
      Route::get('/user-profiles/{id}', [UserProfileController::class, 'show']); // عرض Profile محدد
      Route::put('/user-profiles/{id}', [UserProfileController::class, 'update']); // تحديث Profile محدد
      Route::delete('/user-profiles/{id}', [UserProfileController::class, 'destroy']); // حذف Profile محدد
      Route::post('/user-profile/{userId}/upload-image', [UserProfileController::class, 'uploadImage']);

  });
  
    // مسارات خاصة بالمشرفين فقط
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/admin/users', [AdminController::class, 'listUsers']);
        // يمكنك إضافة المزيد من المسارات هنا خاصة بالمشرف
    });

    // مسارات خاصة بالمعلمين فقط
    Route::middleware(['role:instructor'])->group(function () {
        Route::get('/instructor/courses', [InstructorController::class, 'myCourses']);
        Route::post('/instructor/course', [InstructorController::class, 'createCourse']);
        // يمكنك إضافة المزيد من المسارات هنا خاصة بالمعلم
    });

    // // مسارات خاصة بالطلاب فقط
    // Route::middleware(['role:student'])->group(function () {
    //     Route::get('/student/courses', [StudentController::class, 'enrolledCourses']);
    //     Route::post('/student/enroll', [StudentController::class, 'enrollCourse']);
    //     // يمكنك إضافة المزيد من المسارات هنا خاصة بالطالب
    // });
});

// مسار للحصول على معلومات المستخدم المصادق
Route::middleware('auth:sanctum')->get('/authenticated-user', function (Request $request) {
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


