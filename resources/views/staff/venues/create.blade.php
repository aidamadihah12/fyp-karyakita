@extends('layouts.staff')

@section('content')
<div class="container">
    <h2>Add New Venue</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There are some problems with your input:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('staff.venues.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Venue Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" name="location" class="form-control" value="{{ old('location') }}" required>
        </div>

        <div class="mb-3">
            <label for="location_url" class="form-label">Location URL (Google Maps link)</label>
            <input type="url" name="location_url" class="form-control" value="{{ old('location_url') }}">
        </div>

        <div class="mb-3">
            <label for="package_type" class="form-label">Package Type</label>
            <input type="text" name="package_type" class="form-control" value="{{ old('package_type') }}" required>
        </div>

        <div class="mb-3">
            <label for="event_type" class="form-label">Event Type</label>
            <input type="text" name="event_type" class="form-control" value="{{ old('event_type') }}" required>
        </div>

        <div class="mb-3">
            <label for="available_date" class="form-label">Available Date</label>
            <input type="date" name="available_date" class="form-control" value="{{ old('available_date') }}" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price (RM)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required>
        </div>

        <div class="mb-3">
            <label for="sample_photo" class="form-label">Sample Photo</label>
            <input type="file" name="sample_photo" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Save Venue</button>
        <a href="{{ route('staff.venues.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
