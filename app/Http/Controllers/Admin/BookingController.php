<?php

// App\Http\Controllers\Admin\BookingController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AssignmentNotification;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['event', 'customer', 'freelancer', 'venue'])
            ->latest()->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $events = Event::all();
        $customers = User::where('user_role', 'customer')->get();
        $venues = Venue::all();

        return view('admin.bookings.create', compact('events', 'customers', 'venues'));
    }

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

        Booking::create([
            'customer_id' => $validated['user_id'],
            'event_id' => $event->id,
            'venue_id' => $validated['venue_id'],
            'date' => $validated['event_date'],
            'status' => $validated['status'],
            'note' => $validated['note'],
            'total_amount' => $event->price,
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking created successfully.');
    }

    public function show($id)
    {
        $booking = Booking::with(['event', 'customer', 'freelancer', 'venue'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $events = Event::all();
        $users = User::all();
        $venues = Venue::all();

        return view('admin.bookings.edit', compact('booking', 'events', 'users', 'venues'));
    }

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
            'venue_id' => $validated['venue_id'],
            'date' => $validated['event_date'],
            'status' => $validated['status'],
            'note' => $validated['note'],
            'total_amount' => $event->price,
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully.');
    }

    public function assignForm($id)
    {
        $booking = Booking::findOrFail($id);
        $freelancers = User::where('user_role', 'freelance')->get();

        return view('admin.bookings.assign', compact('booking', 'freelancers'));
    }

    public function assignStore(Request $request, $id)
    {
        $request->validate([
            'freelancer_id' => 'required|exists:users,id',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->freelancer_id = $request->freelancer_id;
        $booking->status = 'Assigned';
        $booking->save();

        Notification::route('mail', $booking->freelancer->email)
            ->notify(new AssignmentNotification($booking));

        return redirect()->route('admin.bookings.index')->with('success', 'Photographer assigned successfully.');
    }

    public function showAssignmentList()
    {
        $bookings = Booking::with('freelancer')->whereNotNull('freelancer_id')->latest()->paginate(10);
        return view('admin.bookings.assignment-list', compact('bookings'));
    }
}
