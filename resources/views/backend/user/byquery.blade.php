@push('css_vendor')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
@endpush
@extends('layouts.app')
@section('title', 'By Query')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
    <li class="breadcrumb-item active">By Query</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <section class="section">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <form action="{{ route('getdata.sql') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="tabel">Tabel</label>
                                    <select name="tabel" id="tabel" class="form-select select2">
                                        <option value="" selected disabled hidden>-- Pilih --</option>
                                        @foreach ($tables as $table)
                                            <option value="{{ $table->tablename }}">{{ $table->tablename }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="kolom">Kolom</label>
                                    <select name="kolom[]" id="kolom" class="form-select select2" multiple="multiple"
                                        disabled>
                                    </select>
                                </div>
                                <button class="btn btn-primary">Go</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection
@push('scripts_vendor')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {
            $(`.select2`).select2({
                placeholder: 'Pilih Data',
                theme: 'bootstrap-5',
            });

            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });

            $('#tabel').change(function() {
                let tabel = $(this).val();
                $('#kolom').empty();
                if (tabel) {
                    $.ajax({
                        url: '{{ route('user.getColumn') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            tabel: tabel
                        },
                        success: function(response) {
                            $('#kolom').prop('disabled', false);
                            $('#kolom').append(
                                // '<option value="" selected disabled hidden>-- Pilih --</option>'
                            );
                            response['kolom'].forEach(element => {
                                $('#kolom').append(
                                    '<option value="' + element + '">' + element +
                                    '</option>'
                                );
                            });
                        }
                    });
                } else {
                    $('#kolom').prop('disabled',
                        true); // Nonaktifkan dropdown pengguna jika tidak ada peran yang dipilih
                    $('#kolom').html('<option value="">Pilih Pengguna</option>');
                }
            });
        })
    </script>
@endpush
