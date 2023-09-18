<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menu_json = json_decode(File::get('database/data/menu.json'));
        foreach ($menu_json as $key) {
            Menu::create([
                'menu' => $key->menu,
                'url' => $key->url,
                'has_sub_menu' => $key->has_sub_menu,
                'icon' => $key->icon,
                'active' => $key->active,
            ]);
        }
    }
}
