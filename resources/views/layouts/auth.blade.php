<!DOCTYPE html>
<html lang="ru">

    <head>
        <meta charset="utf-8">
        <title>@yield('title', $title ?? 'Интернет-магазин')</title>
        <meta name="description" content="Регистрация или вход">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">

        <link rel="apple-touch-icon" sizes="180x180" href="{{ Vite::image('apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ Vite::image('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ Vite::image('favicon-16x16.png') }}">
        <link rel="mask-icon" href="{{ Vite::image('safari-pinned-tab.svg') }}" color="#1E1F43">
        <meta name="msapplication-TileColor" content="#1E1F43">
        <meta name="theme-color" content="#1E1F43">

        @vite(['resources/css/app.css', 'resources/sass/main.sass', 'resources/js/app.js'])
    </head>

    <body>

        <main class="md:min-h-screen md:flex md:items-center md:justify-center py-16 lg:py-20">
            <div class="container">
                <div class="text-center">
                    <a href="{{ route('home') }}" class="inline-block" rel="home">
                        <img src="{{ Vite::image('logo.svg') }}" class="w-[148px] md:w-[201px] h-[36px] md:h-[50px]"
                            alt="SP Shop">
                    </a>
                </div>
                @if ($message = flash()->get())
                    <div class="{{ $message->getClass() }}">
                        {{ $message->getMessage() }}
                    </div>
                @endif
                @yield('content')
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    </body>

</html>
