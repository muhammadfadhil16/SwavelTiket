@extends('layouts.userLayout')

@section('title', 'Tiketku')

@section('content')
<div class="container mx-auto mt-6 px-4">

    <h1 class="text-2xl font-semibold mb-4">Tiketku</h1>

    @if($orders->isEmpty())
    <p class="text-gray-500">Belum ada pesanan.</p>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($orders as $orderItem)
        <div class="bg-white shadow-md rounded-lg overflow-hidden flex flex-col">
            <!-- Card Image -->
            <div class="h-48 bg-gray-200 flex justify-center items-center">
                @if($orderItem->event->image)
                <img src="{{ asset('storage/' . $orderItem->event->image) }}" alt="Event Image"
                    class="h-full w-full object-cover">
                @else
                <span class="text-gray-500">Gambar Event Tidak Tersedia</span>
                @endif
            </div>

            <!-- Card Body -->
            <div class="p-4 flex flex-col flex-grow">
                <h5 class="text-lg font-bold text-gray-800">{{ $orderItem->ticket->type }} Ticket</h5>
                <p class="text-sm text-gray-600"><strong>Event:</strong> {{ $orderItem->event->name ?? 'Tidak tersedia' }}</p>
                <p class="text-sm text-gray-600"><strong>Jumlah:</strong> {{ $orderItem->quantity }}</p>
                <p class="text-sm text-gray-600"><strong>Total Harga:</strong> Rp {{ number_format($orderItem->total_price, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-600"><strong>Status:</strong>
                    @if ($orderItem->status == 'pending')
                    <span class="text-yellow-600 font-semibold">Pending</span>
                    @elseif ($orderItem->status == 'approved')
                    <span class="text-green-600 font-semibold">Approved</span>
                    @else
                    <span class="text-red-600 font-semibold">Rejected</span>
                    @endif
                </p>

                <!-- Buttons -->
                <div class="mt-1 flex gap-2">
                    <a href="{{ route('order.ShowEventOrder', ['id_order' => $orderItem->id_order]) }}"
                        class="flex-1 bg-blue-600 text-white text-sm py-2 px-4 rounded-lg text-center hover:bg-blue-700">
                        Lihat Event
                    </a>
                    <a href="{{ route('user.orderDetail.show', $orderItem->id_order) }}"
                        class="flex-1 bg-green-600 text-white text-sm py-2 px-4 rounded-lg text-center hover:bg-green-700">
                        Lihat Tiket
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
