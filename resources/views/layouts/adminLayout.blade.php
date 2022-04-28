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
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('plugins/jquery/ui-min.js')}}"></script>
    <script src="{{asset('plugins/bootstrap/bundle.min.js')}}"></script>
    <script src="{{asset('plugins/chart/chart.min.js')}}"></script>
    <script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
    <script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{asset('plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.11.5/b-2.2.2/sl-1.3.4/datatables.min.js"></script>
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.11.5/b-2.2.2/sl-1.3.4/datatables.min.css"/>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/summernote/summernote.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/font-awesome.min.css') }}">
    <style>
        .note-editing-area {
            background: white;
        }
    </style>
</head>
<body>
<div id="app">
    <div class="wrapper">
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
                            <h6 class="nav-link" style="color: #d0d4db !important; cursor: pointer">
                                Администрирование контента
                                <i class="right fa fa-angle-left"></i>
                            </h6>
                            <ul class="nav nav-treeview">
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
                                    <a class="nav-link" href="https://adminlte.io/themes/v3/" target="_blank">Admin lte
                                        preview</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('summernote') }}">summernote</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="https://github.com/Brontoz554?tab=repositories">GitHub</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item menu-is-opening menu-open">
                            <h6 class="nav-link" style="color: #d0d4db !important; cursor: pointer">
                                Система управления
                                <i class="right fa fa-angle-left"></i>
                            </h6>
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
                                <li class="nav-item">
                                    <a href="{{ route('booking') }}" class="nav-link">
                                        <p>Добавить бронирование</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('booking.board') }}" class="nav-link">
                                        <p>Шахматка</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('clients') }}" class="nav-link">
                                        <p>Клиенты</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://t.me/blue_cliff_bot" target="_blank">Наш телеграм бот</a>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        <div class="content-wrapper" style="min-height: 842px;">
            <section class="content pt-3">
                @yield('content')
            </section>
        </div>
    </div>
</div>
</body>
</html>
