@extends('layouts.admin')

@section('title', 'Edit Booking')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Booking</h2>

    <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="customer_id">Customer</label>
            <select name="customer_id" id="customer_id" class="form-control @error('customer_id') is-invalid @enderror" required>
                <option value="">-- Select Customer --</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ old('customer_id', $booking->customer_id) == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
            @error('customer_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="venue_id">Venue</label>
            <select name="venue_id" id="venue_id" class="form-control @error('venue_id') is-invalid @enderror" required>
                <option value="">-- Select Venue --</option>
                @foreach($venues as $venue)
                    <option value="{{ $venue->id }}" {{ old('venue_id', $booking->venue_id) == $venue->id ? 'selected' : '' }}>
                        {{ $venue->name }}
                    </option>
                @endforeach
            </select>
            @error('venue_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="date">Event Date</label>
            <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror"
                   value="{{ old('date', $booking->date) }}" required>
            @error('date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="time">Event Time</label>
            <input type="time" name="time" id="time" class="form-control @error('time') is-invalid @enderror"
                   value="{{ old('time', $booking->time) }}" required>
            @error('time')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="package">Package</label>
            <input type="text" name="package" id="package" class="form-control @error('package') is-invalid @enderror"
                   value="{{ old('package', $booking->package) }}" required>
            @error('package')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="">-- Select Status --</option>
                <option value="Pending" {{ old('status', $booking->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Confirmed" {{ old('status', $booking->status) == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="Completed" {{ old('status', $booking->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                <option value="Cancelled" {{ old('status', $booking->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="location">Location (Name/Address)</label>
            <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror"
                   value="{{ old('location', $booking->location) }}">
            @error('location')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="location_url">Location URL (Google Maps)</label>
            <input type="url" name="location_url" id="location_url" class="form-control @error('location_url') is-invalid @enderror"
                   value="{{ old('location_url', $booking->location_url) }}">
            @error('location_url')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="note">Note (Optional)</label>
            <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror" rows="3">{{ old('note', $booking->note) }}</textarea>
            @error('note')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Booking</button>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>
@endsection
