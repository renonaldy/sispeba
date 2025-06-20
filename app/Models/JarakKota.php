<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JarakKota extends Model
{
    //
    protected $table = 'jarak_kota';
    protected $fillable = ['asal', 'tujuan', 'jarak_km'];
}
