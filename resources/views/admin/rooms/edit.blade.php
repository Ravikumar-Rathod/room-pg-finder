@extends('layouts.admin')

@section('title', 'Edit Room')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Edit Room</h5>
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Room Title</label>
                    <input type="text" name="title" class="form-control"
                        value="{{ $room->title }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Rent (₹)</label>
                    <input type="number" name="rent" class="form-control"
                        value="{{ $room->rent }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Room Type</label>
                    <select name="room_type" class="form-select" required>
                        <option value="single" {{ $room->room_type == 'single' ? 'selected' : '' }}>Single</option>
                        <option value="sharing" {{ $room->room_type == 'sharing' ? 'selected' : '' }}>Sharing</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Location</label>
                    <select name="location_id" class="form-select" required>
                        <option value="">Select Location</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}"
                                {{ $room->location_id == $location->id ? 'selected' : '' }}>
                                {{ $location->area }}, {{ $location->district }}, {{ $location->state }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Full Address</label>
                    <input type="text" name="full_address" class="form-control"
                        value="{{ $room->full_address }}">
                </div>

                <!-- Map -->
                <div class="col-md-12 mb-3">
                    <label class="form-label">📍 Pick Location on Map</label>
                    <div id="map" style="height:350px; border-radius:10px; border:1px solid #ddd;"></div>
                    <small class="text-muted">Click on map to change location</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Latitude</label>
                    <input type="text" name="latitude" id="latitude"
                        class="form-control" value="{{ $room->latitude }}" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Longitude</label>
                    <input type="text" name="longitude" id="longitude"
                        class="form-control" value="{{ $room->longitude }}" readonly>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control"
                        rows="4" required>{{ $room->description }}</textarea>
                </div>

                <!-- Current Images -->
                @if($room->images && count($room->images) > 0)
                <div class="col-md-12 mb-3">
                    <label class="form-label">Current Images</label>
                    <div class="row">
                        @foreach($room->images as $image)
                        <div class="col-md-3 mb-2">
                            <img src="{{ asset('storage/'.$image) }}"
                                class="img-fluid rounded shadow-sm"
                                style="height:100px; width:100%; object-fit:cover;">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- New Images -->
                <div class="col-md-12 mb-3">
                    <label class="form-label">
                        Update Images
                        <span class="badge bg-info">Min 3 - Max 8</span>
                        <small class="text-muted">(Leave empty to keep current images)</small>
                    </label>
                    <input type="file" name="images[]" id="images"
                        class="form-control" accept="image/*"
                        multiple onchange="previewImages(this)">
                    <div id="imagePreview" class="row mt-3"></div>
                    <div id="imageCount" class="mt-1"></div>
                </div>

                <!-- Facilities -->
                <div class="col-md-12 mb-3">
                    <label class="form-label">Facilities</label>
                    <div class="mt-2">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="wifi" class="form-check-input"
                                id="wifi" {{ $room->wifi ? 'checked' : '' }}>
                            <label class="form-check-label" for="wifi">
                                <i class="fas fa-wifi"></i> WiFi
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="ac" class="form-check-input"
                                id="ac" {{ $room->ac ? 'checked' : '' }}>
                            <label class="form-check-label" for="ac">
                                <i class="fas fa-snowflake"></i> AC
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="food" class="form-check-input"
                                id="food" {{ $room->food ? 'checked' : '' }}>
                            <label class="form-check-label" for="food">
                                <i class="fas fa-utensils"></i> Food
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Room
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
// Map Setup - Show existing location if available
var lat = {{ $room->latitude ?? 22.2587 }};
var lng = {{ $room->longitude ?? 71.1924 }};
var zoom = {{ $room->latitude ? 15 : 7 }};

var map = L.map('map').setView([lat, lng], zoom);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
}).addTo(map);

var marker;

// Show existing marker
@if($room->latitude && $room->longitude)
marker = L.marker([{{ $room->latitude }}, {{ $room->longitude }}]).addTo(map);
marker.bindPopup('📍 {{ $room->title }}').openPopup();
@endif

map.on('click', function(e) {
    var lat = e.latlng.lat.toFixed(6);
    var lng = e.latlng.lng.toFixed(6);

    document.getElementById('latitude').value  = lat;
    document.getElementById('longitude').value = lng;

    if (marker) {
        marker.setLatLng(e.latlng);
    } else {
        marker = L.marker(e.latlng).addTo(map);
    }

    marker.bindPopup('📍 Selected Location<br>Lat: ' + lat + '<br>Lng: ' + lng).openPopup();
});

// Image Preview
function previewImages(input) {
    var preview = document.getElementById('imagePreview');
    var countDiv = document.getElementById('imageCount');
    preview.innerHTML = '';
    countDiv.innerHTML = '';

    var files = input.files;
    var count = files.length;

    if (count < 3) {
        countDiv.innerHTML = '<span class="text-danger">⚠️ Minimum 3 images required! You selected ' + count + '</span>';
        input.value = '';
        return;
    }

    if (count > 8) {
        countDiv.innerHTML = '<span class="text-danger">⚠️ Maximum 8 images allowed! You selected ' + count + '</span>';
        input.value = '';
        return;
    }

    countDiv.innerHTML = '<span class="text-success">✅ ' + count + ' images selected</span>';

    for (var i = 0; i < files.length; i++) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var col = document.createElement('div');
            col.className = 'col-md-3 mb-2';
            col.innerHTML = '<img src="' + e.target.result + '" class="img-fluid rounded shadow-sm" style="height:100px; width:100%; object-fit:cover;">';
            preview.appendChild(col);
        }
        reader.readAsDataURL(files[i]);
    }
}
</script>
@endsection