<?php

namespace App\Models;

use App\Models\Peminjaman;
use App\Models\kategoriBuku;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';

    protected $guarded = [];

    public function kategoriBuku()
    {
        return $this->hasMany(kategoriBuku::class, 'bukuId');
    }
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'bukuId');
    }
}
