@extends('layouts.freelance')

@section('title', 'Manage Bookings')

@section('content')
<div class="container">
    <h1 class="mb-4">Manage Bookings</h1>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Bookings Table -->
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Booking ID</th>
                            <th>Customer</th>
                            <th>Event</th>
                            <th>Date</th>
                            <th>Note</th>
                            <th>Status</th>
                            <th>Location</th>
                            <th>Photographer</th>
                            <th>Total (RM)</th>
                            <th>Created At</th>
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
                                <td>{{ number_format($booking->total_amount ?? 0, 2) }}</td>
                                <td>{{ $booking->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-secondary disabled">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted">No bookings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
