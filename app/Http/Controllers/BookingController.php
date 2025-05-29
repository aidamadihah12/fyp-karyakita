<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AssignmentNotification;
use Illuminate\Support\Facades\Log;  // Add Log facade

class BookingController extends Controller
{
    // Display all bookings
    public function index()
    {
        // Eager load event relationship to show event info in booking list
        $bookings = Booking::with('event')->get();  // Retrieve all bookings
        $events = Event::all();  // Retrieve all events

        // Log the retrieved bookings data
        Log::info('Bookings Retrieved:', $bookings->toArray());

        return view('admin.bookings.index', compact('bookings', 'events'));
    }

    // Show the form for creating a new booking
    public function create()
    {
        $events = Event::all();  // Get all events for the dropdown
        return view('admin.bookings.create', compact('events'));
    }

    // Store a newly created booking
    public function store(Request $request)
    {
        // Log the incoming form data for debugging
        Log::info('Form Data for Booking Store:', $request->all());

        // Validate the incoming request data
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'event_date' => 'required|date',
            'status' => 'required|string|in:Pending,Confirmed,Completed',
        ]);

        // Find the event by ID
        $event = Event::findOrFail($request->event_id);

        // Create the new booking
        $booking = Booking::create([
            'event_id' => $event->id,
            'event_type' => $event->name,
            'event_date' => $request->event_date,
            'total_amount' => $event->price,
            'status' => $request->status,
        ]);

        // Log the newly created booking data
        Log::info('Booking Created:', $booking->toArray());

        // Redirect to the bookings index with a success message
        return redirect()->route('admin.bookings.index')->with('success', 'Booking added successfully');
    }

    // Display the details of a specific booking
    public function show($id)
    {
        // Find the booking with the event details
        $booking = Booking::with('event')->find($id);

        if (!$booking) {
            return redirect()->route('admin.bookings.index')->with('error', 'Booking not found');
        }

        return view('admin.bookings.show', compact('booking'));
    }

    // Show the form for editing a specific booking
    public function edit($id)
    {
        // Find the booking by ID and all events
        $booking = Booking::find($id);
        $events = Event::all();

        if (!$booking) {
            return redirect()->route('admin.bookings.index')->with('error', 'Booking not found');
        }

        return view('admin.bookings.edit', compact('booking', 'events'));
    }

    // Update the specified booking
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'event_date' => 'required|date',
            'status' => 'required|string|in:Pending,Confirmed,Completed',
        ]);

        // Find the booking by ID
        $booking = Booking::find($id);
        if (!$booking) {
            return redirect()->route('admin.bookings.index')->with('error', 'Booking not found');
        }

        // Find the event and update the booking
        $event = Event::findOrFail($request->event_id);
        $booking->update([
            'event_id' => $event->id,
            'event_type' => $event->name,
            'event_date' => $request->event_date,
            'total_amount' => $event->price,
            'status' => $request->status,
        ]);

        // Log the updated booking data
        Log::info('Booking Updated:', $booking->toArray());

        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully');
    }

    // Delete the specified booking
    public function destroy($id)
    {
        // Find the booking by ID and delete it
        $booking = Booking::find($id);
        if (!$booking) {
            return redirect()->route('admin.bookings.index')->with('error', 'Booking not found');
        }

        // Delete the booking
        $booking->delete();

        // Log the deletion
        Log::info('Booking Deleted:', ['booking_id' => $booking->id]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully');
    }

    // Show the form to assign a freelancer (photographer) to the booking
    public function assignForm($id)
    {
        $booking = Booking::findOrFail($id);
        $freelancers = User::where('role', 'freelance')->get();

        return view('admin.bookings.assign', compact('booking', 'freelancers'));
    }

    // Store the assignment of a freelancer to the booking
    public function assignStore(Request $request, $id)
    {
        // Validate the freelancer ID
        $request->validate([
            'freelancer_id' => 'required|exists:users,id',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->freelancer_id = $request->freelancer_id;
        $booking->status = 'Assigned';
        $booking->save();

        // Send a notification to the freelancer
        Notification::route('mail', $booking->freelancer->email)
            ->notify(new AssignmentNotification($booking));

        // Log the assignment
        Log::info('Freelancer Assigned to Booking:', [
            'booking_id' => $booking->id,
            'freelancer_id' => $booking->freelancer_id,
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Photographer assigned successfully.');
    }

    // Show the list of bookings with assigned freelancers
    public function showAssignmentList()
    {
        $bookings = Booking::with('freelancer')->whereNotNull('freelancer_id')->latest()->get();

        return view('admin.bookings.assignment-list', compact('bookings'));
    }
}
