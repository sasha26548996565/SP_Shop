<?php

declare(strict_types=1);

namespace App\Logging\Telegram;

use Monolog\Logger;
use Monolog\LogRecord;
use App\Services\Telegram\TelegramBotApi;
use Monolog\Handler\AbstractProcessingHandler;

final class TelegramLoggerHandler extends AbstractProcessingHandler
{
    private int $chatId;
    private string $token;

    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);
        $this->chatId = (int) $config['chat_id'];
        $this->token = $config['token'];

        parent::__construct($level);
    }

    protected function write(LogRecord $record): void
    {
        TelegramBotApi::sendMessage($this->token, $this->chatId, $record->message);
    }
}
