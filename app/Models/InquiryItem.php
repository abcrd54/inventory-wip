<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InquiryItem extends Model
{
    protected $table = 'inquiry_items';

    protected $fillable = [
        'inquiry_id',
        'id_barang',
        'quantity',
        'harga'
    ];

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }
}
