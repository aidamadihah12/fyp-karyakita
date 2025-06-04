@extends('layouts.freelance')

@section('content')
<div class="container">
    <h2>Your Assignments</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($assignments->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Status</th>
                <th>Assigned Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assignments as $assignment)
            <tr>
                <td>{{ $assignment->event->name ?? 'N/A' }}</td>
                <td>{{ ucfirst($assignment->status) }}</td>
                <td>{{ $assignment->created_at->format('Y-m-d') }}</td>
                <td>
                    @if($assignment->status == 'pending')
                        <form action="{{ route('freelance.assignments.accept', $assignment->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success btn-sm" onclick="return confirm('Accept this assignment?')">Accept</button>
                        </form>
                    @else
                        <span class="text-muted">Accepted</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $assignments->links() }}

    @else
    <p>No assignments found.</p>
    @endif
</div>
@endsection
