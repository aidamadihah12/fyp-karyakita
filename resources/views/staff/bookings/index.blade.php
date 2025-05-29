@extends('layouts.staff')

@section('title', 'Manage Bookings')

@section('content')
<h2>Manage Bookings</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Client</th>
            <th>Event Type</th>
            <th>Event Date</th>
            <th>Status</th>
            <th>Total Amount (RM)</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($bookings as $booking)
        <tr>
            <td>{{ $booking->id }}</td>
            <td>{{ $booking->user->full_name ?? 'N/A' }}</td>
            <td>{{ $booking->event_type }}</td>
            <td>{{ \Carbon\Carbon::parse($booking->event_date)->format('d M Y') }}</td>

            <td>{{ $booking->status }}</td>
            <td>{{ number_format($booking->total_amount, 2) }}</td>
            <td>
                <a href="{{ route('staff.bookings.edit', $booking->id) }}" class="btn btn-sm btn-primary">Edit</a>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center">No bookings found.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $bookings->links() }}
@endsection
