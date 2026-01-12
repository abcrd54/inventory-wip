<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparepart;
use App\Models\SparepartKeluar;

class SparepartKeluarController extends Controller
{
    public function index()
    {
        return view('sparepart.keluar', [
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

            SparepartKeluar::create([
                'id_barang' => $row['id_barang'],
                'jumlah' => $row['jumlah'],
                'order_by' => $row['order_by'] ?? null,
                'keterangan' => $row['keterangan'] ?? null,
            ]);
        }

        return redirect()
            ->route('sparepart.keluar.index')
            ->with('success', 'Data keluar berhasil disimpan');
    }
}
