<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Obat;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function harian()
    {
        $today = now()->toDateString();

        $barangKeluar = BarangKeluar::with('obat')
            ->whereDate('tanggal', $today)
            ->get();

        $totalPendapatan = $barangKeluar->sum('total');

        $stokMenipis = Obat::where('stok', '<', 10)->get();

        return response()->json([
            'barang_keluar' => $barangKeluar,
            'total_pendapatan' => $totalPendapatan,
            'stok_menipis' => $stokMenipis,
        ]);
    }

    public function bulanan()
    {
        $month = now()->month;
        $year = now()->year;

        $barangKeluar = BarangKeluar::with('obat')
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();

        $totalPendapatan = $barangKeluar->sum('total');

        return response()->json([
            'total_pendapatan' => $totalPendapatan,
            'total_transaksi' => $barangKeluar->count(),
        ]);
    }

    public function harianPdf()
    {
        $today = now()->toDateString();

        $barangKeluar = BarangKeluar::with('obat')
            ->whereDate('tanggal', $today)
            ->get();

        $totalPendapatan = $barangKeluar->sum('total');

        $stokMenipis = Obat::where('stok', '<', 10)->get();

        $pdf = Pdf::loadView('pdf.laporan-harian', [
            'barang_keluar' => $barangKeluar,
            'total' => $totalPendapatan,
            'stok_menipis' => $stokMenipis,
            'tanggal' => $today,
        ]);

        return $pdf->download('laporan-harian.pdf');
    }

    public function bulananPdf()
    {
        $month = now()->month;
        $year = now()->year;

        $barangKeluar = BarangKeluar::with('obat')
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();

        $totalPendapatan = $barangKeluar->sum('total');

        $pdf = Pdf::loadView('pdf.laporan-bulanan', [
            'barang_keluar' => $barangKeluar,
            'total' => $totalPendapatan,
            'bulan' => $month,
            'tahun' => $year,
        ]);

        return $pdf->download("laporan-bulanan-$month-$year.pdf");
    }
}
