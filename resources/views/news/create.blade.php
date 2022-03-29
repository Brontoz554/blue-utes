@extends('layouts.app')
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
        <div class="text-danger">Заголовок обязателен для заполнения</div>
        @enderror
    </div>
    <div class='form-group required'>
        <label for="subject">Контент</label>
        {!! Form::textarea('news_content', null, ['class' => 'form form-control', 'placeholder' => 'Контент']) !!}
        @error('news_content')
        <div class="text-danger">Контент новости обязателен для заполнения</div>
        @enderror
    </div>
    <div class='form-group required'>
        <label for="subject">Изображение</label>
        {!! Form::file('image', null, ['class' => 'form form-control']) !!}
        @error('image')
        <div class="text-danger">Вы забыли загрузить изображение</div>
        @enderror
    </div>
    <div class='form-group required'>
        <label for="subject">Ссылка на страницу</label>
        {!! Form::text('link', null, ['class' => 'form form-control', 'placeholder' => 'ссылка на страницу']) !!}
        @error('link')
        <div class="text-danger">ссылка обязательна для заполнения и должна быть валидна (https:\\example.com)</div>
        @enderror
    </div>
    {!! Form::submit('Добавить новость', ['class' => 'btn btn-default']) !!}

    {!! Form::close() !!}

    <script>
        if ($('.alert.alert-success.w-25').is(':visible')) {
            setInterval(() => {
                $('.alert.alert-success.w-25').hide(300)
            }, 5000)
        }
    </script>
@endsection
