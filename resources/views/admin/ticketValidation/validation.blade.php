@extends('layouts.adminLayout')

@section('title', 'Ticket Validation')

@section('content')
<div class="container mx-auto mt-8 px-4 sm:px-2">
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6 sm:text-xl">Ticket Validation</h1>

    <!-- Alert Messages -->
    @if (session('status') === 'qr.success')
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i> QR Code berhasil diverifikasi!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif (session('status') === 'qr.error')
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle-fill"></i> QR Code gagal diverifikasi!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Validation Form -->
    <form id="validationForm" method="POST" action="{{ route('admin.ticketValidation.validate') }}" class="bg-white p-6 rounded-lg shadow-md sm:p-4">
        @csrf
        <!-- QR Code Scanner -->
        <div class="container mt-4">
            <h2 class="text-xl font-semibold mb-4 text-center">Scan QR Code</h2>
            <div id="qr-reader" class="mx-auto" style="width: 100%; max-width: 500px; border: 1px solid #ddd; padding: 10px; border-radius: 8px;"></div>
            <div id="qr-reader-results" class="mt-3 text-center"></div>
            <div id="verification-status" class="mt-4 text-center"></div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const qrReader = new Html5Qrcode("qr-reader");

        // Fungsi untuk memulai scanner
        function startScanner() {
            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    const cameraId = devices[0].id; // Pilih kamera pertama
                    qrReader.start(
                        cameraId,
                        { fps: 10, qrbox: { width: 250, height: 250 } },
                        onScanSuccess,
                        onScanFailure
                    ).catch(error => {
                        displayError("Unable to access the camera. Please check your browser settings and permissions.");
                        console.error("Error starting scanner:", error);
                    });
                } else {
                    displayError("No cameras available. Please check your device.");
                }
            }).catch(error => {
                displayError("Unable to access the camera. Please check your browser settings and permissions.");
                console.error("Error getting cameras:", error);
            });
        }

        // Fungsi untuk menangani hasil scan QR code
        function onScanSuccess(decodedText, decodedResult) {
            const statusDiv = document.getElementById('verification-status');
            statusDiv.innerHTML = `<p class="text-info">Verifying QR Code... <span class="spinner-border spinner-border-sm"></span></p>`;

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
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    displaySuccess("QR Code berhasil diverifikasi!");
                } else {
                    displayError(`QR Code gagal diverifikasi: ${data.message}`);
                }
            })
            .catch(error => {
                displayError("Terjadi kesalahan saat memverifikasi QR Code.");
                console.error('Error verifying QR code:', error);
            });
        }

        // Fungsi untuk menangani kegagalan scan QR code
        function onScanFailure(error) {
            console.warn(`QR Code scan failed: ${error}`);
        }

        // Fungsi untuk menampilkan pesan sukses
        function displaySuccess(message) {
            const statusDiv = document.getElementById('verification-status');
            statusDiv.innerHTML = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
        }

        // Fungsi untuk menampilkan pesan error
        function displayError(message) {
            const statusDiv = document.getElementById('verification-status');
            statusDiv.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
        }

        // Mulai scanner
        startScanner();
    });
</script>
@endsection
