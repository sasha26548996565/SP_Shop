@extends('layouts.auth')

@section('title', 'Забыли пароль')

@section('content')
    <x-forms.auth-forms title='Забыли пароль' action=''>
        @csrf

        <x-forms.text-input type='email' name='email' :isError="$errors->has('email')" placeholder='Email' required></x-forms.text-input>
        @error('email')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
        @enderror

        <x-forms.primary-button>
            Отправить
        </x-forms.primary-button>

        <x-slot:socialAuth></x-slot:socialAuth>
        <x-slot:buttons>
            <div class="text-xxs md:text-xs"><a href="{{ route('auth.login') }}"
                    class="text-white hover:text-white/70 font-bold">Вспомнил пароль</a></div>
        </x-slot:buttons>
    </x-forms.auth-forms>
@endsection
