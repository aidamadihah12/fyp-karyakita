@extends('layouts.admin')

@section('title', 'Edit Booking')

@section('content')
<div class="container">
    <h2>Edit Booking #{{ $booking->id }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="event_id">Select Event</label>
            <select name="event_id" id="event_id" class="form-control" required>
                <option value="">-- Select Event --</option>
                @foreach ($events as $event)
                    <option value="{{ $event->id }}" {{ $booking->event_id == $event->id ? 'selected' : '' }}>
                        {{ $event->name }} - RM{{ number_format($event->price, 2) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="event_date">Event Date</label>
            <input type="date" name="event_date" id="event_date" class="form-control"
                   value="{{ old('event_date', $booking->event_date) }}" required>
        </div>

        <div class="form-group">
            <label for="total_amount">Total Amount (RM)</label>
            <input type="number" name="total_amount" id="total_amount" class="form-control"
                   value="{{ old('total_amount', $booking->total_amount) }}" required>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="Pending" {{ old('status', $booking->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Confirmed" {{ old('status', $booking->status) == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="Completed" {{ old('status', $booking->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update Booking</button>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>
@endsection
