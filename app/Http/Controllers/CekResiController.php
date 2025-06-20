<?php

namespace App\Http\Controllers;

use App\Events\TrackingUpdated;
use App\Models\Pengiriman;
use App\Models\PengirimanStatus;
use App\Notifications\StatusUpdatedNotification;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;

class CekResiController extends Controller
{
    //
    public function index()
    {
        return view('cek-resi.index');
    }

    public function cari(Request $request)
    {
        $request->validate([
            'no_resi' => 'required|string|max:255'
        ]);

        $pengiriman = Pengiriman::where('no_resi', $request->no_resi)->first();

        if (!$pengiriman) {
            return back()->with('error', 'Nomor resi tidak ditemukan.');
        }

        return view('cek-resi.hasil', compact('pengiriman'));
    }

    public function tracking($no_resi)
    {
        $pengiriman = Pengiriman::where('no_resi', $no_resi)->with('statuses')->first();

        if (!$pengiriman) {
            return redirect()->route('cek-resi.index')->with('error', 'Nomor resi tidak ditemukan.');
        }

        // urutkan status berdasarkan waktu
        $statuses = $pengiriman->statuses->sortBy('waktu_status');

        return view('cek-resi.tracking', compact('pengiriman', 'statuses'));
    }


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'no_resi' => 'required|string',
            'status' => 'required|string',
            'lokasi_terakhir' => 'required|string',
        ]);

        $pengiriman = Pengiriman::findOrFail($id);
        $pengiriman->update([
            'status' => $request->status,
            'lokasi_terakhir' => $request->lokasi_terakhir,
        ]);

        // Tambah ke riwayat status
        PengirimanStatus::create([
            'pengiriman_id' => $pengiriman->id,
            'status' => $request->status,
            'waktu_status' => now(),
        ]);

        // Kirim notifikasi ke penerima
        Notification::route('mail', $pengiriman->email_penerima) // pastikan field ini ada
            ->notify(new StatusUpdatedNotification($pengiriman));

        broadcast(new TrackingUpdated($pengiriman)); // real-time update

        return back()->with('success', 'Status berhasil diperbarui.');
    }
}
