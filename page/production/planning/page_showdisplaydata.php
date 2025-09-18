<?php
$plant = $_SESSION['plant'];
$unitcode = $_SESSION['unitcode'];
$planningnumber = $_GET['v'];
$years = $_GET['y'];
?>
<div class="container">
    <h6 class="fw-bold mb-5">Display Data - Proses Planning Number #<b class="fs-5"><?= $planningnumber ?></b></h6>
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark active" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1" aria-selected="true">Planning Number</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-2" type="button" role="tab" aria-controls="pills-2" aria-selected="false">Prepare Hoper</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark" id="pills-3-tab" data-bs-toggle="pill" data-bs-target="#pills-3" type="button" role="tab" aria-controls="pills-3" aria-selected="false">Proses Hoper</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark" id="pills-4-tab" data-bs-toggle="pill" data-bs-target="#pills-4" type="button" role="tab" aria-controls="pills-4" aria-selected="false">Prepare Topack</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark" id="pills-5-tab" data-bs-toggle="pill" data-bs-target="#pills-5" type="button" role="tab" aria-controls="pills-5" aria-selected="false">Proses Topack</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark" id="pills-6-tab" data-bs-toggle="pill" data-bs-target="#pills-6" type="button" role="tab" aria-controls="pills-6" aria-selected="false">Reconciliation Topack</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark" id="pills-7-tab" data-bs-toggle="pill" data-bs-target="#pills-7" type="button" role="tab" aria-controls="pills-7" aria-selected="false">Prepare Pillow</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark" id="pills-8-tab" data-bs-toggle="pill" data-bs-target="#pills-8" type="button" role="tab" aria-controls="pills-8" aria-selected="false">Proses Pillow</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark" id="pills-9-tab" data-bs-toggle="pill" data-bs-target="#pills-9" type="button" role="tab" aria-controls="pills-9" aria-selected="false">Reconciliation Pillow</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
            <!-- Planning Number -->
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years'");
            $row = mysqli_fetch_array($sql);
            $productname = Getdata("ProductDescriptions", "mara_product", "ProductID", $row['ProductID'])
            ?>
            <div class="card">
                <div class="border-0 mb-0 p-3 mt-3">
                    <div class="form-group row mb-0">
                        <label for="productiddisplayplanning" class="col-sm-2 col-form-label">Product ID</label>
                        <div class="col-sm-2">
                            <input type="text" value="<?= $row['ProductID'] ?>" class="form-control form-control-sm" readonly>
                        </div>
                        <label for="createonisplayplanning" class="col-sm-2 offset-4">Created On</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['CreatedOn'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <div class="col-sm-4 offset-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0 fw-bold" value="<?= $productname ?>" readonly>
                        </div>
                        <label for="createbydisplayplanning" class="col-sm-2 offset-2">Created By</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['CreatedBy'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="batchdisplayplanning" class="col-sm-2 form-label">Batch</label>
                        <div class="col-sm-2">
                            <input type="text" value="<?= $row['BatchNumber'] ?>" class="form-control form-control-sm" readonly>
                        </div>
                        <label for="expireddatedisplayplanning" class="col-sm-2 form-label">Expired Date</label>
                        <div class="col-sm-2">
                            <input type="text" value="<?= $row['ExpiredDate'] ?>" class="form-control form-control-sm" readonly>
                        </div>
                        <label for="changedondisplayplanning" class="col-sm-2">Changed On</label>
                        <div class="col-sm-2">
                            <input type="text" value="<?= $row['ChangedOn'] ?>" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="kodemesindisplayplanning" class="col-sm-2 col-form-label">Shift</label>
                        <div class="col-sm-2">
                            <input type="text" value="<?= $row['ShiftID'] ?>" class="form-control form-control-sm" readonly>
                        </div>
                        <label for="changedbydisplayplanning" class="col-sm-2 offset-4">Changed By</label>
                        <div class="col-sm-2">
                            <input type="text" value="<?= $row['ChangedBy'] ?>" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="kodemesindisplayplanning" class="col-sm-2 col-form-label">Kode Mesin</label>
                        <div class="col-sm-2">
                            <input type="text" value="<?= $row['ResourceID'] ?>" class="form-control form-control-sm" readonly>
                        </div>
                        <label for="tglkemasdisplayplanning" class="col-sm-2">Tgl Kemas</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['PackingDate'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="kodemesinmixingdisplayplanning" class="col-sm-2">Kode Mesin Mixing</label>
                        <div class="col-sm-2">
                            <input type="text" value="<?= $row['ResourceIDMix'] ?>" class="form-control form-control-sm" readonly>
                        </div>
                        <label for="tglmixingdisplayplanning" class="col-sm-2 form-label">Tgl Mixing</label>
                        <div class="col-sm-2">
                            <input type="text" value="<?= $row['MixingDate'] ?>" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="qtydisplayplanning" class="col-sm-2">Qty</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Quantity'] ?>" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" value="<?= $row['UnitOfMeasures'] ?>" class="form-control form-control-sm bg-transparent fw-bold border-0" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="prosesnumberdisplayplanning" class="col-sm-2">Process Number</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control form-control-sm" value="<?= $row['ProcessNumber'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="notongdisplayplanning" class="col-sm-2">Total Tong</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control form-control-sm" value="<?= $row['ContainerNumber'] ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
            <!-- Prepare Hoper -->
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM proses_prepare WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    PlanningNumber='$planningnumber' AND 
                                                                    Years='$years' AND 
                                                                    Types='Hoper'");
            $row = mysqli_fetch_array($sql);
            ?>
            <div class="card">
                <div class="border-0 mb-0 p-3 mt-3">
                    <div class="form-group row mb-0">
                        <label for="operator1displaydata" class="col-sm-2 offset-8 col-form-label">Operator 1</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Operator1'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="operator2displaydata" class="col-sm-2 offset-8 col-form-label">Operator 2</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Operator2'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="changedbydisplayplanning" class="col-sm-2 offset-8">Pengawas Produksi</label>
                        <div class="col-sm-2">
                            <input type="text" value="<?= $row['PengawasProduksi'] ?>" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <h6 class="fw-bold">Input Parameter</h6>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter1displaydata" class="col-sm-8 col-form-label">1. <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 1) ?></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Parameter_1'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter2displaydata" class="col-sm-8 col-form-label">2. <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 2) ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Parameter_2'] ?>" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="°C" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter2suhupersiapanhoper" class="col-sm-8 ps-4 col-form-label"><?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 21) ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Parameter_2_1'] ?>" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="%" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter3persiapanhoper" class="col-sm-8 col-form-label">3. <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 3) ?></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Parameter_3'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter4persiapanhoper" class="col-sm-8 col-form-label">4. <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 4) ?></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Parameter_4'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter5persiapanhoper" class="col-sm-8 col-form-label">5. <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 5) ?></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Parameter_5'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-sm-12 px-5">
                            <table>
                                <!-- <tr>
                                    <td>- <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 51) ?> </th>
                                    <td><input type="text" class="form-control form-control-sm" id="parameter5_1persiapanhoper" readonly></td>
                                </tr> -->
                                <tr>
                                    <td>- <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 52) ?></td>
                                    <td><input type="text" class="form-control form-control-sm" value="<?= $row['Sub_parameter_5_2'] ?>" readonly></td>
                                </tr>
                                <tr>
                                    <td>- <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 53) ?></td>
                                    <td><input type="text" class="form-control form-control-sm" value="<?= $row['Sub_parameter_5_3'] ?>" readonly></td>
                                </tr>
                                <tr>
                                    <td>- <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 54) ?></td>
                                    <td><input type="text" class="form-control form-control-sm" value="<?= $row['Sub_parameter_5_4'] ?>" readonly></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter6persiapanhoper" class="col-sm-8 col-form-label">6. <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 6) ?></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Parameter_6'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter7persiapanhoper" class="col-sm-8 col-form-label">7. <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 7) ?></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Parameter_7'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="parameter8persiapanhoper" class="col-sm-8 col-form-label">8. <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 8) ?></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Parameter_8'] ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-3" role="tabpanel" aria-labelledby="pills-3-tab">
            <div class="card">
                <div class="border-0 mb-0 mt-3 p-3">
                    <table class="table table-sm">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>Proses Number</th>
                                <th>No Tong</th>
                                <th>Waktu</th>
                                <th>Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = mysqli_query($conn, "SELECT * FROM transaksi_hoper WHERE Plant='$plant' AND
                                                                                        UnitCode='$unitcode' AND
                                                                                        PlanningNumber='$planningnumber' AND
                                                                                        Years='$years'");
                            while ($row = mysqli_fetch_array($sql)) {
                            ?>
                                <tr>
                                    <td><?= $row['ProcessNumber'] ?></td>
                                    <td><?= $row['ContainerNumber'] ?></td>
                                    <td><?= $row['TimeExecuted'] ?></td>
                                    <td><?= $row['Quantity'] ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-4" role="tabpanel" aria-labelledby="pills-4-tab">
            <!-- Prepare Topack -->
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM proses_prepare WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND
                                                                        Years='$years' AND Types='Topack'");
            $row = mysqli_fetch_array($sql);
            ?>
            <div class="card">
                <div class="border-0 mb-0 p-3 mt-3">
                    <div class="form-group row mb-0">
                        <label for="operator1displaydata" class="col-sm-2 offset-8 col-form-label">Operator 1</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Operator1'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="operator2displaydata" class="col-sm-2 offset-8 col-form-label">Operator 2</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Operator2'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="changedbydisplayplanning" class="col-sm-2 offset-8">Pengawas Produksi</label>
                        <div class="col-sm-2">
                            <input type="text" value="<?= $row['PengawasProduksi'] ?>" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <h6 class="fw-bold">Input Parameter</h6>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter1displaydata" class="col-sm-8 col-form-label">1. <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 1) ?></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Parameter_1'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter2displaydata" class="col-sm-8 col-form-label">2. <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 2) ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Parameter_2'] ?>" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="°C" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter2suhupersiapanhoper" class="col-sm-8 ps-4 col-form-label"><?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 21) ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Parameter_2_1'] ?>" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="%" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter3persiapanhoper" class="col-sm-8 col-form-label">3. <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 3) ?></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Parameter_3'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter4persiapanhoper" class="col-sm-8 col-form-label">4. <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 4) ?></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Parameter_4'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter5persiapanhoper" class="col-sm-8 col-form-label">5. <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 5) ?></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Parameter_5'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-sm-12 px-5">
                            <table>
                                <!-- <tr>
                                    <td>- <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 51) ?> </th>
                                    <td><input type="text" class="form-control form-control-sm" id="parameter5_1persiapanhoper" readonly></td>
                                </tr> -->
                                <tr>
                                    <td>- <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 52) ?></td>
                                    <td><input type="text" class="form-control form-control-sm" value="<?= $row['Sub_parameter_5_2'] ?>" readonly></td>
                                </tr>
                                <tr>
                                    <td>- <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 53) ?></td>
                                    <td><input type="text" class="form-control form-control-sm" value="<?= $row['Sub_parameter_5_3'] ?>" readonly></td>
                                </tr>
                                <tr>
                                    <td>- <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 54) ?></td>
                                    <td><input type="text" class="form-control form-control-sm" value="<?= $row['Sub_parameter_5_4'] ?>" readonly></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter6persiapanhoper" class="col-sm-8 col-form-label">6. <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 6) ?></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Parameter_6'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter7persiapanhoper" class="col-sm-8 col-form-label">7. <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 7) ?></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Parameter_7'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="parameter8persiapanhoper" class="col-sm-8 col-form-label">8. <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 8) ?></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Parameter_8'] ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-5" role="tabpanel" aria-labelledby="pills-5-tab">
            <!-- Proses Topack -->
            <div class="card">
                <div class="border-0 mb-0 p-3 mt-3">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                    Engine Set
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <section class="mb-3">
                                        <?php
                                        $i = 0;
                                        $sql = mysqli_query($conn, "SELECT * FROM qc_characteristic WHERE KodeProses LIKE '%ES%'");
                                        if (mysqli_num_rows($sql) > 0) {
                                            while ($r = mysqli_fetch_array($sql)) { ?>
                                                <div class="form-group row mb-1">
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control form-control-sm border-0 bg-transparent" id="jenispengecekanengineset<?= $i ?>" value="<?= $r['Proses'] ?>" readonly>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <input type="text" value="<?= GetdataIII("NilaiSuhu", "machine_engine", "PlanningNumber", $_GET['v'], "JenisTransaksi", "Topack", "JenisPengecekan", $r['Proses']) ?>" class="form-control form-control-sm" id="suhu<?= $i ?>" disabled>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control form-control-sm bg-transparent border-0" value="Spec: <?= $r['Nilai'], ' ', $r['UnitOfMeasures'] ?>" readonly>
                                                    </div>
                                                </div>
                                        <?php $i++;
                                            }
                                        } ?>
                                    </section>
                                    <section class="mb-3">
                                        <?php
                                        $idno = 1;
                                        $sql = mysqli_query($conn, "SELECT * FROM text_sys WHERE JenisProses='engineset'");
                                        if (mysqli_num_rows($sql) > 0) {
                                            while ($r = mysqli_fetch_array($sql)) { ?>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="textengineset<?= $idno; ?>" checked disabled>
                                                    <label class="form-check-label" for="textengineset<?= $idno; ?>"><?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'engineset', 'Item', $idno) ?></label>
                                                </div>
                                        <?php $idno++;
                                            }
                                        }
                                        ?>
                                    </section>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="true" aria-controls="panelsStayOpen-collapseTwo">
                                    Production Sampling
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <table class="table table-sm">
                                        <thead class="bg-dark text-white">
                                            <tr>
                                                <th>Item</th>
                                                <th>Jam Timbang</th>
                                                <th>Qty</th>
                                                <th>Uom</th>
                                                <th>Bobot Timbang</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = mysqli_query($conn, "SELECT * FROM sampling_transaksi_topack WHERE Plant='$plant' AND
                                                                                                                UnitCode='$unitcode' AND
                                                                                                                PlanningNumber='$planningnumber' AND
                                                                                                                Years='$years'");
                                            while ($row = mysqli_fetch_array($sql)) {
                                            ?>
                                                <tr>
                                                    <td><?= $row['Item'] ?></td>
                                                    <td><?= $row['JamTimbang'] ?></td>
                                                    <td><?= $row['Qty'] ?></td>
                                                    <td><?= $row['Uom'] ?></td>
                                                    <td><?= $row['BobotTimbang'] ?></td>
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
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-6" role="tabpanel" aria-labelledby="pills-6-tab">
            <!-- Rekonsiliasi Topack -->
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM transaksi_topack WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND
                                                                        Years='$years'");
            $row = mysqli_fetch_array($sql);
            ?>
            <div class="card">
                <div class="border-0 mb-0 p-3 mt-3">
                    <div class="form-group row mb-0">
                        <label for="jammulaiprosestopack" class="col-sm-2 col-form-label">Jam Mulai</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Starttimes'] ?>" readonly>
                        </div>
                        <label for="jamselesaiprosestopack" class="col-sm-2 col-form-label">Jam Selesai</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Endtimes'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="countermesinprosestopack" class="col-sm-2 col-form-label">Counter Mesin</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['CounterMesin'] ?>" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="counterprinterprosestopack" class="col-sm-2 col-form-label">Counter Printer</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control form-control-sm" value="<?= $row['CounterPrinter'] ?>" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="lithoterpakaiprosestopack" class="col-sm-2 col-form-label">Jumlah Kemasan Terpakai</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['UsedListho'] ?>" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Roll" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="rusakprosestopack" class="col-sm-2 col-form-label">Hasil SCH Rusak</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['rejectedsch'] ?>" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="rusakprosestopack" class="col-sm-2 col-form-label">Sampling</label>
                        <div class="col-sm-2" id="showiconsampling">
                            <!-- <input type="text" class="form-control form-control-sm" id="rusakprosestopack" value="0" readonly> -->
                            <!-- <img src="../asset/icon/no.png"> -->
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="rusakprosestopack" class="col-sm-2 col-form-label">Sampel Tes Kebocoran</label>
                        <div class="col-sm-2">
                            <input type="number" min="0" value="0" class="form-control form-control-sm" value="<?= $row['SampleKebocoran'] ?>" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="rusakprosestopack" class="col-sm-2 col-form-label">Retained Sample</label>
                        <div class="col-sm-2">
                            <input type="number" min="0" value="0" class="form-control form-control-sm" value="<?= $row['RetainedSample'] ?>" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row mb-0">
                        <label for="hasilteoritisrekontopack" class="col-sm-2 col-form-label">Hasil Teoritis</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['HasilTeoritis'] ?>" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="hasilnyatarekontopack" class="col-sm-2 col-form-label">Hasil Nyata</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['HasilNyata'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="presentaserekontopack" class="col-sm-2 col-form-label">Presentase</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Persentase'] ?>" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" id="uom1rekontopack" value="%" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-7" role="tabpanel" aria-labelledby="pills-7-tab">
            <!-- Prepare Pillow -->
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM proses_prepare_pillow WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND
                                                                        Years='$years'");
            $row = mysqli_fetch_array($sql);
            ?>
            <div class="card">
                <div class="border-0 mb-0 p-3 mt-3">
                    <div class="form-group row mb-0">
                        <label for="personalnumberemployee" class="col-sm-2 col-form-label">Operator 1</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['FirstOperator'] ?>" readonly>
                        </div>
                        <label for="personalnumberemployee" class="col-sm-2 offset-4 col-form-label">Operator 4</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['FourOperator'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="personalnumberemployee" class="col-sm-2 col-form-label">Operator 2</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['SecondOperator'] ?>" readonly>
                        </div>
                        <label for="personalnumberemployee" class="col-sm-2 offset-4 col-form-label">Operator 5</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['FiveOperator'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="personalnumberemployee" class="col-sm-2 col-form-label">Operator 3</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['ThreeOperator'] ?>" readonly>
                        </div>
                        <label for="personalnumberemployee" class="col-sm-2 offset-4 col-form-label">Operator 6</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['SixOperator'] ?>" readonly>
                        </div>

                    </div>
                    <div class="form-group row mb-3">
                        <label for="changedbydisplayplanning" class="col-sm-2 offset-8">Pengawas Produksi</label>
                        <div class="col-sm-2">
                            <input type="text" value="<?= $row['PengawasProduksi'] ?>" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <h6 class="fw-bold">Uraian Pemeriksaan</h6>
                        <hr class="width-50">
                    </div>
                    <section class="mb-3">
                        <?php
                        $idno = 1;
                        $sql = mysqli_query($conn, "SELECT * FROM text_sys WHERE JenisProses='pillowpack' AND Item != 31 AND Item !=32");
                        if (mysqli_num_rows($sql) > 0) {
                            while ($r = mysqli_fetch_array($sql)) {
                                if ($r['Item'] == 4) { ?>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="textpillowpack<?= $idno; ?>" checked disabled>
                                        <label class="form-check-label" for="textpillowpack<?= $idno; ?>"><?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', $idno) ?></label>
                                        <div class="form-group row mb-1">
                                            <div class="col-sm-2">
                                                <input class="form-control border-0 bg-transparent" type="text" id="duspersiapanpillow" value="Dus">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control form-control-sm" id="qtyduspreparepillow" value="<?= $row['Qty_1'] ?>" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <input class="form-control border-0 bg-transparent" type="text" id="hangerpersiapanpillow" value="Hanger">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control form-control-sm" id="qtyhangerpersiapanpillow" value="<?= $row['Qty_3'] ?>" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <input class="form-control border-0 bg-transparent" type="text" id="boxpersiapanpillow" value="Box">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control form-control-sm" id="qtyboxpersiapanpillow" value="<?= $row['Qty_5'] ?>" readonly>
                                            </div>

                                        </div>
                                        <div class="form-group row mb-1">
                                            <div class="col-sm-2">
                                                <input class="form-control border-0 bg-transparent" type="text" id="brosurpersiapanpillow" value="Brosur">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control form-control-sm" id="qtybrosurpersiapanpillow" value="<?= $row['Qty_2'] ?>" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <input class="form-control border-0 bg-transparent" type="text" id="stikerpersiapanpillow" value="Stiker">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control form-control-sm" id="qtystikerpersiapanpillow" value="<?= $row['Qty_4'] ?>" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <input class="form-control border-0 bg-transparent" type="text" id="plastikpersiapanpillow" value="Plastik">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control form-control-sm" id="qtyplastikpersiapanpillow" value="<?= $row['Qty_6'] ?>" readonly>
                                            </div>
                                        </div>
                                    </div>

                                <?php } elseif ($r['Item'] == 3) { ?>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="textpillowpack<?= $idno; ?>" checked disabled>
                                        <label class="form-check-label" for="textpillowpack<?= $idno; ?>"><?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', $idno) ?></label>
                                        <table>
                                            <tr>
                                                <td style="color: gray;">- <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', 31) ?></td>
                                            </tr>
                                            <tr>
                                                <td style="color: gray;">- <?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', 32) ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                <?php } else { ?>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="textpillowpack<?= $idno; ?>" checked disabled>
                                        <label class="form-check-label" for="textpillowpack<?= $idno; ?>"><?= GetdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', $idno) ?></label>
                                    </div>
                                <?php } ?>
                        <?php $idno++;
                            }
                        }
                        ?>
                    </section>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-8" role="tabpanel" aria-labelledby="pills-8-tab">
            <!-- Proses Pillow Pack -->
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM transaksi_pillow WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND
                                                                        Years='$years'");
            $row = mysqli_fetch_array($sql);
            ?>
            <div class="card">
                <div class="border-0 mb-0 p-3 mt-3">
                    <div class="form-group row mb-0">
                        <label for="rentengprosespillow" class="col-sm-1 col-form-label fw-bold">Renteng</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['TypeRenteng'] ?>" readonly>
                        </div>
                    </div>
                    <hr class="width-50">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="text1prosespillowpack" checked disabled>
                        <label class="form-check-label" for="text1prosespillowpack">1. Masukan setiap renteng kedalam plastik</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="text2prosespillowpack" checked disabled>
                        <label class="form-check-label" for="text2prosespillowpack">2. Masukan setiap
                            <input type="text" value="<?= $row['QtyPlastik'] ?>" id="qtypastikprosespillow" readonly> plastik pada poin 1 ke dalam box dengan carton sealer</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="text3prosespillowpack" checked disabled>
                        <label class="form-check-label" for="text3prosespillowpack">3. Timbang tiap box dan cetak spesifikasi pada box</label>
                        <table>
                            <td style="color: grey;">(Kode Produk, Tanggal Kemas, Shift, Jam, Kode Operator, ED, Nomor Line, Nomor urut kemas bobot)</td>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-9" role="tabpanel" aria-labelledby="pills-9-tab">
            <!-- Rekon Pillow -->
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM transaksi_rekon_pillow WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years'");
            $row = mysqli_fetch_array($sql);
            ?>
            <div class="card">
                <div class="border-0 mb-0 p-3 mt-3">
                    <div class="form-group row mb-0">
                        <label for="hasilpengemasanrekonsiliasipillow" class="col-sm-2 col-form-label">Hasil Pengemasan</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['HasilPengemasan'] ?>" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Car" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="countermesinrekonsiliasipillow" class="col-sm-2 col-form-label">Counter Mesin</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control form-control-sm" value="<?= $row['CounterMesin'] ?>" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Rtg" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="lithoterpakairekonsiliasipillow" class="col-sm-2 col-form-label fw-bold">Jumlah Kemasan Terpakai</label>
                    </div>

                    <div class="form-group row mb-1">
                        <div class="col-sm-2">
                            <input class="form-control border-0 bg-transparent" type="text" id="dusrekonpillow" value="Dus" readonly>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Dus'] ?>" readonly>
                        </div>
                        <div class="col-sm-2">
                            <input class="form-control border-0 bg-transparent" type="text" id="hangerrekonpillow" value="Hanger" readonly>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Hanger'] ?>" readonly>
                        </div>
                        <div class="col-sm-2">
                            <input class="form-control border-0 bg-transparent" type="text" id="boxrekonpillow" value="Box" readonly>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Tbox'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <div class="col-sm-2">
                            <input class="form-control border-0 bg-transparent" type="text" id="brosurrekonpillow" value="Brosur" readonly>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Brosur'] ?>" readonly>
                        </div>
                        <div class="col-sm-2">
                            <input class="form-control border-0 bg-transparent" type="text" id="stikerrekonpillow" value="Stiker" readonly>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Stiker'] ?>" readonly>
                        </div>
                        <div class="col-sm-2">
                            <input class="form-control border-0 bg-transparent" type="text" id="plastikrekonpillow" value="Plastik" readonly>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['Plastik'] ?>" readonly>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row mb-0">
                        <label for="hasilteoritisrekonpillow" class="col-sm-2 col-form-label">Hasil Teoritis</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['HasilTeoritis'] ?>" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="hasilnyatarekonpillow" class="col-sm-2 col-form-label">Hasil Nyata</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['HasilNyata'] ?>" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="presentaserekonpillow" class="col-sm-2 col-form-label">Presentase</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="<?= $row['PresentaseHasil'] ?>" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" id="uom1rekonpillow" value="%" readonly>
                        </div>
                    </div>
                    <!-- <div class="form-group row mb-0">
                        <label for="rangehasilrekonpillow" class="col-sm-2 col-form-label">Range Hasil</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" id="rangehasilrekonpillow" value="<?= $rangehasil ?>" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" id="uom2rekonpillow" value="<?= $uom ?>" readonly>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>