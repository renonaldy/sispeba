<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    //
    public function create()
    {
        $produks = Produk::all();
        return view('penjualan.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $tanggal = now();
        $total = 0;
        $data = [];

        foreach ($request->produk_id as $index => $produkId) {
            $produk = Produk::findOrFail($produkId);
            $jumlah = $request->jumlah[$index];

            if ($jumlah > 0 && $jumlah <= $produk->stok) {
                $subtotal = $jumlah * $produk->harga;
                $total += $subtotal;

                $data[] = [
                    'produk_id' => $produk->id,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $produk->harga,
                    'subtotal' => $subtotal,
                ];

                // Update stok
                $produk->decrement('stok', $jumlah);
            }
        }

        $penjualan = Penjualan::create([
            'user_id' => auth()->id(),
            'tanggal' => $tanggal,
            'total' => $total,
        ]);

        foreach ($data as $detail) {
            $penjualan->details()->create($detail);
        }

        return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil disimpan.');
    }

    public function riwayat()
    {
        $penjualans = Penjualan::where('user_id', auth()->id())->with('details.produk')->latest()->get();
        return view('pelanggan.riwayat', compact('penjualans'));
    }
}
