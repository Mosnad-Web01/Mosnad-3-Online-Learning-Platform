<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthLogingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseCategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonCompletionController;
use App\Http\Controllers\CourseUserController;
use App\Http\Controllers\PaymentController;

// مسار لـ CSRF Cookie (لـ Sanctum)
Route::middleware('web')->get('/sanctum/csrf-cookie', function (Request $request) {
    return response()->json(['message' => 'CSRF token set', 'cookie' => $request]);
});


// مجموعة المسارات الخاصة بـ API
Route::middleware('web')->group(function () {
 
    // مسارات عامة لا تتطلب مصادقة
    Route::post('/login', [AuthLogingController::class, 'login']);
    Route::post('/register', [AuthLogingController::class, 'register']);
    Route::post('/logout', [AuthLogingController::class, 'logout']);

    // مسارات الدورات
    Route::prefix('courses')->group(function () {
        Route::post('/', [CourseController::class, 'store']);
        Route::get('/', [CourseController::class, 'index']);
        Route::get('{id}', [CourseController::class, 'show']);
        Route::put('{id}', [CourseController::class, 'update']);
        Route::delete('{id}', [CourseController::class, 'destroy']);
    });

    // مسارات الفئات
    Route::prefix('categories')->group(function () {
        Route::post('/', [CourseCategoryController::class, 'store']);
        Route::get('/', [CourseCategoryController::class, 'index']);
        Route::get('{id}', [CourseCategoryController::class, 'show']);
        Route::put('{id}', [CourseCategoryController::class, 'update']);
        Route::delete('{id}', [CourseCategoryController::class, 'destroy']);
    });


    // المسارات التي تتطلب مصادقة باستخدام Sanctum
    Route::middleware('auth:sanctum')->group(function () {

        // مسارات المستخدمين
        Route::resource('/users', UserController::class);

        // مسارات الدروس
        Route::prefix('courses/{courseId}/lessons')->name('courses.lessons.')->group(function () {
            Route::post('/', [LessonController::class, 'store'])->name('store');
            Route::get('/', [LessonController::class, 'index'])->name('index');
            Route::get('{lessonId}', [LessonController::class, 'show'])->name('show');
            Route::put('{lessonId}', [LessonController::class, 'update'])->name('update');
            Route::delete('{lessonId}', [LessonController::class, 'destroy'])->name('destroy');
        });

        // ملف تعريف المستخدم
        Route::prefix('user-profiles')->group(function () {
            Route::get('/', [UserProfileController::class, 'index']);
            Route::post('/', [UserProfileController::class, 'store']);
            Route::get('/{id}', [UserProfileController::class, 'show']);
            Route::put('/{id}', [UserProfileController::class, 'update']);
            Route::delete('/{id}', [UserProfileController::class, 'destroy']);
            Route::post('/{userId}/upload-image', [UserProfileController::class, 'uploadImage']);
        });

        // مسارات المشرفين
        Route::prefix('admin')->middleware('role:admin')->group(function () {
            Route::get('/dashboard', [AdminController::class, 'dashboard']);
            Route::get('/users', [AdminController::class, 'listUsers']);
        });

        // مسارات المعلمين
        Route::prefix('instructor')->middleware('role:instructor')->group(function () {
            Route::get('/courses', [InstructorController::class, 'myCourses']);
            Route::post('/course', [InstructorController::class, 'createCourse']);
        });
    // مسارات الالتحاق بالدورات
    Route::prefix('enrollments')->middleware('auth')->group(function () {
        // تسجيل طالب في دورة
        Route::post('/courses/{courseId}/enroll', [EnrollmentController::class, 'enroll'])
            ->name('enrollments.enroll');

        // تحديث تقدم الطالب في الدورة
        Route::patch('/courses/{courseId}/progress', [EnrollmentController::class, 'updateProgress'])
            ->name('enrollments.updateProgress');

        // الحصول على جميع تسجيلات الطالب
        Route::get('/courses', [EnrollmentController::class, 'getStudentEnrollments'])
            ->name('enrollments.getStudentEnrollments');

        // الحصول على معلومات تسجيل معينة
        Route::get('/courses/{courseId}', [EnrollmentController::class, 'getEnrollment'])
            ->name('enrollments.getEnrollment');
    });
        // مسارات إكمال الدروس
        Route::prefix('lesson-completions')->group(function () {
            Route::get('/', [LessonCompletionController::class, 'index']);
            Route::post('/', [LessonCompletionController::class, 'store']);
            Route::delete('{lessonCompletion}', [LessonCompletionController::class, 'destroy']);
        });

        // مسارات المستخدم والدورات
        Route::prefix('course-user')->group(function () {
            Route::post('/', [CourseUserController::class, 'store']);
            Route::get('/', [CourseUserController::class, 'index']);
            Route::get('{id}', [CourseUserController::class, 'show']);
            Route::put('{id}', [CourseUserController::class, 'update']);
            Route::delete('{id}', [CourseUserController::class, 'destroy']);
        });

        // مسارات الدفع
        Route::prefix('payments')->group(function () {
            Route::post('/', [PaymentController::class, 'store']);
            Route::get('/', [PaymentController::class, 'index']);
            Route::get('{id}', [PaymentController::class, 'show']);
            Route::put('{id}', [PaymentController::class, 'update']);
            Route::delete('{id}', [PaymentController::class, 'destroy']);
        });

        // مسارات المراجعات
        Route::prefix('reviews')->group(function () {
            Route::get('/', [ReviewController::class, 'index']);
            Route::get('{id}', [ReviewController::class, 'show']);
            Route::post('/', [ReviewController::class, 'store']);
            Route::put('{id}', [ReviewController::class, 'update']);
            Route::delete('{id}', [ReviewController::class, 'destroy']);
            Route::get('/course/{courseId}', [ReviewController::class, 'getReviewsByCourse']);
            Route::get('/instructor/{instructorId}', [ReviewController::class, 'getReviewsByInstructor']);
        });
    });
});
