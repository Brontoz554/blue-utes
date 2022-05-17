@extends("layouts.adminLayout")
@section("title", "Рацион клиента ". $booking->client->name)
@section("content")

    <div class="container">
        @if (session()->has('success'))
            <div class="d-flex justify-content-end">
                <div class="alert alert-success w-25">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        <div class="card p-3">
            <h5 class="pt-2 pb-2">Рацион клиента {{ $booking->client->name }}</h5>
            <div>
                <p>Бронирование c <b>{{ $booking->date_start }}</b> по <b>{{ $booking->date_end }}</b></p>
                <p>Время заезда <b>{{ $booking->time_start }}</b>, время выезда <b>{{ $booking->time_end }}</b></p>
            </div>
            <div style="overflow: auto">
                <table class="table table-bordered table-striped dataTable dtr-inline">
                    <thead>
                    <tr>
                        @foreach($booking->nutritious as $nutrition)
                            <th> {{ $nutrition->date }} </th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @foreach($booking->nutritious as $nutrition)
                            <td style="min-width: 150px" data-target="{{ $nutrition->id }}">
                                <div>
                                    порции завтрака: <input class="form form-control nutritious-item"
                                                            type="number"
                                                            data-target="{{ $nutrition->id }}"
                                                            name="breakfast" value="{{ $nutrition->breakfast }}">
                                </div>
                                <div>
                                    порции обеда: <input class="form form-control nutritious-item" type="number"
                                                         name="dinner"
                                                         data-target="{{ $nutrition->id }}"
                                                         value="{{ $nutrition->dinner }}">
                                </div>
                                <div>
                                    порции ужина: <input class="form form-control nutritious-item" type="number"
                                                         name="lunch"
                                                         data-target="{{ $nutrition->id }}"
                                                         value="{{ $nutrition->lunch }}">
                                </div>
                            </td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card p-3">
            @if(count($booking->PaidServiceNutritiousBooking) > 0)

                <h5 class="pt-2 pb-2">Платно добавленый рацион клиента</h5>
                <table class="table table-bordered table-striped dataTable dtr-inline" id="nutritious">
                    <thead>
                    <tr>
                        <th>Название услуги</th>
                        <th>Выставленная цена</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @foreach($booking->PaidServiceNutritiousBooking as $paid)
                            <td data-target="{{ $paid->name }}">
                                <input class="form form-control paid-item" type="text" name="name"
                                       value="{{ $paid->name }}"
                                       id="{{ $paid->id }}">
                            </td>
                            <td data-target="{{ $paid->price }}">
                                <input class="form form-control paid-item" type="text" name="price"
                                       value="{{ $paid->price }}"
                                       id="{{ $paid->id }}">
                            </td>
                            <td>
                                <a class="btn btn-default mb-3"
                                   href="{{ route('destroy.paid.nutritious', $paid->id) }}">Удалить</a>
                            </td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            @else
                <h5 class="pt-2 pb-2">У клиента нет дополнительного платного рациона</h5>
            @endif
        </div>

        {!! Form::open(["action" =>"PaidServiceNutritiousBookingController@store", "method" => "POST", "class" => "container card p-4"])!!}
        <h4>Выставить счёт за дополнительную порцию</h4>

        <input type="hidden" name="bookingId" value="{{ $booking->id }}">

        <div class="form-group required mt-2">
            <label for="name">Название</label>
            <input type="text" name="name" id="name" class="form form-control col-3"
                   placeholder="Дополнительный завтрак">
        </div>

        <div class="form-group required">
            <label for="price">Цена</label>
            <input type="number" name="price" id="price" class="form form-control col-3" placeholder="1000" min="0">
        </div>

        <input type="submit" class="btn btn-secondary col-3" value="Добавить счёт">
        {{ Form::close() }}
    </div>
    <script>
        $(".nutritious-item").change(function () {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('edit.nutrition') }}",
                data: {
                    id: $(this).attr("data-target"),
                    name: $(this).attr('name'),
                    option: $(this).val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
            });
        });

        $('#nutritious').DataTable({
            "order": [[0, "asc"]],
            "pageLength": 10,
            "searching": true,
        });

        $(".paid-item").change(function () {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('editPaidNutritious') }}",
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
