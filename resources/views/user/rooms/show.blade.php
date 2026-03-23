@extends('layouts.user')

@section('title', 'Room Details')

@section('content')
<div class="row">
    <div class="col-md-8">

        <!-- Image Carousel -->
        <div class="card border-0 shadow-sm mb-4">
            @if($room->images && count($room->images) > 0)
            <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @foreach($room->images as $key => $image)
                        <button type="button" data-bs-target="#roomCarousel"
                            data-bs-slide-to="{{ $key }}"
                            class="{{ $key == 0 ? 'active' : '' }}"></button>
                    @endforeach
                </div>
                <div class="carousel-inner">
                    @foreach($room->images as $key => $image)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/'.$image) }}"
                            class="d-block w-100"
                            style="height:350px; object-fit:cover;">
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button"
                    data-bs-target="#roomCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button"
                    data-bs-target="#roomCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>

            <!-- Thumbnails -->
            <div class="card-body pb-0">
                <div class="row">
                    @foreach($room->images as $key => $image)
                    <div class="col-3 mb-2">
                        <img src="{{ asset('storage/'.$image) }}"
                            class="img-fluid rounded shadow-sm"
                            style="height:70px; width:100%; object-fit:cover; cursor:pointer;"
                            onclick="goToSlide({{ $key }})">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="card-body">
                <h4>{{ $room->title }}</h4>
                <p class="text-muted">
                    <i class="fas fa-map-marker-alt text-danger"></i>
                    {{ $room->full_address }},
                    {{ $room->location->area }},
                    {{ $room->location->district }},
                    {{ $room->location->state }}
                </p>
                <h5 class="text-primary">₹{{ number_format($room->rent, 2) }}/month</h5>
                <span class="badge bg-info mb-3">{{ ucfirst($room->room_type) }}</span>

                <h6 class="mt-3">Description</h6>
                <p>{{ $room->description }}</p>

                <h6>Facilities</h6>
                <div class="mb-3">
                    <span class="badge {{ $room->wifi ? 'bg-success' : 'bg-secondary' }} me-1 p-2">
                        <i class="fas fa-wifi"></i> WiFi
                    </span>
                    <span class="badge {{ $room->ac ? 'bg-success' : 'bg-secondary' }} me-1 p-2">
                        <i class="fas fa-snowflake"></i> AC
                    </span>
                    <span class="badge {{ $room->food ? 'bg-success' : 'bg-secondary' }} me-1 p-2">
                        <i class="fas fa-utensils"></i> Food
                    </span>
                </div>

                <div class="mb-3">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $room->rating ? 'text-warning' : 'text-muted' }}"></i>
                    @endfor
                    <span class="text-muted ms-1">({{ $reviews->count() }} reviews)</span>
                </div>

                @if($room->is_available)
                <form action="{{ route('user.bookings.store', $room->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-calendar-check"></i> Book Now
                    </button>
                </form>
                @else
                <button class="btn btn-secondary btn-lg" disabled>
                    <i class="fas fa-times"></i> Not Available
                </button>
                @endif
            </div>
        </div>

        <!-- Map Location -->
        @if($room->latitude && $room->longitude)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-map-marker-alt text-danger"></i> Room Location
                </h5>
            </div>
            <div class="card-body p-0">
                <div id="map" style="height:300px; border-radius:0 0 10px 10px;"></div>
            </div>
        </div>
        @endif

        <!-- Reviews -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Reviews ({{ $reviews->count() }})</h5>
            </div>
            <div class="card-body">
                @forelse($reviews as $review)
                <div class="border-bottom pb-3 mb-3">
                    <div class="d-flex justify-content-between">
                        <strong><i class="fas fa-user-circle"></i> {{ $review->user->name }}</strong>
                        <small class="text-muted">{{ $review->created_at->format('d M Y') }}</small>
                    </div>
                    <div class="my-1">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                        @endfor
                    </div>
                    <p class="mb-0">{{ $review->comment }}</p>
                </div>
                @empty
                <p class="text-muted text-center">No Reviews Yet! Be the first to review!</p>
                @endforelse
            </div>
        </div>

        <!-- Add Review -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Add Your Review</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user.reviews.store', $room->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <select name="rating" class="form-select" required>
                            <option value="">Select Rating</option>
                            <option value="1">⭐ 1 - Poor</option>
                            <option value="2">⭐⭐ 2 - Fair</option>
                            <option value="3">⭐⭐⭐ 3 - Good</option>
                            <option value="4">⭐⭐⭐⭐ 4 - Very Good</option>
                            <option value="5">⭐⭐⭐⭐⭐ 5 - Excellent</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Comment</label>
                        <textarea name="comment" class="form-control"
                            rows="3" required placeholder="Write your review..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Submit Review
                    </button>
                </form>
            </div>
        </div>

    </div>

    <!-- Right Side Info -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h6 class="text-muted">Room Info</h6>
                <hr>
                <p><strong>Type:</strong> {{ ucfirst($room->room_type) }}</p>
                <p><strong>Rent:</strong> ₹{{ number_format($room->rent, 2) }}/month</p>
                <p><strong>Status:</strong>
                    @if($room->is_available)
                        <span class="badge bg-success">Available</span>
                    @else
                        <span class="badge bg-danger">Not Available</span>
                    @endif
                </p>
                <p><strong>Rating:</strong>
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $room->rating ? 'text-warning' : 'text-muted' }}"></i>
                    @endfor
                </p>
                <hr>
                <h6 class="text-muted">Facilities</h6>
                <p>
                    <i class="fas fa-wifi {{ $room->wifi ? 'text-success' : 'text-muted' }}"></i>
                    WiFi: {{ $room->wifi ? 'Yes' : 'No' }}
                </p>
                <p>
                    <i class="fas fa-snowflake {{ $room->ac ? 'text-success' : 'text-muted' }}"></i>
                    AC: {{ $room->ac ? 'Yes' : 'No' }}
                </p>
                <p>
                    <i class="fas fa-utensils {{ $room->food ? 'text-success' : 'text-muted' }}"></i>
                    Food: {{ $room->food ? 'Yes' : 'No' }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@if($room->latitude && $room->longitude)
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
var map = L.map('map').setView([{{ $room->latitude }}, {{ $room->longitude }}], 15);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
}).addTo(map);

L.marker([{{ $room->latitude }}, {{ $room->longitude }}])
    .addTo(map)
    .bindPopup('📍 <strong>{{ $room->title }}</strong><br>{{ $room->full_address }}')
    .openPopup();
</script>
@endif

<script>
function goToSlide(index) {
    var carousel = bootstrap.Carousel.getInstance(document.getElementById('roomCarousel'));
    carousel.to(index);
}
</script>
@endsection