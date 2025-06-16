<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    // List all events with pagination
    public function index()
    {
        $events = Event::latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    // Show the form for creating a new event
    public function create()
    {
        return view('admin.events.create');
    }

    // Store a newly created event
    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'price' => 'required|integer|min:1',
            'available_slots' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'location_url' => 'nullable|url|max:255',
        ]);

        // Create the event
        $event = Event::create([
            'name' => $validated['name'],
            'event_date' => $validated['event_date'],
            'price' => $validated['price'],
            'available_slots' => $validated['available_slots'],
            'location_url' => $request->location_url,
        ]);

        // Handle the image upload if present
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $event->image = $imagePath;
            $event->save();
        }

        // Redirect with success message
        return redirect()->route('admin.events.index')->with('success', 'Event created successfully');
    }

    // Show the form for editing a single event
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    // Update a single event
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'price' => 'required|integer|min:1',
            'available_slots' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'location_url' => 'nullable|url|max:255',
        ]);

        $event = Event::findOrFail($id);
        $event->name = $validated['name'];
        $event->event_date = $validated['event_date'];
        $event->price = $validated['price'];
        $event->available_slots = $validated['available_slots'];
        $event->location_url = $request->location_url;

        if ($request->hasFile('image')) {
            if ($event->image) {
                \Storage::delete('public/' . $event->image);
            }

            $imagePath = $request->file('image')->store('events', 'public');
            $event->image = $imagePath;
        }

        $event->save();

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully');
    }

    // Show the details of a single event
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.show', compact('event'));
    }

    // Delete a single event
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully');
    }
}
