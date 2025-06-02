<?php

namespace App\Http\Controllers\API;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    // Get all bookings
    public function index()
    {
        $bookings = Booking::with('event')->get();
        return response()->json($bookings);
    }

    // Store a new booking
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'event_date' => 'required|date',
            'status' => 'required|string|in:Pending,Confirmed,Completed',
        ]);

        $booking = Booking::create([
            'event_id' => $request->event_id,
            'event_date' => $request->event_date,
            'status' => $request->status,
        ]);

        return response()->json($booking, 201);
    }

    // Update a booking
    public function update(Request $request, $id)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'event_date' => 'required|date',
            'status' => 'required|string|in:Pending,Confirmed,Completed',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update([
            'event_id' => $request->event_id,
            'event_date' => $request->event_date,
            'status' => $request->status,
        ]);

        return response()->json($booking);
    }

    // Delete a booking
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully']);
    }
}
