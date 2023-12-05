<?php

declare(strict_types=1);

namespace Domain\Order\DTOs;

use Support\Traits\Makeable;

class CustomerDTO
{
    use Makeable;

    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $email,
        public string $phone,
        public ?string $city,
        public ?string $address
    ) {
    }

    public function getFullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public static function fromArray(array $params): self
    {
        return self::make(
            $params['first_name'] ?? '',
            $params['last_name'] ?? '',
            $params['email'] ?? '',
            $params['phone'] ?? '',
            $params['city'] ?? '',
            $params['address'] ?? ''
        );
    }
}
