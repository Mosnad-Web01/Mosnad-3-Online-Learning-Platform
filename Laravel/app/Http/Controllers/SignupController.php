<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SignupController extends Controller
{
    public function create(): Factory|View {
        return view('auth.signup');
    }
}
