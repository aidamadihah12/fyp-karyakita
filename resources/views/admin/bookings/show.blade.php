@extends('layouts.admin')

@section('title', 'Booking Details')

@section('content')
<div class="container">
    <h2>Booking Details - #{{ $booking->id }}</h2>

    <div class="mb-3">
        <label for="event_type" class="form-label">Event Type</label>
        <input type="text" id="event_type" class="form-control" value="{{ $booking->event_type }}" disabled>
    </div>

    <div class="mb-3">
        <label for="event_date" class="form-label">Event Date</label>
        <input type="text" id="event_date" class="form-control" value="{{ \Carbon\Carbon::parse($booking->event_date)->format('Y-m-d') }}" disabled>
    </div>

    <div class="mb-3">
        <label for="total_amount" class="form-label">Total Amount (RM)</label>
        <input type="text" id="total_amount" class="form-control" value="{{ number_format($booking->total_amount, 2) }}" disabled>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <input type="text" id="status" class="form-control" value="{{ $booking->status }}" disabled>
    </div>

    <!-- Back button -->
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Back to Bookings</a>
</div>
@endsection
