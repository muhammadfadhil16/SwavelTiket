@extends('layouts.adminLayout')
@section('title', 'Daftar Tiket')

@section('content')
<section class="antialiased bg-gray-100 text-gray-600 h-screen px-4">
    <div class="flex flex-col h-full">
        <!-- Table -->
        <div class="w-full max-w-5xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 mt-6">
            <header class="px-5 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-gray-800">DAFTAR TIKET EVENT {{ $event->name }}</h2>
            </header>
            <div class="p-3">
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                            <tr>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">No</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Tiket</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Harga</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Jumlah</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Aksi</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            @foreach ($event->tickets as $index => $ticket)
                            <tr>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left">{{ $index + 1 }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left">{{ $ticket->type }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left font-medium text-green-500">Rp {{ number_format($ticket->price, 0, ',', '.') }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left">{{ $ticket->quantity }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-2">
                                        <!-- Edit Button -->
                                        <a href="{{ route('tickets.edit', $ticket) }}"
                                            class="bg-yellow-500 text-white px-4 py-1 rounded-md hover:bg-yellow-600 transition">
                                            Edit
                                        </a>
                                        <!-- Delete Button -->
                                        <button type="button"
                                            onclick="openModal('deleteModal', {{ $ticket->id_ticket }})"
                                            class="bg-red-500 text-white px-4 py-1 rounded-md hover:bg-red-600 transition">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Back Button -->
        </div>
        <div class="flex justify-center mt-4">
            <a href="{{ route('events.index') }}"
                class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                Kembali
            </a>
        </div>
    </div>
</section>

<!-- Modal Konfirmasi Delete -->
<div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <form id="deleteFormModal" method="POST" class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        @csrf
        @method('DELETE')
        <h3 class="text-lg font-semibold mb-4">Konfirmasi Hapus Tiket</h3>
        <p class="mb-3">Apakah Anda yakin ingin menghapus ticket ini?</p>
        <p class="mt-1 text-red-600">ini akan menghapus semua data yang berkaitan dengan tiket ini!</p>
        <div class="flex justify-end space-x-2">
            <button type="button" onclick="closeModal('deleteModal')" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Batal</button>
            <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Hapus</button>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    function openModal(modalId, ticketId = null) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('hidden');
        if (ticketId) {
            // Gunakan placeholder dan replace dengan ticketId yang dipilih
            const form = document.getElementById('deleteFormModal');
            form.action = "{{ route('tickets.destroy', 'TICKET_ID') }}".replace('TICKET_ID', ticketId);
        }
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
</script>
@endsection
