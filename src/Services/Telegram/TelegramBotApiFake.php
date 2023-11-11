<?php

declare(strict_types=1);

namespace Services\Telegram;

class TelegramBotApiFake implements TelegramBotApiContract
{
    public static bool $status = true;

    public function returnTrue(): static
    {
        self::$status = true;

        return $this;
    }

    public function returnFalse(): static
    {
        self::$status = false;

        return $this;
    }

    public static function sendMessage(string $token, int $chatId, string $message): bool
    {
        return self::$status;
    }
}
