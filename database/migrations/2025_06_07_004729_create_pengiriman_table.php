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
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengirim');
            $table->string('nama_penerima');
            $table->text('alamat');
            $table->string('kota');
            $table->string('kode_pos');
            // $table->string('alamat_tujuan');
            $table->string('status')->default('dalam proses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('pengiriman');
        Schema::table('pengiriman', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
