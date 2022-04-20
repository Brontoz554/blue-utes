@extends('layouts.adminLayout')
@section('title', 'Создание тарифа')
@section('content')

    {!! Form::open(['action' =>'TariffController@store', 'method' => 'POST', 'class' => 'container card p-4 col-6'])!!}
    <h3>Создание тарифа</h3>

    <div class='form-group required'>
        <label for="subject">Название тарифа</label>
        {{ Form::text('name', null, ['class' => 'form form-control']) }}
    </div>

    <div class='form-group required'>
        <label for="subject">Цена за сутки</label>
        {{ Form::text('price', null, ['class' => 'form form-control']) }}
    </div>


    <div class='form-group required'>
        <label for="subject">Лечение входит в стоимость</label>
        <input name="treatment" type="checkbox" checked>
    </div>

    <div class='form-group required'>
        <label for="subject">Питание входит в стоимость</label>
        <input name="nutrition" type="checkbox" checked>
    </div>

    <div class='form-group required'>
        <label for="subject">Проживание входит в стоимость</label>
        <input name="accommodation" type="checkbox" checked>
    </div>

    <div class='form-group required'>
        <label for="subject">Тип суток</label>
        <select name="type_of_day" id="type_of_day" class="form form-control">
            <option value="Санаторный">Санаторный</option>
            <option value="Отельный">Отельный</option>
        </select>
    </div>

    <div class='form-group required'>
        <label for="subject">Расчётный час</label>
        <div class="d-flex">
            {{ Form::time('check_out_start', null, ['class' => 'form form-control', 'placeholder' => 'Начало']) }}
            {{ Form::time('check_out_end', null, ['class' => 'form form-control', 'placeholder' => 'Конец']) }}
        </div>
    </div>

    <div class="form-group required mt-3 mb-3" id="another">

    </div>

    <div class='form-group required d-flex flex-column'>
        <input id="add-another" type="button" class="btn btn-outline-dark" value="Добавить дополнительные услуги">
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::submit('Создать', ['class' => 'btn btn-dark w-25 mt-3']) !!}

    {!! Form::close() !!}

    <script>
        var iterator = 0
        $('#add-another').click(function () {
            let div = $('#another')
            div.append(
                "<div class='d-flex align-content-center align-items-end' id='json-elem-" + iterator + "'>" +
                "<div class='w-50'>" +
                "<label>Название услуги</label>" +
                "<input type='text' name='json-name-" + iterator + "' class='form form-control'>" +
                "</div>" +
                "<div class='w-50'>" +
                "<label>Цена услуги</label>" +
                "<input type='number' name='json-price-" + iterator + "' class='form form-control'>" +
                "</div>" +
                "<span class='btn btn-default' id='json-remove-elem' style='height: 38px' onclick='removeElem(" + iterator + ")'>" +
                "<i class='fa fa-trash'></i>" +
                "</span>" +
                "</div>"
            )
            iterator++
        });

        function removeElem(iterator) {
            $('#json-elem-' + iterator).remove()
        }
    </script>
@endsection
