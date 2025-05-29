@extends('layouts.admin')

@section('title', 'Manage Bookings')

@section('content')
    <h1>Manage Bookings</h1>
    <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">Add New Booking</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Event Name</th>
                <th>Status</th>
                <th>Total Amount</th>
                <th>Event Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->event->name }}</td>
                    <td>{{ $booking->status }}</td>
                    <td>{{ number_format($booking->total_amount, 2) }}</td>
                    <td>{{ $booking->event_date }}</td>
                    <td>
                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
