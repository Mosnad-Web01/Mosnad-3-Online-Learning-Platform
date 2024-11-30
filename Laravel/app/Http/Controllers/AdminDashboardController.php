<?php
// app/Http/Controllers/AdminDashboardController.php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(): Factory|View {
  // استرجاع بيانات خاصة بالإدارة
  $adminData = [
    'usersCount' => \App\Models\User::count(),
    'coursesCount' => \App\Models\Course::count(),
];
    return view('admin.dashboard', compact('adminData'));

    }
}
