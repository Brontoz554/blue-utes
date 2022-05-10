@extends("layouts.adminLayout")
@section("title", "Бронирования")
@section("content")
    <a class="btn btn-secondary mb-3" href="{{ route('booking') }}">Добавить бронирование</a>
    <div class="container">
        {{--        {{ $json }}--}}
        {{--                @foreach ($roomTypes as $roomType)--}}
        {{--                    <div class="card p-3">--}}
        {{--                        <b>название типа номера</b>--}}
        {{--                        <div>{{ $roomType->name }}</div>--}}
        {{--                        <hr>--}}
        {{--                        @foreach ($roomType->rooms as $room)--}}
        {{--                            <b>название комнаты</b>--}}
        {{--                            <div>{{ $room->number }}</div>--}}
        {{--                            <hr>--}}
        {{--                            @foreach ($room->bookings as $booking)--}}
        {{--                                <b>информация о бронировании</b>--}}
        {{--                                <div>{{ $booking }}</div>--}}
        {{--                                <b>информация о клиенте</b>--}}
        {{--                                <div>{{ $booking->client }}</div>--}}
        {{--                                <b>информация о тарифе</b>--}}
        {{--                                <div>{{ $booking->tariff }}</div>--}}
        {{--        вытащить связи у (сервисов, питания,мед.услуг) тарифа resources/views/management-system/tariff/index.blade.php 31 строка--}}
        {{--                                <hr>--}}
        {{--                            @endforeach--}}
        {{--                        @endforeach--}}
        {{--                    </div>--}}
        {{--                @endforeach--}}
    </div>
    <div class="w-100" style="overflow: auto">
        <h3 class="p-2">Бронирования</h3>
        <table class="table table-bordered table-striped dataTable dtr-inline" id="bookings">
            <thead>
            <tr>
                <th>
                    Номер комнаты
                </th>
                <th>
                    Информация о бронировании
                </th>
                <th>Информация о клиенте</th>
                <th>Предоставляемые услуги в рамках тарифа</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($roomTypes as $roomType)
                @foreach ($roomType->rooms as $room)
                    @foreach ($room->bookings as $booking)
                        <tr class="odd">
                            <td>{{ $room->number }} <span class="text-muted">{{ $roomType->name }}</span>
                            </td>
                            <td>
                                <div>
                                    <b>Заезд: </b>
                                    {{ $booking->date_start }} : {{ $booking->time_start }}
                                </div>
                                <div>
                                    <b>Выезд:</b>
                                    {{ $booking->date_end }} : {{ $booking->time_end }}
                                </div>
                                <div>
                                    <b>Цена с учётом скидки</b>
                                    {{ $booking->price }}
                                    @if($booking->discount > 0)
                                        <span class="text-muted">{{ $booking->discount }} (скидка)</span>
                                    @endif
                                </div>
                                <div>
                                    <b>Взролых: </b> {{ $booking->old }} чел
                                </div>
                                <div>
                                    <b>Детей: </b> {{ $booking->new }} чел
                                </div>
                            </td>
                            <td>
                                <div>{{ $booking->client->name }}</div>
                                <div><span
                                        class="text-muted">Количество посещений:</span> {{ $booking->client->number_of_sessions }}
                                </div>
                                @if(isset($booking->client->comments_about_client))
                                    <div><span
                                            class="text-muted">Комментарии о клиенте: </span> {{ $booking->client->comments_about_client }}
                                    </div>
                                @endif
                            </td>
                            <td class="col-3">
                                <div>
                                    <b>Тариф: </b>{{ $booking->tariff->name }}
                                </div>
                                <p><b>Предоставляемые услуги в рамках тарифа:</b></p>
                                <ul>
                                    @if($booking->tariff->treatment == 'on')
                                        <li>Медецинские услуги</li>
                                        <ol>
                                            @foreach($booking->tariff->treatments as $treatment)
                                                <li>{{ $treatment->name }}</li>
                                            @endforeach
                                        </ol>
                                    @endif

                                    @if($booking->tariff->nutrition == 'on')
                                        <li>Услуги питания</li>
                                        <ol>
                                            @foreach($booking->tariff->eatings as $eat)
                                                <li>{{ $eat->name }}</li>
                                            @endforeach
                                        </ol>
                                    @endif

                                    @if($booking->tariff->another == 'on')
                                        <li>Дополнительные услуги</li>
                                        <ol>
                                            @foreach($booking->tariff->services as $service)
                                                <li>{{ $service->name }}</li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </ul>
                                <div>
                                    <b>Цена за сутки: </b> {{ $booking->tariff->price }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <a class="btn btn-default mb-3" href="{{ route('edit.booking.view', $booking->id) }}">Редактировать</a>

                                    <a class="btn btn-default mb-3"
                                       href="{{ route('edit.nutrition.view', $booking->id) }}">Изменить
                                        рацион</a>

                                    <a class="btn btn-default mb-3" href="{{ route('destroy.booking', $booking->id) }}">Удалить</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function () {
            $('#bookings').DataTable({
                "order": [[0, "asc"]],
                "pageLength": 10,
                "searching": true,
            });
        });
    </script>
@endsection
