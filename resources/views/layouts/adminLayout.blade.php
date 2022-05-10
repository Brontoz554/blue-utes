<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(env('APP_STAND') == 'PROD')
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script
        src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.11.5/b-2.2.2/sl-1.3.4/datatables.min.js"></script>

    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('/js/maskinput/jquery.mask.js') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ asset('/js/maskinput/sinon-1.10.3.js') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ asset('/js/maskinput/sinon-qunit-1.0.0.js') }}" charset="utf-8"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">

    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.11.5/b-2.2.2/sl-1.3.4/datatables.min.css"/>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <style>
        .note-editing-area {
            background: white;
        }
    </style>
</head>
<body>
<div id="app">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Авторизация</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a href="{{ route('home') }}" class="dropdown-item">Админка</a>
                            <a class="dropdown-item"
                               href="{{ route('logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">Выход</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <div
                class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition">
                <div class="os-padding">
                    <div class="os-viewport os-viewport-native-scrollbars-invisible">
                        <div class="os-content">
                            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                                <div class="image">
                                </div>
                                <div class="info">
                                    <a href="#" class="d-block">{{ \Illuminate\Support\Facades\Auth::user()->name }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <h6 href="#content-management" aria-expanded="false" data-bs-toggle="collapse"
                                class="nav-link" style="color: #d0d4db !important; cursor: pointer">
                                Система управления контентом сайта
                            </h6>
                            <div class="collapse" id="content-management">
                                <ul class="nav nav-treeview" style="display: block;">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('main') }}">Сайт</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('pages') }}">Модерация страниц</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('show.news') }}">Новости</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://adminlte.io/themes/v3/" target="_blank">Admin
                                            lte
                                            preview</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                           href="https://github.com/Brontoz554?tab=repositories">GitHub</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <h6 href="#system-management" aria-expanded="false" data-bs-toggle="collapse"
                                class="nav-link" style="color: #d0d4db !important; cursor: pointer">
                                Система управления имуществом
                            </h6>
                            <div class="collapse" id="system-management">
                                <ul class="nav nav-treeview" style="display: block;">
                                    <li class="nav-item">
                                        <a href="{{ route('room.type.view') }}" class="nav-link">
                                            <p>Типы номеров</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('treatment.view') }}" class="nav-link">
                                            <p>Список лечебных услуг</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('eating.view') }}" class="nav-link">
                                            <p>Список приёма пищи</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('services.view') }}" class="nav-link">
                                            <p>Список дополнительных услуг для тарифов</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('room.service.view') }}" class="nav-link">
                                            <p>Список дополнительных услуг для номеров</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('room.view') }}" class="nav-link">
                                            <p>Номера</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('tariff') }}" class="nav-link">
                                            <p>Тарифы</p>
                                        </a>
                                    </li>
{{--                                    <li class="nav-item">--}}
{{--                                        <a href="{{ route('booking') }}" class="nav-link">--}}
{{--                                            <p>Добавить бронирование</p>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
                                    <li class="nav-item">
                                        <a href="{{ route('booking.board') }}" class="nav-link">
                                            <p>Бронирования</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('clients') }}" class="nav-link">
                                            <p>Клиенты</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('reception') }}" class="nav-link">
                                            <p>Ресепшн</p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://t.me/blue_cliff_bot" target="_blank">Наш телеграм бот</a>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        <div class="content-wrapper" style="min-height: 100vh;">
            <section class="content pt-3">
                @yield('content')
            </section>
        </div>
    </div>
</div>
</body>
</html>
