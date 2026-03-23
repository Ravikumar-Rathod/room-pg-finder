@extends('layouts.admin')

@section('title', 'Manage Bookings')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">All Bookings</h5>
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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
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
                    <td>
                        @if($booking->status == 'pending')
                        <form action="{{ route('admin.bookings.approve', $booking->id) }}"
                            method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fas fa-check"></i> Approve
                            </button>
                        </form>
                        <form action="{{ route('admin.bookings.reject', $booking->id) }}"
                            method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-times"></i> Reject
                            </button>
                        </form>
                        @else
                            <span class="text-muted">No Action</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No Bookings Found!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection