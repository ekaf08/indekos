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

        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    @if ($getAkses->insert == 't')
                        <button class="btn btn-primary me-4" onclick="addForm(`{{ route('user.store') }}`, 'Tambah User')"><i
                                class="bi bi-plus"></i>
                            Tambah User</button>
                    @endif
                </div>
                <div class="col-6 text-end">
                    @if ($getAkses->export == 't')
                        <a href="{{ route('user.xlsx') }}" class="btn btn-success" title="Export User Xlsx"><i
                                class="bi bi-filetype-xlsx"></i>
                            Export Xlsx</a>
                        <button class="btn btn-danger" onclick="addForm(`{{ route('user.store') }}`, 'Tambah User')"><i
                                class="bi bi-file-pdf" title="Export User Pdf"></i>
                            Export Pdf</button>
                        <a href="{{ route('user.byquery') }}" class="btn btn-info" title="Export by query"> Export by
                            query</a>
                    @endif
                </div>
            </div>
        </div>

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
                @includeIf('backend.user.form')
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
@includeIf('includes.select2')
@includeIf('includes.previewImage')

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
            $('#emailStatus').text('').removeClass('text-danger');
            $('#email').removeClass('is-invalid');
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`)[0].reset();
            $(`${modal} form`).attr('action', url);
            $(`${modal} form [name=_method]`).val('post');
            $(`${modal} form [name=nama]`).focus();
            resetInput(`${modal} form`);
            resetData();

        }
        // ---- End Function untuk tambah data

        // start fungsi untuk reset select2 dan preview image
        function resetData() {
            $('.select2').trigger('change');
            $(`#preview-image`).attr('src', '').hide();
            $('#hapus-lampiran').hide();
        }
        // End start fungsi untuk reset select2 dan preview image

        // ---- Start Function untuk Edit data
        function editForm(url, title) {
            $.get(url).done(response => {
                    $('#emailStatus').text('').removeClass('text-danger');
                    $('#email').removeClass('is-invalid');
                    $(modal).modal('show');
                    $(`${modal} .modal-title`).text(title);
                    $(`${modal} form`).attr('action', url);
                    $(`${modal} [name=_method]`).val('put');

                    resetInput(`${modal} form`);
                    loopForm(response.data);
                    resetData();
                })
                .fail(errors => {
                    var message = 'Data tidak dapat ditampilkan.'
                    showAlert(message, 'gagal')
                });
        }
        // ---- End Function untuk Edit data

        // fungsi untuk zoom image yang ada di dalam tabel user
        $(document).ready(function() {
            $('.table-user').on('click', 'a', function() {
                var img = $(this).data('img');
                var nama = $(this).data('nama');

                $(modal_image).modal('show');
                $(`${modal_image} .modal-title`).text(nama)
                $(`${modal_image} #img_src`).attr('src', img);
            })
        })
        // End fungsi untuk zoom image

        $('body').on('hidden.bs.modal', '.modal', function() {
            console.log("modal closed");
        });

        // fungsi untuk cek passsword
        cekpass = () => {
            var x = document.getElementById("password");

            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
        // fungsi untuk cek passsword

        // Cek email menggunakan fungsi key up
        $(document).ready(function() {
            $('#email').keyup(function() {
                var email = $('#email').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('cek_email') }}',
                    data: {
                        _token: csrfToken,
                        email: email
                    },
                    success: function(response) {
                        if (response.exists) {
                            var message = response.errors.email[0]
                            $('#email').addClass('is-invalid');
                            $('#emailStatus').text(message).addClass('text-danger');
                        } else {
                            // $('#emailStatus').text('Alamat email tersedia.').add('color','green');
                            $('#emailStatus').text('').removeClass('text-danger');
                            $('#email').removeClass('is-invalid');
                        }
                    },
                    error: function() {
                        $('#emailStatus').text('Terjadi kesalahan dalam memeriksa email.').css(
                            'color', 'red');
                    }
                });
            });
        });
        //End Cek email menggunakan fungsi key up


        // fungsi untuk submit Form
        function submitForm(originalForm) {
            console.log(originalForm);
            $.post({
                    url: $(originalForm).attr('action'),
                    data: new FormData(originalForm),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false
                })
                .done(response => {
                    $(modal).modal('hide');
                    showAlert(response.message, 'success');
                    table.ajax.reload();
                })
                .fail(errors => {
                    // console.log(errors.responseJSON.errors);
                    // return;
                    var message = 'Data gagal disimpan.'
                    if (errors.status == 422) {
                        // console.log(errors.responseJSON.message);
                        showAlert(message, 'gagal');
                        loopErrors(errors.responseJSON.errors);
                        return;
                    }

                    showAlert(message, 'gagal');
                });
        }
        //End fungsi untuk submit Form
    </script>
@endpush
