<?php

namespace App\Models;

use App\Models\kategoriBuku;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoribuku';

    protected $guarded = [];

    public function kategoriBuku()
    {
        return $this->hasMany(kategoriBuku::class);
    }
}
