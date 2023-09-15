<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $admin = Roles::create([
        //     'nama' => 'Admin'
        // ]);
        // $user = Roles::create([
        //     'nama'  => 'User'
        // ]);

        $roles_json = json_decode(File::get('database/data/roles.json'));
        foreach ($roles_json as $key) {
            Roles::create([
                'nama' => $key->nama,
            ]);
        }
    }
}
