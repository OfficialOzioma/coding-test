<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserAchievementsTest extends TestCase
{
    use RefreshDatabase;

    public function testUserAchievementsEndpoint()
    {
        // Create a user with some achievements and badges
        $user = User::factory()->create();
        // Your logic to assign achievements and badges to the user...

        // Hit the endpoint
        $response = $this->get("/users/{$user->id}/achievements");

        // Assert response status
        $response->assertStatus(200);

        // Assert response structure
        $response->assertJsonStructure([
            'unlocked_achievements',
            'next_available_achievements',
            'current_badge',
            'next_badge',
            'remaining_to_unlock_next_badge',
        ]);

        // Assert response content
        $response->assertJson([
            'unlocked_achievements' => [], // Your expected unlocked achievements
            'next_available_achievements' => [], // Your expected next available achievements
            'current_badge' => null, // Your expected current badge or null
            'next_badge' => null, // Your expected next badge or null
            'remaining_to_unlock_next_badge' => 0, // Your expected remaining count to unlock next badge
        ]);
    }
}
