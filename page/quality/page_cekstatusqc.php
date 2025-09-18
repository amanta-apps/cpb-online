<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/lab.png"> Cek Status Analisa QC</h6>
    <hr class="w-50 mb-3">
    <div class="card shadow-lg border-0 mb-1" id="cardcolor">
        <div class="form-group row mb-0">
            <label for="idprodukdataproduk" class="col-sm-2 col-form-label">Scan Barcode</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm text-lowercase" id="scanbarcodecekstatusqc" onkeypress="cekstatusqc()">
            </div>
        </div>
        <div class="form-group row mb-0">
            <!-- <label for="floatingTextarea2" class="col-sm-2 col-form-label">Keterangan</label> -->
            <div class="col-sm-4 offset-2 form-floating">
                <textarea class="form-control h-100 fw-bold bg-transparent" placeholder="Leave a comment here" id="statusqccekstatusqc" style="font-size: 30pt;" readonly></textarea>
                <label for="floatingTextarea2" class="px-3">Status QC</label>
            </div>
        </div>
        <!-- <div class="form-group row mt-5" id="statusqccekstatusqc">

        </div> -->
        <div class="form-group row mb-0 col-sm-4 offset-2 text-end mt-3" id="showhasilanalisacekstatusqc" hidden>
            <a href="#" class="text-decoration-none" onclick="message(1)"> show hasil analisa >></a>
        </div>
        <!-- <div class="form-group row mb-0">
            <label for="idprodukdataproduk" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm text-lowercase" id="menudaftarmenu" readonly>
            </div>
        </div> -->
        <!-- <hr> -->
        <!-- <div class="form-group row">
            <div class="col-sm-4">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="simpanmenu()"><img src="../asset/icon/save.png"> Save</button>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload()"><img src="../asset/icon/cancel.png"> Cancel</button>
            </div>
        </div> -->
    </div>
</div>