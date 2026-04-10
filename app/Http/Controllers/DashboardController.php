<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Obat;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'totalObat' => Obat::count(),

            'keluarHariIni' => BarangKeluar::whereDate('created_at', Carbon::today())->sum('jumlah'),

            'pendapatanHariIni' => BarangKeluar::whereDate('created_at', Carbon::today())->sum('total'),

            'stokMenipis' => Obat::where('stok', '<', 10)
                ->take(5)
                ->get(['id', 'nama', 'stok']),
        ]);
    }
}
