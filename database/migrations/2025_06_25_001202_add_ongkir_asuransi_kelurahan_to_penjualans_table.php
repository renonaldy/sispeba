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
        Schema::table('penjualans', function (Blueprint $table) {
            //
            $table->foreignId('kelurahan_id')->nullable()->constrained('kelurahans')->after('alamat');
            $table->integer('ongkir')->default(0)->after('kelurahan_id');
            $table->boolean('asuransi')->default(false)->after('ongkir');
            $table->string('no_resi')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penjualans', function (Blueprint $table) {
            //
        });
    }
};
