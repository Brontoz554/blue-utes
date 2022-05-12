@extends('layouts.adminLayout')
@section('title', 'Виды питания')
@section('content')

    {!! Form::open(['action' =>'EatingController@storeEating', 'method' => 'POST', 'class' => 'container card p-4'])!!}
    <h3>Добавить вид питания</h3>

    <div class='form-group required'>
        <label for="subject">Название</label>
        {{ Form::text('name', null, ['class' => 'form form-control']) }}
        <div class="text-muted">пример: завтрак, обед, ужин</div>
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
    {!! Form::submit('Добавить', ['class' => 'btn btn-dark w-25 mt-3']) !!}

    {!! Form::close() !!}

    <div class="container p-0">
        <h3 class="p-2">Текущие типы</h3>
        <table class="table table-bordered table-striped dataTable dtr-inline"
        >
            <thead>
            <tr>
                <th class="sorting">Название</th>
                <th class="sorting">Цега</th>
                <th class="sorting">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($types as $type)
                <tr class="odd">
                    <td>
                        <input id="{{ $type->id }}" class="type-name form form-control" type="text"
                               value="{{ $type->name }}" name="name" data-target="{{ $type->name }}">
                    </td>
                    <td>
                        <input id="{{ $type->id }}" class="type-name form form-control w-50" type="text"
                               value="{{ $type->price }}" name="price" data-target="{{ $type->price }}">
                    </td>
                    <td>
                        <a class="btn btn-default" href="{{ route('destroy.eating', $type->id) }}">Удалить тип
                            питания</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <script>
        $(".type-name").change(function () {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('edit.eating') }}",
                data: {
                    id: $(this).attr("id"),
                    name: $(this).attr('name'),
                    option: $(this).val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
            });
        });
    </script>
@endsection
