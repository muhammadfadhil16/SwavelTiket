<?php

namespace App\Http\Controllers\User;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;


class CatalogueController extends Controller
{
    /**
     * Display the catalog of events.
     */
    public function index(Request $request)
    {
        $query = Event::query();

         // Tambahkan harga tiket minimum untuk setiap event
         $query->addSelect([
            'min_price' => Ticket::select(DB::raw('MIN(price)'))
                ->whereColumn('tickets.id_event', 'events.id_event')
                ->limit(1),
        ]);

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter untuk mengecualikan event dengan status Done
        $query->where('status', '!=', 'Done');

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);  // Pastikan ini adalah nama kolom kategori
        }

        $events = $query->latest('date') // Mengambil event terbaru berdasarkan tanggal
            ->take(5)          // Batas hasil menjadi 5
            ->get();           // Ambil hasilnya

        // Return the view with the events data
        return view('user.catalogue.index', compact('events'));
    }


    /**
     * Show a specific event by its ID.
     */
    public function showEvent($id_event)
    {
        // Find the event by its ID
        $event = Event::findOrFail($id_event);

        // Pass the event to the view
        return view('user.catalogue.detailevent', compact('event'));
    }

    public function showAllEvents(Request $request)
    {
        $query = Event::query();

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category != '') {
            $categories = explode(',', $request->category);
            $query->whereIn('category', $categories);
        }

        // Filter untuk mengecualikan event dengan status Done
        $query->where('status', '!=', 'Done');

        // Menambahkan pengurutan dan pagination
        $events = $query->orderBy('date', 'desc')->paginate(8);

        // Kembalikan ke view dengan data
        return view('user.catalogue.allEvents', compact('events'));
    }
}
