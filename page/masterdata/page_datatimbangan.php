<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/scale2.png"> Daftar Timbangan</h6>
    <hr class="w-50 mb-3">
    <div class="card shadow-lg border-0 mb-1" id="cardcolor">
        <div class="form-group row mb-0">
            <label for="ipaddressdatatimbangan" class="col-sm-2 col-form-label">IP Address</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" id="ipaddressdatatimbangan" placeholder="19x.xxx.xxx.xxx">
            </div>
            <label for="createondatatimbangan" class="col-sm-2 offset-2">Created On</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" id="createondatatimbangan" value="<?= date('d/m/Y H:i:s') ?>" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="namatimbangandatatimbangan" class="col-sm-2 col-form-label">Nama Timbangan</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" id="namatimbangandatatimbangan">
            </div>
            <label for="createdbydatatimbangan" class="col-sm-2 offset-2">Created By</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm" id="createdbydatatimbangan" value="<?= $_SESSION['userid'] ?>" readonly>
            </div>
        </div>
        <div class="form-group row mb-1">
            <label for="detaillokasidatatimbangan" class="col-sm-2 col-form-label">Detail Lokasi <sup>(optional)</sup></label>
            <div class="col-sm-3">
                <textarea id="detaillokasidatatimbangan" class="form-control form-control-sm" cols="20" rows="3"></textarea>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="portdatatimbangan" class="col-sm-2 col-form-label">Port</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm" id="portdatatimbangan">
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-4">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="simpandaftartimbangan()"><img src="../asset/icon/save.png"> Save</button>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload()"><img src="../asset/icon/cancel.png"> Cancel</button>
            </div>
        </div>
    </div>
    <table id="dproduct" class="table table-striped table-sm" style="width:100%">
        <thead class="bg-dark text-white">
            <tr>
                <th style="width: 15%;">#</th>
                <th>IP Address</th>
                <th>Nama Timbangan</th>
                <th>Detail Lokasi</th>
                <th>Port</th>
                <th>Created By</th>
                <th>Created On</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $plant = $_SESSION['plant'];
            $unitcode = $_SESSION['unitcode'];
            $sql = mysqli_query($conn, "SELECT * FROM mapping_timbangan WHERE Plant='$plant' AND UnitCode='$unitcode'");
            while ($row = mysqli_fetch_array($sql)) {
            ?>
                <tr>
                    <td>
                        <a href="#" class="badge bg-warning text-decoration-none href_transform" onclick="changedatatimbangan('<?= $row['AddressOf'] ?>')"> Change</a>
                        <a href="#" class="badge bg-danger text-decoration-none href_transform" onclick="deletedatatimbangan('<?= $row['AddressOf'] ?>')"> Delete</a>
                    </td>
                    <td><?= $row['AddressOf'] ?></td>
                    <td><?= $row['NamaTimbangan'] ?></td>
                    <td><?= $row['DetailLokasi'] ?></td>
                    <td><?= $row['PortOf'] ?></td>
                    <td><?= $row['CreatedBy'] ?></td>
                    <td><?= $row['CreatedOn'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>