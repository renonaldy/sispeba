<?php

namespace App\Http\Controllers;

use App\Models\JarakKota;
use App\Models\Kelurahan;
use App\Models\Kota;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    //
    //     public function showLanding()
    // {
    //     $kotas = Kota::all();
    //     return view('welcome', compact('kotas'));
    // }

    public function landingPage()
    {
        $kotas = Kelurahan::all(); // Ambil semua data kota
        return view('welcome', compact('kotas'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'kota_asal' => 'required|exists:kotas,id',
            'kota_tujuan' => 'required|exists:kotas,id',
            'berat' => 'required|numeric|min:1'
        ]);

        $jarak = JarakKota::where('kota_asal_id', $request->kota_asal)
            ->where('kota_tujuan_id', $request->kota_tujuan)
            ->first();

        if (!$jarak) {
            return back()->with('hasil_ongkir', [
                'asal' => 'Tidak ditemukan',
                'tujuan' => 'Tidak ditemukan',
                'jarak' => 0,
                'berat' => $request->berat,
                'ongkir' => 0
            ]);
        }

        $ongkir_per_km_per_kg = 500; // misal: Rp500 per km per kg
        $berat_dalam_kg = ceil($request->berat / 1000);
        $ongkir = $jarak->jarak * $berat_dalam_kg * $ongkir_per_km_per_kg;

        $asal = Kota::find($request->kota_asal);
        $tujuan = Kota::find($request->kota_tujuan);

        return back()->with('hasil_ongkir', [
            'asal' => "{$asal->kota}, {$asal->kecamatan}, {$asal->kelurahan}",
            'tujuan' => "{$tujuan->kota}, {$tujuan->kecamatan}, {$tujuan->kelurahan}",
            'jarak' => $jarak->jarak,
            'berat' => $request->berat,
            'ongkir' => $ongkir
        ]);
    }
}
