<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function detail()
    {
        return $this->hasMany(PembelianDetails::class);
    }

    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class);
    }
}
