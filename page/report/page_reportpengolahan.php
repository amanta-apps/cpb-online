<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/report.png"> Input Parameter Report - Pengolahan</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <label for="personalnumberemployee" class="col-sm-2 col-form-label">Nomor Planning<sup class="text-danger">*</sup></label>
        <div class="col-sm-2">
            <div class="input-group mb-1">
                <input type="text" class="form-control" placeholder="Nomor Planning" aria-label="Recipient's username" aria-describedby="button-addon2" id="nomorplanningreportpengolahan">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchplanningreportpengolahan"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
    </div>
    <div class="form-group row mb-1">
        <label for="yearreportpengolahan" class="col-sm-2 col-form-label">Years</label>
        <div class="col-sm-1">
            <input type="number" class="form-control" id="yearreportpengolahan" value="<?= date('Y') ?>" max="<?= date('Y') ?>">
        </div>
    </div>
    <div class="form-group row mb-0" id="nomesinreportpengolahan" hidden>
        <label for="selectnomesinreportpengolahan" class="col-sm-2 col-form-label">No Mesin Mix</label>
        <div class="col-sm-4">
            <select name="" id="selectnomesinreportpengolahan" class="form-select form-select-sm"></select>
        </div>
    </div>
    <div class="form-group row mt-3 mb-0">
        <div class="col-sm-4 offset-2">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="jenistransaksi" id="rencanakerjapencampuran" checked onchange="pilihanpengolahan(this.checked)">
                <label class="form-check-label" for="jenistransaksi">
                    Rencana Kerja Pencampuran
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="jenistransaksi" id="hasiltimbang" onchange="pilihanpengolahan(this.checked)">
                <label class="form-check-label" for="hasiltimbang">
                    Laporan Hasil Timbang
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="jenistransaksi" id="lampiranpengolahan" onchange="pilihanpengolahan(this.checked)">
                <label class="form-check-label" for="lampiranpengolahan">
                    Lampiran
                </label>
            </div>
        </div>
    </div>
    <div class="form-group row mt-3">
        <div class="col-sm-2 offset-2">
            <button type="button" class="btn btn-outline-dark btn-sm" onclick="showreportpengolahan()"><img src="../asset/icon/accept.png"> Submit</button>
        </div>
    </div>
</div>
<!-- Planning Number-->
<div class="modal fade" id="searchplanningreportpengolahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">List Planning Number</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="reportpengolahan" class="table table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Planing Number</th>
                            <th>Years</th>
                            <th>Product ID</th>
                            <th>Descriptions</th>
                            <th>Batch</th>
                            <!-- <th>Expired Date</th> -->
                            <th>Created On</th>
                            <!-- <th>Created By</th> -->
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End -->