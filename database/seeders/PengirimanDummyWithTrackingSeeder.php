<?php

namespace Database\Seeders;

use App\Models\Pengiriman;
use App\Models\PengirimanStatus;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PengirimanDummyWithTrackingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for ($i = 1; $i <= 5; $i++) {
            $pengiriman = Pengiriman::create([
                'no_resi' => strtoupper(Str::random(10)),
                'nama_penerima' => "Penerima {$i}",
                'alamat_tujuan' => "Jl. Contoh Alamat No.{$i}, Pekanbaru",
                'status' => 'delivered',
                'created_at' => now()->subDays(3),
            ]);

            PengirimanStatus::create([
                'pengiriman_id' => $pengiriman->id,
                'status' => 'pickup',
                'waktu_status' => Carbon::now()->subDays(3)->setTime(9, 0),
            ]);

            PengirimanStatus::create([
                'pengiriman_id' => $pengiriman->id,
                'status' => 'transit',
                'waktu_status' => Carbon::now()->subDays(2)->setTime(12, 0),
            ]);

            PengirimanStatus::create([
                'pengiriman_id' => $pengiriman->id,
                'status' => 'delivered',
                'waktu_status' => Carbon::now()->subDays(1)->setTime(16, 30),
            ]);
        }
    }
}
