@extends('layouts.freelance')


@section('title', 'Assignments')

@section('content')
<h2>Assignments</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Event</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($assignments as $assignment)
        <tr>
            <td>{{ $assignment->id }}</td>
            <td>{{ $assignment->event->name ?? 'N/A' }}</td>
            <td>{{ ucfirst($assignment->status) }}</td>
            <td>
                @if($assignment->status === 'pending')
                    <form action="{{ route('freelance.assignments.accept', $assignment->id) }}" method="POST" onsubmit="return confirm('Accept this assignment?');">
                        @csrf
                        <button class="btn btn-success btn-sm">Accept</button>
                    </form>
                @else
                    -
                @endif
            </td>
        </tr>
        @empty
        <tr><td colspan="4" class="text-center">No assignments found.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $assignments->links() }}
@endsection
