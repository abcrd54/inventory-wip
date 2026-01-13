<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;

class UnitBulkController extends Controller
{
    public function index()
    {
        return view('unit.bulk-status', [
            'units' => Unit::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'unit_ids' => 'required|array',
            'status' => 'required'
        ]);

        Unit::whereIn('id', $request->unit_ids)
            ->update(['status' => $request->status]);

        return back()->with('success', 'Status unit berhasil diperbarui');
    }
}
