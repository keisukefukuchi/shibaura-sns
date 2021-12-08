<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            Message::create([
                'channel_id' => 1,
                'user_id'    => $i,
                'reply_id'    => 0,
                'message'       => 'This is a test post' .$i,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}