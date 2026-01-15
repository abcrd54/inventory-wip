<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use Illuminate\Support\Str;
use App\Models\Unit;
use App\Models\InquiryItem;


class InquiryController extends Controller
{
    public function index()
    {
        return view('inquiry.index', [
            'inquiries' => Inquiry::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function create()
    {
        $tipes = Unit::select('tipe')
        ->distinct()
        ->orderBy('tipe')
        ->get();

    return view('inquiry.create', compact('tipes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_customer' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'items' => 'required|array|min:1',
            'items.*.tipe' => 'required',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric|min:0',
        ]);

        $inquiry = Inquiry::create([
            'no_inquiry' => 'INQ-' . date('Ymd') . '-' . strtoupper(Str::random(4)),
            'nama_customer' => $request->nama_customer,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'harga' => collect($request->items)->sum(function ($item) {
                return $item['harga'] * $item['quantity'];
            }),
            'quantity' => collect($request->items)->sum('quantity'),
            'ongkir' => $request->ongkir ?? 0,
            'ppn' => 0,
            'status' => 'menunggu_invoice'
        ]);

        foreach ($request->items as $item) {
            InquiryItem::create([
                'inquiry_id' => $inquiry->id,
                'id_barang'  => $item['tipe'], // atau id barang sebenarnya
                'quantity'   => $item['quantity'],
                'harga'      => $item['harga'],
            ]);
        }

        return redirect()->route('inquiry.index')
            ->with('success','Inquiry berhasil dibuat');
    }

    public function destroy($id)
    {
        Inquiry::findOrFail($id)->delete();
        return back()->with('success', 'Inquiry berhasil dihapus');
    }
}
