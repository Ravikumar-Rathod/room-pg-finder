@extends('layouts.user')

@section('title', 'Search Rooms')

@section('content')
<!-- Filter Section -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="fas fa-filter"></i> Filter Rooms</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('user.rooms.index') }}">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">State</label>
                    <input type="text" name="state" class="form-control"
                        value="{{ request('state') }}" placeholder="Enter State">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">District</label>
                    <input type="text" name="district" class="form-control"
                        value="{{ request('district') }}" placeholder="Enter District">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Area</label>
                    <input type="text" name="area" class="form-control"
                        value="{{ request('area') }}" placeholder="Enter Area">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Room Type</label>
                    <select name="room_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="single" {{ request('room_type') == 'single' ? 'selected' : '' }}>Single</option>
                        <option value="sharing" {{ request('room_type') == 'sharing' ? 'selected' : '' }}>Sharing</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Min Rent (₹)</label>
                    <input type="number" name="min_rent" class="form-control"
                        value="{{ request('min_rent') }}" placeholder="Min Rent">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Max Rent (₹)</label>
                    <input type="number" name="max_rent" class="form-control"
                        value="{{ request('max_rent') }}" placeholder="Max Rent">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Facilities</label>
                    <div class="mt-1">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="wifi" class="form-check-input"
                                {{ request('wifi') ? 'checked' : '' }}>
                            <label class="form-check-label">WiFi</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="ac" class="form-check-input"
                                {{ request('ac') ? 'checked' : '' }}>
                            <label class="form-check-label">AC</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="food" class="form-check-input"
                                {{ request('food') ? 'checked' : '' }}>
                            <label class="form-check-label">Food</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <a href="{{ route('user.rooms.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Rooms List -->
<div class="row">
    @forelse($rooms as $room)
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm h-100">
            @if($room->images && count($room->images) > 0)
                <img src="{{ asset('storage/'.$room->images[0]) }}"
                    class="card-img-top"
                    height="180"
                    style="object-fit:cover;">
            @else
                <div class="bg-light text-center py-5">
                    <i class="fas fa-bed fa-3x text-muted"></i>
                </div>
            @endif
            <div class="card-body">
                <h6 class="card-title">{{ $room->title }}</h6>
                <p class="text-muted small mb-1">
                    <i class="fas fa-map-marker-alt text-danger"></i>
                    {{ $room->location->area }}, {{ $room->location->district }},
                    {{ $room->location->state }}
                </p>
                <p class="text-primary fw-bold mb-2">
                    ₹{{ number_format($room->rent, 2) }}/month
                </p>
                <p class="small text-muted mb-2">
                    <span class="badge bg-info">{{ ucfirst($room->room_type) }}</span>
                </p>
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
                <div class="mb-2">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $room->rating ? 'text-warning' : 'text-muted' }}"></i>
                    @endfor
                </div>
                <a href="{{ route('user.rooms.show', $room->id) }}"
                    class="btn btn-primary btn-sm w-100">
                    <i class="fas fa-eye"></i> View Details
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <i class="fas fa-bed fa-3x text-muted mb-3"></i>
        <p class="text-muted">No Rooms Found!</p>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-3">
    {{ $rooms->links() }}
</div>
@endsection