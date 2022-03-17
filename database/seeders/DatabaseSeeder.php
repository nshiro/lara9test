<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Random;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // Post::factory(30)->create();

        [$first] = User::factory(15)->create()->each(function ($user) {
            Post::factory(random_int(2, 5))->random()->create(['user_id' => $user])->each(function ($post) {
                Comment::factory(random_int(1, 5))->create(['post_id' => $post]);
            });
        });

        $first->update([
            'name' => 'シロ',
            'email' => 'aaa@bbb.net',
            'password' => Hash::make('hogehoge'),
        ]);
    }
}
