<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ongkir extends Model
{
    //
    protected $fillable = [
        'asal',
        'tujuan',
        'berat',
        'jarak',
        'ongkir',
    ];
}
