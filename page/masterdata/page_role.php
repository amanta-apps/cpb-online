<?php
$role_p = Getdata('RoleCode', 'general_setting_web', 'UnitCode', 'S001');
?>
<div class="container">
    <h6 class="fw-bold mt-3 text-start">ROLES</h6>
    <hr class="w-50 mb-3">
    <div class="card shadow-lg border-0 mb-1" id="cardcolor">
        <div class="form-group row mb-0">
            <label for="idprodukdataproduk" class="col-sm-2 col-form-label">Role</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm" id="koderoledatarole" value="<?= $role_p ?>" readonly>
            </div>
            <!-- <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" id="roledatarole">
            </div> -->
            <div class="col-sm-3">
                <select class="select2" id="roledatarole">
                    <option></option>
                    <?php
                    $sql = mysqli_query($conn, "SELECT DISTINCT Roles FROM agr_role WHERE Stts ='X' AND Roles LIKE '%$role_p%'");
                    while ($r = mysqli_fetch_array($sql)) { ?>
                        <option value="<?= $r['Roles'] ?>"><?= $r['Roles'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <label for="createondatabarang" class="col-sm-2">Created On</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" id="createondatarole" value="<?= date('d/m/Y H:i:s') ?>" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="deskripsidataproduk" class="col-sm-2 col-form-label">Menus</label>
            <div class="col-sm-5">
                <select class="select2" id="menudatarole">
                    <option></option>
                    <?php
                    $sql = mysqli_query($conn, "SELECT Descriptions FROM agr_menu WHERE Descriptions !=''");
                    while ($r = mysqli_fetch_array($sql)) { ?>
                        <option value="<?= $r['Descriptions'] ?>"><?= $r['Descriptions'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <label for="createondatabarang" class="col-sm-2">Created By</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm" id="createbydatarole" value="<?= $_SESSION['userid'] ?>" readonly>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-4">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="simpanrole()"><img src="../asset/icon/save.png"> Save</button>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload()"><img src="../asset/icon/cancel.png"> Cancel</button>
            </div>
        </div>
    </div>
    <table id="mytable" class="table table-striped table-sm" style="width:100%">
        <thead class="bg-dark text-white">
            <tr>
                <th style="width: 5%;">Option</th>
                <th>Role</th>
                <th>Menu</th>
                <th style="width: 50%;">Description</th>
                <th>Created By</th>
                <th>Created On</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $sql = mysqli_query($conn, 'SELECT * FROM agr_role');
            while ($row = mysqli_fetch_array($sql)) {
            ?>
                <tr>
                    <td>
                        <a href="#" class="badge bg-danger text-decoration-none href_transform" onclick="deletedatarole('<?= $row['Roles'] ?>','<?= $row['Menus'] ?>')"> Delete</a>
                    </td>
                    <td><?= $row['Roles'] ?></td>
                    <td><?= $row['Menus'] ?></td>
                    <td><?= Getdata('Descriptions', 'agr_menu', 'Menus', $row['Menus']) ?></td>
                    <td><?= $row['CreatedBy'] ?></td>
                    <td><?= $row['CreatedOn'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>