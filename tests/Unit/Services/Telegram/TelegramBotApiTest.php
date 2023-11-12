<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Telegram;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Services\Telegram\TelegramBotApi;
use Services\Telegram\TelegramBotApiContract;

final class TelegramBotApiTest extends TestCase
{
    public function test_message_send_success(): void
    {
        Http::fake([
            TelegramBotApi::HOST . '*' => Http::response(['OK' => true])
        ]);

        $result = TelegramBotApi::sendMessage('', 1, 'Test');
        $this->assertTrue($result);
    }

    public function test_message_send_success_by_fake(): void
    {
        TelegramBotApi::fake()
            ->returnTrue();

        $result = app(TelegramBotApiContract::class)::sendMessage('', 1, 'Test message');
        $this->assertTrue($result);
    }

    public function test_message_send_fail_by_fake(): void
    {
        TelegramBotApi::fake()
            ->returnFalse();

        $result = app(TelegramBotApiContract::class)::sendMessage('', 1, 'TestMessage');
        $this->assertFalse($result);
    }
}