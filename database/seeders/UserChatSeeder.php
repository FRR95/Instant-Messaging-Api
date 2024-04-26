<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_chats')->insert([
            [
                "user_id" => 1,
                "chat_id" => 1 ,
            ],
            [
                "user_id" => 2,
                "chat_id" => 1 ,
            ],
            [
                "user_id" => 3,
                "chat_id" => 2 ,
            ],
            [
                "user_id" => 4,
                "chat_id" => 2,
            ],
        ]);
    }
}
