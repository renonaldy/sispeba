<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekeningBank extends Model
{
    //
    protected $fillable = [
        'nama_bank',
        'nomor_rekening',
        'atas_nama',
        'jenis'
    ];
}
