<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Room;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
            'rating'  => 'required|integer|min:1|max:5',
        ]);

        // Check already reviewed
        $exists = Review::where('user_id', auth()->id())
                    ->where('room_id', $id)
                    ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'You have already reviewed this room!');
        }

        Review::create([
            'user_id' => auth()->id(),
            'room_id' => $id,
            'comment' => $request->comment,
            'rating'  => $request->rating,
        ]);

        // Update Room Rating
        $avgRating = Review::where('room_id', $id)->avg('rating');
        Room::findOrFail($id)->update(['rating' => $avgRating]);

        return redirect()->back()
            ->with('success', 'Review Added Successfully!');
    }
}