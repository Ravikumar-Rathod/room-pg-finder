@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Total Bookings -->
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="bg-primary text-white rounded p-3 me-3">
                    <i class="fas fa-calendar fa-2x"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0">Total Bookings</h6>
                    <h3 class="mb-0">{{ $totalBookings }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Bookings -->
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="bg-warning text-white rounded p-3 me-3">
                    <i class="fas fa-clock fa-2x"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0">Pending Bookings</h6>
                    <h3 class="mb-0">{{ $pendingBookings }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Approved Bookings -->
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="bg-success text-white rounded p-3 me-3">
                    <i class="fas fa-check fa-2x"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0">Approved Bookings</h6>
                    <h3 class="mb-0">{{ $approvedBookings }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Rooms -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Available Rooms</h5>
        <a href="{{ route('user.rooms.index') }}" class="btn btn-primary btn-sm">
            View All
        </a>
    </div>
    <div class="card-body">
        <div class="row">
            @forelse($recentRooms as $room)
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    @if($room->image)
                        <img src="{{ asset('storage/'.$room->image) }}"
                            class="card-img-top" height="180"
                            style="object-fit:cover;">
                    @else
                        <div class="bg-light text-center py-5">
                            <i class="fas fa-bed fa-3x text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h6 class="card-title">{{ $room->title }}</h6>
                        <p class="text-muted small mb-1">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $room->location->area }}, {{ $room->location->district }}
                        </p>
                        <p class="text-primary fw-bold mb-2">₹{{ number_format($room->rent, 2) }}/month</p>
                        <div class="mb-2">
                            @if($room->wifi)
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-wifi"></i> WiFi
                                </span>
                            @endif
                            @if($room->ac)
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-snowflake"></i> AC
                                </span>
                            @endif
                            @if($room->food)
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-utensils"></i> Food
                                </span>
                            @endif
                        </div>
                        <a href="{{ route('user.rooms.show', $room->id) }}"
                            class="btn btn-primary btn-sm w-100">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">No Rooms Available!</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection