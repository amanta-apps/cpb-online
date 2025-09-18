<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/machine.png"> Create Master of Inspection</h6>
    <hr class="w-50 mb-3">
    <div class="card shadow-lg border-0 mb-1" id="cardcolor">
        <div class="form-group row mb-0">
            <label for="micdatamic" class="col-sm-2 col-form-label">Master of insp.</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm text-uppercase" id="micdatamic" maxlength="8">
            </div>
            <label for="createondatamic" class="col-sm-2 offset-3 text-right">Created On</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" id="createondatamic" value="<?= date('d/m/Y H:i:s') ?>" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="descdatamic" class="col-sm-2 col-form-label">Desc.</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm text-capitalize" id="descdatamic" maxlength="40">
            </div>
            <label for="createbydatamic" class="col-sm-2 offset-1 text-right">Created By</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm" id="createbydatamic" value="<?= $_SESSION['userid'] ?>" readonly>
            </div>
        </div>
        <div class="form-group row mb-1">
            <label for="spesifikasidatamic" class="col-sm-2 col-form-label">Spesifikasi <sup style="font-size: 6pt;">(full Desc)</sup></label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm text-capitalize" id="spesifikasidatamic" maxlength="40">
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="createbymainresource" class="col-sm-2 text-right">Type</label>
            <div class="col-sm-1">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="radio" id="typequaldatamic" name="typemiccreatemic" checked>
                    <label class="form-check-label" for="cetakprosestopackreviewquality">
                        Qual
                    </label>
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="radio" id="typequandatamic" name="typemiccreatemic">
                    <label class="form-check-label" for="cetakprosestopackreviewquality">
                        Quan
                    </label>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-4">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="simpanmic()"><img src="../asset/icon/save.png"> Simpan</button>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload()"><img src="../asset/icon/cancel.png"> Cancel</button>
            </div>
        </div>
    </div>
    <table id="dmainresources" class="table table-striped table-sm" style="width:100%;">
        <thead class="bg-dark text-white">
            <tr>
                <th style="width: 15%;">Option</th>
                <th>Master of Insp.</th>
                <th>Deskripsi</th>
                <th>Spesifikasi</th>
                <th>Qualitatif</th>
                <th>Quantitatif</th>
                <th>Created On</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $plant = $_SESSION['plant'];
            $unitcode = $_SESSION['unitcode'];
            $sql = mysqli_query($conn, "SELECT * FROM master_inspection WHERE Plant='$plant' AND UnitCode='$unitcode' ORDER BY CreatedOn DESC");
            while ($row = mysqli_fetch_array($sql)) {
            ?>
                <tr>
                    <td>
                        <a href="#" class="badge bg-warning text-decoration-none href_transform" onclick="changedatamic('<?= $row['MIC'] ?>')">Change</a>
                        <a href="#" class="badge bg-danger text-decoration-none href_transform" onclick="deleteddatamic('<?= $row['MIC'] ?>')">Delete</a>
                    </td>
                    <td><?= $row['MIC'] ?></td>
                    <td><?= $row['Descriptions'] ?></td>
                    <td><?= $row['FullyDesc'] ?></td>
                    <td><?= $row['Qual'] ?></td>
                    <td><?= $row['Quan'] ?></td>
                    <td><?= $row['CreatedOn'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>