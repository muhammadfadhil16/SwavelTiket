@extends('layouts.adminLayout')

@section('title', 'Ticket Validation')

@section('content')
<div class="container mx-auto mt-8 px-4 sm:px-2">
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6 sm:text-xl">Validasi Tiket</h1>

    <!-- Alert Messages -->
    @if (session('status') === 'qr.success')
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i> QR Code berhasil diverifikasi!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showNotification('success', 'QR Code berhasil diverifikasi!');
        });
    </script>
    @elseif (session('status') === 'qr.warning')
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i> Tiket sudah tervalidasi sebelumnya.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showNotification('warning', 'Tiket sudah tervalidasi sebelumnya.');
        });
    </script>
    @elseif (session('status') === 'qr.not_found')
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle-fill"></i> QR Code tidak ditemukan!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showNotification('danger', 'QR Code tidak ditemukan!');
        });
    </script>
    @elseif (session('status') === 'qr.invalid')
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle-fill"></i> QR Code tidak valid!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showNotification('danger', 'QR Code tidak valid!');
        });
    </script>
    @elseif (session('status') === 'qr.expired')
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle-fill"></i> QR Code sudah kadaluarsa!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showNotification('danger', 'QR Code sudah kadaluarsa!');
        });
    </script>
    @elseif (session('status') === 'qr.error')
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle-fill"></i> QR Code gagal diverifikasi!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- QR Code Scanner -->
    <div class="container mt-4">
        <h2 class="text-xl font-semibold mb-4 text-center">Scan QR Code</h2>
        <div id="qr-reader" class="mx-auto" style="width: 100%; max-width: 500px; border: 1px solid #ddd; padding: 10px; border-radius: 8px;"></div>
        <div id="qr-reader-results" class="mt-3 text-center"></div>
        <div id="verification-status" class="mt-4 text-center"></div>
        <div id="validation-status" class="mt-4"></div>

        <!-- Camera Selection Dropdown -->
        <select id="camera-select" class="mb-3 px-2 py-1 border rounded"></select>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const qrReader = new Html5Qrcode("qr-reader");
        let lastScanTime = 0; // Waktu terakhir pemindaian berhasil
        const scanInterval = 3000; 
        let currentCameraId = null;
        let cameras = [];

        // Fungsi untuk memulai scanner
        function startScanner(cameraId) {
            qrReader.stop().catch(()=>{}); // Stop jika sudah ada scanner berjalan
            qrReader.start(
                cameraId,
                { fps: 10, qrbox: { width: 250, height: 250 } },
                onScanSuccess,
                onScanFailure
            ).catch(error => {
                showNotification('danger', "Unable to access the camera. Please check your browser settings and permissions.");
                console.error("Error starting scanner:", error);
            });
            currentCameraId = cameraId;
        }

        // Fungsi untuk menangani hasil scan QR code
        function onScanSuccess(decodedText, decodedResult) {
            const currentTime = Date.now();

            // Batasi pemrosesan jika waktu sejak pemindaian terakhir kurang dari interval
            if (currentTime - lastScanTime < scanInterval) {
                console.log("Scan ignored to prevent spam.");
                return;
            }

            lastScanTime = currentTime; // Perbarui waktu pemindaian terakhir
            showNotification('info', "Verifying QR Code...");

            // Kirim QR code ke server untuk verifikasi
            fetch('{{ route('admin.ticketValidation.validate') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ qr_code: decodedText })
            })
            .then(response => {
                // Periksa apakah respons berhasil
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.message || `HTTP error! status: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Server Response:', data); // Log respons server
                if (data.success) {
                    showNotification('success', "QR Code berhasil diverifikasi!");
                    document.getElementById('verification-status').innerText = "QR Code berhasil diverifikasi!";
                } else if (data.message === 'Tiket sudah divalidasi sebelumnya.') {
                    console.log('Tiket sudah tervalidasi:', data); // Log tambahan
                    showNotification('danger', "Tiket sudah tervalidasi.");
                    document.getElementById('verification-status').innerText = "Tiket sudah tervalidasi.";
                } else {
                    showNotification('danger', data.message);
                    document.getElementById('verification-status').innerText = data.message;
                }
            })
            .catch(error => {
                showNotification('danger', error.message || "Terjadi kesalahan saat memverifikasi QR Code.");
                console.error('Error verifying QR code:', error);
            });
        }

        // Fungsi untuk menangani kegagalan scan QR code
        function onScanFailure(error) {
            console.warn(`QR Code scan failed: ${error}`);
        }

        // Fungsi untuk menampilkan notifikasi pop-up
        function showNotification(type, message) {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `<span>${message}</span>`;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.add('fade-out');
                setTimeout(() => notification.remove(), 500); // Hapus setelah transisi selesai
            }, 3000); // Tampilkan selama 3 detik
        }

        // Fungsi untuk memperbarui daftar kamera
        function updateCameraList() {
            Html5Qrcode.getCameras().then(devices => {
                cameras = devices;
                const select = document.getElementById('camera-select');
                select.innerHTML = '';
                devices.forEach(device => {
                    const option = document.createElement('option');
                    option.value = device.id;
                    option.text = device.label || `Camera ${select.length + 1}`;
                    select.appendChild(option);
                });
                if (devices.length) {
                    startScanner(devices[0].id);
                }
                select.onchange = function() {
                    startScanner(this.value);
                };
            }).catch(error => {
                showNotification('danger', "No cameras available. Please check your device.");
            });
        }

        // Perbarui daftar kamera saat halaman dimuat
        updateCameraList();
    });
</script>
@endsection
