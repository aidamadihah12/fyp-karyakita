@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Edit Venue</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.venues.update', $venue->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Venue Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $venue->name) }}">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description', $venue->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control" value="{{ old('location', $venue->location) }}">
        </div>

        <div class="mb-3">
            <label>Package Type</label>
            <input type="text" name="package_type" class="form-control" value="{{ old('package_type', $venue->package_type) }}">
        </div>

        <div class="mb-3">
            <label>Event Type</label>
            <input type="text" name="event_type" class="form-control" value="{{ old('event_type', $venue->event_type) }}">
        </div>

        <div class="mb-3">
            <label>Available Date</label>
            <input type="date" name="available_date" class="form-control" value="{{ old('available_date', $venue->available_date) }}">
        </div>

        <div class="mb-3">
            <label>Price (RM)</label>
            <input type="number" name="price" step="0.01" class="form-control" value="{{ old('price', $venue->price) }}">
        </div>

        <div class="mb-3">
            <label>Replace Photo</label>
            <input type="file" name="sample_photo" class="form-control">
        </div>

        @if($venue->sample_photo)
            <div class="mb-3">
                <img src="{{ asset('uploads/' . $venue->sample_photo) }}" width="120">
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Update Venue</button>
        <a href="{{ route('admin.venues.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
