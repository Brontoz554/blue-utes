@extends('layouts.adminLayout')
@section('content')
    <style>
        .note-editor.note-frame.panel.panel-default {
            height: 100%;
        }

        .note-editable {
            height: 350px;
        }

    </style>
    <div class="container card p-5">
        <h2>Пример наполнения контента</h2>
        <textarea name="example" id="example" cols="10" rows="10"></textarea>
    </div>

    <script>
        $(document).ready(function () {
            $('#example').summernote();
        });
    </script>
@endsection
