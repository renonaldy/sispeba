<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlamatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $file = storage_path('app/indonesia_alamat.csv');

        if (!file_exists($file)) {
            throw new \Exception("CSV file not found at $file");
        }

        $handle = fopen($file, 'r');

        $header = fgetcsv($handle); // Skip header

        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            DB::table('kelurahans')->insert([
                'provinsi'   => $data[0],
                'kota'       => $data[1],
                'kecamatan'  => $data[2],
                'kelurahan'  => $data[3],
                'kode_pos'   => $data[4],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        fclose($handle);
    }
}
