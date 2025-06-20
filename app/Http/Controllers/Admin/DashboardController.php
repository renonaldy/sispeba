<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function index()
    {
        return view('dashboard.index', [
            'totalProfit' => 12628,
            'totalSales' => 4679,
            'totalRevenue' => 84686,
            'growthPercentage' => 68.2,
        ]);
    }
}
