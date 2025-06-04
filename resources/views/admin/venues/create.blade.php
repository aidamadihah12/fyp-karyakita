@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Add New Venue</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.venues.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Venue Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control" required value="{{ old('location') }}">
        </div>

        <div class="mb-3">
            <label>Location URL</label>
            <input type="url" name="location_url" class="form-control" placeholder="https://maps.google.com/..." value="{{ old('location_url') }}">
        </div>

        <div class="mb-3">
            <label>Package Type</label>
            <input type="text" name="package_type" class="form-control" required value="{{ old('package_type') }}">
        </div>

        <div class="mb-3">
            <label>Event Type</label>
            <input type="text" name="event_type" class="form-control" required value="{{ old('event_type') }}">
        </div>

        <div class="mb-3">
            <label>Available Date</label>
            <input type="date" name="available_date" class="form-control" required value="{{ old('available_date') }}">
        </div>

        <div class="mb-3">
            <label>Price (RM)</label>
            <input type="number" name="price" step="0.01" class="form-control" required value="{{ old('price') }}">
        </div>

        <div class="mb-3">
            <label>Sample Photo</label>
            <input type="file" name="sample_photo" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Create Venue</button>
        <a href="{{ route('admin.venues.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
