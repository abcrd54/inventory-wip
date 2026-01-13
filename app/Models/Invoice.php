<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';

    protected $fillable = [
        'no_invoice',
        'nama_customer',
        'no_hp',
        'alamat',
        'harga',
        'ongkir',
        'ppn',
        'quantity',
        'id_barang'
    ];
}
