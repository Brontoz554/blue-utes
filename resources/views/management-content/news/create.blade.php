@extends('layouts.adminLayout')
@section("title", "Создание новости")
@section('content')
    @if (session()->has('message'))
        <div class="d-flex justify-content-end">
            <div class="alert alert-success w-25">
                {{ session('message') }}
            </div>
        </div>
    @endif
    {!! Form::open(['action' =>'NewsController@store', 'method' => 'POST', 'class' => 'container card p-4', "enctype"=>"multipart/form-data"])!!}
    @csrf
    <div class='form-group required'>
        <label for="subject">Заголовок</label>
        {!! Form::text('subject', null, ['class' => 'form form-control', 'placeholder' => 'Заголовок']) !!}
        @error('subject')
        <div class="text-danger">Поле обязательно для заполнения</div>
        @enderror
    </div>
    <div class='form-group required'>
        <label for="subject">Контент</label>
        {!! Form::textarea('news_content', null, ['class' => 'form form-control', 'placeholder' => 'Контент']) !!}
        @error('news_content')
        <div class="text-danger">Поле обязательно для заполнения</div>
        @enderror
    </div>
    <div class='form-group required'>
        <label for="subject">Изображение</label>
        {!! Form::file('image', null, ['class' => 'form form-control']) !!}
        @error('image')
        <div class="text-danger">Вы забыли загрузить изображение</div>
        @enderror
    </div>
    <div class="d-flex">
        <div class="col-6">
            <div class='form-group required' id="page-name">
                <label for="subject">Название страницы или ссылка на неё</label>
                {!! Form::text('pageName', null, ['class' => 'form form-control', 'placeholder' => 'Название страницы']) !!}
                <div class="text-muted">
                    Если название страницы openDay, то страница будет доступна по ссыке /open_day
                </div>
                @error('pageName')
                <div class="text-danger">Поле обязательно для заполнения и должно содержать одно слово</div>
                @enderror
            </div>
            <div class='form-group required'>
                <label for="subject">Сгенерировать страницу?</label>
                {{ Form::checkbox('checkbox', 'yes', true, ['class' => 'generate-page-question']) }}
                <div class="text-muted">
                    Генерировать страницу нужно в тех случаях, когда новость ссылается на наш сайт
                </div>
            </div>
        </div>
{{--        <div class="col-6">--}}
{{--            <div class='form-group required' id="link-on-another-site"--}}
{{--                --}}{{--         style="display: none"--}}
{{--            >--}}
{{--                <label for="subject">Ссылка на страницу</label>--}}
{{--                {!! Form::text('link', null, ['class' => 'form form-control', 'placeholder' => 'ссылка на страницу']) !!}--}}
{{--                @error('link')--}}
{{--                <div class="text-danger">Ссылка обязательна для заполнения и быть валидна (https:\\example.com)</div>--}}
{{--                @enderror--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::submit('Добавить новость', ['class' => 'btn btn-dark w-25']) !!}
    {!! Form::close() !!}
    <script>
        if ($('.alert.alert-success.w-25').is(':visible')) {
            setInterval(() => {
                $('.alert.alert-success.w-25').hide(300)
            }, 5000)
        }
        // $('.generate-page-question').click(function () {
        //     if (!$(this).is(':checked')) {
        //         $('#link-on-another-site').show(300)
        //         $('#page-name').hide(300)
        //     } else {
        //         $('#link-on-another-site').hide(300)
        //         $('#page-name').show(300)
        //     }
        // });
    </script>
@endsection
