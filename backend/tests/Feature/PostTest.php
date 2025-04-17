<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostTest extends TestCase
{
    use WithFaker;

    public function testPostsShowSuccess(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->getJson('/api/posts');
        $response
            ->assertOk();
    }

    public function testPostsShowFailUnauth(): void
    {
        $response = $this->getJson('/api/posts');
        $response
            ->assertUnauthorized();
    }

    public function testPostsShowFailNotFound(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $response = $this->getJson('/api/post');
        $response
            ->assertNotFound();
    }

    public function testPostStoreSuccess(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $post = [
            'user_id' => $this->faker->numberBetween(1, UserFactory::NUMBER),
            'title' => $this->faker->realText(64),
            'content' => $this->faker->realText(),
            'tag_ids' => [1],
        ];
        $response = $this->postJson('/api/posts', $post);
        $response
            ->assertCreated();
    }

    public function testPostStoreFailUnauth(): void
    {
        $post = [
            'user_id' => $this->faker->numberBetween(1, UserFactory::NUMBER),
            'title' => $this->faker->realText(64),
            'content' => $this->faker->realText(),
            'tag_ids' => [1],
        ];
        $response = $this->postJson('/api/posts', $post);
        $response
            ->assertUnauthorized();
    }

    public function testPostStoreFailUnprocessable(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $post = [
            'user_id' => '',
            'title' => $this->faker->realText(64),
            'content' => $this->faker->realText(),
            'tag_ids' => '',
        ];
        $response = $this->postJson('/api/posts', $post);
        $response
            ->assertUnprocessable();
    }

    public function testPostStoreFailNotFoundExistsKey(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $post = [
            'user_id' => '2323232323',
            'post_id' => '32323232323',
            'title' => $this->faker->realText(64),
            'content' => $this->faker->realText(),
            'tag_ids' => [3232332323],
        ];
        $response = $this->postJson('/api/posts', $post);
        $response
            ->assertUnprocessable();
    }

    public function testPostStoreFailUniquePost(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $post = [
            'user_id' => $this->faker->numberBetween(1, UserFactory::NUMBER),
            'post_id' => $this->faker->numberBetween(1),
            'title' => $this->faker->realText(64),
            'content' => $this->faker->realText(),
            'tag_ids' => [1],
        ];
        $response = $this->postJson('/api/posts', $post);
        $response
            ->assertUnprocessable();
    }

    public function testPostByIdShowSuccess(): void
    {
        $post = Post::factory()->create();
        $this->assertDatabaseHas(Post::class, [
            'id' => $post->id,
        ]);
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->getJson('/api/posts/'.$post->id);
        $response
            ->assertOk();
    }

    public function testPostByIdShowFailUnauth(): void
    {
        $post = Post::factory()->create();
        $this->assertDatabaseHas(Post::class, [
            'id' => $post->id,
        ]);
        $response = $this->getJson('/api/posts/'.$post->id);
        $response
            ->assertUnauthorized();
    }

    public function testPostByIdShowFailNotFound(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->getJson('/api/posts/10000');
        $response
            ->assertNotFound();
    }

    public function testPostByIdShowFailBadContent(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->getJson('/api/posts/wef');
        $response
            ->assertNotFound();
    }

    public function testPostUpdateSuccess(): void
    {
        $post = Post::factory()->create();
        $this->assertDatabaseHas(Post::class, [
            'id' => $post->id,
        ]);
        Sanctum::actingAs(
            User::factory()->create()
        );

        $dataForUpdatePost = [
            'title' => $this->faker->title,
        ];

        $response = $this->json('PUT', '/api/posts/'.$post->id, $dataForUpdatePost);
        $response
            ->assertCreated();
        $this->assertDatabaseHas(
            Post::class,
            array_merge(
                ['id' => $post->id],
                $dataForUpdatePost
            )
        );
    }

    public function testPostUpdateFailUnauth(): void
    {
        $post = Post::factory()->create();
        $this->assertDatabaseHas(Post::class, [
            'id' => $post->id,
        ]);

        $dataForUpdatePost = [
            'title' => $this->faker->title,
        ];
        $response = $this->json('PUT', '/api/posts/'.$post->id, $dataForUpdatePost);
        $response
            ->assertUnauthorized();
    }

    public function testPostUpdateFailNotFound(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $response = $this->json('PUT', '/api/posts/2434', [
            'title' => $this->faker->title,
        ]);
        $response
            ->assertNotFound();
    }

    public function testPostUpdateFailUnprocessable(): void
    {
        $post = Post::factory()->create();
        $this->assertDatabaseHas(Post::class, [
            'id' => $post->id,
        ]);
        Sanctum::actingAs(
            User::factory()->create()
        );

        $dataForUpdatePost = [
            'title' => '',
        ];

        $response = $this->json('PUT', '/api/posts/'.$post->id, $dataForUpdatePost);
        $response
            ->assertUnprocessable();
        $this->assertDatabaseMissing(
            Post::class,
            array_merge(
                ['id' => $post->id],
                $dataForUpdatePost
            )
        );
    }

    public function testPostDestroySuccess(): void
    {
        $post = Post::factory()->create();
        $this->assertDatabaseHas(Post::class, [
            'id' => $post->id,
        ]);
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->json('Delete', '/api/posts/'.$post->id);
        $response
            ->assertNoContent();
        $this->assertDatabaseMissing(Post::class, [
            'id' => $post->id,
        ]);
    }

    public function testPostDestroyFailUnauth(): void
    {
        $post = Post::factory()->create();
        $this->assertDatabaseHas(Post::class, [
            'id' => $post->id,
        ]);
        $response = $this->json('Delete', '/api/posts/'.$post->id);
        $response
            ->assertUnauthorized();
        $this->assertDatabaseHas(Post::class, [
            'id' => $post->id,
        ]);
    }

    public function testPostDestroyFailNotFound(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $response = $this->json('Delete', '/api/posts/00000');
        $response
            ->assertNotFound();
    }

    public function testShowListingPostSuccess(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $response = $this->getJson('/api/posts/listing');
        $response
            ->assertOk()
            ->assertSee([
                'title',
                'user_id',
                'post_id',
                'child_depth',
            ]);
    }

    public function testShowListingPostFailUnauth(): void
    {
        $response = $this->getJson('/api/posts/listing');
        $response
            ->assertUnauthorized()
            ->assertDontSee([
                'title',
                'user_id',
                'post_id',
                'child_depth',
            ]);
    }

    public function testShowListingPostNotFound(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $response = $this->getJson('/api/posts/listings');
        $response
            ->assertNotFound()
            ->assertDontSee([
                'title',
                'user_id',
                'post_id',
                'child_depth',
            ]);
    }

    public function testPaginationPostSuccess(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $response = $this->getJson('/api/posts');

        $response
            ->assertOk()
            ->assertSee([
                'current_page',
                'data',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ]);
    }

    public function testSortingByReactionSuccess(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $post = Post::withCount('reactions as reactions')
            ->orderByDesc('reactions')
            ->first();

        $response = $this->getJson('/api/posts?order=reactions');
        $firstPaginationElement = json_decode($response->getContent())->data[0];

        $this->assertEquals($post->id, $firstPaginationElement->id);
        $this->assertEquals($post->reactions, $firstPaginationElement->reactions);
        $response
            ->assertOk();
    }

    public function testSortingByReactionFailUnauth(): void
    {
        $response = $this->getJson('/api/posts?order=reactions');
        $response
            ->assertUnauthorized();
    }
}
