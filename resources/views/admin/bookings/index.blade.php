@extends('layouts.admin')

@section('title', 'Manage Bookings')

@section('content')
<div class="container">
    <h1>Manage Bookings</h1>

    <!-- Display success or error messages -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary mb-3">Add New Booking</a>

    <!-- Bookings Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Customer</th>
                <th>Event</th>
                <th>Date</th>
                <th>Note</th>
                <th>Status</th>
                <th>Location</th>
                <th>Photographer</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->user->name ?? 'N/A' }}</td>
                    <td>{{ $booking->event->name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->event_date)->format('Y-m-d') }}</td>
                    <td>{{ $booking->note ?? '-' }}</td>
                    <td>
                        <span class="badge
                            @if($booking->status == 'Pending') bg-warning
                            @elseif($booking->status == 'Confirmed') bg-success
                            @elseif($booking->status == 'Completed') bg-primary
                            @elseif($booking->status == 'Assigned') bg-info
                            @else bg-secondary
                            @endif">
                            {{ $booking->status }}
                        </span>
                    </td>
                    <td>
                        {{ $booking->location ?? '-' }}<br>
                        @if ($booking->location_url)
                            <a href="{{ $booking->location_url }}" target="_blank" rel="noopener noreferrer">View Map</a>
                        @else
                            N/A
                        @endif
                    </td>
<td>
    @if($booking->photographer)
        {{ $booking->photographer->name }}<br>
        <small class="text-muted">({{ ucfirst($booking->photographer->user_role) }})</small>
    @else
        <span class="text-muted">Not Assigned</span>
    @endif
</td>


                    <td>
                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">No bookings found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    {{ $bookings->links() }}
</div>
@endsection
