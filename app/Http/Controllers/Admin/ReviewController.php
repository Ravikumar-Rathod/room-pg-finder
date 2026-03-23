<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'room'])
                    ->latest()
                    ->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy($id)
    {
        Review::findOrFail($id)->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review Deleted Successfully!');
    }
}