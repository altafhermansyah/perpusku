<?php

namespace App\Models;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;

class kategoriBuku extends Model
{
    protected $table = 'kategoriBuku_relasi';

    protected $guarded = [];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'bukuId');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategoriId');
    }
}
