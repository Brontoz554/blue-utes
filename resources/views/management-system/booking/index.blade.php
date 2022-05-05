@extends("layouts.adminLayout")
@section("title", "шахматка")
@section("content")
    <a class="btn btn-secondary mb-3" href="{{ route('booking') }}">Добавить бронирование</a>
    <div class="container">
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
        <table class="table table-bordered table-striped dataTable dtr-inline">
            <thead>
            <tr>
                <th>
                    Номер комнаты
                </th>
                <th>
                    Информация о бронировании
                </th>
                <th>информация о клиенте</th>
                <th>информация о тарифе</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($roomTypes as $roomType)
                @foreach ($roomType->rooms as $room)
                    @foreach ($room->bookings as $booking)
                        <tr class="odd">
                            <td class="col-3">{{ $room->number }} <span class="text-muted">{{ $roomType->name }}</span>
                            </td>
                            <td class="col-3">
                                <div>
                                    <b>заезд</b>
                                    <br>
                                    {{ $booking->date_start }} : {{ $booking->time_start }}
                                </div>
                                <div>
                                    <b>выезд</b>
                                    <br>
                                    {{ $booking->date_end }} : {{ $booking->time_end }}
                                </div>
                                <div>
                                    <b>Цена с учётом скидки</b>
                                    <br>
                                    {{ $booking->price }}
                                    @if($booking->discount > 0)
                                        <span class="text-muted">{{ $booking->discount }} (скидка)</span>
                                    @endif
                                    @if($booking->accommodation)
                                        <div class="text-muted">Проживание входит в стоимость</div>
                                    @endif
                                </div>
                            </td>
                            <td class="col-3">
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
                                {{--                                <div>{{ $booking->tariff }}</div>--}}
                                <div>
                                    <b>Тариф {{ $booking->tariff->name }}</b>
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
                            </td>
                            <td>
                                <a class="btn btn-secondary mb-3" href="{{ route('edit.booking', $booking->id) }}">Редактировать</a>
                                <a class="btn btn-secondary"
                                   href="{{ route('destroy.booking', $booking->id) }}">Удалить</a>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
