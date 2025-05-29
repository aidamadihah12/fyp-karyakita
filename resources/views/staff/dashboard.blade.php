@extends('layouts.staff')

@section('title', 'Staff Dashboard')

@section('content')
<h2>Staff Dashboard</h2>

<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Pending Bookings</h5>
                <p class="card-text fs-3">{{ $pendingBookingsCount }}</p>
                <a href="{{ route('staff.bookings') }}" class="btn btn-light btn-sm">Manage Bookings</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Client Inquiries</h5>
                <p class="card-text fs-3">{{ $inquiriesCount }}</p>
                <a href="{{ route('staff.inquiries') }}" class="btn btn-light btn-sm">View Inquiries</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Send Notifications</h5>
                <a href="{{ route('staff.notifications.form') }}" class="btn btn-light btn-sm mt-4">Send Notification</a>
            </div>
        </div>
    </div>
</div>
@endsection
