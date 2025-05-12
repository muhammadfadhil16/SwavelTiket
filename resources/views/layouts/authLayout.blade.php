<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tiket Aja - Platform Pemesanan Tiket Terbaik">
    <meta name="keywords" content="Tiket, Pemesanan, Event, Tiket Aja">
    <meta name="author" content="Tiket Aja">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('assets/img/tikettt.png') }}" onerror="this.src='{{ asset('assets/img/default.png') }}'">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notifications = document.querySelectorAll('.notification');
            notifications.forEach(notification => {
                setTimeout(() => {
                    notification.classList.add('hide');
                }, 2000); // Hilang setelah 2 detik
            });
        });
    </script>
</head>
<body class="bg-login min-h-screen flex flex-col items-center justify-center"></body>
    <!-- Notifikasi -->
    <div id="notification" class="fixed top-5 right-5 z-50 hidden p-4 rounded-lg text-white shadow-lg"></div>

    <!-- Kontainer Utama -->
    <div class="container max-w-sm mx-auto p-5 h-full">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="text-center text-gray-600 text-sm mt-1 w-full">
        &copy; {{ date('Y') }} Tiket Aja. All rights reserved.
    </footer>

    <!-- Script Notifikasi -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const notification = document.getElementById('notification');

            @if (session('status'))
                const message = "{{ session('status') === 'success' ? 'Login berhasil! Selamat datang di halaman katalog.' : 'Email atau password salah!' }}";
                const type = "{{ session('status') }}";

                showNotification(message, type);
            @endif

            function showNotification(message, type) {
                notification.textContent = message;
                notification.classList.remove('hidden');
                notification.style.transition = 'all 5s ease';

                if (type === 'success') {
                    notification.style.backgroundColor = '#4caf50'; // Hijau untuk sukses
                } else if (type === 'error') {
                    notification.style.backgroundColor = '#f44336'; // Merah untuk error
                }

                setTimeout(() => {
                    notification.style.opacity = '0';
                    setTimeout(() => {
                        notification.classList.add('hidden');
                        notification.style.opacity = '1';
                    }, 400);
                }, 4000);
            }
        });
    </script>
</body>
</html>
