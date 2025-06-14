@extends('layouts.admin')

@section('title', 'Payment Details')

@section('content')
<div class="container">
    <h2 class="mb-4">Payment #{{ $payment->id }} Details</h2>

    <table class="table table-bordered w-50">
        <tr>
            <th>Booking ID</th>
            <td>{{ $payment->booking->id ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Client Name</th>
            <td>{{ $payment->booking->user->full_name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Payment Date</th>
            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y H:i') }}</td>
        </tr>
        <tr>
            <th>Amount (RM)</th>
            <td>{{ number_format($payment->amount, 2) }}</td>
        </tr>
        <tr>
            <th>Payment Method</th>
            <td>{{ $payment->payment_method }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <span class="badge {{ $payment->status === 'Successful' ? 'bg-success' : 'bg-danger' }}">
                    {{ $payment->status }}
                </span>
            </td>
        </tr>
    </table>

    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary mt-3">Back to Payments</a>
</div>
@endsection
