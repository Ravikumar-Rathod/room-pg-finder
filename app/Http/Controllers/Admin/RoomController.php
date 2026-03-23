<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Location;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('location')->latest()->get();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $locations = Location::all();
        return view('admin.rooms.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'location_id'  => 'required|exists:locations,id',
            'full_address' => 'nullable|string',
            'latitude'     => 'nullable|string',
            'longitude'    => 'nullable|string',
            'rent'         => 'required|numeric',
            'room_type'    => 'required|in:single,sharing',
            'images'       => 'required|array|min:3|max:8',
            'images.*'     => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('images');
        $data['wifi'] = $request->has('wifi') ? 1 : 0;
        $data['ac']   = $request->has('ac') ? 1 : 0;
        $data['food'] = $request->has('food') ? 1 : 0;

        // store method - Fix this
        if ($request->hasFile('images')) 
        {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('rooms', 'public');
            }
            $data['images'] = $imagePaths; // ✅ Remove json_encode
        }

        Room::create($data);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room Added Successfully!');
    }

    public function edit($id)
    {
        $room      = Room::findOrFail($id);
        $locations = Location::all();
        return view('admin.rooms.edit', compact('room', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'location_id'  => 'required|exists:locations,id',
            'full_address' => 'nullable|string',
            'latitude'     => 'nullable|string',
            'longitude'    => 'nullable|string',
            'rent'         => 'required|numeric',
            'room_type'    => 'required|in:single,sharing',
            'images'       => 'nullable|array|min:3|max:8',
            'images.*'     => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $room = Room::findOrFail($id);
        $data = $request->except('images');
        $data['wifi'] = $request->has('wifi') ? 1 : 0;
        $data['ac']   = $request->has('ac') ? 1 : 0;
        $data['food'] = $request->has('food') ? 1 : 0;

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('rooms', 'public');
            }
            $data['images'] = json_encode($imagePaths);
        }

        $room->update($data);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room Updated Successfully!');
    }

    public function destroy($id)
    {
        Room::findOrFail($id)->delete();

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room Deleted Successfully!');
    }
}