@extends('layouts.adminLayout')
@section('title', 'Тарифы')
@section('content')

    <a href="{{ route('create.tariff.view') }}" class="btn btn-secondary mb-3">
        Добавить тариф
    </a>
    <div class="p-0">
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
                <th>Тип тарифа</th>
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
                        @if($obj->prepayment)
                            <div>Предоплата: <b>{{ $obj->prepayment }}</b></div>
                        @endif
                        @if($obj->hour)
                            <div>Бесплатная отмена за <b>{{ $obj->hour }}</b> часа(ов) до заезда</div>
                        @endif
                        @if($obj->fine)
                            <div>штраф за позднюю отмену: <b>{{ $obj->fine }}</b></div>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex flex-column">
                            <a class="btn btn-default" href="{{ route('destroy.tariff', $obj->id) }}">Удалить</a>
                            <a class="btn btn-default" href="{{ route('edit.tariff.view', $obj->id) }}">Редактировать</a>
                        </div>
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
