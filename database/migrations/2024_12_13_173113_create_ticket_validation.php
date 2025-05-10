<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticket_validation', function (Blueprint $table) {
            $table->id('id_ticketvalidation');
            $table->foreignId('id_order')->constrained('orders')->references('id_order'); // Reference the 'id_order' column in 'orders'
            $table->foreignId('id_ticket')->constrained('tickets')->references('id_ticket'); // Reference the 'id_ticket' column in 'tickets'
            $table->foreignId('id_order_detail')->constrained('order_detail')->references('id_order_detail');
            $table->boolean('is_valid')->default(false);
            $table->timestamp('validation_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_validation');
    }
};
