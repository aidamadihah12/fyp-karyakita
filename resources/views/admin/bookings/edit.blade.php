@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Edit Booking</h2>

    <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Customer</label>
            <select name="customer_id" class="form-control" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $booking->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Event</label>
            <select name="event_id" class="form-control" required>
                @foreach ($events as $event)
                    <option value="{{ $event->id }}" {{ $booking->event_id == $event->id ? 'selected' : '' }}>{{ $event->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="{{ $booking->event_date }}" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                @foreach (['Pending', 'Confirmed', 'Completed'] as $status)
                    <option value="{{ $status }}" {{ $booking->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
        </div>

<div class="mb-3">
    <label for="photographer_id">Assign Photographer</label>
    <select name="photographer_id" class="form-control">
        <option value="">-- Not Assigned --</option>
        @foreach ($photographers as $photographer)
<option value="{{ $photographer->id }}"
    {{ old('photographer_id', $booking->photographer_id ?? '') == $photographer->id ? 'selected' : '' }}>
    {{ $photographer->name ?? $photographer->name ?? 'Unnamed User' }}
    ({{ ucfirst($photographer->user_role ?? 'N/A') }})
</option>

        @endforeach
    </select>
</div>



        <div class="mb-3">
            <label>Note</label>
            <textarea name="note" class="form-control">{{ $booking->note }}</textarea>
        </div>

        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control" value="{{ $booking->location }}">
        </div>

        <div class="mb-3">
            <label>Location URL</label>
            <input type="url" name="location_url" class="form-control" value="{{ $booking->location_url }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Booking</button>
    </form>
</div>
@endsection
