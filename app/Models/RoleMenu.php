<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\RoleSubMenu;
use App\Models\Menu;

class RoleMenu extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded  = ['id'];
    protected $table    = 'role_menu';
    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    public function sub_menu()
    {
        return $this->hasMany(RoleSubMenu::class, 'id_role_menu')->orderBy('id_sub_menu', 'asc');
    }

    public function menu_detail()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }

    public function has_sub_menu()
    {
        return $this->belongsTo(SubMenu::class, 'id_menu');
    }
}
