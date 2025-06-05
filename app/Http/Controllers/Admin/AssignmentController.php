<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\User;
use App\Models\Event;

class AssignmentController extends Controller
{
// inside index method
public function index()
{
    // Get customers, e.g., users with 'Customer' role, eager load related event dates if needed
    $customers = User::role('Customer')->get();

    // Freelancers as before
    $freelancers = User::role('Freelance')->get();

    return view('admin.assignments.index', compact('customers', 'freelancers'));
}


public function assign(Request $request)
{
    $request->validate([
        'event_id' => 'required|exists:events,id',
        'freelancer_id' => 'required|exists:users,id',
    ]);

    Assignment::updateOrCreate(
        ['event_id' => $request->event_id],
        ['freelancer_id' => $request->freelancer_id]
    );

    return redirect()->route('assignments.index')->with('success', 'Freelancer assigned successfully.');
}

}
