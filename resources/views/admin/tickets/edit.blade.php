@extends('layouts.adminLayout')

@section('title', 'Edit Ticket')

@section('content')
<div class="container mx-auto mt-8 px-4">
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Ubah Tiket</h1>

        <!-- Form Edit Ticket -->
        <form action="{{ route('tickets.update', $ticket->id_ticket) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nama Ticket -->
            <div class="mb-6">
                <label for="name" class="block text-gray-700 font-medium mb-2">Tiket</label>
                <input type="text" id="name" name="name" class="w-full px-4 py-2 border  rounded-md focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror" placeholder="Enter ticket name" value="{{ old('name', $ticket->type ?? '') }}" required>
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Harga Ticket -->
            <div class="mb-6">
                <label for="price" class="block text-gray-700 font-medium mb-2">Harga</label>
                <input type="number" id="price" name="price" class="w-full px-4 py-2 border  rounded-md focus:ring-blue-500 focus:border-blue-500 @error('price') border-red-500 @enderror" placeholder="Enter ticket price" value="{{ old('price', $ticket->price) }}" required>
                @error('price')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kuota Ticket -->
            <div class="mb-6">
                <label for="quantity" class="block text-gray-700 font-medium mb-2">Jumlah</label>
                <input type="number" id="quantity" name="quantity" class="w-full px-4 py-2 border  rounded-md focus:ring-blue-500 focus:border-blue-500 @error('quantity') border-red-500 @enderror" placeholder="Enter ticket quantity" value="{{ old('quantity', $ticket->quantity) }}" required>
                @error('quantity')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-between">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">Simpan Perubahan</button>
                <a href="{{ route('tickets.index', $event->id_event) }}" class="bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700 transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
