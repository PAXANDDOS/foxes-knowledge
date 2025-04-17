<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use WithFaker;

    public function testCreateInvitationSuccess(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $invitation = [
            'email' => $this->faker->unique()->safeEmail(),
        ];

        $response = $this->postJson('/api/invitations', $invitation);
        $response->assertNoContent();
    }

    public function testCreateInvitationFailUnauth(): void
    {
        $invitation = [
            'email' => $this->faker->unique()->safeEmail(),
        ];

        $response = $this->postJson('/api/invitations', $invitation);
        $response->assertUnauthorized();
    }

    public function testCreateInvitationFailBadContent(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $invitation = [
            'email' => '',
        ];

        $response = $this->postJson('/api/invitations', $invitation);
        $response->assertUnprocessable();
    }
}
