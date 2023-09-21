<!--Basic Modal -->
<div class="modal fade text-left" id="modal-form" role="dialog" data-bs-backdrop="false" aria-labelledby="myModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">Basic Modal</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="" method="POST">
                @csrf
                @method('post')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Nama User</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Masukan Nama User">
                            </div>

                            <div class="form-group">
                                <label for="email">Email </label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="contoh@email.com">
                                <p id="emailStatus" class="text-sm ms-2"></p>
                            </div>

                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="id_role" id="id_role" class="form-select select-2">
                                    <option value="" selected disabled hidden>-- Pilih --</option>
                                    @foreach ($getRole as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="phone">No Handphone</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="08*******">
                            </div>

                            <div class="form-group">
                                <label for="address">Alamat Lengkap</label>
                                <textarea name="address" id="address" cols="30" rows="4" class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="path_image">Upload Foto</label>
                                <input type="file" class="form-control" id="path_image" name="path_image"
                                    accept=".png, .jpg, .jpeg">
                                <div class="form-group text-left">
                                    <button type="button" id="hapus-lampiran"
                                        class="btn btn-link text-danger text-bold" style="display: none; float: right;"
                                        title="Hapus Lampiran"><i class="bi bi-x-circle-fill"></i>
                                    </button>
                                    <img id="preview-image" class="img-fluid img-thumbnail justify-content-start mt-2"
                                        src="{{ url(Storage::disk('local')->url(auth()->user()->path_image ?? '')) }}"
                                        alt="Preview Image" style=" max-height: 100px; object-fit: cover; ">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                                <div class='form-check mt-2' id="tampil_password">
                                    <div class="checkbox">
                                        <input type="checkbox" id="cek_password" class='form-check-input'
                                            onclick="cekpass()">
                                        <label for="cek_password">Tampilkan Password</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Batal</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
