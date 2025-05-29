@extends('layouts.admin')

@section('title', 'Create Booking')

@section('content')
<div class="container">
    <h1>Create Booking</h1>

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

        <div class="form-group">
            <label for="event_id">Select Event</label>
            <select name="event_id" id="event_id" class="form-control" required>
                <option value="">-- Select Event --</option>
                @foreach ($events as $event)
                    <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                        {{ $event->name }} - RM{{ number_format($event->price, 2) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="event_date">Event Date</label>
            <input type="date" id="event_date" name="event_date" class="form-control" value="{{ old('event_date') }}" required>
        </div>

        <div class="form-group">
            <label for="total_amount">Total Amount (RM)</label>
            <input type="number" name="total_amount" id="total_amount" class="form-control" value="{{ old('total_amount', 0) }}" required readonly>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Confirmed" {{ old('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create Booking</button>
    </form>
</div>
@endsection
