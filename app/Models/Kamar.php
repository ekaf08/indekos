<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kamar extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kamar';
    protected $guarded = [];

    public function kategori_kamar()
    {
        return $this->belongsToMany(Kategori::class, 'kategori_kamar');
    }
}
