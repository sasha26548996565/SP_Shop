<?php

declare(strict_types=1);

namespace Domain\Order\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Domain\Order\Contracts\NewOrderContract;
use Domain\Order\DTOs\CustomerDTO;
use Domain\Order\DTOs\OrderDTO;
use Domain\Order\Models\Order;

final class NewOrderAction implements NewOrderContract
{
    public function __invoke(OrderDTO $orderParams, CustomerDTO $customerParams, bool $createAccount): Order
    {
        $totalPrice = cart()->getRawTotalPrice();
        if ($createAccount) {
            $registerAction = app(RegisterNewUserContract::class);

            $user = $registerAction(new NewUserDTO(
                $customerParams->getFullName(),
                $customerParams->email,
                $orderParams->password,
            ));
        }

        return Order::create([
            'user_id' => $user?->id ?? auth()?->id(),
            'delivery_type_id' => $orderParams->delivery_type_id,
            'payment_method_id' => $orderParams->payment_method_id,
            'total_price' => $totalPrice,
        ]);
    }
}
