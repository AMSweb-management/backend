<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Obat;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    public function index()
    {
        return BarangKeluar::with('obat')
            ->latest()
            ->paginate(5);
    }

    public function store(Request $request)
    {
        $request->validate([
            'obat_id' => 'required',
            'jumlah' => 'required|integer',
        ]);

        $obat = Obat::findOrFail($request->obat_id);

        $total = $request->jumlah * $obat->harga;

        $data = BarangKeluar::create([
            'obat_id' => $request->obat_id,
            'jumlah' => $request->jumlah,
            'tanggal' => now(),
            'total' => $total,
        ]);

        // 🔥 kurangi stok
        $obat->decrement('stok', $request->jumlah);

        return response()->json([
            'message' => 'Berhasil',
            'data' => $data,
        ]);
    }
}
