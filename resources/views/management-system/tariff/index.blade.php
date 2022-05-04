@extends('layouts.adminLayout')
@section('title', 'Тарифы')
@section('content')

    <div class="container p-0 pt-5">
        <a href="{{ route('create.tariff.view') }}" class="btn btn-default col-3">
            Добавить тариф
        </a>
        <h3 class="p-2">Тарифы</h3>
        <table id="rooms" class="table table-bordered table-striped dataTable dtr-inline">
            <thead>
            <tr>
                <th>Название тарифа</th>
                <th>Цена за сутки</th>
                <th>расчётный тип</th>
                <th>Типы номеров, которые входят в услуги тарифа</th>
                <th>Лечение</th>
                <th>Питание</th>
                <th>Доп.услуги</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($tariff as $obj)
                <tr id="{{ $obj->id }}">
                    <td>
                        {{ $obj->name }}
                    </td>
                    <td>
                        {{ $obj->price }}
                    </td>
                    <td>
                        {{ $obj->type_of_day }}
                    </td>
                    <td>
                        @foreach($obj->roomTypes as $type)
                            <div>{{ $type->name }}</div>
                        @endforeach
                    </td>
                    <td>
                        @if($obj->treatment == 'on')
                            @foreach($obj->treatments as $treatment)
                                <div>{{ $treatment->name }}</div>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if($obj->nutrition == 'on')
                            @foreach($obj->eatings as $eat)
                                <div>{{ $eat->name }}</div>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if($obj->another == 'on')
                            @foreach($obj->services as $service)
                                <div>{{ $service->name }}</div>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-default" href="{{ route('destroy.tariff', $obj->id) }}">Удалить</a>
                        <a class="btn btn-default" href="{{ route('edit.tariff.view', $obj->id) }}">Редактировать</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function () {
            $('#rooms').DataTable({
                "order": [[0, "asc"]],
                "pageLength": 50,
                "searching": true,
            });
        });
    </script>
@endsection
