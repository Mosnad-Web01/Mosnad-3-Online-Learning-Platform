<?php

// app/Http/Controllers/InstructorDashboardController.php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class InstructorDashboardController extends Controller
{
    public function index(): Factory|View {

        return view('instructor.dashboard'); // عرض الصفحة الخاصة بالمعلم
    }
}
