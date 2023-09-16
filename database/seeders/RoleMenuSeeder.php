<?php

namespace Database\Seeders;

use App\Models\RoleMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;


class RoleMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolemenu_json = json_decode(File::get('database/data/role_menu.json'));
        foreach ($rolemenu_json as $key) {
            RoleMenu::create([
                'id' => $key->id,
                'id_role' => $key->id_role,
                'as_role' => $key->as_role,
                'id_menu' => $key->id_menu,
                'as_menu' => $key->as_menu,
                'sort' => $key->sort,
                'select' => $key->select,
                'insert' => $key->insert,
                'update' => $key->update,
                'delete' => $key->delete,
                'id_role' => $key->id_role,
                'delete' => $key->delete,
            ]);
        }
    }
}
