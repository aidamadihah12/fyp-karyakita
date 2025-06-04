<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AssignmentNotification;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    // Display all bookings with pagination
    public function index()
    {
        // Use 'customer' relationship instead of 'user'
        $bookings = Booking::with(['event', 'customer', 'freelancer', 'venue'])
            ->latest()
            ->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

public function create()
{
    $events = Event::all();
    $customers = User::where('user_role', 'customer')->get(); // Only customers
    $venues = Venue::all();

    return view('admin.bookings.create', compact('events', 'customers', 'venues'));
}



    // Store new booking
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'venue_id' => 'nullable|exists:venues,id',
            'event_date' => 'required|date',
            'status' => 'required|string|in:Pending,Confirmed,Completed',
            'note' => 'nullable|string',
        ]);

        $event = Event::findOrFail($validated['event_id']);

        $booking = Booking::create([
            'customer_id' => $validated['user_id'],  // Make sure Booking model uses customer_id
            'event_id' => $event->id,
            'venue_id' => $validated['venue_id'] ?? null,
            'date' => $validated['event_date'],
            'status' => $validated['status'],
            'note' => $validated['note'] ?? null,
            'total_amount' => $event->price,
        ]);

        Log::info('Booking created', $booking->toArray());

        return redirect()->route('admin.bookings.index')->with('success', 'Booking created successfully.');
    }

    // Show single booking details
    public function show($id)
    {
        $booking = Booking::with(['event', 'customer', 'freelancer', 'venue'])->findOrFail($id);

        return view('admin.bookings.show', compact('booking'));
    }

    // Show edit form
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $events = Event::all();
        $users = User::all();
        $venues = Venue::all();

        return view('admin.bookings.edit', compact('booking', 'events', 'users', 'venues'));
    }

    // Update booking
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'venue_id' => 'nullable|exists:venues,id',
            'event_date' => 'required|date',
            'status' => 'required|string|in:Pending,Confirmed,Completed,Assigned',
            'note' => 'nullable|string',
        ]);

        $booking = Booking::findOrFail($id);
        $event = Event::findOrFail($validated['event_id']);

        $booking->update([
            'customer_id' => $validated['user_id'],
            'event_id' => $event->id,
            'venue_id' => $validated['venue_id'] ?? null,
            'date' => $validated['event_date'],
            'status' => $validated['status'],
            'note' => $validated['note'] ?? null,
            'total_amount' => $event->price,
        ]);

        Log::info('Booking updated', $booking->toArray());

        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully.');
    }

    // Delete booking
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        Log::info('Booking deleted', ['booking_id' => $id]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully.');
    }

    // Show form to assign a freelancer photographer to booking
    public function assignForm($id)
    {
        $booking = Booking::findOrFail($id);
        $freelancers = User::where('user_role', 'freelance')->get();

        return view('admin.bookings.assign', compact('booking', 'freelancers'));
    }

    // Store assignment of freelancer photographer
    public function assignStore(Request $request, $id)
    {
        $request->validate([
            'freelancer_id' => 'required|exists:users,id',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->freelancer_id = $request->freelancer_id;
        $booking->status = 'Assigned';
        $booking->save();

        // Notify the freelancer
        Notification::route('mail', $booking->freelancer->email)
            ->notify(new AssignmentNotification($booking));

        Log::info('Freelancer assigned', [
            'booking_id' => $booking->id,
            'freelancer_id' => $booking->freelancer_id,
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Photographer assigned successfully.');
    }

    // List bookings with assigned freelancers
    public function showAssignmentList()
    {
        $bookings = Booking::with('freelancer')->whereNotNull('freelancer_id')->latest()->paginate(10);

        return view('admin.bookings.assignment-list', compact('bookings'));
    }
}
