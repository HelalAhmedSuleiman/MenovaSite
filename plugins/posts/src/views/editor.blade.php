@php
    $name = isset($name) ? $name : "content";
    $value = isset($value) ? $value : "";
    $id = isset($id) ? $id : "post-content";
    $placeholder = isset($placeholder) ? $placeholder : "Please enter value";
@endphp

<link rel="stylesheet" href="{{ url('css/editor.css') }}"/>

<style>
    .note-editor {
        min-height: unset;
        margin-bottom: 19px;
        border: 1px solid #e5e6e7 !important;
    }
</style>

<textarea name="{{ $name }}" class="summernote {{ $id }}">{{ $value }}</textarea>

@push("footer")
    <script src="{{ url('js/editor.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.{{ $id }}').summernote({
                placeholder: '{{ $placeholder }}',
                height: 100,
                tabsize: 2
            });
        });
    </script>
@endpush

