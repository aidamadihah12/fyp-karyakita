<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Studio Karya Kita</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Chart.js for Profit Analytics Graph -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .wrapper {
            display: flex;
            height: 100vh;
            flex-direction: column;
        }
        .content-area {
            flex: 1;
            display: flex;
            overflow: hidden;
        }
        .sidebar {
            width: 220px;
            background-color: #343a40;
            color: #fff;
            padding-top: 1rem;
            flex-shrink: 0;
            height: 100%;
        }
        .sidebar a {
            color: #adb5bd;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
            color: #fff;
            text-decoration: none;
        }
        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #f8f9fa;
        }
        .topbar {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .topbar .logout-btn {
            color: white;
            border: none;
            background: none;
            font-size: 1rem;
        }
        .topbar .logout-btn:hover {
            color: #ffc107;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="wrapper">

    <!-- Top menu bar -->
    <div class="topbar">
        <div class="brand fw-bold fs-4">Studio Karya Kita</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn" title="Logout">Logout</button>
        </form>
    </div>

    <!-- Content area -->
    <div class="content-area">

        <!-- Sidebar -->
<nav class="sidebar">
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Home</a>
    <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">Manage Bookings</a>
    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Manage Users</a>
    <a href="{{ route('admin.payments.index') }}" class="{{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">Manage Payments</a>
    <a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}">Reports</a>
    <a href="{{ route('admin.events.index') }}" class="{{ request()->routeIs('admin.events.index') ? 'active' : '' }}">Manage Events</a>
    <a href="{{ route('admin.venues.index') }}" class="{{ request()->routeIs('admin.venues.*') ? 'active' : '' }}">Venues Listing</a>
    <a href="{{ route('admin.profit.analytics') }}" class="{{ request()->routeIs('admin.profit.analytics') ? 'active' : '' }}">Profit Analytics</a>
    <a href="{{ route('admin.system.testing') }}" class="{{ request()->routeIs('admin.system.testing') ? 'active' : '' }}">System Testing</a>
    <a href="{{ route('admin.liveview.index') }}" class="{{ request()->routeIs('admin.liveview.*') ? 'active' : '' }}">Live View</a>
    <a href="{{ route('admin.calendar') }}" class="{{ request()->routeIs('admin.calendar') ? 'active' : '' }}">📅 Calendar</a>
</nav>


        <!-- Main dashboard content -->
        <main class="main-content">
            <h2 class="mb-4">Admin</h2>

            <!-- Metrics Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary shadow">
                        <div class="card-body">
                            <h5>Total Users</h5>
                            <h3>{{ $usersCount }}</h3>
                            <small>All registered users</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success shadow">
                        <div class="card-body">
                            <h5>Total Bookings</h5>
                            <h3>{{ $bookingsCount }}</h3>
                            <small>All bookings made</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-info shadow">
                        <div class="card-body">
                            <h5>Total Payments</h5>
                            <h3>RM {{ number_format($totalPayments, 2) }}</h3>
                            <small>Payments received</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning shadow">
                        <div class="card-body">
                            <h5>Pending Bookings</h5>
                            <h3>{{ $pendingBookings }}</h3>
                            <small>Require action</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profit Analytics Graph -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5>Profit Analytics</h5>
                </div>
                <div class="card-body">
                    <canvas id="profitChart"></canvas>
                </div>
            </div>

            <!-- Recent Bookings Table -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5>Recent Bookings</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Client Name</th>
                                <th>Event Type</th>
                                <th>Event Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBookings as $booking)
                            <tr>
                                <td>{{ $booking->id }}</td>
                                <td>{{ optional($booking->user)->full_name ?? 'N/A' }}</td>
                                <td>{{ $booking->event_type }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->event_date)->format('d M Y') }}</td>
                                <td>
                                    <span class="badge
                                        @if($booking->status == 'Pending') bg-warning
                                        @elseif($booking->status == 'Confirmed') bg-success
                                        @else bg-secondary
                                        @endif">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center">No recent bookings found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Future profit analytics chart placeholder --}}
            {{-- <div id="profit-chart" style="height: 300px;"></div> --}}
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Profit Analytics Graph (using Chart.js)
    var ctx = document.getElementById('profitChart').getContext('2d');
    var profitChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Profit (RM)',
                data: [1200, 1900, 3000, 5000, 2000, 4000, 3500],
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return 'RM ' + tooltipItem.raw;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
</body>
</html>
