@extends('layouts.admin')

@section('title', 'Create Booking')

@section('content')
<div class="container">
    <h2>Create New Booking</h2>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.bookings.store') }}" method="POST">
        @csrf

        <!-- Select Customer -->
        <div class="form-group">
            <label for="user_id">Customer</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="">-- Select Customer --</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}" {{ old('user_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }} ({{ $customer->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Select Event -->
        <div class="form-group">
            <label for="event_id">Event</label>
            <select name="event_id" id="event_id" class="form-control" required>
                <option value="">-- Select Event --</option>
                @foreach ($events as $event)
                    <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                        {{ $event->name }} - {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="time">Event Time</label>
             <input type="time" name="time" id="time" class="form-control @error('time') is-invalid @enderror"
                 value="{{ old('time') }}" required>
                @error('time')
                 <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Select Venue -->
        <div class="form-group">
            <label for="venue_id">Venue</label>
            <select name="venue_id" id="venue_id" class="form-control" required>
                <option value="">-- Select Venue --</option>
                @foreach ($venues as $venue)
                    <option value="{{ $venue->id }}" {{ old('venue_id') == $venue->id ? 'selected' : '' }}>
                        {{ $venue->name }} ({{ $venue->location_url }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Event Date -->
        <div class="form-group">
            <label for="event_date">Event Date</label>
            <input type="date" name="event_date" id="event_date" class="form-control" value="{{ old('event_date') }}" required>
        </div>


        <!-- Location (Optional) -->
        <div class="form-group">
            <label for="location">Event Location (Optional)</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}">
        </div>

        <!-- Location URL (Optional) -->
        <div class="form-group">
            <label for="location_url">Google Maps URL (Optional)</label>
            <input type="url" name="location_url" id="location_url" class="form-control" value="{{ old('location_url') }}">
        </div>

        <!-- Booking Status -->
        <div class="form-group">
            <label for="status">Booking Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="">-- Select Status --</option>
                <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Confirmed" {{ old('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="photographer_id">Assign Photographer</label>
                <select name="photographer_id" class="form-control">
                    <option value="">-- Not Assigned --</option>
                    @foreach ($photographers as $photographer)
                    <option value="{{ $photographer->id }}"
                        {{ old('photographer_id', $booking->photographer_id ?? '') == $photographer->id ? 'selected' : '' }}>
                        {{ $photographer->name }} ({{ ucfirst($photographer->user_role) }})
                    </option>
            @endforeach
            </select>
        </div>


        <!-- Note -->
        <div class="form-group">
            <label for="note">Notes (Optional)</label>
            <textarea name="note" id="note" class="form-control" rows="3">{{ old('note') }}</textarea>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-primary mt-3">Create Booking</button>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary mt-3 ms-2">Back to Booking List</a>
    </form>
</div>
@endsection
