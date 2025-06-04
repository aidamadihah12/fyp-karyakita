@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $venue->name }}</h2>

    @if($venue->sample_photo)
        <img src="{{ asset('uploads/' . $venue->sample_photo) }}" class="img-fluid mb-3" alt="Venue Photo">
    @endif

    <p><strong>Description:</strong> {{ $venue->description }}</p>
    <p><strong>Location:</strong> {{ $venue->location }}</p>
    <p><strong>Event Type:</strong> {{ $venue->event_type }}</p>
    <p><strong>Package Type:</strong> {{ $venue->package_type }}</p>
    <p><strong>Available Date:</strong> {{ $venue->available_date }}</p>
    <p><strong>Price:</strong> RM{{ number_format($venue->price, 2) }}</p>

    <a href="{{ route('venues.index') }}" class="btn btn-secondary">Back to Listings</a>
</div>
@endsection
