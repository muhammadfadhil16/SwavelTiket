<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Support\Facades\Storage;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EventsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    /**
     * Mengambil semua data event
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Event::all(); // Atau Anda bisa sesuaikan untuk mengambil event dengan kondisi tertentu
    }

    /**
     * Menerapkan gaya pada sheet Excel
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Atur style untuk header (baris pertama)
        $sheet->getStyle('A1:I1')->applyFromArray([
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
        $sheet->getStyle('C2:C' . $highestRow)->getAlignment()->setHorizontal('center'); // Tanggal rata tengah
        $sheet->getStyle('F2:F' . $highestRow)->getAlignment()->setHorizontal('center'); // Kapasitas rata tengah
        $sheet->getStyle('G2:G' . $highestRow)->getAlignment()->setHorizontal('center'); // Status rata tengah
        $sheet->getStyle('H2:H' . $highestRow)->getAlignment()->setHorizontal('center'); // Kategori rata tengah
    }


    /**
     * Menambahkan heading pada file Excel
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Date',
            'Location',
            'Description',
            'Capacity',
            'Status',
            'Category',
            'Image',
        ];
    }

    /**
     * Memetakan data event ke dalam format yang akan diekspor
     *
     * @param \App\Models\Event $event
     * @return array
     */
    public function map($event): array
    {
        return [
            $event->id_event,
            $event->name,
            $event->date,
            $event->location,
            $event->description,
            $event->capacity,
            $event->status,
            $event->category,
            $event->image ? Storage::url($event->image) : null, // Untuk menangani file gambar
        ];
    }
}
