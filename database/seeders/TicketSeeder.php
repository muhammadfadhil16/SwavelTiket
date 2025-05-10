<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    public function run()
    {

        Ticket::factory()->count(20)->create();
    }
}
