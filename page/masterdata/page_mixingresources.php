<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/machine.png"> MIXING RESOURCES</h6>
    <hr class="w-50 mb-3">
    <div class="card shadow-lg border-0 mb-1" id="cardcolor">
        <div class="form-group row mb-0">
            <label for="resourceidmixingresource" class="col-sm-2 col-form-label">Resource ID</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" id="resourceidmixingresource" value="<?= Getkode('ResourceID', 'crhd_mixing') ?>" readonly>
            </div>
            <label for="createonmixingresource" class="col-sm-2 offset-2 text-right">Create On</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" id="createonmixingresource" value="<?= date('d/m/Y H:i:s') ?>" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="descriptionmixingresource" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm text-capitalize" id="descriptionmixingresource">
            </div>
            <label for="createbymixingresource" class="col-sm-2 offset-1 text-right">Created By</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm" id="createbymixingresource" value="<?= $_SESSION['userid'] ?>" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="merkmixingresource" class="col-sm-2 col-form-label">Merk</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm text-capitalize" id="merkmixingresource">
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="noinventarismixingresource" class="col-sm-2 col-form-label">No Inventaris</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm text-capitalize" id="noinventarismixingresource">
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-4">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="simpanmixingresource()"><img src="../asset/icon/save.png"> Save</button>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload()"><img src="../asset/icon/cancel.png"> Cancel</button>
            </div>
        </div>
    </div>
    <table id="mytables" class="table table-striped table-sm" style="width:100%;">
        <thead class="bg-dark text-white">
            <tr>
                <th style="width: 15%;">Option</th>
                <th>ResourceID</th>
                <th>Descriptions</th>
                <th>Merk</th>
                <th>NoInventaris</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $sql = mysqli_query($conn, 'SELECT * FROM crhd_mixing');
            while ($row = mysqli_fetch_array($sql)) {
            ?>
                <tr>
                    <td>
                        <a href="#" class="badge bg-warning text-decoration-none href_transform" onclick="changedatamixingresource('<?= $row['ResourceID'] ?>')">Change</a>
                        <a href="#" class="badge bg-danger text-decoration-none href_transform" onclick="deleteddatamixingresource('<?= $row['ResourceID'] ?>')">Delete</a>
                    </td>
                    <td><?= $row['ResourceID'] ?></td>
                    <td><?= $row['ResourceDescriptions1'] ?></td>
                    <td><?= $row['Merk'] ?></td>
                    <td><?= $row['NoInventaris'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>