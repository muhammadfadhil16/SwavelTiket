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
</head>
<body class="bg-login min-h-screen flex flex-col items-center justify-center">

    @if (session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showNotification(
                    "{{ session('status') === 'error' ? 'danger' : session('status') }}",
                    "{{ session('message') }}"
                );
            });
        </script>
    @endif

    <div id="global-notifications" class="fixed top-5 right-5 z-50 space-y-2"></div>

    <!-- Konten Utama -->
    <div class="container max-w-sm mx-auto p-5 h-full">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="text-center text-gray-600 text-sm mt-1 w-full">
        &copy; {{ date('Y') }} Tiket Aja. All rights reserved.
    </footer>

    <!-- Script Notifikasi Global -->
    <script>
        function showNotification(type, message) {
            const notificationContainer = document.getElementById('global-notifications');
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `<span>${message}</span>`;
            notificationContainer.appendChild(notification);

            setTimeout(() => {
                notification.classList.add('fade-out');
                setTimeout(() => notification.remove(), 500);
            }, 3000);
        }
    </script>
</body>
</html>
