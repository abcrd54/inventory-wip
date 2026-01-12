<?php

// app/Models/SparepartMasuk.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparepartMasuk extends Model
{
    protected $table = 'sparepart_masuk';

    protected $fillable = [
        'id_barang',
        'jumlah',
        'order_by',
        'keterangan'
    ];

     public function sparepart()
    {
        return $this->belongsTo(Sparepart::class, 'id_barang');
    }
}
