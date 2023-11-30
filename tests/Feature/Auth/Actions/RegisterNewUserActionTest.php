<?php

declare(strict_types=1);

namespace Tests\Feature\Auth\Actions;

use Domain\Auth\Actions\RegisterNewUserAction;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterNewUserActionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        RegisterNewUserAction::fake();
    }

    public function test_user_created_success(): void
    {
        $email = 'test@gmail.com';
        $this->assertDatabaseMissing('users', compact('email'));

        $action = app(RegisterNewUserContract::class);

        $action(NewUserDTO::make(
            'Test',
            $email,
            'password'
        ));

        $this->assertDatabaseHas('users', compact('email'));
    }
}
