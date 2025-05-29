<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Studio Karya Kita')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body, html { height: 100%; margin: 0; }
        .wrapper { display: flex; height: 100vh; flex-direction: column; }
        .content-area { flex: 1; display: flex; overflow: hidden; }
        .sidebar {
            width: 220px; background-color: #343a40; color: #fff; padding-top: 1rem; flex-shrink: 0; height: 100%;
        }
        .sidebar a {
            color: #adb5bd; display: block; padding: 10px 20px; text-decoration: none;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #495057; color: #fff; text-decoration: none;
        }
        .main-content {
            flex: 1; padding: 20px; overflow-y: auto; background-color: #f8f9fa;
        }
        .topbar {
            background-color: #007bff; color: white; padding: 10px 20px; display: flex; justify-content: space-between; align-items: center;
        }
        .topbar .logout-btn { color: white; border: none; background: none; font-size: 1rem; }
        .topbar .logout-btn:hover { color: #ffc107; cursor: pointer; }
    </style>
</head>
<body>
<div class="wrapper">

    <!-- Topbar -->
    <div class="topbar">
        <div class="brand fw-bold fs-4">Studio Karya Kita</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn" title="Logout">Logout</button>
        </form>
    </div>

    <!-- Content area -->
    <div class="content-area">

        <!-- Sidebar menu -->
        <nav class="sidebar">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Home</a>
            <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">Manage Bookings</a>
            <a href="{{ route('admin.users.index') }}" class="nav-link">Manage Users</a>
            <a href="{{ route('admin.payments.index') }}" class="{{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">Manage Payments</a>
            <a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}">Reports</a>
            <a href="{{ route('admin.events.index') }}" class="{{ request()->routeIs('admin.events.index') ? 'active' : '' }}">Manage Events</a>
            <a href="{{ route('admin.profit.analytics') }}" class="{{ request()->routeIs('admin.profit.analytics') ? 'active' : '' }}">Profit Analytics</a>
            <a href="{{ route('admin.system.testing') }}" class="{{ request()->routeIs('admin.system.testing') ? 'active' : '' }}">System Testing</a>
            <a href="{{ route('admin.liveview.index') }}" class="{{ request()->routeIs('admin.liveview.*') ? 'active' : '' }}">Live View</a>
            <a href="{{ route('admin.calendar') }}" class="{{ request()->routeIs('admin.calendar') ? 'active' : '' }}">📅 Calendar</a>
        </nav>

        <!-- Main content -->
        <main class="main-content">
            @yield('content') <!-- The main content will be injected here -->
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
