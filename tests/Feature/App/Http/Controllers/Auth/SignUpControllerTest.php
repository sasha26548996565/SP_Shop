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
use Database\Factories\UserFactory;
use Tests\RequestFactories\SignUpRequestFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;

class SignUpControllerTest extends TestCase
{
    use RefreshDatabase;

    private array $requestSuccess;
    private array $requestError;

    protected function setUp(): void
    {
        parent::setUp();

        $this->requestSuccess = SignUpRequestFactory::new()->create([
            'email' => 'test@gmail.com',
            'password' => '123456789',
            'password_confirmation' => '123456789',
        ]);

        $this->requestError = SignUpRequestFactory::new()->create([
            'email' => 'test@gmail.com',
            'password' => '123456789',
            'password_confirmation' => '123',
        ]);
    }

    public function test_render_page(): void
    {
        $this->withoutExceptionHandling();
        $this->get(action([SignUpController::class, 'renderPage']))
            ->assertOk()
            ->assertViewIs('auth.sign-up');
    }

    private function request(array $parameters): TestResponse
    {
        return $this->post(
            action([SignUpController::class, 'handle']),
            $parameters
        );
    }

    private function requestSuccess(): TestResponse
    {
        return $this->request($this->requestSuccess);
    }

    private function requestError(): TestResponse
    {
        return $this->request($this->requestError);
    }

    private function findUser(): User
    {
        return User::where('email', $this->requestSuccess['email'])
            ->first();
    }

    public function test_validation_success(): void
    {
        $this->requestSuccess()
            ->assertValid();
    }

    public function test_validation_error(): void
    {
        $user = UserFactory::new()->create([
            'email' => $this->requestError['email']
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $user->email
        ]);

        $this->requestError()
            ->assertInvalid(['email', 'password']);
    }

    public function test_user_created(): void
    {
        $this->assertDatabaseMissing('users', [
            'email' => $this->requestSuccess['email']
        ]);

        $this->requestSuccess();

        $this->assertDatabaseHas('users', [
            'email' => $this->requestSuccess['email']
        ]);
    }

    public function test_event_dispached(): void
    {
        Event::fake();

        $this->requestSuccess();

        Event::assertDispatched(Registered::class);
        Event::assertListening(
            Registered::class,
            SendEmailNewUserListener::class
        );
    }

    public function test_notification_send(): void
    {
        Notification::fake();
        $this->requestSuccess();

        $user = $this->findUser();
        $event = new Registered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);

        Notification::assertSentTo($user, NewUserNotification::class);
    }

    public function test_auth(): void
    {
        $this->requestSuccess()
            ->assertValid()
            ->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($this->findUser());
    }
}