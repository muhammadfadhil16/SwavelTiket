@extends('layouts.userLayout')

@section('title', 'Checkout')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto mt-10">
    <form action="{{ route('order.confirm') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id_ticket" value="{{ $checkoutData['id_ticket'] ?? '' }}">
        <input type="hidden" name="id_event" value="{{ $checkoutData['id_event'] }}">
        <input type="hidden" name="quantity" value="{{ $checkoutData['quantity'] ?? '' }}">
        <input type="hidden" name="total_price" value="{{ $checkoutData['total_price'] ?? '' }}">

        <h2 class="text-2xl font-bold mb-6 text-center text-blue-800">Checkout</h2>

        <!-- Ticket Details -->
        <div class="space-y-4">
            <p class="text-lg"><strong>Tiket:</strong> {{ $checkoutData['ticket_type'] ?? 'N/A' }}</p>
            <p class="text-lg"><strong>Harga per Tiket:</strong> Rp {{ number_format($checkoutData['ticket_price'] ?? 0, 0, ',', '.') }}</p>
            <p class="text-lg"><strong>Jumlah:</strong> {{ $checkoutData['quantity'] ?? 0 }}</p>
            <p class="text-lg"><strong>Total Harga:</strong> Rp {{ number_format($checkoutData['total_price'] ?? 0, 0, ',', '.') }}</p>
            <p class="text-lg"><strong>No Rekening:</strong> 88215542390123 (BCA An Supriyadi)</p>
        </div>

        <!-- Upload Payment Proof -->
        <div class="mt-6">
            <label for="payment_proof" class="block text-sm font-medium text-gray-700">Unggah Bukti Pembayaran</label>
            <input type="file" name="payment_proof" id="payment_proof" accept="image/*"
                class="block w-full mt-2 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="mt-6 w-full py-2 px-4 text-center text-white rounded-lg bg-blue-800 hover:bg-blue-700 transition duration-200">
            Konfirmasi Pembayaran
        </button>
    </form>
</div>
@endsection
