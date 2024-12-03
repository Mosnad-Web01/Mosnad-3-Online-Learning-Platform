<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    HomeController,
    SignupController,
    WebAuthController,
    AdminDashboardController,
    InstructorDashboardController,
    InstructorCourseController,
    InstructorLessonController,
    CourseUserController,
    ReviewController,
    EnrollmentController,
    LessonCompletionController,
    CourseCategoryController,
    CourseController,
    InstructorCategoryController,
    AdminUserController
};

// مجموعة مسارات الويب
Route::middleware('web')->group(function () {

    // إعداد ملف تعريف CSRF
    Route::get('/sanctum/csrf-cookie', function () {
        return response()->json(['message' => 'CSRF cookie set']);
    });

    // المسار الرئيسي للصفحة الرئيسية
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // مسارات تسجيل الدخول والخروج
    Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [WebAuthController::class, 'login'])->name('login.submit');

    // مسارات تسجيل المستخدم الجديد
    Route::get('/signup', [SignupController::class, 'create'])->name('signup');
    Route::post('/signup', [SignupController::class, 'store'])->name('signup.submit');

   

    // مجموعة مسارات مصادقة المستخدم باستخدام Sanctum
    Route::middleware(['auth:sanctum'])->group(function () {
 // مسار لوحة التحكم العام (يتحقق من المصادقة)
 Route::get('/dashboard', function () {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login');
    }
    return view('dashboard');
});
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

        // مسارات لوحة التحكم للمسؤول
        Route::prefix('admin')->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
            Route::resource('/users', AdminUserController::class);
        });

        // مسارات لوحة التحكم للمدرب
        Route::prefix('instructor')->group(function () {

            // لوحة تحكم المدرب
            Route::get('/dashboard', [InstructorDashboardController::class, 'index'])->name('instructor.dashboard');

            // مسارات إدارة الدورات التدريبية
            Route::get('/courses', [InstructorCourseController::class, 'index'])->name('instructor.courses.index');
            Route::get('/courses/create', [InstructorCourseController::class, 'create'])->name('instructor.courses.create');
            Route::post('/courses', [InstructorCourseController::class, 'store'])->name('instructor.courses.store');
            Route::get('/courses/{id}/edit', [InstructorCourseController::class, 'edit'])->name('instructor.courses.edit');
            Route::put('/courses/{id}', [InstructorCourseController::class, 'update'])->name('instructor.courses.update');
            Route::delete('/courses/{id}', [InstructorCourseController::class, 'destroy'])->name('instructor.courses.destroy');

            // مسارات إدارة الدروس
            Route::get('/instructor/courses/{courseId}/lessons', [InstructorLessonController::class, 'index'])->name('instructor.lessons.index');
            Route::get('/courses/{courseId}/lessons/create', [InstructorLessonController::class, 'create'])->name('instructor.lessons.create');
            Route::post('/courses/{courseId}/lessons', [InstructorLessonController::class, 'store'])->name('instructor.lessons.store');
            Route::get('/courses/{courseId}/lessons/{lessonId}/edit', [InstructorLessonController::class, 'edit'])->name('instructor.lessons.edit');
            Route::put('/courses/{courseId}/lessons/{lessonId}', [InstructorLessonController::class, 'update'])->name('instructor.lessons.update');
            Route::delete('/courses/{courseId}/lessons/{lessonId}', [InstructorLessonController::class, 'destroy'])->name('instructor.lessons.destroy');

            // مسارات إدارة الطلاب
            Route::get('/courses/{courseId}/students', [CourseUserController::class, 'index'])->name('instructor.students.index');
            Route::get('/courses/{courseId}/students/{studentId}/edit', [CourseUserController::class, 'edit'])->name('instructor.students.edit');
            Route::put('/courses/{courseId}/students/{studentId}', [CourseUserController::class, 'update'])->name('instructor.students.update');
            Route::delete('/courses/{courseId}/students/{studentId}', [CourseUserController::class, 'destroy'])->name('instructor.students.destroy');
        });
    });

    // مسارات إضافية متعلقة بالدورات التدريبية
    Route::get('/', [CourseController::class, 'home'])->name('home');
    Route::get('courses/{course}', [CourseController::class, 'showDetails'])->name('courses.show.details');

    // مسارات تصنيف المدرب
    Route::prefix('instructor')->middleware('auth')->name('instructor.')->group(function () {
        Route::resource('categories', InstructorCategoryController::class);
    });
});
