<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\InstructorDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\InstructorCourseController;
use App\Http\Controllers\InstructorLessonController;

/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home route (this will be the first route the user will visit)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Login routes
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Signup routes
Route::get('/signup', [SignupController::class, 'create'])->name('signup');
Route::post('/signup', [SignupController::class, 'store'])->name('signup.submit');

// Admin Dashboard route, protected by 'auth' and 'role:admin' middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// Instructor Dashboard and Course management routes
Route::middleware('auth')->prefix('instructor')->group(function () {
    // Dashboard
    Route::get('/dashboard', [InstructorDashboardController::class, 'index'])->name('instructor.dashboard');

    // Course routes
    Route::get('/courses', [InstructorCourseController::class, 'index'])->name('instructor.courses.index');
    Route::get('/courses/create', [InstructorCourseController::class, 'create'])->name('instructor.courses.create');
    Route::post('/courses', [InstructorCourseController::class, 'store'])->name('instructor.courses.store');
    Route::get('/courses/{id}/edit', [InstructorCourseController::class, 'edit'])->name('instructor.courses.edit');
    Route::put('/courses/{id}', [InstructorCourseController::class, 'update'])->name('instructor.courses.update');
    Route::delete('/courses/{id}', [InstructorCourseController::class, 'destroy'])->name('instructor.courses.destroy');

    // Lesson routes
    Route::get('/courses/{courseId}/lessons', [InstructorLessonController::class, 'index'])->name('instructor.lessons.index');
    Route::get('/courses/{courseId}/lessons/create', [InstructorLessonController::class, 'create'])->name('instructor.lessons.create');
    Route::post('/courses/{courseId}/lessons', [InstructorLessonController::class, 'store'])->name('instructor.lessons.store');
    Route::get('/courses/{courseId}/lessons/{lessonId}/edit', [InstructorLessonController::class, 'edit'])->name('instructor.lessons.edit');
    Route::put('/courses/{courseId}/lessons/{lessonId}', [InstructorLessonController::class, 'update'])->name('instructor.lessons.update');
    Route::delete('/courses/{courseId}/lessons/{lessonId}', [InstructorLessonController::class, 'destroy'])->name('instructor.lessons.destroy');
});
