<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/supplier.png"> DAFTAR SUPPLIER</h6>
    <hr class="w-50 mb-3">
    <div class="card shadow-lg border-0 mb-1" id="cardcolor">
        <div class="form-group row mb-0" hidden>
            <label for="kodesupplierdatasupplier" class="col-sm-2 col-form-label">Kode Pemasok</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm text-uppercase" id="kodesupplierdatasupplier" value="<?= Getkode('Idpemasok', 'data_pemasok') ?>" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="namasupplierdatasupplier" class="col-sm-2 col-form-label">Nama Supplier</label>
            <div class="col-sm-5">
                <input type="text" class="form-control form-control-sm" id="namasupplierdatasupplier">
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="keterangandatasupplier" class="col-sm-2 col-form-label">Keterangan</label>
            <div class="col-sm-5">
                <textarea id="keterangandatasupplier" class="form-control form-control-sm" rows="2"></textarea>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-4">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="simpandatasupplier()"><img src="../asset/icon/save.png"> Save</button>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload()"><img src="../asset/icon/cancel.png"> Cancel</button>
            </div>
        </div>
    </div>
    <table id="dmenu" class="table table-striped table-sm" style="width:100%">
        <thead class="bg-dark text-white">
            <tr>
                <th style="width: 5%;"></th>
                <th>Nama Pemasok</th>
                <th style="width: 5%;">Created On</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $sql = mysqli_query($conn, "SELECT * FROM data_pemasok WHERE Plant='$plant'");
            while ($row = mysqli_fetch_array($sql)) {
            ?>
                <tr>
                    <td>
                        <a href="#" class="badge bg-warning text-decoration-none href_transform" onclick="changedatasupplier('<?= $row['KodeSupplier'] ?>')">Change</a>
                        <a href="#" class="badge bg-danger text-decoration-none href_transform" onclick="deletedatasupplier('<?= $row['KodeSupplier'] ?>')">Delete</a>
                    </td>
                    <td><?= $row['Descriptions'] ?></td>
                    <td><?= beautydate2($row['CreatedOn']) ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>