<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Obat extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'nama',
        'tipe',
        'stok',
        'harga',
        'distributor_id',
        'expired_date',
    ];

    protected $casts = [
        'expired_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }
}
