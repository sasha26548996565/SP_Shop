<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers\Auth;

use Tests\TestCase;
use Domain\Auth\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Notifications\NewUserNotification;
use App\Listeners\SendEmailNewUserListener;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Auth\SignUpController;
use Tests\RequestFactories\SignUpRequestFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;

final class SignUpControllerTest extends TestCase
{
    use RefreshDatabase;

    protected array $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = SignUpRequestFactory::new()->create([
            'email' => 'testing@cutcode.ru',
            'password' => '1234567890',
            'password_confirmation' => '1234567890'
        ]);
    }

    private function request(): TestResponse
    {
        return $this->post(
            action([SignUpController::class, 'handle']),
            $this->request
        );
    }

    private function findUser(): User
    {
        return User::query()
            ->where('email', $this->request['email'])
            ->first();
    }

    public function test_page_success(): void
    {
        $this->get(action([SignUpController::class, 'renderPage']))
            ->assertOk()
            ->assertSee('Регистрация')
            ->assertViewIs('auth.sign-up');
    }

    public function test_validation_success(): void
    {
        $this->request()
            ->assertValid();
    }

    public function test_user_created_success(): void
    {
        $this->assertDatabaseMissing('users', [
            'email' => $this->request['email']
        ]);

        $this->request();

        $this->assertDatabaseHas('users', [
            'email' => $this->request['email']
        ]);
    }

    public function test_registered_event_and_listeners_dispatched(): void
    {
        Event::fake();

        $this->request();

        Event::assertDispatched(Registered::class);
        Event::assertListening(
            Registered::class,
            SendEmailNewUserListener::class
        );
    }

    public function test_notification_sent(): void
    {
        $this->request();

        Notification::assertSentTo(
            $this->findUser(),
            NewUserNotification::class
        );
    }


    public function test_user_authenticated_after_and_redirected(): void
    {
        $this->request()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($this->findUser());
    }
}
