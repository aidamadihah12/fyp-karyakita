<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Session;

class StaffController extends Controller
{
    // ===== DASHBOARD =====
    public function dashboard()
    {
        $pendingBookingsCount = Booking::where('status', 'Pending')->count();
        $inquiriesCount = Inquiry::count();

        return view('staff.dashboard', compact('pendingBookingsCount', 'inquiriesCount'));
    }

    // ===== BOOKINGS =====
    public function bookings()
    {
        $bookings = Booking::with('customer')
            ->where('assigned_staff_id', auth()->id())
            ->paginate(10);

        return view('staff.bookings.index', compact('bookings'));
    }

    public function editBooking($id)
    {
        $booking = Booking::findOrFail($id);

        // Ensure only assigned staff can edit
        if ($booking->assigned_staff_id !== auth()->id()) {
            return redirect()->route('staff.bookings')->with('error', 'Unauthorized access.');
        }

        return view('staff.bookings.edit', compact('booking'));
    }

    public function updateBooking(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->assigned_staff_id !== auth()->id()) {
            return redirect()->route('staff.bookings')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'status' => 'required|in:Pending,Confirmed,Completed,Cancelled',
            'total_amount' => 'required|numeric',
        ]);

        $booking->update($request->only('status', 'total_amount'));

        return redirect()->route('staff.bookings')->with('success', 'Booking updated successfully.');
    }

    // ===== INQUIRIES =====
    public function inquiries()
    {
        $inquiries = Inquiry::orderBy('created_at', 'desc')->paginate(10);
        return view('staff.inquiries.index', compact('inquiries'));
    }

    public function showInquiry($id)
    {
        $inquiry = Inquiry::findOrFail($id);
        return view('staff.inquiries.show', compact('inquiry'));
    }

    // ===== NOTIFICATIONS =====
    public function notificationForm()
    {
        return view('staff.notifications.form');
    }

    public function sendNotification(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        Session::flash('success', 'Notification sent successfully: ' . $request->message);
        return redirect()->route('staff.notifications.form');
    }

    // ===== LIVE VIEW =====
    public function liveView()
    {
        return view('staff.liveview');
    }

   // ===== CALENDAR =====
public function calendar()
{
    $bookings = Booking::with(['customer', 'event', 'photographer'])
        ->where('assigned_staff_id', auth()->id())
        ->get();

    $events = $bookings->map(function ($b) {
        $eventName = $b->event->name ?? $b->event_type ?? 'Unnamed Event';
        $photographerName = $b->photographer->name ?? 'No Photographer';
        $customerName = $b->customer->name ?? 'Unknown';

        return [
            'title' => "{$eventName} - {$photographerName}",
            'start' => $b->event_date,
            'url' => route('staff.bookings.edit', $b->id),
            'color' => match($b->status) {
                'Pending' => '#ffc107',
                'Confirmed' => '#28a745',
                'Completed' => '#004085',
                default => '#6c757d',
            },
        ];
    });

    return view('staff.calendar', ['events' => $events]);
}

}
