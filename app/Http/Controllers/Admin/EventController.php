<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    // List all events with pagination (for admin.events.index)
    public function index()
    {
        $events = Event::latest()->paginate(10);  // Paginate the events to avoid overloading the page
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
        'available_slots' => 'required|integer|min:1',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Create the event
    $event = Event::create($validated);

    // Handle the image upload
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('events', 'public');
        $event->image = $imagePath;
        $event->save();
    }

    return redirect()->route('admin.events.index')->with('success', 'Event created successfully');
}



    // Show the form for editing a single event
    public function show($id)
    {
        $event = Event::findOrFail($id);  // Retrieve the event by ID
        return view('admin.events.show', compact('event'));  // Pass event data to the view
    }

    // Show the form for editing a single event
    public function showUpdateForm($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    // Update a single event
    public function update(Request $request, $id)
{
    // Validate the incoming data
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'date' => 'required|date',
        'available_slots' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
    ]);

    // Find the event by ID
    $event = Event::findOrFail($id);

    // Update the event data
    $event->name = $validated['name'];
    $event->date = $validated['date'];
    $event->available_slots = $validated['available_slots'];

    // If a new image is uploaded, store the new image
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('events', 'public');
        $event->image = $imagePath;
    }

    // Save the updated event
    $event->save();

    // Redirect back with success message
    return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
}


    // ✅ Bulk update all events at once
    public function bulkUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'events.*.name' => 'required|string|max:255',
            'events.*.date' => 'required|date',
            'events.*.available_slots' => 'required|integer|min:0',
            'events.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        foreach ($validatedData['events'] as $id => $data) {
            $event = Event::findOrFail($id);

            $event->name = $data['name'];
            $event->date = $data['date'];
            $event->available_slots = $data['available_slots'];

            if (isset($data['image'])) {
                // Handle image upload
                $path = $data['image']->store('events', 'public');
                $event->image = $path;
            }

            $event->save();
        }

        return redirect()->route('admin.events.index')->with('success', 'Events updated successfully.');
    }

       public function edit($id)
    {
        // Retrieve the event by ID
        $event = Event::findOrFail($id);

     // Return the edit view and pass the event data
    return view('admin.events.edit', compact('event'));
    }
}
