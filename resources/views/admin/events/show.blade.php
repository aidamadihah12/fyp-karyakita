@extends('layouts.admin')

@section('title', 'Event Details')

@section('content')
<div class="container">
    <h2>Event Details: {{ $event->name }}</h2>

    <!-- Event Type -->
    <div class="mb-3">
        <label for="event_type" class="form-label">Event Type</label>
        <input type="text" id="event_type" class="form-control" value="{{ $event->name }}" disabled>
    </div>

    <!-- Event Price -->
    <div class="mb-3">
        <label for="event_price" class="form-label">Event Price (RM)</label>
        <input type="text" id="event_price" class="form-control" value="{{ $event->price }}" disabled>
    </div>

    <!-- Event Description -->
    <div class="mb-3">
        <label for="event_description" class="form-label">Event Description</label>
        <textarea id="event_description" class="form-control" disabled>{{ $event->description }}</textarea>
    </div>

    <!-- Event Date -->
    <div class="mb-3">
        <label for="event_date" class="form-label">Event Date</label>
        <input type="text" id="event_date" class="form-control" value="{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d') }}" disabled>
    </div>

    <!-- Back Button -->
    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Back to Events</a>
</div>
@endsection
