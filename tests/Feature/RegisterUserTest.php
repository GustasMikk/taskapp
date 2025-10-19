<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    #@test
    public function user_can_register_successfully()
    {
        $data = [
            'name' => 'TestUser',
            'email' => 'test@test.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'user' => ['id', 'name', 'email', 'created_at'],
                     'token'
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    #@test
    public function registration_fails_with_invalid_data()
    {
        $data = [
            'name' => '',
            'email' => 'not-an-email',
            'password' => '123'
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'email', 'password']);
    }
}
