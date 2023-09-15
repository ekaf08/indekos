<div class="modal fade text-left" id="modal-submenu" tabindex="-1" role="dialog" data-bs-backdrop="false"
    aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1"></h5>
                <button type="button" onclick="location.reload()" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>

            <!--Start Form Action Submenu-->
            <div class="card" id="divSub-1">
                <form action="" method="POST">
                    @csrf
                    @method('post')
                    <div class="modal-body">
                        <div class="col-md-12" hidden>
                            <label for="id_master_menu">Id Master Menu</label>
                            <input type="text" class="form-control" id="id_master_menu" name="id_master_menu">
                            <input type="text" class="form-control" id="master_menu" name="master_menu">
                        </div>

                        <div class="col-md-12">
                            <label for="sub_menu">Sub Menu</label>
                            <input type="text" class="form-control" id="sub_menu" name="sub_menu"
                                placeholder="Masukan Sub Menu">
                        </div>

                        <div class="col-md-12">
                            <label for="routes">Routes</label>
                            <input type="text" class="form-control" id="url" name="url"
                                placeholder="Masukan Routes untuk Sub Menu">
                        </div>

                        <div class="modal-footer mt-3">
                            <div id="footer-button">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Batal</span>
                                </button>

                                <button class="btn btn-primary ml-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!--End Form Action Submenu-->

            <div class="card" id="divSub-2">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table mb-0 table-listSubmenu">
                            <thead class="text-bold">
                                <tr>
                                    <td class="text-center" width="10%">No</td>
                                    <td width="50%">Sub Menu</td>
                                    <td width="25%">Routes</td>
                                    <td class="text-center" width="15%">#</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
