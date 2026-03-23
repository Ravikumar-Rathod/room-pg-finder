<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Review;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers    = User::where('role', 'user')->count();
        $totalRooms    = Room::count();
        $totalBookings = Booking::count();
        $totalPayments = Payment::where('status', 'paid')->sum('amount');
        $recentBookings = Booking::with(['user', 'room'])
                            ->latest()
                            ->take(5)
                            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalRooms',
            'totalBookings',
            'totalPayments',
            'recentBookings'
        ));
    }
}