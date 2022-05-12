@extends("layouts.adminLayout")
@section("title", "Рацион клиента ". $booking->client->name)
@section("content")

    <div class="container">
        <div class="card p-3">
            <h5 class="pt-2 pb-2">Рацион клиента {{ $booking->client->name }}</h5>
            <div>
                <p>Бронирование c <b>{{ $booking->date_start }}</b> по <b>{{ $booking->date_end }}</b></p>
                <p>Время заезда <b>{{ $booking->time_start }}</b>, время выезда <b>{{ $booking->time_end }}</b></p>
            </div>
            <div style="overflow: auto">
                <table class="table table-bordered table-striped dataTable dtr-inline">
                    <thead>
                    <tr>
                        @foreach($booking->nutritious as $nutrition)
                            <th> {{ $nutrition->date }} </th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @foreach($booking->nutritious as $nutrition)
                            <td style="min-width: 150px" data-target="{{ $nutrition->id }}">
                                <div>
                                    порции завтрака: <input class="form form-control col-3" type="number"
                                                            data-target="{{ $nutrition->id }}"
                                                            name="breakfast" value="{{ $nutrition->breakfast }}">
                                </div>
                                <div>
                                    порции обеда: <input class="form form-control col-3" type="number" name="dinner"
                                                         data-target="{{ $nutrition->id }}"
                                                         value="{{ $nutrition->dinner }}">
                                </div>
                                <div>
                                    порции ужина: <input class="form form-control col-3" type="number" name="lunch"
                                                         data-target="{{ $nutrition->id }}"
                                                         value="{{ $nutrition->lunch }}">
                                </div>
                            </td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <form class="card p-3">
            <h4>Выставить счёт за дополнительную порцию</h4>

            <div class="form-group required mt-2">
                <label for="name">Название</label>
                <input type="text" name="name" id="name" class="form form-control col-3">
            </div>

            <div class="form-group required">
                <label for="price">Цена</label>
                <input type="number" name="price" id="price" class="form form-control col-3">
            </div>

            <input type="submit" class="btn btn-secondary col-3" value="Добавить счёт">
        </form>
    </div>
    <script>
        $(".form.form-control.col-3").change(function () {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('edit.nutrition') }}",
                data: {
                    id: $(this).attr("data-target"),
                    name: $(this).attr('name'),
                    option: $(this).val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    $('.toast-top-right.success-message').show(300)
                    setTimeout(() => {
                        $('.toast-top-right.success-message').hide(300)
                    }, 4000)
                },
                error: function () {
                    $('.toast-top-right.error-message').show()
                    setTimeout(() => {
                        $('.toast-top-right.error-message').hide(300)
                    }, 4000)
                }
            });
        });
    </script>
@endsection
