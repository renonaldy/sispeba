<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    //
    protected $fillable = ['provinsi', 'kota', 'kecamatan', 'kelurahan', 'kode_pos'];
}
