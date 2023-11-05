<?php

namespace Tests\RequestFactories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Worksome\RequestFactories\RequestFactory;

class SignUpRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => Hash::make(Str::random(8))
        ];
    }
}