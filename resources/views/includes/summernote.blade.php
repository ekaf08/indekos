@push('css_vendor')
    <link rel="stylesheet" href="{{ asset('backend/assets/extensions/summernote/summernote-lite.css') }}">

    <link rel="stylesheet" href="{{ asset('backend/assets/compiled/css/form-editor-summernote.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('backend/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/compiled/css/app-dark.css') }}"> --}}
@endpush

@push('scripts_vendor')
    {{-- <script src="{{ asset('backend/assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('backend/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('backend/assets/extensions/jquery/jquery.min.js') }}"></script> --}}

    <script src="{{ asset('backend/assets/extensions/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('backend/assets/static/js/pages/summernote.js') }}"></script>
@endpush
