@extends('layouts.adminLayout')
@section("title", "Редактирование контента")
@section('content')
    <div class="container">
        {!! Form::open(['action' =>'PagesController@edit', 'method' => 'POST', 'class' => 'container card p-4', "enctype"=>"multipart/form-data"])!!}
        <input type="hidden" name="id" value="{{ $page->id }}">
        <textarea name="content" id="summernote" rows="30" class="col-12">
                {{ $page->content }}
            </textarea>
        {!! Form::submit('Опубликовать изменения', ['class' => 'btn btn-dark w-25 mt-5']) !!}
        {!! Form::close() !!}
    </div>
    <script>
        $(document).ready(function () {
            $('#summernote').summernote();
        });
    </script>
@endsection
