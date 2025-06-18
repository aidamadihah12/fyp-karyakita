<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AssignmentNotification;
use App\Models\Payment;
use Carbon\Carbon;

class BookingController extends Controller
{
    // Get all bookings
    public function index()
    {
        $bookings = Booking::with(['user', 'event', 'venue', 'photographer'])->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $bookings,
        ]);
    }

    // Store a new booking
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'venue_id' => 'required|exists:venues,id',
            'event_id' => 'required|exists:events,id',
            'event_date' => 'required|date',
            'status' => 'required|string|in:Pending,Confirmed,Completed,Assigned',
            'note' => 'nullable|string',
            'time' => 'required',
            'location' => 'nullable|string|max:255',
            'location_url' => 'nullable|url|max:255',
            'photographer_id' => 'nullable|exists:users,id',
        ]);

        $event = Event::findOrFail($validated['event_id']);

        $booking = Booking::create([
            'user_id'        => $validated['user_id'],
            'venue_id'       => $validated['venue_id'],
            'event_id'       => $event->id,
            'event_type'     => $event->type ?? 'N/A',
            'event_date'     => Carbon::parse($validated['event_date'])->toDateString(),
            'note'           => $validated['note'] ?? null,
            'total_amount'   => $event->price,
            'status'         => $validated['status'],
            'time'           => $validated['time'],
            'location'       => $validated['location'] ?? null,
            'location_url'   => $validated['location_url'] ?? null,
            'photographer_id' => $validated['photographer_id'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully.',
            'data' => $booking,
        ], 201);
    }

    // Show specific booking
    public function show($id)
    {
        $booking = Booking::with(['user', 'event', 'venue', 'photographer'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $booking,
        ]);
    }

    // Update a booking
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'date' => 'required|date',
            'status' => 'required|string|in:Pending,Confirmed,Completed,Assigned',
            'note' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'location_url' => 'nullable|url|max:255',
            'photographer_id' => 'nullable|exists:users,id',
        ]);

        $booking = Booking::findOrFail($id);
        $event = Event::findOrFail($validated['event_id']);

        $booking->update([
            'user_id'        => $validated['customer_id'],
            'event_id'       => $event->id,
            'event_type'     => $event->type ?? 'N/A',
            'event_date'     => Carbon::parse($validated['date'])->toDateString(),
            'note'           => $validated['note'] ?? null,
            'total_amount'   => $event->price,
            'status'         => $validated['status'],
            'location'       => $validated['location'] ?? null,
            'location_url'   => $validated['location_url'] ?? null,
            'photographer_id'=> $validated['photographer_id'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking updated successfully.',
            'data' => $booking,
        ]);
    }

    // Delete a booking
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Booking deleted successfully.',
        ]);
    }

    // Assign Photographer
    public function assignPhotographer(Request $request, $id)
    {
        $request->validate([
            'photographer_id' => 'required|exists:users,id',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->photographer_id = $request->photographer_id;
        $booking->status = 'Assigned';
        $booking->save();

        if ($booking->photographer && $booking->photographer->email) {
            Notification::route('mail', $booking->photographer->email)
                ->notify(new AssignmentNotification($booking));
        }

        return response()->json([
            'success' => true,
            'message' => 'Photographer assigned successfully.',
        ]);
    }

    // Confirm and Record Payment
    public function confirmBooking(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'Paid';
        $booking->save();

        if (!$booking->payment) {
            Payment::create([
                'booking_id' => $booking->id,
                'payment_date' => now(),
                'payment_method' => 'Online Banking',
                'amount' => $booking->total_amount,
                'status' => 'Successful',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Booking confirmed and payment recorded.',
        ]);
    }
}
