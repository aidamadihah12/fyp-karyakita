@extends('layouts.staff')

@section('title', 'Send Notification')

@section('content')
<h2>Send Notification</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('staff.notifications.send') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="message" class="form-label">Message</label>
        <textarea name="message" id="message" rows="4" class="form-control" required>{{ old('message') }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Send Notification</button>
</form>
@endsection
