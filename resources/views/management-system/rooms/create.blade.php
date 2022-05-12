@extends('layouts.adminLayout')
@section('title', 'Создание номера')
@section('content')

    {!! Form::open(['action' =>'RoomsController@storeRoom', 'method' => 'POST', 'class' => 'container card p-4'])!!}
    <h3>Создание номера</h3>

    <div class="form-group required">
        <label for="type">Выберите тип номера</label>
        <select name="room_types_id" id="type" class="form form-control col-12">
            @foreach($types as $type)
                <option value="{{ $type->id }}"> {{ $type->name }}</option>
            @endforeach
        </select>
    </div>

    <div class='form-group required'>
        <label for="subject">Номер</label>
        {{ Form::text('number', null, ['class' => 'form form-control col-12']) }}
        @error('number')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class='form-group required'>
        <label for="subject">Количество спальных мест</label>
        {{ Form::number('space', null, ['class' => 'form form-control col-12']) }}
        @error('space')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group required pt-2" style="margin-bottom: 0 !important;">
        <label for="another">Дополнительные услуги</label>
        <input name="another" type="checkbox" class="services-checkbox">
    </div>
    <div class='form-group required d-flex'>
        <div class="w-50">
            Список предоставляемых услуг
            <select name="services" id="services" class="form form-control" disabled multiple size="8">
                @foreach($services as $service)
                    <option class="option-service-element" value="{{ $service->id }}">{{ $service->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-50">
            Услуги которые будут входить в номер
            <textarea class="form form-control" name="servicesList" id="servicesList" rows="7" disabled></textarea>
            <input type="hidden" name="servicesId" id="servicesId">
        </div>
    </div>

    <div class='form-group required'>
        <label for="subject">Описание номера</label><span class="text-muted">(не обязятально)</span>
        {{ Form::textarea('description', null, ['class' => 'form form-control col-12']) }}
    </div>

    {!! Form::submit('Создать', ['class' => 'btn btn-dark w-25 mt-3']) !!}

    {!! Form::close() !!}

    <script>
        $('.services-checkbox').click(function () {
            if ($(this).is(':checked')) {
                $('#services').removeAttr('disabled')
            } else {
                $('#services').attr('disabled', 'disabled')
            }
        });

        $('.option-service-element').click(function () {
            if ($('.services-checkbox').is(':checked')) {
                let service = $('#servicesList')
                let servicesId = $('#servicesId')
                let thisValue = service.val()
                let addedValue = $(this).html()
                let newList = [];
                if (thisValue.includes(addedValue)) {
                    $.each((service.val()).split("\n"), function (key, value) {
                        if (value !== addedValue) {
                            newList.push(value)
                        }
                    });
                    service.val(newList.join("\n"))

                    let treatValues = servicesId.val()
                    servicesId.val(treatValues.replaceAll($(this).val() + ',', ''))
                } else {
                    service.val(service.val() + $(this).html() + "\n")
                    servicesId.val(servicesId.val() + $(this).val() + ",")
                }
            }
        });
    </script>
@endsection
