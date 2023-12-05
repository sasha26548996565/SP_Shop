<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreRequest;
use Domain\Order\Contracts\NewOrderContract;
use Domain\Order\DTOs\CustomerDTO;
use Domain\Order\DTOs\NewOrderDTO;
use Domain\Order\DTOs\OrderDTO;
use Domain\Order\Models\DeliveryType;
use Domain\Order\Models\PaymentMethod;
use Illuminate\Http\RedirectResponse;
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

    public function handle(StoreRequest $request, NewOrderContract $action): RedirectResponse
    {
        $action(
            OrderDTO::fromRequest($request),
            CustomerDTO::fromArray($request->input('customer')),
            $request->boolean('create_account')
        );
        return to_route('home');
    }
}
