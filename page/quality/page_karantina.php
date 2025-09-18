<?php
$createdfor = $_SESSION['personnelnumber'] . ' - ' . Getdata('EmployeeName', 'pa001', 'PersonnelNumber', $_SESSION['personnelnumber']);
?>
<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/karantina.png"> KARANTINA</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <label for="productkarantina" class="col-sm-2 col-form-label">Product</label>
        <div class="col-sm-5">
            <div class="input-group mb-1">
                <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2" id="productkarantina" value="<?= Getdata('ProductDescriptions', 'mara_product', 'ProductID', $_GET['prod']) ?>" readonly>
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchproductkarantina"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
        <div class="col-sm-1">
            <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2" id="productIDkarantina" value="<?= $_GET['prod'] ?>" disabled hidden>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="betskarantina" class="col-sm-2 col-form-label">Batch</label>
        <div class="col-sm-2">
            <div class="input-group mb-1">
                <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2" id="betskarantina" value="<?= $_GET['bet'] ?>">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchbetskarantina"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="sttskarantina" class="col-sm-2 col-form-label">Status</label>
        <div class="col-sm-2">
            <select id="sttskarantina" class="form-select form-select-sm">
                <?php
                $sql = mysqli_query($conn, "SELECT * FROM text_status ORDER BY Norut ASC");
                while ($r  = mysqli_fetch_array($sql)) { ?>
                    <option value="<?= $r['Stats'] ?>"><?= $r['Descriptions'] ?></option>
                <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="proseskarantina" class="col-sm-2 col-form-label">Proses</label>
        <div class="col-sm-2">
            <select id="proseskarantina" class="form-select form-select-sm">
                <?php
                if ($_GET['prs'] == '') { ?>
                    <option value="pengolahan">Pengolahan</option>
                    <option value="pengemasan">Pengemasan</option>
                <?php } elseif ($_GET['prs'] == 'pengolahan') { ?>
                    <option value="pengolahan">Pengolahan</option>
                    <option value="pengemasan">Pengemasan</option>
                <?php } elseif ($_GET['prs'] == 'pengemasan') { ?>
                    <option value="pengemasan">Pengemasan</option>
                    <option value="pengolahan">Pengolahan</option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-3 offset-2">
            <button type="button" id="simpanqcresulthoper" class="btn btn-outline-success btn-sm" onclick="showkarantina()"><img src="../asset/icon/accept.png"> Submit</button>
        </div>
    </div>
    <div class="mt-2">
        <table id="ddisplayplanning0" class="table table-sm w-100">
            <thead class="bg-dark text-white">
                <tr>
                    <th>Planning Number</th>
                    <th>Years</th>
                    <th>Product ID</th>
                    <th>Description</th>
                    <th>Batch</th>
                    <th>ED</th>
                    <th>Qty</th>
                    <th>Status</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $plant = $_SESSION['plant'];
                $unitcode = $_SESSION['unitcode'];
                $productid = $_GET['prod'];
                $batch = $_GET['bet'];
                $stats = $_GET['stt'];
                $prs = $_GET['prs'];
                $proses = 'insp_pengolahan_header';
                $st = 'StatsY';
                if ($prs == 'pengemasan') {
                    $proses = 'planning_prod_header';
                    $st = 'SttsX';
                }
                if ($productid == '' && $batch == '') {
                    $query = "SELECT * FROM $proses WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND 
                                                                        $st='$stats' LIMIT 100";
                } elseif ($productid != '' && $batch == '') {
                    $query = "SELECT * FROM $proses WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        ProductID='$productid' AND 
                                                                        $st='$stats' LIMIT 100";
                } elseif ($productid == '' && $batch != '') {
                    $query = "SELECT * FROM $proses WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        BatchNumber LIKE '%$batch%' AND 
                                                                        $st='$stats' LIMIT 100";
                } elseif ($productid != '' && $batch != '') {
                    $query = "SELECT * FROM $proses WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        ProductID='$productid' AND
                                                                        BatchNumber LIKE '%$batch%' AND 
                                                                        $st='$stats' LIMIT 100";
                }
                // echo var_dump($query);
                if (isset($_GET['prod']) || isset($_GET['bet'])) {
                    $sql = mysqli_query($conn, $query);
                } else {
                    $sql = mysqli_query($conn, '');
                }
                while ($row = mysqli_fetch_array($sql)) {
                    $ed = $row['ExpiredDate'];
                    if ($prs == 'pengemasan') {
                        $status = $row['SttsX'];
                    } elseif ($prs == 'pengolahan') {
                        $status = $row['StatsY'];
                    }
                    $get_stt = mysqli_query($conn, "SELECT * FROM tbl_karantina WHERE Plant='$plant' AND
                                                                                                UnitCode='$unitcode' AND
                                                                                                PlanningNumber='$row[PlanningNumber]' AND
                                                                                                Years='$row[Years]' AND
                                                                                                ProductID= '$row[ProductID]'
                                                                                                ORDER BY ExtendExp DESC");
                    if (mysqli_num_rows($get_stt) != 0) {
                        $show_karantina = mysqli_fetch_array($get_stt);
                    }
                    if ($ed == '') {
                        $get_ed = mysqli_query($conn, "SELECT ExpiredDate FROM planning_pengolahan_detail WHERE Plant='$plant' AND
                                                                                                                UnitCode='$unitcode' AND
                                                                                                                PlanningNumber='$row[PlanningNumber]' AND
                                                                                                                Years='$row[Years]' AND
                                                                                                                BatchNumber LIKE '%$row[BatchNumber]%'");
                        $r = mysqli_fetch_array($get_ed);
                        $ed = $r['ExpiredDate'];
                    }
                ?>
                    <tr>
                        <td style="width: 10%;" class="fw-bold">#<?= $row['PlanningNumber'] ?></a></td>
                        <td><?= $row['Years'] ?></td>
                        <td><?= $row['ProductID'] ?></td>
                        <td style="width: 40%;"><?= Getdata('ProductDescriptions', 'mara_product', 'ProductID', $row['ProductID']) ?></td>
                        <td><?= $row['BatchNumber'] ?></td>
                        <td><?= $ed ?></td>
                        <td><?= $row['Quantity'] . ' ' . $row['UnitOfMeasures'] ?></td>
                        <td><?= $status ?></td>
                        <?php
                        if ($status == 'REL') { ?>
                            <td><a href="#" class="badge bg-success href_transform" onclick="showdetailkarantina('<?= $prs ?>','<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>','<?= $row['ProductID'] ?>','<?= $row['BatchNumber'] ?>')"><img src="../asset/icon/karantina.png" width="15px"> Kirim ke Karantina</a></td>
                        <?php } else { ?>
                            <td><a href="#" class="badge bg-danger zoom text-decoration-none" onclick="showtrackingkarantina('<?= $show_karantina['KodeKarantina'] ?>','<?= $show_karantina['Qyears'] ?>')"><img src="../asset/icon/karantina.png" width="15px">Sedang Dalam Proses</a></td>
                        <?php }
                        ?>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Search Product-->
<div class="modal fade" id="searchproductkarantina" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Search Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="dsearchdata" class="table table-striped table-responsive-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 10%;">#</th>
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
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="$('#productkarantina').val('<?= $row['ProductDescriptions'] ?>'),$('#productIDkarantina').val('<?= $row['ProductID'] ?>'),$('#searchproductkarantina').modal('hide')">Select</a>
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

<!-- Bets -->
<div class="modal fade" id="searchbetskarantina" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">List Batch Number</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="dsearchdata5" class="table table-sm w-100">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Bets</th>
                    </thead>
                    <tbody>
                        <?php
                        $plant = $_SESSION['plant'];
                        $unitcode = $_SESSION['unitcode'];
                        $sql = mysqli_query($conn, "SELECT DISTINCT A.BatchNumber FROM planning_prod_header AS A
                                                                                 INNER JOIN insp_pengolahan_header AS B WHERE A.Plant='$plant' AND
                                                                                             A.UnitCode='$unitcode' LIMIT 100");
                        // $sql = mysqli_query($conn, "SELECT DISTINCT BatchNumber FROM Planning_prod_header WHERE Plant='$plant' AND
                        //                                                                                         UnitCode='$unitcode' LIMIT 100
                        //                                                         UNION
                        //                                                         SELECT DISTINCT BatchNumber FROM planning_pengolahan_detail WHERE Plant='$plant' AND
                        //                                                                                         UnitCode='$unitcode' LIMIT 100");
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td><a href="#" class="badge bg-success href_transform" onclick="$('#betskarantina').val('<?= $row['BatchNumber'] ?>'),$('#searchbetskarantina').modal('hide')"><?= $row['BatchNumber'] ?></a></td>
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

<!-- Show Konfirmasi Karantina -->
<div class="modal fade" id="modalshowdetailkarantina" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Konfirmasi Data Karantina <label id="titlemodaldetailkarantina"></label></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group row mb-0">
                    <label for="planningnumbermodaldetailkarantina" class="col-sm-2 col-form-label">Planning Number</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="planningnumbermodaldetailkarantina" readonly>
                    </div>
                    <label for="yearsmodaldetailkarantina" class="col-sm-1 col-form-label">Years</label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control form-control-sm" id="yearsmodaldetailkarantina" readonly>
                    </div>
                    <label for="tglkarantinamodaldetailkarantina" class="col-sm-2 offset-1 col-form-label">Tgl Karantina</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control form-control-sm" id="tglkarantinamodaldetailkarantina" value="<?= date('Y-m-d'); ?>">
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="productidmodaldetailkarantina" class="col-sm-2  col-form-label">Product ID</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="productidmodaldetailkarantina" readonly>
                    </div>
                    <label for="productkarantina" class="col-sm-2 offset-3 col-form-label">Qc</label>
                    <div class="col-sm-3">
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2" id="qcmodaldetailkarantina" value="<?= $createdfor ?>">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searcqcmodaldetailkarantina"><span><img src="../asset/icon/cari.png"></span></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="productdescmodaldetailkarantina" class="col-sm-2 col-form-label">Product Desc</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm" id="productdescmodaldetailkarantina" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="betsmodaldetailkarantina" class="col-sm-2 col-form-label">Batch</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="betsmodaldetailkarantina" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="expdatemodaldetailkarantina" class="col-sm-2 col-form-label">Exp. Date/Next. insp</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="expdatemodaldetailkarantina" readonly>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="netxinspmodaldetailkarantina" readonly>
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <label for="keteranganmodaldetailkarantina" class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-4">
                        <textarea class="form-control" id="keteranganmodaldetailkarantina" cols="30" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3 offset-2">
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="submitkarantina('<?= $prs ?>','<?= $stats ?>')"><img src="../asset/icon/accept.png"> Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End -->

<!-- Modal Search Pernr -->
<div class="modal fade" id="searchpernrcekrhsuhu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="selectpernrcekrhsuhu('<?= $row['PersonnelNumber'] ?>','<?= $row['EmployeeName'] ?>')">Select</a>
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

<!-- Show Detail Karantina -->
<div class="modal fade" id="showtrackingkarantina" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Lacak Data Karantina</label></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group row mb-0" hidden>
                    <label for="kodekarantinamodaltrackingkarantina" class="col-sm-2 col-form-label">KodeKarantina</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="kodekarantinamodaltrackingkarantina" readonly>
                    </div>
                    <label for="Qyearsmodaltrackingkarantina" class="col-sm-1 col-form-label">Years</label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control form-control-sm" id="Qyearsmodaltrackingkarantina" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="planningnumbermodaltrackingkarantina" class="col-sm-2 col-form-label">Planning Number</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="planningnumbermodaltrackingkarantina" readonly>
                    </div>
                    <label for="yearsmodaltrackingkarantina" class="col-sm-1 col-form-label">Years</label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control form-control-sm" id="yearsmodaltrackingkarantina" readonly>
                    </div>
                    <label for="tglkarantinamodaltrackingkarantina" class="col-sm-2 offset-2 col-form-label">Tgl Karantina</label>
                    <div class="col-sm-2">
                        <input type="date" class="form-control form-control-sm" id="tglkarantinamodaltrackingkarantina" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="productidmodaltrackingkarantina" class="col-sm-2  col-form-label">Product ID</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="productidmodaltrackingkarantina" readonly>
                    </div>
                    <label for="createdonmodaltrackingkarantina" class="col-sm-2 offset-4 col-form-label">Created On</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="createdonmodaltrackingkarantina" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="productdescmodaltrackingkarantina" class="col-sm-2 col-form-label">Product Desc</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm" id="productdescmodaltrackingkarantina" readonly>
                    </div>
                    <label for="createdbymodaltrackingkarantina" class="col-sm-2 offset-2 col-form-label">Created By</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="createdbymodaltrackingkarantina" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="betsmodaltrackingkarantina" class="col-sm-2 col-form-label">Batch</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="betsmodaltrackingkarantina" readonly>
                    </div>
                    <label for="Qcmodaltrackingkarantina" class="col-sm-2 offset-4 col-form-label">Qc</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="Qcmodaltrackingkarantina" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="expdatemodaltrackingkarantina" class="col-sm-2 col-form-label">Exp. Date/Next. insp</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="expdatemodaltrackingkarantina" readonly>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="netxinspmodaltrackingkarantina" readonly>
                    </div>
                    <label for="extendexpmodaltrackingkarantina" class="col-sm-2 offset-2 col-form-label">Extend Exp. Date</label>
                    <div class="col-sm-1">
                        <input type="number" class="form-control form-control-sm" id="extendexpmodaltrackingkarantina" min="1" onchange="showextendexpkarantina(this.value)">
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <label for="keteranganmodaltrackingkarantina" class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-4">
                        <textarea class="form-control" id="keteranganmodaltrackingkarantina" cols="30" rows="3" readonly></textarea>
                    </div>
                    <label for="kodereffmodaltrackingkarantina" class="col-sm-2 offset-2 col-form-label">Kode Reff</label>
                    <div class="col-sm-2">
                        <textarea class="form-control align-content-center text-center fs-5 fw-bold" id="kodereffmodaltrackingkarantina" cols="30" rows="3" readonly></textarea>
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <label for="statusmodaltrackingkarantina" class="col-sm-2 offset-8 col-form-label">Status</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="statusmodaltrackingkarantina" readonly>
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <table class="table table-sm w-50">
                        <thead class="fw-normal bg-dark text-white">
                            <th>No</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Desc</th>
                        </thead>
                        <tbody>
                            <td>1</td>
                            <td>14/06/2017</td>
                            <td>08:00:11</td>
                            <td>Karantina Created</td>
                        </tbody>
                    </table>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 text-end">
                        <button type="button" id="endkarantinamodaltrackingkarantina" class="btn btn-success btn-sm zoom" onclick="endkarantina('<?= $prs ?>')"><img src="../asset/icon/accept.png"> Close Karantina</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End -->