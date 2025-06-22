<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',  
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testLoginUnauthorized()
    {
        $data = [
            'email' => 'john@example.com',
            'password' => 'wrongpassword',
        ];

        $response = $this->post('/api/login', $data);

        $response->assertStatus(401);
        $response->assertJson(['message' => 'Failed to log in: The provided credentials are incorrect.']);
    }


    public function testLogout()
    {
        Passport::actingAs($this->user);

        $response = $this->post('/api/logout');

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Logged out successfully']);
    }
}