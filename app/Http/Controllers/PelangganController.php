<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kelurahann;
use App\Models\Kota;
use App\Models\Pembayaran;
use App\Models\Pengiriman;
use App\Models\PengirimanSementara;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Produk::where('stok', '>', 0);

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        $produks = $query->paginate(10);
        $kategoriList = KategoriProduk::all();

        return view('pelanggan.belanja', compact('produks', 'kategoriList'));
    }

    public function beli(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1'
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        if ($produk->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak cukup.');
        }

        $subtotal = $produk->harga * $request->jumlah;

        // Simpan ke tabel penjualan
        $penjualan = Penjualan::create([
            'user_id' => auth()->id(),
            'tanggal' => now(),
            'total' => $subtotal,
        ]);

        $penjualan->details()->create([
            'penjualan_id' => $penjualan->id,
            'produk_id' => $produk->id,
            'jumlah' => $request->jumlah,
            'harga_satuan' => $produk->harga,
            'subtotal' => $subtotal,
        ]);

        // Kurangi stok
        $produk->decrement('stok', $request->jumlah);

        return redirect()->route('belanja.index')->with('success', 'Pembelian berhasil.');
    }

    public function keranjang()
    {
        $keranjang = session()->get('keranjang', []);
        $kelurahanList = Kelurahann::all();
        $kotaList = Kota::all();
        $kecamatanList = Kecamatan::all();
        return view('pelanggan.keranjang', compact('keranjang', 'kelurahanList', 'kotaList', 'kecamatanList'));
    }

    public function tambahKeranjang(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1'
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        $keranjang = session()->get('keranjang', []);

        $keranjang[$produk->id] = [
            'id' => $produk->id,
            'produk_id' => $produk->id,
            'nama' => $produk->nama,
            'harga' => $produk->harga,
            'jumlah' => ($keranjang[$produk->id]['jumlah'] ?? 0) + $request->jumlah,
        ];

        session()->put('keranjang', $keranjang);

        return back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function hapusKeranjang(Request $request)
    {
        $id = $request->produk_id;
        $keranjang = session()->get('keranjang', []);
        unset($keranjang[$id]);
        session()->put('keranjang', $keranjang);

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }



    public function prosesCheckout(Request $request)
    {
        $keranjang = session()->get('keranjang', []);
        if (empty($keranjang)) {
            return back()->with('error', 'Keranjang kosong.');
        }

        // Pecah metode_pembayaran (contoh: "transfer:BCA" -> ["transfer", "BCA"])
        $metodeParts = explode(':', $request->metode_pembayaran);
        $metode = $metodeParts[0];
        $bank = $metodeParts[1] ?? null;

        // Validasi input
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'metode_pembayaran' => 'required',
            'kota' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'kode_pos' => 'required|string',
            'bukti_pembayaran' => $metode === 'transfer' ? 'required|image|mimes:jpg,jpeg,png|max:2048' : 'nullable',
        ]);

        // Cek stok dan hitung total
        $total = 0;
        foreach ($keranjang as $item) {
            $produk = Produk::find($item['produk_id'] ?? $item['id']);
            if (!$produk || $produk->stok < $item['jumlah']) {
                return back()->with('error', 'Stok tidak mencukupi.');
            }
            $total += $produk->harga * $item['jumlah'];
        }

        // Hitung ongkir dan asuransi
        $kelurahan = Kelurahann::where('kelurahan', $request->kelurahan)->first();
        $ongkir = $kelurahan->tarif_ongkir ?? 0;
        $asuransi = 0.01 * $total;
        $total += $ongkir + $asuransi;

        // Simpan bukti jika ada
        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        // Simpan penjualan
        $penjualan = Penjualan::create([
            'user_id' => auth()->id(),
            'tanggal' => now(),
            'total' => $total,
            'nama_penerima' => $request->nama_penerima,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'kode_pos' => $request->kode_pos,
            'metode_pembayaran' => $metode,
            'bank' => $bank,
            'bukti_pembayaran' => $buktiPath,
            'ongkir' => $ongkir,
            'asuransi' => $asuransi,
        ]);

        // Simpan detail dan kurangi stok
        foreach ($keranjang as $item) {
            $produk = Produk::find($item['produk_id'] ?? $item['id']);
            $penjualan->details()->create([
                'produk_id' => $produk->id,
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $produk->harga,
                'subtotal' => $produk->harga * $item['jumlah'],
            ]);
            $produk->decrement('stok', $item['jumlah']);
        }

        $userId = auth()->id();
        $jumlahResiSebelumnya = Pengiriman::where('user_id', $userId)->count();
        $noResi = 'RESI-' . $userId . '-' . str_pad($jumlahResiSebelumnya + 1, 4, '0', STR_PAD_LEFT);

        // Simpan pengiriman
        Pengiriman::create([
            'user_id' => $userId,
            'penjualan_id' => $penjualan->id,
            'nama_penerima' => $request->nama_penerima,
            'alamat_tujuan' => $request->alamat,
            'no_resi' => $noResi,
            'status' => 'Menunggu konfirmasi',
        ]);

        // Bersihkan keranjang
        session()->forget('keranjang');

        return redirect()->route('belanja.index')->with('success', 'Pesanan berhasil diproses.');
    }

    public function riwayat()
    {
        $riwayat = Penjualan::with('details.produk')->latest()->get();
        return view('pelanggan.riwayat', compact('riwayat'));
    }

    public function simpanInformasiPengiriman(Request $request)
    {
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'metode_pembayaran' => 'required|in:transfer,cod',
            'bank' => 'required_if:metode_pembayaran,transfer',
            'bukti_pembayaran' => 'required_if:metode_pembayaran,transfer|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        PengirimanSementara::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'nama_penerima' => $request->nama_penerima,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'metode_pembayaran' => $request->metode_pembayaran,
                'bank' => $request->bank,
                'bukti_pembayaran' => $buktiPath,
            ]
        );

        return back()->with('success', 'Informasi pengiriman berhasil disimpan.');
    }
}
