<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Room & PG Finder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }
        .sidebar {
            min-height: 100vh;
            background: #2c3e50;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
        }
        .sidebar .brand {
            padding: 20px;
            color: white;
            font-size: 20px;
            font-weight: bold;
            border-bottom: 1px solid #3d5166;
        }
        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #b2bec3;
            text-decoration: none;
            transition: all 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background: #3d5166;
            color: white;
        }
        .sidebar a i { margin-right: 10px; }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .navbar-top {
            background: white;
            padding: 15px 20px;
            margin: -20px -20px 20px -20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="brand">
        <i class="fas fa-home"></i> Room & PG
    </div>
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a href="{{ route('admin.rooms.index') }}" class="{{ request()->routeIs('admin.rooms*') ? 'active' : '' }}">
        <i class="fas fa-bed"></i> Rooms
    </a>
    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Users
    </a>
    <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings*') ? 'active' : '' }}">
        <i class="fas fa-calendar"></i> Bookings
    </a>
    <a href="{{ route('admin.payments.index') }}" class="{{ request()->routeIs('admin.payments*') ? 'active' : '' }}">
        <i class="fas fa-credit-card"></i> Payments
    </a>
    <a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
        <i class="fas fa-star"></i> Reviews
    </a>
    <a href="{{ route('admin.locations.index') }}" class="{{ request()->routeIs('admin.locations*') ? 'active' : '' }}">
        <i class="fas fa-map-marker-alt"></i> Locations
    </a>
    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="navbar-top">
        <h5 class="mb-0">@yield('title', 'Dashboard')</h5>
        <span><i class="fas fa-user-circle"></i> {{ auth()->user()->name }}</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>