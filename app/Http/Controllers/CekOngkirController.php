<?php

namespace App\Http\Controllers;

use App\Models\Kelurahan;
use App\Models\Kota;
use App\Models\Ongkir;
use Illuminate\Http\Request;

class CekOngkirController extends Controller
{
    //
    public function index()
    {
        // Ambil data provinsi yang unik dari kelurahan
        $provinsi = Kelurahan::select('provinsi')->distinct()->orderBy('provinsi')->get();
        return view('cek-ongkir.index', compact('provinsi'));
    }

    public function create()
    {
        Ongkir::create([
            'asal' => "{$asal->kelurahan}, {$asal->kecamatan}, {$asal->kota}, {$asal->provinsi}",
            'tujuan' => "{$tujuan->kelurahan}, {$tujuan->kecamatan}, {$tujuan->kota}, {$tujuan->provinsi}",
            'berat' => $request->berat,
            'jarak' => $jarak,
            'ongkir' => $ongkir,
        ]);
    }

    public function riwayat()
    {
        $riwayat = Ongkir::latest()->paginate(10);
        return view('cek-ongkir.riwayat', compact('riwayat'));
    }


    public function calculate(Request $request)
    {
        $request->validate([
            'asal_kelurahan' => 'required|string',
            'tujuan_kelurahan' => 'required|string',
            'berat' => 'required|numeric|min:1',
        ]);

        // Cari data asal dan tujuan berdasarkan kelurahan
        $asal = Kelurahan::where('kelurahan', $request->asal_kelurahan)->first();
        $tujuan = Kelurahan::where('kelurahan', $request->tujuan_kelurahan)->first();

        if (!$asal || !$tujuan) {
            return back()->withErrors(['msg' => 'Data alamat asal atau tujuan tidak ditemukan']);
        }

        // Tarif per kg (sesuaikan dengan tarif ongkir yang berlaku)
        $tarif_per_kg = 5000;
        $ongkir = $request->berat * $tarif_per_kg;

        // Menghitung jarak (gunakan rumus haversine atau data lainnya)
        $jarak = $this->calculateDistance($asal->latitude, $asal->longitude, $tujuan->latitude, $tujuan->longitude);

        // Menyimpan data perhitungan dalam session untuk ditampilkan di view
        return back()->with([
            'asal' => "{$asal->kelurahan}, {$asal->kecamatan}, {$asal->kota}, {$asal->provinsi}",
            'tujuan' => "{$tujuan->kelurahan}, {$tujuan->kecamatan}, {$tujuan->kota}, {$tujuan->provinsi}",
            'berat' => $request->berat,
            'jarak' => $jarak, // Jarak dalam kilometer
            'ongkir' => $ongkir, // Ongkir perhitungan
        ]);
    }

    // Fungsi untuk menghitung jarak antara dua titik koordinat (latitude, longitude)
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earth_radius = 6371; // Radius bumi dalam km

        $lat_from = deg2rad($lat1);
        $lon_from = deg2rad($lon1);
        $lat_to = deg2rad($lat2);
        $lon_to = deg2rad($lon2);

        $lat_diff = $lat_to - $lat_from;
        $lon_diff = $lon_to - $lon_from;

        $a = sin($lat_diff / 2) * sin($lat_diff / 2) +
            cos($lat_from) * cos($lat_to) *
            sin($lon_diff / 2) * sin($lon_diff / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earth_radius * $c; // Jarak dalam kilometer

        return round($distance, 2); // Mengembalikan jarak dengan dua angka desimal
    }
}
