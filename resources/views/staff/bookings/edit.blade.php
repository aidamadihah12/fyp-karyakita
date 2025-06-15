@extends('layouts.staff')

@section('title', 'Edit Booking')

@section('content')
<h2>Edit Booking #{{ $booking->id }}</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('staff.bookings.update', $booking->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Booking Status Dropdown -->
    <div class="mb-3">
        <label for="status" class="form-label">Booking Status</label>
        <select name="status" id="status" class="form-select" required>
            @foreach(['Pending','Confirmed','Completed'] as $status)
                <option value="{{ $status }}" {{ $booking->status == $status ? 'selected' : '' }}>
                    {{ $status }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Total Amount Input -->
    <div class="mb-3">
        <label for="total_amount" class="form-label">Total Amount (RM)</label>
        <input type="number" step="0.01" min="0" name="total_amount" id="total_amount" class="form-control" value="{{ $booking->total_amount }}" required>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-success">Update Booking</button>
    <a href="{{ route('staff.bookings') }}" class="btn btn-secondary ms-2">Cancel</a>
</form>
@endsection
