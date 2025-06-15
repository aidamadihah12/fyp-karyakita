<?php

// App\Http\Controllers\Admin\BookingController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AssignmentNotification;


class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'event', 'venue', 'photographer'])->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $events = Event::all();
        $customers = User::where('user_role', 'customer')->get();
        $venues = Venue::all();
        $photographers = User::whereIn('user_role', ['freelance', 'staff'])->get();


        return view('admin.bookings.create', compact('events', 'customers', 'venues', 'photographers'));
    }



   public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'venue_id' => 'required|exists:venues,id',
        'event_id' => 'required|exists:events,id',
        'event_date' => 'required|date',
        'status' => 'required|string|in:Pending,Confirmed,Completed,Assigned',
        'note' => 'nullable|string',
        'time' => 'required',
        'location' => 'nullable|string|max:255',
        'location_url' => 'nullable|url|max:255',
        'photographer_id' => 'nullable|exists:users,id',

    ]);

    $event = Event::findOrFail($validated['event_id']);

    Booking::create([
        'user_id'       => $validated['user_id'],
        'venue_id'      => $validated['venue_id'],
        'event_id'      => $event->id,
        'event_type'    => $event->type ?? 'N/A',
        'event_date'    => $validated['event_date'],
        'note'          => $validated['note'] ?? null,
        'total_amount'  => $event->price,
        'status'        => $validated['status'],
        'time'          => $validated['time'],
        'location'      => $validated['location'] ?? null,
        'location_url'  => $validated['location_url'] ?? null,
        'photographer_id' => $validated['photographer_id'] ?? null,

    ]);

    return redirect()->route('admin.bookings.index')->with('success', 'Booking created successfully.');
}

    public function show($id)
    {
        $booking = Booking::with(['user', 'venue', 'event', 'photographer'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit($id)
    {
    $booking = Booking::findOrFail($id);
    $users = User::all();
    $events = Event::all();
    $venues = Venue::all();
    $photographers = User::whereIn('user_role', ['staff', 'freelance'])->get();

        return view('admin.bookings.edit', compact('booking', 'events', 'users', 'venues', 'photographers'));
    }

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'customer_id' => 'required|exists:users,id',
        'event_id' => 'required|exists:events,id',
        'date' => 'required|date',
        'status' => 'required|string|in:Pending,Confirmed,Completed,Assigned',
        'note' => 'nullable|string',
        'location' => 'nullable|string|max:255',
        'location_url' => 'nullable|url|max:255',
        'photographer_id'  => 'nullable|exists:users,id',

    ]);



    $booking = Booking::findOrFail($id);
    $event = Event::findOrFail($validated['event_id']);

    $booking->update([
        'user_id'       => $validated['customer_id'],
        'event_id'      => $event->id,
        'event_type'    => $event->type ?? 'N/A',
        'event_date'    => $validated['date'],
        'note'          => $validated['note'] ?? null,
        'total_amount'  => $event->price,
        'status'        => $validated['status'],
        'location'      => $validated['location'] ?? null,
        'location_url'  => $validated['location_url'] ?? null,
        'photographer_id' => $validated['photographer_id'] ?? null,

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
        $photographers = User::whereIn('user_role', ['staff', 'freelance'])->get();

        return view('admin.bookings.assign', compact('booking', 'photographers'));
    }

public function assignStore(Request $request, $id)
{
    $request->validate([
        'photographer_id' => 'required|exists:users,id',
    ]);

    $booking = Booking::findOrFail($id);
    $booking->photographer_id = $request->photographer_id; // ← UPDATED
    $booking->status = 'Assigned';
    $booking->save();

    // Optional: Notify the photographer if email exists
    if ($booking->photographer && $booking->photographer->email) {
        Notification::route('mail', $booking->photographer->email)
            ->notify(new AssignmentNotification($booking));
    }

    return redirect()->route('admin.bookings.index')->with('success', 'Photographer assigned successfully.');
}

    public function showAssignmentList()
    {
        $bookings = Booking::with('freelancer')->whereNotNull('freelancer_id')->latest()->paginate(10);
        return view('admin.bookings.assignment-list', compact('bookings'));
    }

public function confirmBooking(Request $request, $id)
{
    $booking = Booking::findOrFail($id);

    $booking->status = 'Paid';
    $booking->save();

    if (!$booking->payment) {
        Payment::create([
            'booking_id' => $booking->id,
            'payment_date' => now(),
            'payment_method' => 'Online Banking',
            'amount' => $booking->total_amount, // ← use correct column
            'status' => 'Successful',
        ]);
    }

    return redirect()->back()->with('success', 'Booking confirmed and payment recorded.');
}
public function payment()
{
    return $this->hasOne(Payment::class, 'booking_id');
}

public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}


}
