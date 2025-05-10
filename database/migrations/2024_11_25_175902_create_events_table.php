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
        Schema::create('events', function (Blueprint $table) {
            $table->id('id_event')->autoIncrement();
            $table->string('name', 255);
            $table->date('date');
            $table->string('image')->nullable();
            $table->string('location', 255);
            $table->text('description')->nullable();
            $table->integer('capacity');
            $table->enum('status', ['Ongoing', 'Upcoming', 'Done'])->default('Upcoming');
            $table->enum('category', ['Music', 'Sport', 'Seminar', 'Workshop']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
