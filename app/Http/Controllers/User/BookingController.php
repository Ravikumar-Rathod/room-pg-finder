<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())
                    ->with('room')
                    ->latest()
                    ->get();

        return view('user.bookings.index', compact('bookings'));
    }

    public function store(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        // Check already booked
        $exists = Booking::where('user_id', auth()->id())
                    ->where('room_id', $id)
                    ->whereIn('status', ['pending', 'approved'])
                    ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'You have already booked this room!');
        }

        Booking::create([
            'user_id'      => auth()->id(),
            'room_id'      => $id,
            'booking_date' => now()->toDateString(),
            'status'       => 'pending',
        ]);

        return redirect()->route('user.bookings.index')
            ->with('success', 'Room Booked Successfully!');
    }

    public function cancel($id)
    {
        $booking = Booking::where('user_id', auth()->id())
                    ->findOrFail($id);

        $booking->delete();

        return redirect()->route('user.bookings.index')
            ->with('success', 'Booking Cancelled Successfully!');
    }
}