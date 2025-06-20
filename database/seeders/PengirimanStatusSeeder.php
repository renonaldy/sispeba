<?php

namespace Database\Seeders;

use App\Models\Pengiriman;
use App\Models\PengirimanStatus;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengirimanStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $pengirimen = Pengiriman::take(5)->get(); // ambil 5 pengiriman pertama

        foreach ($pengirimen as $pengiriman) {
            PengirimanStatus::create([
                'pengiriman_id' => $pengiriman->id,
                'status' => 'pickup',
                'waktu_status' => Carbon::now()->subDays(3),
            ]);

            PengirimanStatus::create([
                'pengiriman_id' => $pengiriman->id,
                'status' => 'transit',
                'waktu_status' => Carbon::now()->subDays(1),
            ]);

            PengirimanStatus::create([
                'pengiriman_id' => $pengiriman->id,
                'status' => 'delivered',
                'waktu_status' => Carbon::now(),
            ]);
        }
    }
}
