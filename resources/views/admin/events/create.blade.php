@extends('layouts.admin')

@section('title', 'Create Event')

@section('content')
<div class="container">
    <h2>Create New Event</h2>

    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Event creation form -->
    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Event Name -->
        <div class="form-group">
            <label for="name">Event Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <!-- Event Date -->
        <div class="form-group">
            <label for="date">Event Date</label>
            <input type="date" id="date" name="date" class="form-control" value="{{ old('date') }}" required>
        </div>

        <!-- Available Slots -->
        <div class="form-group">
            <label for="available_slots">Available Slots</label>
            <input type="number" id="available_slots" name="available_slots" class="form-control" value="{{ old('available_slots') }}" required>
        </div>

        <!-- Event Image -->
        <div class="form-group">
            <label for="image">Event Image (optional)</label>
            <input type="file" id="image" name="image" class="form-control">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary mt-3">Create Event</button>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary mt-3 ms-2">Back to Event List</a>
    </form>
</div>
@endsection
