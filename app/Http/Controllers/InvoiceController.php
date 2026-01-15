<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Inquiry;
use App\Models\Unit;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


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

    public function create($no_inquiry)
    {
        $inquiry = Inquiry::where('no_inquiry', $no_inquiry)
                    ->with('items')
                    ->firstOrFail();

        $tipeItems = $inquiry->items;

        // Ambil semua unit ready untuk tipe-tipe inquiry
        $units = Unit::whereIn('tipe', $tipeItems->pluck('id_barang')->unique())
                    ->where('status', 'ready')
                    ->orderBy('warna')
                    ->get();

        return view('invoice.create', compact('inquiry', 'tipeItems', 'units'));
    }

    private function toDecimal($value)
    {
        // hapus Rp, spasi, titik ribuan
        $clean = str_replace(['Rp', ' ', '.'], '', $value);

        // ganti koma desimal ke titik
        $clean = str_replace(',', '.', $clean);

        return number_format((float) $clean, 2, '.', '');
    }
    // SIMPAN
   public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $totalItem = 0;

            foreach ($request->items as $group) {
                foreach ($group as $itemRow) {
                    $totalItem += $this->toDecimal($itemRow['harga']);
                }
            }

            $ongkir = $this->toDecimal($request->ongkir ?? 0);
            $grandTotal = $totalItem + $ongkir;

            $invoice = Invoice::create([
                'no_invoice' => 'LIGA-' . date('Ymd') . '-' . rand(100,999),
                'inquiry_id' => $request->inquiry_id,
                'ongkir'     => $ongkir,
                'total'      => $grandTotal,
                'status'     => 'tunggu_pengiriman',
            ]);

            foreach ($request->items as $group) {
                foreach ($group as $itemRow) {

                    $unit = Unit::findOrFail($itemRow['unit_id']);

                    InvoiceItem::create([
                        'invoice_id'        => $invoice->id,
                        'unit_id'           => $unit->id,
                        'tipe'              => $unit->tipe,
                        'warna'             => $unit->warna,
                        'no_rangka'         => $unit->nomor_rangka,
                        'no_dinamo'         => $unit->nomor_dinamo,
                        'harga'             => $this->toDecimal($itemRow['harga']),
                        'status_pengiriman' => 'pending',
                    ]);

                    $unit->update(['status' => 'terjual']);
                }
            }

            // update status inquiry
            Inquiry::where('id', $request->inquiry_id)
                ->update(['status' => 'invoice_terbit']);
        });

        return redirect()->route('invoice.index')
            ->with('success', 'Invoice berhasil dibuat');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {

            $invoice = Invoice::with(['items', 'inquiry'])->findOrFail($id);

            if ($invoice->inquiry) {
                $invoice->inquiry->update([
                    'status' => 'menunggu_invoice', // sesuaikan enum kamu
                ]);
            }

            // 2. Kembalikan status unit (jika sebelumnya terjual)
            foreach ($invoice->items as $item) {
                if ($item->unit_id) {
                    Unit::where('id', $item->unit_id)->update([
                        'status' => 'ready'
                    ]);
                }
            }

            // 3. Hapus invoice items
            InvoiceItem::where('invoice_id', $invoice->id)->delete();

            // 4. Hapus invoice
            $invoice->delete();
        });

        return redirect()
            ->route('invoice.index')
            ->with('success', 'Invoice berhasil dihapus & status inquiry dikembalikan');
    }

    public function exportPdf($id)
    {
        $invoice = Invoice::with(['inquiry', 'items'])->findOrFail($id);

        $pdf = Pdf::loadView('pdf.invoice', [
            'invoice' => $invoice,
            'company' => [
                'name'    => 'NAMA PERUSAHAAN',
                'address' => 'ALAMAT PERUSAHAAN',
                'phone'   => 'NO TELP',
                'logo'    => public_path('logo.png'), // GANTI LOGO NANTI
            ]
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Invoice-' . $invoice->no_invoice . '.pdf');
    }

}

