<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-left"></div>

            <div class="header-center">
                <a class="header__logo" href="/">
                    FashionablyLate
                </a>
            </div>

            <div class="header-right">
                <nav class="header-nav">
                    <ul class="header-link">
                        @if (Auth::check())
                        <li class="header-nav__item">
                            <form action="/admin" method="post">
                                @csrf
                                <button class="header-nav__button" type="submit">logout</button>
                            </form>
                        </li>
                        @elseif (Request::is('login'))
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="/register">register</a>
                        </li>
                        @elseif (Request::is('register'))
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="/login">login</a>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>