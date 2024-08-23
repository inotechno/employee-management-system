<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $daily_reports = DailyReport::all()->count();

        return view('dashboard', compact('daily_reports'));
    }
}
