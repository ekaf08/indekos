@push('css_vendor')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
@endpush
@push('scripts_vendor')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $(`.select-2`).select2({
                placeholder: 'Pilih Role',
                theme: 'bootstrap-5',
                dropdownParent: $("#modal-form")
            });

            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });
        })
    </script>
@endpush
