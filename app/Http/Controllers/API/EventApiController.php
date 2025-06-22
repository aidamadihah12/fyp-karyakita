<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventApiController extends Controller
{
    // GET /api/events
    public function index()
    {
        return response()->json(Event::all(), 200);
    }

    // GET /api/events/{id}
    public function show($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }
        return response()->json($event, 200);
    }

    // POST /api/events
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'event_date' => 'required|date',
            'available_slots' => 'required|integer',
            'image' => 'nullable|string',
            'location' => 'nullable|string',
            'package_type' => 'nullable|string',
            'customer_id' => 'nullable|exists:users,id',
            'venue_id' => 'nullable|exists:venues,id',
        ]);

        $event = Event::create($validated);

        return response()->json(['message' => 'Event created', 'event' => $event], 201);
    }

    // PUT/PATCH /api/events/{id}
    public function update(Request $request, $id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'event_date' => 'sometimes|required|date',
            'available_slots' => 'sometimes|required|integer',
            'image' => 'nullable|string',
            'location' => 'nullable|string',
            'package_type' => 'nullable|string',
            'customer_id' => 'nullable|exists:users,id',
            'venue_id' => 'nullable|exists:venues,id'
        ]);

        $event->update($validated);

        return response()->json(['message' => 'Event updated', 'event' => $event], 200);
    }

    // DELETE /api/events/{id}
    public function destroy($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $event->delete();

        return response()->json(['message' => 'Event deleted'], 200);
    }

    private function formatBooking($booking)
{
    $event = $booking->event;

    return [
        'id' => $booking->id,
        'event_type' => $booking->event_type,
        'status' => $booking->status,
        'total_amount' => $booking->total_amount,
        'event_date' => optional($booking->event_date)->format('Y-m-d'),
        'time' => $booking->time,
        'location' => $booking->location,
        'location_url' => $booking->location_url,
        'note' => $booking->note,
        'created_at' => optional($booking->created_at)->toIso8601String(),
        'updated_at' => optional($booking->updated_at)->toIso8601String(),
        'user' => $booking->user,
        'event' => [
            'id' => $event->id,
            'name' => $event->name,
            'price' => $event->price,
            'desc' => $event->desc,
            'event_date' => $event->event_date,
            'image' => $event->image
                ? asset('storage/' . ltrim($event->image, '/'))
                : null,
        ],
        'photographer' => $booking->photographer,
    ];
}

}
