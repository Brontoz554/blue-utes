@extends('layouts.adminLayout')
@section('title', 'Изменение номера ' . $room->number)
@section('content')

    {!! Form::open(['action' =>'RoomsController@editRoom', 'method' => 'POST', 'class' => 'container card p-4 '])!!}
    <h3>Изменение номера {{ $room->number }}</h3>

    <div class="form-group required">
        <label for="type">Выберите тип номера</label>
        <select name="room_types_id" id="type" class="form form-control col-12">
            <option value="{{ $room->type->id }}">{{ $room->type->name }}</option>
            @foreach($types as $type)
                <option value="{{ $type->id }}"> {{ $type->name }}</option>
            @endforeach
        </select>
    </div>

    <div class='form-group required'>
        <label for="subject">Номер</label>
        {{ Form::text('number', $room->number, ['class' => 'form form-control col-12']) }}
        @error('number')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class='form-group required'>
        <label for="subject">Цена за сутки в ₽</label>
        {{ Form::text('price', $room->price, ['class' => 'form form-control col-12']) }}
        @error('price')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class='form-group required'>
        <label for="subject">Количество спальных мест</label>
        {{ Form::number('space', $room->space, ['class' => 'form form-control col-12']) }}
        @error('space')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group required pt-2" style="margin-bottom: 0 !important;">
        <label for="another">Дополнительные услуги</label>
        <input name="another" type="checkbox" class="services-checkbox" @if($room->another == 'on') checked @endif>
    </div>

    <div class='form-group required d-flex'>
        <div class="w-50">
            <label for="services">Список предоставляемых услуг</label>
            <select name="services" id="services" class="form form-control" multiple size="8"
                    @if($room->another !== 'on') disabled @endif>
                @foreach($services as $service)
                    <option class="option-service-element" value="{{ $service->id }}">{{ $service->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-50">
            <label for="servicesList{{ $room->id }}">Услуги входящие в номер</label>
            <textarea class="form form-control servicesList" name="servicesList" id="servicesList" rows="7" disabled
            >@foreach($room->roomServices as $key => $service){{ $service->name . "\n"}}@endforeach</textarea>
            <input type="hidden"
                   name="servicesId"
                   id="servicesId"
                   value="@foreach($room->roomServices as $service){{ $service->id.',' }}@endforeach">
        </div>
    </div>

    <div class='form-group required'>
        <label for="subject">Описание номера</label><span class="text-muted">(не обязятально)</span>
        {{ Form::textarea('description', $room->description, ['class' => 'form form-control col-12']) }}
    </div>

    <input type="hidden" name="dataId" value="{{ $room->id }}">

    {!! Form::submit('Редактировать', ['class' => 'btn btn-dark w-25 mt-3']) !!}

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
                let thisValue = (service.val()).trim()
                let addedValue = ($(this).html()).trim()
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
                    $.each((service.val()).split("\n"), function (key, value) {
                        if (value.trim() !== "") {
                            newList.push(value.trim())
                        }
                    });
                    newList.push(($(this).html()).trim())
                    service.val(newList.join("\n"))

                    servicesId.val(servicesId.val() + $(this).val() + ",")
                }
            }
        });
    </script>
@endsection
