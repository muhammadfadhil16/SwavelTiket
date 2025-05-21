<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\City;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $location = $request->get('location');
        $category = $request->get('category');

        $events = Event::when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%');
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($location, function ($query, $location) {
                return $query->where('location', 'like', '%' . $location . '%');
            })
            ->when($category, function ($query, $category) {
                return $query->where('category', $category);
            })
            ->paginate(10);

        // Ambil semua kategori unik dari tabel Event
        $categories = Event::select('category')->distinct()->get();

        // Kirim variabel $categories ke view
        return view('admin.events.index', compact('events', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::all();
        return view('admin.events.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5026',
            'location' => 'required|string|max:255',
            'venue' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'category' => 'required|string',
            'whatsapp_group_link' => 'nullable|url|max:255', // Tambahkan validasi ini
        ]);

        // Combine location and venue into one field before storing
        $locationAndVenue = $validatedData['location'] . ', ' . $validatedData['venue'];

        // If there's an image, handle the upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Save the event to the database
        Event::create([
            'name' => $validatedData['name'],
            'date' => $validatedData['date'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'image' => $imagePath,
            'location' => $locationAndVenue, // Save combined location and venue
            'description' => $validatedData['description'] ?? null,
            'capacity' => $validatedData['capacity'],
            'status' => 'Upcoming', // Default status
            'category' => $validatedData['category'],
            'whatsapp_group_link' => $validatedData['whatsapp_group_link'] ?? null, // Tambahkan ini
        ]);


        // Redirect with success message
        return redirect()->route('events.index')->with('success', 'Event berhasil dibuat. Kamu bisa menambahkan atau membuat tiket sekarang .');
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Controller: EventController.php
    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        if ($event->status === 'Done') {
            return redirect()->route('events.index')->with('error', "Event {$event->name} sudah selesai dan tidak dapat diedit.");
        }
        $cities = City::all();

        // Pisahkan lokasi dan venue jika perlu
        $locationParts = explode(',', $event->location, 2);
        $event->location = trim($locationParts[0]);
        $event->venue = isset($locationParts[1]) ? trim($locationParts[1]) : '';

        return view('admin.events.edit', compact('event', 'cities'));
    }

    public function update(Request $request, $id)
    {
        // Find the event by IDw
        $event = Event::findOrFail($id);


            // Cek jika status event adalah Done
        if ($event->status === 'Done') {
            return redirect()->route('events.index')->with('error', "Event {$event->name} sudah selesai dan tidak dapat diedit.");
        }
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5026',
            'location' => 'required|string|max:255',
            'venue' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'category' => 'required|string',
            'whatsapp_group_link' => 'nullable|url|max:255', // Tambahkan validasi ini
        ]);

        // Find the event by ID
        $event = Event::findOrFail($id);

        // Handle the image upload if exists
        if ($request->hasFile('image')) {
            // Delete the old image if exists
            if ($event->image && Storage::exists('public/' . $event->image)) {
                Storage::delete('public/' . $event->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('images', 'public');
            $event->image = $imagePath;
        }

        // Combine location and venue into one field
        $locationAndVenue = $validatedData['location'] . ', ' . $validatedData['venue'];

        // Update the event data
        $event->update([
            'name' => $validatedData['name'],
            'date' => $validatedData['date'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'location' => $locationAndVenue,
            'description' => $validatedData['description'] ?? $event->description,
            'capacity' => $validatedData['capacity'],
            'category' => $validatedData['category'],
            'whatsapp_group_link' => $validatedData['whatsapp_group_link'] ?? $event->whatsapp_group_link, // Tambahkan ini
        ]);

        // Redirect or return response
        return redirect()->route('events.index')->with('success', "Event {$event->name} berhasil diperbarui!");
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $eventName = $event->name; // Simpan nama event sebelum dihapus
        $event->delete();

        // Redirect dengan pesan flash berwarna merah
        return redirect()->route('events.index')->with('danger', "Event {$eventName} telah dihapus!");
    }
}
