<?php

namespace Database\Seeders;

use App\Models\SubMenu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SubMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $web_management = SubMenu::create([
        //     'id_menu' => 1,
        //     'sub_menu' => 'Web Management',
        //     'url' => 'config.index',
        //     'icon' => 'config',
        //     'active' => 'config',
        // ]);
        // $kategori = SubMenu::create([
        //     'id_menu' => 2,
        //     'sub_menu' => 'Kategori',
        //     'url' => 'kategori.index',
        //     'icon' => 'kategori',
        //     'active' => 'kategori',
        // ]);

        $submenu_json = json_decode(File::get('database/data/sub_menu.json'));
        foreach ($submenu_json as $key) {
            SubMenu::create([
                'id_menu' => $key->id_menu,
                'sub_menu' => $key->sub_menu,
                'url' => $key->url,
                'icon' => $key->icon,
                'active' => $key->active,
            ]);
        }
    }
}
