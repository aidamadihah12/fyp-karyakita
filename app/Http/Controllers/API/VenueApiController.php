<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venue;

class VenueApiController extends Controller
{
    /**
     * Display a listing of the venues, with optional filters.
     */
    public function index(Request $request)
    {
        $venues = Venue::query()
            ->when($request->location, function ($query) use ($request) {
                $query->where('location', 'like', '%' . $request->location . '%');
            })
            ->when($request->event_type, function ($query) use ($request) {
                $query->where('event_type', $request->event_type);
            })
            ->when($request->package_type, function ($query) use ($request) {
                $query->where('package_type', $request->package_type);
            })
            ->when($request->date, function ($query) use ($request) {
                $query->whereDate('available_date', $request->date);
            })
            ->get();

        return response()->json([
            'status' => 'success',
            'count' => $venues->count(),
            'data' => $venues->map(function ($venue) {
                return [
                    'id' => $venue->id,
                    'name' => $venue->name,
                    'description' => $venue->description,
                    'location' => $venue->location,
                    'location_url' => $venue->location_url,
                    'package_type' => $venue->package_type,
                    'event_type' => $venue->event_type,
                    'available_date' => $venue->available_date,
                    'price' => $venue->price,
                    'photo_url' => $venue->sample_photo
                        ? asset('uploads/' . $venue->sample_photo)
                        : null,
                ];
            }),
        ]);
    }

    /**
     * Display a specific venue by ID.
     */
    public function show($id)
    {
        $venue = Venue::find($id);

        if (!$venue) {
            return response()->json([
                'status' => 'error',
                'message' => 'Venue not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $venue->id,
                'name' => $venue->name,
                'description' => $venue->description,
                'location' => $venue->location,
                'location_url' => $venue->location_url,
                'package_type' => $venue->package_type,
                'event_type' => $venue->event_type,
                'available_date' => $venue->available_date,
                'price' => $venue->price,
                'photo_url' => $venue->sample_photo
                    ? asset('uploads/' . $venue->sample_photo)
                    : null,
            ],
        ]);
    }
}
