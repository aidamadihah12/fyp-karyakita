<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Assignment;

class AdminController extends Controller
{
    // ===== DASHBOARD =====
    public function dashboard()
    {
        $usersCount = User::count();
        $bookingsCount = Booking::count();
        $totalPayments = Payment::sum('amount');
        $pendingBookings = Booking::where('status', 'Pending')->count();

        $recentBookings = Booking::with('customer')
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();

        return view('admin.dashboard', compact(
            'usersCount', 'bookingsCount', 'totalPayments', 'pendingBookings', 'recentBookings'
        ));
    }

    // ===== CALENDAR PAGE =====
    public function calendar()
    {
        $bookings = Booking::with('customer')->get();

        $events = $bookings->map(function ($b) {
            $userFullName = $b->customer ? $b->customer->full_name : 'No Customer';

            return [
                'title' => $b->event_type . ' - ' . $userFullName,
                'start' => $b->event_date,
                'url'   => route('admin.bookings.show', $b->id),
                'color' => $b->status === 'Pending' ? '#ffc107' :
                          ($b->status === 'Confirmed' ? '#28a745' : '#6c757d'),
            ];
        });

        return view('admin.calendar', ['events' => $events]);
    }

    // ===== USERS MANAGEMENT =====
    public function indexUsers()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function editUsers($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUsers(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'user_role' => 'required|in:Admin,Staff,Photographer',
        ]);
        $user->update($request->only(['full_name', 'email', 'user_role']));

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroyUsers($id)
    {
        User::destroy($id);
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    // ===== BOOKINGS MANAGEMENT =====
    public function indexBookings()
    {
        $bookings = Booking::with('customer')->paginate(10);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function editBookings($id)
    {
        $booking = Booking::findOrFail($id);
        return view('admin.bookings.edit', compact('booking'));
    }

    public function updateBookings(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $request->validate([
            'event_type' => 'required|string|max:50',
            'event_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'status' => 'required|in:Pending,Confirmed,Completed',
        ]);
        $booking->update($request->only(['event_type', 'event_date', 'total_amount', 'status']));

        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function destroyBookings($id)
    {
        Booking::destroy($id);
        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully.');
    }

    // ===== PAYMENTS MANAGEMENT =====
    public function indexPayments()
    {
        $payments = Payment::with('booking.customer')->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    public function showPayments($id)
    {
        $payment = Payment::with('booking.customer')->findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }

    // ===== REPORTS =====
    public function reports(Request $request)
    {
        return view('admin.reports.index');
    }

    // ===== EVENTS UPDATE =====
    public function updateEvents(Request $request)
    {
        return redirect()->back()->with('success', 'Events updated successfully.');
    }

    // ===== PROFIT ANALYTICS =====
    public function profitAnalytics(Request $request)
    {
        $profits = Payment::selectRaw('SUM(amount) as total_revenue, DATE(created_at) as date')
                          ->groupBy('date')
                          ->orderBy('date', 'desc')
                          ->get();

        return view('admin.profit.analytics', compact('profits'));
    }

    // ===== SYSTEM TESTING =====
    public function systemTesting()
    {
        try {
            \DB::connection()->getPdo();
            $testResults = "Database connection: SUCCESS\n";
        } catch (\Exception $e) {
            $testResults = "Database connection: FAILED - " . $e->getMessage() . "\n";
        }

        return redirect()->back()->with('testResults', $testResults);
    }

    public function show($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return redirect()->route('admin.bookings.index')->with('error', 'Booking not found');
        }

        return view('admin.bookings.show', compact('booking'));
    }

    public function showAssignments()
    {
        $assignments = Assignment::with('freelancer')->paginate(10);
        $freelancers = User::where('role', 'Freelance')->get();

        return view('admin.assignments.index', compact('assignments', 'freelancers'));
    }

    public function assignFreelancer(Request $request, $assignmentId)
    {
        $request->validate([
            'freelancer_id' => 'required|exists:users,id',
        ]);

        $assignment = Assignment::findOrFail($assignmentId);
        $assignment->freelancer_id = $request->freelancer_id;
        $assignment->status = 'assigned';
        $assignment->save();

        return redirect()->back()->with('success', 'Freelance photographer assigned successfully.');
    }
}
