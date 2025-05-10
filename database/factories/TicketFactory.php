<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition()
    {

        return [
            'id_event' => Event::factory(),
            'type' => $this->faker->randomElement(['Regular', 'VIP', 'VVIP']),
            'price' => $this->faker->numberBetween(50000, 500000),
            'quantity' => $this->faker->numberBetween(50, 500),
        ];
    }
}
