<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    //
    use HasFactory;
    protected $table = 'pengiriman';

    protected $fillable = [
        'nama_pengirim',
        'nama_penerima',
        'alamat',
        'kota',
        'kode_pos',
        // 'alamat_tujuan',
        'status',
    ];

    protected $attributes = [
        'status' => 'Menunggu',
    ];

    public function statuses()
    {
        return $this->hasMany(PengirimanStatus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kurir()
    {
        return $this->belongsTo(User::class, 'kurir_id');
    }
}
