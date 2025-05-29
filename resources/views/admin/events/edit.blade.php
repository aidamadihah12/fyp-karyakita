@extends('layouts.admin')

@section('title', 'Edit Event')

@section('content')
<div class="container">
    <h1>Edit Event</h1>

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

    <!-- Event Edit Form -->
    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')  <!-- Specify the HTTP method as PUT for updating an existing resource -->

        <!-- Event Name -->
        <div class="form-group">
            <label for="name">Event Name</label>
            <input name="name" type="text" class="form-control" value="{{ old('name', $event->name) }}" required>
        </div>

        <!-- Event Date -->
        <div class="form-group">
            <label for="date">Event Date</label>
            <input name="date" type="date" class="form-control" value="{{ old('date', $event->date) }}" required>
        </div>

        <!-- Available Slots -->
        <div class="form-group">
            <label for="available_slots">Available Slots</label>
            <input name="available_slots" type="number" class="form-control" value="{{ old('available_slots', $event->available_slots) }}" required>
        </div>

        <!-- Current Event Image -->
        <div class="form-group">
            <label>Current Image</label><br>
            @if($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" width="100" alt="Event Image">
            @else
                <span>N/A</span>
            @endif
        </div>

        <!-- Image Upload for Change -->
        <div class="form-group">
            <label for="image">Change Image (optional)</label>
            <input name="image" type="file" class="form-control">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary mt-3">Update Event</button>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary mt-3 ms-2">Back to Event List</a>
    </form>
</div>
@endsection
