<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/user.png"> USER AUTHORIZATION</h6>
    <hr class="w-50 mb-3">
    <div class="card shadow-lg border-0 mb-1" id="cardcolor">
        <div class="form-group row mb-0">
            <label for="useriduserotorisasi" class="col-sm-2 col-form-label">User ID</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm text-uppercase" id="useriduserotorisasi" value="<?= Getkode("UserID", "usr02") ?>" readonly>
            </div>
            <label for="createonuserotorisasi" class="col-sm-2 offset-3">Create On</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" id="createonuserotorisasi" value="<?= date('d/m/Y H:i:s') ?>" readonly>
            </div>
        </div>
        <!-- <label for="personalnumberuserotorisasi" class="col-sm-2 col-form-label">Personal Number</label>
            <div class="col-sm-5">
                <input type="text" class="form-control form-control-sm text-uppercase" id="personalnumberuserotorisasi">
                <div id="daftarkaryawan"></div>
            </div> -->
        <div class="form-group row mb-0">
            <label for="deskripsidataproduk" class="col-sm-2 col-form-label">Personal Number</label>
            <div class="col-sm-4">
                <select class="select2" id="personalnumberuserotorisasi" onchange="getnamekaryawan(this.value)">
                    <option></option>
                    <?php
                    $sql = mysqli_query($conn, "SELECT 	PersonnelNumber,EmployeeName FROM pa001");
                    while ($r = mysqli_fetch_array($sql)) { ?>
                        <option value="<?= $r['PersonnelNumber'] ?>"><?= $r['PersonnelNumber'] . ' - ' . $r['EmployeeName'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <label for="createbyuserotorisasi" class="col-sm-2 offset-1 text-right">Created By</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm" id="createbyuserotorisasi" value="<?= $_SESSION['userid'] ?>" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="passworduserotorisasi" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-5">
                <input type="text" class="form-control form-control-sm bg-transparent border-0" id="nameuserotorisasi" readonly>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-4">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="simpanauth()"><img src="../asset/icon/save.png"> Save</button>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload()"><img src="../asset/icon/cancel.png"> Cancel</button>
            </div>
        </div>
    </div>
    <table id="mytable" class="table table-striped table-sm" style="width:100%;">
        <thead class="bg-dark text-white">
            <tr>
                <th style="width: 15%;">Option</th>
                <th>User ID</th>
                <th>Personnel Number</th>
                <th>Nama</th>
                <th>InitialPassword</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = mysqli_query($conn, 'SELECT * FROM usr02 WHERE PersonnelNumber !="90003560"');
            while ($row = mysqli_fetch_array($sql)) {
            ?>
                <tr>
                    <td>
                        <a href="#" class="badge bg-warning text-decoration-none href_transform" onclick="changedataauth('<?= $row['UserID'] ?>')">Change</a>
                        <a href="#" class="badge bg-danger text-decoration-none href_transform" onclick="deletedataauth('<?= $row['UserID'] ?>')">Delete</a>
                    </td>
                    <td><?= $row['UserID'] ?></td>
                    <td><?= $row['PersonnelNumber'] ?></td>
                    <td><?= Getnamakaryawan2($row['PersonnelNumber']) ?></td>
                    <td><?= md5($row['InitialPassword']) ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>