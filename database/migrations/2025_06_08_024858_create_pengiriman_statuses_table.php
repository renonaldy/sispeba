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
        Schema::create('pengiriman_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengiriman_id')->constrained()->onDelete('cascade');
            $table->string('status'); // contoh: 'pickup', 'transit', 'delivered'
            $table->timestamp('waktu_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengiriman_statuses');
    }
};
