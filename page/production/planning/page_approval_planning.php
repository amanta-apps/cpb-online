<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/approve.png"> Approval Planning</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-5">
        <label for="personalnumberemployee" class="col-sm-2 col-form-label">Planning Number</label>
        <div class="col-sm-2">
            <div class="input-group mb-0">
                <input type="text" class="form-control" placeholder="Planning Number" aria-label="Recipient's username" aria-describedby="button-addon2" id="planningnumberapprovalplanning">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchplanningnumberapprovalplanning"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
        <label for="personalnumberemployee" class="col-sm-2 offset-3 col-form-label">Approved By</label>
        <div class="col-sm-3">
            <div class="input-group mb-0">
                <input type="text" class="form-control" placeholder="Approved By" aria-label="Recipient's username" aria-describedby="button-addon2" id="approvedbyapprovalplanning" value="<?= $_SESSION['personnelnumber'] . ' - ' . Getdata('EmployeeName', 'pa001', 'PersonnelNumber', $_SESSION['personnelnumber']) ?>">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchapprovedbyapprovalplanning"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
    </div>
    <div class="accordion" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                    Detail Planning Number
                </button>
            </h2>
            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                <div class="accordion-body">
                    <div class="form-group row mb-0">
                        <label for="setplanningnumberapprovalplanning" class="col-sm-2 col-form-label">Planning Number</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="setplanningnumberapprovalplanning" hidden>
                        </div>
                        <label for="tanggalkemasapprovalplanning" class="col-sm-2 offset-4 col-form-label">Tanggal Kemas</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="tanggalkemasapprovalplanning" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="productidapprovalplanning" class="col-sm-2 col-form-label">Product ID</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="productidapprovalplanning" readonly>
                        </div>
                        <label for="shiftidapprovalplanning" class="col-sm-2 offset-4 col-form-label">Shift ID</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="shiftidapprovalplanning" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="productdescriptionapprovalplanning" class="col-sm-2 col-form-label">Product Description</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="productdescriptionapprovalplanning" readonly>
                        </div>
                        <label for="edapprovalplanning" class="col-sm-2 offset-4 col-form-label">Expired Date</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="edapprovalplanning" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="batchapprovalplanning" class="col-sm-2 col-form-label">Batch</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="batchapprovalplanning" readonly>
                        </div>
                        <label for="tglmixingapprovalplanning" class="col-sm-2 offset-4 col-form-label">Tanggal Mixing</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="tglmixingapprovalplanning" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="nomesinapprovalplanning" class="col-sm-2 col-form-label">No Mesin</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="nomesinapprovalplanning" readonly>
                        </div>
                        <label for="yearsapprovalplanning" class="col-sm-2 offset-4 col-form-label">Years</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="yearsapprovalplanning" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="mixingapprovalplanning" class="col-sm-2 col-form-label">Mesin Mixing</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="mixingapprovalplanning" readonly>
                        </div>

                    </div>
                    <div class="form-group row mb-0">
                        <label for="qtyapprovalplanning" class="col-sm-2 col-form-label">Quantity</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="qtyapprovalplanning" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="prosesnumberapprovalplanning" class="col-sm-2 col-form-label">Process Number</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="prosesnumberapprovalplanning" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-end">
                            <button type="button" class="btn btn-outline-success btn-sm" id="simpanapprovalplanning" data-bs-toggle="modal" data-bs-target="#modalapprovalplanning" hidden><img src="../asset/icon/like.png"> Approved</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Planning Number-->
<div class="modal fade" id="searchplanningnumberapprovalplanning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">List Planning Number</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="ddisplayplanning" class="table table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Planing Number</th>
                            <th>Years</th>
                            <th>Product ID</th>
                            <th>Shift ID</th>
                            <th>Packing Date</th>
                            <th>Resource ID</th>
                            <th>Batch</th>
                            <th>ED</th>
                            <th>Resource ID Mix</th>
                            <th>Mixing Date</th>
                            <th>Qty</th>
                            <th>Uom</th>
                            <th>Process</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $plant = $_SESSION['plant'];
                        $unitcode = $_SESSION['unitcode'];
                        $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                                            AND (Approval ='' OR Approval is null)");
                        while ($row = mysqli_fetch_array($sql)) {
                            $planningnumber = $row['PlanningNumber'];
                            $years = $row['Years'];
                            $query = mysqli_query($conn, "SELECT * FROM tb_approval_viewer WHERE  Plant='$plant' AND UnitCode='$unitcode'
                                                                                                                AND ProcessType ='create_planning'
                                                                                                                AND PlanningNumber='$planningnumber'
                                                                                                                AND Years='$years'");
                            if (mysqli_num_rows($query) != 0) {
                                continue;
                            }
                        ?>
                            <tr>
                                <td><a href="#" class="badge bg-success href_transform" onclick="prosesselectapprovalplanning('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>')"><?= $row['PlanningNumber'] ?></a></td>
                                <td><?= $row['Years'] ?></td>
                                <td><?= $row['ProductID'] ?></td>
                                <td><?= $row['ShiftID'] ?></td>
                                <td><?= $row['PackingDate'] ?></td>
                                <td><?= $row['ResourceID'] ?></td>
                                <td><?= $row['BatchNumber'] ?></td>
                                <td><?= $row['ExpiredDate'] ?></td>
                                <td><?= $row['ResourceIDMix'] ?></td>
                                <td><?= $row['MixingDate'] ?></td>
                                <td><?= $row['Quantity'] ?></td>
                                <td><?= $row['UnitOfMeasures'] ?></td>
                                <td><?= $row['ProcessNumber'] ?></td>
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

<!-- Approved -->
<div class="modal fade" id="modalapprovalplanning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Approval Planning</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group row mb-1">
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Note</label>
                        <textarea class="form-control" id="noteapprovalplanning" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 text-end">
                        <button type="button" class="btn btn-outline-success btn-sm" id="simpanapprovalplanning" onclick="simpanapprovalplanning()"><img src="../asset/icon/save.png"> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End -->

<!-- Modal Search Pernr -->
<div class="modal fade" id="searchapprovedbyapprovalplanning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, 'SELECT * FROM pa001');
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="selectpernrapprovalplanning('<?= $row['PersonnelNumber'] ?>','<?= $row['EmployeeName'] ?>')">Select</a>
                                </td>
                                <td><?= $row['PersonnelNumber'] ?></td>
                                <td><?= $row['EmployeeName'] ?></td>
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