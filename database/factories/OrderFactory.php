<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'id_user' => User::inRandomOrder()->first()->id, // Ambil ID user secara acak
            'id_event' => Event::inRandomOrder()->first()->id_event, // Ambil ID event secara acak
            'id_ticket' => Ticket::inRandomOrder()->first()->id_ticket, // Menghasilkan ID tiket acak
            'payment_proof' => $this->faker->imageUrl(640, 480, 'business'), // Menghasilkan URL gambar acak untuk bukti pembayaran
            'status' => $this->faker->randomElement(['pending']), // Pilih status acak
            'quantity' => $this->faker->numberBetween(1, 10), // Jumlah tiket yang dipesan
            'total_price' => $this->faker->numberBetween(50000, 100000), // Harga total acak
            'created_at' => $this->faker->dateTimeBetween('-6 months', '+6 months'),
        ];
    }
}
