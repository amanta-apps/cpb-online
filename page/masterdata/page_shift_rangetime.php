<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/shift_time.png"> RANGE SHIFT</h6>
    <hr class="w-50 mb-3">
    <div class="card shadow-lg border-0 mb-1" id="cardcolor">
        <div class="form-group row mb-0">
            <label for="rangetimeiddatashiftrange" class="col-sm-2 col-form-label">Range Time ID</label>
            <div class="col-sm-1">
                <input type="number" min="1" value="1" class="form-control form-control-sm" id="rangetimeiddatashiftrange">
            </div>
            <label for="createdondatashiftrange" class="col-sm-2 offset-4 text-right">Created On</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" id="createdondatashiftrange" value="<?= date('d/m/Y H:i:s') ?>" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="rangetimedescriptiondatashiftrange" class="col-sm-2 col-form-label">Range Time Descriptions</label>
            <div class="col-sm-5">
                <input type="text" class="form-control form-control-sm text-uppercase" id="rangetimedescriptiondatashiftrange">
            </div>
            <label for="createbydatashiftrange" class="col-sm-2 text-right">Created By</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm" id="createbydatashiftrange" value="<?= $_SESSION['userid'] ?>" readonly>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-4">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="simpanshiftrange()"><img src="../asset/icon/save.png"> Simpan</button>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload()"><img src="../asset/icon/cancel.png"> Cancel</button>
            </div>
        </div>
    </div>
    <table id="mytable" class="table table-striped table-sm" style="width:100%">
        <thead class="bg-dark text-white">
            <tr>
                <th style="width: 15%;">Option</th>
                <th>Range Time ID</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $sql = mysqli_query($conn, 'SELECT * FROM shifts_r');
            while ($row = mysqli_fetch_array($sql)) {
            ?>
                <tr>
                    <td>
                        <a href="#" class="badge bg-warning text-decoration-none href_transform" onclick="changedatashift_range('<?= $row['RangeTimeID'] ?>')">Change</a>
                        <a href="#" class="badge bg-danger text-decoration-none href_transform" onclick="deleteddatashift_range('<?= $row['RangeTimeID'] ?>')">Delete</a>
                    </td>
                    <td><?= $row['RangeTimeID'] ?></td>
                    <td><?= $row['RangeDescriptions'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>