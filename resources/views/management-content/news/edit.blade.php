@extends('layouts.adminLayout')
@section("title", "Редактировать новость")
@section('content')
    @if (session()->has('message'))
        <div class="d-flex justify-content-end">
            <div class="alert alert-success w-25">
                {{ session('message') }}
            </div>
        </div>
    @endif
    {!! Form::open(['action' =>'NewsController@edit', 'method' => 'POST', 'class' => 'container card p-4', "enctype"=>"multipart/form-data"])!!}
    @csrf
    <input type="hidden" id="id" name="id" value="{{ $news->id }}">
    <div class='form-group required'>
        <label for="subject">Заголовок</label>
        {!! Form::text('subject', $news->subject, ['class' => 'form form-control', 'placeholder' => 'Заголовок']) !!}
        @error('subject')
        <div class="text-danger">Заголовок обязателен для заполнения</div>
        @enderror
    </div>
    <div class='form-group required'>
        <label for="subject">Контент</label>
        {!! Form::textarea('content', $news->content, ['class' => 'form form-control', 'placeholder' => 'Контент']) !!}
        @error('news_content')
        <div class="text-danger">Контент новости обязателен для заполнения</div>
        @enderror
    </div>
    <div class='form-group required'>
        <label>Текущее изображение</label>
        <br>
        <img src="../storage/{{ $news->image }}" alt="news image" width="200" height="200">
        <br>
        <label for="subject">Загрузить новое</label>
        <br>
        {!! Form::file('image', null, ['class' => 'form form-control']) !!}
        @error('image')
        <div class="text-danger">Вы забыли загрузить изображение</div>
        @enderror
    </div>
    <div class='form-group required'>
        <label for="subject">Ссылка на страницу</label>
        {!! Form::text('link', $news->link, ['class' => 'form form-control', 'placeholder' => 'ссылка на страницу']) !!}
        @error('link')
        <div class="text-danger">ссылка обязательна для заполнения и должна быть валидна (https:\\example.com)</div>
        @enderror
    </div>
    {!! Form::submit('Опубликовать изменения', ['class' => 'btn btn-dark w-25']) !!}

    {!! Form::close() !!}

    <script>
        if ($('.alert.alert-success.w-25').is(':visible')) {
            setInterval(() => {
                $('.alert.alert-success.w-25').hide(300)
            }, 5000)
        }
    </script>
@endsection
