<?php

use App\Http\Controllers\Admin\LaporanPembelianController;
use App\Http\Controllers\Admin\RekeningBankController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\CekOngkirController;
use App\Http\Controllers\CekResiController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\OngkirController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TugasController;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\PengirimanController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LandingController::class, 'landingPage']);
Route::post('/cek-ongkir', [LandingController::class, 'calculate'])->name('ongkir.calculate');



// Route::get('/', function () {
//     return auth()->check() ? redirect()->route('dashboard') : view('landing');
// });


/// Route dashboard utama akan redirect sesuai role
Route::middleware(['auth', 'verified'])->group(function () {

    // Redirect ke dashboard sesuai role
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'kurir' => redirect()->route('kurir.dashboard'),
            default => redirect()->route('user.dashboard'),
        };
    })->name('dashboard');

    // Dashboard Admin
    Route::get('/admin', fn() => view('admin.dashboard'))
        ->middleware('role:admin')->name('admin.dashboard');


    // Dashboard Kurir
    Route::get('/kurir', function () {
        return view('kurir.dashboard');
    })->middleware('role:kurir')->name('kurir.dashboard');

    // Dashboard User Biasa
    Route::get('/user', function () {
        return view('user.dashboard');
    })->middleware('role:user')->name('user.dashboard');
});


// Manajemen user oleh admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::resource('users', UserController::class);
});

// Profile (opsional)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/email/verification-notification', function () {
        request()->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');
});

// routes/web.php
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/pengiriman', [PengirimanController::class, 'index'])->name('pengiriman.index');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/pengiriman/create', [PengirimanController::class, 'create'])->name('pengiriman.create');
    Route::post('/pengiriman', [PengirimanController::class, 'store'])->name('pengiriman.store');
});

Route::middleware(['auth', 'role:kurir'])->group(function () {
    Route::get('/pengiriman/kurir', [PengirimanController::class, 'kurirTugas'])->name('pengiriman.kurir');
});


// Admin - Manajemen Pengiriman
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/pengiriman', [PengirimanController::class, 'index'])->name('pengiriman.index');
});

// User - Kirim Paket
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/pengiriman/create', [PengirimanController::class, 'create'])->name('pengiriman.create');
    Route::post('/pengiriman/hitung-ongkir', [PengirimanController::class, 'hitungOngkir'])->name('pengiriman.hitungOngkir');

    Route::post('/pengiriman', [PengirimanController::class, 'store'])->name('pengiriman.store');
    // Route::get('/cek-resi', [PengirimanController::class, 'cekResiForm'])->name('resi.cek');
    // Route::post('/cek-resi', [PengirimanController::class, 'cekResi']);
});

Route::get('/cek-resi', [CekResiController::class, 'index'])->name('cek-resi.index');
Route::post('/cek-resi', [CekResiController::class, 'cari'])->name('cek-resi.cari');
Route::get('/tracking/{no_resi}', [CekResiController::class, 'tracking'])->name('cek-resi.tracking');

// Data Laporan
Route::get('/laporan/pengiriman', [LaporanController::class, 'index'])->name('laporan.pengiriman');
Route::get('/laporan/pengiriman/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pengiriman.pdf');
// Admin melihat semua laporan
Route::middleware(['auth', 'role:admin'])->get('/laporan-admin', [LaporanController::class, 'adminIndex'])->name('laporan.admin');

// User hanya melihat laporannya sendiri
Route::middleware(['auth', 'role:user'])->get('/laporan-user', [LaporanController::class, 'userIndex'])->name('laporan.user');

Route::delete('/admin/laporan-pembelian/{id}', [\App\Http\Controllers\Admin\LaporanPembelianController::class, 'destroy'])->name('admin.laporan_pembelian.destroy');
Route::get('/admin/laporan-pembelian/bukti/{id}', [LaporanPembelianController::class, 'downloadBukti'])->name('admin.laporan_pembelian.download-bukti');
Route::get('/bukti-pembayaran/{filename}', [LaporanPembelianController::class, 'tampilkanBukti'])
    ->name('admin.laporan_pembelian.tampilkan-bukti');


// Kurir - Tugas Pengiriman
Route::middleware(['auth', 'role:kurir'])->group(function () {
    Route::get('/tugas-pengiriman', [PengirimanController::class, 'kurirTugas'])->name('pengiriman.kurir');
    Route::get('/tugas-pengiriman/pdf', [PengirimanController::class, 'cetakTugasKurir'])->name('pengiriman.kurir.pdf');
});


Route::middleware(['auth'])->group(function () {
    Route::resource('pengiriman', PengirimanController::class);
});

Route::post('/pengiriman/{id}/tandai-dikirim', [PengirimanController::class, 'tandaiDikirim'])->name('pengiriman.tandai-dikirim');
Route::post('/pengiriman/{id}/tandai-selesai', [PengirimanController::class, 'tandaiSelesai'])->name('pengiriman.tandai-selesai');
Route::post('/cek-ongkir', [PengirimanController::class, 'hitungOngkir'])->name('cek.ongkir');
// routes/web.php



Route::middleware(['auth'])->group(function () {
    Route::resource('pengiriman', PengirimanController::class);

    Route::patch('/pengiriman/{id}/status', [PengirimanController::class, 'updateStatus'])
        ->name('pengiriman.updateStatus');
});

Route::get('/get-provinsi', function () {
    return Kelurahan::select('provinsi')->distinct()->orderBy('provinsi')->get();
});

// web.php
Route::get('/get-kota', function (Request $request) {
    $provinsi = $request->get('provinsi');

    return Kelurahan::where('provinsi', $provinsi)
        ->select('kota')->distinct()->orderBy('kota')->get();
});


Route::get('/get-kecamatan', function (Request $request) {
    return Kelurahan::where('kota', $request->kota)
        ->select('kecamatan')->distinct()->orderBy('kecamatan')->get();
});

Route::get('/get-kelurahan', function (Request $request) {
    return Kelurahan::where('kecamatan', $request->kecamatan)
        ->select('kelurahan')->distinct()->orderBy('kelurahan')->get();
});

Route::get('/get-kodepos', function (Request $request) {
    return Kelurahan::where('kelurahan', $request->kelurahan)->value('kode_pos');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/cek-ongkir', [CekOngkirController::class, 'index'])->name('cek-ongkir.index');
    Route::post('/cek-ongkir', [CekOngkirController::class, 'cek'])->name('cek-ongkir.cek');
});

Route::post('/cek-ongkir', [CekOngkirController::class, 'calculate'])->name('ongkir.calculate');
Route::get('/riwayat-ongkir', [CekOngkirController::class, 'riwayat'])->name('ongkir.riwayat');

Route::resource('produk', ProdukController::class);
// Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');

Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
Route::get('/penjualan/create', [PenjualanController::class, 'create'])->name('penjualan.create');
Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');

Route::get('/belanja', [PelangganController::class, 'index'])->name('belanja.index');
Route::post('/belanja/beli', [PelangganController::class, 'beli'])->name('belanja.beli');

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/belanja', [PelangganController::class, 'index'])->name('belanja.index');
    Route::post('/belanja/beli', [PelangganController::class, 'beli'])->name('belanja.beli');
});

Route::get('/riwayat-belanja', [PelangganController::class, 'riwayat'])->name('belanja.riwayat');

// Route::middleware(['auth', 'role:user'])->group(function () {
//     Route::get('/keranjang', [PelangganController::class, 'keranjang'])->name('keranjang.index');
//     Route::post('/keranjang/tambah', [PelangganController::class, 'tambahKeranjang'])->name('keranjang.tambah');
//     Route::post('/keranjang/hapus', [PelangganController::class, 'hapusKeranjang'])->name('keranjang.hapus');
//     Route::post('/keranjang/checkout', [PelangganController::class, 'checkout'])->name('keranjang.checkout');
// });

// Route::get('/riwayat-pembelian', [PelangganController::class, 'riwayat'])->name('riwayat.pembelian');
// Route::get('/riwayat', [PelangganController::class, 'riwayat'])->middleware(['auth', 'role:user'])->name('pelanggan.riwayat');
// Route::post('/keranjang/simpan-informasi', [PelangganController::class, 'simpanInformasiPengiriman'])->name('keranjang.simpanInformasi');
// Route::get('/keranjang/pembayaran', [PelangganController::class, 'pembayaran'])->name('keranjang.pembayaran');
// // Route::post('/keranjang/pembayaran', [PelangganController::class, 'prosesCheckout'])->name('keranjang.pembayaran.proses');
// Route::get('/keranjang/cod-proses', [PelangganController::class, 'prosesCod'])->name('keranjang.cod.proses');
// Route::post('/keranjang/checkout', [PelangganController::class, 'checkout'])->name('keranjang.checkout');
// Route::post('/keranjang/pembayaran/proses', [PelangganController::class, 'prosesCheckout'])->name('keranjang.pembayaran.proses');

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/keranjang', [PelangganController::class, 'keranjang'])->name('keranjang.index');
    Route::post('/keranjang/tambah', [PelangganController::class, 'tambahKeranjang'])->name('keranjang.tambah');
    Route::post('/keranjang/hapus', [PelangganController::class, 'hapusKeranjang'])->name('keranjang.hapus');
    Route::post('/keranjang/checkout', [PelangganController::class, 'checkout'])->name('keranjang.checkout');
    Route::get('/keranjang/pembayaran', [PelangganController::class, 'pembayaran'])->name('keranjang.pembayaran');
    Route::post('/keranjang/pembayaran/proses', [PelangganController::class, 'prosesCheckout'])->name('keranjang.pembayaran.proses');
    Route::get('/keranjang/cod-proses', [PelangganController::class, 'prosesCod'])->name('keranjang.cod.proses');
    Route::get('/riwayat', [PelangganController::class, 'riwayat'])->middleware(['auth', 'role:user'])->name('pelanggan.riwayat');
    Route::get('/keranjang/pembayaran/proses', function () {
        return redirect()->route('keranjang.index')->with('error', 'Akses tidak sah.');
    });
});

Route::middleware(['auth', 'role:kurir'])->group(function () {
    Route::get('/kurir/tugas', [TugasController::class, 'index'])->name('kurir.tugas.index');
});


Route::get('/get-ongkir/{kelurahan}', function ($kelurahan) {
    $data = \App\Models\Kelurahann::where('kelurahan', $kelurahan)->first();
    $ongkir = $data->tarif_ongkir ?? 0;
    return response()->json(['ongkir' => $ongkir]);
});




Route::post('/keranjang/simpan-pengiriman', [PelangganController::class, 'simpanInformasiPengiriman'])
    ->name('keranjang.simpanPengiriman');


// routes/web.php
// routes/web.php
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('rekening', RekeningBankController::class);
});

// routes/web.php

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('laporan-pembelian', [LaporanPembelianController::class, 'index'])->name('laporan.pembelian');
});
Route::post('admin/laporan-pembelian/{id}/kirim', [LaporanPembelianController::class, 'prosesPengiriman'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.laporan-pembelian.kirim');

// routes/web.php
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('laporan_pembelian', [LaporanPembelianController::class, 'index'])->name('laporan_pembelian.index');
    // Route::get('laporan-pembelian', [LaporanPembelianController::class, 'index'])->name('laporan.pembelian');
    Route::get('laporan-pembelian/{id}/proses-pengiriman', [LaporanPembelianController::class, 'formPengiriman'])->name('laporan_pembelian.form-pengiriman');
    Route::post('laporan-pembelian/{id}/proses-pengiriman', [LaporanPembelianController::class, 'simpanPengiriman'])->name('laporan_pembelian.simpan-pengiriman');
});

Route::post('admin/laporan-pembelian/{id}/proses-pengiriman', [LaporanPembelianController::class, 'simpanPengiriman'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.laporan_pembelian.simpan-pengiriman');


// Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('laporan_pembelian'e, [LaporanPembelianController::class, 'index'])->name('laporan_pembelian.index');
//     Route::get('laporan-pembelian/{id}/proses-pengiriman', [LaporanPembelianController::class, 'formPengiriman'])->name('laporan_pembelian.form-pengiriman');
//     Route::post('laporan-pembelian/{id}/proses-pengiriman', [LaporanPembelianController::class, 'simpanPengiriman'])->name('laporan_pembelian.simpan-pengiriman');
// });



Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

require __DIR__ . '/auth.php';
