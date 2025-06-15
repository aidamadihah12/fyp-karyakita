<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FreelanceController extends Controller
{
    // ===== DASHBOARD =====
    public function dashboard()
    {
        $availability = auth()->user()->availability ?? false;
        return view('freelance.dashboard', compact('availability'));
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

    // ===== BOOKINGS (ASSIGNMENTS) =====
    public function assignments()
    {
    $freelancerId = auth()->id(); // Ensure the logged-in freelance user

    $assignments = Assignment::with('event') // eager load event data
        ->where('freelancer_id', $freelancerId)
        ->where('status', 'pending') // only show pending
        ->orderBy('created_at', 'desc')
        ->paginate(10);


    return view('freelance.assignments', compact('assignments'));
    }



    // ===== UPLOAD MEDIA =====
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
            }

            return redirect()->route('freelance.upload.media')->with('success', 'Files uploaded successfully!');
        }

        return back()->with('error', 'No media files selected.');
    }

    // ===== CALENDAR =====
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
                'url' => route('freelance.assignments.edit', $assignment->id),
                'color' => match($assignment->status) {
                    'accepted' => '#28a745',
                    'completed' => '#004085',
                    default => '#ffc107',
                },
            ];
        });

        return view('freelance.calendar', ['events' => $events]);
    }

public function bookingsIndex()
{
    $freelancerId = auth()->id();

    $bookings = Booking::with('event')
        ->whereHas('event.assignments', function ($query) use ($freelancerId) {
            $query->where('freelancer_id', $freelancerId);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('freelance.bookings.index', compact('bookings'));
}



}
