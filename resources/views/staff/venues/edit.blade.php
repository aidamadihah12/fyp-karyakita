@extends('layouts.staff')

@section('content')
<div class="container">
    <h2>Edit Venue (Staff)</h2>

    <form method="POST" action="{{ route('staff.venues.update', $venue->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $venue->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description', $venue->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control" value="{{ old('location', $venue->location) }}" required>
        </div>

        <div class="mb-3">
            <label>Package Type</label>
            <input type="text" name="package_type" class="form-control" value="{{ old('package_type', $venue->package_type) }}" required>
        </div>

        <div class="mb-3">
            <label>Event Type</label>
            <input type="text" name="event_type" class="form-control" value="{{ old('event_type', $venue->event_type) }}" required>
        </div>

        <div class="mb-3">
            <label>Available Date</label>
            <input type="date" name="available_date" class="form-control" value="{{ old('available_date', $venue->available_date) }}" required>
        </div>

        <div class="mb-3">
            <label>Price (RM)</label>
            <input type="number" name="price" step="0.01" class="form-control" value="{{ old('price', $venue->price) }}" required>
        </div>

        <div class="mb-3">
            <label>Replace Photo</label>
            <input type="file" name="sample_photo" class="form-control">
        </div>

        @if($venue->sample_photo)
            <div class="mb-3">
                <img src="{{ asset('uploads/' . $venue->sample_photo) }}" width="100">
            </div>
        @endif

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('staff.venues.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
