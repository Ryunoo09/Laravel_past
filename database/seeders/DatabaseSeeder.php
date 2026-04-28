<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(8)->create();

        foreach ($users as $user) {
            $post = \App\Models\Post::factory()->create([
                'user_id' => $user->id,
            ]);

            \App\Models\Comment::factory()->create([
                'post_id' => $post->id,
                'user_id' => $user->id,
            ]);
        }
    }
}
