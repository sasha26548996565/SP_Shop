<?php

declare(strict_types=1);

namespace Domain\Order\Contracts;

use Domain\Order\DTOs\CustomerDTO;
use Domain\Order\DTOs\OrderDTO;
use Domain\Order\Models\Order;

interface NewOrderContract
{
    public function __invoke(OrderDTO $orderParams, CustomerDTO $customerParams, bool $createAccount): Order;
}
