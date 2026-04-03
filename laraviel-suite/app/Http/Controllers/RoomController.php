<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    try {
        // Fetch all rooms with the associated price details (only fetching price from RoomPrices)
        $rooms = Room::with('price:id,price')->get();

        // Format the response to include room_price_id and price
        $roomsData = $rooms->map(function ($room) {
            return [
                'id' => $room->id,
                'room_type' => $room->room_type,
                'description' => $room->description,
                'image_path' => $room->image_path,
                'room_price_id' => $room->room_price_id, // Room Price ID
                'price' => $room->price ? $room->price->price : null, // Get the actual price from the RoomPrices model
            ];
        });

        return response()->json($roomsData); // Return the formatted response as JSON
    } catch (\Exception $e) {
        // Handle any exceptions and return an error message
        return response()->json(['error' => $e->getMessage()], 500);
    }
}



    public function adminRoom() {
            $rooms = Room::all(); // Fetch all room records
            return view('categories.admincit301_laraviel_suite', ['rooms' => $rooms]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        // Validate the incoming data
        $validatedData = $request->validate([
            'room_type' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image',
            'priceId' => 'required|exists:room_prices,id',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $roomImageName = 'room_' . time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('images/roomImage'), $roomImageName);
            $imagePath = './images/roomImage/' . $roomImageName;
        }

        // Create a new room and associate the price ID (not the price itself)
        $room = new Room();
        $room->room_type = $request->room_type;
        $room->description = $request->description;
        $room->image_path = $imagePath;
        $room->room_price_id = $request->priceId;
        $room->save();

        // Log data to check the insertion

        return redirect()->route('rooms.index')->with('success', 'Room added successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'There was an error adding the room.');
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $room = Room::findOrFail($id);
    return view('rooms.edit', compact('room'));
}

public function update(Request $request, $id)
{
    // Validate the input
    $validatedData = $request->validate([
        'room_type' => 'required|string',
        'description' => 'required|string',
        'priceId' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Validate image
    ]);

    // Find the room by ID
    $room = Room::findOrFail($id);

    // Update room data
    $room->room_type = $validatedData['room_type'];
    $room->description = $validatedData['description'];
    $room->room_price_id = $validatedData['priceId'];

    // Check if an image is uploaded
    if ($request->hasFile('image')) {
        // Generate a unique name for the image, including the room ID
        $roomImageName = 'room_' .time(). '.' . $request->file('image')->extension();
        echo $roomImageName;
        // Move the uploaded image to the 'public/images' folder
        $request->file('image')->move(public_path('images/roomImage'), $roomImageName);

        // Get the path to the uploaded image
        $imagePath = './images/roomImage/' . $roomImageName;

        // Update the room's image path
        $room->image_path = $imagePath;
    }

    // Save the updated room data
    $room->save();

    return redirect()->route('admin')->with('success', 'Room updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::find($id);

        if ($room) {
            $room->delete();
            return redirect()->back()->with('success', 'room deleted successfully');
        }

        return redirect()->back()->with('error', 'room not found');
    }
}
