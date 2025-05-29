<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class ProfitController extends Controller
{
    // This method is called by your route for profit analytics
    public function index()
    {
        // Calculate total payments grouped by date
        $profits = Payment::selectRaw('SUM(amount) as total_revenue, DATE(created_at) as date')
                          ->groupBy('date')
                          ->orderBy('date', 'desc')
                          ->get();

        return view('admin.profit.analytics', compact('profits'));
    }

    public function profitAnalytics()
{
    $profits = DB::table('payments')
        ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as date, SUM(amount) as total_revenue')
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

    return view('admin.profit.index', compact('profits'));
}

}
