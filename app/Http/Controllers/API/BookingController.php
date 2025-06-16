<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    // GET: List all bookings with relations
    public function index()
    {
        $bookings = Booking::with([
            'user:id,name,email',
            'venue:id,name,address',
            'event:id,name,type,price' // include event details if needed
        ])->get();

        return response()->json([
            'success' => true,
            'data' => $bookings,
        ]);
    }

    // POST: Store a new booking
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'event_date' => 'required|date',
            'status' => 'required|string|in:Pending,Confirmed,Completed',
            'note' => 'nullable|string',
            'location' => 'nullable|string',
            'location_url' => 'nullable|url',
        ]);

        $event = Event::findOrFail($request->event_id);

        $booking = Booking::create([
            'event_id' => $event->id,
            'event_type' => $event->type ?? 'N/A',
            'event_date' => Carbon::parse($request->event_date)->toDateString(),
            'note' => $request->note,
            'total_amount' => $event->price ?? 0,
            'status' => $request->status,
            'user_id' => auth()->id() ?? null,
            'location' => $request->location,
            'location_url' => $request->location_url,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully',
            'data' => $booking,
        ], 201);
    }

    // PUT/PATCH: Update existing booking
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'event_date' => 'required|date',
            'status' => 'required|string|in:Pending,Confirmed,Completed',
            'note' => 'nullable|string',
            'location' => 'nullable|string',
            'location_url' => 'nullable|url',
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
            'user_id' => $request->customer_id,
            'event_id' => $event->id,
            'event_type' => $event->type ?? 'N/A',
            'event_date' => Carbon::parse($request->event_date)->toDateString(),
            'note' => $request->note,
            'total_amount' => $event->price ?? 0,
            'status' => $request->status,
            'location' => $request->location,
            'location_url' => $request->location_url,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking updated successfully',
            'data' => $booking,
        ]);
    }

    // DELETE: Delete a booking
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
