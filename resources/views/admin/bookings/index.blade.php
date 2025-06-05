@extends('layouts.admin')

@section('title', 'Manage Bookings')

@section('content')
<div class="container">
    <h2>Manage Bookings</h2>

    <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary mb-3">Add New Booking</a>

    <table class="table table-striped" id="bookings-table">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Customer</th>
                <th>Venue</th>
                <th>Date</th>
                <th>Time</th>
                <th>Package</th>
                <th>Note</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {{-- Data will be loaded here via JavaScript --}}
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch(@json(route('api.bookings.index')))
    .then(response => {
        if (!response.ok) throw new Error('Network response was not OK');
        return response.json();
    })
    .then(data => {
        const tbody = document.querySelector('#bookings-table tbody');

        if (!data.success || data.data.length === 0) {
            tbody.innerHTML = `<tr><td colspan="9" class="text-center">No bookings found.</td></tr>`;
            return;
        }

        data.data.forEach(booking => {
            const date = new Date(booking.date).toISOString().slice(0,10); // format yyyy-mm-dd
            tbody.insertAdjacentHTML('beforeend', `
                <tr>
                    <td>${booking.id}</td>
                    <td>${booking.customer ? booking.customer.name : 'N/A'}</td>
                    <td>${booking.venue ? booking.venue.name : 'N/A'}</td>
                    <td>${date}</td>
                    <td>${booking.time ?? '-'}</td>
                    <td>${booking.package ?? '-'}</td>
                    <td>${booking.note ?? '-'}</td>
                    <td>${booking.status ?? '-'}</td>
                    <td>
                        <a href="/admin/bookings/${booking.id}" class="btn btn-info btn-sm">View</a>
                        <a href="/admin/bookings/${booking.id}/edit" class="btn btn-warning btn-sm">Edit</a>
                        <form action="/admin/bookings/${booking.id}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure to delete booking #${booking.id}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            `);
        });
    })
    .catch(error => {
        console.error('Error fetching bookings:', error);
        const tbody = document.querySelector('#bookings-table tbody');
        tbody.innerHTML = `<tr><td colspan="9" class="text-center text-danger">Failed to load bookings.</td></tr>`;
    });
});
</script>
@endpush
