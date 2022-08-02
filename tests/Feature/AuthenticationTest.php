<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Register test
     *
     * @return void
     */
    public function test_a_user_can_register_to_the_application(): void
    {
        $response = $this->postJson('/register', [
            'username'              => 'username',
            'password'              => 'password',
            'password_confirmation' => 'password',
            'name'                  => 'name',
            'surname'               => 'surname'
        ]);

        $response->assertStatus(201);
    }

    public function test_a_user_can_login_into_the_application(): void
    {
        $user = User::factory()->create(['username' => 'username']);

        $response = $this->postJson('/login', [
            'username' => $user->username,
            'password' => 'password'
        ]);

        $response
            ->assertStatus(204)
            ->assertSessionHas('_token');
    }
}
