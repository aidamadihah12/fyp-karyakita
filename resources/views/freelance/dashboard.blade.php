@extends('layouts.freelance')

@section('title', 'Freelance Dashboard')

@section('content')
<h2>Welcome, {{ auth()->user()->full_name }}</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Current Availability</h5>
                <p class="card-text fs-3">{{ $availability ? 'Available' : 'Not Available' }}</p>
                <a href="{{ route('freelance.availability.edit') }}" class="btn btn-light btn-sm">Update Availability</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Your Assignments</h5>
                <a href="{{ route('freelance.assignments') }}" class="btn btn-light btn-sm mt-3">View Assignments</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Upload Media</h5>
                <a href="{{ route('freelance.upload.media.form') }}" class="btn btn-light btn-sm mt-3">Upload Now</a>
            </div>
        </div>
    </div>
</div>
@endsection
