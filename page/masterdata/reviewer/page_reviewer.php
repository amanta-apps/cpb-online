<div class="container">
    <div class="form-group row mt-5">
        <h6 class="text-start"><img src="../asset/icon/reviewer.png"> Reviewer/Approval</h6>
        <hr class="w-50 mb-3">
        <div class="row">
            <div class="form-group mb-0">
                <div class="form-group row mb-0">
                    <label for="typetransaksidatareviewer" class="col-sm-2 col-form-label">Reviewer For</label>
                    <div class="col-sm-3">
                        <select id="typetransaksidatareviewer" class="form-select form-select-sm" onchange="selectlevelsdatareviewer(this.value)">
                            <option value=""></option>
                            <?php
                            $sql = mysqli_query($conn, "SELECT * FROM text_sys WHERE Item=0");
                            while ($r = mysqli_fetch_array($sql)) { ?>
                                <option value="<?= $r['Jenisproses'] ?>"><?= $r['Descriptions'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="pernrdatareviewer" class="col-sm-2 col-form-label">Personal Number</label>
                    <div class="col-sm-3">
                        <div class="input-group mb-1">
                            <input type="text" class="form-control form-control-sm" placeholder="Pernr" aria-label="Recipient's username" aria-describedby="button-addon2" id="pernrdatareviewer">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#listpernrdatareviewer" data-bs-dismiss="modal"><span><img src="../asset/icon/cari.png"></span></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="employeenamedatareviewer" class="col-sm-2 col-form-label">Employee Name</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm bg-white" id="employeenamedatareviewer" disabled>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="positiondatareviewer" class="col-sm-2 col-form-label">Position</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm bg-white" id="positiondatareviewer" disabled>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="levelsdatareviewer" class="col-sm-2 col-form-label">Levels</label>
                    <div class="col-sm-1">
                        <input type="number" min="1" max="1" value="1" class="form-control form-control-sm bg-white" id="levelsdatareviewer" readonly>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-sm-4 offset-2">
                        <button type="button" class="btn btn-success btn-sm" onclick="savedatareviewer()"><img src="../asset/icon/save.png"> Submit</button>
                    </div>
                </div>
                <table id="droles" class="table table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr class="text-center">
                            <th>#</th>
                            <th>Type</th>
                            <th>Levels</th>
                            <th>Pernr</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Created On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $plant = $_SESSION['plant'];
                        $unitcode = $_SESSION['unitcode'];
                        $status = 'Non Active';
                        $sql = mysqli_query($conn, "SELECT * FROM reviewer_person WHERE Plant='$plant' AND 
                                                                                            UnitCode='$unitcode'");
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td><a href="#" class="badge bg-white text-dark href_transform" onclick="deletedatareviewer('<?= $row['TypeTransaction'] ?>','<?= $row['Levels'] ?>','<?= Getdata('Descriptions', 'text_sys', 'Jenisproses', $row['TypeTransaction']) ?>')"><img src="../asset/img/delete.png"></a></td>
                                <td class="fw-bold"><?= Getdata('Descriptions', 'text_sys', 'Jenisproses', $row['TypeTransaction']) ?></td>
                                <td class="fw-bold"><?= $row['Levels'] ?></td>
                                <td class="fw-bold"><?= $row['PersonnelNumber'] ?></td>
                                <td><?= $row['EmployeeName'] ?></td>
                                <td><?= $row['PositionID'] ?></td>
                                <td><?= $row['CreatedOn'] ?></td>
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

<!-- Modal Search Pernr 1-->
<div class="modal fade" id="listpernrdatareviewer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Search Employee Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="dsearchdata5" class="table table-striped table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 10%;">Option</th>
                            <th style="width: 10%;">PersonnelNumber</th>
                            <th style="width: 80%;">EmployeeName</th>
                            <th style="width: 80%;">Position ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, 'SELECT * FROM usr02 AS A INNER JOIN pa001 AS B ON A.PersonnelNumber=B.PersonnelNumber');
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="prosesselectpernrdatareviewer('<?= $row['PersonnelNumber'] ?>',
                                                                                                                                        '<?= $row['EmployeeName'] ?>',
                                                                                                                                        '<?= $row['PositionID'] ?>')">Select</a>
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
        </div>
    </div>
</div>
<!-- End -->