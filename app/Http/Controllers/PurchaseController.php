<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Domain\Order\Payment\DTOs\PaymentDTO;
use Domain\Order\Payment\PaymentSystem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class PurchaseController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect(
            PaymentSystem::create(
                new PaymentDTO()
            )->url()
        );
    }

    public function callback(): JsonResponse
    {
        return PaymentSystem::validate()
            ->response();
    }
}
