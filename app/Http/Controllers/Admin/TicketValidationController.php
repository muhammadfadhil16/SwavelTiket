<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use App\Models\TicketValidation;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TicketValidationController extends Controller
{
    /**
     * Menampilkan halaman validasi tiket.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showTicketValidationPage()
    {
        // Mengambil data event dari tabel events
        $events = Event::select('id_event', 'name')
            ->distinct()
            ->get();

        // Mengembalikan view untuk halaman validasi tiket
        return view('admin.ticketValidation.validation', compact('events'));
    }

    /**
     * Mengambil data tiket berdasarkan ID detail order.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchTicketData(Request $request)
    {
        // Mencari data OrderDetail berdasarkan ID
        $orderDetail = OrderDetail::find($request->id_order_detail);

        // Jika data tidak ditemukan, kembalikan respons error
        if (!$orderDetail) {
            return response()->json([
                'success' => false,
                'message' => 'Order detail tidak ditemukan.',
            ], 404);
        }

        // Jika data ditemukan, kembalikan data tiket dan order
        return response()->json([
            'success' => true,
            'data' => [
                'id_order' => $orderDetail->id_order,
                'id_ticket' => $orderDetail->id_ticket,
            ],
        ], 200);
    }

    /**
     * Memvalidasi tiket menggunakan QR code atau ID detail order.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateTicket(Request $request)
    {
        try {
            // Log QR code yang diterima untuk debugging
            $qrCode = $request->input('qr_code');
            Log::info('QR Code diterima:', ['qr_code' => $qrCode]);

            // Memisahkan QR code untuk mendapatkan ID detail order
            $parts = explode('|', $qrCode);
            $id_order_detail = $parts[1] ?? null; // Bagian kedua adalah ID Order Detail

            // Jika ID detail order tidak valid, kembalikan respons error
            if (!$id_order_detail || !is_numeric($id_order_detail)) {
                Log::error('Format QR Code tidak valid', ['qr_code' => $qrCode]);
                session()->flash('status', 'qr.error');
                return response()->json(['success' => false, 'message' => 'Format QR Code tidak valid'], 400);
            }

            Log::info('Mencari Order Detail:', ['id_order_detail' => $id_order_detail]);

            $orderDetail = OrderDetail::find($id_order_detail);

            if (!$orderDetail) {
                Log::error('Order Detail tidak ditemukan di database.', ['id_order_detail' => $id_order_detail]);
                return response()->json([
                    'success' => false,
                    'message' => 'Order Detail tidak ditemukan.',
                ], 404);
            }

            Log::info('Order Detail ditemukan:', ['order_detail' => $orderDetail]);

            // Memeriksa apakah tiket sudah divalidasi sebelumnya
            $ticketValidation = TicketValidation::where('id_order_detail', $id_order_detail)->first();
            if ($ticketValidation && $ticketValidation->is_valid) {
                Log::warning('Tiket sudah divalidasi', ['id_order_detail' => $id_order_detail]);
                session()->flash('status', 'qr.error');
                return response()->json(['success' => false, 'message' => 'Tiket sudah divalidasi'], 400);
            }

            // Memastikan id_order tidak null
            if (!$orderDetail->id_order) {
                Log::error('ID Order tidak ditemukan untuk Order Detail', ['id_order_detail' => $id_order_detail]);
                session()->flash('status', 'qr.error');
                return response()->json(['success' => false, 'message' => 'ID Order tidak ditemukan untuk Order Detail ini'], 400);
            }

            // Menandai tiket sebagai valid
            TicketValidation::updateOrCreate(
                ['id_order_detail' => $id_order_detail],
                [
                    'id_order' => $orderDetail->id_order,
                    'id_ticket' => $orderDetail->id_ticket,
                    'is_valid' => true,
                    'validation_date' => now(),
                ]
            );

            // Log sukses validasi tiket
            Log::info('Tiket berhasil divalidasi', ['id_order_detail' => $id_order_detail]);
            session()->flash('status', 'qr.success');
            return response()->json(['success' => true, 'message' => 'Tiket berhasil divalidasi']);
        } catch (\Exception $e) {
            // Log error jika terjadi exception
            Log::error('Terjadi kesalahan saat memvalidasi tiket:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('status', 'qr.error');
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat memvalidasi tiket.'], 500);
        }
    }
}
