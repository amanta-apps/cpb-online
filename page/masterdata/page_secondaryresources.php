<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/machine.png"> SECONDARY RESOURCES</h6>
    <hr class="w-50 mb-3">
    <div class="card shadow-lg border-0 mb-1" id="cardcolor">
        <div class="form-group row mb-0">
            <label for="secondaryresourceidsecondaryresource" class="col-sm-2 col-form-label">Primary Resource ID</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" id="secondaryresourceidsecondaryresource" value="<?= Getkode('SecondaryResourceID', 'crhd_secondary') ?>" readonly>
            </div>
            <!-- <label for="createonsecondaryresource" class="col-sm-2 offset-2 text-right">Create On</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" id="createonsecondaryresource" value="<?= date('d/m/Y H:i:s') ?>" readonly>
            </div> -->
        </div>
        <div class="form-group row mb-0">
            <label for="descriptionsecondaryresource" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm text-capitalize" id="descriptionsecondaryresource">
            </div>
            <!-- <label for="createbysecondaryresource" class="col-sm-2 offset-1 text-right">Created By</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm" id="createbysecondaryresource" value="<?= $_SESSION['userid'] ?>" readonly>
            </div> -->
        </div>
        <div class="form-group row mb-0">
            <label for="merksecondaryresource" class="col-sm-2 col-form-label">Merk</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm text-capitalize" id="merksecondaryresource">
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="noinventarissecondaryresource" class="col-sm-2 col-form-label">No Inventaris</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm text-capitalize" id="noinventarissecondaryresource">
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="typesecondaryresource" class="col-sm-2 col-form-label">Type</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm text-capitalize" id="typesecondaryresource">
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="activestatussecondaryresource" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-2">
                <select class="form-select form-select-sm" id="activestatussecondaryresource">
                    <option value="0">None</option>
                    <option value="1">Active</option>
                </select>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-4">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="simpansecondaryresource()"><img src="../asset/icon/save.png"> Save</button>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload()"><img src="../asset/icon/cancel.png"> Cancel</button>
            </div>
        </div>
    </div>
    <div>
        <table id="mytables" class="table table-striped table-sm" style="width:100%;">
            <thead class="bg-dark text-white">
                <tr>
                    <th style="width: 15%;">Option</th>
                    <th>Secondary ResourceID</th>
                    <th>Secondary Descriptions</th>
                    <th>Merk</th>
                    <th>NoInventaris</th>
                    <th>Types</th>
                    <th>ActiveStatus</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $sql = mysqli_query($conn, 'SELECT * FROM crhd_secondary');
                while ($row = mysqli_fetch_array($sql)) {
                    $status = 'Pasive';
                    if ($row['ActiveStatus'] == 1) {
                        $status = 'Active';
                    }
                ?>
                    <tr>
                        <td>
                            <a href="#" class="badge bg-warning text-decoration-none href_transform" onclick="changedatasecondaryresource('<?= $row['SecondaryResourceID'] ?>')">Change</a>
                            <a href="#" class="badge bg-danger text-decoration-none href_transform" onclick="deleteddatasecondaryresource('<?= $row['SecondaryResourceID'] ?>')">Delete</a>
                        </td>
                        <td><?= $row['SecondaryResourceID'] ?></td>
                        <td><?= $row['SecondaryDescriptions'] ?></td>
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
</div>