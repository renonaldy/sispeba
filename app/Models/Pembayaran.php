<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    //
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }

        public function rekening()
    {
        return $this->belongsTo(RekeningBank::class);
    }

}
