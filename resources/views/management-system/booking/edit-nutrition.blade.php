@extends("layouts.adminLayout")
@section("title", "Редактировать рацион")
@section("content")

    <div class="container">
        <div class="card p-2">
            <h5 class="p-2">Рацион клиента {{ $booking->client->name }}</h5>
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
                            <td style="min-width: 150px">
                                <div>
                                    порции завтрака: <b>{{ $nutrition->breakfast }}</b>
                                </div>
                                <div>
                                    порции обеда: <b>{{ $nutrition->dinner }} </b>
                                </div>
                                <div>
                                    порции ужина: <b>{{ $nutrition->lunch }}</b>
                                </div>
                            </td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
