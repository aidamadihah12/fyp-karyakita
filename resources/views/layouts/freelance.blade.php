<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Studio Karya Kita - Freelance')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        /* Full height with flex */
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
        .brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
    </style>
</head>
<body>

<div class="wrapper">

    <!-- Topbar -->
    <div class="topbar">
        <div class="brand">Studio Karya Kita - Freelance</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn" title="Logout">Logout</button>
        </form>
    </div>

    <!-- Content area -->
    <div class="content-area">

        <!-- Sidebar menu -->
        <nav class="sidebar">
            <a href="{{ route('freelance.dashboard') }}" class="{{ request()->routeIs('freelance.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('freelance.availability.edit') }}" class="{{ request()->routeIs('freelance.availability.*') ? 'active' : '' }}">Update Availability</a>
            <a href="{{ route('freelance.assignments') }}" class="{{ request()->routeIs('freelance.assignments*') ? 'active' : '' }}">Accept Assignment</a>
            <a href="{{ route('freelance.upload.media.form') }}" class="{{ request()->routeIs('freelance.upload.media.*') ? 'active' : '' }}">Upload Media</a>
            <a href="{{ route('freelance.calendar') }}" class="{{ request()->routeIs('freelance.calendar') ? 'active' : '' }}">📅 Calendar</a>

        </nav>

        <!-- Main content -->
        <main class="main-content">
            @yield('content')
        </main>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
