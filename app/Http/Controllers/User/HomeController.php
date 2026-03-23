<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Booking;

class HomeController extends Controller
{
    public function index()
    {
        $totalBookings = Booking::where('user_id', auth()->id())->count();
        $pendingBookings = Booking::where('user_id', auth()->id())
                            ->where('status', 'pending')
                            ->count();
        $approvedBookings = Booking::where('user_id', auth()->id())
                            ->where('status', 'approved')
                            ->count();
        $recentRooms = Room::with('location')
                        ->where('is_available', true)
                        ->latest()
                        ->take(6)
                        ->get();

        return view('user.dashboard', compact(
            'totalBookings',
            'pendingBookings',
            'approvedBookings',
            'recentRooms'
        ));
    }
}