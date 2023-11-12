<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers\Auth\Socialite;

use App\Http\Controllers\Auth\Socialite\GithubController;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;
use Mockery\MockInterface;
use Tests\TestCase;

final class GithubControllerTest extends TestCase
{
    use RefreshDatabase;
    
    private function mockSocialiteCallback(string|int $githubId): MockInterface
    {
        $user = $this->mock(SocialiteUser::class, function (MockInterface $m) use($githubId) {
            $m->shouldReceive('getId')
                ->once()
                ->andReturn($githubId);

            $m->shouldReceive('getNickName')
                ->once()
                ->andReturn(str()->random(10));

            $m->shouldReceive('getEmail')
                ->once()
                ->andReturn('test@gmail.com');
        });

        Socialite::shouldReceive('driver->user')
            ->once()
            ->andReturn($user);

        return $user;
    }

    private function callbackRequest(): TestResponse
    {
        return $this->get(
            action(
                [GithubController::class, 'githubCallback'],
                ['driver' => 'github']
            )
        );
    }

    public function test_github_redirect_success(): void
    {
        $this->get(
            action(
                [GithubController::class, 'github'],
                ['driver' => 'github']
            )
        )->assertRedirectContains('github.com');
    }

    public function test_github_callback_created_user_success(): void
    {
        $githubId = str()->random(10);

        $this->assertDatabaseMissing('users', [
            'github_id' => $githubId
        ]);

        $this->mockSocialiteCallback($githubId);

        $this->callbackRequest()
            ->assertRedirect(route('home'));

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'github_id' => $githubId
        ]);
    }

    public function test_authenticated_by_existing_user(): void
    {
        $githubId = str()->random(10);

        UserFactory::new()->create([
            'github_id' => $githubId
        ]);

        $this->assertDatabaseHas('users', [
            'github_id' => $githubId
        ]);

        $this->mockSocialiteCallback($githubId);

        $this->callbackRequest()
            ->assertRedirect(route('home'));

        $this->assertAuthenticated();
    }

}