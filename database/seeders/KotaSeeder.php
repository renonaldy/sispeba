<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $this->call(KotaSeeder::class);
        $kotaPekanbaru = [
            'Bukit Raya',
            'Lima Puluh',
            'Marpoyan Damai',
            'Payung Sekaki',
            'Pekanbaru Kota',
            'Rumbai',
            'Rumbai Barat',
            'Sail',
            'Senapelan',
            'Sukajadi',
            'Tampan',
            'Tenayan Raya',
            'Rumbai Timur',
            'Binawidya',
            'Tuah Madani',
        ];



        foreach ($kotaPekanbaru as $nama) {
            DB::table('kotas')->insert([
                'nama'       => $nama,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
