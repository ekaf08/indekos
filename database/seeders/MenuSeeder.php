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
        // $dashboard = Menu::create([
        //     'menu' => 'Dashboard',
        //     'url' => 'dashboard',
        //     'icon' => 'bi bi-grid-fill',
        //     'active' => 'dashboard',
        // ]);
        // $kategori = Menu::create([
        //     'menu' => 'Master',
        //     'has_sub_menu' => 't',
        //     'icon' => 'bi bi-stack',
        //     'active' => 'master',
        // ]);
        // $transaksi = Menu::create([
        //     'menu' => 'Transaksi',
        //     'has_sub_menu' => 't',
        //     'icon' => 'bi bi-arrow-left-right',
        //     'active' => 'transaksi',
        // ]);
        // $laporan = Menu::create([
        //     'menu' => 'Laporan',
        //     'has_sub_menu' => 't',
        //     'icon' => 'bi bi-file-earmark-pdf',
        //     'active' => 'laporan',
        // ]);
        // $setup = Menu::create([
        //     'menu' => 'Pengaturan',
        //     'has_sub_menu' => 't',
        //     'icon' => 'bi bi-gear',
        //     'active' => 'pengaturan',
        // ]);

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
