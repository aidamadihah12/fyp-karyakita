<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AssignmentNotification;

class BookingController extends Controller
{
    public function index()
    {
        // Removed 'venue'
        $bookings = Booking::with(['user', 'event', 'photographer'])->get();
        return response()->json(['success' => true, 'data' => $bookings]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
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
            'user_id' => $validated['user_id'],
            'event_id' => $event->id,
            'event_type' => $event->type ?? 'N/A',
            'event_date' => $validated['event_date'],
            'note' => $validated['note'] ?? null,
            'total_amount' => $event->price ?? 0,
            'status' => $validated['status'],
            'time' => $validated['time'],
            'location' => $validated['location'] ?? null,
            'location_url' => $validated['location_url'] ?? null,
            'photographer_id' => $validated['photographer_id'] ?? null,
        ]);

        return response()->json(['success' => true, 'message' => 'Booking created successfully.', 'data' => $booking]);
    }

    public function show($id)
    {
        // Removed 'venue'
        $booking = Booking::with(['user', 'event', 'photographer'])->findOrFail($id);
        return response()->json(['success' => true, 'data' => $booking]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id', // changed from customer_id
            'event_id' => 'required|exists:events,id',
            'event_date' => 'required|date',
            'status' => 'required|string|in:Pending,Confirmed,Completed,Assigned',
            'note' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'location_url' => 'nullable|url|max:255',
            'photographer_id' => 'nullable|exists:users,id',
        ]);

        $booking = Booking::findOrFail($id);
        $event = Event::findOrFail($validated['event_id']);

        $booking->update([
            'user_id' => $validated['user_id'],
            'event_id' => $event->id,
            'event_type' => $event->type ?? 'N/A',
            'event_date' => $validated['event_date'],
            'note' => $validated['note'] ?? null,
            'total_amount' => $event->price ?? 0,
            'status' => $validated['status'],
            'location' => $validated['location'] ?? null,
            'location_url' => $validated['location_url'] ?? null,
            'photographer_id' => $validated['photographer_id'] ?? null,
        ]);

        return response()->json(['success' => true, 'message' => 'Booking updated successfully.', 'data' => $booking]);
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json(['success' => true, 'message' => 'Booking deleted successfully.']);
    }

    public function confirmBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'Paid';
        $booking->save();

        if (!$booking->payment) {
            Payment::create([
                'booking_id' => $booking->id,
                'payment_date' => now(),
                'payment_method' => 'Online Banking',
                'amount' => $booking->total_amount ?? 0,
                'status' => 'Successful',
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Booking confirmed and payment recorded.']);
    }

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

        return response()->json(['success' => true, 'message' => 'Photographer assigned successfully.', 'data' => $booking]);
    }
}
