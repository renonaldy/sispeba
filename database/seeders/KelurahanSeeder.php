<?php

namespace Database\Seeders;

use App\Models\Kelurahan;
// use Dotenv\Store\File\Reader;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use League\Csv\Reader;

class KelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $csv = Reader::createFromPath(database_path('seeders/data/indonesia_alamat.csv'), 'r');
        $csv->setHeaderOffset(0); // Anggap baris pertama header

        $records = $csv->getRecords();

        foreach ($records as $record) {
            Kelurahan::create([
                'provinsi' => $record['provinsi'],
                'kota' => $record['kota'],
                'kecamatan' => $record['kecamatan'],
                'kelurahan' => $record['kelurahan'],
                'kode_pos' => $record['kode_pos'],
            ]);
        }
    }
}
