<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/employee.png"> EMPLOYEE</h6>
    <hr class="w-50 mb-3">
    <div class="card shadow-lg border-0 mb-1" id="cardcolor">
        <div class="form-group row mb-0">
            <label for="personalnumberemployee" class="col-sm-2 col-form-label">Personal Number</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm" id="personalnumberemployee">
            </div>
            <label for="createonemployee" class="col-sm-2 offset-3 text-right">Created On</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" id="createonemployee" value="<?= date('d/m/Y H:i:s') ?>" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="employeenameemployee" class="col-sm-2 col-form-label">Employee Name</label>
            <div class="col-sm-5">
                <input type="text" class="form-control form-control-sm text-capitalize" id="employeenameemployee">
            </div>
            <label for="createbyemployee" class="col-sm-2 text-right">Created By</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm" id="createbyemployee" value="<?= $_SESSION['userid'] ?>" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="positionidemployee" class="col-sm-2 col-form-label">ID Position</label>
            <div class="col-sm-2">
                <select id="positionidemployee" class="select2">
                    <option value=""></option>
                    <?php
                    $sql = mysqli_query($conn, "SELECT * FROM pa002");
                    while ($r  = mysqli_fetch_array($sql)) { ?>
                        <option value="<?= $r['PositionID'] ?>"><?= $r['PositionID']  ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-4">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="simpanemployee()"><img src="../asset/icon/save.png"> Save</button>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload()"><img src="../asset/icon/cancel.png"> Cancel</button>
            </div>
        </div>
    </div>
    <table id="mytable" class="table table-striped table-sm" style="width:100%;">
        <thead class="bg-dark text-white">
            <tr>
                <th style="width: 15%;">Option</th>
                <th>Pernr</th>
                <th>Employee</th>
                <th>Position ID</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $sql = mysqli_query($conn, 'SELECT * FROM pa001 WHERE PersonnelNumber != "90003560"');
            while ($row = mysqli_fetch_array($sql)) {
            ?>
                <tr>
                    <td>
                        <a href="#" class="badge bg-warning text-decoration-none href_transform" onclick="changedataemployee('<?= $row['PersonnelNumber'] ?>')">Change</a>
                        <a href="#" class="badge bg-danger text-decoration-none href_transform" onclick="deletedataemployee('<?= $row['PersonnelNumber'] ?>')">Delete</a>
                    </td>
                    <td><?= $row['PersonnelNumber'] ?></td>
                    <td><?= $row['EmployeeName'] ?></td>
                    <td><?= $row['PositionID'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>