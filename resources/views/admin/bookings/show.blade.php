@extends('layouts.admin')

@section('title', 'Booking Details')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Booking Details</h2>

    <table class="table table-bordered">
        <tbody>
            <tr>
                <th scope="row">Booking ID</th>
                <td>{{ $booking->id }}</td>
            </tr>
            <tr>
                <th scope="row">Customer</th>
                <td>{{ $booking->customer->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th scope="row">Venue</th>
                <td>{{ $booking->venue->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th scope="row">Date</th>
                <td>{{ \Carbon\Carbon::parse($booking->date)->format('Y-m-d') }}</td>
            </tr>
            <tr>
                <th scope="row">Time</th>
                <td>{{ $booking->time }}</td>
            </tr>
            <tr>
                <th scope="row">Package</th>
                <td>{{ $booking->package }}</td>
            </tr>
            <tr>
                <th scope="row">Note</th>
                <td>{{ $booking->note ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-warning">Edit Booking</a>
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Back to Bookings List</a>
</div>
@endsection
