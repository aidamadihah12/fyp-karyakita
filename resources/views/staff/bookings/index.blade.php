@extends('layouts.staff')

@section('title', 'Manage Bookings')

@section('content')
<div class="container">
    <h1>Manage Bookings</h1>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Bookings Table -->
    <table class="table table-striped table-bordered align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Event ID</th>
                <th>Event Date</th>
                <th>Note</th>
                <th>Status</th>
                <th>Location</th>
                <th>Total (RM)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->event_id ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->event_date)->format('d M Y') }}</td>
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
                            <a href="{{ $booking->location_url }}" target="_blank">View Map</a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ number_format($booking->total_amount, 2) }}</td>
                    <td>
                        <a href="{{ route('staff.bookings.edit', $booking->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        {{-- Add more buttons if needed --}}
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
    <div class="mt-3">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
