@extends('layouts.adminLayout')
@section('content')
    @if (session()->has('message'))
        <div class="d-flex justify-content-end">
            <div class="alert alert-success w-25">
                {{ session('message') }}
            </div>
        </div>
    @endif
    <div class="container">
        <a href="{{route('create.page.view')}}" class="btn btn-dark mb-3">Добавить страницу</a>
        <table class="table table-bordered table-hover dataTable dtr-inline collapsed bg-white"
               aria-describedby="example2_info">
            <thead>
            <tr>
                <th>Название</th>
                <th>Контент</th>
                <th>Дата</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pages as $item)
                <tr>
                    <td>
                        <div>{{ $item->name }}</div>
                        <a href="{{ \Illuminate\Support\Str::snake($item->name ) }}">Ссылка на страницу</a>
                    </td>
                    <td class="col-5">{!! $item->content !!}</td>
                    <td class="col-2">{{ $item->created_at }}</td>
                    <td class="col-2">
                        <a href="{{ route('destroy.page', $item->id) }}" class="btn btn-dark mb-3">
                            Удалить
                        </a>
                        <a href="{{ route('edit.page.view', $item->id) }}" class="btn btn-dark">
                            Редактировать
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <script>
        if ($('.alert.alert-success.w-25').is(':visible')) {
            setInterval(() => {
                $('.alert.alert-success.w-25').hide(300)
            }, 5000)
        }
    </script>
@endsection
