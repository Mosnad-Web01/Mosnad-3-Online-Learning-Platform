<?php
// app/Http/Controllers/AdminDashboardController.php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(): Factory|View {

        return view('admin.dashboard'); // عرض الصفحة الخاصة بالمسؤول
    }
}
