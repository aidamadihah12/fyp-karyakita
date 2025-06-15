@extends('layouts.freelance')

@section('title', 'Manage Bookings')

@section('content')
<div class="container">
    <h1>Manage Bookings</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-striped table-bordered align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Event Name</th>
                <th>Event Date</th>
                <th>Location</th>
                <th>Status</th>
                <th>Total (RM)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->event->name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->event->event_date ?? $booking->created_at)->format('d M Y') }}</td>
                    <td>
                        {{ $booking->event->location ?? '-' }}<br>
                        @if ($booking->event->location_url)
                            <a href="{{ $booking->event->location_url }}" target="_blank">View Map</a>
                        @else
                            N/A
                        @endif
                    </td>
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
                    <td>{{ number_format($booking->total_amount ?? 0, 2) }}</td>
                    <td>{{ $booking->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No bookings found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
