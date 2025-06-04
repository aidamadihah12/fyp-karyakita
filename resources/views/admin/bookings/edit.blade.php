@extends('layouts.admin')

@section('title', 'Booking Details')

@section('content')
<div class="container">
    <h2>Booking Details</h2>

    <table class="table table-bordered">
        <tr>
            <th>Booking ID</th>
            <td>{{ $booking->id }}</td>
        </tr>
        <tr>
            <th>Customer</th>
            <td>{{ $booking->customer->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Venue</th>
            <td>{{ $booking->venue->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Date</th>
            <td>{{ \Carbon\Carbon::parse($booking->date)->format('Y-m-d') }}</td>
        </tr>
        <tr>
            <th>Time</th>
            <td>{{ $booking->time }}</td>
        </tr>
        <tr>
            <th>Package</th>
            <td>{{ $booking->package }}</td>
        </tr>
        <tr>
            <th>Note</th>
            <td>{{ $booking->note }}</td>
        </tr>
    </table>

    <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
