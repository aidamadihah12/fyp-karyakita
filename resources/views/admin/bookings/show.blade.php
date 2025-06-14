@extends('layouts.admin')

@section('title', 'Booking Details')

@section('content')
<div class="container">
    <h2>Booking Details: #{{ $booking->id }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Customer -->
    <div class="mb-3">
        <label class="form-label">Customer</label>
        <input type="text" class="form-control" value="{{ $booking->user->name ?? 'N/A' }}" disabled>
    </div>

    <!-- Venue -->
    <div class="mb-3">
        <label class="form-label">Venue</label>
        <input type="text" class="form-control" value="{{ $booking->venue->name ?? 'N/A' }}" disabled>
    </div>

    <!-- Event -->
    <div class="mb-3">
        <label class="form-label">Event</label>
        <input type="text" class="form-control" value="{{ $booking->event->name ?? '-' }}" disabled>
    </div>

    <!-- Event Date -->
    <div class="mb-3">
        <label class="form-label">Event Date</label>
        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($booking->event_date)->format('Y-m-d') }}" disabled>
    </div>

    <!-- Time -->
    <div class="mb-3">
        <label class="form-label">Time</label>
        <input type="text" class="form-control" value="{{ $booking->time ?? '-' }}" disabled>
    </div>

    <!-- Assigned Photographer -->
    <div class="mb-3">
        <label class="form-label">Assigned Photographer</label>
        @if ($booking->photographer)
            <input type="text" class="form-control" value="{{ $booking->photographer->name }} ({{ ucfirst($booking->photographer->user_role) }})" disabled>
            @else
            <input type="text" class="form-control" value="Not Assigned" disabled>
        @endif
    </div>

    <!-- Note -->
    <div class="mb-3">
        <label class="form-label">Note</label>
        <textarea class="form-control" rows="3" disabled>{{ $booking->note ?? '-' }}</textarea>
    </div>

    <!-- Status -->
    <div class="mb-3">
        <label class="form-label">Status</label>
        <input type="text" class="form-control bg-light"
               value="{{ $booking->status }}"
               style="font-weight: bold; color:
               @if($booking->status == 'Pending') #856404
               @elseif($booking->status == 'Confirmed') #155724
               @elseif($booking->status == 'Completed') #004085
               @elseif($booking->status == 'Assigned') #0c5460
               @else #6c757d
               @endif;"
               disabled>
    </div>

    <!-- Total Amount -->
    <div class="mb-3">
        <label class="form-label">Total Amount (RM)</label>
        <input type="text" class="form-control" value="RM {{ number_format($booking->total_amount, 2) }}" disabled>
    </div>

    <!-- Location -->
    <div class="mb-3">
        <label class="form-label">Location</label>
        <input type="text" class="form-control" value="{{ $booking->location ?? '-' }}" disabled>
    </div>

    <!-- Location URL -->
    <div class="mb-3">
        <label class="form-label">Location URL</label><br>
        @if($booking->location_url)
            <a href="{{ $booking->location_url }}" target="_blank" rel="noopener noreferrer">{{ $booking->location_url }}</a>
        @else
            <span>N/A</span>
        @endif
    </div>

    <!-- Action Buttons -->
    <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
