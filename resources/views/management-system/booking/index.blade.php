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
                    <hr>
                @endforeach
            @endforeach
        </div>
        @endforeach
    </div>
@endsection
