<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'room'])
                    ->latest()
                    ->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function approve($id)
    {
        Booking::findOrFail($id)->update(['status' => 'approved']);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking Approved!');
    }

    public function reject($id)
    {
        Booking::findOrFail($id)->update(['status' => 'rejected']);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking Rejected!');
    }
}