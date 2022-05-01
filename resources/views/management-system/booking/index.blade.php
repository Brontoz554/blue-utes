@extends("layouts.adminLayout")
@section("title", "шахматка")
@section("content")
    <div class="container">
        @foreach ($roomTypes as $roomType)
            <div class="card p-3">
                <b>название типа номера</b>
                <div>{{ $roomType->name }}</div>
                <hr>
                @foreach ($roomType->rooms as $room)
                    <b>название комнаты</b>
                    <div>{{ $room->number }}</div>
                    <hr>
                    @foreach ($room->bookings as $booking)
                        <b>информация о бронировании</b>
                        <div>{{ $booking }}</div>
                        <b>информация о клиенте</b>
                        <div>{{ $booking->client }}</div>
                        <b>информация о тарифе</b>
                        <div>{{ $booking->tariff }}</div>
                        {{--вытащить связи у (сервисов, питания,мед.услуг) тарифа resources/views/management-system/tariff/index.blade.php 31 строка--}}
                        <hr>
                    @endforeach
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
