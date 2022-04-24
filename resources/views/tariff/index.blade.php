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
                <th>Лечение</th>
                <th>Питание</th>
                <th>Проживание</th>
                <th>Расчётный тип</th>
                <th>Доп.услуги</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($tariff as $obj)
                <tr id="{{ $obj->id }}">
                    <td>
                        <input type="text" class="type-name form form-control" value="{{ $obj->name }}" name="name">
                    </td>
                    <td>
                        <input type="text" class="type-name form form-control" value="{{ $obj->price }}" name="price">
                    </td>
                    <td>
                        @if($obj->treatment)
                            @foreach($obj->treatments as $treatment)
                                <div>{{ $treatment->name }}</div>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if($obj->nutrition)
                            @foreach($obj->eatings as $eat)
                                <div>{{ $eat->name }}</div>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if($obj->accommodation)
                            <div>Проживание включено</div>
                        @endif
                    </td>
                    <td>{{ $obj->type_of_day }}</td>
                    <td>
                        @if($obj->nutrition)
                            @foreach($obj->services as $service)
                                <div>{{ $service->name }}</div>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-default" href="{{ route('destroy.tariff', $obj->id) }}">Удалить</a>
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
                    url: "{{ route('edit.tariff') }}",
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
