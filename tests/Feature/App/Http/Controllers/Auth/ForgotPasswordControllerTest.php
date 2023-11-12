<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ForgotPasswordController;
use Database\Factories\UserFactory;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

final class ForgotPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    private function testCredentials(): array
    {
        return [
            'email' => 'test@gmail.com'
        ];
    }

    public function test_render_page(): void
    {
        $this->get(action([ForgotPasswordController::class, 'renderPage']))
            ->assertOk()
            ->assertViewIs('auth.forgot-password');
    }

    public function test_forgot_password(): void
    {
        $user = UserFactory::new()->create($this->testCredentials());

        $this->post(action([ForgotPasswordController::class, 'handle']), $this->testCredentials())
            ->assertRedirect();

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_fail_forgot_password(): void
    {
        $this->assertDatabaseMissing('users', $this->testCredentials());

        $this->post(action([ForgotPasswordController::class, 'handle']), $this->testCredentials())
            ->assertInvalid(['email']);

        Notification::assertNothingSent();
    }
}