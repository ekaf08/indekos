@extends('layouts.app')
@section('title', 'Profil')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Profil</li>
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
        @foreach ($role->menu as $menu)
            @foreach ($menu->sub_menu as $sub_menu)
                @if ($sub_menu->sub_menu_detail->url == $routeName && $sub_menu->select == 't')
                    <div class="card-body">
                        <section class="section">
                            <div class="row" id="table-head">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Update Profil {{ $profil->name }}</h4>
                                        </div>
                                        <form class="form form-vertical" id="form_profil" enctype="multipart/form-data">
                                            <div class="card-body">
                                                @csrf
                                                <div class="form-body">
                                                    <div class="row">

                                                        <!--Upload Profil-->

                                                        <div class="form-group col-md-12 offset-md-0">
                                                            <div class="form-group text-center">
                                                                <button type="button" id="hapus-lampiran"
                                                                    class="btn btn-link text-danger text-bold"
                                                                    style="display: none; float: right;"
                                                                    title="Hapus Lampiran"><i
                                                                        class="bi bi-x-circle-fill"></i>
                                                                </button>
                                                                <img id="preview-image"
                                                                    class="img-fluid img-thumbnail rounded-5 justify-content-start"
                                                                    src="{{ url($profil->path_image ?? '/') }}"
                                                                    alt="Preview Image"
                                                                    style=" max-height: 200px; object-fit: cover; ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="path_image">Profil</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="form-group has-icon-left">
                                                                <div class="position-relative">
                                                                    <input type="file" class="form-control"
                                                                        id="path_image" name="path_image"
                                                                        accept=".png, .jpg, .jpeg">
                                                                    <div class="form-control-icon me-2">
                                                                        <i class="bi bi-image-alt"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!--End Upload Profil-->

                                                        <div class="col-md-2">
                                                            <label for="name">Nama</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="form-group has-icon-left">
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Nama .." name="name" id="name"
                                                                        value="{{ ucwords($profil->name) }}">
                                                                    <div class="form-control-icon">
                                                                        <i class="bi bi-person"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label for="phone">No Handphone</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="form-group has-icon-left">
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="08***" id="phone" name="phone"
                                                                        value="{{ $profil->phone }}">
                                                                    <div class="form-control-icon">
                                                                        <i class="bi bi-phone"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label for="email">Email</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="form-group has-icon-left">
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="email@contoh.com" name="email"
                                                                        id="email" value="{{ $profil->email }}">
                                                                    <div class="form-control-icon">
                                                                        <i class="bi bi-envelope"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label for="address">Alamat</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="form-group ">
                                                                <div class="position-relative">
                                                                    <textarea name="address" id="address" class="form-control " cols="30" rows="5">{{ $profil->address }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label for="old_password">Password Lama</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="form-group has-icon-left">
                                                                <div class="position-relative">
                                                                    <input type="password" class="form-control"
                                                                        placeholder="Password Lama" id="old_password"
                                                                        name="old_password" disabled>
                                                                    <div class="form-control-icon">
                                                                        <i class="bi bi-lock"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label for="password">Password Baru</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="form-group has-icon-left">
                                                                <div class="position-relative">
                                                                    <input type="password" class="form-control"
                                                                        placeholder="Password" id="password"
                                                                        name="password" disabled>
                                                                    <div class="form-control-icon">
                                                                        <i class="bi bi-lock"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label for="confirm_password">Konfirmasi Password</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="form-group has-icon-left">
                                                                <div class="position-relative">
                                                                    <input type="password" class="form-control"
                                                                        placeholder="Konfirmasi Password"
                                                                        id="confirm_password" name="confirm_password"
                                                                        disabled>
                                                                    <div class="form-control-icon">
                                                                        <i class="bi bi-lock"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-10 offset-md-2">
                                                            <div class='form-check'>
                                                                <div class="checkbox">
                                                                    <input type="checkbox" id="ganti_password"
                                                                        class='form-check-input'>
                                                                    <label for="ganti_password">Ganti Password</label>
                                                                </div>
                                                            </div>
                                                            <div class='form-check' id="tampil_password" hidden>
                                                                <div class="checkbox">
                                                                    <input type="checkbox" id="cek_password"
                                                                        class='form-check-input' onclick="cekpass()">
                                                                    <label for="cek_password">Tampilkan Password</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    <div class="col-md-10 offset-md-2 d-flex justify-content-start">
                                                        <button type="button" class="btn btn-primary me-1 mb-1"
                                                            id="btn_simpan">Simpan</button>
                                                        <button type="reset"
                                                            class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                @endif
            @endforeach
        @endforeach
    </div>
@endsection
@includeIf('includes.sweetalert')
@includeIf('includes.summernote')

@push('scripts')
    <script>
        cekpass = () => {
            var x = document.getElementById("password");
            var y = document.getElementById("confirm_password");
            var z = document.getElementById("old_password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }

            if (y.type === "password") {
                y.type = "text";
            } else {
                y.type = "password";
            }

            if (z.type === "password") {
                z.type = "text";
            } else {
                z.type = "password";
            }
        }
        //End menampilkan password dan konfirmasi password

        // untuk menghilangkan readonly password
        $(document).ready(function() {
            $('#ganti_password').change(function() {
                // console.log('disini');
                if (this.checked) {
                    $("#tampil_password").removeAttr("hidden");
                    $('#old_password').removeAttr('disabled');
                    $('#password').removeAttr('disabled');
                    $('#confirm_password').removeAttr('disabled');
                } else {
                    $("#tampil_password").attr("hidden", true);
                    $("#old_password").attr("disabled", true);
                    $("#password").attr("disabled", true);
                    $("#confirm_password").attr("disabled", true);
                }
            })
        });
        //End untuk menghilangkan readonly password

        //Fungsi untuk preview image
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('input[name="path_image"]').change(function() {
            $('#hapus-lampiran').show();
            $('#preview-image').show();
            previewImage(this);
        });

        const hapusLampiran = document.querySelector('#hapus-lampiran');
        const imageTerpilih = document.querySelector('#preview-image');
        const inputImage = document.querySelector('#path_image');

        hapusLampiran.addEventListener('click', function() {
            imageTerpilih.src = '';
            inputImage.value = '';
            $('#hapus-lampiran').hide();
            $('#preview-image').hide();
        })
        //end Fungsi preview image

        // submit ke rout profil update
        $(document).ready(function() {
            $('#btn_simpan').click(function(event) {
                event.preventDefault();
                // Mengambil data dari form
                var formData = new FormData($('#form_profil')[0]);

                // Melakukan permintaan AJAX
                $.ajax({
                    type: 'POST', // Metode HTTP
                    url: '{{ route('profil.update') }}',
                    data: formData,
                    processData: false, // Diperlukan agar FormData tidak diproses secara otomatis
                    contentType: false, // Diperlukan agar tipe konten tidak diatur secara otomatis
                    success: function(response) {
                        showAlert(response.message, 'success');
                    },
                    error: function(errors) {
                        var message = errors.responseJSON.message;
                        showAlert(message, 'gagal');
                        loopErrors(errors.responseJSON.errors);
                        return;
                    }
                });
            });
        });
        // End submit ke rout profil update
    </script>
@endpush
