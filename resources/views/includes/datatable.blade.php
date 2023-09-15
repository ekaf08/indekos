@push('css_vendor')
    {{-- <link rel="stylesheet"
        href="{{ asset('/backend/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/backend/assets/css/pages/datatables.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('/backend/assets/vendors/jquery-datatables/custom/datatables.css') }}">
@endpush

@push('scripts_vendor')
    {{-- <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script src="{{ asset('/backend/assets/js/pages/datatables.js') }}"></script> --}}
    <script src="{{ asset('/backend/assets/vendors/jquery-datatables/custom/datatables.js') }}"></script>
@endpush
