<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    public function run()
    {
        // Membuat 10 data event menggunakan factory
        Event::factory()->count(5)->create();
    }
}
