<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    //
    public function create()
    {
        $kotas = Kota::orderBy('nama')->get();
        return view('pengiriman.create', compact('kotas'));
    }
}
