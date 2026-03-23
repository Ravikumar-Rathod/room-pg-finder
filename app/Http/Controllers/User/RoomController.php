<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Location;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with('location')->where('is_available', true);

        // Search Filters
        if ($request->filled('state')) {
            $query->whereHas('location', function($q) use ($request) {
                $q->where('state', $request->state);
            });
        }

        if ($request->filled('district')) {
            $query->whereHas('location', function($q) use ($request) {
                $q->where('district', $request->district);
            });
        }

        if ($request->filled('area')) {
            $query->whereHas('location', function($q) use ($request) {
                $q->where('area', $request->area);
            });
        }

        if ($request->filled('room_type')) {
            $query->where('room_type', $request->room_type);
        }

        if ($request->filled('min_rent')) {
            $query->where('rent', '>=', $request->min_rent);
        }

        if ($request->filled('max_rent')) {
            $query->where('rent', '<=', $request->max_rent);
        }

        if ($request->filled('wifi')) {
            $query->where('wifi', 1);
        }

        if ($request->filled('ac')) {
            $query->where('ac', 1);
        }

        if ($request->filled('food')) {
            $query->where('food', 1);
        }

        $rooms     = $query->latest()->paginate(9);
        $locations = Location::all();

        return view('user.rooms.index', compact('rooms', 'locations'));
    }

    public function show($id)
    {
        $room    = Room::with(['location', 'reviews.user'])->findOrFail($id);
        $reviews = $room->reviews()->with('user')->latest()->get();

        return view('user.rooms.show', compact('room', 'reviews'));
    }
}