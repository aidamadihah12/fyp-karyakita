@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Assign Freelance Photographer</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.assignments.assign') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="event_id">Customer & Event</label>
            <select name="event_id" id="event_id" class="form-control @error('event_id') is-invalid @enderror" required>
                <option value="">-- Select Customer & Event --</option>
                @forelse($customers as $customer)
                    @if($customer->event)
                        <option value="{{ $customer->event->id }}" {{ old('event_id') == $customer->event->id ? 'selected' : '' }}>
                            {{ $customer->id }} - {{ $customer->name }} - {{ \Carbon\Carbon::parse($customer->event->event_date)->format('Y-m-d') }}
                        </option>
                    @endif
                @empty
                    <option disabled>No customers with events available</option>
                @endforelse
            </select>
            @error('event_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="freelancer_id">Freelance Photographer</label>
            <select name="freelancer_id" id="freelancer_id" class="form-control @error('freelancer_id') is-invalid @enderror" required>
                <option value="">-- Select Freelancer --</option>
                @forelse($freelancers as $freelancer)
                    <option value="{{ $freelancer->id }}" {{ old('freelancer_id') == $freelancer->id ? 'selected' : '' }}>
                        {{ $freelancer->name }}
                    </option>
                @empty
                    <option disabled>No freelancers available</option>
                @endforelse
            </select>
            @error('freelancer_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Assign Photographer</button>
            <a href="{{ route('admin.assignments.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
