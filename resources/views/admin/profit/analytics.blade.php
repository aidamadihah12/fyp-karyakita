@extends('layouts.admin')

@section('title', 'Profit Analytics')

@section('content')
    <h2 class="mb-4">Profit Analytics</h2>

    <!-- Profit Chart Card -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <h5>Profit Analytics</h5>
        </div>
        <div class="card-body">
            <canvas id="profitChart" height="100"></canvas>
        </div>
    </div>

    <!-- Profit Table -->
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Date</th>
                <th>Total Revenue (RM)</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>2025-01</td><td>1200.00</td></tr>
            <tr><td>2025-02</td><td>1500.00</td></tr>
            <tr><td>2025-03</td><td>1000.00</td></tr>
            <tr><td>2025-04</td><td>1800.00</td></tr>
            <tr><td>2025-05</td><td>1600.00</td></tr>
            <tr><td>2025-06</td><td>1900.00</td></tr>
        </tbody>
    </table>

    <!-- Load Chart.js (MUST be included once) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Chart Script -->
    <script>
        const ctx = document.getElementById('profitChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['2025-01', '2025-02', '2025-03', '2025-04', '2025-05', '2025-06'],
                datasets: [{
                    label: 'Monthly Revenue (RM)',
                    data: [1200, 1500, 1000, 1800, 1600, 1900],
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
                            text: 'Month'
                        }
                    }
                }
            }
        });
    </script>
@endsection
