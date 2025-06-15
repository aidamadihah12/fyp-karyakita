@extends('layouts.freelance')

@section('title', 'Freelance Dashboard')

@section('content')
<div class="container">
    <h2 class="my-4">Welcome, {{ auth()->user()->full_name }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">

        <!-- Assignments Card -->
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3 shadow">
                <div class="card-body">
                    <h5 class="card-title">Your Assignments</h5>
                    <p class="card-text">View and manage the assignments you've received.</p>
                    <a href="{{ route('freelance.assignments') }}" class="btn btn-light btn-sm mt-2">View Assignments</a>
                </div>
            </div>
        </div>

        <!-- Upload Media Card -->
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3 shadow">
                <div class="card-body">
                    <h5 class="card-title">Upload Media</h5>
                    <p class="card-text">Submit media files for completed assignments.</p>
                    <a href="{{ route('freelance.upload.media') }}" class="btn btn-light btn-sm mt-2">Upload Now</a>
                </div>
            </div>
        </div>

        <!-- Manage Bookings Card -->
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3 shadow">
                <div class="card-body">
                    <h5 class="card-title">Manage Bookings</h5>
                    <p class="card-text">View bookings assigned to events you're part of.</p>
                    <a href="{{ route('freelance.bookings.index') }}" class="btn btn-light btn-sm mt-2">View Bookings</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
