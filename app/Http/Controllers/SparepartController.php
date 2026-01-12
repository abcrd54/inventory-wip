<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    public function index()
    {
        $spareparts = Sparepart::latest()->get();
        return view('sparepart.index', compact('spareparts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tipe' => 'nullable',
            'warna' => 'nullable'
        ]);

        Sparepart::create($request->all());

        return redirect()->route('sparepart.index')
            ->with('success', 'Sparepart berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        Sparepart::findOrFail($id)->update(
            $request->only('nama', 'tipe', 'warna')
        );

        return back()->with('success', 'Sparepart berhasil diupdate');
    }

    public function destroy($id)
    {
        Sparepart::findOrFail($id)->delete();

        return back()->with('success', 'Sparepart berhasil dihapus');
    }

}
