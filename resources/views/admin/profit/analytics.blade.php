@extends('layouts.admin')

@section('title', 'Profit Analytics')

@section('content')
    <h2 class="mb-4">Profit Analytics</h2>

    @if($profits->isEmpty())
        <p>No payment data available.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Total Revenue (RM)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($profits as $profit)
                    <tr>
                        <td>{{ $profit->date }}</td>
                        <td>{{ number_format($profit->total_revenue, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
