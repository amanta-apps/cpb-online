<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/createplanning2.png"> CREATE PLANNING - PENGEMASAN</h6>
    <hr class="w-100 mb-3">
    <div class="border-0 mb-0">
        <div class="form-group row mb-0">
            <label for="personalnumberemployee" class="col-sm-2 col-form-label">Product ID</label>
            <div class="col-sm-2">
                <div class="input-group mb-1">
                    <input type="text" class="form-control form-control-sm" placeholder="Product ID" aria-label="Recipient's username" aria-describedby="button-addon2" id="productidcreateplanning" onkeypress="submitproductcreateplanning()">
                    <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchprodukcreateplanning" onclick="resetproductcreateplanning()"><span><img src="../asset/icon/cari.png"></span></button>
                </div>
            </div>
            <label for="employeenameemployee" class="col-sm-2 offset-3 col-form-label">Dibuat Oleh</label>
            <div class="col-sm-3">
                <div class="input-group mb-1">
                    <input type="text" class="form-control form-control-sm" placeholder="Dibuat Oleh" aria-label="Recipient's username" aria-describedby="button-addon2" id="pernrcreateplanning" value="<?= $_SESSION['personnelnumber'] . ' - ' . Getdata('EmployeeName', 'pa001', 'PersonnelNumber', $_SESSION['personnelnumber']) ?>">
                    <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchpernrcreateplanning"><span><img src="../asset/icon/cari.png"> </span></button>
                </div>
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-sm-4 offset-2">
                <input type="text" class="form-control form-control-sm bg-transparent border-0 fw-bold" id="descriptionproductcreateplanning" readonly>
            </div>
            <label for="employeenameemployee" class="col-sm-3 offset-1 col-form-label">Shift</label>
            <div class="col-sm-2">
                <div class="input-group mb-1">
                    <input type="text" class="form-control form-control-sm" placeholder="Shift" aria-label="Recipient's username" aria-describedby="button-addon2" id="shiftcreateplanning" onkeypress="submitshiftcreateplanning()">
                    <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchshiftcreateplanning" onclick="resetshiftcreateplanning()"><span><img src="../asset/icon/cari.png"> </span></button>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="tglkemascreateplanning" class="col-sm-3 offset-7">Tgl Kemas</label>
            <div class="col-sm-2">
                <input type="date" class="form-control form-control-sm" id="tglkemascreateplanning" value="<?= date('Y-m-d') ?>">
            </div>
        </div>
        <!-- <hr class="mb-2"> -->
        <div class="form-group row mb-0" id="cardcolor">
            <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn-sm text-dark fw-bold active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Basic Data</button>
                </li>
                <li class="nav-item" role="presentation" hidden>
                    <button class="nav-link btn-sm text-dark fw-bold" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Data Machine</button>
                </li>
                <li class="nav-item" role="presentation" hidden>
                    <button class="nav-link btn-sm text-dark fw-bold" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-reviewer" type="button" role="tab" aria-controls="pills-reviewer" aria-selected="false">Daftar Approval</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="form-group row mb-0">
                        <label for="batchcreateplanning" class="col-sm-2 col-form-label">Batch</label>
                        <div class="col-sm-2">
                            <input type="text" id="batchcreateplanning" maxlength="7" class="form-control form-control-sm text-uppercase" aria-describedby="passwordHelpBlock">
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="expireddatecreateplanning" class="col-sm-2 col-form-label">Expired Date</label>
                        <div class="col-sm-2">
                            <input type="date" id="expireddatecreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" value="<?= date('Y-m-d'); ?>" readonly>
                        </div>
                        <label for="tglmixingcreateplanning" class="col-sm-2 offset-4 col-form-label">Tgl Mixing</label>
                        <div class="col-sm-2">
                            <input type="date" id="tglmixingcreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" value="<?= date('Y-m-d') ?>" onchange="getkadaluarsa(this.value)">
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="jumlahsachetcreateplanning" class="col-sm-2 col-form-label">Jumlah SCH</label>
                        <div class="col-sm-2">
                            <input type="number" id="jumlahsachetcreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" min="1" value="1">
                        </div>
                        <!-- <label class="col-sm-2 col-form-label fw-bold">Satuan SCH</label> -->
                        <div class="col-sm-1">
                            <input type="text" id="uomcreateplanning" class="form-control form-control-sm" value="SCH" readonly>
                        </div>
                        <label for="kodemesinmixingcreateplanning" class="col-sm-2 offset-3 col-form-label">No Mesin Mixing</label>
                        <div class="col-sm-2">
                            <div class="input-group mb-1">
                                <input type="text" class="form-control form-control-sm" placeholder="Code" aria-label="Recipient's username" aria-describedby="button-addon2" id="kodemesinmixingcreateplanning">
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchmesinmixingcreateplanning" onclick="resetmesinmixingcreateplanning()"><span><img src="../asset/icon/cari.png"> </span></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="noprosescreateplanning" class="col-sm-2 col-form-label">No Process/Tong</label>
                        <div class="col-sm-1">
                            <input type="number" id="noprosescreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" min="1" value="1">
                        </div>
                        <div class="col-sm-1">
                            <input type="number" id="notongcreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" min="1" value="1">
                        </div>
                        <label for="kodemesincreateplanning" class="col-sm-2 offset-4 col-form-label">Kode Mesin</label>
                        <div class="col-sm-2">
                            <div class="input-group mb-1">
                                <input type="text" class="form-control form-control-sm" placeholder="Code" aria-label="Recipient's username" aria-describedby="button-addon2" id="kodemesincreateplanning" onkeypress="submitmesincreateplanning()">
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchmesincreateplanning" onclick="resetmesincreateplanning()"><span><img src="../asset/icon/cari.png"> </span></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0 offset-2" hidden>
                        <label for="nohoppercreateplanning" class="col-sm-2 col-form-label">No Hopper</label>
                        <div class="col-sm-2">
                            <input type="text" id="nohoppercreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                        <label for="descriptionhoppercreateplanning" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-4">
                            <input type="text" id="descriptionhoppercreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                        <label for="noruanghoppercreateplanning" class="col-sm-2 col-form-label" hidden>No Ruang Hopper</label>
                        <div class="col-sm-2" hidden>
                            <input type="text" id="noruanghoppercreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                        <label for="namaruanghoppercreateplanning" class="col-sm-2 col-form-label" hidden>Nama Ruang</label>
                        <div class="col-sm-4" hidden>
                            <input type="text" id="namaruanghoppercreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0 offset-2" hidden>
                        <label for="nomesintopackcreateplanning" class="col-sm-2 col-form-label">No Topack</label>
                        <div class="col-sm-2">
                            <input type="text" id="nomesintopackcreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                        <label for="descriptiontopackcreateplanning" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-4">
                            <input type="text" id="descriptiontopackcreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                        <label for="noruangtopackcreateplanning" class="col-sm-2 col-form-label" hidden>No Ruang Topack</label>
                        <div class="col-sm-2" hidden>
                            <input type="text" id="noruangtopackcreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                        <label for="namruangtopackcreateplanning" class="col-sm-2 col-form-label" hidden>Nama Ruang</label>
                        <div class="col-sm-4" hidden>
                            <input type="text" id="namruangtopackcreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <!-- <div class="col-sm-7">
                        <label for="kodemesincreateplanning" class="col-sm-2 col-form-label">Kode Mesin</label>
                        <div class="col-sm-2">
                            <div class="input-group mb-1">
                                <input type="text" class="form-control form-control-sm" placeholder="Code" aria-label="Recipient's username" aria-describedby="button-addon2" id="kodemesincreateplanning" onkeypress="submitmesincreateplanning()">
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchmesincreateplanning" onclick="resetmesincreateplanning()"><span><img src="../asset/icon/cari.png"> </span></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-sm-2">
                            <label for="nohoppercreateplanning" class="form-label">No Hopper</label>
                            <input type="text" id="nohoppercreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                        <div class="col-sm-4">
                            <label for="descriptionhoppercreateplanning" class="form-label">Description</label>
                            <input type="text" id="descriptionhoppercreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                        <div class="col-sm-2" hidden>
                            <label for="noruanghoppercreateplanning" class="form-label">No Ruang Hopper</label>
                            <input type="text" id="noruanghoppercreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                        <div class="col-sm-4" hidden>
                            <label for="namaruanghoppercreateplanning" class="form-label">Nama Ruang</label>
                            <input type="text" id="namaruanghoppercreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-sm-2">
                            <label for="nomesintopackcreateplanning" class="form-label">No Topack</label>
                            <input type="text" id="nomesintopackcreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                        <div class="col-sm-4">
                            <label for="descriptiontopackcreateplanning" class="form-label">Description</label>
                            <input type="text" id="descriptiontopackcreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                        <div class="col-sm-2" hidden>
                            <label for="noruangtopackcreateplanning" class="form-label">No Ruang Topack</label>
                            <input type="text" id="noruangtopackcreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                        <div class="col-sm-4" hidden>
                            <label for="namruangtopackcreateplanning" class="form-label">Nama Ruang</label>
                            <input type="text" id="namruangtopackcreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                    </div> -->
                </div>
                <div class="tab-pane fade" id="pills-reviewer" role="tabpanel" aria-labelledby="pills-eviewer-tab">
                </div>
                <section id="tbl_reviewerplanning">
                    <div class="form-group row mb-0" <?= getconfigreviewer('create_planning', 'Addreviewer') ?>>
                        <label for="employeenameemployee" class="col-sm-2 col-form-label">Tambah Approval</label>
                        <div class="col-sm-4">
                            <div class="input-group mb-1">
                                <input type="text" class="form-control form-control-sm" placeholder="Pernr" aria-label="Recipient's username" aria-describedby="button-addon2" id="revieweraddcreateplanning">
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchpernr2createplanning"><span><img src="../asset/icon/cari.png"> </span></button>
                            </div>
                        </div>
                    </div>
                    <section <?= getconfigreviewer('create_planning', 'ShowReviewer') ?>>
                        <?php
                        $plant = $_SESSION['plant'];
                        $unitcode = $_SESSION['unitcode'];
                        $sql = mysqli_query($conn, "SELECT * FROM reviewer_person WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                                            AND TypeTransaction ='create_planning' ORDER BY Levels ASC");
                        if (mysqli_num_rows($sql) != 0) { ?>
                            <table class="table table-sm mt-3 w-100">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th style="width: 5%;">Nomor</th>
                                        <th style="width: 30%;">Approval</th>
                                        <th>Jabatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $l = 0;
                                    while ($r = mysqli_fetch_array($sql)) { ?>
                                        <tr>
                                            <!-- <td><?= $r['Levels'] ?></td> -->
                                            <td><input type="checkbox" id="reviewerpengemasan<?= $l ?>" class="form-check-input" checked disabled> <?= $r['Levels'] ?><input type="text" class="form-control form-control-sm" id="levelscreateplanningpengemasan<?= $l ?>" value="<?= $r['Levels'] ?>" hidden></td>
                                            <td><?= $r['PersonnelNumber'] . ' - ' . ucwords(strtolower($r['EmployeeName'])) ?></td>
                                            <td><?= $r['PositionID'] ?></td>
                                        </tr>
                                    <?php
                                        $l += 1;
                                    } ?>
                                </tbody>
                            </table>
                            <div class="form-group row mb-0">
                                <label for="revieweraddcreateplanningpengemasan" class="col-sm-2 col-form-label">Total Reviewer</label>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-sm-1">
                                    <input type="text" class="form-control form-control-sm" id="totalreviewercreateplanningpengemasan" value="<?= $l ?>" readonly>
                                </div>
                            </div>
                        <?php  } ?>
                    </section>
                </section>
                <hr class="mt-3">
                <div class="form-group row">
                    <div class="col-sm-12 text-end">
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="simpancreateplanning()"><img src="../asset/icon/save.png"> Save</button>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload()"><img src="../asset/icon/cancel.png"> Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <hr> -->

</div>

<!-- Modal Search Product-->
<div class="modal fade" id="searchprodukcreateplanning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  " id="staticBackdropLabel">Search Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="dsearchdata" class="table table-striped table-responsive-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 10%;">Option</th>
                            <th style="width: 10%;">Product ID</th>
                            <th>Descriptions</th>
                            <th hidden>Total Self Life</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $sql = mysqli_query($conn, 'SELECT * FROM mara_product');
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="selectproductcreateplanning('<?= $row['ProductID'] ?>','<?= $row['ProductDescriptions'] ?>','<?= $row['TotalSelfLife'] ?>')">Select</a>
                                </td>
                                <td><?= $row['ProductID'] ?></td>
                                <td><?= $row['ProductDescriptions'] ?></td>
                                <td hidden><?= $row['TotalSelfLife'] ?></td>
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

<!-- Modal Search Shift-->
<div class="modal fade" id="searchshiftcreateplanning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  " id="staticBackdropLabel">Search Shift</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="dsearchdata2" class="table table-striped table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 10%;">Option</th>
                            <th style="width: 10%;">Shift ID</th>
                            <th>Descriptions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, 'SELECT * FROM shifts');
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="selectshiftcreateplanning('<?= $row['ShiftID'] ?>')">Select</a>
                                </td>
                                <td><?= $row['ShiftID'] ?></td>
                                <td><?= $row['ShiftDescriptions'] ?></td>
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

<!-- Modal Search Mesin-->
<div class="modal fade" id="searchmesincreateplanning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-lg" id="staticBackdropLabel">Search Machine</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="dsearchdata3" class="table table-striped table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 10%;">Option</th>
                            <th style="width: 10%;">Resource ID</th>
                            <th style="width: 10%;">Hopper</th>
                            <th style="width: 30%;">Descriptions</th>
                            <th style="width: 10%;">Topack</th>
                            <th style="width: 30%;">Descriptions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, 'SELECT * FROM crhd');
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="selectmesincreateplanning('<?= $row['ResourceID'] ?>','<?= $row['PrimaryResourceID'] ?>','<?= $row['ResourceDescriptions1'] ?>','<?= $row['SecondaryResourceID'] ?>','<?= $row['ResourceDescriptions2'] ?>')">Select</a>
                                </td>
                                <td><?= $row['ResourceID'] ?></td>
                                <td><?= $row['PrimaryResourceID'] ?></td>
                                <td><?= $row['ResourceDescriptions1'] ?></td>
                                <td><?= $row['SecondaryResourceID'] ?></td>
                                <td><?= $row['ResourceDescriptions2'] ?></td>
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

<!-- Modal Search Mixing Mesin-->
<div class="modal fade" id="searchmesinmixingcreateplanning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Search Machine Mixing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="dsearchdata4" class="table table-striped table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 10%;">Option</th>
                            <th style="width: 10%;">Resource ID</th>
                            <th style="width: 80%;">Descriptions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, 'SELECT * FROM crhd_mixing');
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="selectmesinmixingcreateplanning('<?= $row['ResourceID'] ?>','<?= $row['ResourceDescriptions1'] ?>')">Select</a>
                                </td>
                                <td><?= $row['ResourceID'] ?></td>
                                <td><?= $row['ResourceDescriptions1'] ?></td>
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

<!-- Modal Search Pernr 1-->
<div class="modal fade" id="searchpernrcreateplanning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="selectpernrcreateplanning('<?= $row['PersonnelNumber'] ?>','<?= $row['EmployeeName'] ?>')">Select</a>
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

<!-- Modal Search Pernr 2-->
<div class="modal fade" id="searchpernr2createplanning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Search Employee Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="dsearchdata6" class="table table-striped table-sm" style="width:100%;">
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
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="$('#revieweraddcreateplanning').val('<?= $row['PersonnelNumber'] ?> - <?= ucwords(strtolower($row['EmployeeName'])) ?>'),$('#searchpernr2createplanning').modal('hide')">Select</a>
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