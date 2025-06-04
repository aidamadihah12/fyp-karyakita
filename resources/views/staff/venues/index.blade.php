@extends('layouts.staff')

@section('content')
<div class="container">
    <h2>Venue List (Staff)</h2>
    <a href="{{ route('staff.venues.create') }}" class="btn btn-primary mb-3">Add New Venue</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($venues->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Location</th>
                <th>Location URL</th>
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
                <td>
                    @if($venue->location_url)
                        <a href="{{ $venue->location_url }}" target="_blank">View</a>
                    @else
                        <em>Not set</em>
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($venue->available_date)->format('Y-m-d') }}</td>
                <td>{{ number_format($venue->price, 2) }}</td>
                <td>
                    @if($venue->sample_photo)
                        <img src="{{ asset('uploads/' . $venue->sample_photo) }}" alt="Photo" width="80">
                    @else
                        <em>No image</em>
                    @endif
                </td>
                <td>
                    <a href="{{ route('staff.venues.show', $venue->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('staff.venues.edit', $venue->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('staff.venues.destroy', $venue->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $venues->links() }}

    @else
    <p>No venues found.</p>
    @endif
</div>
@endsection
