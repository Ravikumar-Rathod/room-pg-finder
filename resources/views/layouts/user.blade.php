<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room & PG Finder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }
        .sidebar {
            min-height: 100vh;
            background: #1a73e8;
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
            border-bottom: 1px solid #1557b0;
        }
        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background: #1557b0;
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
    <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a href="{{ route('user.rooms.index') }}" class="{{ request()->routeIs('user.rooms*') ? 'active' : '' }}">
        <i class="fas fa-search"></i> Search Rooms
    </a>
    <a href="{{ route('user.bookings.index') }}" class="{{ request()->routeIs('user.bookings*') ? 'active' : '' }}">
        <i class="fas fa-calendar"></i> My Bookings
    </a>
    <a href="{{ route('user.profile.index') }}" class="{{ request()->routeIs('user.profile*') ? 'active' : '' }}">
        <i class="fas fa-user"></i> Profile
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