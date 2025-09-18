<div class="container">
    <h6 class="fw-bold mt-3 text-start">ASSIGN ROLES</h6>
    <hr class="w-50 mb-3">
    <!-- <div class="card shadow-lg border-0 mb-1" id="cardcolor"> -->
    <div class="form-group row mb-0">
        <label for="personalnumberemployee" class="col-sm-2 col-form-label">User ID</label>
        <div class="col-sm-2">
            <div class="input-group mb-1">
                <input type="text" class="form-control" placeholder="User ID" aria-label="Recipient's username" aria-describedby="button-addon2" id="useridassignrole">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchuseridassignrole"><span><img src=" ../asset/icon/cari.png"></span></button>
            </div>
        </div>
        <label for="createondatabarang" class="col-sm-2 offset-4">Created On</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm" id="createondatabarang" value="<?= date('d/m/Y H:i:s') ?>" readonly>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="createondatabarang" class="col-sm-2"></label>
        <div class="col-sm-4">
            <input type="text" class="form-control form-control-sm bg-transparent border-0 fw-bold" id="employeenameassignrole" readonly>
        </div>
        <label for="createondatabarang" class="col-sm-2 offset-2">Created By</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm" id="createbydataproduk" value="<?= $_SESSION['userid'] ?>" readonly>
        </div>
    </div>
    <div class="form-group row mb-0" id="roleuserlist">

    </div>
    <!-- <hr> -->
    <div class="form-group row mt-3">
        <div class="col-sm-4">
            <button type="button" class="btn btn-outline-success btn-sm" id="simpanassignrole" onclick="simpanassignrole()" hidden><img src="../asset/icon/save.png"> Save</button>
        </div>
    </div>
</div>

<!-- Modal Search Product-->
<div class="modal fade" id="searchuseridassignrole" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Search User ID</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="mytables" class="table table-striped table-responsive-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 10%;"></th>
                            <th style="width: 10%;">User ID</th>
                            <th style="width: 50%;">Nama</th>
                            <th>Personnel Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, 'SELECT A.UserID, B.EmployeeName,B.PersonnelNumber FROM usr02 AS A
                        INNER JOIN pa001 AS B ON A.PersonnelNumber = B.PersonnelNumber ORDER By A.UserID ASC');
                        if ($_SESSION['userid'] != 'SM000') {
                            $sql = mysqli_query($conn, 'SELECT A.UserID, B.EmployeeName,B.PersonnelNumber FROM usr02 AS A
                        INNER JOIN pa001 AS B ON A.PersonnelNumber = B.PersonnelNumber WHERE A.UserID != "SM000" ORDER By A.UserID ASC');
                        }
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="selectuseridassignrole('<?= $row['UserID'] ?>','<?= $row['EmployeeName'] ?>','<?= $row['PersonnelNumber'] ?>')">Select</a>
                                </td>
                                <td><?= $row['UserID'] ?></td>
                                <td><?= $row['EmployeeName'] ?></td>
                                <td><?= $row['PersonnelNumber'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End -->