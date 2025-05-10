<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;

class OrdersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    /**
     * Ambil semua data order.
     */
    public function collection()
    {
        return Order::with(['user', 'ticket'])->get();
    }

    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
    {
            $sheet->getStyle('A1:H1')->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FFFFFFFF'], // Warna teks putih
                    'size' => 12, // Ukuran font header
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF4F81BD'], // Warna background biru muda
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Tambahkan border ke seluruh kolom yang berisi data
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'], // Warna hitam
                    ],
                ],
            ]);

            // Atur tinggi baris header
            $sheet->getRowDimension(1)->setRowHeight(25);

            // Pusatkan konten untuk kolom tertentu
            $sheet->getStyle('A2:A' . $highestRow)->getAlignment()->setHorizontal('center'); // ID rata tengah
            $sheet->getStyle('B2:B' . $highestRow)->getAlignment()->setHorizontal('center'); // Nama Pengguna rata tengah
            $sheet->getStyle('C2:C' . $highestRow)->getAlignment()->setHorizontal('center'); // Email Pengguna rata tengah
            $sheet->getStyle('D2:D' . $highestRow)->getAlignment()->setHorizontal('center'); // Nama Event rata tengah
            $sheet->getStyle('E2:E' . $highestRow)->getAlignment()->setHorizontal('center'); // Kategori rata tengah
            $sheet->getStyle('F2:F' . $highestRow)->getAlignment()->setHorizontal('center'); // Jumlah rata tengah
            $sheet->getStyle('G2:G' . $highestRow)->getAlignment()->setHorizontal('center'); // Status rata tengah
            $sheet->getStyle('H2:H' . $highestRow)->getAlignment()->setHorizontal('center'); // Tanggal Pemesanan rata tengah
    }

    /**
     * Tambahkan header untuk setiap kolom di Excel.
     */
    public function headings(): array
    {
        return [
            'ID Order',
            'Nama Pengguna',
            'Email Pengguna',
            'Nama Event',
            'Jenis Tiket',
            'Jumlah',
            'Status',
            'Tanggal Pemesanan',
        ];
    }

    /**
     * Mapping data untuk setiap baris di Excel.
     */
    public function map($order): array
    {
        return [
            $order->id_order,
            $order->user->name_user ?? 'N/A',
            $order->user->email_user ?? 'N/A',
            $order->ticket->event->name ?? 'N/A',
            $order->ticket->type ?? 'N/A',
            $order->quantity,
            ucfirst($order->status), // Ubah ke format huruf kapital pertama
            $order->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
