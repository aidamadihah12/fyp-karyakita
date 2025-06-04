@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Assign Freelance Photographers</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

<form action="{{ route('admin.assignments.assign') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="event_id">Select Event</label>
            <select name="event_id" id="event_id" class="form-control" required>
                <option value="">-- Select Event --</option>
                @foreach($events as $event)
                    <option value="{{ $event->id }}">{{ $event->name }} - {{ $event->date }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mt-3">
            <label for="freelancer_id">Select Freelance Photographer</label>
            <select name="freelancer_id" id="freelancer_id" class="form-control" required>
                <option value="">-- Select Freelancer --</option>
                @foreach($freelancers as $freelancer)
                    <option value="{{ $freelancer->id }}">{{ $freelancer->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Assign Photographer</button>
    </form>
</div>
@endsection
