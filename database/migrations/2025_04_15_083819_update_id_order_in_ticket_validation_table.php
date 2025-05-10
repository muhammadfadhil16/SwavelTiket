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
        Schema::table('ticket_validation', function (Blueprint $table) {
            $table->unsignedBigInteger('id_order')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket_validation', function (Blueprint $table) {
            $table->unsignedBigInteger('id_order')->nullable(false)->default(0)->change();
        });
    }
};
