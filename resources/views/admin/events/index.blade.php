@extends('layouts.adminLayout')

@section('title', 'Events Tiketku')

@section('content')
<div class="container mx-auto mt-8 px-4">
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">List Events</h1>

    <!-- Alerts -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
            <i class="bi bi-x text-green-700"></i>
        </button>
    </div>
    @endif

    @if(session('danger'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
        <strong>Error!</strong> {{ session('danger') }}
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
            <i class="bi bi-x text-red-700"></i>
        </button>
    </div>
    @endif

    {{-- search and filter --}}
    <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
        <!-- Search Form -->
        <form method="GET" action="{{ route('events.index') }}" class="flex flex-wrap gap-2 w-full md:w-auto">
            <input type="text" name="search" class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Search events..." value="{{ request()->get('search') }}">

            <!-- Filter by Status -->
            <select name="status" class="w-full md:w-48 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Status</option>
                <option value="Upcoming" {{ request()->get('status') == 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                <option value="Ongoing" {{ request()->get('status') == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                <option value="Done" {{ request()->get('status') == 'Done' ? 'selected' : '' }}>Done</option>
            </select>

            <!-- Filter by Location -->
            <input type="text" name="location" class="w-full md:w-48 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Filter by location" value="{{ request()->get('location') }}">

            <button type="submit" class="px-4 py-2  bg-slate-800 text-white rounded-md hover:bg-slate-700 ">
                <i class="bi bi-search"></i> Search
            </button>
        </form>

        <!-- Export Button -->
        <a href="{{ route('admin.events.export') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
            <i class="bi bi-download"></i> Export Events
        </a>
    </div>

    <!-- Events Table -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-black uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Event
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tanggal
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Lokasi
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Tindakan
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Tiket
                    </th>
                    <th scope="col" class="px-6 py-3">
                        WhatsApp Group
                    </th>
                </tr>
            </thead>
            <tbody>
                @if($events->count() > 0)
                    @foreach ($events as $key => $event)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $events->firstItem() + $key }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $event->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $event->date }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $event->location }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if ($event->status == 'Upcoming')
                            <span class="px-2 py-1 text-sm font-semibold text-white bg-blue-500 rounded-full">{{ $event->status }}</span>
                            @elseif ($event->status == 'Ongoing')
                            <span class="px-2 py-1 text-sm font-semibold text-white bg-green-500 rounded-full">{{ $event->status }}</span>
                            @elseif ($event->status == 'Done')
                            <span class="px-2 py-1 text-sm font-semibold text-white bg-gray-500 rounded-full">{{ $event->status }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-wrap justify-center gap-2">
                                <!-- View Button -->
                                <button class="px-2 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                                    onclick="openModal(this)"
                                    data-name="{{ $event->name }}"
                                    data-date="{{ $event->date }}"
                                    data-image="{{ $event->image ? asset('storage/' . $event->image) : 'No image' }}"
                                    data-start_time="{{ $event->start_time }}"
                                    data-end_time="{{ $event->end_time }}"
                                    data-location="{{ $event->location }}"
                                    data-description="{{ $event->description }}"
                                    data-capacity="{{ $event->capacity }}"
                                    data-status="{{ $event->status }}"
                                    data-category="{{ $event->category }}">
                                    View
                                </button>

                                <!-- Edit Button -->
                                <a href="{{ route('events.edit', $event->id_event) }}" class="px-2 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">Edit</a>

                                <!-- Delete Button -->
                                <form action="{{ route('events.destroy', $event->id_event) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete the event {{ $event->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded-md hover:bg-red-700">Delete</button>
                                </form>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-wrap justify-center gap-2">
                                <a href="{{ route('tickets.create', $event->id_event) }}" class="px-2 py-1 bg-green-600 text-white rounded-md hover:bg-green-700">Create Ticket</a>
                                <a href="{{ route('tickets.index', ['event' => $event->id_event]) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                    Lihat Tiket
                                </a>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($event->whatsapp_group_link)
                            <a href="{{ $event->whatsapp_group_link }}" target="_blank" class="text-blue-500 underline">
                                Join Group
                            </a>
                            @else
                            <span class="text-gray-500">No Link</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">No events found matching your search.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $events->links('pagination::tailwind') }}
    </div>
</div>

<!-- Enhanced Responsive Modal -->
<div id="eventDetailModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 z-50 hidden transition-opacity duration-300 ease-in-out" aria-hidden="true" role="dialog" aria-labelledby="modal-event-name" aria-describedby="modal-description">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-full sm:max-w-md md:max-w-lg mx-4 overflow-hidden transform scale-95 transition-transform duration-300 ease-in-out">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-teal-500 px-6 py-4 flex justify-between items-center">
            <h5 id="modal-event-name" class="text-lg font-semibold text-white truncate">Event Title</h5>
            <button type="button" onclick="closeModal()" class="text-white hover:text-gray-200 focus:outline-none">
                <i class="bi bi-x-lg text-2xl"></i>
            </button>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-4">
            <img id="modal-event-image" class="w-full h-48 object-cover rounded-lg" src="" alt="Event Image">
            <p id="modal-description" class="text-gray-700 text-sm leading-relaxed"></p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div><strong>Tanggal:</strong> <span id="modal-event-date">-</span></div>
                <div><strong>Mulai:</strong> <span id="modal-event-start-time">-</span></div>
                <div><strong>Selesai:</strong> <span id="modal-event-end-time">-</span></div>
                <div><strong>Lokasi:</strong> <span id="modal-location">-</span></div>
                <div><strong>Kapasitas:</strong> <span id="modal-capacity">-</span></div>
                <div><strong>Status:</strong> <span id="modal-status">-</span></div>
                <div class="sm:col-span-2"><strong>Kategori:</strong> <span id="modal-category">-</span></div>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 bg-gray-100 flex justify-end">
            <button onclick="closeModal()" class="px-5 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition focus:outline-none">Tutup</button>
        </div>
    </div>
</div>

<script>
    function openModal(button) {
        const modal = document.getElementById('eventDetailModal');
        modal.querySelector('#modal-event-name').textContent = button.dataset.name || 'No name available';
        modal.querySelector('#modal-event-date').textContent = button.dataset.date || 'No date available';
        modal.querySelector('#modal-event-start-time').textContent = button.dataset.start_time || 'No start time available';
        modal.querySelector('#modal-event-end-time').textContent = button.dataset.end_time || 'No end time available';
        modal.querySelector('#modal-event-image').src = button.dataset.image || '/path/to/default-image.jpg';
        modal.querySelector('#modal-location').textContent = button.dataset.location || 'No location available';
        modal.querySelector('#modal-description').textContent = button.dataset.description || 'No description available';
        modal.querySelector('#modal-capacity').textContent = button.dataset.capacity || 'No capacity available';
        modal.querySelector('#modal-status').textContent = button.dataset.status || 'No status available';
        modal.querySelector('#modal-category').textContent = button.dataset.category || 'No category available';

        modal.classList.remove('hidden');
        modal.classList.add('opacity-100', 'scale-100');
        modal.style.display = 'flex';
    }

    function closeModal() {
        const modal = document.getElementById('eventDetailModal');
        modal.classList.add('hidden');
        modal.classList.remove('opacity-100', 'scale-100');
        modal.style.display = '';
    }

    // Close modal when clicking outside
    document.getElementById('eventDetailModal').addEventListener('click', (e) => {
        if (e.target.id === 'eventDetailModal') {
            closeModal();
        }
    });

    console.log('Modal initialized');
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
        console.log('Button found:', button);
        button.addEventListener('click', () => openModal(button));
    });

    document.addEventListener('DOMContentLoaded', () => {
        const buttons = document.querySelectorAll('button[onclick="openModal(this)"]');
        if (buttons.length > 0) {
            buttons.forEach(button => {
                button.addEventListener('click', () => openModal(button));
            });
        } else {
            console.error('No buttons found for opening the modal.');
        }
    });
</script>
@endsection
