<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderDetail;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderDetailController extends Controller
{
    /**
     * Menampilkan semua OrderDetail.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $orderDetails = OrderDetail::with(['order', 'ticketValidation'])->paginate(10); // Pagination untuk efisiensi
        return response()->json($orderDetails);
    }

    /**
     * Menampilkan Order berdasarkan ID.
     *
     * @param int $id_order
     * @return \Illuminate\Http\Response
     */
    public function show($id_order)
    {
        $order = Order::with(['orderDetails.ticket', 'event'])->findOrFail($id_order);

        if ($order->status !== 'approved') {
            return redirect()->back()->with('error', 'Order belum disetujui.');
        }

        $whatsappGroupLink = $order->event->whatsapp_group_link;

        return view('user.orderDetail.show', compact('order', 'whatsappGroupLink'));
    }
}
