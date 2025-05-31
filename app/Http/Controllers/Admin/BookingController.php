<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    // Display all bookings
    public function index()
    {
        $bookings = Booking::with('event')->get();  // Get all bookings with their associated events
        return view('admin.bookings.index', compact('bookings'));
    }

    // Show the form to create a new booking
    public function create()
    {
        $events = Event::all(); // Fetch all events for the select dropdown
        return view('admin.bookings.create', compact('events'));
    }

    // Store a new booking
    public function store(Request $request)
{
    // Validate the form input
    $request->validate([
        'event_id' => 'required|exists:events,id', // Ensure event_id exists in the events table
        'event_date' => 'required|date',
        'status' => 'required|string|in:Pending,Confirmed,Completed',
    ]);

    // Retrieve the event by ID
    $event = Event::findOrFail($request->event_id);

    // Ensure the user is authenticated
    $user_id = auth()->id();  // Get the ID of the currently logged-in user

    // Ensure the event has a price
    if ($event->price === null) {
        return redirect()->back()->with('error', 'The selected event does not have a valid price.');
    }

    // Create the new booking and include the user_id and event price
    Booking::create([
        'user_id' => $user_id,   // Add the user_id here
        'event_id' => $event->id,
        'event_type' => $event->name,
        'event_date' => $request->event_date,
        'total_amount' => $event->price,  // Use the event price here
        'status' => $request->status,
    ]);

    // Redirect back to the booking index with success message
    return redirect()->route('admin.bookings.index')->with('success', 'Booking created successfully');
}

    // Show the details of a booking
    public function show($id)
    {
         $booking = Booking::with('event')->findOrFail($id);
    dd($booking);  // Check if total_amount is populated
    return view('admin.bookings.show', compact('booking'));
    }

    // Show the form to edit a booking
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $events = Event::all(); // Fetch all events
        return view('admin.bookings.edit', compact('booking', 'events'));
    }

    // Update the booking
    public function update(Request $request, $id)
    {
        // Validate the form input
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'event_date' => 'required|date',
            'status' => 'required|string|in:Pending,Confirmed,Completed',
        ]);

        $booking = Booking::findOrFail($id);
        $event = Event::findOrFail($request->event_id);

        // Update the booking
        $booking->update([
            'event_id' => $event->id,
            'event_type' => $event->name,
            'event_date' => $request->event_date,
            'total_amount' => $event->total_amount,  // Update total amount based on event price
            'status' => $request->status,
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully');
    }

    // Delete a booking
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully');
    }
}
