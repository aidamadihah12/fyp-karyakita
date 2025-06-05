<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\User;
use App\Models\Event;

class AssignmentController extends Controller
{
    public function index()
    {
        // Load customers with their events (assuming one event per customer)
        $customers = User::role('Customer')->with('event')->get();
        $freelancers = User::role('Freelance')->get();

        return view('admin.assignments.index', compact('customers', 'freelancers'));
    }

    public function assign(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'freelancer_id' => 'required|exists:users,id',
            'booking_id' => 'required|exists:bookings,id',
        ]);


        $request->validate([
            'event_id' => 'required|exists:events,id',
            'freelancer_id' => 'required|exists:users,id',
            'booking_id' => 'required|exists:bookings,id', // ADD THIS
        ]);


        return redirect()->route('assignments.index')->with('success', 'Freelancer assigned successfully.');
    }
}
