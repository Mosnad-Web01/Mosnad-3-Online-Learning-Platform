<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\InstructorDashboardController;
use App\Http\Controllers\AdminDashboardController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// تعريف التوجيه للمسؤول
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// تعريف التوجيه للمعلم
Route::middleware(['auth', 'role:instructor'])->group(function () {
    Route::get('/dashboard/instructor', [InstructorDashboardController::class, 'index'])->name('instructor.dashboard');
});
Route::get('/', [HomeController::class, 'index'])->name('home');

// روت صفحة تسجيل الدخول
Route::get('/login', [LoginController::class, 'create'])->name('login');

// روت صفحة إنشاء حساب
Route::get('/signup', [SignupController::class, 'create'])->name('signup');


