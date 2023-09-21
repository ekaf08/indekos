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
                                                <th class="text-center" width="10%">Profil</th>
                                                <th class="text-center" width="20%">Nama </th>
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
                <!--Modal untuk menampilkan gambar-->
                <!-- Modal -->
                <div class="modal fade" id="modal_image" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal_image_title"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <img id="img_src" src="" class="d-block w-100" alt="...">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer"></div>
                        </div>
                    </div>
                </div>
                <!--End Modal untuk menampilkan gambar-->
            </div>
        @endif

    </div>
@endsection
@includeIf('includes.datatable')
@includeIf('includes.sweetalert')

@push('scripts')
    <script>
        let modal = '#modal-form';
        let modal_image = '#modal_image';
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
                "targets": [0, 1],
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

        // fungsi untuk zoom  image yang ada di dalam tabel user 
        $(document).ready(function() {
            $('.table-user').on('click', 'a', function() {
                var img = $(this).data('img');
                var nama = $(this).data('nama');

                $(modal_image).modal('show');
                $(`${modal_image} .modal-title`).text(nama)
                $(`${modal_image} #img_src`).attr('src', img);
            })
        })
        // End fungsi untuk zoom  image 

        $('body').on('hidden.bs.modal', '.modal', function() {
            console.log("modal closed");

        });
    </script>
@endpush
