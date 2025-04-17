<?php

namespace Database\Seeders;

use App\Models\Comment;
use Database\Factories\CommentFactory;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
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
                'user_id' => 2,
                'post_id' => 1,
                'content' => 'Nice post!',
            ],
            [
                'user_id' => 2,
                'post_id' => 2,
                'content' => 'Awesome!',
            ],
        ];

        foreach ($data as $comment) {
            Comment::create($comment);
        }

        Comment::factory()->count(CommentFactory::NUMBER)->create();
    }
}
