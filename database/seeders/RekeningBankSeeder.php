<?php

namespace Database\Seeders;

use App\Models\RekeningBank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RekeningBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        RekeningBank::insert([
            ['nama_bank' => 'BCA', 'nomor_rekening' => '1234567890', 'atas_nama' => 'CV SISPEBA STORE', 'jenis' => 'bank'],
            ['nama_bank' => 'DANA', 'nomor_rekening' => '081234567890', 'atas_nama' => 'CV SISPEBA STORE', 'jenis' => 'e-wallet'],
        ]);
    }
}
