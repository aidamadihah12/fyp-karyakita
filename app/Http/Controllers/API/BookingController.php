<?php

namespace App\Http\Controllers\API;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    // Validation rules extracted to a private method
    private function validationRules(): array
    {
        return [
            'customer_id' => ['required', 'exists:customers,id'],
            'event_id' => ['required', 'exists:events,id'],
            'venue_id' => ['nullable', 'exists:venues,id'],
            'date' => ['required', 'date'],
            'status' => ['required', 'string', Rule::in(['Pending', 'Confirmed', 'Completed', 'Assigned'])],
            'note' => ['nullable', 'string'],
            'package' => ['nullable', 'string'],
        ];
    }

    // List all bookings with related data
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
        $validated = $request->validate($this->validationRules());

        $event = Event::findOrFail($validated['event_id']);

        $booking = Booking::create([
            //'customer_id' => $validated['customer_id'],
            'event_id' => $event->id,
            'venue_id' => $validated['venue_id'] ?? null,
            'date' => $validated['date'],
            'package' => $validated['package'] ?? null,
            'note' => $validated['note'] ?? null,
            'total_amount' => $event->price,
            'status' => $validated['status'],
            'user_id' => auth()->id() ?? null, // Uncomment if API authentication is used
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully',
            'data' => $booking,
        ], 201);
    }

    // Show a single booking
    public function show(Booking $booking)
    {
        $booking->load(['event', 'customer', 'venue', 'freelancer']);

        return response()->json([
            'success' => true,
            'data' => $booking,
        ]);
    }

    // Update an existing booking
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate($this->validationRules());

        $event = Event::findOrFail($validated['event_id']);

        $booking->update([
            'customer_id' => $validated['customer_id'],
            'event_id' => $event->id,
            'venue_id' => $validated['venue_id'] ?? null,
            'date' => $validated['date'],
            'package' => $validated['package'] ?? null,
            'note' => $validated['note'] ?? null,
            'total_amount' => $event->price,
            'status' => $validated['status'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking updated successfully',
            'data' => $booking,
        ]);
    }

    // Delete a booking
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Booking deleted successfully',
        ]);
    }
}
