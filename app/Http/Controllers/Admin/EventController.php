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
            'date' => 'required|date',
            'price' => 'required|integer|min:1',
            'available_slots' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'location_url' => 'nullable|url|max:255',
        ]);

        // Create the event
        $event = Event::create([
            'name' => $validated['name'],
            'event_date' => $validated['date'],
            'price' => $validated['price'],
            'available_slots' => $validated['available_slots'],
            'location_url' => $validated['location_url'],
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
        // Retrieve the event by ID
        $event = Event::findOrFail($id);  // Ensure the event exists
        return view('admin.events.edit', compact('event'));
    }

    // Update a single event
    public function update(Request $request, $id)
{
    // Validate the incoming data
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'date' => 'required|date',
        'price' => 'required|integer|min:1',
        'available_slots' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'location_url' => 'nullable|url|max:255',
    ]);

    // Find the event by ID
    $event = Event::findOrFail($id);

    // Update the event data
    $event->name = $validated['name'];
    $event->date = $validated['date'];
    $event->price = $validated['price'];
    $event->available_slots = $validated['available_slots'];
    $event->location_url = $request->location_url;

    // Handle the image upload if a new image is uploaded
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($event->image) {
            \Storage::delete('public/' . $event->image);
        }

        // Store the new image
        $imagePath = $request->file('image')->store('events', 'public');
        $event->image = $imagePath;
    }

    // Save the updated event
    $event->save();

    // Redirect with success message
    return redirect()->route('admin.events.index')->with('success', 'Event updated successfully');
}

    // Show the details of a single event
    public function show($id)
    {
        // Retrieve the event by ID
        $event = Event::findOrFail($id);  // Ensure the event exists

        // Return the event details view and pass the event data
        return view('admin.events.show', compact('event'));
    }
        public function destroy($id)
    {
        // Find the event by ID
        $event = Event::findOrFail($id);

        // Delete the event
        $event->delete();

        // Redirect back to the events index page with a success message
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully');
    }
}
