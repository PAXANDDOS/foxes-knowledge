<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use WithFaker;

    public function testCommentsShowSuccess(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->getJson('/api/comments');
        $response
            ->assertOk();
    }

    public function testCommentsShowFailUnauth(): void
    {
        $response = $this->getJson('/api/comments');
        $response
            ->assertUnauthorized();
    }

    public function testCommentsShowFailNotFound(): void
    {
        $response = $this->getJson('/api/comment');
        $response
            ->assertNotFound();
    }

    public function testCommentStoreSuccess(): void
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->postJson('/api/comments', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'content' => $this->faker->realText(),
        ]);
        $response
            ->assertCreated();
    }

    public function testCommentStoreFailUnauth(): void
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson('/api/comments', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'content' => $this->faker->realText(),
        ]);
        $response
            ->assertUnauthorized();
    }

    public function testCommentStoreFailUnprocessable(): void
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->postJson('/api/comments', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'content' => '',
        ]);
        $response
            ->assertUnprocessable();
    }

    public function testCommentByIdShowSuccess(): void
    {
        $comment = Comment::factory()->create();
        $this->assertDatabaseHas(Comment::class, [
            'id' => $comment->id,
        ]);
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->getJson('/api/comments/'.$comment->id);
        $response
            ->assertOk();
    }

    public function testCommentByIdShowFailUnauth(): void
    {
        $comment = Comment::factory()->create();
        $this->assertDatabaseHas(Comment::class, [
            'id' => $comment->id,
        ]);
        $response = $this->getJson('/api/comments/'.$comment->id);
        $response
            ->assertUnauthorized();
    }

    public function testCommentByIdShowFailNotFound(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->getJson('/api/comments/10000');
        $response
            ->assertNotFound();
    }

    public function testCommentByIdShowFailBadContent(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->getJson('/api/comments/wef');
        $response
            ->assertNotFound();
    }

//
    public function testCommentUpdateSuccess(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        $this->assertDatabaseHas(Comment::class, [
            'id' => $comment->id,
        ]);

        Sanctum::actingAs($user);

        $dataForUpdateComment = [
            'content' => $this->faker->realText,
        ];

        $response = $this->json('PUT', '/api/comments/'.$comment->id, $dataForUpdateComment);
        $response
            ->assertCreated();
        $this->assertDatabaseHas(
            Comment::class,
            array_merge(
                ['id' => $comment->id],
                $dataForUpdateComment
            )
        );
    }

    public function testCommentUpdateFailUnauth(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        $this->assertDatabaseHas(Comment::class, [
            'id' => $comment->id,
        ]);

        $dataForUpdateComment = [
            'content' => $this->faker->realText,
        ];

        $response = $this->json('PUT', '/api/comments/'.$comment->id, $dataForUpdateComment);
        $response
            ->assertUnauthorized();
        $this->assertDatabaseMissing(
            Comment::class,
            array_merge(
                ['id' => $comment->id],
                $dataForUpdateComment
            )
        );
    }

    public function testCommentUpdateFailNotFound(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $response = $this->json('PUT', '/api/comments/2434', [
            'title' => $this->faker->title,
        ]);
        $response
            ->assertNotFound();
    }

    public function testCommentUpdateFailUnprocessable(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();
        Sanctum::actingAs($user);
        $this->assertDatabaseHas(Comment::class, [
            'id' => $comment->id,
        ]);

        $dataForUpdateComment = [
            'content' => '',
        ];

        $response = $this->json('PUT', '/api/comments/'.$comment->id, $dataForUpdateComment);
        $response
            ->assertUnprocessable();
        $this->assertDatabaseMissing(
            Comment::class,
            array_merge(
                ['id' => $comment->id],
                $dataForUpdateComment
            )
        );
    }

    public function testCommentDestroySuccess(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();
        Sanctum::actingAs($user);
        $this->assertDatabaseHas(Comment::class, [
            'id' => $comment->id,
        ]);

        $response = $this->json('Delete', '/api/comments/'.$comment->id);
        $response
            ->assertNoContent();
        $this->assertDatabaseMissing(Comment::class, [
            'id' => $comment->id,
        ]);
    }

    public function testCommentDestroyFailUnauth(): void
    {
        $comment = Comment::factory()->create();
        $this->assertDatabaseHas(Comment::class, [
            'id' => $comment->id,
        ]);
        $response = $this->json('Delete', '/api/comments/'.$comment->id);
        $response
            ->assertUnauthorized();
        $this->assertDatabaseHas(Comment::class, [
            'id' => $comment->id,
        ]);
    }

    public function testCommentDestroyFailNotFound(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $response = $this->json('Delete', '/api/comments/00000');
        $response
            ->assertNotFound();
    }
}
