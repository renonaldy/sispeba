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
        Schema::create('rekening_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->string('jenis'); // bank / e-wallet
            $table->string('nama'); // BCA, Mandiri, Dana, OVO, dll
            $table->string('atas_nama');
            $table->string('nomor_rekening');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekening_pembayarans');
    }
};
