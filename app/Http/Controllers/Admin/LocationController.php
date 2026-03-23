<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::latest()->get();
        return view('admin.locations.index', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'state'    => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'area'     => 'required|string|max:255',
        ]);

        Location::create($request->all());

        return redirect()->route('admin.locations.index')
            ->with('success', 'Location Added Successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'state'    => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'area'     => 'required|string|max:255',
        ]);

        Location::findOrFail($id)->update($request->all());

        return redirect()->route('admin.locations.index')
            ->with('success', 'Location Updated Successfully!');
    }

    public function destroy($id)
    {
        Location::findOrFail($id)->delete();

        return redirect()->route('admin.locations.index')
            ->with('success', 'Location Deleted Successfully!');
    }
}