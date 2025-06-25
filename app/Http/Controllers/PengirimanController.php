<?php

namespace App\Http\Controllers;

use App\Models\JarakKota;
use App\Models\Kelurahan;
use App\Models\Pengiriman;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// use Str;
use Illuminate\Support\Str;

class PengirimanController extends Controller
{
    //

    public function index()
    {

        // $pengirimans = Pengiriman::latest()->paginate(10);
        // return view('pengiriman.index', compact('pengirimans'));

        // $pengirimans = Pengiriman::with(['user', 'statuses'])->latest()->get();
        $user = Auth::user();

        // Jika admin, ambil semua pengiriman
        if ($user->role === 'admin') {
            $pengirimans = Pengiriman::with('user')->latest()->paginate(10);
        }
        // Jika user biasa, ambil hanya pengiriman miliknya
        else {
            $pengirimans = Pengiriman::where('user_id', $user->id)->latest()->paginate(10);
        }

        return view('pengiriman.index', compact('pengirimans'));
    }

    public function create()
    {
        $kelurahans = Kelurahan::select('id', 'kelurahan', 'kota', 'kecamatan', 'kode_pos')
            ->orderBy('kota', 'asc')
            ->orderBy('kecamatan', 'asc')
            ->get();

        $kurirs = User::where('role', 'kurir')->get();

        return view('pengiriman.create', compact('kelurahans', 'kurirs'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nama_penerima' => 'required',
    //         'nama_pengirim' => 'required',
    //         'alamat' => 'required',
    //         'alamat_lengkap' => 'required',
    //         'alamat_tujuan' => 'required',
    //         'kurir_id' => 'nullable|exists:users,id',
    //     ]);

    //     $validated['user_id'] = auth()->id();

    //     // Pengiriman::create($validated);

    //     $today = now()->format('Ymd');

    //     // Ambil nomor terakhir hari ini
    //     $last = Pengiriman::whereDate('created_at', today())->latest()->first();
    //     $lastNumber = $last ? (int)substr($last->no_resi, -6) : 0;
    //     $newNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
    //     $no_resi = 'RESI-' . $today . '-' . $newNumber;

    //     // Menyimpan data pengiriman
    //     $pengiriman = new Pengiriman();
    //     $pengiriman->user_id = Auth::id();
    //     $pengiriman->no_resi = $no_resi;
    //     $pengiriman->nama_pengirim = $request->nama_pengirim;
    //     $pengiriman->nama_penerima = $request->nama_penerima;
    //     $pengiriman->alamat = $request->alamat;
    //     $pengiriman->alamat_lengkap = $request->alamat_lengkap;

    //     $pengiriman->alamat_tujuan = $request->alamat_tujuan;
    //     // $pengiriman->kota = $request->kota;
    //     // $pengiriman->kode_pos = $request->kode_pos;
    //     // $pengiriman->berat = $request->berat;
    //     // $pengiriman->ongkir = $totalOngkir; // Menyimpan ongkir yang sudah dihitung
    //     $pengiriman->status = 'Diproses'; // Status awal

    //     $pengiriman->save();

    //     return redirect()->route('pengiriman.index')->with('success', 'Data berhasil ditambahkan.');
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengirim' => 'required|string|max:255',
            'nama_penerima' => 'required|string|max:255',
            'alamat' => 'required|integer',
            'alamat_tujuan' => 'required|integer',
            'alamat_lengkap' => 'required|string',
            'kurir_id' => 'nullable|exists:users,id',
        ]);

        $today = now()->format('Ymd');

        // Ambil nomor resi terakhir untuk hari ini
        $last = Pengiriman::whereDate('created_at', today())->latest()->first();
        $lastNumber = $last ? (int)substr($last->no_resi, -6) : 0;
        $newNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
        $no_resi = 'RESI-' . $today . '-' . $newNumber;

        // Buat pengiriman
        $pengiriman = new Pengiriman();
        $pengiriman->user_id = auth()->id();
        $pengiriman->no_resi = $no_resi;
        $pengiriman->nama_pengirim = $validated['nama_pengirim'];
        $pengiriman->nama_penerima = $validated['nama_penerima'];
        $pengiriman->alamat = $validated['alamat'];
        $pengiriman->alamat_lengkap = $validated['alamat_lengkap'];
        $pengiriman->alamat_tujuan = $validated['alamat_tujuan'];
        $pengiriman->kurir_id = $request->kurir_id ?? null;
        $pengiriman->status = 'Menunggu'; // atau 'Diproses' tergantung logika
        $pengiriman->save();

        return redirect()->route('pengiriman.index')->with('success', 'Data pengiriman berhasil ditambahkan.');
    }


    public function hitungOngkir(Request $request)
    {
        $request->validate([
            'asal' => 'required|exists:kelurahans,id',
            'tujuan' => 'required|exists:kelurahans,id',
            'berat' => 'required|numeric|min:0.1',
        ]);

        $asalId = $request->asal;
        $tujuanId = $request->tujuan;
        $berat = $request->berat;

        // Misal logika hitung ongkir:
        // Dapatkan jarak antar kelurahan dari tabel jarak_kotas
        $jarak = DB::table('jarak_kotas')
            ->where('kelurahan_asal_id', $asalId)
            ->where('kelurahan_tujuan_id', $tujuanId)
            ->value('jarak');

        if (!$jarak) {
            return response()->json(['error' => 'Data jarak tidak ditemukan'], 404);
        }

        // Hitung ongkir = jarak * berat * tarif per kg (misal 2000)
        $tarifPerKgPerKm = 2000;
        $ongkir = $jarak * $berat * $tarifPerKgPerKm;

        return response()->json(['ongkir' => $ongkir]);
    }


    // public function hitungOngkir(Request $request)
    // {
    //     $request->validate([
    //         'alamat' => 'required|string',
    //         'alamat_tujuan' => 'required|string',
    //         'berat' => 'required|numeric|min:0.1',
    //     ]);

    //     $jarak = JarakKota::where('alamat', $request->alamat)
    //         ->where('alamat_tujuan', $request->alamat_tujuan)
    //         ->first();

    //     if (!$jarak) {
    //         return response()->json(['error' => 'Data jarak tidak ditemukan'], 404);
    //     }

    //     $tarifPerKm = 1000;
    //     $tarifPerKg = 500;
    //     $total = ($jarak->jarak_km * $tarifPerKm) + ($request->berat * $tarifPerKg);

    //     return response()->json([
    //         'ongkir' => $total,
    //         'jarak_km' => $jarak->jarak_km
    //     ]);
    // }

    public function edit(Pengiriman $pengiriman)
    {
        return view('pengiriman.edit', compact('pengiriman'));
    }

    public function update(Request $request, Pengiriman $pengiriman)
    {
        $request->validate([
            'nama_penerima' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'kode_pos' => 'required|numeric',
            // 'status' => 'required|string',
        ]);

        $pengiriman->update($request->all());
        return redirect()->route('pengiriman.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Pengiriman $pengiriman)
    {
        $pengiriman->delete();
        return redirect()->route('pengiriman.index')->with('success', 'Data berhasil dihapus.');
    }

    public function tandaiDikirim($id)
    {
        $pengiriman = Pengiriman::findOrFail($id);
        if ($pengiriman->status === 'Menunggu') {
            $pengiriman->status = 'Dalam Perjalanan';
            $pengiriman->save();
        }

        return redirect()->route('pengiriman.index')->with('success', 'Status diperbarui menjadi Dalam Perjalanan');
    }

    public function tandaiSelesai($id)
    {
        $pengiriman = Pengiriman::findOrFail($id);
        if ($pengiriman->status === 'Dalam Perjalanan') {
            $pengiriman->status = 'Selesai';
            $pengiriman->save();
        }

        return redirect()->route('pengiriman.index')->with('success', 'Status diperbarui menjadi Selesai');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:proses,dikirim,selesai',
        ]);

        $pengiriman = Pengiriman::findOrFail($id);

        if (!in_array(auth()->user()->role, ['admin', 'kurir'])) {
            abort(403, 'Unauthorized action.');
        }

        $pengiriman->status = $request->status;
        $pengiriman->save();

        return redirect()->back()->with('success', 'Status pengiriman berhasil diupdate.');
    }

    public function kurirTugas()
    {
        $pengiriman = Pengiriman::where('kurir_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();
        return view('pengiriman.kurir', compact('pengiriman'));
    }

    public function cetakTugasKurir()
    {
        $pengiriman = Pengiriman::where('kurir_id', auth()->id())->get();
        $pdf = Pdf::loadView('pengiriman.kurir-pdf', compact('pengiriman'));
        return $pdf->download('tugas-kurir.pdf');
    }
}
