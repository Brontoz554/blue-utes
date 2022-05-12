@extends('layouts.adminLayout')
@section('title', 'Данные клиентов')
@section('content')

    <div>
        <h3 class="p-2">Клиенты</h3>
        <table id="rooms" class="table table-bordered table-striped dataTable dtr-inline">
            <thead>
            <tr>
                <th class="col-3">Имя</th>
                <th>Номер телефона</th>
                <th>почтовый ящик</th>
                <th>Паспортные данные</th>
                <th>Количество посещений</th>
                <th>Комментарии о клиенте</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clients as $client)
                <tr id="{{ $client->id }}">
                    <td>
                        <input name="name" type="text" class="form form-control attribute" value="{{ $client->name }}">
                        {{--                    {{ $client->name }}--}}
                    </td>
                    <td>
                        <input name="number" type="text" class="form form-control attribute"
                               value="{{ $client->number }}">
                        {{--                    {{ $client->number }}--}}
                    </td>
                    <td>
                        <input name="mail" type="text" class="form form-control attribute" value="{{ $client->mail }}">
                        {{--                        {{ $client->mail }}--}}
                    </td>
                    <td>
                        <div>серия:
                            <input type="text" name="serial" value="{{ $client->serial }}" class="form form-control">
                            {{--                            {{ $client->serial }}--}}
                        </div>
                        <div>номер:
                            <input type="text" name="passport_number" value="{{ $client->passport_number }}" class="form form-control">
                            {{--                            {{ $client->passport_number }}--}}
                        </div>
                        <div>дата регистрации:
                            <input type="date" name="passport_data" value="{{ $client->passport_data }}" class="form form-control">
                            {{--                            {{ $client->passport_data }}--}}
                        </div>
                    </td>
                    <td>{{ $client->number_of_sessions }}</td>
                    <td>
                        <textarea class="form form-control attribute" name="comments_about_client"
                                  id="comments_about_client"
                                  cols="30" rows="5">{{ $client->comments_about_client }}</textarea>
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

        $(".attribute").change(function () {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('edit.client') }}",
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
        });
        $(".form.form-control.col-6").change(function () {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('edit.client') }}",
                data: {
                    id: $(this).parent().parent().parent().attr("id"),
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
        });

    </script>
@endsection
