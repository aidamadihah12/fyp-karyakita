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
            'package_type' => 'required|string',
            'event_type' => 'required|string',
            'available_date' => 'required|date',
            'price' => 'required|numeric',
            'sample_photo' => 'nullable|image|mimes:jpeg,png,jpg'
        ]);

        if ($request->hasFile('sample_photo')) {
            $filename = time() . '.' . $request->sample_photo->extension();
            $request->sample_photo->move(public_path('uploads'), $filename);
            $validated['sample_photo'] = $filename;
        }

        $venue->update($validated);

        return redirect()->route('staff.venues.index')->with('success', 'Venue updated successfully.');
    }
}
