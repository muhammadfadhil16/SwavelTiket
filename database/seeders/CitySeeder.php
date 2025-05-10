<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    public function run()
    {
        $cities = [
            'Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Yogyakarta', 'Makassar',
            'Semarang', 'Denpasar', 'Palembang', 'Batam', 'Banjarmasin', 'Balikpapan',
            'Tangerang', 'Cimahi', 'Malang', 'Pekanbaru', 'Padang', 'Pontianak',
            'Manado', 'Samarinda', 'Mataram', 'Jayapura', 'Kupang', 'Cirebon',
            'Bogor', 'Depok', 'Bekasi', 'Tangerang Selatan', 'Solo', 'Banda Aceh',
            'Palangkaraya', 'Ambon', 'Ternate', 'Sorong'
        ];

        foreach ($cities as $city) {
            City::create(['name' => $city]);
        }
    }
}
