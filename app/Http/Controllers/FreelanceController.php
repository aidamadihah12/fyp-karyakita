<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FreelanceController extends Controller
{
    // ===== Dashboard =====
    public function dashboard()
    {
        $availability = auth()->user()->availability ?? false;
        return view('freelance.dashboard', compact('availability'));
    }

    // ===== Edit Availability =====
    public function editAvailability()
    {
        $availability = auth()->user()->availability ?? false;
        return view('freelance.availability', compact('availability'));
    }

    public function updateAvailability(Request $request)
    {
        $request->validate([
            'availability' => 'required|boolean',
        ]);

        $user = auth()->user();
        $user->availability = $request->availability;
        $user->save();

        return redirect()->route('freelance.dashboard')->with('success', 'Availability updated successfully.');
    }

    // ===== View Assignments =====
    public function assignments()
    {
        $assignments = Assignment::with('event')
            ->where(function ($query) {
                $query->where('freelancer_id', auth()->id())
                      ->orWhere('status', 'pending');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('freelance.assignments.index', compact('assignments'));
    }

    // ===== Accept Assignment =====
    public function acceptAssignment($id)
    {
        $assignment = Assignment::findOrFail($id);

        if ($assignment->status === 'pending') {
            $assignment->freelancer_id = auth()->id();
            $assignment->status = 'accepted';
            $assignment->save();

            return redirect()->route('freelance.assignments')->with('success', 'Assignment accepted.');
        }

        return redirect()->route('freelance.assignments')->with('error', 'This assignment is no longer available.');
    }

    // ===== Upload Media Form =====
    public function uploadMediaForm()
    {
        $events = Event::whereHas('assignments', function ($query) {
            $query->where('freelancer_id', auth()->id());
        })->get();

        foreach ($events as $event) {
            $event->event_date = Carbon::parse($event->event_date);
        }

        return view('freelance.upload_media', compact('events'));
    }

    // ===== Handle Media Upload =====
    public function uploadMedia(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'media_files' => 'required|array',
            'media_files.*' => 'mimes:jpg,jpeg,png,mp4,mov|max:20480',
        ]);

        if ($request->hasFile('media_files')) {
            foreach ($request->file('media_files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs("media/event_{$request->event_id}", $filename, 'public');
                // Optionally save metadata to a Media model if needed
            }

            return redirect()->route('freelance.upload.media')->with('success', 'Files uploaded successfully!');
        }

        return back()->with('error', 'No media files selected.');
    }

    // ===== Calendar View =====
    public function calendar()
    {
        $assignments = Assignment::with('event')
            ->where('freelancer_id', auth()->id())
            ->get();

        $events = $assignments->map(function ($assignment) {
            $event = $assignment->event;
            return [
                'title' => $event->event_type . ' - ' . ($event->client_name ?? 'Client'),
                'start' => $event->event_date,
                'color' => $assignment->status === 'accepted' ? '#17a2b8' : '#ffc107',
            ];
        });

        return view('freelance.calendar', ['events' => $events]);
    }
}
