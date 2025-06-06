<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venue;

class VenueController extends Controller
{
    /**
     * Display a listing of the venues.
     */
    public function index()
    {
        $venues = Venue::latest()->paginate(10);
        return view('admin.venues.index', compact('venues'));
    }

    /**
     * Show the form for creating a new venue.
     */
    public function create()
    {
        return view('admin.venues.create');
    }

    /**
     * Store a newly created venue in storage.
     */
    public function store(Request $request)
    {
$validated = $request->validate([
    'name' => 'required|string|max:255',
    'description' => 'nullable|string',
    'location' => 'required|string|max:255',
    'location_url' => 'nullable|url',
    'package_type' => 'required|string|max:255',
    'event_type' => 'required|string|max:255',
    'available_date' => 'required|date',
    'price' => 'required|numeric|min:0',
    'sample_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
]);

        if ($request->hasFile('sample_photo')) {
            $filename = time() . '.' . $request->sample_photo->extension();
            $request->sample_photo->move(public_path('uploads'), $filename);
            $validated['sample_photo'] = $filename;
        }

        Venue::create($validated);

        return redirect()->route('admin.venues.index')->with('success', 'Venue created successfully.');
    }

    /**
     * Show the form for editing the specified venue.
     */
    public function edit($id)
    {
        $venue = Venue::findOrFail($id);
        return view('admin.venues.edit', compact('venue'));
    }

    /**
     * Update the specified venue in storage.
     */
    public function update(Request $request, $id)
    {
        $venue = Venue::findOrFail($id);

$validated = $request->validate([
    'name' => 'required|string|max:255',
    'description' => 'nullable|string',
    'location' => 'required|string|max:255',
    'location_url' => 'nullable|url',
    'package_type' => 'required|string|max:255',
    'event_type' => 'required|string|max:255',
    'available_date' => 'required|date',
    'price' => 'required|numeric|min:0',
    'sample_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
]);
        if ($request->hasFile('sample_photo')) {
            $filename = time() . '.' . $request->sample_photo->extension();
            $request->sample_photo->move(public_path('uploads'), $filename);
            $validated['sample_photo'] = $filename;
        }

        $venue->update($validated);

        return redirect()->route('admin.venues.index')->with('success', 'Venue updated successfully.');
    }

    /**
     * Remove the specified venue from storage.
     */
    public function destroy($id)
    {
        Venue::destroy($id);
        return back()->with('success', 'Venue deleted successfully.');
    }

    /**
     * Display the specified venue (for frontend/public view).
     */
    public function show($id)
    {
        $venue = Venue::findOrFail($id);
        return view('venues.show', compact('venue'));
    }
}
