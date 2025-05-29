<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;   // Assuming you have this model
use App\Models\Event;        // Assuming you have this model
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;  // Import Carbon for date parsing

class FreelanceController extends Controller
{
    // Show freelancer dashboard or availability form
    public function dashboard()
    {
        // Example: Get current availability status (boolean or custom)
        $availability = auth()->user()->availability ?? false;
        return view('freelance.dashboard', compact('availability'));
    }

    // Show form to update availability
    public function editAvailability()
    {
        $availability = auth()->user()->availability ?? false;
        return view('freelance.availability', compact('availability'));
    }

    // Handle availability update form submission
    public function updateAvailability(Request $request)
    {
        $request->validate([
            'availability' => 'required|boolean',
        ]);

        $user = auth()->user();
        $user->availability = $request->availability;
        $user->save();

        return redirect()->route('freelance.dashboard')->with('success', 'Availability updated.');
    }

    // List assignments to accept
    public function assignments()
    {
        // Example: show assignments assigned or available for this freelancer
        $assignments = Assignment::where('freelancer_id', auth()->id())
                        ->orWhere('status', 'pending')
                        ->paginate(10);

        return view('freelance.assignments', compact('assignments'));
    }

    // Accept assignment
    public function acceptAssignment($id)
    {
        $assignment = Assignment::findOrFail($id);

        // Example: only allow if pending
        if ($assignment->status === 'pending') {
            $assignment->freelancer_id = auth()->id();
            $assignment->status = 'accepted';
            $assignment->save();

            return redirect()->route('freelance.assignments')->with('success', 'Assignment accepted.');
        }

        return redirect()->route('freelance.assignments')->with('error', 'Cannot accept this assignment.');
    }

    // Upload media form
    public function uploadMediaForm()
    {
        $events = Event::all();

        // Convert event dates to Carbon instances if not already Carbon
        foreach ($events as $event) {
            $event->date = Carbon::parse($event->date); // Ensure it's a Carbon instance
        }

        return view('freelance.upload_media', compact('events'));
    }

    // Handle media upload
    public function uploadMedia(Request $request)
    {
        // Validate the uploaded files
        $request->validate([
            'event_id' => 'required|exists:events,id', // Ensure event exists
            'media_files' => 'required|array', // Ensure files are provided as an array
            'media_files.*' => 'mimes:jpg,jpeg,png,mp4,mov|max:20480', // Validate file types and max size (20MB)
        ]);

        // Process the files
        if ($request->hasFile('media_files')) {
            foreach ($request->file('media_files') as $file) {
                // Store the file (e.g., in the public folder or a dedicated storage disk)
                $file->store('media', 'public');
            }

            return redirect()->route('freelance.upload.media')->with('success', 'Files uploaded successfully!');
        }

        return back()->with('error', 'No files selected.');
    }

    // Calendar view showing freelancer assignments
    public function calendar()
    {
        // Example assumes you have an Assignment model related to Event
        $assignments = Assignment::with('event')
            ->where('freelancer_id', auth()->id())
            ->get();

        // Format for FullCalendar
        $events = $assignments->map(function ($assignment) {
            return [
                'title' => $assignment->event->event_type . ' Assignment',
                'start' => $assignment->event->event_date,
                'color' => '#17a2b8',
            ];
        });

        return view('freelance.calendar', ['events' => $events]);
    }
}
