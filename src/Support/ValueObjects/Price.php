<?php

declare(strict_types=1);

namespace Support\ValueObjects;

use InvalidArgumentException;
use Stringable;
use Support\Traits\Makeable;

final class Price implements Stringable
{
    use Makeable;

    private array $currencies = [
        'RUB' => '₽'
    ];

    public function __construct(
        private readonly int $value,
        private readonly int $precision = 100,
        private readonly string $currency = 'RUB'
    )
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Price must be more than thero');
        }

        if (isset($this->currencies[$this->currency]) == false) {
            throw new InvalidArgumentException('Currency not allowed');
        }
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getValue(): float|int
    {
        return $this->value / $this->precision;
    }

    public function getRawValue(): int
    {
        return $this->value;
    }

    public function getSymbol(): string
    {
        return $this->currencies[$this->currency];
    }

    public function __toString(): string
    {
        return number_format($this->getValue(), 0, ',', ' ') . ' '
            . $this->getSymbol();
    }
}
