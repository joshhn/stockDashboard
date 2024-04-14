<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_register(): void
    {
        $response = $this->postJson('/api/register', ['name' => 'John Test', 'email' => 'test@gmail.com', 'password' => '12345678']);
        $response->assertCreated();
        
        $response = $this->postJson('/api/register', ['name' => 'John Test', 'email' => 'test@gmail.com', 'password' => '12345678']);
        $response->assertUnprocessable()->assertJsonValidationErrors(['email']);

        $response = $this->postJson('/api/register', ['email' => 'test2@gmail.com', 'password' => '1234']);
        $response->assertUnprocessable()->assertJsonValidationErrors(['name', 'password']);

        $response = $this->postJson('/api/register', ['name' => 'John Test', 'email' => 'gmail.com', 'password' => '12345678']);
        $response->assertUnprocessable()->assertJsonValidationErrors(['email']);
    }

    public function test_user_log_in(): void
    {
        $response = $this->postJson('/api/register', ['name' => 'John Test', 'email' => 'test@gmail.com', 'password' => '12345678']);
        $response->assertCreated();

        $response = $this->postJson('/api/login', ['email' => 'test@gmail.com', 'password' => '12345678']);
        $response->assertOk();

        $response = $this->postJson('/api/login', ['email' => 'test@gmail.com', 'password' => '12345678900']);
        $response->assertBadRequest();

        $response = $this->postJson('/api/login', ['email' => 'test2@gmail.com', 'password' => '12345678']);
        $response->assertBadRequest();
    }

    public function test_returns_user_information()
    {
        $user = User::factory()->create();

        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->get('/api/user');

        $response->assertOk()->assertJson(['id' => $user->id, 'name' => $user->name]);
    }
}
