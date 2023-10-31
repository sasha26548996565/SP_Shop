<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Notifications\NewUserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailNewUserListener implements ShouldQueue
{
    public function handle(Registered $event): void
    {
        $event->user->notify(new NewUserNotification());
    }
}