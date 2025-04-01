<?php

namespace Tests\Unit;


use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase; // Ensures a clean database for each test

    /** @test */
    public function it_registers_a_user_successfully()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'success']);

        $this->assertDatabaseHas('users', [
            'email' => 'johndoe@example.com'
        ]);
    }

    /** @test */
    public function it_fails_registration_due_to_missing_fields()
    {
        $response = $this->postJson('/api/register', []);

        $response->assertStatus(400)
                 ->assertJsonStructure(['errors']);
    }

    /** @test */
    public function it_logs_in_a_user_successfully()
    {
        $user = User::factory()->create([
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password123')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'johndoe@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token']);
    }

    /** @test */
    public function it_fails_login_with_invalid_credentials()
    {
        User::factory()->create([
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password123')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'johndoe@example.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertStatus(200) // Change to 401 if you modify the controller
                 ->assertJson(['errors' => 'invalid credentials']);
    }

    /** @test */
    public function it_logs_out_a_user_successfully()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/logout');

        $response->assertStatus(200)
                 ->assertJson(['message' => 'token destroyed']);
    }

}
