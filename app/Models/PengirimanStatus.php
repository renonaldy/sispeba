<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengirimanStatus extends Model
{
    //
    protected $fillable = ['pengiriman_id', 'status', 'waktu_status'];

    public function pengiriman()
    {
        return $this->belongsTo(Pengiriman::class);
    }
}
