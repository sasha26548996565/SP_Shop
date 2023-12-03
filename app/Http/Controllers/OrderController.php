<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Domain\Order\Models\DeliveryType;
use Domain\Order\Models\PaymentMethod;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $items = cart()->getCartItemsWithoutCache();

        if ($items->isEmpty()) {
            throw new \DomainException('Корзина пуста');
        }

        $deliveryTypes = DeliveryType::select(['id', 'title', 'price', 'with_address'])
            ->get();

        $paymentMethods = PaymentMethod::select(['id', 'title', 'redirect_to_pay'])
            ->get();

        return view('order.index', compact(
            'items',
            'deliveryTypes',
            'paymentMethods'
        ));
    }
}
