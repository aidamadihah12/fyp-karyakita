@extends('layouts.freelance')


@section('title', 'Update Availability')

@section('content')
<h2>Update Availability</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('freelance.availability.update') }}">
    @csrf

    <div class="form-check form-switch mb-3">
        <input class="form-check-input" type="checkbox" id="availability" name="availability" value="1" {{ $availability ? 'checked' : '' }}>
        <label class="form-check-label" for="availability">Available for assignments</label>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
