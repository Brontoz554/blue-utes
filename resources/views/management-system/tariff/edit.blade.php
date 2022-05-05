@extends('layouts.adminLayout')
@section('title', 'Редактирование тарифа ' . $tariff->name)
@section('content')

    {!! Form::open(['action' =>'TariffController@editTariff', 'method' => 'POST', 'class' => 'container card p-4 col-8'])!!}
    <h3>Редактирование тарифа {{ $tariff->name }}</h3>

    <div class='form-group required col-12'>
        <label for="subject">Название тарифа</label>
        {{ Form::text('name', $tariff->name, ['class' => 'form form-control']) }}
        @error('name')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class='form-group required col-12'>
        <label for="subject">Цена за сутки</label>
        {{ Form::text('price', $tariff->price, ['class' => 'form form-control']) }}
        @error('price')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group required col-12">
        <label for="typeOfDay">Расчётный тип</label>
        <select name="typeOfDay" id="typeOfDay" class="form form-select">
            <option value="{{ $tariff->type_of_day }}" selected disabled>{{ $tariff->type_of_day }}</option>
            <option value="Санаторный">Санаторный</option>
            <option value="Гостинечный">Гостинечный</option>
        </select>
    </div>

    <div class='form-group required col-12 d-flex'>
        <div class="w-50">
            Достунпые типы номеров
            <select name="typesRooms" id="typesRooms" class="form form-control" multiple size="8">
                <option class="option-typesRooms-element-select-all" value="all">Выбрать всё</option>
                @foreach($roomTypes as $roomType)
                    <option class="option-typesRooms-element" value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-50">
            Категории номеров для тарифа
            <textarea class="form form-control" name="roomTypeList" id="roomTypeList" rows="7" disabled
            >@foreach($tariff->roomTypes as $type){{ $type->name . "\n" }}@endforeach</textarea>
            <input type="hidden" name="roomTypeId" id="roomTypeId"
                   value="@foreach($tariff->roomTypes as $type){{ $type->id . ',' }}@endforeach">
        </div>
    </div>
    @error('roomTypeId')
    <div class="text-danger text-right">{{ $message }}</div>
    @enderror

    <div class="form-group required col-12 pt-2" style="margin-bottom: 0 !important;">
        <label for="treatment">Лечение входит в стоимость</label>
        <input name="treatment" type="checkbox" class="treatment-checkbox"
               @if($tariff->treatment == 'on') checked @endif>
    </div>

    <div class='form-group required col-12 d-flex'>
        <div class="w-50">
            Список предоставляемых услуг лечения
            <select name="treatments" id="treatments" class="form form-control" @if($tariff->treatment != 'on') disabled
                    @endif multiple size="8">
                <option class="option-treatment-element-select-all" value="all">Выбрать всё</option>
                @foreach($treatments as $treatment)
                    <option class="option-treatment-element"
                            value="{{ $treatment->id }}">{{ $treatment->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-50">
            Услуги которые будут входить в тариф
            <textarea class="form form-control" name="treatmentsList" id="treatmentsList" rows="7" disabled
            >@foreach($tariff->treatments as $treatment){{ $treatment->name . "\n"}}@endforeach</textarea>
            <input type="hidden"
                   name="treatmentsId"
                   id="treatmentsId"
                   value="@foreach($tariff->treatments as $treatment){{ $treatment->id . ','}}@endforeach">
        </div>
    </div>

    <div class="form-group required col-12 pt-2" style="margin-bottom: 0 !important;">
        <label for="subject">Питание входит в стоимость</label>
        <input name="nutrition" type="checkbox" class="eating-checkbox" @if($tariff->nutrition == 'on') checked @endif>
    </div>

    <div class='form-group required col-12 d-flex'>
        <div class="w-50">
            Список предоставляемых услуг питания
            <select name="eating" id="eating" class="form form-control" multiple size="8"
                    @if($tariff->nutrition != 'on') disabled @endif>
                <option class="option-eating-element-select-all" value="all">Выбрать всё</option>
                @foreach($eat as $item)
                    <option class="option-eating-element" value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-50">
            Услуги которые будут входить в тариф
            <textarea class="form form-control" name="eatingList" id="eatingList" rows="7" disabled
            >@foreach($tariff->eatings as $nutrition){{ $nutrition->name . "\n"}}@endforeach</textarea>
            <input type="hidden" name="eatingId" id="eatingId"
                   value="@foreach($tariff->eatings as $nutrition){{ $nutrition->id . ','}}@endforeach">
        </div>
    </div>

    <div class="form-group required col-12 pt-2" style="margin-bottom: 0 !important;">
        <label for="subject">Дополнительные услуги</label>
        <input name="another" type="checkbox" class="services-checkbox" @if($tariff->another == 'on') checked @endif>
    </div>

    <div class='form-group required col-12 d-flex'>
        <div class="w-50">
            Список предоставляемых услуг питания
            <select name="services" id="services" class="form form-control" multiple size="8"
                    @if($tariff->another != 'on') disabled @endif>
                <option class="option-services-element-select-all" value="all">Выбрать всё</option>
                @foreach($services as $item)
                    <option class="option-services-element" value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-50">
            Услуги которые будут входить в тариф
            <textarea class="form form-control" name="servicesList" id="servicesList" rows="7" disabled
            >@foreach($tariff->services as $service) {{ $service->name . "\n" }} @endforeach</textarea>
            <input type="hidden" name="servicesId" id="servicesId"
                   value="@foreach($tariff->services as $service){{ $service->id . ',' }}@endforeach">
        </div>
    </div>

    <input type="hidden" name="id" value="{{ $tariff->id }}">

    {!! Form::submit('Редактировать', ['class' => 'btn btn-dark w-25 mt-3']) !!}

    {!! Form::close() !!}

    <script>
        $('.option-typesRooms-element-select-all').click(function () {
            let types = $('#roomTypeList')
            let typesIds = $('#roomTypeId')
            $.each($('.option-typesRooms-element'), function () {
                addOrRemoveElems(types, typesIds, this)
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
                    addOrRemoveElems(treatment, treatmentsId, this)
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
                    addOrRemoveElems(eating, eatingId, this)
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
                    addOrRemoveElems(services, servicesId, this)
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
