@extends('layouts.staff')

@section('title', 'Client Inquiries')

@section('content')
<h2>Client Inquiries</h2>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Client Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Date</th>
            <th>View</th>
        </tr>
    </thead>
    <tbody>
        @forelse($inquiries as $inq)
        <tr>
            <td>{{ $inq->id }}</td>
            <td>{{ $inq->name }}</td>
            <td>{{ $inq->email }}</td>
            <td>{{ Str::limit($inq->message, 50) }}</td>
            <td>{{ $inq->created_at->format('d M Y') }}</td>
            <td><a href="{{ route('staff.inquiries.show', $inq->id) }}" class="btn btn-sm btn-info">View</a></td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center">No inquiries found.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $inquiries->links() }}
@endsection
