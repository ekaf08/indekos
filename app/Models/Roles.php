<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\RoleMenu;

class Roles extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded  = ['id'];
    protected $table    = 'roles';
    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    public function menu()
    {
        return $this->hasMany(RoleMenu::class, 'id_role')->orderBy('sort', 'asc');
    }
}
