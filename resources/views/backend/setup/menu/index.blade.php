<div class="card">
    @foreach ($role->menu as $menu)
        @foreach ($menu->sub_menu as $sub_menu)
            @if ($sub_menu->sub_menu_detail->url == $routeName && $sub_menu->insert == 't')
                <div class="card-header">
                    <button class="btn btn-primary mb-5" onclick="add_menu(`{{ route('menu.store') }}`, 'Tambah Menu')">
                        <i class="bi bi-plus"></i> Tambah Menu
                    </button>
                </div>
            @endif

            @if ($sub_menu->sub_menu_detail->url == $routeName && $sub_menu->select == 't')
                <div class="card-body">
                    <section class="section">
                        <div class="row" id="table-head">
                            <div class="col-12">
                                <div class="card">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-listMenu">
                                            <thead class="text-bold">
                                                <tr>
                                                    <td class="text-center" width="10%">No</td>
                                                    <td class="text-center">Nama Menu</td>
                                                    <td class="text-center" width="25%">Konfigurasi Sub Menu</td>
                                                    <td class="text-center" width="15%">#</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($lala as $item => $key)
                                                    <tr>
                                                        <td>{{ $item + 1 }}</td>
                                                        <td>{{ $key->menu }}</td>
                                                        <td class="text-center">
                                                            @if ($key->id != '1')
                                                                <button class="btn btn-link text-info"
                                                                    title="Tambah sub menu untuk menu {{ $key->menu }}"
                                                                    onclick="add_submenu(`{{ route('submenu.store') }}`, 'Tambah Submenu {{ $key->menu }}', '{{ encrypt($key->id) }}', '{{ $key->menu }}')">
                                                                    <i class="bi bi-folder-plus"></i>
                                                                </button>

                                                                <button class="btn btn-link text-primary"
                                                                    title="config sub menu untuk menu {{ $key->menu }}"
                                                                    onclick="config_submenu(`{{ route('setup.showSubMenu') }}`, 'Konfigurasi Submenu {{ $key->menu }}', '{{ encrypt($key->id) }}', '{{ $key->menu }}')">
                                                                    <i class="bi bi-gear"></i>
                                                                </button>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($key->id != '1')
                                                                <button type="button" class="btn btn-link text-success"
                                                                    onclick="editMenu(`{{ route('menu.update', encrypt($key->id)) }}`, `Edit Menu`, `{{ $key->menu }}`)"
                                                                    title="Edit Menu - {{ $key->menu }}"><i
                                                                        class="bi bi-pencil-square"></i></button>
                                                                <button type="button" class="btn btn-link text-danger"
                                                                    onclick="deleteData('{{ route('menu.destroy', encrypt($key->id)) }}')"
                                                                    title="Hapus menu {{ $key->menu }}">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            @endif
        @endforeach
    @endforeach
</div>

<!--Start modal menu-->
<div class="modal fade text-left" id="modal-menu" tabindex="-1" role="dialog" data-bs-backdrop="false"
    aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">Basic Modal</h5>
                <button type="button" onclick="location.reload()" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <!--<form action="{{ route('menu.store') }}?pills=menu" method="POST" enctype="multipart/form-data"> -->
            <form action="" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('post')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="menu">Nama Menu : </label>
                                <input type="text" class="form-control @error('menu') is-invalid @enderror"
                                    name="menu" id="menu">
                                @error('menu')
                                    <div class="invalid-feedback">
                                        <p>{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="icon">Icon Menu : </label>
                                <input type="text" name="icon" id="icon" class="form-control">
                                <p class="text-sm text-secondary">Icon menu menggunakan icon
                                    <a href="https://getbootstrap.com/docs/5.0/extend/icons/" target="_blank">
                                        bootstrap.</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-md-end mb-5">
                        <button class="btn btn-primary"> Simpan</button>
                        <button type="reset" class="btn btn-secondary"> Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End modal menu-->

@includeIf('backend.setup.menu.submenu')

@push('scripts')
    <script>
        let modal_submenu = '#modal-submenu';
        let modal_menu = '#modal-menu';

        // Start fungsi untuk tambah menu
        add_menu = (url, title) => {
            $(modal_menu).modal('show');

            $(`${modal_menu} .modal-title`).text(title);
            $(`${modal_menu} form`)[0].reset();
            $(`${modal_menu} form`).attr('action', url);
            $(`${modal_menu} form [name=_method]`).val('post');
            $(`${modal_menu} form [name=menu]`).focus();

            resetInput(`${modal_menu} form`);
        }
        // End fungsi untuk tambah menu

        // fungsi untuk edit menu
        editMenu = (url, title, id, menu) => {
            $.get(url).done(response => {
                $(modal_menu).modal('show');
                $(`${modal_menu} .modal-title`).text(title);
                $(`${modal_menu} form`).attr('action', url);
                $(`${modal_menu} [name=_method]`).val('put')

                resetInput(`${modal_menu} form`);
                loopForm(response.data);
            }).fail(errors => {
                var message = 'Data tidak dapat ditampilkan.'
                showAlert(message, 'gagal')
            });
        }
        // end fungsi untuk edit menu

        // Start Fungsi untuk modal tambah submenu
        function add_submenu(url, title, id, menu) {
            $("#divSub-2").hide();
            $("#divSub-1").show();
            $(modal_submenu).modal('show');
            // console.log(url, title, 'bener disini', id, menu);
            $(`${modal_submenu} .modal-title`).text(title);
            $(`${modal_submenu} form`)[0].reset();
            $(`${modal_submenu} form`).attr('action', url);
            $(`${modal_submenu} form [name=_method]`).val('post');
            $(`${modal_submenu} form [name=id_master_menu]`).val(id);
            $(`${modal_submenu} form [name=master_menu]`).val(menu);
            $(`${modal_submenu} form [name=sub_menu]`).focus();

            resetInput(`${modal_submenu} form`);
        }
        // End Fungsi untuk modal tambah submenu

        // Start tabel config submenu
        config_submenu = (url, title, id, menu) => {
            $("#divSub-1").hide();
            $("#divSub-2").show();
            $(`${modal_submenu} .modal-title`).text(title);
            $(modal_submenu).modal('show');
            let table_subMenu;
            table_subMenu = $('.table-listSubmenu').DataTable({
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
                ajax: {
                    url: '{{ route('setup.showSubMenu') }}',
                    type: 'GET',
                    'data': {
                        id: id,
                        "_token": "{{ csrf_token() }}"
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'sub_menu',
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
                        data: 'url',
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
            })
        }
        // end tabel config submenu

        // edit sub menu
        editSubMenu = (url, title, id, nama) => {
            $.get(url).done(response => {
                    $("#divSub-2").hide();
                    $("#divSub-1").show();
                    $(modal_submenu).modal('show');
                    $(`${modal_submenu} .modal-title`).text(title);
                    $(`${modal_submenu} form`).attr('action', url);
                    $(`${modal_submenu} [name=_method]`).val('put');

                    resetInput(`${modal_submenu} form`);
                    loopForm(response.data);
                })
                .fail(errors => {
                    var message = 'Data tidak dapat ditampilkan.'
                    showAlert(message, 'gagal')
                });
        }
        // End edit sub menu
    </script>
@endpush
