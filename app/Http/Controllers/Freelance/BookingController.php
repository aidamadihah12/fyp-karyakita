<?php

namespace App\Http\Controllers\Freelance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        $userId = auth()->id(); // Get current freelance user ID

        $bookings = Booking::with(['user', 'event', 'freelancer', 'venue'])
            ->where('freelancer_id', $userId)
            ->latest()
            ->paginate(10);

        // Update this line to match your actual Blade file
        return view('freelance.bookings.index', compact('bookings'));
    }
}
