<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payment;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Get the start and end of the current month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Count bookings this month
        $bookingsCount = Booking::whereBetween('event_date', [$startOfMonth, $endOfMonth])->count();

        // Sum payments this month
        $paymentsSum = Payment::whereBetween('payment_date', [$startOfMonth, $endOfMonth])->sum('amount');

        // Prepare the report data to pass to the view
        $reports = [
            [
                'id' => 1,
                'description' => 'Bookings this month',
                'date' => $startOfMonth->format('Y-m-d'),  // Display the first date of the month
                'value' => $bookingsCount . ' bookings',
            ],
            [
                'id' => 2,
                'description' => 'Payments collected this month',
                'date' => $startOfMonth->format('Y-m-d'),  // Display the first date of the month
                'value' => 'RM ' . number_format($paymentsSum, 2),  // Format payment sum to two decimal places
            ],
        ];

        // Return the report view with the data
        return view('admin.reports.index', compact('reports'));
    }
}
