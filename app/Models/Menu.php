<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded  = ['id'];
    protected $table    = 'menu';
    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];
}
