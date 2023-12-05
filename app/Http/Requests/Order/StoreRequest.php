<?php

declare(strict_types=1);

namespace App\Http\Requests\Order;

use Domain\Order\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer.first_name' => ['required', 'string'],
            'customer.last_name' => ['required', 'string'],
            'customer.email' => ['required', 'email:dns'],
            'customer.phone' => ['required', new PhoneRule()],
            'customer.city' => ['sometimes'],
            'customer.address' => ['sometimes'],
            'create_account' => ['boolean'],
            'password' => $this->boolean('create_account')
                ? ['required', 'confirmed', Password::defaults()]
                : ['sometimes'],
            'delivery_type_id' => ['required', 'exists:delivery_types,id'],
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
        ];
    }
}
