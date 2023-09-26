@extends('layouts.app')
@section('title', 'Web Management')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Web Management</li>
@endsection

@section('content')
    <!--Start Nav-->
    <div id="navRole">
        <!--Start Tab Nav-->
        <nav>
            <div class="nav nav-tabs mb-3" id="nav-tab111" role="tablist">
                <a class="nav-item nav-link active" id="role-tab" data-toggle="tab" href="#nav-role" role="tab"
                    aria-controls="nav-role" aria-selected="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-person-gear" viewBox="0 0 16 16">
                        <path
                            d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm.256 7a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
                    </svg>
                    Role Management
                </a>
                <a class="nav-item nav-link" id="addMenu-tab" data-toggle="tab" href="#nav-addMenu" role="tab"
                    aria-controls="nav-addMenu" aria-selected="false"><i class="bi bi-window-plus"></i> Menu Management</a>
            </div>
        </nav>
        <!--End Tab Nav-->

        <!-- *** Start Tab Content *** -->
        <div class="tab-content" id="nav-tabContent">
            <!-- *** Start Tab Content Role Management *** -->
            <div class="tab-pane fade show active" id="nav-role" role="tabpanel" aria-labelledby="nav-role-tab">
                <div class="card">
                    @foreach ($role->menu as $menu)
                        @foreach ($menu->sub_menu as $sub_menu)
                            <!-- *** Strat Main Role -->
                            @if ($sub_menu->sub_menu_detail->url == $routeName && $sub_menu->insert == 't')
                                <div class="card-header">
                                    <button class="btn btn-primary"
                                        onclick="addForm(`{{ route('setup.store') }}`, 'Tambah Akses Role')"><i
                                            class="bi bi-plus"></i> Tambah Role</button>
                                </div>
                            @endif
                            @if ($sub_menu->sub_menu_detail->url == $routeName && $sub_menu->select == 't')
                                <div class="card-body">
                                    <section class="section">
                                        <div class="row" id="table-head">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        {{-- <h4 class="card-title">Role</h4> --}}
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table class="table mb-0 table-setup">
                                                            <thead class="thead-dark text-bold">
                                                                <tr>
                                                                    <td class="text-center" width="5%">No</td>
                                                                    <td class="text-center">Nama Role</td>
                                                                    <td class="text-center" width="12%">#</td>
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
                                </div>
                            @endif
                            <!-- *** End Main Role -->
                        @endforeach
                    @endforeach
                </div>
            </div>
            <!-- *** End Tab Content Role Management *** -->
            <!-- *** Start Tab Content Menu Management *** -->
            <div class="tab-pane fade" id="nav-addMenu" role="tabpanel" aria-labelledby="nav-addMenu-tab">
                <!-- *** End Main Add Menu -->
                @includeIf('backend.setup.menu.index')
                <!-- *** End Main Add Menu -->
            </div>
            <!-- *** End Tab Content Menu Management *** -->
            <!-- *** Start Tab Content *** -->
        </div>
    </div>
    <!--End Nav-->

    @includeIf('backend.setup.form')
@endsection
@includeIf('includes.datatable')
@includeIf('includes.sweetalert')

@push('scripts')
    <script>
        let modal = '#modal-form';
        let table;

        // --- Start Datatable Role
        table = $('.table-setup').DataTable({
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
                url: '{{ route('setup.data') }}',
                type: 'GET',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'nama',
                    sortable: false,
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
                    render: function(data, type, row) {
                        if (data == null) {
                            return "Tidak Ada";
                        } else {
                            return data
                        }
                    }
                },
            ],
            'columnDefs': [{
                "targets": [0],
                "className": "text-center",
                "width": "4%"
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

        // --- Start fungsi untuk rebuild datatble a href
        function rebuildTable(table) {
            setTimeout(function() {
                table.columns.adjust().responsive.recalc();
            }, 500);
        }

        $(document).ready(function() {
            var hash = document.location.hash
            if (hash) {
                tab = document.querySelector('#nav-tab111 a' + document.location.hash + '-tab')
                bootstrap.Tab.getInstance(tab).show()
            }

            var triggerTabList = [].slice.call(document.querySelectorAll('#nav-tab111 a'))
            triggerTabList.forEach(function(triggerEl) {
                var tabTrigger = new bootstrap.Tab(triggerEl)
                triggerEl.addEventListener('click', function(event) {
                    event.preventDefault();
                    tabTrigger.show();
                    rebuildTable(table);
                })
            })
        })
        // --- End fungsi untuk rebuild datatble a href
        // --- End Datatable Role

        // ---- Start Function untuk tambah data
        function addForm(url, title) {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`)[0].reset();
            $(`${modal} form`).attr('action', url);
            $(`${modal} form [name=_method]`).val('post');
            $(`${modal} form [name=nama]`).focus();
            resetInput(`${modal} form`);

            // menghilangkan nav tabs ketika tambah form
            $('#navMenu').hide();
            $('#tambahRole').show();
            $('#footer-button').show();
            $(`${modal} .modal-footer`).show();
            $(`${modal}`).removeClass(" modal-xl");
            $(`${modal}`).addClass(" modal-lg");
        }
        // ---- End Function untuk tambah data

        //  --- Start Edit
        function editForm(url, title, id_role) {
            $(modal).modal('show');
            // menghilangkan form tambah role ketika edit
            $('#tambahRole').hide();
            $('#footer-button').hide();
            $(`${modal} .modal-footer`).hide();
            $('#navMenu').show();
            $(`${modal}`).removeClass(" modal-lg");
            $(`${modal}`).addClass(" modal-xl");
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('put');
            $.get(url).done(response => {
                    resetInput(`${modal} form`);
                    loopForm(response.data);
                })
                .fail(errors => {
                    var message = 'Data tidak dapat di tampilkan'
                    showAlert(message, 'gagal')
                })
            // --- Start Datatable Menu
            let table_menu;
            table_menu = $('.table-menu').DataTable({
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
                    url: '{{ route('setup.menu') }}',
                    type: 'POST',
                    'data': {
                        "_token": "{{ csrf_token() }}",
                        id_role: id_role,
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'nama_menu',
                        sortable: false,
                        render: function(data, type, row) {
                            if (data == null) {
                                return "Tidak Ada";
                            } else {
                                return data
                            }
                        }
                    },
                    {
                        data: 'deleted_at',
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
                        render: function(data, type, row) {
                            if (data == null) {
                                return "Tidak Ada";
                            } else {
                                return data
                            }
                        }
                    },
                ],
                'columnDefs': [{
                    "targets": [0, 2, 3],
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
            // --- End Datatable Menu

            // --- Start Datatable SubMenu
            let table_sub_menu;
            table_sub_menu = $('.table-sub-menu').DataTable({
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
                    url: '{{ route('setup.subMenu') }}',
                    type: 'POST',
                    'data': {
                        "_token": "{{ csrf_token() }}",
                        id_role: id_role,
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'nama_sub_menu',
                        sortable: false,
                        render: function(data, type, row) {
                            if (data == null) {
                                return "Tidak Ada";
                            } else {
                                return data
                            }
                        }
                    },
                    {
                        data: 'select',
                        render: function(data, type, row) {
                            if (data == null) {
                                return "Tidak Ada";
                            } else {
                                return data
                            }
                        }
                    },
                    {
                        data: 'insert',
                        render: function(data, type, row) {
                            if (data == null) {
                                return "Tidak Ada";
                            } else {
                                return data
                            }
                        }
                    },
                    {
                        data: 'update',
                        render: function(data, type, row) {
                            if (data == null) {
                                return "Tidak Ada";
                            } else {
                                return data
                            }
                        }
                    },
                    {
                        data: 'delete',
                        render: function(data, type, row) {
                            if (data == null) {
                                return "Tidak Ada";
                            } else {
                                return data
                            }
                        }
                    },
                    {
                        data: 'export',
                        render: function(data, type, row) {
                            if (data == null) {
                                return "Tidak Ada";
                            } else {
                                return data
                            }
                        }
                    },
                    {
                        data: 'import',
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
                        render: function(data, type, row) {
                            if (data == null) {
                                return "Tidak Ada";
                            } else {
                                return data
                            }
                        }
                    },
                ],
                'columnDefs': [{
                    "targets": [0, 2, 3, 4, 5, 6, 7, 8],
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
            // --- End Datatable SubMenu

            // --- Start fungsi untuk rebuild Menu datatble a href
            function rebuildTable(table) {
                setTimeout(function() {
                    table.columns.adjust().responsive.recalc();
                }, 500);
            }

            $(document).ready(function() {
                var hash = document.location.hash
                if (hash) {
                    tab = document.querySelector('#nav-tab a' + document.location.hash + '-tab')
                    bootstrap.Tab.getInstance(tab).show()
                }

                var triggerTabList = [].slice.call(document.querySelectorAll('#nav-tab a'))
                triggerTabList.forEach(function(triggerEl) {
                    var tabTrigger = new bootstrap.Tab(triggerEl)
                    triggerEl.addEventListener('click', function(event) {
                        event.preventDefault();
                        tabTrigger.show();
                        rebuildTable(table_menu);
                        rebuildTable(table_sub_menu);
                    })
                })
            })
            // --- End fungsi untuk rebuild Menu datatble a href
        }
        //  --- End Edit


        // --- Start ceklis aktif / tidak aktif untuk sub menu
        $('.table-sub-menu').on('change', 'input[type="checkbox"]', function(e) {
            var id = $(this).data('id');
            var kolom = $(this).data('kolom');

            if ($(this).is(":checked")) {
                var value = 'true'
            } else {
                var value = 'false'
            }

            $.ajax({
                url: "{{ route('setup.configMenu') }}",
                method: 'POST',
                data: {
                    // data yang ingin dikirim ke server
                    id: id,
                    kolom: kolom,
                    value: value,
                    _token: $('[name=csrf-token]').attr('content'),
                },
                success: function(response) {
                    showAlert(response.message, 'success');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseJSON.message);
                    var message = jqXHR.responseJSON.message;
                    showAlert(message, 'gagal')
                }
            });
        });
        // --- End ceklis aktif / tidak aktif untuk sub menu

        // --- Start Fungsi untuk menambah sub menu
        function add_SubMenu(url) {
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: $('[name=csrf-token]').attr('content'),
                },
                success: function(response) {
                    showAlert(response.message, 'success');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    gagal();
                }
            })
        }
        // --- End Fungsi untuk menambah sub menu

        // --- Table menu nav pills
        let tableListMenu;

        tableListMenu = $('.table-listMenu').DataTable({
            processing: true,
            autoWidth: false,
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
        })


        $(document).ready(function() {
            // --- Start ceklis aktif / tidak aktif untuk menu
            $('.table-menu').on('change', 'input[type="checkbox"]', function(e) {
                console.log('dsfjk');
                var id = $(this).data('id');
                var kolom = $(this).data('kolom')

                if ($(this).is(":checked")) {
                    $.ajax({
                        url: "{{ route('setup.restore_menu') }}",
                        method: 'POST',
                        data: {
                            // data yang ingin dikirim ke server
                            id: id,
                            _token: $('[name=csrf-token]').attr('content'),
                        },
                        success: function(response) {
                            showAlert(response.message, 'success');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            gagal();
                        }
                    });
                } else {
                    $.ajax({
                        url: "{{ route('setup.hapus_menu') }}",
                        method: 'DELETE',
                        data: {
                            // data yang ingin dikirim ke server
                            id: id,
                            _token: $('[name=csrf-token]').attr('content'),
                        },
                        success: function(response) {
                            showAlert(response.message, 'success');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            gagal();
                        }
                    });
                }
            })
            // --- End ceklis aktif / tidak aktif untuk menu

            //start fungsi untuk button urutan menu
            $('.table-menu').on('click', 'button[id="atas"]', function(e) {
                console.log('halo aku di klik button atas');

                var id = $(this).data('id');
                var urutan = $(this).data('urutan');

                if (urutan === 1) {
                    var message = 'Menu sudah diurutan pertama.'
                    showAlert(message, 'gagal');
                    return;
                } else {
                    $.ajax({
                        url: `{{ route('setup.urutanMenu') }}`,
                        method: `POST`,
                        data: {
                            id: id,
                            direction: 'up',
                            _token: $('[name=csrf-token]').attr('content'),
                        },
                        success: function(response) {
                            showAlert(response.message, 'success');
                            timeOut();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            var message = 'Sort menu gagal di simpan.'
                            showAlert(message, 'gagal');
                        }
                    })
                }
            })

            $('.table-menu').on('click', 'button[id="bawah"]', function(e) {
                var id = $(this).data('id');

                $.ajax({
                    url: `{{ route('setup.urutanMenu') }}`,
                    method: `POST`,
                    data: {
                        id: id,
                        direction: 'down',
                        _token: $('[name=csrf-token]').attr('content'),
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.success === true) {
                            showAlert(response.message, 'success');
                            timeOut();
                        } else if (response.success === false) {
                            showAlert(response.message, 'gagal');
                            timeOut();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        var message = 'Sort menu gagal di simpan.'
                        showAlert(message, 'gagal');
                    }
                })
            })
            //end fungsi untuk button urutan menu
        })

        // ---- Start Function Submit Form
        $(function() {
            $('#modal-form').on('submit', function(e) {
                if (!e.preventDefault()) {
                    $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                        .done((response) => {
                            // Tampilkan SweetAlert dengan pesan sukses
                            showAlert(response.message, 'success');

                            // Reset form setelah berhasil
                            $(`${modal} form`)[0].reset();
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                        })
                        .fail((errors) => {
                            var message = 'Data gagal disimpan.'
                            if (errors.status == 422) {
                                // console.log(errors.responseJSON.message);
                                showAlert(message, 'gagal');
                                loopErrors(errors.responseJSON.errors);
                                return;
                            }
                            showAlert(message, 'gagal');
                        })
                }
            })
        });
        // ---- END Form 
    </script>
@endpush
