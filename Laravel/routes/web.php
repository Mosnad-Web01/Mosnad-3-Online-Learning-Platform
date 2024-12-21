<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    HomeController,
    WebProfileController,
    WebAuthController,
    AdminDashboardController,
    InstructorDashboardController,
    InstructorCourseController,
    InstructorLessonController,
    CourseUserController,
    CourseController,
    InstructorCategoryController,
    AdminLessonController,
    AdminCourseController,
    AdminCategoryController,
    AdminController,
    InstructorController,
    StudentController,
    AdminUserController,
    ProgressController,
    WebReviewController,
    ContactController

};

// مجموعة مسارات الويب
Route::middleware('web')->group(function () {

    // إعداد ملف تعريف CSRF
    Route::get('/sanctum/csrf-cookie', function () {
        return response()->json(['message' => 'CSRF cookie set']);
    });

    // المسار الرئيسي للصفحة الرئيسية
    Route::get('/', [HomeController::class, 'home'])->name('home');

    // مسارات تسجيل الدخول والخروج
    Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [WebAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');
    Route::get('/signup', [WebAuthController::class, 'showRegister'])->name('signup');
    Route::post('/signup', [WebAuthController::class, 'register'])->name('signup.submit');

    
    Route::post('/admin/logout', [AdminController::class, 'logout']);
    Route::post('/instructor/logout', [InstructorController::class, 'logout']);

    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    
    // // مسارات تسجيل المستخدم الجديد
    // Route::get('/signup', [SignupController::class, 'create'])->name('signup');
    // Route::post('/signup', [SignupController::class, 'store'])->name('signup.submit');


    // مسار الرد على المراجعة
    Route::post('/reviews/{review}/reply', [WebReviewController::class, 'storeReply'])->name('reviews.reply');
    
    // مسار الرد على الرد
    Route::post('/replies/{reply}/reply', [WebReviewController::class, 'storeReplyToReply'])->name('replies.replyToReply');

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
        Route::get('/profile/form', [WebProfileController::class, 'showForm'])->name('profile.form');
        Route::post('/profile', [WebProfileController::class, 'store'])->name('profile.store');
        Route::put('/profile/{id}', [WebProfileController::class, 'update'])->name('profile.update');
        

        Route::resource('/reviews', WebReviewController::class);

        Route::get('/reviews/student/{studentId}', [WebReviewController::class, 'getReviewsByStudent']);
        Route::get('/reviews/top', [WebReviewController::class, 'getTopReviews']);
        Route::get('/reviews/date-range', [WebReviewController::class, 'getReviewsByDateRange']);
        Route::get('/reviews/brief', [WebReviewController::class, 'getBriefReviews']);
        
        
        // مسارات لوحة التحكم للمدرب
        Route::prefix('instructor')
         ->middleware(['role:Admin,Instructor'])
        ->group(function () {
            // لوحة تحكم المدرب
            Route::get('/dashboard', [InstructorDashboardController::class, 'index'])->name('instructor.dashboard');

            Route::resource('profile', WebProfileController::class);

            // مسارات إدارة الدورات التدريبية
            Route::get('/courses', [InstructorCourseController::class, 'index'])->name('instructor.courses.index');
            Route::get('/courses/create', [InstructorCourseController::class, 'create'])->name('instructor.courses.create');
            Route::post('/courses', [InstructorCourseController::class, 'store'])->name('instructor.courses.store');
            Route::get('/courses/{id}/edit', [InstructorCourseController::class, 'edit'])->name('instructor.courses.edit');
            Route::put('/courses/{id}', [InstructorCourseController::class, 'update'])->name('instructor.courses.update');
            Route::delete('/courses/{id}', [InstructorCourseController::class, 'destroy'])->name('instructor.courses.destroy');

            // مسارات إدارة الدروس
            Route::get('/courses/{courseId}/lessons', [InstructorLessonController::class, 'index'])->name('instructor.lessons.index');
            Route::get('/courses/{courseId}/lessons/create', [InstructorLessonController::class, 'create'])->name('instructor.lessons.create');
            Route::post('/courses/{courseId}/lessons', [InstructorLessonController::class, 'store'])->name('instructor.lessons.store');
            Route::get('/courses/{courseId}/lessons/{lessonId}/edit', [InstructorLessonController::class, 'edit'])->name('instructor.lessons.edit');
            Route::put('/courses/{courseId}/lessons/{lessonId}', [InstructorLessonController::class, 'update'])->name('instructor.lessons.update');
            Route::delete('/courses/{courseId}/lessons/{lessonId}', [InstructorLessonController::class, 'destroy'])->name('instructor.lessons.destroy');
            Route::delete('/lessons/{courseId}/{lessonId}/images/{imageIndex}', [InstructorLessonController::class, 'deleteImage'])
             ->name('instructor.lessons.deleteImage');
             Route::get('/lessons/{lesson}/video', [InstructorLessonController::class, 'addVideo'])->name('lessons.addVideo');
             Route::post('/lessons/{lesson}/video', [InstructorLessonController::class, 'storeVideo'])->name('lessons.storeVideo');

             Route::get('/lessons/{lessonId}/video', [InstructorLessonController::class, 'viewVideo'])->name('instructor.lessons.view_video');

                
             //Instructor students
             Route::get('/students', [StudentController::class, 'index'])->name('students.index');
             Route::get('/course/{courseId}/StudentChart', [StudentController::class, 'showChart'])->name('progress.chart');
             Route::get('/course/{courseId}/student/{studentId}/progress', [StudentController::class, 'show'])->name('progress.course');

             //reviews
             


             // مسارات إدارة الطلاب
             // ملف routes/web.php

            Route::get('/courses/{courseId}/students', [CourseUserController::class, 'index'])->name('instructor.students.index');
            Route::get('/courses/{courseId}/students/{studentId}/edit', [CourseUserController::class, 'edit'])->name('instructor.students.edit');
            Route::put('/courses/{courseId}/students/{studentId}', [CourseUserController::class, 'update'])->name('instructor.students.update');
            Route::delete('/courses/{courseId}/students/{studentId}', [CourseUserController::class, 'destroy'])->name('instructor.students.destroy');
        });

        // مسارات لوحة تحكم الإدمن
        Route::prefix('admin')->name('admin.')
        ->middleware(['role:Admin'])
        ->group(function () {

            // لوحة تحكم الإدمن
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

            // مسارات إدارة فئات الكورسات
            Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
            Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
            Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
            Route::get('/categories/{id}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
            Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
            Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

            // مسارات إدارة الدورات
            Route::get('/courses', [AdminCourseController::class, 'index'])->name('courses.index');
            Route::get('/courses/create', [AdminCourseController::class, 'create'])->name('courses.create');
            Route::post('/courses', [AdminCourseController::class, 'store'])->name('courses.store');
            Route::get('/courses/{id}/edit', [AdminCourseController::class, 'edit'])->name('courses.edit');
            Route::put('/courses/{id}', [AdminCourseController::class, 'update'])->name('courses.update');
            Route::delete('/courses/{id}', [AdminCourseController::class, 'destroy'])->name('courses.destroy');
        
            // مسارات إدارة الدروس

            Route::get('/students', [StudentController::class, 'index'])->name('students.index');

            // مسارات إدارة الدروس
            Route::get('/courses/{courseId}/lessons', [AdminLessonController::class, 'index'])->name('lessons.index');
            Route::get('/courses/{courseId}/lessons/create', [AdminLessonController::class, 'create'])->name('lessons.create');
            Route::post('/courses/{courseId}/lessons', [AdminLessonController::class, 'store'])->name('lessons.store');
            Route::get('/courses/{courseId}/lessons/{lessonId}/edit', [AdminLessonController::class, 'edit'])->name('lessons.edit');
            Route::put('/courses/{courseId}/lessons/{lessonId}', [AdminLessonController::class, 'update'])->name('lessons.update');
            Route::delete('/courses/{courseId}/lessons/{lessonId}', [AdminLessonController::class, 'destroy'])->name('lessons.destroy');

            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
            Route::resource('/users', AdminUserController::class);

        });
    });

    // مسارات إضافية متعلقة بالدورات التدريبية
    Route::get('courses/{course}', [CourseController::class, 'showDetails'])->name('courses.show');
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');

    // مسارات تصنيف المدرب
    Route::prefix('instructor')->middleware('auth')->name('instructor.')->group(function () {
        Route::resource('categories', InstructorCategoryController::class);
    });

});
