@extends("layouts.adminLayout")
@section("title", "Редактировать бронирование")
@section("content")

    {!! Form::open(["action" =>"BookingController@editBooking", "method" => "POST", "class" => "container card p-4"])!!}
    @if(Session::has('room'))
        <p class="alert-danger p-2">{{ Session::get('room') }}</p>
    @endif

    @if(Session::has('success'))
        <p class="alert-success p-2">{{ Session::get('success') }}</p>
    @endif
    <h3>Редактировать бронирование</h3>

    <input type="hidden" name="bookingId" value="{{ $booking->id }}">
    <div>
        <b>Имя: </b> {{ $booking->client->name }}
    </div>

    <div>
        <b>Почтовый адрес: </b> {{ $booking->client->mail }}
    </div>

    <div>
        <b>Номер телефона: </b> {{ $booking->client->number }}
    </div>

    <div class="d-flex align-items-baseline mb-3">
        <div class="w-25">
            <label>Дата заезда</label>
            {{ Form::date("date_start", $booking->date_start, ["class" => "form form-control w-100", "id" => "date_start"]) }}
            @error("date_start")
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="w-25">
            <label class="mt-3">Время заезда</label>
            {{ Form::time("time_start", $booking->time_start, ["class" => "form form-control w-100", "id" => "time_start"]) }}
            @error("time_start")
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="ml-3 w-25">
            <label>Дата выезда</label>
            {{ Form::date("date_end", $booking->date_end, ["class" => "form form-control w-100", "id"=> "date_end"]) }}
            @error("date_end")
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="w-25">
            <label class="mt-3">Время выезда</label>
            {{ Form::time("time_end", $booking->time_end, ["class" => "form form-control w-100", "id" => "time_end"]) }}
            @error("time_end")
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="d-flex">
        <div class="form-group required w-50">
            <label for="room">Номер комнаты</label>
            <select name="room" id="room" class="form-select col-12">
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">
                        {{ $room->number }}
                        {{ $room->type->name }}
                    </option>
                @endforeach
            </select>
            @if(Session::has('room'))
                <p class="alert alert-info">{{ Session::get('room') }}</p>
            @endif
            <p class="text-success" id="room-info"></p>
            @error("room")
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group required w-50 ml-3">
            <label for="subject">Тариф</label>
            <select name="tariff" id="tariff" class="form-select col-12">
                @foreach($tariff as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            @error("tariff")
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="d-flex">
        <div class="d-flex w-50">
            <div class="form-group required w-50">
                <label for="subject">Взрослых</label>
                {{ Form::number("old", $booking->old, ["class" => "form form-control", 'min' => 1, 'id' => 'old']) }}
                @error("old")
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group required w-50">
                <label for="subject">Дети до 5 лет</label>
                {{ Form::number("new", $booking->new, ["class" => "form form-control", "min" => 0, 'id' => 'new']) }}
                @error("new")
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class='form-group required w-25'>
        <label for="type_of_day">Тип суток</label>
        {!! Form::select('type_of_day', array_unique([
            $booking->type_of_day => $booking->type_of_day,
            'Санаторный' => 'Санаторный',
            'Отельный' => 'Отельный',
        ]), null, ['class' => 'form-select']) !!}
    </div>

    <div class="d-flex w-50">
        <div class="form-group required w-50">
            <label for="subject">Общая стоимость</label>
            {{ Form::number("price", $booking->price, ["class" => "form form-control", "min" => 0, "id" => 'price']) }}
            @error("price")
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group required w-50">
            <label for="subject">скидка в рублях</label>
            {{ Form::number("discount", $booking->discount, ["class" => "form form-control", "id" => "discount" ]) }}
            @error("discount")
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group required pl-0 w-50">
        <label for="booking_type">Кто бронирует</label>
        {!! Form::select('booking_type', array_unique([
            $booking->booking_type => $booking->booking_type,
            'Гость бронирует для себя' => 'Гость бронирует для себя',
            'Контактное лицо бронирует для гостя' => 'Контактное лицо бронирует для гостя',
            'Бронирует контрагент' => 'Бронирует контрагент',
        ]), null, ['class' => 'form-select']) !!}
    </div>

    <div class="d-flex w-75">
        <div class="form-group required w-50">
            <label for="payment_type">Тип оплаты</label>
            {!! Form::select('payment_type', array_unique([
                $booking->payment_type => $booking->payment_type,
                'Наличными(при заселении)' => 'Наличными(при заселении)',
                'Картой (при заселении)' => 'Картой (при заселении)',
                'Перевод' => 'Перевод',
            ]), null, ['class' => 'form-select']) !!}
            @error("payment_type")
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group required w-50">
            <label for="payment_state">Статус оплаты</label>
            {!! Form::select('payment_state', array_unique([
                $booking->payment_state => $booking->payment_state,
                'Оплачено' => 'Оплачено',
                'Не оплачено' => 'Не оплачено',
            ]), null, ['class' => 'form-select']) !!}
            @error("discount")
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group required mt-2">
        <label>Комментарий</label>
        {{ Form::textarea("comment", $booking->comment, ["class" => "form form-control"]) }}
    </div>

    {!! Form::submit("Редактировать", ["class" => "btn btn-dark w-25 mt-3"]) !!}

    {!! Form::close() !!}

    <script>
        $(document).ready(function ($) {
            $("#number").mask("+7 (999) 999 99 99");
            $("#serial").mask("9999");
            $("#passport_number").mask("999999");
        });
    </script>
    <script>
        getRoom();
        getTariff();
        checkBooking();

        $('#client_type').change(function () {
            if ($(this).val() === 'newClient') {
                $('#guest_name').prop('required', true);
                $('#number').prop('required', true);
                $('#email').prop('required', true);
                $('#serial').prop('required', true);
                $('#passport_number').prop('required', true);
                $('#passport_date').prop('required', true);
                $('#newClient').show()
                $('#oldClient').hide()
            } else {
                $('#newClient').hide()
                $('#oldClient').show()
                $('#guest_name').prop('required', false);
                $('#number').prop('required', false);
                $('#email').prop('required', false);
                $('#serial').prop('required', false);
                $('#passport_number').prop('required', false);
                $('#passport_date').prop('required', false);
            }
        })

        $('#tariff').on('change', async function () {
            await getTariff();
            calculateTotalPrice();

            $.ajax({
                type: "post",
                dataType: "json",
                url: "{{ route('getTariffRoomInfo') }}",
                data: {
                    id: $('#tariff').val()
                },

                success: function (response) {
                    $('.room-render').hide()
                    $.each(response.tariff, function (key, val) {
                        $.each($('.room-render'), function () {
                            if ($(this).attr('data-target') === val.name) {
                                $(this).show()
                            }
                        })
                    })

                    $('.rooms-select').removeAttr('disabled')
                    $('.rooms-select').val('не выбрано')
                },
            });
        });

        $('#room').on('change', async function () {
            await getRoom()
            checkBooking()
            calculateTotalPrice()
        });

        $('#date_start').on('change', async function () {
            calculateTotalPrice();
            checkBooking();
        });

        $('#time_start').on('change', async function () {
            calculateTotalPrice();
            checkBooking();
        });

        $('#date_end').on('change', async function () {
            calculateTotalPrice();
            checkBooking();
        });

        $('#time_end').on('change', async function () {
            calculateTotalPrice();
            checkBooking();
        });

        $('#type_of_day').on('change', async function () {
            calculateTotalPrice();
            checkBooking();
        });

        $('#discount').change(function () {
            let newPrice = Number($('#price').val()) - Number($("#discount").val())
            $('#price').val(newPrice)
        })

        async function getTariff() {
            $.ajax({
                type: "post",
                dataType: "json",
                url: "{{ route('getTariffInfo') }}",
                data: {
                    id: $('#tariff').val()
                },

                success: function (response) {
                    sessionStorage.setItem('tariff', response.tariff.price);
                    $('.render').remove()
                    $('.nutrition-type').val(0)
                    $('.breakfast').hide()
                    $('.dinner').hide()
                    $('.lunch').hide()
                    $('.tariff-information').show()

                    if (response.tariff.treatment === 'on') {
                        $.each(response.tariff.treatments, function (key, value) {
                            $('.tariff-treatment').append(
                                "<div class='render'>" + value.name + "</div>"
                            )
                        });
                    }

                    if (response.tariff.nutrition === 'on') {
                        $.each(response.tariff.eatings, function (key, value) {
                            if (value.name === 'завтрак') {
                                $('.breakfast').show()
                            }
                            if (value.name === 'обед') {
                                $('.dinner').show()
                            }
                            if (value.name === 'ужин') {
                                $('.lunch').show()
                            }
                        });
                    }


                    if (response.tariff.another === 'on') {
                        $.each(response.tariff.services, function (key, value) {
                            $('.tariff-services').append(
                                "<div class='render'>" + value.name + "</div>"
                            )
                        });
                    }

                    $('.tariff-name').html(response.tariff.name)
                    $('.tariff-price').html(response.tariff.price)

                },
            });
        }

        async function getRoom() {
            $.ajax({
                type: "post",
                dataType: "json",
                url: "{{ route('getRoomPrice') }}",
                data: {
                    id: $('#room').val()
                },

                success: function (response) {
                    sessionStorage.setItem('roomPrice', response.room[0].price);
                    $('#old').attr("max", response.room[0].space)
                    if ((response.room[0].space - 2) > 0) {
                        $('#new').attr("max", response.room[0].space - 2)
                    } else {
                        $('#new').attr("max", response.room[0].space)
                    }
                },
            });
        }

        function checkBooking() {
            $.ajax({
                type: "post",
                dataType: "json",
                url: "{{ route('checkRoomBooking') }}",
                data: {
                    room: $('#room').val(),
                    start: $('#date_start').val() + ' ' + $('#time_start').val(),
                    end: $('#date_end').val() + ' ' + $('#time_end').val(),
                    old: $('#old').val(),
                    new: $('#new').val(),
                },

                success: function (response) {
                    $('#room-info').html(response.message)
                },
            });
        }

        function calculateTotalPrice(withRoom = false) {
            let oneDay = 1000 * 60 * 60 * 24;
            let start = new Date($('#date_start').val())
            let end = new Date($('#date_end').val())
            if (start > end) {
                alert('Дата заезда позже чем дата выезда, такое невозможно')
                return;
            }
            let days = end.getTime() - start.getTime()
            let totalDays = days / oneDay;

            let price = sessionStorage.getItem('tariff');
            if (withRoom) {
                price = Number(price) + Number(sessionStorage.getItem('roomPrice'));
            }

            if ($('#type_of_day').val() == 'Санаторный') {
                totalDays++
                $('#price').val(price * totalDays)
            } else {
                $('#price').val(price * totalDays)
            }

            let newPrice = Number($('#price').val()) - Number($("#discount").val())
            $('#price').val(newPrice)
        }
    </script>
@endsection
