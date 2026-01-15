<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice'; // WAJIB kalau tabel singular

    protected $fillable = [
        'no_invoice',
        'inquiry_id',
        'total',
        'ongkir',
        'status',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'ongkir' => 'decimal:2',
    ];

    // ✅ RELASI YANG HILANG
    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class, 'inquiry_id');
    }

    // (opsional) relasi ke item
    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    protected static function booted()
    {
        static::deleting(function ($invoice) {
            $invoice->items()->delete();
        });
    }

}
