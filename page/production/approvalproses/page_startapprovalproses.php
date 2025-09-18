<div class="container">
    <h6 class="fw-bold mt-3 text-start">APPROVAL PROSES</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row">
        <label for="jenisprosesstartapprovalproses" class="col-sm-2 col-form-label">Jenis Proses</label>
        <div class="col-sm-2">
            <select class="form-select form-select-sm" id="jenisprosesstartapprovalproses">
                <option selected></option>
                <option value="Hoper">Hoper</option>
                <option value="Topack">Topack</option>
                <option value="Pillow Pack">Pillow Pack</option>
                <option value="analisapengemasansekunder">Analisa Pengemasan Sekunder</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="statusstartapprovalproses" class="col-sm-2 col-form-label">Status</label>
        <div class="col-sm-2">
            <select class="form-select form-select-sm" id="statusstartapprovalproses">
                <?php
                $i = 1;
                $sql = mysqli_query($conn, "SELECT Descriptions FROM text_sys WHERE JenisProses='approval'");
                while ($r = mysqli_fetch_array($sql)) { ?>
                    <option value="<?= $r['Descriptions'] ?>"><?= $i . '. ' . $r['Descriptions'] ?></option>
                <?php
                    $i++;
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="createonfromstartapprovalproses" class="col-sm-2 col-form-label">Created On</label>
        <div class="col-sm-2">
            <input type="date" class="form-control form-control-sm" id="createonfromstartapprovalproses" value="<?= date('Y-m-d', strtotime('-7 days', strtotime(date('Y-m-d'))));  ?>">
        </div>
        <label for="createontostartapprovalproses" class="col-sm-1 col-form-label">To</label>
        <div class="col-sm-2">
            <input type="date" class="form-control form-control-sm" id="createontostartapprovalproses" value="<?= date('Y-m-d') ?>">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-2 offset-2 mt-2">
            <button type="button" class="btn btn-outline-success btn-sm" onclick="submitstartapprovalproses()"><img src="../asset/icon/search.png"> Submit</button>
        </div>
    </div>
</div>