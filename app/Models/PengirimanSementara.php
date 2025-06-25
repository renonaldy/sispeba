<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengirimanSementara extends Model
{
    //
    protected $table = 'pengiriman_sementara';

    protected $fillable = [
        'user_id',
        'nama_penerima',
        'alamat',
        'no_hp',
        'metode_pembayaran',
    ];
}
