<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function notifications()
    {
        $now = Carbon::now();
        $limitDate = Carbon::now()->addDays(30);

        $items = Obat::where(function ($q) use ($limitDate) {
            $q->where('stok', '<=', 10)
                ->orWhere(function ($q2) use ($limitDate) {
                    $q2->whereNotNull('expired_date')
                        ->where('expired_date', '<=', $limitDate);
                });
        })->get();

        $data = $items->map(function ($item) use ($limitDate) {

            $isLowStock = $item->stok <= 10;
            $isExpiredSoon = $item->expired_date && $item->expired_date <= $limitDate;

            $types = [];
            $messages = [];

            if ($isLowStock) {
                $types[] = 'low_stock';
                $messages[] = 'Stok menipis';
            }

            if ($isExpiredSoon) {
                $types[] = 'expired';
                $messages[] = 'Akan kadaluarsa';
            }

            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'stok' => $item->stok,
                'expired_date' => $item->expired_date,

                'types' => $types,
                'messages' => $messages,
            ];
        });

        return response()->json([
            'total' => $data->count(),
            'data' => $data,
        ]);
    }

    public function markRead()
    {
        Obat::where('stok', '<=', 10)
            ->update(['is_read' => true]);

        return response()->json([
            'message' => 'Semua notifikasi ditandai sudah dibaca',
        ]);
    }
}
