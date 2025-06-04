<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venue;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::latest()->paginate(10);
        return view('staff.venues.index', compact('venues'));
    }

    public function create()
    {
        return view('staff.venues.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string',
            'location_url' => 'nullable|url',
            'package_type' => 'required|string',
            'event_type' => 'required|string',
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

        return redirect()->route('staff.venues.index')->with('success', 'Venue created successfully.');
    }

    public function show($id)
    {
        $venue = Venue::findOrFail($id);
        return view('staff.venues.show', compact('venue'));
    }

    public function edit($id)
    {
        $venue = Venue::findOrFail($id);
        return view('staff.venues.edit', compact('venue'));
    }

    public function update(Request $request, $id)
    {
        $venue = Venue::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string',
            'location_url' => 'nullable|url',
            'package_type' => 'required|string',
            'event_type' => 'required|string',
            'available_date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'sample_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('sample_photo')) {
            // Optional: Delete old photo if exists
            if ($venue->sample_photo && file_exists(public_path('uploads/' . $venue->sample_photo))) {
                unlink(public_path('uploads/' . $venue->sample_photo));
            }

            $filename = time() . '.' . $request->sample_photo->extension();
            $request->sample_photo->move(public_path('uploads'), $filename);
            $validated['sample_photo'] = $filename;
        }

        $venue->update($validated);

        return redirect()->route('staff.venues.index')->with('success', 'Venue updated successfully.');
    }

    public function destroy($id)
    {
        $venue = Venue::findOrFail($id);

        // Delete image if exists
        if ($venue->sample_photo && file_exists(public_path('uploads/' . $venue->sample_photo))) {
            unlink(public_path('uploads/' . $venue->sample_photo));
        }

        $venue->delete();

        return redirect()->route('staff.venues.index')->with('success', 'Venue deleted successfully.');
    }
}
