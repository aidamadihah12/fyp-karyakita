@extends('layouts.staff')

@section('content')
<div class="container">
    <h2>Venue List (Staff View)</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Location</th>
                <th>Package</th>
                <th>Event</th>
                <th>Date</th>
                <th>Price</th>
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
                        <img src="{{ asset('uploads/' . $venue->sample_photo) }}" width="70">
                    @else
                        <em>No image</em>
                    @endif
                </td>
                <td>
                    <a href="{{ route('staff.venues.edit', $venue->id) }}" class="btn btn-sm btn-info">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $venues->links() }}
</div>
@endsection
