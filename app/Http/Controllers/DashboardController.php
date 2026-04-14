<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Obat;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startDate = $today->copy()->subDays(6);

        $dailySales = BarangKeluar::query()
            ->selectRaw('DATE(tanggal) as date, COALESCE(SUM(jumlah), 0) as total_jumlah, COALESCE(SUM(total), 0) as total_pendapatan')
            ->whereBetween('tanggal', [$startDate->toDateString(), $today->toDateString()])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $salesTrend = collect(range(0, 6))
            ->map(function (int $offset) use ($startDate, $dailySales): array {
                $date = $startDate->copy()->addDays($offset)->toDateString();
                $row = $dailySales->get($date);

                return [
                    'date' => $date,
                    'label' => Carbon::parse($date)->translatedFormat('D'),
                    'jumlah' => (int) ($row->total_jumlah ?? 0),
                    'pendapatan' => (float) ($row->total_pendapatan ?? 0),
                ];
            })
            ->values();

        $stockByType = Obat::query()
            ->selectRaw('tipe, COUNT(*) as total_item, COALESCE(SUM(stok), 0) as total_stok')
            ->groupBy('tipe')
            ->orderByDesc('total_stok')
            ->get()
            ->map(function ($row): array {
                return [
                    'tipe' => $row->tipe,
                    'totalItem' => (int) $row->total_item,
                    'totalStok' => (int) $row->total_stok,
                ];
            })
            ->values();

        return response()->json([
            'totalObat' => Obat::count(),

            'keluarHariIni' => BarangKeluar::whereDate('tanggal', $today)->sum('jumlah'),

            'pendapatanHariIni' => BarangKeluar::whereDate('tanggal', $today)->sum('total'),

            'stokMenipis' => Obat::where('stok', '<', 10)
                ->take(5)
                ->get(['id', 'nama', 'stok']),

            'grafik' => [
                'penjualanMingguan' => $salesTrend,
                'stokPerTipe' => $stockByType,
            ],
        ]);
    }
}
