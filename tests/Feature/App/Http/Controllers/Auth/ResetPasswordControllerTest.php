<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LoginController;
use Tests\TestCase;
use Domain\Auth\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Auth\ResetPasswordController;
use Database\Factories\UserFactory;

final class ResetPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private string $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = UserFactory::new()->create([
            'email' => 'test@gmail.com'
        ]);
        $this->token = Password::createToken($this->user);
    }

    public function test_render_page(): void
    {
        $this->get(action([ResetPasswordController::class, 'renderPage'], ['token' => $this->token]))
            ->assertOk()
            ->assertViewIs('auth.reset-password');
    }

    public function test_reset_password(): void
    {
        $newPassword = Str::random(8);
        $newPasswordConfirmation = $newPassword;
        $parameters = [
            'email' => $this->user->email,
            'password' => $newPassword,
            'password_confirmation' => $newPasswordConfirmation,
            'token' => $this->token
        ];

        Password::shouldReceive('reset')
            ->once()
            ->withSomeOfArgs($parameters)
            ->andReturn(Password::PASSWORD_RESET);

        $response = $this->post(action([ResetPasswordController::class, 'handle']), $parameters);

        $response->assertRedirect(action([LoginController::class, 'renderPage']));
    }
}
