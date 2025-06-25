<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    //
    use HasFactory;

    protected $fillable = ['nama', 'kategori_id', 'deskripsi', 'stok', 'harga', 'gambar'];

    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_id');
    }

    public function penjualanDetails()
    {
        return $this->hasMany(PenjualanDetail::class);
    }

    public function details()
    {
        return $this->hasMany(PenjualanDetail::class);
    }
}
