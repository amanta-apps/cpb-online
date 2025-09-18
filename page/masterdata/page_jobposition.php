<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/job.png"> JOB POSITION</h6>
    <hr class="w-50 mb-3">
    <div class="card shadow-lg border-0 mb-1" id="cardcolor">
        <div class="form-group row mb-0">
            <label for="positionidjobposition" class="col-sm-2 col-form-label">Position ID</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm text-uppercase" id="positionidjobposition">
            </div>
            <label for="createonjobposition" class="col-sm-2 offset-3 text-right">Create On</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" id="createonjobposition" value="<?= date('d/m/Y H:i:s') ?>" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="descriptionjobposition" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-5">
                <input type="text" class="form-control form-control-sm text-capitalize" id="descriptionjobposition">
                <div id="daftarkaryawan"></div>
            </div>
            <label for="createbyjobposition" class="col-sm-2 text-right">Created By</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm" id="createbyjobposition" value="<?= $_SESSION['userid'] ?>" readonly>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-4">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="simpanjob()"><img src="../asset/icon/save.png"> Save</button>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload()"><img src="../asset/icon/cancel.png"> Cancel</button>
            </div>
        </div>
    </div>
    <table id="mytable" class="table table-striped table-sm" style="width:100%;">
        <thead class="bg-dark text-white">
            <tr>
                <th style="width: 15%;">Option</th>
                <th style="width: 15%;">Position ID</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = mysqli_query($conn, 'SELECT * FROM pa002');
            while ($row = mysqli_fetch_array($sql)) {
            ?>
                <tr>
                    <td>
                        <a href="#" class="badge bg-warning text-decoration-none href_transform" onclick="changedatajob('<?= $row['PositionID'] ?>')">Change</a>
                        <a href="#" class="badge bg-danger text-decoration-none href_transform" onclick="deletedatajob('<?= $row['PositionID'] ?>')">Delete</a>
                    </td>
                    <td><?= $row['PositionID'] ?></td>
                    <td><?= $row['Descriptions'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>