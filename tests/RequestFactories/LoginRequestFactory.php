<?php

namespace Tests\RequestFactories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Worksome\RequestFactories\RequestFactory;

class LoginRequestFactory extends RequestFactory
{
	public function definition(): array
	{
		return [
			'email' => $this->faker->email,
			'password' => Hash::make(Str::random(8))
		];
	}
}