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
        Schema::create('order_detail', function (Blueprint $table) {
            $table->id('id_order_detail');
            $table->unsignedBigInteger('id_order'); // Tipe data disesuaikan
            $table->foreign('id_order')->references('id_order')->on('orders')->onDelete('cascade');
            $table->unsignedBigInteger('id_ticket'); // Sesuaikan tipe dengan tabel tickets jika bigint
            $table->foreign('id_ticket')->references('id_ticket')->on('tickets')->onDelete('cascade');
            $table->string('qr_code', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_detail');
    }
};
