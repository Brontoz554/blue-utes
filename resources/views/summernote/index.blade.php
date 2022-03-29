@extends('layouts.app')
@section('content')
    <style>
        .note-editor.note-frame.panel.panel-default {
            height: 100%;
        }

    </style>
    <div class="container card p-5">
        <textarea name="example" id="example"></textarea>
    </div>

    <script>
        $(document).ready(function () {
            $('#example').summernote();
        });
    </script>
@endsection
