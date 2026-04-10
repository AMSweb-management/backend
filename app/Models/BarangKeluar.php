<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $fillable = [
        'obat_id',
        'jumlah',
        'tanggal',
        'total'
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
