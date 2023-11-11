<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LogoutController;
use Database\Factories\UserFactory;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_logout_success(): void
    {
        $user = UserFactory::new()->create([
            'email' => 'test@gmail.com'
        ]);

        $this->actingAs($user)
            ->delete(action(LogoutController::class));

        $this->assertGuest();
    }

    public function test_logout_fail(): void
    {
        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Unauthenticated.');

        $this->delete(action(LogoutController::class));
    }
}