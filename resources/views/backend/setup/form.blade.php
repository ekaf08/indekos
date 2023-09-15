<div class="modal fade text-left" id="modal-form" tabindex="-1" role="dialog" data-bs-backdrop="false"
    aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">Basic Modal</h5>
                <button type="button" onclick="location.reload()" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('post')
                    <div class="col-md-12" id="tambahRole">
                        <label for="nama">Nama Role</label>
                        <input type="text" class="form-control" id="nama" name="nama"
                            placeholder="Masukan Nama Role">
                    </div>

                    @includeIf('backend.setup.table_menu')
                    <div class="modal-footer">
                        <div id="footer-button">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Batal</span>
                            </button>
                            <button class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i> Simpan
                            </button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
