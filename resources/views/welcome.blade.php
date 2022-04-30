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
        <div class="content">
            <div class="title m-b-md" style="color: #7bc7ff">
                Синий утёс
            </div>

            <div class="links">
                <a href="https://t.me/blue_cliff_bot" target="_blank">Наш телеграм бот</a>
                <a href="{{ route('pages') }}" target="_blank">Модерация страниц</a>
                <a href="{{ route('news') }}" target="_blank">Новости(пример для клиента)</a>
                <a href="{{ route('show.news') }}" target="_blank">Новости(пример для админа)</a>
                <a href="https://adminlte.io/themes/v3/" target="_blank">Admin lte preview</a>
                <a href="https://github.com/Brontoz554?tab=repositories">GitHub</a>
            </div>
        </div>
    </div>

    {!! Form::open(['action' =>'RequestController@callMe', 'method' => 'POST', 'class' => 'container card p-4'])!!}
    <h3>Мы свяжемся с вами сами, если вы заполните форму</h3>
    <div class='form-group required'>
        <label for="subject">Как к вам обращаться?</label>
        {{ Form::text('name', null, ['class' => 'form form-control']) }}
    </div>

    <div class='form-group required'>
        <label for="subject">Ваш номер телефона</label>
        {{ Form::text('number', null, ['class' => 'form form-control', 'placeholder' => "+7 (999) 99 99 999", 'id'=>'phone']) }}
    </div>

    <div class='form-group required'>
        <label for="subject">Комментарий</label>
        {{ Form::textarea('comment', null, ['class' => 'form form-control']) }}
    </div>
    {!! Form::submit('Заказать звонок', ['class' => 'btn btn-dark w-25 mt-3']) !!}
    {!! Form::close() !!}

    <script>
        $(document).ready(function () {
            $("#phone").mask("+7 (999) 999 99 99");
        });
    </script>
@endsection
