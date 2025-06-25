<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    //
    public function index()
    {
        $kurir = Auth::user()->name;

        $pengiriman = Pengiriman::where('nama_pengirim', $kurir)
            ->whereIn('status', ['proses', 'dikirim'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kurir.tugas.index', compact('pengiriman'));
    }
}
