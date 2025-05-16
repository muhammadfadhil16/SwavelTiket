<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/notifications.css') }}">

    {{-- QR Scan --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
</head>
<body class="min-h-screen flex bg-gray-50 text-gray-800">
    <!-- Sidebar -->
    <div id="sidebar" class="fixed top-0 left-0 w-64 h-full bg-white border-r z-30 transform -translate-x-full sm:translate-x-0 transition-transform duration-300">
        <div class="flex items-center justify-center h-16 border-b">
            <div class="font-semibold">Admin Dashboard</div>
        </div>
        <div class="overflow-y-auto flex-grow py-4 px-2">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 border-transparent hover:border-indigo-500 pr-6 transition">
                        <span class="inline-flex justify-center items-center ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
                            </svg>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('users.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 border-transparent hover:border-indigo-500 pr-6 transition">
                        <span class="inline-flex justify-center items-center ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">User</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('events.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 border-transparent hover:border-indigo-500 pr-6 transition">
                        <span class="inline-flex justify-center items-center ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm6.75-4.5h.008v.008h-.008v-.008Z" />
                            </svg>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Events</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('events.create') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 border-transparent hover:border-indigo-500 pr-6 transition">
                        <span class="inline-flex justify-center items-center ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Buat Events</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 border-transparent hover:border-indigo-500 pr-6 transition">
                        <span class="inline-flex justify-center items-center ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Order</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.ticketValidation') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 border-transparent hover:border-indigo-500 pr-6 transition">
                        <span class="inline-flex justify-center items-center ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                            </svg>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Scan Tiket</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden"></div>

    <!-- Navbar -->
    <div class="fixed top-0 left-0 right-0 h-16 bg-white border-b flex items-center justify-between px-6 z-20 shadow-sm">
        <div class="flex items-center">
            <button id="sidebarToggle" aria-label="Toggle sidebar" title="Toggle sidebar" class="p-2 text-gray-600 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-lg sm:hidden">
                <i class="bi bi-list text-xl"></i>
            </button>
            <span class="ml-2 text-xl font-semibold">Admin Dashboard</span>
        </div>
        <div class="relative group">
            <!-- Tombol Notifikasi -->
            <button id="admin-notification-toggle" class="flex items-center text-gray-600 hover:text-gray-800 focus:outline-none">
                <i class="bi bi-bell text-2xl"></i>
                @if(Auth::check() && Auth::user()->unreadNotifications->count() > 0)
                    <span class="bg-red-500 text-white text-xs rounded-full px-2 py-0.5 ml-1">
                        {{ Auth::user()->unreadNotifications->count() }}
                    </span>
                @endif
            </button>

            <!-- Dropdown Notifikasi -->
            <div id="admin-notification-dropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg hidden z-50">
                <div class="px-4 py-2 text-gray-700 font-bold border-b border-gray-200 flex justify-between items-center">
                    <span>Notifikasi</span>
                    <button id="delete-all-notifications-admin" class="text-red-600 hover:underline text-sm">Hapus Semua</button>
                </div>
                <ul id="admin-notification-list" class="divide-y divide-gray-200 max-h-64 overflow-y-auto">
                    @forelse(Auth::user()->unreadNotifications as $notification)
                        <li class="px-4 py-2 flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-800">{{ $notification->data['message'] }}</p>
                                <small class="text-gray-500">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            <button class="text-blue-600 hover:underline mark-as-read-admin" data-id="{{ $notification->id }}">
                                Tandai
                            </button>
                        </li>
                    @empty
                        <li class="px-4 py-2 text-gray-500 text-center">Tidak ada notifikasi baru</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="relative group">
            <!-- Tombol Profil -->
            <button id="profileToggle" class="flex items-center text-gray-600 hover:text-gray-800 focus:outline-none" aria-label="User menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A4 4 0 017 16h10a4 4 0 011.879.804M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="ml-2 hidden lg:block font-medium">{{ Auth::user()->name_user }}</span>
            </button>

            <!-- Dropdown Profil -->
            <div id="profileDropdown" class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md hidden z-50">
                <div class="px-4 py-2 text-gray-700">Hi, {{ Auth::user()->name_user }}</div>
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Dashboard</a>
                <hr class="my-1" />
                <form action="{{ route('logout') }}" method="POST" class="px-4 py-2">
                    @csrf
                    <button type="submit" class="w-full text-left text-gray-700 hover:text-red-700">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main
      id="main-content"
      class="flex-1 pt-16 px-3 sm:pl-64 transition-all duration-300">
      @yield('content')
    </main>

    <div id="global-notifications" class="fixed top-5 right-5 z-50 space-y-2"></div>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showNotification('success', "{{ session('success') }}");
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showNotification('danger', "{{ session('error') }}");
            });
        </script>
    @endif

    <!-- Toggle Script -->
    <script>
        const btn = document.getElementById('sidebarToggle')
        const sidebar = document.getElementById('sidebar')
        const main   = document.getElementById('main-content')
        const overlay = document.getElementById('sidebarOverlay');

        btn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notificationToggle = document.getElementById('admin-notification-toggle');
            const notificationDropdown = document.getElementById('admin-notification-dropdown');

            // Toggle visibility of the notification dropdown
            notificationToggle.addEventListener('click', (e) => {
                e.stopPropagation(); // Prevent event bubbling
                notificationDropdown.classList.toggle('hidden');
            });

            // Close the dropdown if clicked outside
            document.addEventListener('click', (event) => {
                if (!notificationToggle.contains(event.target) && !notificationDropdown.contains(event.target)) {
                    notificationDropdown.classList.add('hidden');
                }
            });

            // Tandai notifikasi sebagai sudah dibaca
            document.querySelectorAll('.mark-as-read-admin').forEach(button => {
                button.addEventListener('click', function () {
                    const notificationId = this.dataset.id;

                    fetch('{{ route('admin.notifications.read') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ id: notificationId }),
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.closest('li').remove();
                        }
                    });
                });
            });

            // Hapus semua notifikasi
            document.getElementById('delete-all-notifications-admin').addEventListener('click', function () {
                fetch('{{ route('admin.notifications.deleteAll') }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('admin-notification-list').innerHTML = '<li class="px-4 py-2 text-gray-500 text-center">Tidak ada notifikasi baru</li>';
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const profileToggle = document.getElementById('profileToggle');
            const profileDropdown = document.getElementById('profileDropdown');

            // Toggle dropdown visibility
            profileToggle.addEventListener('click', (e) => {
                e.stopPropagation(); // Mencegah event bubbling
                profileDropdown.classList.toggle('hidden');
            });

            // Tutup dropdown jika klik di luar
            document.addEventListener('click', (e) => {
                if (!profileDropdown.contains(e.target) && !profileToggle.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });
        });

        function showNotification(type, message) {
            const notificationContainer = document.getElementById('global-notifications');
            if (!notificationContainer) {
                console.error('Notification container not found!');
                return;
            }

            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `<span>${message}</span>`;
            notificationContainer.appendChild(notification);

            setTimeout(() => {
                notification.classList.add('fade-out');
                setTimeout(() => notification.remove(), 500); // Hapus setelah transisi selesai
            }, 3000); // Tampilkan selama 3 detik
        }

        document.addEventListener('DOMContentLoaded', function () {
            const notifications = document.querySelectorAll('.notification');
            notifications.forEach(notification => {
                setTimeout(() => {
                    notification.classList.add('fade-out');
                    setTimeout(() => notification.remove(), 500); // Hapus setelah transisi selesai
                }, 3000); // Tampilkan selama 3 detik
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
