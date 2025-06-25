<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\Pengiriman;
use App\Models\Penjualan;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanPembelianController extends Controller
{
    //
    public function index(Request $request)
    {
        $pembelian = Penjualan::with(['user', 'pembayaran', 'details.produk'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.laporan_pembelian.index', compact('pembelian'));
    }

    public function prosesPengiriman(Request $request, $id)
    {
        $request->validate([
            'kurir' => 'required|string|max:100',
            'no_resi' => 'required|string|max:100',
            'tanggal_kirim' => 'required|date',
        ]);

        $pembelian = Pembelian::findOrFail($id);

        // Simpan data pengiriman (jika belum ada, buat baru)
        // Pengiriman::updateOrCreate(
        //     ['pembelian_id' => $pembelian->id],
        //     [
        //         'kurir' => $request->kurir,
        //         'no_resi' => $request->no_resi,
        //         'tanggal_kirim' => $request->tanggal_kirim,
        //         'status' => 'dikirim',
        //     ]
        // );
        Pengiriman::updateOrCreate(
            ['pembelian_id' => $pembelian->id],
            [
                'nama_pengirim'  => $request->kurir, // ⬅️ Tambahkan ini
                'nama_penerima'  => $pembelian->user->name ?? '-',
                'alamat'         => $pembelian->alamat,
                'kota'           => $pembelian->kota ?? '-',
                'kode_pos'       => $pembelian->kode_pos ?? '-',
                'status'         => 'dikirim',
                'no_resi'        => $request->no_resi,
                'tanggal_kirim'  => $request->tanggal_kirim,
            ]
        );


        $pembelian->status = 'dikirim';
        $pembelian->save();

        return back()->with('success', 'Pengiriman berhasil diproses.');
    }

    // app/Http/Controllers/Admin/LaporanPembelianController.php

    public function formPengiriman($id)
    {
        $pembelian = Penjualan::with('user')->findOrFail($id);
        $kurirs = User::where('role', 'kurir')->get(); // Ambil semua kurir

        // Buat nomor resi otomatis berdasarkan tanggal hari ini
        $today = now()->format('Ymd'); // contoh: 20250621
        $last = Pengiriman::whereDate('created_at', today())->latest('id')->first();

        $lastNumber = 0;
        if ($last && preg_match('/-(\d{6})$/', $last->no_resi, $match)) {
            $lastNumber = (int)$match[1];
        }

        $newNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
        $resi = 'RESI-' . $today . '-' . $newNumber;
        $pembelian->status = 'diproses'; // Ubah status jadi "diproses"
        $pembelian->save();


        return view('admin.laporan_pembelian.konfirmasi', compact('pembelian', 'kurirs', 'resi'));
    }

    public function simpanPengiriman(Request $request, $id)
    {
        $request->validate([
            'kurir' => 'required|string|max:255',
            'no_resi' => 'required|string|max:255',
            'tanggal_kirim' => 'required|date',
        ]);


        $pembelian = Penjualan::findOrFail($id);
        $kurir = User::where('name', $request->kurir)->first();

        Pengiriman::create([
            'pembelian_id'   => $pembelian->id,
            'nama_pengirim'  => $request->kurir,
            'nama_penerima'  => $pembelian->user->name ?? '-',
            'alamat'         => $pembelian->alamat,
            'kota'           => $pembelian->kota ?? '-',
            'kode_pos'       => $pembelian->kode_pos ?? '-',
            'status'         => 'dikirim',
            'no_resi'        => $request->no_resi,
            'tanggal_kirim'  => $request->tanggal_kirim,
        ]);
        $pembelian->update([
            'status' => 'dikirim',
            // 'kurir' => $request->kurir,
            // 'no_resi' => $request->no_resi,
            // 'tanggal_kirim' => $request->tanggal_kirim,
        ]);

        return redirect()->route('pengiriman.index')->with('success', 'Pesanan berhasil dikirim.');
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);

        // Hapus relasi terlebih dahulu jika diperlukan
        $penjualan->details()->delete();

        // Hapus bukti pembayaran dari storage
        if ($penjualan->bukti_pembayaran && \Storage::disk('public')->exists($penjualan->bukti_pembayaran)) {
            \Storage::disk('public')->delete($penjualan->bukti_pembayaran);
        }

        // Hapus entri penjualan
        $penjualan->delete();

        return back()->with('success', 'Data pembelian berhasil dihapus.');
    }

    public function downloadBukti($id)
    {
        $penjualan = Penjualan::findOrFail($id);

        if (!$penjualan->bukti_pembayaran) {
            abort(404);
        }

        $path = storage_path('app/public/bukti_pembayaran/' . $penjualan->bukti_pembayaran);

        if (!file_exists($path)) {
            abort(403, 'File tidak ditemukan atau tidak diizinkan.');
        }

        return response()->file($path);
    }

    public function tampilkanBukti($filename)
    {
        $path = storage_path('app/public/bukti_pembayaran/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}
