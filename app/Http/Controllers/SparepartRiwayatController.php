<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SparepartMasuk;
use App\Models\SparepartKeluar;

class SparepartRiwayatController extends Controller
{
    public function index(Request $request)
    {
        $jenis  = $request->jenis; // masuk | keluar | all
        $tanggal = $request->tanggal;

        $masuk = SparepartMasuk::with('sparepart')
            ->selectRaw("'masuk' as tipe, id_barang, jumlah, order_by, keterangan, created_at");

        $keluar = SparepartKeluar::with('sparepart')
            ->selectRaw("'keluar' as tipe, id_barang, jumlah, order_by, keterangan, created_at");

        if ($tanggal) {
            $masuk->whereDate('created_at', $tanggal);
            $keluar->whereDate('created_at', $tanggal);
        }

        if ($jenis === 'masuk') {
            $data = $masuk->get();
        } elseif ($jenis === 'keluar') {
            $data = $keluar->get();
        } else {
            $data = $masuk->unionAll($keluar)
                          ->orderBy('created_at', 'desc')
                          ->get();
        }

        return view('sparepart.riwayat', compact('data'));
    }
}
