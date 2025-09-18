<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/proses.png"> Proses Hoper</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <label for="personalnumberemployee" class="col-sm-2 col-form-label">Planning Number</label>
        <div class="col-sm-2">
            <div class="input-group mb-4">
                <input type="text" class="form-control" placeholder="Planning Number" aria-label="Recipient's username" aria-describedby="button-addon2" id="planningnumberproseshoper">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchplanningnumberproseshoper"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
        <label for="pengawasproduksiproseshoper" class="col-sm-2 offset-4 col-form-label">Pengawas Produksi</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" class="form-control form-control-sm" aria-label="Recipient's username" aria-describedby="button-addon2" id="pengawasproduksiproseshoper">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchpengawasproduksiproseshoper"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
    </div>
    <div class="accordion" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                    Detail Planning Number
                </button>
            </h2>
            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                <div class="accordion-body">
                    <div class="form-group row mb-0">
                        <label for="setplanningnumberproseshoper" class="col-sm-2 col-form-label fw-bold">Planning Number</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="setplanningnumberproseshoper" readonly>
                        </div>
                        <label for="tanggalkemasproseshoper" class="col-sm-2 offset-4 col-form-label">Tanggal Kemas</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="tanggalkemasproseshoper" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="productidproseshoper" class="col-sm-2 col-form-label">Product ID</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="productidproseshoper" readonly>
                        </div>
                        <label for="shiftidproseshoper" class="col-sm-2 offset-4 col-form-label">Shift ID</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="shiftidproseshoper" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="productidproseshoper" class="col-sm-2 col-form-label">Product Description</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="productdescriptionproseshoper" readonly>
                        </div>
                        <label for="edproseshoper" class="col-sm-2 offset-4 col-form-label">Expired Date</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="edproseshoper" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="batchproseshoper" class="col-sm-2 col-form-label">Batch</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="batchproseshoper" readonly>
                        </div>
                        <label for="tglmixingproseshoper" class="col-sm-2 offset-4 col-form-label">Tanggal Mixing</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="tglmixingproseshoper" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="nomesinproseshoper" class="col-sm-2 col-form-label">No Mesin</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="nomesinproseshoper" readonly>
                        </div>
                        <label for="yearsproseshoper" class="col-sm-2 offset-4 col-form-label">Years</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="yearsproseshoper" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="mixingproseshoper" class="col-sm-2 col-form-label">Mesin Mixing</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="mixingproseshoper" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="qtyproseshoper" class="col-sm-2 col-form-label">Quantity</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="qtyproseshoper" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="jumlahprosesproseshoper" class="col-sm-2 col-form-label">Process Number</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="jumlahprosesproseshoper" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                    Data
                </button>
            </h2>
            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
                <div class="accordion-body">
                    <div class="form-group row mb-3">
                        <label for="scanbarcodeproseshoper" class="col-sm-2 col-form-label"><sup class="text-danger">*</sup> Scan Barcode</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control form-control-sm focusin" id="scanbarcodeproseshoper" onkeypress="submitproseshopper(event)" autofocus>
                        </div>
                    </div>
                    <div id="content_page">

                    </div>
                    <div class="col-sm-1 offset-11 ms-auto">
                        <label for="kodemesinmixingcreateplanning" class="form-label">&nbsp;</label>
                        <div class="input-group">
                            <button type="button" id="btn_saveproseshoper" class="btn btn-outline-dark btn-sm" onclick="saveproseshopper()" hidden><img src="../asset/icon/save.png"> Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Planning Number-->
<div class="modal fade" id="searchplanningnumberproseshoper" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">List Planning Number</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="mytables" class="table table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Planing Number</th>
                            <th>Years</th>
                            <th>Product ID</th>
                            <th>Batch</th>
                            <th>Shift ID</th>
                            <th>Packing Date</th>
                            <th>Resource ID</th>
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
                        $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND
                                                                                             UnitCode='$unitcode' AND
                                                                                             PrepareHoper='X' AND ProsesHoper is null");
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td><a href="#" class="badge bg-success href_transform" onclick="prosesselectproseshoper('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>')"><?= $row['PlanningNumber'] ?></a></td>
                                <td><?= $row['Years'] ?></td>
                                <td><?= $row['ProductID'] ?></td>
                                <td><?= $row['BatchNumber'] ?></td>
                                <td><?= $row['ShiftID'] ?></td>
                                <td><?= $row['PackingDate'] ?></td>
                                <td><?= $row['ResourceID'] ?></td>
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
<!-- Pengawas Produksi-->
<div class="modal fade" id="searchpengawasproduksiproseshoper" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">List Operator</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="mytable_pernr" class="table table-striped table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 5%;"></th>
                            <th>Pernr</th>
                            <th>Employee</th>
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
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="submitpengawasproses('hoper','<?= $row['EmployeeName'] ?>')">Select</a>
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