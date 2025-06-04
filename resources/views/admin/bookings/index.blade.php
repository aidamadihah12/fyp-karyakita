@extends('layouts.admin')

@section('title', 'Manage Bookings')

@section('content')
<div class="container">
    <h2>Manage Bookings</h2>

    <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary mb-3">Add New Booking</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Customer</th>
                <th>Venue</th>
                <th>Date</th>
                <th>Time</th>
                <th>Package</th>
                <th>Note</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->customer->name ?? 'N/A' }}</td>
                    <td>{{ $booking->venue->name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->date)->format('Y-m-d') }}</td>
                    <td>{{ $booking->time }}</td>
                    <td>{{ $booking->package }}</td>
                    <td>{{ $booking->note }}</td>
                    <td>
                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
