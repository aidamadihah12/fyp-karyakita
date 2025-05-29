<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Manage Users - Studio Karya Kita</title>
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

    <div class="content-area">

        <!-- Sidebar -->
        <nav class="sidebar">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Home</a>
            <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">Manage Bookings</a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Manage Users</a>
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
            <h2 class="mb-4">Manage Users</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->user_role }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>

                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>

<div>
    {{ $users->links() }}  <!-- This generates the pagination links -->
</div>

        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
