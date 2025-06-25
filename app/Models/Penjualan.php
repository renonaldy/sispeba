<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    //
    protected $fillable = [
        'user_id',
        'tanggal',
        'total',
        'nama_penerima',
        'alamat',
        'no_hp',
        'kota',
        'kecamatan',
        'kelurahan',
        'kode_pos',
        'metode_pembayaran',
        'bank',
        'bukti_pembayaran',
        'ongkir',
        'asuransi',
    ];

    public function details()
    {
        return $this->hasMany(PenjualanDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class);
    }

    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class, 'pembelian_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahann::class);
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
}
