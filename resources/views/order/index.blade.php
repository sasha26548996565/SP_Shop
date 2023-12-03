@extends('layouts.app')

@section('title', 'Заказы')

@section('content')

    <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4 mb-6">
        <li><a href="{{ route('home') }}" class="text-body hover:text-pink text-xs">Главная</a></li>
        <li><a href="{{ route('cart') }}" class="text-body hover:text-pink text-xs">Корзина покупок</a></li>
        <li><span class="text-body text-xs">Оформление заказа</span></li>
    </ul>

    <section>
        <!-- Section heading -->
        <h1 class="mb-8 text-lg lg:text-[42px] font-black">Оформление заказа</h1>

        <form class="grid xl:grid-cols-3 items-start gap-6 2xl:gap-8 mt-12">

            <!-- Contact information -->
            <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                <h3 class="mb-6 text-md 2xl:text-lg font-bold">Контактная информация</h3>
                <div class="space-y-3">
                    <x-forms.text-input type="text" name="customer[first_name]" placeholder="Имя" required
                        value="{{ old('customer.first_name') }}" :isError="$errors->has('customer.first_name')">
                    </x-forms.text-input>

                    @error('customer.first_name')
                        <x-forms.error>
                            {{ $message }}
                        </x-forms.error>
                    @enderror

                    <x-forms.text-input type="text" name="customer[last_name]" placeholder="Фамилия" required
                        value="{{ old('customer.last_name') }}" :isError="$errors->has('customer.last_name')">
                    </x-forms.text-input>

                    @error('customer.last_name')
                        <x-forms.error>
                            {{ $message }}
                        </x-forms.error>
                    @enderror

                    <x-forms.text-input type="text" name="customer[phone]" placeholder="Номер телефона" required
                        value="{{ old('customer.phone') }}" :isError="$errors->has('customer.phone')">
                    </x-forms.text-input>

                    @error('customer.phone')
                        <x-forms.error>
                            {{ $message }}
                        </x-forms.error>
                    @enderror

                    <x-forms.text-input type="text" name="customer[email]" placeholder="E-mail" required
                        value="{{ old('customer.email') }}" :isError="$errors->has('customer.email')">
                    </x-forms.text-input>

                    @error('customer.email')
                        <x-forms.error>
                            {{ $message }}
                        </x-forms.error>
                    @enderror

                    @guest
                        <div x-data="{ createAccount: false }">
                            <div class="py-3 text-body">Вы можете создать аккаунт после оформления заказа</div>
                            <div class="form-checkbox">
                                <input type="checkbox" name="create_account" @checked(old('create_account'))
                                    id="checkout-create-account" value="1">
                                <label for="checkout-create-account" class="form-checkbox-label"
                                    @click="createAccount = ! createAccount">Зарегистрировать аккаунт</label>
                            </div>
                            <div x-show="createAccount" x-transition:enter="ease-out duration-300"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0" class="mt-4 space-y-3">

                                <x-forms.text-input type="password" name="password" placeholder="Придумайте пароль" required
                                    :isError="$errors->has('password')"></x-forms.text-input>

                                @error('password')
                                    <x-forms.error>
                                        {{ $message }}
                                    </x-forms.error>
                                @enderror

                                <x-forms.text-input type="password" name="password_confirmation" placeholder="Повторите пароль"
                                    required :isError="$errors->has('password_confirmation')"></x-forms.text-input>

                                @error('password_confirmation')
                                    <x-forms.error>
                                        {{ $message }}
                                    </x-forms.error>
                                @enderror
                            </div>
                        </div>
                    @endguest
                </div>
            </div>

            <!-- Shipping & Payment -->
            <div class="space-y-6 2xl:space-y-8">

                <!-- Shipping-->
                <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                    <h3 class="mb-6 text-md 2xl:text-lg font-bold">Способ доставки</h3>
                    <div class="space-y-5">
                        @foreach ($deliveryTypes as $deliveryType)
                            <div class="space-y-3">
                                <div class="form-radio">
                                    <input type="radio" name="delivery_type_id" value="{{ $deliveryType->id }}"
                                        id="delivery-type-{{ $deliveryType->id }}" @checked($loop->first || old('delivery_type_id') == $deliveryType->id)>
                                    <label for="delivery-type-{{ $deliveryType->id }}"
                                        class="form-radio-label">{{ $deliveryType->title }}</label>
                                </div>
                                @if ($deliveryType->with_address)
                                    <x-forms.text-input type="text" name="customer[city]" placeholder="Город" required
                                        :isError="$errors->has('customer.city')"></x-forms.text-input>

                                    @error('customer.city')
                                        <x-forms.error>
                                            {{ $message }}
                                        </x-forms.error>
                                    @enderror

                                    <x-forms.text-input type="text" name="customer[address]" placeholder="Адрес" required
                                        :isError="$errors->has('customer.address')"></x-forms.text-input>

                                    @error('customer.address')
                                        <x-forms.error>
                                            {{ $message }}
                                        </x-forms.error>
                                    @enderror
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Payment-->
                <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                    <h3 class="mb-6 text-md 2xl:text-lg font-bold">Метод оплаты</h3>
                    <div class="space-y-5">
                        @foreach ($paymentMethods as $paymentMethod)
                            <div class="form-radio">
                                <input type="radio" name="payment_method_id" id="payment-method-{{ $paymentMethod->id }}"
                                    value="{{ $paymentMethod->id }}" @checked($loop->first || old('payment_method_id') == $paymentMethod->id)>
                                <label for="payment-method-{{ $paymentMethod->id }}"
                                    class="form-radio-label">{{ $paymentMethod->title }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Checkout -->
            <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                <h3 class="mb-6 text-md 2xl:text-lg font-bold">Заказ</h3>
                <table class="w-full border-spacing-y-3 text-body text-xxs text-left" style="border-collapse: separate">
                    <thead class="text-[12px] text-body uppercase">
                        <th scope="col" class="pb-2 border-b border-body/60">Товар</th>
                        <th scope="col" class="px-2 pb-2 border-b border-body/60">К-во</th>
                        <th scope="col" class="px-2 pb-2 border-b border-body/60">Сумма</th>
                    </thead>
                    <tbody>
                        @each('order.shared.item', $items, 'item')
                    </tbody>
                </table>
                <div class="text-xs font-semibold text-right">Всего: {{ cart()->getTotalPrice() }} ₽</div>

                <div class="mt-8 space-y-8">
                    <!-- Promocode -->
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <input type="text"
                                class="grow w-full h-[56px] px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition"
                                placeholder="Промокод" required>
                            <button type="submit" class="shrink-0 w-14 !h-[56px] !px-0 btn btn-purple">→</button>
                        </div>
                        <div class="space-y-3">
                            <div class="px-4 py-3 rounded-lg bg-[#137d3d] text-xs">Промокод <a href="#"
                                    class="mx-2 py-0.5 px-1.5 rounded-md border-dashed border-2 text-white hover:text-white/70 text-xs"
                                    title="Удалить промокод">&times; leeto15</a> успешно добавлен.</div>
                            <!-- <div class="px-4 py-3 rounded-lg bg-[#b91414] text-xs">Промокод <b>leeto15</b> удалён.</div> -->
                            <!-- <div class="px-4 py-3 rounded-lg bg-[#b91414] text-xs">Промокод <b>leeto15</b> не найден.</div> -->
                        </div>
                    </div>

                    <!-- Summary -->
                    <table class="w-full text-left">
                        <tbody>
                            <tr>
                                <th scope="row" class="pb-2 text-xs font-medium">Доставка:</th>
                                <td class="pb-2 text-xs">600 ₽</td>
                            </tr>
                            <tr>
                                <th scope="row" class="pb-2 text-xs font-medium">Промокод:</th>
                                <td class="pb-2 text-xs">15 398 ₽</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-md 2xl:text-lg font-black">Итого:</th>
                                <td class="text-md 2xl:text-lg font-black">{{ cart()->getTotalPrice() }} ₽</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Process to checkout -->
                    <button type="submit" class="w-full btn btn-pink">Оформить заказ</button>
                </div>
            </div>

        </form>
    </section>
@endsection