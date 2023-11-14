<?php

declare(strict_types=1);

namespace Tests\Unit\Support\ValueObjects;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Support\ValueObjects\Price;

class PriceTest extends TestCase
{
    private Price $price;
    
    private function setPrice(mixed $price): void
    {
        $this->price = Price::make($price);
    }

    public function test_instance(): void
    {
        $this->setPrice(10000);

        $this->assertInstanceOf(Price::class, $this->price);
    }

    public function test_equals_params(): void
    {
        $this->setPrice(10000);

        $this->assertEquals(100, $this->price->getValue());
        $this->assertEquals(10000, $this->price->getRawValue());
        $this->assertEquals('RUB', $this->price->getCurrency());
        $this->assertEquals('₽', $this->price->getSymbol());
        $this->assertEquals('100 ₽', $this->price->__toString());
    }

    public function test_invalid_params(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        $this->setPrice(-10000, 'USD');
    }
}
