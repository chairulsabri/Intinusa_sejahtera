<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'access_token',
                'token_type',
                'user' => ['id', 'name', 'username', 'email']
            ]);

        $this->assertDatabaseHas('users', [
            'username' => 'johndoe',
            'email' => 'john@example.com'
        ]);
    }

    public function test_api_can_login_with_email()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'login' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['access_token', 'user']);
    }

    public function test_api_can_login_with_username()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'login' => 'testuser',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['access_token', 'user']);
    }

    public function test_api_login_fails()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'login' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401);
    }

    public function test_api_logout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token')->plainTextToken;

        $response = $this->postJson('/api/logout', [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);
        $this->assertEmpty($user->tokens);
    }

    public function test_api_forgot_password()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/forgot-password', [
            'email' => $user->email
        ]);

        $response->assertStatus(200);
    }
}
