@extends('layouts.adminLayout')
@section('title', 'Создание номера')
@section('content')

    {!! Form::open(['action' =>'RoomsController@storeRoom', 'method' => 'POST', 'class' => 'container card p-4'])!!}
    <h3>Создание номера</h3>

    <div class="form-group required">
        <label for="type">Выберите тип номера</label>
        <select name="room_types_id" id="type" class="form form-control col-6">
            @foreach($types as $type)
                <option value="{{ $type->id }}"> {{ $type->name }}</option>
            @endforeach
        </select>
    </div>

    <div class='form-group required'>
        <label for="subject">Номер</label>
        {{ Form::text('number', null, ['class' => 'form form-control col-6']) }}
        @error('number')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class='form-group required'>
        <label for="subject">Цена за сутки в ₽</label>
        {{ Form::text('price', null, ['class' => 'form form-control col-6']) }}
        @error('price')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class='form-group required'>
        <label for="subject">Количество спальных мест</label>
        {{ Form::number('space', null, ['class' => 'form form-control col-6']) }}
        @error('space')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class='form-group required'>
        <label for="subject">Описание номера</label><span class="text-muted">(не обязятально)</span>
        {{ Form::textarea('description', null, ['class' => 'form form-control col-6']) }}
    </div>

    {!! Form::submit('Создать', ['class' => 'btn btn-dark w-25 mt-3']) !!}

    {!! Form::close() !!}
@endsection
