@extends("layouts.adminLayout")
@section("title", "Бронирование")
@section("content")

    {!! Form::open(["action" =>"BookingController@booking", "method" => "POST", "class" => "container card p-4"])!!}
    <h3>Бронирование</h3>

    <div class="d-flex align-items-baseline mb-3">
        <div class="w-25">
            <label>Дата заезда</label>
            {{ Form::date("date_start", null, ["class" => "form form-control w-100", "id" => "date_start"]) }}
            @error("date_start")
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="w-25">
            <label class="mt-3">Время заезда</label>
            {{ Form::time("time_start", '00:00', ["class" => "form form-control w-100", "id" => "time_start"]) }}
            @error("time_start")
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="ml-3 w-25">
            <label>Дата выезда</label>
            {{ Form::date("date_end", null, ["class" => "form form-control w-100", "id"=> "date_end"]) }}
            @error("date_end")
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="w-25">
            <label class="mt-3">Время выезда</label>
            {{ Form::time("time_end", '00:00', ["class" => "form form-control w-100", "id" => "time_end"]) }}
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
        <div class="form-group required w-50">
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
            <div class="form-group required col-4 pl-0">
                <label for="subject">Взрослых</label>
                {{ Form::number("old", 1, ["class" => "form form-control", 'min' => 1, 'id' => 'old']) }}
                @error("old")
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group required col-4 pr-0">
                <label for="subject">Дети до 5 лет</label>
                {{ Form::number("new", 0, ["class" => "form form-control", "min" => 0, 'id' => 'new']) }}
                @error("new")
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group required col-6">
            <label for="accommodation">Проживание входит в стоимость тарифа?</label>
            <input type="checkbox" name="accommodation" id="accommodation" class="form form-check" checked>
        </div>
    </div>

    <div class='form-group required w-25'>
        <label for="type_of_day">Тип суток</label>
        <select name="type_of_day" id="type_of_day" class="form form-select">
            <option value="Санаторный">Санаторный</option>
            <option value="Отельный">Отельный</option>
        </select>
    </div>

    <div class="d-flex w-50">
        <div class="form-group required w-50">
            <label for="subject">Общая стоимость</label>
            {{ Form::number("price", null, ["class" => "form form-control", "min" => 0, "id" => 'price']) }}
            @error("price")
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group required w-50">
            <label for="subject">скидка в рублях</label>
            {{ Form::number("discount", null, ["class" => "form form-control", "id" => "discount" ]) }}
            @error("discount")
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group required pl-0">
        <label for="type">Кто бронирует</label>
        <select name="type" id="type" class="form-select col-5">
            <option value="1">Гость бронирует для себя</option>
            <option value="2">Контактное лицо бронирует для гостя</option>
            <option value="3">Бронирует контрагент</option>
        </select>
    </div>

    <fieldset class="bg-light p-4 mt-2 mb-2">
        <legend>Данные клиента</legend>
        <select name="client_type" id="clientType" class="form form-select mb-2">
            <option value="newClient">Новый клиент</option>
            <option value="oldClient">Клиент уже посещял санаторий</option>
        </select>
        <div id="newClient">
            <div class="d-flex">
                <div class="col-4 pl-0">
                    <label for="subject">Имя гостя</label>
                    {{ Form::text("name", null, ["class" => "form form-control"]) }}
                    @error("name")
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-4">
                    <label for="subject">Номер телефона</label>
                    {{ Form::text("number", null, ["class" => "form form-control", 'id' => 'number']) }}
                    @error("number")
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-4 pr-0">
                    <label for="subject">Почта</label>
                    {{ Form::email("mail", null, ["class" => "form form-control", 'id' => 'mail']) }}
                    @error("mail")
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="d-flex">
                <div class="col-4 pl-0">
                    <label for="subject">Серия паспорта</label>
                    {{ Form::text("serial", null, ["class" => "form form-control", 'id' => 'serial']) }}
                    @error("serial")
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-4">
                    <label for="subject">Номер паспорта</label>
                    {{ Form::text("passport_number", null, ["class" => "form form-control", 'id' => 'passport_number']) }}
                    @error("passport_number")
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-4 pr-0">
                    <label for="subject">Дата выдачи</label>
                    {{ Form::date("passport_data", null, ["class" => "form form-control", 'id' => 'passport_date']) }}
                    @error("passport_data")
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div id="oldClient" style="display:none;">
            <select name="oldClient" class="form form-select">
                @foreach($clients as $client)
                    <option value="{{ $client->number }}">
                        {{ $client->name }}
                        {{ $client->number }}
                    </option>
                @endforeach
            </select>
        </div>
    </fieldset>

    <div class="form-group required mt-2">
        <label>Комментарий</label>
        {{ Form::textarea("comment", null, ["class" => "form form-control"]) }}
    </div>

    {{--    <div class="form-group required pl-0">--}}
    {{--        <label for="type">Кто бронирует</label>--}}
    {{--        <select name="type" id="type" class="form-select col-5">--}}
    {{--            <option value="1">Стойка администратора</option>--}}
    {{--            <option value="2">Сайт санатория</option>--}}
    {{--            <option value="3">Электронная почта</option>--}}
    {{--            <option value="4">Телефон</option>--}}
    {{--        </select>--}}
    {{--    </div>--}}

    {!! Form::submit("Создать", ["class" => "btn btn-dark w-25 mt-3"]) !!}

    {!! Form::close() !!}

    <script src="{{ asset('/js/jquery.maskedinput.min.js') }}"></script>
    <script defer>
        $(document).ready(function () {
            $("#number").mask("+7 (999) 999 99 99");
            $("#serial").mask("9999");
            $("#passport_number").mask("999999");
        });
    </script>
    <script>
        $('#clientType').change(function () {
            console.log($(this).val())
            if ($(this).val() == 'newClient') {
                $('#newClient').show()
                $('#oldClient').hide()
            } else {
                $('#newClient').hide()
                $('#oldClient').show()
            }
        })
        getRoom();
        getTariff();
        checkBooking();

        $('#tariff').on('change', async function () {
            await getTariff();
            calculateTotalPrice();
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

        $('#accommodation').click(function () {
            if ($(this).is(':checked')) {
                calculateTotalPrice()
            } else {
                calculateTotalPrice(true)
            }
        });

        $('#discount').change(function () {
            let newPrice = Number($('#price').val()) - Number($("#discount").val())
            $('#price').val(newPrice)
        })

        async function getTariff() {
            $.ajax({
                type: "post",
                dataType: "json",
                url: "{{ route('getTariffPrice') }}",
                data: {
                    id: $('#tariff').val()
                },

                success: function (response) {
                    sessionStorage.setItem('tariff', response.price[0].price);
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
                    $('#old').val(1)
                    $('#new').val(1)
                    $('#old').attr("max", response.room[0].space)
                    $('#new').attr("max", response.room[0].space - 2)
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
