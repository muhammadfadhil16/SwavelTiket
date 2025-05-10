<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // Membuat 10 data order menggunakan factory
        Order::factory()->count(5)->create();
    }
}
