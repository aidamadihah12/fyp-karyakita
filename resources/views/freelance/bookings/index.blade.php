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
                            <th>ID</th>
                            <th>Event Name</th>
                            <th>Event Date</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Total (RM)</th>
                            <th>Created At</th>
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
                                <td>
                                    <!-- Action button placeholder -->
                                    <a href="#" class="btn btn-sm btn-outline-secondary disabled">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No bookings found.</td>
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
