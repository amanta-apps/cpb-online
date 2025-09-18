<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/machine.png"> MAIN RESOURCES</h6>
    <hr class="w-50 mb-3">
    <div class="card shadow-lg border-0 mb-1" id="cardcolor">
        <div class="form-group row mb-0">
            <label for="resourceidmainresource" class="col-sm-2 col-form-label">Resource ID</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm text-uppercase" id="resourceidmainresource" value="<?= Getkode('ResourceID', 'crhd') ?>" readonly>
            </div>
            <label for="createonmainresource" class="col-sm-2 offset-3 text-right">Created On</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" id="createonmainresource" value="<?= date('d/m/Y H:i:s') ?>" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="resourcedesription1mainresource" class="col-sm-2 col-form-label">Resource Descriptions I</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm text-capitalize" id="resourcedesription1mainresource">
            </div>
            <label for="createbymainresource" class="col-sm-2 offset-1 text-right">Created By</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm" id="createbymainresource" value="<?= $_SESSION['userid'] ?>" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="resourcedesription2mainresource" class="col-sm-2 col-form-label">Resource Descriptions II</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm text-capitalize" id="resourcedesription2mainresource">
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="primaryresourceidmainresource" class="col-sm-2 col-form-label">Primary Resource ID</label>
            <div class="col-sm-2">
                <select class="select2" id="primaryresourceidmainresource">
                    <option></option>
                    <?php
                    $sql = mysqli_query($conn, "SELECT PrimaryResourceID FROM crhd_primary");
                    while ($r = mysqli_fetch_array($sql)) { ?>
                        <option value="<?= $r['PrimaryResourceID'] ?>"><?= $r['PrimaryResourceID'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="secondaryresourceidmainresource" class="col-sm-2 col-form-label">Secondary Resource ID</label>
            <div class="col-sm-2">
                <select class="select2" id="secondaryresourceidmainresource">
                    <option></option>
                    <?php
                    $sql = mysqli_query($conn, "SELECT SecondaryResourceID FROM crhd_secondary");
                    while ($r = mysqli_fetch_array($sql)) { ?>
                        <option value="<?= $r['SecondaryResourceID'] ?>"><?= $r['SecondaryResourceID'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-4">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="simpanmainresource()"><img src="../asset/icon/save.png"> Simpan</button>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload()"><img src="../asset/icon/cancel.png"> Cancel</button>
            </div>
        </div>
    </div>
    <table id="mytables" class="table table-striped table-sm" style="width:100%;">
        <thead class="bg-dark text-white">
            <tr>
                <th style="width: 15%;">Option</th>
                <th>Resource ID</th>
                <th>Resource Description I</th>
                <th>Resource Description II</th>
                <th>Primary Resource ID</th>
                <th>Secondary Resource ID</th>
                <!-- <th>Created By</th>
                <th>Created On</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $sql = mysqli_query($conn, 'SELECT * FROM crhd');
            while ($row = mysqli_fetch_array($sql)) {
            ?>
                <tr>
                    <td>
                        <a href="#" class="badge bg-warning text-decoration-none href_transform" onclick="changedatamainresource('<?= $row['ResourceID'] ?>')">Change</a>
                        <a href="#" class="badge bg-danger text-decoration-none href_transform" onclick="deleteddatamainresource('<?= $row['ResourceID'] ?>')">Delete</a>
                    </td>
                    <td><?= $row['ResourceID'] ?></td>
                    <td><?= $row['ResourceDescriptions1'] ?></td>
                    <td><?= $row['ResourceDescriptions2'] ?></td>
                    <td><?= $row['PrimaryResourceID'] ?></td>
                    <td><?= $row['SecondaryResourceID'] ?></td>
                    <!-- <td><?= $row['CreatedBy'] ?></td>
                    <td><?= $row['CreatedOn'] ?></td> -->
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>