<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Penjualan;
use PDF;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Pengiriman::with(['statuses' => fn($q) => $q->latest('waktu_status')]);

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $pengiriman = $query->get();

        return view('laporan.pengiriman', compact('pengiriman', 'request'));
    }

    public function exportPdf(Request $request)
    {
        $query = Pengiriman::with(['statuses' => fn($q) => $q->latest('waktu_status')]);

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('pengiriman_id')) {
            $query->where('id', $request->pengiriman_id);
        }

        $pengiriman = $query->get();

        $pdf = PDF::loadView('laporan.pengiriman_pdf', compact('pengiriman'));

        return $pdf->download('laporan_pengiriman.pdf');
    }

    public function adminIndex()
    {
        $laporan = Penjualan::with('user', 'details.produk')->latest()->get();
        return view('laporan.admin', compact('laporan'));
    }

    public function userIndex()
    {
        $laporan = Penjualan::with('details.produk', 'pengiriman') // tambahkan 'pengiriman'
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('laporan.user', compact('laporan')); // pastikan variabel $laporan dikirim
    }
}
