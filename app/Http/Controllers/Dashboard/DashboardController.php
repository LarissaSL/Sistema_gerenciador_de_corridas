<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $title = 'Dashboard';
        $userName = Auth::user()->name;

        return view('dashboard.dashboard', compact('userName', 'title'));
    }
}
