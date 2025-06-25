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

        DB::table('kotas')->insert([
            ['nama' => 'Pekanbaru'],
            ['nama' => 'Dumai'],
            // ['nama_kota' => 'Surabaya'],
            // Tambahkan data kota lainnya
        ]);
    }
}
