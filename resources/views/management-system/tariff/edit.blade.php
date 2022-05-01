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

    <div class="form-group required col-12 pt-2" style="margin-bottom: 0 !important;">
        <label for="subject">Лечение входит в стоимость</label>
        <input name="treatment" type="checkbox" class="treatment-checkbox"
               @if($tariff->treatment == 'on') checked @endif>
    </div>

    <div class='form-group required col-12 d-flex'>
        <div class="w-50">
            <label for="treatments">Список предоставляемых услуг лечения</label>
            <select name="treatments" id="treatments" class="form form-control" @if($tariff->treatment != 'on') disabled
                    @endif multiple size="8">
                @foreach($treatments as $treatment)
                    <option class="option-treatment-element"
                            value="{{ $treatment->id }}">{{ $treatment->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-50">
            <label for="treatmentsList">Услуги которые будут входить в тариф</label>
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
            <label for="eating">Список предоставляемых услуг питания</label>
            <select name="eating" id="eating" class="form form-control" multiple size="8"
                    @if($tariff->nutrition != 'on') disabled @endif>
                @foreach($eat as $item)
                    <option class="option-eating-element" value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-50">
            <label for="eatingList">Услуги которые будут входить в тариф</label>
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
            <label for="services">Список предоставляемых услуг питания</label>
            <select name="services" id="services" class="form form-control" multiple size="8"
                    @if($tariff->another != 'on') disabled @endif>
                @foreach($services as $item)
                    <option class="option-services-element" value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-50">
            <label for="servicesList">Услуги которые будут входить в тариф</label>
            <textarea class="form form-control" name="servicesList" id="servicesList" rows="7" disabled
            >@foreach($tariff->services as $service) {{ $service->name . "\n" }} @endforeach</textarea>
            <input type="hidden" name="servicesId" id="servicesId"
                   value="@foreach($tariff->services as $service){{ $service->id . ',' }}@endforeach">
        </div>
    </div>

    <input type="hidden" name="id" value="{{ $tariff->id }}">

    {!! Form::submit('Создать', ['class' => 'btn btn-dark w-25 mt-3']) !!}

    {!! Form::close() !!}

    <script>
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
                let thisValue = treatment.val()
                let addedValue = $(this).html()
                if (thisValue.includes(addedValue)) {

                    treatment.val(thisValue.replaceAll(addedValue, "\n"))
                    let clearList = []
                    $.each((treatment.val()).split("\n"), function (key, value) {
                        if (value !== '') {
                            clearList.push(value)
                        }
                    })

                    treatment.val(clearList.join("\n") + "\n")

                    let treatValues = treatmentsId.val()
                    treatmentsId.val(treatValues.replaceAll($(this).val() + ',', ''))
                } else {
                    treatment.val(treatment.val() + $(this).html() + "\n")
                    treatmentsId.val(treatmentsId.val() + $(this).val() + ",")
                }
            }
        });

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
                let thisValue = eating.val()
                let addedValue = $(this).html()
                if (thisValue.includes(addedValue)) {

                    eating.val(thisValue.replaceAll(addedValue, "\n"))
                    let clearList = []
                    $.each((eating.val()).split("\n"), function (key, value) {
                        if (value !== '') {
                            clearList.push(value)
                        }
                    })

                    eating.val(clearList.join("\n") + "\n")

                    let treatValues = eatingId.val()
                    eatingId.val(treatValues.replaceAll($(this).val() + ',', ''))
                } else {
                    eating.val(eating.val() + $(this).html() + "\n")
                    eatingId.val(eatingId.val() + $(this).val() + ",")
                }
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
                let thisValue = services.val()
                let addedValue = $(this).html()
                if (thisValue.includes(addedValue)) {

                    services.val(thisValue.replaceAll(addedValue, "\n"))
                    let clearList = []
                    $.each((services.val()).split("\n"), function (key, value) {
                        if (value !== '') {
                            clearList.push(value)
                        }
                    })

                    services.val(clearList.join("\n") + "\n")

                    let treatValues = servicesId.val()
                    servicesId.val(treatValues.replaceAll($(this).val() + ',', ''))
                } else {
                    services.val(services.val() + $(this).html() + "\n")
                    servicesId.val(servicesId.val() + $(this).val() + ",")
                }
            }
        });

        function removeElem(iterator) {
            $('#json-elem-' + iterator).remove()
        }
    </script>
@endsection
