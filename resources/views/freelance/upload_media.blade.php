@extends('layouts.freelance')

@section('title', 'Upload Media')

@section('content')
<h2>Upload Media</h2>

<!-- Success message -->
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Error message -->
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<!-- Validation errors -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('freelance.upload.media') }}" enctype="multipart/form-data">
    @csrf
<div class="mb-3">
    <label for="event_id" class="form-label">Event</label>
    <select id="event_id" name="event_id" class="form-select" required>
        <option value="">-- Select Event --</option>
        @foreach($events as $event)
            <option value="{{ $event->id }}">
                {{ $event->event_type }} - {{ $event->event_date->format('d M Y') }}
            </option>
        @endforeach
    </select>
</div>


    <div class="mb-3">
        <label for="media_files" class="form-label">Upload Media Files</label>
        <input type="file" name="media_files[]" id="media_files" multiple class="form-control" required>
        <small class="form-text text-muted">Allowed types: jpg, jpeg, png, mp4, mov. Max size per file: 20MB.</small>
    </div>

    <button type="submit" class="btn btn-primary">Upload</button>
</form>
@endsection
