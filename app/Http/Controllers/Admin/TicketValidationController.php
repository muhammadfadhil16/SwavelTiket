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
            // Simulasi waktu tunggu untuk debugging
            sleep(2);

            // Validasi input
            $request->validate([
                'qr_code' => 'required|string',
            ]);

            $qrCode = $request->input('qr_code');
            Log::info('QR Code diterima:', ['qr_code' => $qrCode]);

            // Memisahkan QR code untuk mendapatkan ID detail order
            $parts = explode('|', $qrCode);
            $id_order_detail = $parts[1] ?? null;

            if (!$id_order_detail || !is_numeric($id_order_detail)) {
                Log::error('Format QR Code tidak valid', ['qr_code' => $qrCode]);
                return response()->json(['success' => false, 'message' => 'Format QR Code tidak valid'], 400);
            }

            Log::info('Mencari Order Detail:', ['id_order_detail' => $id_order_detail]);

            // Cari data OrderDetail berdasarkan ID
            $orderDetail = OrderDetail::find($id_order_detail);

            if (!$orderDetail) {
                Log::error('Order Detail tidak ditemukan di database.', ['id_order_detail' => $id_order_detail]);
                return response()->json(['success' => false, 'message' => 'Order Detail tidak ditemukan.'], 404);
            }

            Log::info('Status validasi:', ['is_validated' => $orderDetail->is_validated]);

            if ($orderDetail->is_validated) {
                Log::warning('Tiket sudah divalidasi', ['id_order_detail' => $id_order_detail]);
                return response()->json(['success' => false, 'message' => 'Tiket sudah divalidasi sebelumnya.']);
            }

            // Tandai tiket sebagai valid
            $orderDetail->update(['is_validated' => true]);

            Log::info('Tiket berhasil divalidasi', ['id_order_detail' => $id_order_detail]);
            return response()->json(['success' => true, 'message' => 'QR Code berhasil diverifikasi!']);
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat memvalidasi tiket:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat memvalidasi tiket.'], 500);
        }
    }
}
