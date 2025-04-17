<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TagTest extends TestCase
{
    use WithFaker;

    public function testTagsShowSuccess(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->getJson('/api/tags');
        $response
            ->assertOk();
    }

    public function testTagsShowFailUnauth(): void
    {
        $response = $this->getJson('/api/tags');
        $response
            ->assertUnauthorized();
    }

    public function testTagsShowFailNotFound(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $response = $this->getJson('/api/tag');
        $response
            ->assertNotFound();
    }

    public function testTagStoreSuccess(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $tag = [
            'name' => $this->faker->colorName(),
            'color' => $this->faker->hexColor(),
        ];
        $response = $this->postJson('/api/tags', $tag);
        $response
            ->assertCreated();
    }

    public function testTagStoreFailUnauth(): void
    {
        $tag = [
            'name' => $this->faker->colorName(),
            'color' => $this->faker->hexColor(),
        ];
        $response = $this->postJson('/api/tags', $tag);
        $response
            ->assertUnauthorized();
    }

    public function testTagStoreFailUnprocessable(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $tag = [
            'name' => '',
            'color' => '',
        ];
        $response = $this->postJson('/api/tags', $tag);
        $response
            ->assertUnprocessable();
    }

    public function testTagByIdShowSuccess(): void
    {
        $tag = Tag::factory()->create();
        $this->assertDatabaseHas(Tag::class, [
            'id' => $tag->id,
        ]);
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->getJson('/api/tags/'.$tag->id);
        $response
            ->assertOk();
    }

    public function testTagByIdShowFailUnauth(): void
    {
        $tag = Tag::factory()->create();
        $this->assertDatabaseHas(Tag::class, [
            'id' => $tag->id,
        ]);
        $response = $this->getJson('/api/tags/'.$tag->id);
        $response
            ->assertUnauthorized();
    }

    public function testTagByIdShowFailNotFound(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->getJson('/api/tags/10000');
        $response
            ->assertNotFound();
    }

    public function testTagByIdShowFailBadContent(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->getJson('/api/tags/wef');
        $response
            ->assertNotFound();
    }

    public function testTagUpdateSuccess(): void
    {
        $tag = Tag::factory()->create();
        $this->assertDatabaseHas(Tag::class, [
            'id' => $tag->id,
        ]);
        Sanctum::actingAs(
            User::factory()->create()
        );

        $dataForUpdateTag = [
            'color' => $this->faker->hexColor(),
        ];

        $response = $this->json('PUT', '/api/tags/'.$tag->id, $dataForUpdateTag);
        $response
            ->assertCreated();
        $this->assertDatabaseHas(
            Tag::class,
            array_merge(
                ['id' => $tag->id],
                $dataForUpdateTag
            )
        );
    }

    public function testTagUpdateFailUnauth(): void
    {
        $tag = Tag::factory()->create();
        $this->assertDatabaseHas(Tag::class, [
            'id' => $tag->id,
        ]);

        $dataForUpdateTag = [
            'color' => $this->faker->hexColor(),
        ];
        $response = $this->json('PUT', '/api/tags/'.$tag->id, $dataForUpdateTag);
        $response
            ->assertUnauthorized();
    }

    public function testTagUpdateFailNotFound(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $response = $this->json('PUT', '/api/tags/2434', [
            'color' => $this->faker->hexColor(),
        ]);
        $response
            ->assertNotFound();
    }

    public function testTagUpdateFailUnprocessable(): void
    {
        $tag = Tag::factory()->create();
        $this->assertDatabaseHas(Tag::class, [
            'id' => $tag->id,
        ]);
        Sanctum::actingAs(
            User::factory()->create()
        );

        $dataForUpdateTag = [
            'color' => '',
        ];

        $response = $this->json('PUT', '/api/tags/'.$tag->id, $dataForUpdateTag);
        $response
            ->assertUnprocessable();
        $this->assertDatabaseMissing(
            Tag::class,
            array_merge(
                ['id' => $tag->id],
                $dataForUpdateTag
            )
        );
    }

    public function testTagDestroySuccess(): void
    {
        $tag = Tag::factory()->create();
        $this->assertDatabaseHas(Tag::class, [
            'id' => $tag->id,
        ]);
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->json('Delete', '/api/tags/'.$tag->id);
        $response
            ->assertNoContent();
        $this->assertDatabaseMissing(Tag::class, [
            'id' => $tag->id,
        ]);
    }

    public function testTagDestroyFailUnauth(): void
    {
        $tag = Tag::factory()->create();
        $this->assertDatabaseHas(Tag::class, [
            'id' => $tag->id,
        ]);
        $response = $this->json('Delete', '/api/tags/'.$tag->id);
        $response
            ->assertUnauthorized();
        $this->assertDatabaseHas(Tag::class, [
            'id' => $tag->id,
        ]);
    }

    public function testTagDestroyFailNotFound(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $response = $this->json('Delete', '/api/tags/00000');
        $response
            ->assertNotFound();
    }

    public function testShowTopTagsSuccess(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->getJson('/api/tags/top');
        $response
            ->assertOk()
            ->assertSee([
                'name',
                'tag_id',
                'color',
                'posts',
            ]);
    }

    public function testShowTopTagsFailUnauth(): void
    {
        $response = $this->getJson('/api/tags/top');
        $response
            ->assertUnauthorized()
            ->assertDontSee([
                'name',
                'tag_id',
                'color',
                'posts',
            ]);
    }

    public function testShowTopTagsNotFound(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->getJson('/api/tags/tops');
        $response
            ->assertNotFound()
            ->assertDontSee([
                'name',
                'tag_id',
                'color',
                'posts',
            ]);
    }
}
