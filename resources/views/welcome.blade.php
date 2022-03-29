@extends('layouts.app')
@section('content')
    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
    <div class="flex-center position-ref full-height">
{{--        @if (Route::has('login'))--}}
{{--            <div class="top-right links">--}}
{{--                @auth--}}
{{--                    <a href="{{ route('profile') }}">Мой профиль</a>--}}
{{--                @else--}}
{{--                    <a href="{{ route('login') }}">Вход</a>--}}

{{--                    @if (Route::has('register'))--}}
{{--                        <a href="{{ route('register') }}">Регистрация</a>--}}
{{--                    @endif--}}
{{--                @endauth--}}
{{--            </div>--}}
{{--        @endif--}}

        <div class="content">
            <div class="title m-b-md" style="color: #7bc7ff">
                Синий утёс
            </div>

            <div class="links">
                <a href="https://t.me/blue_cliff_bot" target="_blank">Наш телеграм бот</a>
                <a href="{{ route('news') }}" target="_blank">Новости</a>
                <a href="https://adminlte.io/themes/v3/" target="_blank">Admin lte preview</a>
                <a href="{{ route('summernote') }}">summernote</a>
                <a href="https://github.com/Brontoz554?tab=repositories">GitHub</a>
            </div>
        </div>
    </div>
@endsection
