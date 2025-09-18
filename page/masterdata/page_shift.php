<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/shift.png"> SHIFT</h6>
    <hr class="w-50 mb-3">
    <div class="card shadow-lg border-0 mb-3" id="cardcolor">
        <div class="form-group row mb-0">
            <label for="shiftidshift" class="col-sm-2 col-form-label">Shift ID</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm text-uppercase" id="shiftidshift" value="<?= Getkode('ShiftID', 'shifts') ?>" readonly>
            </div>
            <label for="createdonshift" class="col-sm-2 offset-3 text-right">Created On</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" id="createdonshift" value="<?= date('d/m/Y H:i:s') ?>" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="shiftdescriptiondatashift" class="col-sm-2 col-form-label">Shift Descriptions</label>
            <div class="col-sm-5">
                <input type="text" class="form-control form-control-sm" id="shiftdescriptiondatashift">
            </div>
            <label for="createdbydatashift" class="col-sm-2 text-right">Created By</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm" id="createdbydatashift" value="<?= $_SESSION['userid'] ?>" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="idrangetimedatashift" class="col-sm-2 col-form-label">ID Range Time</label>
            <div class="col-sm-5">
                <select class="select2" id="idrangetimedatashift">
                    <option value=""></option>
                    <?php
                    $sql = mysqli_query($conn, "SELECT * FROM shifts_r");
                    while ($r = mysqli_fetch_array($sql)) { ?>
                        <option value="<?= $r['RangeTimeID'] ?>"><?= $r['RangeTimeID'] . ' - ' . $r['RangeDescriptions'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <hr>
        <div class="form-group row">
            <div class="col-sm-4">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="simpanshift()"><img src="../asset/icon/save.png"> Save</button>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload()"><img src="../asset/icon/cancel.png"> Cancel</button>
            </div>
        </div>
    </div>
    <table id="mytable" class="table table-striped table-sm" style="width:100%">
        <thead class="bg-dark text-white">
            <tr>
                <th style="width: 15%;">Option</th>
                <th>Shift ID</th>
                <th>Shift Description</th>
                <th>Range Time ID</th>
                <th>Time</th>
                <th>Created By</th>
                <th>Created On</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $sql = mysqli_query($conn, 'SELECT * FROM shifts');
            while ($row = mysqli_fetch_array($sql)) {
            ?>
                <tr>
                    <td>
                        <a href="#" class="badge bg-warning text-decoration-none href_transform" onclick="changedatashift('<?= $row['ShiftID'] ?>')">Change</a>
                        <a href="#" class="badge bg-danger text-decoration-none href_transform" onclick="deleteddatashift('<?= $row['ShiftID'] ?>')">Delete</a>
                    </td>
                    <td><?= $row['ShiftID'] ?></td>
                    <td><?= $row['ShiftDescriptions'] ?></td>
                    <td><?= $row['RangeTimeID'] ?></td>
                    <td><?= Getdata('RangeDescriptions', 'shifts_r', 'RangeTimeID', $row['RangeTimeID']) ?></td>
                    <td><?= $row['CreatedBy'] ?></td>
                    <td><?= $row['CreatedOn'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>