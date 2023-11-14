<?php

declare(strict_types=1);

namespace Tests\Feature\Auth\DTOs;

use App\Http\Requests\Auth\SignUpRequest;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class NewUserDTOTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_user_dto_instance(): void
    {
        $params = NewUserDTO::formRequest(new SignUpRequest([
            'name' => 'Test',
            'email' => 'test@gmail.com',
            'password' => '12345',
        ]));

        $this->assertInstanceOf(NewUserDTO::class, $params);
    }
}
