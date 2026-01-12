<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparepart;
use App\Models\SparepartMasuk;

class SparepartMasukController extends Controller
{
    public function index()
    {
        return view('sparepart.masuk', [
            'spareparts' => Sparepart::orderBy('nama')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items.*.id_barang' => 'nullable|exists:sparepart,id',
            'items.*.jumlah' => 'nullable|integer|min:1',
        ]);

        foreach ($request->items as $row) {

            if (empty($row['id_barang']) || empty($row['jumlah'])) {
                continue;
            }

            SparepartMasuk::create([
                'id_barang' => $row['id_barang'],
                'jumlah' => $row['jumlah'],
                'order_by' => $row['order_by'] ?? null,
                'keterangan' => $row['keterangan'] ?? null,
            ]);
        }

        return redirect()
            ->route('sparepart.masuk.index')
            ->with('success', 'Data masuk berhasil disimpan');
    }
}
