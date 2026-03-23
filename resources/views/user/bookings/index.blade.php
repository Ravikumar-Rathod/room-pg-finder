@extends('layouts.user')

@section('title', 'My Bookings')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">My Bookings</h5>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Room</th>
                    <th>Location</th>
                    <th>Rent</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $booking->room->title }}</td>
                    <td>
                        {{ $booking->room->location->area }},
                        {{ $booking->room->location->district }}
                    </td>
                    <td>₹{{ number_format($booking->room->rent, 2) }}</td>
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
                    <td>
                        @if($booking->status == 'pending')
                        <form action="{{ route('user.bookings.cancel', $booking->id) }}"
                            method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Cancel booking?')">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                        </form>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No Bookings Found!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection