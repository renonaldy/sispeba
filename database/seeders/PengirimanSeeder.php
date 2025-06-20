<?php

namespace Database\Seeders;

use App\Models\Pengiriman;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengirimanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Pengiriman::create([
            'nama_pengirim' => 'Ahmad',
            'alamat_tujuan' => 'Pekanbaru, Riau',
            'status' => 'dalam proses',
        ]);

        Pengiriman::create([
            'nama_pengirim' => 'Budi',
            'alamat_tujuan' => 'Jakarta Selatan',
            'status' => 'selesai',
        ]);

        $this->call([
            PengirimanSeeder::class,
        ]);
    }
}
