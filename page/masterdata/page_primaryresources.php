<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/machine.png"> PRIMARY RESOURCES</h6>
    <hr class="w-50 mb-3">
    <div class="card shadow-lg border-0 mb-1" id="cardcolor">
        <div class="form-group row mb-0">
            <label for="primaryresourceidprimaryresource" class="col-sm-2 col-form-label">Primary Resource ID</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" id="primaryresourceidprimaryresource" value="<?= Getkode('PrimaryResourceID', 'crhd_primary') ?>" readonly>
            </div>
            <!-- <label for="createonprimaryresource" class="col-sm-2 offset-2 text-right">Create On</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" id="createonprimaryresource" value="<?= date('d/m/Y H:i:s') ?>" readonly>
            </div> -->
        </div>
        <div class="form-group row mb-0">
            <label for="descriptionprimaryresource" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm text-capitalize" id="descriptionprimaryresource">
            </div>
            <!-- <label for="createbyprimaryresource" class="col-sm-2 offset-1 text-right">Created By</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm" id="createbyprimaryresource" value="<?= $_SESSION['userid'] ?>" readonly>
            </div> -->
        </div>
        <div class="form-group row mb-0">
            <label for="merkprimaryresource" class="col-sm-2 col-form-label">Merk</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm text-capitalize" id="merkprimaryresource">
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="noinventarisprimaryresource" class="col-sm-2 col-form-label">No Inventaris</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm text-capitalize" id="noinventarisprimaryresource">
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="typeprimaryresource" class="col-sm-2 col-form-label">Type</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm text-capitalize" id="typeprimaryresource">
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="activestatusprimaryresource" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-2">
                <select class="form-select form-select-sm" id="activestatusprimaryresource">
                    <option value="0">None</option>
                    <option value="1">Active</option>
                </select>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-4">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="simpanprimaryresource()"><img src="../asset/icon/save.png"> Save</button>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload()"><img src="../asset/icon/cancel.png"> Cancel</button>
            </div>
        </div>
    </div>
    <table id="mytables" class="table table-striped table-sm" style="width:100%;">
        <thead class="bg-dark text-white">
            <tr>
                <th style="width: 15%;">Option</th>
                <th>PrimaryResourceID</th>
                <th>PrimaryDescriptions</th>
                <th>Merk</th>
                <th>NoInventaris</th>
                <th>Types</th>
                <th>ActiveStatus</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $sql = mysqli_query($conn, 'SELECT * FROM crhd_primary');
            while ($row = mysqli_fetch_array($sql)) {
                $status = 'Pasive';
                if ($row['ActiveStatus'] == 1) {
                    $status = 'Active';
                }
            ?>
                <tr>
                    <td>
                        <a href="#" class="badge bg-warning text-decoration-none href_transform" onclick="changedataprimaryresource('<?= $row['PrimaryResourceID'] ?>')">Change</a>
                        <a href="#" class="badge bg-danger text-decoration-none href_transform" onclick="deleteddataprimaryresource('<?= $row['PrimaryResourceID'] ?>')">Delete</a>
                    </td>
                    <td><?= $row['PrimaryResourceID'] ?></td>
                    <td><?= $row['PrimaryDescriptions'] ?></td>
                    <td><?= $row['Merk'] ?></td>
                    <td><?= $row['NoInventaris'] ?></td>
                    <td><?= $row['Types'] ?></td>
                    <td><?= $status ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>