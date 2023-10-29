<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guest();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email:dns'],
            'password' => ['required', 'string', 'confirmed']
        ];
    }
}