<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JarakKotaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jarak_kotas')->insert([
            [
                'asal_kota' => 'Pekanbaru',
                'asal_kecamatan' => 'Bukit Raya',
                'asal_kelurahan' => 'Air Dingin',
                'tujuan_kota' => 'Dumai',
                'tujuan_kecamatan' => 'Dumai Selatan',
                'tujuan_kelurahan' => 'Pahlawan',
                'jarak' => 125
            ],
            [
                'asal_kota' => 'Pekanbaru',
                'asal_kecamatan' => 'Bukit Raya',
                'asal_kelurahan' => 'Simpang Tiga',
                'tujuan_kota' => 'Dumai',
                'tujuan_kecamatan' => 'Dumai Timur',
                'tujuan_kelurahan' => 'Teluk Binjai',
                'jarak' => 128
            ],
            [
                'asal_kota' => 'Pekanbaru',
                'asal_kecamatan' => 'Senapelan',
                'asal_kelurahan' => 'Kampung Dalam',
                'tujuan_kota' => 'Dumai',
                'tujuan_kecamatan' => 'Bukit Kapur',
                'tujuan_kelurahan' => 'Bukit Kapur',
                'jarak' => 135
            ],
            // Tambah data lainnya...
        ]);
    }
}
