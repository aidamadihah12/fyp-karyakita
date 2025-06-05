<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venue;
use Illuminate\Validation\ValidationException;

class VenueApiController extends Controller
{
    /**
     * Display a listing of venues with optional filters.
     *
     * Filters supported:
     * - location (partial match)
     * - event_type (exact match)
     * - package_type (exact match)
     * - date (filters venues available on this date)
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws ValidationException
     */
    public function index(Request $request)
    {
        $request->validate([
            'location' => 'sometimes|string|max:255',
            'event_type' => 'sometimes|string|max:100',
            'package_type' => 'sometimes|string|max:100',
            'date' => 'sometimes|date',
        ]);

        $venues = Venue::query()
            ->when($request->filled('location'), function ($query) use ($request) {
                $query->where('location', 'like', '%' . $request->location . '%');
            })
            ->when($request->filled('event_type'), function ($query) use ($request) {
                $query->where('event_type', $request->event_type);
            })
            ->when($request->filled('package_type'), function ($query) use ($request) {
                $query->where('package_type', $request->package_type);
            })
            ->when($request->filled('date'), function ($query) use ($request) {
                $query->whereDate('available_date', $request->date);
            })
            ->get();

        return response()->json([
            'status' => 'success',
            'count' => $venues->count(),
            'data' => $venues,
        ]);
    }

    /**
     * Display the specified venue.
     *
     * @param  Venue  $venue
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Venue $venue)
    {
        return response()->json([
            'status' => 'success',
            'data' => $venue,
        ]);
    }
}
