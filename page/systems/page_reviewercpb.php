<div class="container">
    <h6 class="fw-bold mt-3 text-start">Config Reviewer</h6>
    <hr class="w-50 mb-3">

    <div class="card shadow-lg border-0 mb-1" id="cardcolor">
        <div class="form-group row mb-0">
            <label for="menureviewercpb" class="col-sm-2 col-form-label">Menu</label>
            <div class="col-sm-2">
                <select class="select2" id="menureviewercpb">
                    <option></option>
                    <?php
                    $sql = mysqli_query($conn, "SELECT Texts,Descriptions FROM config_reviewer");
                    while ($r = mysqli_fetch_array($sql)) { ?>
                        <option value="<?= $r['Texts'] ?>"><?= $r['Descriptions']  ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="pernrreviewercpb" class="col-sm-2 col-form-label">Personal no.</label>
            <div class="col-sm-4">
                <select class="select2" id="pernrreviewercpb">
                    <option></option>
                    <?php
                    $sql = mysqli_query($conn, "SELECT PersonnelNumber,EmployeeName FROM pa001");
                    while ($r = mysqli_fetch_array($sql)) { ?>
                        <option value="<?= $r['PersonnelNumber'] ?>"><?= $r['PersonnelNumber'] . ' - ' . $r['EmployeeName']  ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-4">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="simpanreviewercpb()"><img src="../asset/icon/save.png"> Save</button>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload()"><img src="../asset/icon/cancel.png"> Cancel</button>
            </div>
        </div>
    </div>
    <table id="mytable" class="table table-striped table-sm" style="width:100%">
        <thead class="bg-dark text-white">
            <tr>
                <th style="width: 5%;"></th>
                <th style="width: 50%;">Description</th>
                <th>Pernr</th>
                <th>Created On</th>
                <th>Created By</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $sql = mysqli_query($conn, 'SELECT * FROM mapping_reviewer');
            while ($row = mysqli_fetch_array($sql)) {
            ?>
                <tr>
                    <td>
                        <a href="#" class="badge bg-danger text-decoration-none href_transform" onclick="deletereviewercpb('<?= $row['FormReviewer'] ?>','<?= $row['Pernr'] ?>')"> Delete</a>
                    </td>
                    <td><?= Getdata("Descriptions", "config_reviewer", "Texts", $row['FormReviewer']) ?></td>
                    <td><?= $row['Pernr'] ?></td>
                    <td><?= beautydate2($row['CreatedOn']) ?></td>
                    <td><?= $row['CreatedBy'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
</div>