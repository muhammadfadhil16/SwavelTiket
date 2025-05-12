@extends('layouts.userLayout')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container mx-auto mt-6 px-4">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800 text-center">Detail Pesanan Anda</h1>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <!-- Gambar Event -->
            @if ($order->event->image ?? false)
                <img src="{{ asset('storage/' . $order->event->image) }}" alt="Gambar Event" class="w-full h-64 object-cover rounded-md mb-6">
            @else
                <img src="{{ asset('assets/img/placeholder.png') }}" alt="Gambar Tidak Tersedia" class="w-full h-64 object-cover rounded-md mb-6">
            @endif

            <!-- Nama Event -->
            <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">{{ $order->event->name ?? 'Nama Event Tidak Tersedia' }}</h2>

            <!-- Detail Tiket -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($order->orderDetails as $orderDetail)
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <p class="text-lg text-gray-700"><strong>Tiket:</strong> {{ $orderDetail->ticket->type ?? 'Tidak Tersedia' }}</p>
                    <p class="text-lg text-gray-700"><strong>Jumlah:</strong> {{ $orderDetail->order->quantity ?? 0 }}</p>
                    <p class="text-lg text-gray-700"><strong>Harga:</strong> Rp {{ number_format($orderDetail->order->total_price ?? 0, 0, ',', '.') }}</p>

                    <!-- QR Code -->
                    <div class="text-center mt-4">
                        <p class="text-lg text-gray-700"><strong>QR Code:</strong></p>
                        @if ($orderDetail->qr_code ?? false)
                            <img src="{{ asset('storage/' . $orderDetail->qr_code) }}" alt="QR Code" class="mx-auto w-32 h-32">
                        @else
                            <p class="text-gray-500">QR Code Tidak Tersedia</p>
                        @endif
                    </div>
                    <!-- Status -->
                    <div class="text-center mt-4">
                        <p class="text-lg text-gray-700"><strong>Status:</strong></p>
                        @if ($orderDetail->is_validated)
                            <span class="text-green-500 font-semibold">Aktif</span>
                        @elseif ($orderDetail->status == 'expired')
                            <span class="text-red-500 font-semibold">Kedaluwarsa</span>
                        @else
                            <span class="text-yellow-500 font-semibold">Menunggu</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- WhatsApp Group Link -->
            @if($whatsappGroupLink)
            <div class="mt-4 text-center">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">WhatsApp Group Link</h3>
                <a href="{{ $whatsappGroupLink }}" target="_blank"
                    class="inline-block bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition duration-200">
                    Join WhatsApp Group
                </a>
            </div>
            @endif
        </div>
    </div>

    <div class="mt-4 mb-5 text-center">
        <a href="{{ route('user.orders.index') }}" class="inline-block bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition duration-200">
            Kembali ke Pesanan
        </a>
    </div>
</div>
@endsection
