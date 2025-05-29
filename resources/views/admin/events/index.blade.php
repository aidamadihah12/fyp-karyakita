@extends('layouts.admin')

@section('title', 'Manage Events')

@section('content')
<div class="container">
    <h1>Manage Events</h1>

    <!-- Display success or error messages -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('admin.events.create') }}" class="btn btn-primary mb-3">Create New Event</a>

    <!-- Events Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Date</th>
                <th>Available Slots</th>
                <th>Current Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
                <tr>
                    <td>{{ $event->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($event->date)->format('Y-m-d') }}</td>
                    <td>{{ $event->available_slots }}</td>
                    <td>
                        @if ($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" width="50" alt="Event Image">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this event?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    {{ $events->links() }}
</div>
@endsection
