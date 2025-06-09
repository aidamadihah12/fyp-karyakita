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
}
