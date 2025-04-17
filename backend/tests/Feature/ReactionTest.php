<?php

namespace Tests\Feature;

use App\Enums\ReactionType;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ReactionTest extends TestCase
{
    public function testStoreReactionPostSuccess(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        Sanctum::actingAs($user);

        $postReaction = [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'type' => ReactionType::UPVOTE,
        ];
        $response = $this->postJson('/api/posts/'.$post->id.'/reactions', $postReaction);
        $response
            ->assertCreated();
    }

    public function testStoreReactionPostFailUnauth(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $postReaction = [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'type' => ReactionType::UPVOTE,
        ];
        $response = $this->postJson('/api/posts/'.$post->id.'/reactions', $postReaction);
        $response
            ->assertUnauthorized();
    }

    public function testStoreReactionPostFailNotFound(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $postReaction = [
            'user_id' => $user->id,
            'post_id' => 1000,
            'type' => 'upv',
        ];
        $response = $this->postJson('/api/posts/1000/reactions', $postReaction);
        $response
            ->assertUnauthorized();
    }

    public function testStoreReactionPostFailBadContent(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        Sanctum::actingAs($user);

        $postReaction = [
            'user_id' => '',
            'post_id' => '',
            'type' => '',
        ];
        $response = $this->postJson('/api/posts/'.$post->id.'/reactions', $postReaction);
        $response
            ->assertUnprocessable();
    }

    public function testReactionPostCancelSuccess(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        Sanctum::actingAs($user);

        $postReactionData = [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'type' => ReactionType::UPVOTE,
        ];
        $postReaction = Reaction::create($postReactionData);
        $this->assertDatabaseHas(Reaction::class, array_merge(
            ['id' => $postReaction->id],
            $postReactionData
        ));

        $response = $this->postJson('/api/posts/'.$post->id.'/reactions', $postReactionData);

        $response
            ->assertNoContent();
    }

    public function testReactionPostCancelFailUnauth(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $postReactionData = [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'type' => ReactionType::UPVOTE,
        ];
        $postReaction = Reaction::create($postReactionData);
        $this->assertDatabaseHas(Reaction::class, array_merge(
            ['id' => $postReaction->id],
            $postReactionData
        ));

        $response = $this->postJson('/api/posts/'.$post->id.'/reactions', $postReactionData);

        $response
            ->assertUnauthorized();
    }

    public function testReactionPostCancelFailNotFound(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $postReactionData = [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'type' => ReactionType::UPVOTE,
        ];
        $postReaction = Reaction::create($postReactionData);
        $this->assertDatabaseHas(Reaction::class, array_merge(
            ['id' => $postReaction->id],
            $postReactionData
        ));

        $response = $this->postJson('/api/posts/'.$post->ids.'/reactions', $postReactionData);

        $response
            ->assertNotFound();
    }

    public function testReactionPostUpdateSuccess(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        Sanctum::actingAs($user);

        $postReactionData = [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'type' => ReactionType::UPVOTE,
        ];
        $postReaction = Reaction::create($postReactionData);
        $this->assertDatabaseHas(Reaction::class, array_merge(
            ['id' => $postReaction->id],
            $postReactionData
        ));

        $postReactionUpdate = [
            'type' => ReactionType::DOWNVOTE,
        ];

        $response = $this->postJson('/api/posts/'.$post->id.'/reactions', $postReactionUpdate);

        $response
            ->assertStatus(201);

        $this->assertDatabaseHas(
            Reaction::class,
            array_merge(
                ['id' => $postReaction->id],
                $postReactionUpdate
            )
        );
    }

    public function testReactionPostUpdateFailUnauth(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $postReactionData = [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'type' => ReactionType::UPVOTE,
        ];
        $postReaction = Reaction::create($postReactionData);
        $this->assertDatabaseHas(Reaction::class, array_merge(
            ['id' => $postReaction->id],
            $postReactionData
        ));

        $postReactionUpdate = [
            'type' => ReactionType::DOWNVOTE,
        ];

        $response = $this->postJson('/api/posts/'.$post->id.'/reactions', $postReactionUpdate);

        $response
            ->assertUnauthorized();

        $this->assertDatabaseMissing(
            Reaction::class,
            array_merge(
                ['id' => $postReaction->id],
                $postReactionUpdate
            )
        );
    }

    public function testReactionPostUpdateFailNotFound(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $postReactionData = [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'type' => ReactionType::UPVOTE,
        ];
        $postReaction = Reaction::create($postReactionData);
        $this->assertDatabaseHas(Reaction::class, array_merge(
            ['id' => $postReaction->id],
            $postReactionData
        ));

        $postReactionUpdate = [
            'type' => ReactionType::DOWNVOTE,
        ];

        $response = $this->postJson('/api/posts/'.$post->ids.'/reactions', $postReactionUpdate);

        $response
            ->assertNotFound();

        $this->assertDatabaseMissing(
            Reaction::class,
            array_merge(
                ['id' => $postReaction->id],
                $postReactionUpdate
            )
        );
    }

    public function testStoreReactionCommentSuccess(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();
        Sanctum::actingAs($user);

        $commentReaction = [
            'user_id' => $user->id,
            'comment_id' => $comment->id,
            'type' => ReactionType::UPVOTE,
        ];
        $response = $this->postJson('/api/comments/'.$comment->id.'/reactions', $commentReaction);
        $response
            ->assertCreated();
    }

    public function testStoreReactionCommentFailUnauth(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        $commentReaction = [
            'user_id' => $user->id,
            'comment_id' => $comment->id,
            'type' => ReactionType::UPVOTE,
        ];
        $response = $this->postJson('/api/comments/'.$comment->id.'/reactions', $commentReaction);
        $response
            ->assertUnauthorized();
    }

    public function testStoreReactionCommentFailNotFound(): void
    {
        $user = User::factory()->create();

        $commentReaction = [
            'user_id' => $user->id,
            'comment_id' => 1000,
            'type' => 'upv',
        ];
        $response = $this->postJson('/api/comments/1000/reactions', $commentReaction);
        $response
            ->assertUnauthorized();
    }

    public function testStoreReactionCommentFailBadContent(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        Sanctum::actingAs($user);

        $commentReaction = [
            'user_id' => '',
            'comment_id' => '',
            'type' => '',
        ];
        $response = $this->postJson('/api/comments/'.$comment->id.'/reactions', $commentReaction);
        $response
            ->assertUnprocessable();
    }

    public function testReactionCommentCancelSuccess(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        Sanctum::actingAs($user);

        $commentReactionData = [
            'user_id' => $user->id,
            'comment_id' => $comment->id,
            'type' => ReactionType::UPVOTE,
        ];
        $commentReaction = Reaction::create($commentReactionData);
        $this->assertDatabaseHas(Reaction::class, array_merge(
            ['id' => $commentReaction->id],
            $commentReactionData
        ));

        $response = $this->postJson('/api/comments/'.$comment->id.'/reactions', $commentReactionData);

        $response
            ->assertNoContent();
    }

    public function testReactionCommentCancelFailUnauth(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        $commentReactionData = [
            'user_id' => $user->id,
            'comment_id' => $comment->id,
            'type' => ReactionType::UPVOTE,
        ];
        $commentReaction = Reaction::create($commentReactionData);
        $this->assertDatabaseHas(Reaction::class, array_merge(
            ['id' => $commentReaction->id],
            $commentReactionData
        ));

        $response = $this->postJson('/api/comments/'.$comment->id.'/reactions', $commentReactionData);

        $response
            ->assertUnauthorized();
    }

    public function testReactionCommentCancelFailNotFound(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        $commentReactionData = [
            'user_id' => $user->id,
            'comment_id' => $comment->id,
            'type' => ReactionType::UPVOTE,
        ];
        $commentReaction = Reaction::create($commentReactionData);
        $this->assertDatabaseHas(Reaction::class, array_merge(
            ['id' => $commentReaction->id],
            $commentReactionData
        ));

        $response = $this->postJson('/api/comments/'.$comment->ids.'/reactions', $commentReactionData);

        $response
            ->assertNotFound();
    }

    public function testReactionCommentUpdateSuccess(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        Sanctum::actingAs($user);

        $commentReactionData = [
            'user_id' => $user->id,
            'comment_id' => $comment->id,
            'type' => ReactionType::UPVOTE,
        ];
        $commentReaction = Reaction::create($commentReactionData);
        $this->assertDatabaseHas(Reaction::class, array_merge(
            ['id' => $commentReaction->id],
            $commentReactionData
        ));

        $commentReactionUpdate = [
            'type' => ReactionType::DOWNVOTE,
        ];

        $response = $this->postJson('/api/comments/'.$comment->id.'/reactions', $commentReactionUpdate);

        $response
            ->assertStatus(201);

        $this->assertDatabaseHas(
            Reaction::class,
            array_merge(
                ['id' => $commentReaction->id],
                $commentReactionUpdate
            )
        );
    }

    public function testReactionCommentUpdateFailUnauth(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        $commentReactionData = [
            'user_id' => $user->id,
            'comment_id' => $comment->id,
            'type' => ReactionType::UPVOTE,
        ];
        $commentReaction = Reaction::create($commentReactionData);
        $this->assertDatabaseHas(Reaction::class, array_merge(
            ['id' => $commentReaction->id],
            $commentReactionData
        ));

        $commentReactionUpdate = [
            'type' => ReactionType::DOWNVOTE,
        ];

        $response = $this->postJson('/api/comments/'.$comment->id.'/reactions', $commentReactionUpdate);

        $response
            ->assertUnauthorized();

        $this->assertDatabaseMissing(
            Reaction::class,
            array_merge(
                ['id' => $commentReaction->id],
                $commentReactionUpdate
            )
        );
    }

    public function testReactionCommentUpdateFailNotFound(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        $commentReactionData = [
            'user_id' => $user->id,
            'comment_id' => $comment->id,
            'type' => ReactionType::UPVOTE,
        ];
        $commentReaction = Reaction::create($commentReactionData);
        $this->assertDatabaseHas(Reaction::class, array_merge(
            ['id' => $commentReaction->id],
            $commentReactionData
        ));

        $commentReactionUpdate = [
            'type' => ReactionType::DOWNVOTE,
        ];

        $response = $this->postJson('/api/comments/'.$comment->ids.'/reactions', $commentReactionUpdate);

        $response
            ->assertNotFound();

        $this->assertDatabaseMissing(
            Reaction::class,
            array_merge(
                ['id' => $commentReaction->id],
                $commentReactionUpdate
            )
        );
    }
}
