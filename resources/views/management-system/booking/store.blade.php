@extends("layouts.adminLayout")
@section("title", "Бронирование")
@section("content")
    <style>
        table > tbody > tr > td > div > label {
            font-weight: normal !important;
        }
    </style>

    {!! Form::open(["action" =>"BookingController@booking", "method" => "POST", "class" => "container card p-4"])!!}
    @if(Session::has('success'))
        <p class="alert-success p-2">{{ Session::get('success') }}</p>
    @endif
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
            <select name="room" id="room" class="form-select col-12 rooms-select" disabled required>
                <option value="не выбрано" selected>Не выбрано</option>
                @foreach($rooms as $room)
                    <option class="room-render" value="{{ $room->id }}" data-target="{{ $room->type->name }}">
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
            <label for="tariff">Тариф</label>
            <select name="tariff" id="tariff" class="form-select col-12" required>
                <option value="не выбрано" selected disabled>Не выбрано</option>
                @foreach($tariff as $item)
                    <option class="tariff-item" value="{{ $item->id }}">{{ $item->name }}</option>
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
                {{ Form::number("old", 1, ["class" => "form form-control", 'min' => 1, 'id' => 'old']) }}
                @error("old")
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group required w-50">
                <label for="subject">Дети до 5 лет</label>
                {{ Form::number("new", 0, ["class" => "form form-control", "min" => 0, 'id' => 'new']) }}
                @error("new")
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class='form-group required col-6'>
            <label for="type_of_day">Тип суток</label>
            <select name="type_of_day" id="type_of_day" class="form form-select">
                <option value="Санаторный">Санаторный</option>
                <option value="Отельный">Отельный</option>
            </select>
        </div>
    </div>

    <div class="d-flex flex-row">
        <div class="w-50 d-flex">
            <div class="form-group required w-50">
                <label for="subject">Общая стоимость</label>
                {{ Form::number("price", null, ["class" => "form form-control", "min" => 0, "id" => 'price']) }}
                @error("price")
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group required w-50">
                <label for="subject">Скидка в рублях</label>
                {{ Form::number("discount", null, ["class" => "form form-control", "id" => "discount"]) }}
                @error("discount")
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="d-flex">
        <div class="form-group required">
            <label for="payment_type">Тип оплаты</label>
            <select name="payment_type" id="payment_type" class="form form-select">
                <option value="Наличными(при заселении)">Наличными(при заселении)</option>
                <option value="Картой (при заселении)">Картой (при заселении)</option>
                <option value="Перевод">Перевод</option>
            </select>
            @error("payment_type")
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group required">
            <label for="payment_state">Статус оплаты</label>
            <select name="payment_state" id="payment_type" class="form form-select">
                <option value="Не оплачено">Не оплачено</option>
                <option value="Оплачено">Оплачено</option>
            </select>
            @error("discount")
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group required pl-0 w-50">
        <label for="booking_type">Кто бронирует</label>
        <select name="booking_type" id="booking_type" class="form-select">
            <option value="Гость бронирует для себя">Гость бронирует для себя</option>
            <option value="Контактное лицо бронирует для гостя">Контактное лицо бронирует для гостя</option>
            <option value="Бронирует контрагент">Бронирует контрагент</option>
        </select>
    </div>

    <fieldset class="bg-light p-4 mt-2 mb-2">
        <label for="clientType">Данные клиента</label>
        <select name="client_type" id="clientType" class="form form-select mb-2">
            <option value="newClient">Новый клиент</option>
            <option value="oldClient">Клиент уже посещял санаторий</option>
        </select>
        <div id="newClient">
            <div class="d-flex">
                <div class="col-4 pl-0">
                    <label for="name">Имя гостя</label>
                    {{ Form::text("name", null, ["class" => "form form-control", "id"=> "guest_name"]) }}
                    @error("name")
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-4">
                    <label for="number">Номер телефона</label>
                    {{ Form::text("number", null, ["class" => "form form-control", 'id' => 'number']) }}
                    @error("number")
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-4 pr-0">
                    <label for="mail">Почта</label>
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
        <div id="oldClient" class="mt-3" style="display:none;">
            <table id="clients" class="table table-bordered table-striped dataTable dtr-inline">
                <thead>
                <tr>
                    <th class="text-muted">Выбирите нужного</th>
                    <th>ФИО клиента</th>
                    <th>Номер телефона</th>
                    <th>Почтовый ящик</th>
                    <th>Кол-во посещений</th>
                </tr>
                </thead>
                <tbody>
                @foreach($clients as $client)
                    <tr>
                        <td class="col-1">
                            <input type="radio" value="{{ $client->id }}" name="oldClient">
                        </td>
                        <td> {{ $client->name }} </td>
                        <td> {{ $client->number }} </td>
                        <td> {{ $client->mail }} </td>
                        <td> {{ $client->number_of_sessions }} </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
    </fieldset>

    <div class="tariff-information" style="display: none">
        <div class="mt-2 mb-2">
            <b>Название тарифа:</b> <span class="tariff-name">Тариф не выбран</span>
        </div>
        <div class="mt-2 mb-2">
            <b>Цена за сутки:</b> <span class="tariff-price">0</span>
        </div>
        <div class="mt-2 mb-2">
            <b>Предоставляемые медецинские услуги в рамках тарифа:</b>
            <div class="tariff-treatment"></div>
        </div>
        <div class="mt-2 mb-2">
            <b>Предоставляемые дополнительные услуги в рамках тарифа:</b>
            <div class="tariff-services"></div>
        </div>
        <div class="tariff-info"></div>
        <div class="mt-2 mb-2">
            <b>Предоставляемые услуги питания в рамках тарифа:</b>
            <p class="text-muted">Количетсво персон, которые будут кушать</p>
            <div class="tariff-nutrition d-flex">
                <div style="width: 75px; display: none" class="mr-2 breakfast">
                    <label for="breakfast">Завтрак</label>
                    <input class="form form-control nutrition-type" type="number" name="breakfast"
                           id="breakfast" min="0">
                </div>
                <div style="width: 75px; display: none;" class="mr-2 dinner">
                    <label for="dinner">Обед</label>
                    <input class="form form-control nutrition-type" type="number" name="dinner"
                           id="dinner" min="0">
                </div>
                <div style="width: 75px; display: none;" class="lunch">
                    <label for="lunch">Ужин</label>
                    <input class="form form-control nutrition-type" type="number" name="lunch"
                           id="lunch" min="0">
                </div>
            </div>
        </div>

    </div>

    <div class="form-group required mt-2">
        <label>Комментарий</label>
        {{ Form::textarea("comment", null, ["class" => "form form-control"]) }}
    </div>

    {!! Form::submit("Создать", ["class" => "btn btn-dark w-25 mt-3"]) !!}

    {!! Form::close() !!}

    <script>
        $(document).ready(function ($) {
            $("#number").mask("+7 (999) 999 99 99");
            $("#serial").mask("9999");
            $("#passport_number").mask("999999");

            $('#clients').DataTable({
                "order": [[0, "asc"]],
                "pageLength": 10,
                "searching": true,
            });
        });
    </script>
    <script>
        $('#clientType').change(function () {
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
                },

                success: function (response) {
                    $('#room-info').html(response.message)
                },
            });
        }

        function calculateTotalPrice() {
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
