<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Telegram;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Services\Telegram\TelegramBotApi;

class TelegramBotApiTest extends TestCase
{
    public function test_message_send_success(): void
    {
        Http::fake([
            TelegramBotApi::HOST . '*' => Http::response(['OK' => true])
        ]);

        $result = TelegramBotApi::sendMessage('', 1, 'Test');
        $this->assertTrue($result);
    }
}