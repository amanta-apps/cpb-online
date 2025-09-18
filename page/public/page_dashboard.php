<?php
$plant = $_SESSION['plant'];
$unitcode = $_SESSION['unitcode'];
$pernr = $_SESSION['personnelnumber'];
$nama = explode(" ", $_SESSION['employeename']);
$tgl_start = $_GET['start'];
if ($_GET['start'] == '') {
    $tgl_start = date('Y-m-01');
}
$tgl_end = $_GET['end'];
if ($_GET['end'] == '') {
    $tgl_end = date('Y-m-28');
}
?>
<div class="container">
    <h6 class="fw-bold" style="margin-top: 10%;"><?= GetdataII('DashboardTitle', 'general_setting_web', 'UnitCode', $unitcode, 'Plant', $plant) ?></h6>
    <div class="mt-5" id="content_dashboard">
        <p><?= GetdataII('DashboardContent', 'general_setting_web', 'UnitCode', $unitcode, 'Plant', $plant) ?></p>
    </div>
    <section class="mb-5">
        <p class="text-end fw-bold fs-6">Hi, <?= $nama[0] ?></p>
        <h6 class="fw-bold"><img src="../asset/icon/dashboard.png"> DASHBOARD </h6>
        <div class="row">
            <div class="col-3 mt-3">
                <div class="card p-3 border-2 border-dark zoom">
                    <div class="card-title fw-bold">Total Planning Pengolahan</div>
                    <div class="card-body">
                        <p class="card-text fw-bold fs-6"><?= number_format(getrowtable('planning_pengolahan_header', '', ''), 0, '', '.') ?></p>
                    </div>
                </div>
            </div>
            <div class="col-3 mt-3">
                <div class="card p-3 border-2 border-dark zoom">
                    <div class="card-title fw-bold">Total Planning Pengemasan</div>
                    <div class="card-body">
                        <p class="card-text fw-bold fs-6"><?= number_format(getrowtable('planning_prod_header', '', ''), 0, '', '.') ?></p>
                    </div>
                </div>
            </div>
            <div class="col-3 mt-3">
                <div class="card p-3 border-2 border-dark zoom">
                    <div class="card-title fw-bold">Total Review KA Unit</div>
                    <div class="card-body">
                        <p class="card-text fw-bold fs-6"><?= number_format(getrowtable('proses_review_mg', '', ''), 0, '', '.') ?></p>
                    </div>
                </div>
            </div>
            <div class="col-3 mt-3">
                <div class="card p-3 border-2 border-dark zoom">
                    <div class="card-title fw-bold">Total Review Quality</div>
                    <div class="card-body">
                        <p class="card-text fw-bold fs-6"><?= number_format(getrowtable('proses_review_quality', '', ''), 0, '', '.') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    $cfg = mysqli_query($conn, "SELECT * FROM tb_configweb WHERE Plant='$plant'AND UnitCode='$unitcode' ORDER BY Items ASC");
    if (mysqli_num_rows($cfg) != 0) {
        while ($r = mysqli_fetch_array($cfg)) {
            $mr = mysqli_query($conn, "SELECT * FROM mapping_reviewer WHERE Plant='$plant' AND UnitCode='$unitcode' AND (Pernr ='$pernr' OR Pernr='ALL') AND FormReviewer='$r[FormReviewer]'");
            $show_mr = mysqli_fetch_array($mr);
            if ($r['FormReviewer'] == 'create_planning_pengolahan' && $r['StatsX'] == 'X') {
                if (mysqli_num_rows($mr) != 0) { ?>
                    <div class="border-dashboard">
                        <h6 class=" mb-3">List of Requests <b>Planning Pengolahan</b></h6>
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-createplanningmenunggu-tab" data-bs-toggle="tab" data-bs-target="#nav-createplanningmenunggu" type="button" role="tab" aria-controls="nav-createplanningmenunggu" aria-selected="false">Antrian</button>
                            </div>
                        </nav>
                        <div class="tab-content mt-3" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-createplanningmenunggu" role="tabpanel" aria-labelledby="nav-createplanningmenunggu-tab">
                                <table id="mytable_dashboard1" class="table table-sm" style="width:100%;">
                                    <thead class="fw-normal bg-dark text-white">
                                        <tr>
                                            <th><input type="checkbox" name="" id="ceckallapprovalpengemasan" onchange="checkAllpengolahan(this.checked)"></th>
                                            <th style="width: 10%;">Planning Number</th>
                                            <th style="width: 5%;">Planning Years</th>
                                            <th style="width: 50%;">Proses Type</th>
                                            <th>Request Name</th>
                                            <th>Request Date</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = mysqli_query($conn, "SELECT * FROM tb_approval_viewer WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND 
                                                                                PersonnelNumber ='$pernr' AND
                                                                                ProcessType='planning_pengolahan' AND
                                                                                StatusApproval is null 
                                                                                ORDER BY PersonnelNumber ASC");
                                        while ($row = mysqli_fetch_array($sql)) {
                                            // --------- Cek Plan. Delete
                                            $query = mysqli_query($conn, "SELECT * FROM planning_pengolahan_header WHERE Plant='$plant' AND 
                                                                                                                        UnitCode='$unitcode' AND
                                                                                                                        PlanningNumber='$row[PlanningNumber]' AND
                                                                                                                        Years='$row[Years]' AND
                                                                                                                        Approval='X' AND
                                                                                                                        Del='X'");
                                            if (mysqli_num_rows($query) != 0) {
                                                continue;
                                            }
                                            // ------End
                                            $pernr1 = Getdata('PersonnelNumber', 'usr02', 'UserID', $row['CreatedBy']);
                                        ?>
                                            <tr>
                                                <td><input type="checkbox" name="selectallpengolahan[]" id="selectallpengolahan" value="<?= $row['PlanningNumber'] . '/' . $row['Years'] . '/' . $row['ProcessType'] . '/' . $row['Levels'] . '/' . $row['PersonnelNumber'] ?>"></td>
                                                <td class="text-dark"><button class="btn-sm badge bg-warning text-dark zoom" onclick="prosesdisplayplanning('<?= $row['ProcessType'] ?>','<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>')">#<?= $row['PlanningNumber'] ?></button></td>
                                                <td class="text-dark fw-bold"><?= $row['Years'] ?></td>
                                                <td class="text-dark fw-bold"><?= Getdata('Descriptions', 'text_sys', 'Jenisproses ', $row['ProcessType']) ?></td>
                                                <td><?= $pernr1 . ' - ' . Getdata('EmployeeName', 'pa001', 'PersonnelNumber', $pernr1) ?></td>
                                                <td><?= date('d/m/Y H:i:s', strtotime($row['CreatedOn'])) ?></td>
                                                <td><a href="#" class="badge bg-success zoom text-decoration-none text-white" onclick="prosesapprovalreviewer('<?= $row['ProcessType'] ?>','<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>','<?= $row['Levels'] ?>','<?= $row['PersonnelNumber'] ?>','Y')"><img src="../asset/icon/accept2.png"> Setuju</a>
                                                    <a href="#" class="badge bg-danger zoom text-decoration-none text-white" onclick="prosesapprovalreviewer('<?= $row['ProcessType'] ?>','<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>','<?= $row['Levels'] ?>','<?= $row['PersonnelNumber'] ?>','T')"><img src="../asset/icon/no_accept.png"> Tolak</a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="form-group row mb-0" id="buttonsetujuisemua">
                                    <div class="col-sm-2">
                                        <button type="button" class="btn btn-success btn-sm zoom" onclick="saveallapprovalpengolahan()"><img src="../asset/icon/accept2.png"> Setuju Semua</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
            } elseif ($r['FormReviewer'] == 'create_planning_pengemasan' && $r['StatsX'] == 'X') {
                if (mysqli_num_rows($mr) != 0) { ?>
                    <section class="border-dashboard">
                        <h6 class=" mb-3">List of Requests <b>Planning Pengemasan</b></h6>
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-createplanningmenunggu-tab" data-bs-toggle="tab" data-bs-target="#nav-createplanningmenunggu" type="button" role="tab" aria-controls="nav-createplanningmenunggu" aria-selected="false">Antrian</button>
                            </div>
                        </nav>
                        <div class="tab-content mt-3" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-createplanningmenunggu" role="tabpanel" aria-labelledby="nav-createplanningmenunggu-tab">
                                <table id="mytable_dashboard2" class="table table-sm" style="width:100%;">
                                    <thead class="fw-normal bg-dark text-white">
                                        <tr>
                                            <th><input type="checkbox" name="" id="ceckallapprovalpengemasan" onchange="checkAll(this.checked)"></th>
                                            <th style="width: 10%;">Planning Number</th>
                                            <th style="width: 5%;">Planning Years</th>
                                            <th style="width: 50%;">Produk</th>
                                            <th>Batch</th>
                                            <th>Qty</th>
                                            <th>Resource</th>
                                            <th>Mixing</th>
                                            <th>Tgl Mixing</th>
                                            <th>Request Date</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = mysqli_query($conn, "SELECT * FROM tb_approval_viewer WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND 
                                                                                PersonnelNumber ='$pernr' AND
                                                                                ProcessType='create_planning' AND
                                                                                StatusApproval is null");
                                        while ($row = mysqli_fetch_array($sql)) {
                                            $pernr2 = Getdata('PersonnelNumber', 'usr02', 'UserID', $row['CreatedBy']);
                                            $productid = GetdataIV('ProductID', 'planning_prod_header', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $row['PlanningNumber'], 'Years', $row['Years']);
                                        ?>
                                            <tr>
                                                <td><input type="checkbox" name="selectallpengemasan[]" id="selectallpengemasan" value="<?= $row['PlanningNumber'] . '/' . $row['Years'] . '/' . $row['ProcessType'] . '/' . $row['Levels'] . '/' . $row['PersonnelNumber'] ?>"></td>
                                                <td class="text-dark fw-bold"><button class="btn-sm badge bg-warning text-dark zoom" onclick="prosesdisplayplanning('<?= $row['ProcessType'] ?>','<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>')">#<?= $row['PlanningNumber'] ?></button></a></td>
                                                <td class="text-dark fw-bold"><?= $row['Years'] ?></td>
                                                <td class="text-dark fw-bold"><?= Getdata('ProductDescriptions', 'mara_product', 'ProductID', $productid) ?></td>
                                                <td class="text-dark fw-bold"><?= GetdataIV('BatchNumber', 'planning_prod_header', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $row['PlanningNumber'], 'Years', $row['Years']) ?></td>
                                                <td><?= GetdataIV('Quantity', 'planning_prod_header', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $row['PlanningNumber'], 'Years', $row['Years']) . ' ' . GetdataIV('UnitOfMeasures', 'planning_prod_header', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $row['PlanningNumber'], 'Years', $row['Years']) ?></td>
                                                <td><?= GetdataIV('ResourceID', 'planning_prod_header', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $row['PlanningNumber'], 'Years', $row['Years']) ?></td>
                                                <td><?= GetdataIV('ResourceIDMix', 'planning_prod_header', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $row['PlanningNumber'], 'Years', $row['Years']) ?></td>
                                                <td><?= GetdataIV('MixingDate', 'planning_prod_header', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $row['PlanningNumber'], 'Years', $row['Years']) ?></td>
                                                <!-- <td><?= $pernr2 . ' - ' . Getdata('EmployeeName', 'pa001', 'PersonnelNumber', $pernr2) ?></td> -->
                                                <td><?= date('d/m/Y H:i:s', strtotime($row['CreatedOn'])) ?></td>
                                                <td><a href="#" class="badge bg-success zoom text-decoration-none text-white" onclick="prosesapprovalreviewer('<?= $row['ProcessType'] ?>','<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>','<?= $row['Levels'] ?>','<?= $row['PersonnelNumber'] ?>')"><img src="../asset/icon/accept2.png"> Setuju</a>
                                                    <a href="#" class="badge bg-danger zoom text-decoration-none text-white" onclick="message(1)"><img src="../asset/icon/no_accept.png"> Tolak</a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="form-group row mb-0" id="buttonsetujuisemua">
                                    <div class="col-sm-2">
                                        <button type="button" class="btn btn-success btn-sm zoom" onclick="saveallapprovalpengemasan()"><img src="../asset/icon/accept2.png"> Setuju Semua</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php }
            } elseif ($r['FormReviewer'] == 'approval_proses' && $r['StatsX'] == 'X') {
                if (mysqli_num_rows($mr) != 0) { ?>
                    <section class="border-dashboard">
                        <h6 class="mb-3">List of Requests <b>Persetujuan All Proses</b></h6>
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-allprosespengemasanlanningmenunggu-tab" data-bs-toggle="tab" data-bs-target="#nav-allprosespengemasanlanningmenunggu" type="button" role="tab" aria-controls="nav-allprosespengemasanlanningmenunggu" aria-selected="false">Antrian</button>
                            </div>
                        </nav>
                        <div class="tab-content mt-3" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-allprosespengemasanlanningmenunggu" role="tabpanel" aria-labelledby="nav-allprosespengemasanlanningmenunggu-tab">
                                <section id="parameter3" class="mb-3">
                                    <div class="form-group row mb-0">
                                        <label for="batchstartdisplayplanningpengolahan" class="col-sm-2 col-form-label">Periode</label>
                                        <div class="col-sm-2">
                                            <input type="date" class="form-control form-control-sm" id="tglfromallproses" value="<?= $tgl_start ?>">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="date" class="form-control form-control-sm" id="tglendallproses" value="<?= $tgl_end ?>">
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-secondary btn-sm zoom" onclick="submitdisplayapprovalallproses()"><img src="../asset/icon/search.png"> Cari</button>
                                        </div>
                                    </div>
                                </section>
                                <table id="mytable_dashboard3" class="table table-sm" style="width:100%;">
                                    <thead class="fw-normal bg-dark text-white">
                                        <tr>
                                            <th><input type="checkbox" onchange="checkAll_allproses(this.checked)"></th>
                                            <th style="width: 10%;">Planning Number</th>
                                            <th style="width: 5%;">Planning Years</th>
                                            <th>Product ID</th>
                                            <th>Batch Number</th>
                                            <th>Request Name</th>
                                            <th>Request Date</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND 
                                                                            (ReviewMG ='' or ReviewMG is null) AND
                                                                            (ReviewQA ='' or ReviewQA is null) AND
                                                                            RekonPillow='X' AND
                                                                            CreatedOn >='$tgl_start' AND CreatedOn <= '$tgl_end' 
                                                                            ORDER BY CreatedOn ASC");
                                        while ($row = mysqli_fetch_array($sql)) {
                                            $pernr3 = Getdata('PersonnelNumber', 'usr02', 'UserID', $row['CreatedBy']);
                                        ?>
                                            <tr>
                                                <td><input type="checkbox" name="selectallproses[]" id="selectallproses" value="<?= $row['PlanningNumber'] . '/' . $row['Years'] ?>"></td>
                                                <td class="text-dark"><button class="btn-sm badge bg-warning text-dark zoom" onclick="showdetailallproses('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>')">#<?= $row['PlanningNumber'] ?></button></a></td>
                                                <td class="text-dark"><?= $row['Years'] ?></td>
                                                <td><?= $row['ProductID'] ?></td>
                                                <td><?= $row['BatchNumber'] ?></td>
                                                <td><?= $pernr3 . ' - ' . Getdata('EmployeeName', 'pa001', 'PersonnelNumber', $pernr3) ?></td>
                                                <td><?= date('d/m/Y H:i:s', strtotime($row['CreatedOn'])) ?></td>
                                                <td><a href="#" class="badge bg-success zoom text-decoration-none text-white" onclick="saveapprovalproses('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>')"><img src="../asset/icon/accept2.png"> Setuju</a>
                                                    <a href="#" class="badge bg-danger zoom text-decoration-none text-white" onclick="message(1)"><img src="../asset/icon/no_accept.png"> Tolak</a>
                                                </td>
                                            </tr>
                                        <?php
                                            $i = $i + 1;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="form-group row mb-0" id="buttonsetujuisemua">
                                    <div class="col-sm-2">
                                        <button type="button" class="btn btn-success btn-sm zoom" onclick="saveallapprovalproses()"><img src="../asset/icon/accept2.png"> Setuju Semua</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php
                }
            } elseif ($r['FormReviewer'] == 'other_request' && $r['StatsX'] == 'X') {
                if (mysqli_num_rows($mr) != 0) { ?>
                    <section class="border-dashboard">
                        <h6 class="mb-3">List of Requests <b>Other Request</b></h6>
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-allprosespengemasanlanningmenunggu-tab" data-bs-toggle="tab" data-bs-target="#nav-allprosespengemasanlanningmenunggu" type="button" role="tab" aria-controls="nav-allprosespengemasanlanningmenunggu" aria-selected="false">Antrian</button>
                            </div>
                        </nav>
                        <div class="tab-content mt-3" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-allprosespengemasanlanningmenunggu" role="tabpanel" aria-labelledby="nav-allprosespengemasanlanningmenunggu-tab">
                                <section id="parameter3" class="mb-3">
                                    <div class="form-group row mb-0">
                                        <label for="batchstartdisplayplanningpengolahan" class="col-sm-2 col-form-label">Periode</label>
                                        <div class="col-sm-2">
                                            <input type="date" class="form-control form-control-sm" id="tglfromallproses" value="<?= $tgl_start ?>">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="date" class="form-control form-control-sm" id="tglendallproses" value="<?= $tgl_end ?>">
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-secondary btn-sm zoom" onclick="submitdisplayapprovalallproses()"><img src="../asset/icon/search.png"> Cari</button>
                                        </div>
                                    </div>
                                </section>
                                <table id="mytable_dashboard4" class="table table-sm" style="width:100%;">
                                    <thead class="fw-normal bg-dark text-white">
                                        <tr>
                                            <th><input type="checkbox" onchange="checkAll_allproses(this.checked)"></th>
                                            <th style="width: 10%;">No Tiket</th>
                                            <th style="width: 5%;">Years</th>
                                            <th>Type Perubahan</th>
                                            <th>Request Name</th>
                                            <th>Request Date</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $type = '';
                                        $sql = mysqli_query($conn, "SELECT * FROM tbl_tempupdate WHERE Stats14=''");
                                        while ($row = mysqli_fetch_array($sql)) {
                                            $pernr3 = Getdata('PersonnelNumber', 'usr02', 'UserID', $row['CreatedBy']);
                                            switch ($row['ObjectUpdate']) {
                                                case 'proses_prepare_mixer':
                                                    $type = 'Prepare Mixer';
                                                    break;
                                                case 'qc_result_pengolahan':
                                                    $type = 'QC Result Pengolahan';
                                                    break;
                                                case 'result_recording':
                                                    $type = 'QC Organoleptis';
                                                    break;
                                                default:
                                                    break;
                                            }
                                        ?>
                                            <tr>
                                                <td><input type="checkbox" name="selectallproses[]" id="selectallproses" value="<?= $row['NoUpdate'] . '/' . $row['NoUpdateYears'] ?>"></td>
                                                <td class="text-dark"><button class="btn-sm badge bg-warning text-dark zoom" onclick="showdatachange('<?= $row['NoUpdate'] ?>','<?= $row['NoUpdateYears'] ?>','<?= $row['ObjectUpdate'] ?>')">#<?= $row['NoUpdate'] ?></button></a></td>
                                                <td class="text-dark"><?= $row['NoUpdateYears'] ?></td>
                                                <td><?= $type ?></td>
                                                <td><?= $pernr3 . ' - ' . Getdata('EmployeeName', 'pa001', 'PersonnelNumber', $pernr3) ?></td>
                                                <td><?= beautydate2($row['CreatedOn']) ?></td>
                                                <td><a href="#" class="badge bg-success zoom text-decoration-none text-white" onclick="approvechangepersiapanpengolahan('<?= $row['NoUpdate'] ?>','<?= $row['NoUpdateYears'] ?>','<?= $row['ObjectUpdate'] ?>')"><img src="../asset/icon/accept2.png"> Setuju</a>
                                                    <a href="#" class="badge bg-danger zoom text-decoration-none text-white" onclick="message(1)"><img src="../asset/icon/no_accept.png"> Tolak</a>
                                                </td>
                                            </tr>
                                        <?php
                                            $i = $i + 1;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="form-group row mb-0" id="buttonsetujuisemua">
                                    <div class="col-sm-2">
                                        <button type="button" class="btn btn-success btn-sm zoom" onclick="saveallapprovalproses()"><img src="../asset/icon/accept2.png"> Setuju Semua</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
    <?php }
            }
        }
    } ?>
</div>

<!-- Modal Display Planning Pengemasan-->
<div class="modal fade" id="modaldisplayplanning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Display Planning Pengemasan</h5>
                <button type="button" class="btn btn-sm btn-dark href_transform" data-bs-dismiss="modal" aria-label="Close"><img src="../asset/icon/back.png"> Back</button>
            </div>
            <div class="modal-body">
                <div class="border-0 mb-0">
                    <div class="form-group row mb-0">
                        <label for="numberdisplayplanning" class="col-sm-2 col-form-label">Planning Number</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="numberdisplayplanning" readonly>
                        </div>
                        <label for="shiftdisplayplanning" class="col-sm-2 offset-3 col-form-label">Shift</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" id="shiftdisplayplanning" readonly>
                        </div>

                    </div>
                    <div class="form-group row mb-0">
                        <label for="yearsdisplayplanning" class="col-sm-2 col-form-label">Years</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="yearsdisplayplanning" readonly>
                        </div>
                        <label for="createonisplayplanning" class="col-sm-2 offset-3 col-form-label">Dibuat Tgl</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" id="createonisplayplanning" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="createbydisplayplanning" class="col-sm-2 offset-7 col-form-label">Dibuat Oleh</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" id="createbydisplayplanning" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="tglkemasdisplayplanning" class="col-sm-2 offset-7 col-form-label">Packing Date</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" id="tglkemasdisplayplanning" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="tglmixingdisplayplanning" class="col-sm-2 offset-7 col-form-label">Mixing Date</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" id="tglmixingdisplayplanning" readonly>
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        <label for="prosesnumberdisplayplanning" class="col-sm-2 offset-7">Process Number/Tong</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control form-control-sm" id="prosesnumberdisplayplanning" min="1" readonly>
                        </div>
                        <!-- <label for="notongdisplayplanning" class="col-sm-1">Tong</label> -->
                        <div class="col-sm-2">
                            <input type="number" class="form-control form-control-sm" id="notongdisplayplanning" min="1" readonly>
                        </div>
                    </div>
                    <section id="approvalplanningpengemasan"></section>
                    <div class="form-group row" hidden>
                        <div class="col-sm-12 text-end">
                            <button type="button" class="btn btn-outline-success btn-sm" id="savechangeplanning" onclick="updateproduksiplanningdisplayplanning()"><img src="../asset/icon/save.png"> Save or Update</button>
                            <!-- <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload()"><img src="../asset/icon/trash.png"> Display</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End -->

<!-- Modal Display Planning-->
<div class="modal fade" id="modaldisplayplanning2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Display Planning Pengolahan</h6>
                <button type="button" class="btn btn-sm btn-dark href_transform" data-bs-dismiss="modal" aria-label="Close"><img src="../asset/icon/back.png"> Back</button>
            </div>
            <div class="modal-body">
                <div class="border-0 mb-0 bg-transparent">
                    <div class="form-group row mb-0">
                        <label for="planningnumberdisplayplanningpengolahan" class="col-sm-2 col-form-label">Planning Number</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="planningnumberdisplayplanningpengolahan" readonly>
                        </div>
                        <label for="shiftdisplayplanningpengolahan" class="col-sm-2 offset-3 col-form-label">Shift</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" id="shiftdisplayplanningpengolahan" readonly>
                        </div>

                    </div>
                    <div class="form-group row mb-0">
                        <label for="yearsdisplayplanningpengolahan" class="col-sm-2 col-form-label">Years</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="yearsdisplayplanningpengolahan" readonly>
                        </div>
                        <label for="createdondisplayplanningpengolahan" class="col-sm-2 offset-3 col-form-label">Dibuat Tgl</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" id="createdondisplayplanningpengolahan" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="createdfordisplayplanningpengolahan" class="col-sm-2 offset-7 col-form-label">Dibuat Oleh</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" id="createdfordisplayplanningpengolahan" readonly>
                        </div>
                    </div>

                </div>
                <section id="approvalplanningpengolahan"></section>
                <section id="listbahan1"></section>
            </div>
        </div>
    </div>
</div>
<!-- End -->

<script>
    function checkAll(ele) {
        let checkboxes = document.querySelectorAll(`input[type="checkbox"][id^="selectallpengemasan"]`);
        if (ele === true) {
            checkboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
        } else {
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        }
    }

    function checkAllpengolahan(ele) {
        let checkboxes = document.querySelectorAll(`input[type="checkbox"][id^="selectallpengolahan"]`);
        if (ele === true) {
            checkboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
        } else {
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        }
    }

    function checkAll_allproses(ele) {
        let checkboxes = document.querySelectorAll(`input[type="checkbox"][id^="selectallproses"]`);
        if (ele === true) {
            checkboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
        } else {
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        }
    }
</script>