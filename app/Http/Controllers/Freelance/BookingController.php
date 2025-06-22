<?php

namespace App\Http\Controllers\Freelance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    // Display only the bookings assigned to the logged-in freelance photographer
    public function index()
    {
        $userId = auth()->id(); // Current logged-in freelancer ID

        $bookings = Booking::with(['user', 'event', 'freelancer', 'venue'])
            ->where('freelancer_id', $userId)
            ->latest()
            ->paginate(10);

        return view('freelance.manage-bookings', compact('bookings'));
    }
}
