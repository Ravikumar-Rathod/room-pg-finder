@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Total Users -->
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="bg-primary text-white rounded p-3 me-3">
                    <i class="fas fa-users fa-2x"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0">Total Users</h6>
                    <h3 class="mb-0">{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Rooms -->
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="bg-success text-white rounded p-3 me-3">
                    <i class="fas fa-bed fa-2x"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0">Total Rooms</h6>
                    <h3 class="mb-0">{{ $totalRooms }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Bookings -->
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="bg-warning text-white rounded p-3 me-3">
                    <i class="fas fa-calendar fa-2x"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0">Total Bookings</h6>
                    <h3 class="mb-0">{{ $totalBookings }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="bg-danger text-white rounded p-3 me-3">
                    <i class="fas fa-credit-card fa-2x"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0">Total Revenue</h6>
                    <h3 class="mb-0">₹{{ number_format($totalPayments, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Bookings -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Recent Bookings</h5>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Room</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBookings as $booking)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->room->title }}</td>
                    <td>{{ $booking->booking_date }}</td>
                    <td>
                        @if($booking->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($booking->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No Bookings Found!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection 
