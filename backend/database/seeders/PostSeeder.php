<?php

namespace Database\Seeders;

use App\Models\Post;
use Database\Factories\PostFactory;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'title' => 'Introduction to React.js',
                'content' => 'Welcome to React.js!',
            ],
            [
                'user_id' => 1,
                'post_id' => 1,
                'title' => 'Creating React project',
                'content' => 'Today we will create our first React project.',
            ],
        ];

        foreach ($data as $post) {
            Post::create($post)->tags()->attach([1, 2]);
        }

        Post::factory()->count(PostFactory::NUMBER + count($data))->create();
    }
}
