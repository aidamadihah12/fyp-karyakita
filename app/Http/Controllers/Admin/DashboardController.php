<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $usersCount = User::count();
        $bookingsCount = Booking::count();
        $totalPayments = Payment::sum('amount');
        $pendingBookings = Booking::where('status', 'Pending')->count();

        $recentBookings = Booking::with('user')
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();

        return view('admin.dashboard', compact(
            'usersCount', 'bookingsCount', 'totalPayments', 'pendingBookings', 'recentBookings'
        ));
    }
}
