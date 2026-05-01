<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BarangKeluarController extends Controller
{
    public function index()
    {
        return BarangKeluar::with('obat')
            ->latest()
            ->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'obat_id' => 'required|exists:obats,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'nullable|date',
        ]);

        $data = DB::transaction(function () use ($validated) {
            $obat = Obat::query()
                ->lockForUpdate()
                ->findOrFail($validated['obat_id']);

            $stokSaatIni = (int) $obat->stok;
            $jumlahKeluar = (int) $validated['jumlah'];

            if ($stokSaatIni <= 0) {
                throw ValidationException::withMessages([
                    'jumlah' => ['Stok obat sudah habis. Barang keluar tidak dapat diproses.'],
                ]);
            }

            if ($jumlahKeluar > $stokSaatIni) {
                throw ValidationException::withMessages([
                    'jumlah' => ["Jumlah barang keluar melebihi stok tersedia. Stok saat ini: {$stokSaatIni}."],
                ]);
            }

            $data = BarangKeluar::create([
                'obat_id' => $validated['obat_id'],
                'jumlah' => $jumlahKeluar,
                'tanggal' => $validated['tanggal'] ?? now(),
                'total' => $jumlahKeluar * $obat->harga,
            ]);

            $obat->stok = max(0, $stokSaatIni - $jumlahKeluar);
            $obat->save();

            return $data;
        });

        return response()->json([
            'message' => 'Berhasil',
            'data' => $data,
        ]);
    }
}
