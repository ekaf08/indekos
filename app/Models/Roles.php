<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\RoleMenu;
use Illuminate\Support\Facades\Route;

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

    static public function getSubMenu()
    {
        $url = Route::currentRouteName();
        $getMenu = Roles::withTrashed()
            ->leftJoin('role_menu', 'role_menu.id_role', 'roles.id')
            ->leftJoin('role_sub_menu', 'role_sub_menu.id_role_menu', 'role_menu.id')
            ->leftJoin('sub_menu', 'sub_menu.id', 'role_sub_menu.id_sub_menu')
            ->whereNotNull('role_sub_menu.deleted_at')
            ->where('roles.id', auth()->user()->id_role)
            ->where('sub_menu.url', $url)
            ->select('role_sub_menu.*', 'sub_menu.url')
            ->withTrashed()
            ->first();

        return $getMenu;
    }
}
