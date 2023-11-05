<?php

declare(strict_types=1);

namespace App\Support\Flash;

final class FlashMessage
{
    public function __construct(private string $message, private string $class)
    {}

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getClass(): string
    {
        return $this->class;
    }
}