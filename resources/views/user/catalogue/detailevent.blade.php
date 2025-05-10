@extends('layouts.userLayout')

@section('title', $event->name)

@section('content')
<div class="container">
    <section class="shadow-lg p-2 rounded-lg bg-white">
        <img src="{{ asset('storage/' . $event->image) }}" alt="img-card" class="w-full h-[30vh] rounded-lg object-cover" />
        <div class="mt-2 border-b-2 py-2">
            <p class="text-2xl font-medium ">
                {{ \Carbon\Carbon::parse($event->date)->format('l, d M Y') }}
            </p>
            <h1 class="text-4xl font-semibold">{{ $event->name }}</h1>
        </div>

        <div class="py-2">
            <p><i class="bi bi-geo-fill"></i> {{ $event->location }}</p>
            <div class="mt-2">
                <h5 class="text-xl font-bold">Tentang Event</h5>
                <p class="text-m">{{ $event->description }}</p>
            </div>
        </div>
    </section>

    <section class="bg-white rounded-lg mt-3">
        <div class="container mx-auto py-8">
            <div class="flex mb-4">
                <ul class="flex space-x-8">
                    <li>
                        <a href="#" id="tab1" class="tab-link text-blue-600 border-b-2 border-transparent hover:border-blue-600 pb-2 px-4">Syarat dan Ketentuan</a>
                    </li>
                    <li>
                        <a href="{{ route('tickets.index', ['event' => $event->id_event]) }}" id="tab2" class="tab-link text-blue-600 border-b-2 border-transparent hover:border-blue-600 pb-2 px-4">Tiket</a>

                    </li>
                </ul>
            </div>

            <!-- Tab Content: Syarat dan Ketentuan -->
            <div id="tab1-content" class="tab-content hidden">
                <div class="syarat-ketentuan p-6 rounded-xl">
                    <h2 class="text-primary-900 text-xl font-semibold mb-4">Syarat dan Ketentuan Acara</h2>
                    <ol class="list-decimal ml-6">
                        <li>
                            <strong>Pendaftaran:</strong>
                            <ul>
                                <li>Peserta harus mendaftar melalui <a href="#" class="text-blue-600">link pendaftaran</a> sebelum <strong>[tanggal batas pendaftaran]</strong>.</li>
                                <li>Pendaftaran yang diterima setelah tanggal batas tidak akan diproses.</li>
                            </ul>
                        </li>
                        <li>
                            <strong>Peserta:</strong>
                            <ul>
                                <li>Acara ini terbuka untuk <strong>[keterangan peserta]</strong>.</li>
                                <li>Peserta diharapkan memberikan informasi yang akurat dan lengkap.</li>
                            </ul>
                        </li>
                        <li>
                            <strong>Pembayaran:</strong>
                            <ul>
                                <li>Biaya pendaftaran sebesar <strong>[jumlah]</strong> harus dibayarkan sebelum <strong>[tanggal pembayaran]</strong>.</li>
                                <li>Pembayaran dapat dilakukan melalui <strong>[metode pembayaran]</strong>.</li>
                                <li>Biaya pendaftaran tidak dapat dikembalikan setelah <strong>[tanggal pengembalian]</strong>.</li>
                            </ul>
                        </li>
                        <li>
                            <strong>Program dan Jadwal:</strong>
                            <ul>
                                <li>Acara akan berlangsung pada <strong>[tanggal dan waktu]</strong>.</li>
                                <li>Lokasi acara: <strong>[nama tempat dan alamat]</strong>.</li>
                                <li>Jadwal lengkap acara akan diumumkan melalui <strong>[media komunikasi]</strong>.</li>
                            </ul>
                        </li>
                        <li>
                            <strong>Kegiatan:</strong>
                            <ul>
                                <li>Peserta diharapkan mengikuti semua kegiatan yang telah dijadwalkan.</li>
                                <li>Peserta diharapkan menjaga etika dan disiplin selama acara berlangsung.</li>
                            </ul>
                        </li>
                        <li>
                            <strong>Tanggung Jawab:</strong>
                            <ul>
                                <li>Penyelenggara tidak bertanggung jawab atas kehilangan, kerusakan, atau kecelakaan yang terjadi selama acara.</li>
                                <li>Peserta harus menjaga keselamatan diri masing-masing.</li>
                            </ul>
                        </li>
                        <li>
                            <strong>Pelanggaran:</strong>
                            <ul>
                                <li>Setiap pelanggaran terhadap syarat dan ketentuan ini dapat mengakibatkan diskualifikasi dari acara.</li>
                            </ul>
                        </li>
                        <li>
                            <strong>Ketentuan Lain:</strong>
                            <ul>
                                <li>Peserta setuju untuk menerima informasi dan pembaruan terkait acara dengan melakukan pendaftaran.</li>
                                <li>Syarat dan ketentuan ini dapat diperbarui oleh penyelenggara tanpa pemberitahuan sebelumnya.</li>
                            </ul>
                        </li>
                        <li>
                            <strong>Kontak:</strong>
                            <ul>
                                <li>Untuk informasi lebih lanjut, silakan hubungi <strong>[nama dan kontak]</strong>.</li>
                            </ul>
                        </li>
                    </ol>
                </div>
            </div>

            <!-- Tab Content: Tiket -->
            <div id="tab2-content" class="tab-content hidden">
                <div class="tickets grid grid-cols-1 gap-4 lg:grid-cols-2">
                    @foreach ($event->tickets as $ticket) <!-- Loop through each ticket for the event -->
                    <div class="ticket bg-primary-50 flex flex-col gap-8 rounded-xl p-6">
                        {{-- <div class="w-full h-48">
                            <img src="{{ asset('storage/images/' . $ticket->image) }}" alt="Ticket Image" class="w-full h-full object-cover rounded-t-lg">
                    </div> --}}
                    <div class="bg-gray-100 flex flex-col gap-4 rounded-xl p-6">
                        <h2 class="text-primary-900 text-lg font-semibold">{{ $ticket->type }} Ticket</h2>
                        <span class="text-sm text-gray-500 md:text-base">{{ $ticket->description }}</span>
                        <h4 class="text-primary-900 text-xl font-bold md:text-3xl">Rp {{ number_format($ticket->price, 0, ',', '.') }}</h4>

                        <!-- Quantity Form -->
                        <form action="{{ route('order.store') }}" method="POST" class="mt-4">
                            @csrf
                            {{-- mengambil data untuk create --}}
                            <input type="hidden" name="id_ticket" value="{{ $ticket->id_ticket}}">
                            <input type="hidden" name="id_event" value="{{ $event->id_event }}">
                            <input type="hidden" name="customer_name" value="{{ Auth::user()->name_user }}">
                            <input type="hidden" name="customer_email" value="{{ Auth::user()->email_user }}">

                            <div class="flex items-center space-x-4">
                                <input type="number" name="quantity" min="1" max="{{ $ticket->quantity }}" value="1" class="w-20 p-2 border rounded-md" required>
                                <p class="text-sm text-gray-500">Max available: {{ $ticket->quantity }}</p>
                            </div>
                            <button type="submit" class="mt-4 w-full py-2 px-4 text-center text-white rounded-lg border border-primary-900 bg-blue-900 hover:bg-primary-950 duration-200 ">
                                Buy Ticket
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

</div>
</section>

</div>
@endsection
