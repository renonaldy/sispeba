<?php

namespace Database\Seeders;

use App\Models\KategoriProduk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $kategori = [
            'Kosmetik',
            'Pakaian',
            'Kendaraan Kecil',
            'Obat-obatan',
            'Lain-lain'
        ];

        foreach ($kategori as $nama) {
            KategoriProduk::firstOrCreate(['nama' => $nama]);
        }
    }
}
