@extends('layouts.adminLayout')
@section('content')
    <div class="container">
        {!! Form::open(['action' =>'PagesController@store', 'method' => 'POST', 'class' => 'container card p-4'])!!}

        <div class='form-group required'>
            <label for="subject">Название страницы</label>
            {{ Form::text('pageName', null, ['class' => 'form form-control']) }}
            <div class="text-muted">
                Если название страницы openDay, то страница будет доступна по ссыке /open_day
            </div>
        </div>
        <div class="form-group required">
            <label>Контент</label>
            <textarea name="content" id="summernote" rows="30" class="col-12">

            </textarea>
        </div>
        {!! Form::submit('Опубликовать страницу', ['class' => 'btn btn-dark w-25 mt-5']) !!}
        {!! Form::close() !!}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <script>
        $(document).ready(function () {
            $('#summernote').summernote();
        });
    </script>
@endsection
