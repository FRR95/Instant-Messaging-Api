<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'nickname' => '@Admin',
                'url_profile_image'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/Windows_10_Default_Profile_Picture.svg/2048px-Windows_10_Default_Profile_Picture.svg.png',
                'biography'=>'Hola soy Admin y esta es mi biografía',
                'email' => 'Admin@gmail.com',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'role_id' => 2,

            ],
            [
                'name' => 'Fran',
                'nickname' => '@Franky',
                'url_profile_image'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/Windows_10_Default_Profile_Picture.svg/2048px-Windows_10_Default_Profile_Picture.svg.png',
                'biography'=>'Hola soy Fran y esta es mi biografía',
                'email' => 'Fran@gmail.com',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'role_id' => 1,
            ],
            [
                'name' => 'Robert',
                'nickname' => '@Robert',
                'url_profile_image'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/Windows_10_Default_Profile_Picture.svg/2048px-Windows_10_Default_Profile_Picture.svg.png',
                'biography'=>'Hola soy Robert y esta es mi biografía',
                'email' => 'Robert@gmail.com',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'role_id' => 1,
            ],
            [
                'name' => 'Anna',
                'nickname' => '@Anna',
                'url_profile_image'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/Windows_10_Default_Profile_Picture.svg/2048px-Windows_10_Default_Profile_Picture.svg.png',
                'biography'=>'Hola soy Anna y esta es mi biografía',
                'email' => 'Anna@gmail.com',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'role_id' => 1,
            ],
            [
                'name' => 'Luis',
                'nickname' => '@Luis',
                'url_profile_image'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/Windows_10_Default_Profile_Picture.svg/2048px-Windows_10_Default_Profile_Picture.svg.png',
                'biography'=>'Hola soy Luis y esta es mi biografía',
                'email' => 'Luis@gmail.com',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'role_id' => 1,
            ],
            [
                'name' => 'Marta',
                'nickname' => '@Marta',
                'url_profile_image'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/Windows_10_Default_Profile_Picture.svg/2048px-Windows_10_Default_Profile_Picture.svg.png',
                'biography'=>'Hola soy Marta y esta es mi biografía',
                'email' => 'Marta@gmail.com',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'role_id' => 1,
            ],
        ]);
    }
}
