@extends('layouts.adminLayout')
@section('title', 'Создание тарифа')
@section('content')

    {!! Form::open(['action' =>'TariffController@store', 'method' => 'POST', 'class' => 'container card p-4 col-8'])!!}
    @if(Session::has('success'))
        <p class="alert-success p-2">{{ Session::get('success') }}</p>
    @endif
    <h3>Создание тарифа</h3>

    <div class='form-group required col-12'>
        <label for="subject">Название тарифа</label>
        {{ Form::text('name', null, ['class' => 'form form-control']) }}
        @error('name')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class='form-group required col-12'>
        <label for="subject">Цена за сутки</label>
        {{ Form::text('price', null, ['class' => 'form form-control']) }}
        @error('price')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group required col-12">
        <label for="typeOfDay">Расчётный тип</label>
        <select name="typeOfDay" id="typeOfDay" class="form form-select">
            <option value="Санаторный">Санаторный</option>
            <option value="Гостинечный">Гостинечный</option>
        </select>
    </div>

    <div class='form-group required col-12 d-flex'>
        <div class="w-50">
            Достунпые типы номеров
            <select name="typesRooms" id="typesRooms" class="form form-control" multiple size="8">
                <option class="option-typesRooms-element-select-all" value="all" data-target="add">Выбрать всё</option>
                @foreach($roomTypes as $roomType)
                    <option class="option-typesRooms-element" value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-50">
            Категории номеров для тарифа
            <textarea class="form form-control" name="roomTypeList" id="roomTypeList" rows="7" disabled></textarea>
            <input type="hidden" name="roomTypeId" id="roomTypeId">
        </div>
    </div>
    @error('roomTypeId')
    <div class="text-danger text-right">{{ $message }}</div>
    @enderror

    <div class="form-group required col-12 pt-2" style="margin-bottom: 0 !important;">
        <label for="subject">Лечение входит в стоимость</label>
        <input name="treatment" type="checkbox" class="treatment-checkbox">
    </div>

    <div class='form-group required col-12 d-flex'>
        <div class="w-50">
            Список предоставляемых услуг лечения
            <select name="treatments" id="treatments" class="form form-control" disabled multiple size="8">
                <option class="option-treatment-element-select-all" value="all">Выбрать всё</option>
                @foreach($treatments as $treatment)
                    <option class="option-treatment-element"
                            value="{{ $treatment->id }}">{{ $treatment->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-50">
            Услуги которые будут входить в тариф
            <textarea class="form form-control" name="treatmentsList" id="treatmentsList" rows="7" disabled></textarea>
            <input type="hidden" name="treatmentsId" id="treatmentsId">
        </div>
    </div>

    <div class="form-group required col-12 pt-2" style="margin-bottom: 0 !important;">
        <label for="subject">Питание входит в стоимость</label>
        <input name="nutrition" type="checkbox" class="eating-checkbox">
    </div>

    <div class='form-group required col-12 d-flex'>
        <div class="w-50">
            Список предоставляемых услуг питания
            <select name="eating" id="eating" class="form form-control" disabled multiple size="8">
                <option class="option-eating-element-select-all" value="all">Выбрать всё</option>
                @foreach($eat as $item)
                    <option class="option-eating-element" value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-50">
            Услуги которые будут входить в тариф
            <textarea class="form form-control" name="eatingList" id="eatingList" rows="7" disabled></textarea>
            <input type="hidden" name="eatingId" id="eatingId">
        </div>
    </div>

    <div class="form-group required col-12 pt-2" style="margin-bottom: 0 !important;">
        <label for="subject">Дополнительные услуги</label>
        <input name="another" type="checkbox" class="services-checkbox">
    </div>

    <div class='form-group required col-12 d-flex'>
        <div class="w-50">
            Список предоставляемых услуг питания
            <select name="services" id="services" class="form form-control" disabled multiple size="8">
                <option class="option-services-element-select-all" value="all">Выбрать всё</option>
                @foreach($services as $item)
                    <option class="option-services-element" value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-50">
            Услуги которые будут входить в тариф
            <textarea class="form form-control" name="servicesList" id="servicesList" rows="7" disabled></textarea>
            <input type="hidden" name="servicesId" id="servicesId">
        </div>
    </div>

    <div class="col-6 mt-3">
        <p><b>Условия предоплаты и отмены бронирования</b></p>
        <span class="text-muted">Используются в подтверждениях, а так же для бронирований с сайта отеля или через виджет онлайн-бронирований</span>
    </div>

    <div class="form-group required col-12 mt-3">
        <label for="irrevocable">Невозвратный тариф</label>
        <input type="checkbox" name="irrevocable" id="irrevocable">
    </div>

    <div class="form-group required col-8 d-flex flex-column">
        <div class="d-flex mt-1 align-items-baseline">
            <span>Предоплата</span>
            {{ Form::number('prepayment', null, ['class' => 'ml-1 form form-control col-2']) }}
            <span>₽</span>
        </div>
        <div class="d-flex mt-1 align-items-baseline irrevocable">
            <span>Бесплатная отмена за</span>
            {{ Form::number('hour', null, ['class' => 'ml-1 form form-control col-2']) }}
            <span>часов до заезда</span>
        </div>
        <div class="d-flex mt-1 align-items-baseline irrevocable">
            <span>штраф за позднюю отмену</span>
            {{ Form::number('fine', null, ['class' => 'ml-1 form form-control col-2']) }}
            <span>₽</span>
        </div>
    </div>

    {!! Form::submit('Создать', ['class' => 'btn btn-dark w-25 mt-3']) !!}

    {!! Form::close() !!}

    <script>
        $('#irrevocable').click(function () {
            if ($(this).is(':checked')) {
                $('div.irrevocable').css({
                    'opacity': '0'
                })
            } else {
                $('div.irrevocable').css({
                    'opacity': '1'
                })
            }
        });

        $('.option-typesRooms-element-select-all').click(function () {
            let types = $('#roomTypeList')
            let typesIds = $('#roomTypeId')
            $.each($('.option-typesRooms-element'), function () {
                let thisValue = types.val()
                let addedValue = $(this).html()
                if (!thisValue.includes(addedValue)) {
                    types.val(types.val() + $(this).html() + "\n")
                    typesIds.val(typesIds.val() + $(this).val() + ",")
                }
            })
        });
        $('.option-typesRooms-element').click(function () {
            let types = $('#roomTypeList')
            let typesIds = $('#roomTypeId')
            addOrRemoveElems(types, typesIds, this)
        });

        $('.treatment-checkbox').click(function () {
            if ($(this).is(':checked')) {
                $('#treatments').removeAttr('disabled')
            } else {
                $('#treatments').attr('disabled', 'disabled')
            }
        });
        $('.option-treatment-element').click(function () {
            if ($('.treatment-checkbox').is(':checked')) {
                let treatment = $('#treatmentsList')
                let treatmentsId = $('#treatmentsId')
                addOrRemoveElems(treatment, treatmentsId, this)
            }
        });
        $('.option-treatment-element-select-all').click(function () {
            if ($('.treatment-checkbox').is(':checked')) {
                let treatment = $('#treatmentsList')
                let treatmentsId = $('#treatmentsId')
                $.each($('.option-treatment-element'), function () {
                    let thisValue = treatment.val()
                    let addedValue = $(this).html()
                    if (!thisValue.includes(addedValue)) {
                        treatment.val(treatment.val() + $(this).html() + "\n")
                        treatmentsId.val(treatmentsId.val() + $(this).val() + ",")
                    }
                });
            }
        })

        $('.eating-checkbox').click(function () {
            if ($(this).is(':checked')) {
                $('#eating').removeAttr('disabled')
            } else {
                $('#eating').attr('disabled', 'disabled')
            }
        });
        $('.option-eating-element').click(function () {
            if ($('.eating-checkbox').is(':checked')) {
                let eating = $('#eatingList')
                let eatingId = $('#eatingId')
                addOrRemoveElems(eating, eatingId, this)
            }
        });
        $('.option-eating-element-select-all').click(function () {
            if ($('.eating-checkbox').is(':checked')) {
                let eating = $('#eatingList')
                let eatingId = $('#eatingId')
                $.each($('.option-eating-element'), function () {
                    let thisValue = eating.val()
                    let addedValue = $(this).html()
                    if (!thisValue.includes(addedValue)) {
                        eating.val(eating.val() + $(this).html() + "\n")
                        eatingId.val(eatingId.val() + $(this).val() + ",")
                    }
                });
            }
        });

        $('.services-checkbox').click(function () {
            if ($(this).is(':checked')) {
                $('#services').removeAttr('disabled')
            } else {
                $('#services').attr('disabled', 'disabled')
            }
        });
        $('.option-services-element').click(function () {
            if ($('.services-checkbox').is(':checked')) {
                let services = $('#servicesList')
                let servicesId = $('#servicesId')
                addOrRemoveElems(services, servicesId, this)
            }
        });
        $('.option-services-element-select-all').click(function () {
            if ($('.services-checkbox').is(':checked')) {
                let services = $('#servicesList')
                let servicesId = $('#servicesId')
                $.each($('.option-services-element'), function () {
                    let thisValue = services.val()
                    let addedValue = $(this).html()
                    if (!thisValue.includes(addedValue)) {
                        services.val(services.val() + $(this).html() + "\n")
                        servicesId.val(servicesId.val() + $(this).val() + ",")
                    }
                })
            }
        });

        function addOrRemoveElems(list, ids, elem) {
            let thisValue = list.val()
            let addedValue = $(elem).html()
            let newList = [];
            if (thisValue.includes(addedValue)) {
                $.each((list.val()).split("\n"), function (key, value) {
                    if (value !== addedValue) {
                        newList.push(value)
                    }
                });
                list.val(newList.join("\n"))

                let treatValues = ids.val()
                ids.val(treatValues.replaceAll($(elem).val() + ',', ''))
            } else {
                list.val(list.val() + $(elem).html() + "\n")
                ids.val(ids.val() + $(elem).val() + ",")
            }
        }
    </script>
@endsection
