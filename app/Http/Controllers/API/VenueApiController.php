<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venue;

class VenueApiController extends Controller
{
    public function index(Request $request)
    {
        $venues = Venue::query()
            ->when($request->location, fn($q) => $q->where('location', 'like', '%' . $request->location . '%'))
            ->when($request->event_type, fn($q) => $q->where('event_type', $request->event_type))
            ->when($request->package_type, fn($q) => $q->where('package_type', $request->package_type))
            ->when($request->date, fn($q) => $q->whereDate('available_date', $request->date))
            ->get();

        return response()->json([
            'status' => 'success',
            'count' => $venues->count(),
            'data' => $venues
        ]);
    }

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
        'data' => $venue,
    ]);
}

}

