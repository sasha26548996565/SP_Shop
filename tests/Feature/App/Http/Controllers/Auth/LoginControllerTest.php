<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LoginController;
use Database\Factories\UserFactory;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\RequestFactories\LoginRequestFactory;

final class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_render_page(): void
    {
        $this->withoutExceptionHandling();
        $this->get(action([LoginController::class, 'renderPage']))
            ->assertOk()
            ->assertViewIs('auth.login');
    }

    public function test_login(): void
    {
        $this->withoutExceptionHandling();
        $password = Str::random(8);
        $parameters = [
            'email' => 'test@gmail.com',
            'password' => $password
        ];
        $user = UserFactory::new()->create([
            'email' => $parameters['email'],
            'password' => Hash::make($parameters['password'])
        ]);

        $request = LoginRequestFactory::new()->create($parameters);

        $response = $this->post(
            action([LoginController::class, 'handle']),
            $request
        );

        $response->assertValid()
            ->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fail(): void
    {
        $this->withoutExceptionHandling();
        $request = LoginRequestFactory::new()->create([
            'email' => 'test@gmail.com'
        ]);

        $this->post(
            action([LoginController::class, 'handle']),
            $request
        )->assertInvalid(['email']);

        $this->assertGuest();
    }
}