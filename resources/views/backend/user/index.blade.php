@extends('layouts.app')
@section('title', 'User')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">User</li>
@endsection

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('content')
    <div class="card">
        @if ($getAkses->insert == 't')
            <div class="card-header">
                <button class="btn btn-primary" onclick="addForm(`{{ route('user.store') }}`, 'Tambah User')"><i
                        class="bi bi-plus"></i>
                    Tambah User</button>
            </div>
        @endif

        @if ($getAkses->select == 't')
            <div class="card-body">
                <section class="section">
                    <div class="row" id="table-head">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    {{-- <h4 class="card-title">Role</h4> --}}
                                </div>

                                <div class="table-responsive">
                                    <table class="table mb-0 table-user">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="text-center" width="5%">No</th>
                                                <th class="text-center" width="10%"></th>
                                                <th class="text-center">Nama </th>
                                                <th class="text-center">Alamat</th>
                                                <th class="text-center" width="10%">No Hp</th>
                                                <th class="text-center" width="10%">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                @includeIf('backend.kategori.form')
            </div>
        @endif

    </div>
@endsection
@includeIf('includes.datatable')
@includeIf('includes.sweetalert')

@push('scripts')
    <script>
        let modal = '#modal-form';
        let table;

        // ---- Start Datatable
        table = $('.table-user').DataTable({
            processing: true,
            autoWidth: false,
            serverside: true,
            responsive: true,
            columnDefs: [{
                    responsivePriority: 1,
                    targets: 0
                },
                {
                    responsivePriority: 2,
                    targets: -1
                },
            ],
            ajax: {
                url: '{{ route('user.data') }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false,
                },
                {
                    data: 'path_image',
                    render: function(data, type, row) {
                        if (data == null) {
                            return "Tidak Ada";
                        } else {
                            return data
                        }
                    }
                },
                {
                    data: 'nama',
                    render: function(data, type, row) {
                        if (data == null) {
                            return "Tidak Ada";
                        } else {
                            return data
                        }
                    }
                },
                {
                    data: 'address',
                    render: function(data, type, row) {
                        if (data == null) {
                            return "Tidak Ada";
                        } else {
                            return data
                        }
                    }
                },
                {
                    data: 'phone',
                    render: function(data, type, row) {
                        if (data == null) {
                            return "Tidak Ada";
                        } else {
                            return data
                        }
                    }
                },
                {
                    data: 'action',
                    searchable: false,
                    sortable: false
                },
            ],
            'columnDefs': [{
                "targets": [0, 2],
                "className": "text-center",
            }],
            "language": {
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                "infoFiltered": "(disaring dari _MAX_ total data)",
                "lengthMenu": "Menampilkan _MENU_ data",
                "search": "Cari:",
                "zeroRecords": "Tidak ada data yang sesuai",
                /* Kostum pagination dengan element baru */
                "paginate": {
                    "previous": "<i class='bi bi-chevron-left'></i>",
                    "next": "<i class='bi bi-chevron-right'></i>"
                }
            },
            "bDestroy": true
        })
        // ---- End Datatable

        // ---- Start Function untuk tambah data
        function addForm(url, title) {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`)[0].reset();
            $(`${modal} form`).attr('action', url);
            $(`${modal} form [name=_method]`).val('post');
            $(`${modal} form [name=nama]`).focus();
            resetInput(`${modal} form`);
        }
        // ---- End Function untuk tambah data

        // ---- Start Function untuk Edit data
        function editForm(url, title) {
            $.get(url).done(response => {
                    $(modal).modal('show');
                    $(`${modal} .modal-title`).text(title);
                    $(`${modal} form`).attr('action', url);
                    $(`${modal} [name=_method]`).val('put');

                    resetInput(`${modal} form`);
                    loopForm(response.data);
                })
                .fail(errors => {
                    var message = 'Data tidak dapat ditampilkan.'
                    showAlert(message, 'gagal')
                });
        }
        // ---- End Function untuk Edit data
    </script>
@endpush
