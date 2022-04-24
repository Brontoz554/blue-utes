@extends('layouts.adminLayout')
@section('title', 'Данные клиентов')
@section('content')

    <div class="p-0 pt-5">
        <h3 class="p-2">Клиенты</h3>
        <table id="rooms" class="table table-bordered table-striped dataTable dtr-inline">
            <thead>
            <tr>
                <th class="col-2">Имя</th>
                <th>Номер телефона</th>
                <th class="col-2">почтовый ящик</th>
                <th>Паспортные данные (серия-номер) дата регистрации</th>
                <th>Комментарии о клиенте</th>
                <th>Количество посещений</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clients as $client)
                <tr id="{{ $client->id }}">
                    <td>
                        <input name="name" type="text" class="form form-control attribute" value="{{ $client->name }}">
                    </td>
                    <td>
                        <input name="number" type="text" class="form form-control attribute" value="{{ $client->number }}">
                    </td>
                    <td>
                        <input name="mail" type="text" class="form form-control attribute" value="{{ $client->mail }}">
                    </td>
                    <td>
                        <div class="text-muted">серия:
                            <input type="text" name="serial" value="{{ $client->serial }}"
                                   class="form form-control col-6">
                        </div>
                        <div class="text-muted">номер:
                            <input type="text" name="passport_number" value="{{ $client->passport_number }}"
                                   class="form form-control col-6">
                        </div>
                        <div class="text-muted">дата регистрации:
                            <input type="date" name="passport_data" value="{{ $client->passport_data }}"
                                   class="form form-control col-6">
                        </div>
                    </td>
                    <td>
                        <textarea class="form form-control attribute" name="comments_about_client"
                                  id="comments_about_client"
                                  cols="30" rows="5">{{ $client->comments_about_client }}</textarea>
                    </td>
                    <td>{{ $client->number_of_sessions }}</td>
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
