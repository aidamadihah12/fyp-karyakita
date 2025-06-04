<?php

namespace App\Http\Controllers\API;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    // Get all bookings with related event data
    public function index()
    {
        $bookings = Booking::with(['event', 'customer', 'venue', 'freelancer'])->get();

        return response()->json([
            'success' => true,
            'data' => $bookings,
        ]);
    }

    // Store a new booking
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'event_id' => 'required|exists:events,id',
            'venue_id' => 'nullable|exists:venues,id',
            'date' => 'required|date',
            'status' => 'required|string|in:Pending,Confirmed,Completed',
            'note' => 'nullable|string',
            'package' => 'nullable|string',
        ]);

        $event = Event::findOrFail($request->event_id);

        $booking = Booking::create([
            'customer_id' => $request->customer_id,
            'event_id' => $event->id,
            'venue_id' => $request->venue_id,
            'date' => $request->date,
            'package' => $request->package ?? null,
            'note' => $request->note ?? null,
            'total_amount' => $event->price,
            'status' => $request->status,
            // 'user_id' => auth()->id() ?? null, // Uncomment if API authentication is used
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully',
            'data' => $booking,
        ], 201);
    }

    // Update a booking
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'event_id' => 'required|exists:events,id',
            'venue_id' => 'nullable|exists:venues,id',
            'date' => 'required|date',
            'status' => 'required|string|in:Pending,Confirmed,Completed,Assigned',
            'note' => 'nullable|string',
            'package' => 'nullable|string',
        ]);

        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found',
            ], 404);
        }

        $event = Event::findOrFail($request->event_id);

        $booking->update([
            'customer_id' => $request->customer_id,
            'event_id' => $event->id,
            'venue_id' => $request->venue_id,
            'date' => $request->date,
            'package' => $request->package ?? null,
            'note' => $request->note ?? null,
            'total_amount' => $event->price,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking updated successfully',
            'data' => $booking,
        ]);
    }

    // Delete a booking
    public function destroy($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found',
            ], 404);
        }

        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Booking deleted successfully',
        ]);
    }
}
