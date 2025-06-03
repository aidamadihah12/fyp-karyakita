@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Venue Management (Admin)</h2>
    <a href="{{ route('admin.venues.create') }}" class="btn btn-primary mb-3">+ Add New Venue</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Location</th>
                <th>Package Type</th>
                <th>Event Type</th>
                <th>Available Date</th>
                <th>Price (RM)</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venues as $venue)
            <tr>
                <td>{{ $venue->name }}</td>
                <td>{{ $venue->location }}</td>
                <td>{{ $venue->package_type }}</td>
                <td>{{ $venue->event_type }}</td>
                <td>{{ $venue->available_date }}</td>
                <td>{{ number_format($venue->price, 2) }}</td>
                <td>
                    @if($venue->sample_photo)
                        <img src="{{ asset('uploads/' . $venue->sample_photo) }}" alt="Photo" width="80">
                    @else
                        <em>No image</em>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.venues.edit', $venue->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.venues.destroy', $venue->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this venue?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $venues->links() }}
</div>
@endsection
