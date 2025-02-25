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
        return $this->hasMany(kategoriBuku::class);
    }
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
    public function ulasan()
    {
        return $this->hasMany(Ulasan::class);
    }
    public function koleksi()
    {
        return $this->hasMany(Koleksi::class);
    }
}
