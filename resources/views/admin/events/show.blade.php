@extends('layouts.admin')

@section('title', 'Event Details')

@section('content')
<div class="container">
    <h2>Event Details: {{ $event->name }}</h2>

    <!-- Display Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Event Name -->
    <div class="mb-3">
        <label for="event_name" class="form-label">Event Name</label>
        <input type="text" id="event_name" class="form-control" value="{{ $event->name }}" disabled>
    </div>

    <!-- Event Price -->
    <div class="mb-3">
        <label for="event_price" class="form-label">Event Price (RM)</label>
        <input type="text" id="event_price" class="form-control" value="RM {{ number_format($event->price, 2) }}" disabled>
    </div>

    <!-- Event Slots Available -->
    <div class="mb-3">
        <label for="available_slots" class="form-label">Available Slots</label>
        <input type="text" id="available_slots" class="form-control" value="{{ $event->available_slots }}" disabled>
    </div>

    <!-- Event Date -->
    <div class="mb-3">
        <label for="event_date" class="form-label">Event Date</label>
        <input type="text" id="event_date" class="form-control" value="{{ \Carbon\Carbon::parse($event->date)->format('Y-m-d') }}" disabled>
    </div>

<!-- Event Description -->
<div class="mb-3">
    <label for="event_desc" class="form-label">Event Description</label>
    <textarea id="event_desc" class="form-control" rows="4" disabled>{!! $event->desc !!}</textarea>

</div>

<div class="mb-3">
    <label><strong>Location URL:</strong></label><br>
    @if($event->location_url)
        <a href="{{ $event->location_url }}" target="_blank">{{ $event->location_url }}</a>
    @else
        <span>N/A</span>
    @endif
</div>


    <!-- Event Image -->
    @if ($event->image)
        <div class="mb-3">
            <label for="event_image" class="form-label">Event Image</label>
            <div>
                <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image" class="img-fluid" style="max-width: 300px;">
            </div>
        </div>
    @else
        <div class="mb-3">
            <label for="event_image" class="form-label">Event Image</label>
            <p>No image available</p>
        </div>
    @endif

    <!-- Back Button -->
    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Back to Events</a>
</div>
@endsection
