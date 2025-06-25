<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        DB::table('kecamatans')->insert([
            ['nama' => 'Bukit Raya'],
            ['nama' => 'Lima Puluh'],
            ['nama' => 'Marpoyan Damai'],
            ['nama' => 'Payung Sekaki'],
            ['nama' => 'Pekanbaru Kota'],
            ['nama' => 'Sail'],
            ['nama' => 'Senapelan'],
            ['nama' => 'Sukajadi'],
            ['nama' => 'Tenayan Raya'],
            ['nama' => 'Binawidya'],
            ['nama' => 'Kulim'],
            ['nama' => 'Rumbai Barat'],
            ['nama' => 'Rumbai'],
            ['nama' => 'Rumbai Timur'],
            ['nama' => 'Tuahmadani'],
            ['nama' => 'Dumai Selatan'],
            ['nama' => 'Dumai Timur'],
            ['nama' => 'Dumai Kota'],
            ['nama' => 'Sungai Sembilan'],
            ['nama' => 'Medang Kampai'],
            ['nama' => 'Bukit Kapur'],
        ]);
    }
}
