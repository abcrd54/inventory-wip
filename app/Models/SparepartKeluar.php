<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparepartKeluar extends Model
{
    use HasFactory;

    protected $table = 'sparepart_keluar';

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
