<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'unit_id',
        'tipe',
        'warna',
        'no_rangka',
        'no_dinamo',
        'harga',
        'status_pengiriman',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function unit()
    {
        return $this->belongsTo(ModelUnit::class, 'unit_id');
    }
}
