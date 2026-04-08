<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthTest extends TestCase
{

     use DatabaseTransactions;

    public function test_login_exitoso()
    {
        // Arrange
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('123456')
        ]);

        $data = [
            'email' => 'test@test.com',
            'password' => '123456'
        ];

        // ACT
        $response = $this->postJson('/api/login', $data);

         // Assert
        $this->assertApiSuccess($response, 200);
    }

    public function test_login_falla_usuario_no_existe()
    {
        // Arrange
        $data = [
            'email' => 'noexiste@test.com',
            'password' => '123456'
        ];

        // Act
        $response = $this->postJson('/api/login', $data);

        // Assert
        $response->assertStatus(401);
    }

    public function test_login_falla_password_incorrecto()
    {
        // Arrange
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('123456')
        ]);

        $data = [
            'email' => 'test@test.com',
            'password' => 'wrongpass'
        ];

        // Act
        $response = $this->postJson('/api/login', $data);

        // Assert
        $response->assertStatus(401);
    }

    public function test_login_falla_validacion()
    {
        // Act
        $response = $this->postJson('/api/login', []);

        // Assert
        $response->assertStatus(422);
    }
}
