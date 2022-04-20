@extends('layouts.adminLayout')
@section('title', 'Номера')
@section('content')

    <div class="container p-0 pt-5">
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
                <th>Доп.Описание</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($rooms as $room)
                <tr id="{{ $room->id }}">
                    <td>{{ $room->type->name }}</td>
                    <td>
                        <input type="text" class="type-name form form-control" value="{{ $room->number }}" name="number">
                    </td>
                    <td>
                        <input type="text" class="type-name form form-control" value="{{ $room->price }}" name="price">
                    </td>
                    <td>
                        <input type="text" class="type-name form form-control" value="{{ $room->space }}" name="space">
                    </td>
                    <td>{{ $room->state }}</td>
                    <td>
                        <textarea type="text" class="type-name form form-control"
                                  name="description">{!! $room->description !!}</textarea>
                    </td>
                    <td>
                        <a class="btn btn-default" href="{{ route('destroy.room', $room->id) }}">Удалить номер</a>
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

        let oldValue

        $(".type-name").focus(function () {
            oldValue = $(this).val()
        });

        $(".type-name").blur(function () {
            if (oldValue !== $(this).val()) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('edit.room') }}",
                    data: {
                        id: $(this).parent().parent().attr("id"),
                        name: $(this).attr('name'),
                        option: $(this).val(),
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function () {
                        $('.toast-top-right.success-message').show(300)
                        setTimeout(() => {
                            $('.toast-top-right.success-message').hide(300)
                        }, 4000)
                    },
                    error: function () {
                        $('.toast-top-right.error-message').show()
                        setTimeout(() => {
                            $('.toast-top-right.error-message').hide(300)
                        }, 4000)
                    }
                });
            }
        });

    </script>
@endsection
