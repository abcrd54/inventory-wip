<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $table = 'inquiry';

    protected $fillable = [
        'no_inquiry',
        'harga',
        'ongkir',
        'ppn',
        'quantity',
        'nama_customer',
        'no_hp',
        'alamat',
        'id_barang'
    ];

    public function items()
    {
        return $this->hasMany(InquiryItem::class);
    }

}
