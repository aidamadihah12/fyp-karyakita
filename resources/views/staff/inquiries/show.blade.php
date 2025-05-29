@extends('layouts.admin')

@section('title', 'Inquiry Details')

@section('content')
<h2>Inquiry #{{ $inquiry->id }}</h2>

<table class="table table-bordered">
    <tr>
        <th>Name</th>
        <td>{{ $inquiry->name }}</td>
    </tr>
    <tr>
        <th>Email</th>
        <td>{{ $inquiry->email }}</td>
    </tr>
    <tr>
        <th>Message</th>
        <td>{{ $inquiry->message }}</td>
    </tr>
    <tr>
        <th>Date</th>
        <td>{{ $inquiry->created_at->format('d M Y H:i') }}</td>
    </tr>
</table>

<a href="{{ route('staff.inquiries') }}" class="btn btn-secondary">Back to Inquiries</a>
@endsection
