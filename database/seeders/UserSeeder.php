<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $admin = User::create([
        //     'name' => 'Admin',
        //     'username' => 'admin',
        //     'id_role' => 1,
        //     'email' => 'admin@email.com',
        //     'password' => Hash::make('123'),
        // ]);
        // $user = User::create([
        //     'name' => 'User',
        //     'username' => 'user',
        //     'id_role' => 2,
        //     'email' => 'user@email.com',
        //     'password' => Hash::make('123'),
        // ]);

        $user_json = json_decode(File::get('database/data/users.json'));
        foreach ($user_json as $key) {
            User::create([
                'id_role' => $key->id_role,
                'name' => $key->name,
                'email' => $key->email,
                'password' => $key->password,
                'username' => $key->username,
            ]);
        }
    }
}
