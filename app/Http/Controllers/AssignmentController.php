<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\User;
use App\Models\Event;

class AssignmentController extends Controller
{
    public function index()
{
    $events = Event::where('status', 'pending')->get(); // or any filter
    $freelancers = User::role('Freelance')->get(); // Assuming you use Spatie Roles

    return view('admin.assignments.index', compact('events', 'freelancers'));
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
