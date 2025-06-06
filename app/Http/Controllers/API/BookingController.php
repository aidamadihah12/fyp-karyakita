<?php

// App\Http\Controllers\API\BookingController.php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['event', 'customer', 'venue', 'freelancer'])->get();

        return response()->json([
            'success' => true,
            'data' => $bookings,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id', // customer must exist in users table
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
            'package' => $request->package,
            'note' => $request->note,
            'total_amount' => $event->price,
            'status' => $request->status,
            'user_id' => auth()->id() ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully',
            'data' => $booking,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'venue_id' => 'nullable|exists:venues,id',
            'date' => 'required|date',
            'status' => 'required|string|in:Pending,Confirmed,Completed,Assigned',
            'note' => 'nullable|string',
            'package' => 'nullable|string',
        ]);

        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Booking not found'], 404);
        }

        $event = Event::findOrFail($request->event_id);

        $booking->update([
            'customer_id' => $request->customer_id,
            'event_id' => $event->id,
            'venue_id' => $request->venue_id,
            'date' => $request->date,
            'package' => $request->package,
            'note' => $request->note,
            'total_amount' => $event->price,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking updated successfully',
            'data' => $booking,
        ]);
    }

    public function destroy($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Booking not found'], 404);
        }

        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Booking deleted successfully',
        ]);
    }
}

