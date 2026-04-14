<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Distributor extends Model
{
    use HasUuids;

    protected $fillable = ['nama', 'alamat'];

    public function obats()
    {
        return $this->hasMany(Obat::class);
    }
}