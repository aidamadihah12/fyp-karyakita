<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use App\Models\Venue;

class BookingController extends Controller
{
    /**
     * Get all bookings with related models.
     */
    public function index()
    {
    $bookings = Booking::with(['event', 'user', 'venue', 'freelancer'])
            ->get()
            ->map(function ($booking) {
                return $this->formatBooking($booking);
            });

        return response()->json([
            'success' => true,
            'data' => $bookings
        ]);
    }

    /**
     * Show a specific booking.
     */
    public function show($id)
    {
        $booking = Booking::with(['event', 'venue'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $this->formatBooking($booking)
        ]);
    }

    /**
     * Create a new booking.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'venue_id' => 'required|exists:venues,id',
            'event_type' => 'required|string',
            'status' => 'nullable|string',
            'total_amount' => 'nullable|string',
            'event_date' => 'required|date',
            'location' => 'nullable|string',
            'location_url' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        $booking = Booking::create($validated);

        return response()->json([
            'success' => true,
            'data' => $this->formatBooking($booking->load('event', 'venue'))
        ]);
    }

    /**
     * Update a booking.
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $this->formatBooking($booking->load('event', 'venue'))
        ]);
    }

    /**
     * Delete a booking.
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Format a booking for API response.
     */
    private function formatBooking($booking)
    {
        return [
            'id' => $booking->id,
            'user_id' => $booking->user_id,
            'event_id' => $booking->event_id,
            'venue_id' => $booking->venue_id,
            'event_type' => $booking->event_type,
            'assigned_staff_id' => $booking->assigned_staff_id,
            'status' => $booking->status,
            'total_amount' => $booking->total_amount,
            'event_date' => optional($booking->event_date)->toISOString(),
            'location' => $booking->location,
            'location_url' => $booking->location_url,
            'note' => $booking->note,
            'created_at' => optional($booking->created_at)->toISOString(),
            'updated_at' => optional($booking->updated_at)->toISOString(),
            'customer' => $booking->user_id,
            'freelancer' => $booking->freelancer_id ?? null,

            // Nested Event object
               'event' => $booking->event ? [
            'id' => $booking->event->id,
            'name' => $booking->event->name,
            'price' => $booking->event->price,
            'available_slots' => $booking->event->available_slots,
            'image' => $booking->event->image,
            'desc' => $booking->event->desc,
            'status' => $booking->event->status,
            'customer_id' => $booking->event->customer_id,
            'event_date' => optional($booking->event->event_date)->toISOString(),
            'created_at' => optional($booking->event->created_at)->toISOString(),
            'updated_at' => optional($booking->event->updated_at)->toISOString(),
            ] : null,
        ];
    }
}
