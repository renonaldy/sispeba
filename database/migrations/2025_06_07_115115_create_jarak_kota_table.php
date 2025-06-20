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
        Schema::create('jarak_kota', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kota_asal_id');
            $table->unsignedBigInteger('kota_tujuan_id');
            $table->float('jarak'); // dalam kilometer
            $table->timestamps();

            $table->foreign('kota_asal_id')->references('id')->on('kotas')->onDelete('cascade');
            $table->foreign('kota_tujuan_id')->references('id')->on('kotas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jarak_kota');
    }
};
