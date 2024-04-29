<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chats')->insert([
            [
                "name" => "Chat de Fran y Admin",
                "author_id"=>1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Chat de Anna y Robert",
                "author_id"=>3,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
