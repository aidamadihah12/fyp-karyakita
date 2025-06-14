@extends('layouts.admin')

@section('title', 'Manage Payments')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Manage Payments</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Booking ID</th>
                <th>Customer Name</th>
                <th>Payment Date</th>
                <th>Amount (RM)</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($payments as $payment)
            <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ $payment->booking->id ?? 'N/A' }}</td>
                <td>{{ $payment->booking->user->name ?? 'N/A' }}</td>
                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                <td>{{ number_format($payment->amount, 2) }}</td>
                <td>
                    <span class="badge {{ $payment->status === 'Successful' ? 'bg-success' : 'bg-danger' }}">
                        {{ $payment->status }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.payments.show', $payment->id) }}" class="btn btn-sm btn-info">View</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No payments found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div>
        {{ $payments->links() }}
    </div>
</div>
@endsection
