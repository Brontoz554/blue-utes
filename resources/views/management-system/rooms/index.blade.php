@extends('layouts.adminLayout')
@section('title', 'Номера')
@section('content')

    <div class="p-0 pt-5">
        <a href="{{ route('create.room.view') }}" class="btn btn-default col-3">
            Создать номер
        </a>
        <h3 class="p-2">Номера</h3>
        <table id="rooms" class="table table-bordered table-striped dataTable dtr-inline">
            <thead>
            <tr>
                <th>Тип номера</th>
                <th>Номер</th>
                <th>Цена за сутки</th>
                <th>Количество спальных мест</th>
                <th>Статус</th>
                <th>Доп. услуги</th>
                <th>Доп. описание</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($rooms as $room)
                <tr id="{{ $room->id }}">
                    <td>{{ $room->type->name }}</td>
                    <td>
                        {{ $room->number }}
                    </td>
                    <td>
                        {{ $room->price }}
                    </td>
                    <td>
                        {{ $room->space }}
                    </td>
                    <td>{{ $room->state }}</td>
                    <td>
                        @if($room->another == 'on')
                            @foreach($room->roomServices as $service)
                                <div>{{ $service->name }}</div>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        {{ $room->description }}
                    </td>
                    <td>
                        <a class="btn btn-default" href="{{ route('destroy.room', $room->id) }}">
                            Удалить номер
                        </a>
                        <a class="btn btn-default" href="{{ route('edit.room.view', $room->id) }}">
                            Редактировать
                        </a>
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
