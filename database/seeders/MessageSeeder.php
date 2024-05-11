<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('messages')->insert([
            [
                'content' => 'soy Admin y este es mi primer mensaje para Fran',
                'chat_id' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                'content' => 'soy Fran y este es mi primer mensaje para Admin',
                'chat_id' => 1,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'content' => 'soy Robert y este es mi primer mensaje para Anna',
                'chat_id' => 2,
                'user_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'content' => 'soy Anna y este es mi primer mensaje para Robert',
                'chat_id' => 2,
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
