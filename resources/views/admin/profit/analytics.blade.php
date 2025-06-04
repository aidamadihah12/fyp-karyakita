@extends('layouts.admin')

@section('title', 'Profit Analytics')

@section('content')
    <h2 class="mb-4">Profit Analytics</h2>

    @if($profits->isEmpty())
        <p>No payment data available.</p>
    @else
        <canvas id="profitChart" height="100"></canvas>

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

        <script>
            const labels = {!! json_encode($profits->pluck('date')) !!};
            const data = {!! json_encode($profits->pluck('total_revenue')) !!};

            const ctx = document.getElementById('profitChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Daily Revenue (RM)',
                        data: data,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
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
                                text: 'Date'
                            }
                        }
                    }
                }
            });
        </script>
    @endif
@endsection
