<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venue;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::latest()->paginate(10);
        return view('admin.venues.index', compact('venues'));
    }

    public function create()
    {
        return view('admin.venues.create');
    }

    public function store(Request $request)
    {
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

        Venue::create($validated);

        return redirect()->route('admin.venues.index')->with('success', 'Venue created successfully.');
    }

    public function edit($id)
    {
        $venue = Venue::findOrFail($id);
        return view('admin.venues.edit', compact('venue'));
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

        return redirect()->route('admin.venues.index')->with('success', 'Venue updated successfully.');
    }

    public function destroy($id)
    {
        Venue::destroy($id);
        return back()->with('success', 'Venue deleted successfully.');
    }
}
