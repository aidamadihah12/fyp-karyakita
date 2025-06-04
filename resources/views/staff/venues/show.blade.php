@extends('layouts.staff')

@section('content')
<div class="container">
    <h2>Venue Details - {{ $venue->name }}</h2>

    <div class="mb-3">
        <strong>Name:</strong> {{ $venue->name }}
    </div>

    <div class="mb-3">
        <strong>Location:</strong> {{ $venue->location }}
    </div>

    <div class="mb-3">
        <strong>Location URL:</strong>
        @if($venue->location_url)
            <a href="{{ $venue->location_url }}" target="_blank">View on Map</a>
        @else
            <em>Not set</em>
        @endif
    </div>

    <div class="mb-3">
        <strong>Package Type:</strong> {{ $venue->package_type }}
    </div>

    <div class="mb-3">
        <strong>Event Type:</strong> {{ $venue->event_type }}
    </div>

    <div class="mb-3">
        <strong>Available Date:</strong> {{ \Carbon\Carbon::parse($venue->available_date)->format('Y-m-d') }}
    </div>

    <div class="mb-3">
        <strong>Price (RM):</strong> {{ number_format($venue->price, 2) }}
    </div>

    <div class="mb-3">
        <strong>Sample Photo:</strong><br>
        @if($venue->sample_photo)
            <img src="{{ asset('uploads/' . $venue->sample_photo) }}" alt="Photo" width="200">
        @else
            <em>No photo available</em>
        @endif
    </div>

    <a href="{{ route('staff.venues.index') }}" class="btn btn-primary">Back to Venue List</a>
</div>
@endsection
