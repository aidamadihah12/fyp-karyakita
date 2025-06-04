@extends('layouts.admin')

@section('title', 'Create Booking')

@section('content')
<div class="container">
    <h2>Create New Booking</h2>

    <form action="{{ route('admin.bookings.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="customer_id">Customer</label>
            <select name="customer_id" class="form-control" required>
                <option value="">-- Select Customer --</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="venue_id">Venue</label>
            <select name="venue_id" class="form-control" required>
                <option value="">-- Select Venue --</option>
                @foreach($venues as $venue)
                    <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="date">Event Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="time">Event Time</label>
            <input type="time" name="time" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="package">Package</label>
            <input type="text" name="package" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="note">Note (Optional)</label>
            <textarea name="note" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Create Booking</button>
    </form>
</div>
@endsection
