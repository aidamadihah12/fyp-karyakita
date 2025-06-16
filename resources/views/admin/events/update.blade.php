@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Event</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Name</label>
            <input name="name" class="form-control" value="{{ $event->name }}" required>
        </div>
        <div class="form-group">
            <label>Date</label>
            <input type="date" name="event_date" class="form-control" value="{{ old('event_date', $event->event_date ?? '') }}">
        </div>
        <div class="form-group">
            <label>Available Slots</label>
            <input name="available_slots" type="number" class="form-control" value="{{ $event->available_slots }}" required>
        </div>
        <div class="form-group">
            <label>Current Image</label><br>
            @if($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" width="100">
            @else
                N/A
            @endif
        </div>
        <div class="form-group">
            <label>Change Image</label>
            <input name="image" type="file" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
