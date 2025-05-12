<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrderDetailTableAddNullableQrCode extends Migration
{
    public function up()
    {
        Schema::table('order_detail', function (Blueprint $table) {
            $table->string('qr_code')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('order_detail', function (Blueprint $table) {
            $table->string('qr_code')->nullable(false)->change();
        });
    }
}
