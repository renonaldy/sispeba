<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelurahannSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $kelurahans = [
            'Air Dingin',
            'Simpang Tiga',
            'Tangkerang Labuai',
            'Tangkerang Selatan',
            'Tangkerang Utara',
            'Pesisir',
            'Sekip',
            'Tanjung Rhu',
            'Rintis',
            'Maharatu',
            'Perhentian Marpoyan',
            'Sidomulyo Timur',
            'Wonorejo',
            'Tangkerang Barat',
            'Tangkerang Tengah',
            'Air Hitam',
            'Labuh Baru Barat',
            'Labuh Baru Timur',
            'Tampan',
            'Bandar Raya',
            'Tirta Siak',
            'Sukaramai',
            'Sumahilang',
            'Kota Tinggi',
            'Kota Baru',
            'Tanah Datar',
            'Simpang Empat',
            'Cinta Raja',
            'Sukamaju',
            'Sukamulya',
            'Sago',
            'Kampung Dalam',
            'Kampung Bandar',
            'Kampung Baru',
            'Padang Terubuk',
            'Padang Bulan',
            'Sukajadi',
            'Harjosari',
            'Kedung Sari',
            'Kampung Melayu',
            'Jadirejo',
            'Pulau Karam',
            'Kampung Tengah',
            'Rejosari',
            'Bambu Kuning',
            'Bencah Lesung',
            'Tangkerang Timur',
            'Industri Tenayan',
            'Melebung',
            'Sialang Sakti',
            'Tuah Negeri',
            'Binawidya',
            'Delima',
            'Simpang Baru',
            'Tobek Godang',
            'Sungai Sibam',
            'Kulim',
            'Mentangor',
            'Sialangrampai',
            'Pebatuan',
            'Pematangkapau',
            'Agrowisata',
            'Maharani',
            'Muara Fajar Barat',
            'Muara Fajar Timur',
            'Rantau Panjang',
            'Rumbai Bukit',
            'Sri Meranti',
            'Umban Sari',
            'Palas',
            'Lembah Damai',
            'Limbungan Baru',
            'Meranti Pandak',
            'Tebing Tinggi Okura',
            'Sungaiukai',
            'Sungaiambang',
            'Lembah Sari',
            'Limbungan',
            'Sidomulyo Barat',
            'Sialangmunggu',
            'Tuahkarya',
            'Tuahmadani',
            'Airputih',
            'Pahlawan',
            'Tanjung Palas',
            'Laksamana',
            'Teluk Binjai',
            'Bumi Ayu',
            'Suka Maju',
            'Dumai Kota',
            'Pahlawan',
            'Rimba Sekampung',
            'Sungai Sembilan',
            'Babussalam',
            'Pangkalan Jati',
            'Medang Kampai',
            'Air Tawar',
            'Kurnia',
            'Bukit Kapur',
            'Pangkalan Sei',
            'Tambun',
        ];

        $data = [];

        foreach ($kelurahans as $kelurahan) {
            $data[] = [
                'kelurahan' => $kelurahan,
                'tarif_ongkir' => 12000, // tarif default
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('kelurahanns')->insert($data);
    }
}
