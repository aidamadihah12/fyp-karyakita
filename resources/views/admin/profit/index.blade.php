@extends('layouts.admin')

@section('title', 'Profit Analytics')

@section('content')
    <h2 class="mb-4">Profit Analytics</h2>

    @if($profits->isEmpty())
        <p>No payment data available.</p>
    @else
        <!-- Chart Container -->
        <canvas id="profitChart" height="100"></canvas>

        <!-- Table -->
        <table class="table table-bordered mt-5">
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

        <!-- Chart Script -->
        <script>
            const labels = {!! json_encode($profits->pluck('date')) !!};
            const data = {!! json_encode($profits->pluck('total_revenue')) !!};

            const ctx = document.getElementById('profitChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar', // or 'line'
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Monthly Revenue (RM)',
                        data: data,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Revenue (RM)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        }
                    }
                }
            });
        </script>
    @endif
@endsection
