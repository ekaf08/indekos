<?php

namespace Database\Seeders;

use App\Models\RoleSubMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RoleSubMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleSubMenu_json = json_decode(File::get('database/data/role_sub_menu.json'));
        foreach ($roleSubMenu_json as $key) {
            RoleSubMenu::create([
                'id_role_menu' => $key->id_role_menu,
                'as_menu' => $key->as_menu,
                'id_sub_menu' => $key->id_sub_menu,
                'as_sub_menu' => $key->as_sub_menu,
                'select' => $key->select,
                'insert' => $key->insert,
                'update' => $key->update,
                'delete' => $key->delete,
                'import' => $key->import,
                'export' => $key->export,
            ]);
        }
    }
}
