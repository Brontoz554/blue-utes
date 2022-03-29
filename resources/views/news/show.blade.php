@extends('layouts.app')
@section('content')
    @if (session()->has('message'))
        <div class="d-flex justify-content-end">
            <div class="alert alert-success w-25">
                {{ session('message') }}
            </div>
        </div>
    @endif
    <div class="container">
        <a href="{{route('create.news.view')}}" class="btn btn-dark mb-3">Добавить новость</a>

        <table class="table table-bordered table-hover dataTable dtr-inline collapsed bg-white"
               aria-describedby="example2_info">
            <thead>
            <tr>
                <th>
                    Автор
                </th>
                <th>
                    Заголовок
                </th>
                <th>
                    Контент
                </th>
                <th>
                    Картинка
                </th>
                <th>
                    ссылка
                </th>
                <th>Дата</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                @foreach($news as $item)
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->subject }}</td>
                    <td class="col-2">{{ \Illuminate\Support\Str::limit($item->content) }}</td>
                    <td><img src="storage\{{ $item->image }}" alt="news image" width="200" height="200"></td>
                    <td>{{ $item->link }}</td>
                    <td class="col-2">{{ $item->created_at }}</td>
                    <td class="col-2">
                        <a href="{{ route('destroy.news', $item->id) }}" class="btn btn-dark mb-3">
                            Удалить
                        </a>
                        <a href="{{ route('edit.news.view', $item->id) }}" class="btn btn-dark">
                            Редактировать
                        </a>
                    </td>
                @endforeach
            </tr>
            </tbody>
        </table>
    </div>
    {{--    {{ $news }}--}}
@endsection
