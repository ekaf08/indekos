<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\SubMenu;

class RoleSubMenu extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded  = ['id'];
    protected $table    = 'role_sub_menu';
    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    public function sub_menu_detail()
    {
        return $this->belongsTo(SubMenu::class, 'id_sub_menu')->orderBy('id', 'asc');
    }
}
