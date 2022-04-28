@extends("layouts.adminLayout")
@section("title", "шахматка")
@section("content")
    @foreach($bookings as $booking)
        <div class="card container">
            <div>
                <p>Комната</p>
                {{ $booking->room }}
                <hr>
            </div>
            <div>
                <p>клиент</p>
                {{ $booking->client }}
                <hr>
            </div>

            <div>
                <p>тариф</p>
                {{ $booking->tariff }}
                <hr>
            </div>

            <div>
                <p>информация о бронировании</p>
                {{ $booking }}
                <hr>
            </div>
        </div>
    @endforeach
@endsection
