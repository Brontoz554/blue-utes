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
    <!-- Scripts -->
    <script src="{{ asset('/js/app.js') }}"></script>

    <script src="{{ asset('/js/popper.min.js') }}"></script>

    <script src="{{ asset('/js/jquery.clim.min.js') }}"></script>

    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('/summernote/summernote.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>

    <!-- datatables -->
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.11.5/b-2.2.2/sl-1.3.4/datatables.min.js"></script>

    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.11.5/b-2.2.2/sl-1.3.4/datatables.min.css"/>
    {{--    <link rel="stylesheet" type="text/css" href="Editor-2.0.7/css/editor.dataTables.css">--}}

<!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{--    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">--}}
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
                        <li class="nav-header"><h5>Администрирование контента</h5></li>
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
                        <li class="nav-header"><h5>Система управления</h5></li>
                        <li class="nav-item">
                            <a href="{{ route('room.type.view') }}" class="nav-link">
                                <p>Типы номеров</p>
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
                            <a href="iframe.html" class="nav-link">
                                <p>Добавить бронирование</p>
                            </a>
                        </li>
                        <li class="nav-header"><h5>Дополнительно</h5></li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://t.me/blue_cliff_bot" target="_blank">Наш телеграм бот</a>
                        </li>
                    </ul>
                </div>
                <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
                    <div class="os-scrollbar-track">
                        <div class="os-scrollbar-handle"
                             style="height: 66.1516%; transform: translate(0px, 0px);"></div>
                    </div>
                </div>
                <div class="os-scrollbar-corner"></div>
            </div>

        </aside>

        <div class="content-wrapper" style="min-height: 842px;">

            <section class="content pt-3">
                @yield('content')
            </section>

        </div>

        <aside class="control-sidebar control-sidebar-dark" style="display: none; top: 57px; height: 899px;">
            <div
                class="p-3 control-sidebar-content os-host os-theme-light os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-scrollbar-vertical-hidden os-host-transition">
                <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
                    <div class="os-scrollbar-track">
                        <div class="os-scrollbar-handle" style="transform: translate(0px, 0px);"></div>
                    </div>
                </div>
                <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-unusable os-scrollbar-auto-hidden">
                    <div class="os-scrollbar-track">
                        <div class="os-scrollbar-handle" style="transform: translate(0px, 0px);"></div>
                    </div>
                </div>
                <div class="os-scrollbar-corner"></div>
            </div>
        </aside>

        <div id="sidebar-overlay"></div>
    </div>
</div>
</body>
</html>
