<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()->get();
        return view('admin.rooms', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_type' => 'required|string|max:255',
            'floor_level' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        Room::create($request->all());

        return redirect()->route('admin.rooms')->with('success', 'Room created successfully!');
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_type' => 'required|string|max:255',
            'floor_level' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $room->update($request->all());

        return redirect()->route('admin.rooms')->with('success', 'Room updated successfully!');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('admin.rooms')->with('success', 'Room deleted successfully!');
    }
}