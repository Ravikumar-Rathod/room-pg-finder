@extends('layouts.admin')

@section('title', 'Manage Rooms')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Rooms</h5>
        <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Room
        </a>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Location</th>
                    <th>Rent</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rooms as $room)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($room->image)
                            <img src="{{ asset('storage/'.$room->image) }}"
                                width="60" height="50"
                                style="object-fit:cover; border-radius:5px;">
                        @else
                            <span class="text-muted">No Image</span>
                        @endif
                    </td>
                    <td>{{ $room->title }}</td>
                    <td>
                        {{ $room->location->area }},
                        {{ $room->location->district }},
                        {{ $room->location->state }}
                    </td>
                    <td>₹{{ number_format($room->rent, 2) }}</td>
                    <td>
                        <span class="badge bg-info">{{ ucfirst($room->room_type) }}</span>
                    </td>
                    <td>
                        @if($room->is_available)
                            <span class="badge bg-success">Available</span>
                        @else
                            <span class="badge bg-danger">Not Available</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.rooms.edit', $room->id) }}"
                            class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.rooms.destroy', $room->id) }}"
                            method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No Rooms Found!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection