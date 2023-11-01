<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'AAP Shop')</title>

    @vite(['resources/css/app.css', 'resources/sass/main.sass', 'resources/js/app.js'])
</head>

<body>
    @auth
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            @method('DELETE')

            <input type="submit" value="Выйти" style="cursor: pointer;">
        </form>
    @endauth
</body>

</html>
