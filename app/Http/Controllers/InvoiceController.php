<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Inquiry;
use App\Models\Unit;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    // LIST INVOICE
    public function index()
    {
        $invoices = Invoice::with('inquiry')
            ->latest()
            ->get();

        return view('invoice.index', compact('invoices'));
    }

    public function selectInquiry()
    {
        $inquiries = Inquiry::orderBy('created_at', 'desc')
            ->get()
            ->map(function ($i) {
                $i->total = ($i->harga)
                        + ($i->ongkir ?? 0)
                        + ($i->ppn ?? 0);
                return $i;
            });

        return view('invoice.select-inquiry', compact('inquiries'));
    }

    public function create(Inquiry $inquiry)
    {
        $units = Unit::where('tipe', $inquiry->items->first()->tipe)
            ->where('status', 'ready')
            ->get();

        return view('invoice.create', compact('inquiry', 'units'));
    }

    // SIMPAN
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $invoice = Invoice::create([
                'no_invoice' => 'LIGA-' . date('Ymd') . '-' . rand(100,999),
                'inquiry_id' => $request->inquiry_id,
                'status' => 'tunggu_pengiriman',
                'total' => collect($request->items)->sum('harga')
            ]);

            $usedUnit = [];

            foreach ($request->items as $item) {

                if (in_array($item['unit_id'], $usedUnit)) {
                    throw new \Exception('Unit dobel');
                }

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'unit_id' => $item['unit_id'],
                    'harga' => $item['harga']
                ]);

                Unit::where('id', $item['unit_id'])
                    ->update(['status' => 'terjual']);

                $usedUnit[] = $item['unit_id'];
            }
        });

        return redirect()
            ->route('invoice.index')
            ->with('success', 'Invoice berhasil dibuat');
    }
}

