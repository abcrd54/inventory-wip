<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use Illuminate\Database\QueryException;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $query = Unit::query();

        if ($request->tipe) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->warna) {
            $query->where('warna', $request->warna);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $units = $query->orderBy('created_at', 'desc')->get();

        return view('unit.index', [
            'units' => $units,
            'tipeList' => Unit::select('tipe')->distinct()->pluck('tipe'),
            'warnaList' => Unit::select('warna')->distinct()->pluck('warna'),
            'statusList' => Unit::select('status')->distinct()->pluck('status'),
        ]);
    }

    public function create()
    {
        return view('unit.create');
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'tipe' => 'required',
                'warna' => 'required',
                'kategori' => 'required',
                'nomor_rangka' => 'required|unique:unit,nomor_rangka',
                'nomor_dinamo' => 'required|unique:unit,nomor_dinamo',
            ]);

            Unit::create([
                'tipe' => $request->tipe,
                'warna' => $request->warna,
                'kategori' => $request->kategori,
                'nomor_rangka' => $request->nomor_rangka,
                'nomor_dinamo' => $request->nomor_dinamo,
                'status' => 'READY',
            ]);

            return redirect()
                ->route('unit.index')
                ->with('success', 'Unit berhasil ditambahkan');

        } catch (QueryException $e) {

            // Gagal karena database (duplicate, constraint, dll)
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data. Nomor rangka atau dinamo sudah terdaftar.');

        } catch (\Exception $e) {

            // Gagal umum
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    public function updateStatus(Request $request, Unit $unit)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $unit->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status unit berhasil diubah');
    }
}
