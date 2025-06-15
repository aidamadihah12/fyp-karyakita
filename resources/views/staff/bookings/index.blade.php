@extends('layouts.staff')

@section('title', 'Manage Bookings')

@section('content')
<div class="container">
    <h1>Manage Bookings</h1>

    <!-- Flash messages -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

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
                <th>Action</th>
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
                        <a href="{{ route('staff.bookings.edit', $booking->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No bookings found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    {{ $bookings->links() }}
</div>
@endsection
