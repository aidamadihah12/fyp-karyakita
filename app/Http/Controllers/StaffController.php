<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Inquiry;  // We'll assume you have this model for client inquiries
use Illuminate\Support\Facades\Session;

class StaffController extends Controller
{
    // Show staff dashboard summary page
    public function dashboard()
    {
        $pendingBookingsCount = Booking::where('status', 'Pending')->count();
        $inquiriesCount = Inquiry::count();

        return view('staff.dashboard', compact('pendingBookingsCount', 'inquiriesCount'));
    }

    // ===== Manage Bookings =====
    public function bookings()
    {
        $bookings = Booking::with('user')->paginate(10);
        return view('staff.bookings.index', compact('bookings'));
    }

    public function editBooking($id)
    {
        $booking = Booking::findOrFail($id);
        return view('staff.bookings.edit', compact('booking'));
    }

    public function updateBooking(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Pending,Confirmed,Completed,Cancelled',
            'total_amount' => 'required|numeric',
        ]);

        $booking->update($request->only('status', 'total_amount'));

        return redirect()->route('staff.bookings')->with('success', 'Booking updated successfully.');
    }

    // ===== Client Inquiries =====
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

    // ===== Send Notifications (basic example) =====
    public function notificationForm()
    {
        return view('staff.notifications.form');
    }

    public function sendNotification(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        // Logic to send notification (email, SMS, etc) goes here
        // For demo, we'll just flash a success message

        Session::flash('success', 'Notification sent successfully: ' . $request->message);

        return redirect()->route('staff.notifications.form');
    }

    public function liveView()
{
    return view('staff.liveview');
}

public function calendar()
{
    $bookings = \App\Models\Booking::with('user')
        ->where('assigned_staff_id', auth()->id())
        ->get();

    $events = $bookings->map(function ($b) {
        return [
            'title' => $b->event_type . ' - ' . $b->user->full_name,
            'start' => $b->event_date,
            'color' => $b->status === 'Pending' ? '#ffc107' :
                       ($b->status === 'Confirmed' ? '#28a745' : '#6c757d'),
        ];
    });

    return view('staff.calendar', ['events' => $events]);
}


}
