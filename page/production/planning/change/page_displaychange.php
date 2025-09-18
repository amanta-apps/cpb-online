    <?php
    include '../../function/koneksi.php';
    $notiket = base64_decode($_GET['x']);
    $tiketyears = base64_decode($_GET['y']);
    $object = trim(base64_decode($_GET['z']));
    $query = mysqli_query($conn, "SELECT * FROM tbl_tempupdate WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND
                                                                    NoUpdate='$notiket' AND 
                                                                    NoUpdateYears='$tiketyears' AND
                                                                    ObjectUpdate='$object' AND
                                                                    Stats14=''");
    $r = mysqli_fetch_array($query);
    $planningnumber = $r['PlanningNumber'];
    $years = $r['Years'];
    $noproses = $r['NoProses'];
    $productid = $r['ProductID'];
    $batchnumber = $r['BatchNumber'];
    $insplot = $r['InspectionLot'];
    $inspyear = $r['Lotyears'];
    $createdon = $r['CreatedOn'];
    $createdby = $r['CreatedBy'];
    ?>
    <div class="container">
        <div class="border-0 mb-0 p-3 mt-3">
            <div class="form-group row mb-0">
                <label for="noproseschangepersiapanpengolahan" class="col-sm-2 col-form-label">Tiket Number</label>
                <div class="col-sm-3">
                    <input type="text" id="noproseschangepersiapanpengolahan" class="form-control form-control-sm" value="<?= $notiket ?> " readonly>
                </div>
                <div class="col-sm-1">
                    <input type="text" id="noproseschangepersiapanpengolahan" class="form-control form-control-sm" value="<?= $tiketyears ?> " readonly>
                </div>
                <label for="noproseschangepersiapanpengolahan" class="col-sm-2 offset-2 col-form-label">Product ID</label>
                <div class="col-sm-2">
                    <div class="input-group">
                        <input type="text" id="productidchangepersiapanpengolahan" class="form-control form-control-sm" value="<?= $productid ?> " readonly>
                        <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" onclick="displaymaterial($('#productidchangepersiapanpengolahan').val())"><img src="../asset/icon/detail.png" title="Display Material"></button>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-0">
                <label for="noproseschangepersiapanpengolahan" class="col-sm-2 col-form-label">Planning Number</label>
                <div class="col-sm-3">
                    <input type="text" id="noproseschangepersiapanpengolahan" class="form-control form-control-sm" value="<?= $planningnumber ?> " readonly>
                </div>
                <div class="col-sm-1">
                    <input type="text" id="noproseschangepersiapanpengolahan" class="form-control form-control-sm" value="<?= $years ?> " readonly>
                </div>
                <label for="noproseschangepersiapanpengolahan" class="col-sm-2 offset-2 col-form-label">Batch Number</label>
                <!-- <div class="col-sm-2">
                    <input type="text" id="noproseschangepersiapanpengolahan" class="form-control form-control-sm" value="<?= $batchnumber ?> " readonly>
                </div> -->
                <div class="col-sm-2">
                    <div class="input-group">
                        <input type="text" id="batchnumberchangepersiapanpengolahan" class="form-control form-control-sm" value="<?= $batchnumber ?> " readonly>
                        <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" onclick="displaybatch($('#productidchangepersiapanpengolahan').val(),$('#batchnumberchangepersiapanpengolahan').val())"><img src="../asset/icon/detail.png" title="Display Batch"></button>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-0">
                <?php
                if ($object != "result_recording") { ?>
                    <label for="noproseschangepersiapanpengolahan" class="col-sm-2 col-form-label">No Proses</label>
                    <div class="col-sm-1">
                        <input type="text" id="noproseschangepersiapanpengolahan" class="form-control form-control-sm" value="<?= $noproses ?> " readonly>
                    </div>
                    <label for="noproseschangepersiapanpengolahan" class="col-sm-2 offset-5 col-form-label">Request By</label>
                    <div class="col-sm-2">
                        <input type="text" id="noproseschangepersiapanpengolahan" class="form-control form-control-sm" value="<?= Getpernr($createdby) ?> " readonly>
                    </div>
                <?php
                } else { ?>
                    <label for="noproseschangepersiapanpengolahan" class="col-sm-2 col-form-label">Inspection Lot</label>
                    <div class="col-sm-3">
                        <input type="text" id="noproseschangepersiapanpengolahan" class="form-control form-control-sm" value="<?= $insplot ?> " readonly>
                    </div>
                    <div class="col-sm-1">
                        <input type="text" id="noproseschangepersiapanpengolahan" class="form-control form-control-sm" value="<?= $inspyear ?> " readonly>
                    </div>
                    <label for="noproseschangepersiapanpengolahan" class="col-sm-2 offset-2 col-form-label">Request By</label>
                    <div class="col-sm-2">
                        <input type="text" id="noproseschangepersiapanpengolahan" class="form-control form-control-sm" value="<?= Getpernr($createdby) ?> " readonly>
                    </div>
                <?php
                }
                ?>

            </div>
            <div class="form-group row mb-0">
                <?php
                if ($object == "result_recording") { ?>
                    <label for="noproseschangepersiapanpengolahan" class="col-sm-2 col-form-label">No Proses</label>
                    <div class="col-sm-1">
                        <input type="text" id="noproseschangepersiapanpengolahan" class="form-control form-control-sm" value="<?= $noproses ?> " readonly>
                    </div>
                    <label for="noproseschangepersiapanpengolahan" class="col-sm-2 offset-5 col-form-label">Request Date</label>
                    <div class="col-sm-2">
                        <input type="text" id="noproseschangepersiapanpengolahan" class="form-control form-control-sm" value="<?= beautydate1(date('Ymd', strtotime($createdon))) ?> " readonly>
                    </div>
                <?php
                } else { ?>
                    <label for="noproseschangepersiapanpengolahan" class="col-sm-2 offset-8 col-form-label">Request Date</label>
                    <div class="col-sm-2">
                        <input type="text" id="noproseschangepersiapanpengolahan" class="form-control form-control-sm" value="<?= beautydate1(date('Ymd', strtotime($createdon))) ?> " readonly>
                    </div>
                <?php
                }
                ?>

            </div>
            <div class="form-group row mb-0">
                <label for="noproseschangepersiapanpengolahan" class="col-sm-2 offset-8 col-form-label">Request Time</label>
                <div class="col-sm-2">
                    <input type="text" id="noproseschangepersiapanpengolahan" class="form-control form-control-sm" value="<?= date('H:i:s', strtotime($createdon)) ?> " readonly>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12 text-end">
                    <button type="button" class="btn btn-success btn-sm zoom" onclick="approvechangepersiapanpengolahan('<?= $notiket ?>','<?= $tiketyears ?>','<?= $object ?>')"><img src="../asset/icon/accept2.png"> Approve</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    if ($object == "proses_prepare_mixer") {
        $sql = mysqli_query($conn, "SELECT * FROM proses_prepare_mixer WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                PlanningNumber='$planningnumber' AND
                                                                                Years='$years' AND
                                                                                ProductID='$productid' AND
                                                                                BatchNumber='$batchnumber' AND
                                                                                NoProses='$noproses' AND
                                                                                StatsUpdate=''
                                                                                ORDER BY CreatedOn ASC");
        $row = mysqli_fetch_array($sql);
        $operator1 = $row['Operator1'];
        $operator2 = $row['Operator2'];
        $operator3 = $row['Operator3'];
        $pengawas = $row['PengawasProduksi'];
        $param1 = $row['Parameter_1'];
        $param2 = $row['Parameter_2'];
        $param3 = $row['Parameter_3'];
        $param4 = $row['Parameter_4'];
        $param5 = $row['Parameter_5'];
        $param6 = $row['Parameter_6'];
        $param7 = $row['Parameter_7'];
        $param8 = $row['Parameter_8'];
        $param9 = $row['Parameter_9'];
        $param10 = $row['Parameter_10'];
    } elseif ($object == "qc_result_pengolahan") {
        $sql = mysqli_query($conn, "SELECT * FROM qc_result WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    PlanningNumber='$planningnumber' AND
                                                                    Years='$years' AND
                                                                    Types='Pengolahan' AND
                                                                    BatchNumber='$batchnumber' AND
                                                                    NoProses='$noproses' AND
                                                                    StatsUpdate=''
                                                                    ORDER BY CreatedOn ASC");
        $row = mysqli_fetch_array($sql);
        $suhu = $row['Suhu'];
        $qcname = $row['CreatedFor'];
    } elseif ($object == "result_recording") {
        $sql = mysqli_query($conn, "SELECT * FROM result_recording WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    InspectionLot ='$insplot' AND
                                                                    Lotyears ='$inspyear' AND
                                                                    NoProses='$noproses' AND
                                                                    StatsUpdate=''
                                                                    ORDER BY CreatedOn ASC");
    }
    if ($object == "proses_prepare_mixer") {
    ?>
        <div class="container">
            <div class="form-group row mb-0" id="cardcolor">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Data Lama</button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Data Baru</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="card mb-3">
                            <div class="border-0 mb-0 p-3 mt-3">
                                <div class="form-group row mb-0">
                                    <label for="personalnumberemployee" class="col-sm-2 offset-7 col-form-label">Operator 1</label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" value="<?= $operator1 ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="personalnumberemployee" class="col-sm-2 offset-7 col-form-label">Operator 2</label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" value="<?= $operator2 ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="personalnumberemployee" class="col-sm-2 offset-7 col-form-label">Operator 3</label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" value="<?= $operator3 ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="pengawasproduksipersiapanpengolahan" class="col-sm-2 offset-7 col-form-label">Pengawas Produksi</label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" value="<?= $pengawas ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <h6 class="fw-bold">Input Parameter</h6>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="parameter1changepersiapanpengolahan" class="col-sm-8 col-form-label">1. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 1) ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm" value="<?= $param1 ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="parameter2displaydata" class="col-sm-8 col-form-label">2. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 2) ?></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" value="<?= $param2 ?>" id="parameter2changepersiapanpengolahan" readonly>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control form-control-sm" value="°C" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="parameter3changepersiapanpengolahan" class="col-sm-8 col-form-label">3. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 3) ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm" value="<?= $param3 ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="parameter4changepersiapanpengolahan" class="col-sm-8 col-form-label">4. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 4) ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm" value="<?= $param4 ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="parameter5changepersiapanpengolahan" class="col-sm-8 col-form-label">5. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 5) ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm" value="<?= $param5 ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="parameter6changepersiapanpengolahan" class="col-sm-8 col-form-label">6. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 6) ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm" value="<?= $param6 ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="parameter7changepersiapanpengolahan" class="col-sm-8 col-form-label">7. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 7) ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm" value="<?= $param7 ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="parameter8changepersiapanpengolahan" class="col-sm-8 col-form-label">8. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 8) ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm" value="<?= $param8 ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="parameter9changepersiapanpengolahan" class="col-sm-8 col-form-label">9. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 9) ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm" value="<?= $param9 ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="parameter10changepersiapanpengolahan" class="col-sm-8 col-form-label">10. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 10) ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm" value="<?= $param10 ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <?php
                        $sql = mysqli_query($conn, "SELECT * FROM proses_prepare_mixer WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                PlanningNumber='$planningnumber' AND
                                                                                Years='$years' AND
                                                                                ProductID='$productid' AND
                                                                                BatchNumber='$batchnumber' AND
                                                                                NoProses='$noproses' AND
                                                                                StatsUpdate=1
                                                                                ORDER BY CreatedOn ASC");
                        if (mysqli_num_rows($sql) <> 0) {
                            $row = mysqli_fetch_array($sql);
                            $operator1 = $row['Operator1'];
                            $operator2 = $row['Operator2'];
                            $operator3 = $row['Operator3'];
                            $pengawas = $row['PengawasProduksi'];
                            $param1 = $row['Parameter_1'];
                            $param2 = $row['Parameter_2'];
                            $param3 = $row['Parameter_3'];
                            $param4 = $row['Parameter_4'];
                            $param5 = $row['Parameter_5'];
                            $param6 = $row['Parameter_6'];
                            $param7 = $row['Parameter_7'];
                            $param8 = $row['Parameter_8'];
                            $param9 = $row['Parameter_9'];
                            $param10 = $row['Parameter_10'];
                            # code...
                        }
                        ?>
                        <div class="card mb-3">
                            <div class="border-0 mb-0 p-3 mt-3">
                                <div class="form-group row mb-0">
                                    <label for="personalnumberemployee" class="col-sm-2 offset-7 col-form-label">Operator 1</label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" value="<?= $operator1 ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="personalnumberemployee" class="col-sm-2 offset-7 col-form-label">Operator 2</label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" value="<?= $operator2 ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="personalnumberemployee" class="col-sm-2 offset-7 col-form-label">Operator 3</label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" value="<?= $operator3 ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="pengawasproduksipersiapanpengolahan" class="col-sm-2 offset-7 col-form-label">Pengawas Produksi</label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" value="<?= $pengawas ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <h6 class="fw-bold">Input Parameter</h6>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="parameter1changepersiapanpengolahan" class="col-sm-8 col-form-label">1. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 1) ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm" value="<?= $param1 ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="parameter2displaydata" class="col-sm-8 col-form-label">2. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 2) ?></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" value="<?= $param2 ?>" id="parameter2changepersiapanpengolahan" readonly>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control form-control-sm" value="°C" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="parameter3changepersiapanpengolahan" class="col-sm-8 col-form-label">3. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 3) ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm" value="<?= $param3 ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="parameter4changepersiapanpengolahan" class="col-sm-8 col-form-label">4. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 4) ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm" value="<?= $param4 ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="parameter5changepersiapanpengolahan" class="col-sm-8 col-form-label">5. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 5) ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm" value="<?= $param5 ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="parameter6changepersiapanpengolahan" class="col-sm-8 col-form-label">6. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 6) ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm" value="<?= $param6 ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="parameter7changepersiapanpengolahan" class="col-sm-8 col-form-label">7. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 7) ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm" value="<?= $param7 ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="parameter8changepersiapanpengolahan" class="col-sm-8 col-form-label">8. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 8) ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm" value="<?= $param8 ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="parameter9changepersiapanpengolahan" class="col-sm-8 col-form-label">9. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 9) ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm" value="<?= $param9 ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="parameter10changepersiapanpengolahan" class="col-sm-8 col-form-label">10. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 10) ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm" value="<?= $param10 ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <div class="col-sm-12 text-end">
                        <button type="button" class="btn btn-success btn-sm zoom" onclick="approvechangepersiapanpengolahan('<?= $_GET['x'] ?>','<?= $_GET['y'] ?>','<?= $_GET['z'] ?>')"><img src="../asset/icon/accept2.png"> Approve</button>
                    </div>
                </div> -->
            </div>
        </div>
    <?php
    } else if ($object == "qc_result_pengolahan") {
    ?>
        <div class="container">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Data Lama</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Data Baru</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="form-group row mb-1 ms-3 mt-5">
                        <div class="form-group row mb-0">
                            <label for="noproseschangepersiapanpengolahan" class="col-sm-2 offset-8 col-form-label">Qc Name</label>
                            <div class="col-sm-2">
                                <input type="text" id="noproseschangepersiapanpengolahan" class="form-control form-control-sm" value="<?= $qcname . ' - ' . Getnamakaryawan2($qcname) ?> " readonly>
                            </div>
                        </div>
                        <h6 class="fw-bold">Record Result RH & Suhu</h6>
                        <table class="table table-sm" style=" width: 50%;">
                            <thead class="fw-bold bg-secondary text-white">
                                <tr>
                                    <td style="width: 50%;">Deskripsi</td>
                                    <td>Spesifikasi</td>
                                    <td>Satuan</td>
                                    <td>Penilaian</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Suhu</td>
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent text-start" id="suhu_persiapanhoperqc" value="<?= Getdata('Nilai', 'qc_characteristic', 'KodeProses', 'HP01') ?>" readonly></td>
                                    <td> °C</td>
                                    <td><input type="number" class="form-control form-control-sm" id="parameter2persiapanhoperqc" value="<?= $suhu ?>" readonly></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade show" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <?php
                    if ($object == "qc_result_pengolahan") {
                        $sql = mysqli_query($conn, "SELECT * FROM qc_result WHERE Plant='$plant' AND
                                                                                        UnitCode='$unitcode' AND
                                                                                        PlanningNumber='$planningnumber' AND
                                                                                        Years='$years' AND
                                                                                        Types='Pengolahan' AND
                                                                                        BatchNumber='$batchnumber' AND
                                                                                        NoProses='$noproses' AND
                                                                                        StatsUpdate='1'
                                                                                        ORDER BY CreatedOn ASC");
                        $row = mysqli_fetch_array($sql);
                        $suhu = $row['Suhu'];
                        $qcname = $row['CreatedFor'];
                    }
                    ?>
                    <div class="form-group row mb-1 ms-3 mt-5">
                        <div class="form-group row mb-0">
                            <label for="noproseschangepersiapanpengolahan" class="col-sm-2 offset-8 col-form-label">Qc Name</label>
                            <div class="col-sm-2">
                                <input type="text" id="noproseschangepersiapanpengolahan" class="form-control form-control-sm" value="<?= $qcname . ' - ' . Getnamakaryawan2($qcname) ?> " readonly>
                            </div>
                        </div>
                        <h6 class="fw-bold">Record Result RH & Suhu</h6>
                        <table class="table table-sm" style=" width: 50%;">
                            <thead class="fw-bold bg-secondary text-white">
                                <tr>
                                    <td style="width: 50%;">Deskripsi</td>
                                    <td>Spesifikasi</td>
                                    <td>Satuan</td>
                                    <td>Penilaian</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Suhu</td>
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent text-start" id="suhu_persiapanhoperqc" value="<?= Getdata('Nilai', 'qc_characteristic', 'KodeProses', 'HP01') ?>" readonly></td>
                                    <td> °C</td>
                                    <td><input type="number" class="form-control form-control-sm" id="parameter2persiapanhoperqc" value="<?= $suhu ?>" readonly></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else if ($object == "result_recording") { ?>
        <div class="container">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Data Lama</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Data Baru</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <table class="table table-sm w-100 mt-3">
                        <thead class="fw-bold bg-secondary text-white">
                            <tr>
                                <td rowspan="2" class="text-center align-middle">No</td>
                                <td rowspan="2" class="align-middle">Master of Inspection</td>
                                <td rowspan="2" class="align-middle" style="width: 50%;">Parameter</td>
                                <td colspan="3" class="text-center align-middle">Hasil Pemeriksaan</td>
                                <td rowspan="2" class="align-middle">Keterangan Hasil Tolak</td>
                            </tr>
                            <tr>
                                <td class="text-center">Awal</td>
                                <td class="text-center">Tengah</td>
                                <td class="text-center">Akhir</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $query = mysqli_query($conn, "SELECT * FROM result_recording WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            InspectionLot ='$insplot' AND
                                                                                            Lotyears ='$inspyear' AND
                                                                                            NoProses='$noproses' AND
                                                                                            StatsUpdate=''
                                                                                            ORDER BY CreatedOn ASC");
                            while ($r = mysqli_fetch_array($query)) {
                                $sql = mysqli_query($conn, "SELECT Descriptions,Qual,Quan,FullyDesc FROM master_inspection WHERE Plant='$plant' AND 
                                                                                                        UnitCode='$unitcode' AND 
                                                                                                        MIC ='$r[MIC]'");
                                $q = mysqli_fetch_array($sql); ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center">
                                        <input class="form-control form-control-sm  border-0 bg-transparent" type="text" value="<?= $r['MIC'] ?>" readonly>
                                    </td>
                                    <td>
                                        <label class="text-decoration-underline"><?= $q['Descriptions'] ?></label>
                                        <br>
                                        <?= $q['FullyDesc'] ?>
                                    </td>
                                    <?php
                                    if ($q['Quan'] == 'X') { ?>
                                        <td class="text-center">
                                            <input class="form-control form-control-sm" type="text" value="<?= $r['Result_Awal'] ?>" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-control form-control-sm" type="text" value="<?= $r['Result_Tengah'] ?>" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-control form-control-sm" type="text" value="<?= $r['Result_Akhir'] ?>" disabled>
                                        </td>
                                    <?php } elseif ($q['Qual'] == 'X') {
                                        if ($r['Result_Awal'] == true) {
                                            $result_awal = 'checked';
                                        }
                                        if ($r['Result_Tengah'] == true) {
                                            $result_tengah = 'checked';
                                        }
                                        if ($r['Result_Akhir'] == true) {
                                            $result_akhir = 'checked';
                                        }
                                    ?>
                                        <td class="text-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" <?= str_replace("'", "", $result_awal) ?> disabled>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" <?= str_replace("'", "", $result_tengah) ?> disabled>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" <?= str_replace("'", "", $result_akhir) ?> disabled>
                                            </div>
                                        </td>
                                    <?php }
                                    ?>
                                    <td class="text-center"><input type="text" class="form-control form-control-sm" value="<?= $r['Ket_hasiltolak'] ?>" disabled></td>
                                </tr>
                            <?php
                                $i += 1;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade show" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <table class="table table-sm w-100 mt-3">
                        <thead class="fw-bold bg-secondary text-white">
                            <tr>
                                <td rowspan="2" class="text-center align-middle">No</td>
                                <td rowspan="2" class="align-middle">Master of Inspection</td>
                                <td rowspan="2" class="align-middle" style="width: 50%;">Parameter</td>
                                <td colspan="3" class="text-center align-middle">Hasil Pemeriksaan</td>
                                <td rowspan="2" class="align-middle">Keterangan Hasil Tolak</td>
                            </tr>
                            <tr>
                                <td class="text-center">Awal</td>
                                <td class="text-center">Tengah</td>
                                <td class="text-center">Akhir</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $query = mysqli_query($conn, "SELECT * FROM result_recording WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            InspectionLot ='$insplot' AND
                                                                                            Lotyears ='$inspyear' AND
                                                                                            NoProses='$noproses' AND
                                                                                            StatsUpdate=1
                                                                                            ORDER BY CreatedOn ASC");
                            while ($r = mysqli_fetch_array($query)) {
                                $sql = mysqli_query($conn, "SELECT Descriptions,Qual,Quan,FullyDesc FROM master_inspection WHERE Plant='$plant' AND 
                                                                                                        UnitCode='$unitcode' AND 
                                                                                                        MIC ='$r[MIC]'");
                                $q = mysqli_fetch_array($sql); ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center">
                                        <input class="form-control form-control-sm  border-0 bg-transparent" type="text" value="<?= $r['MIC'] ?>" readonly>
                                    </td>
                                    <td>
                                        <label class="text-decoration-underline"><?= $q['Descriptions'] ?></label>
                                        <br>
                                        <?= $q['FullyDesc'] ?>
                                    </td>
                                    <?php
                                    if ($q['Quan'] == 'X') { ?>
                                        <td class="text-center">
                                            <input class="form-control form-control-sm" type="text" value="<?= $r['Result_Awal'] ?>" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-control form-control-sm" type="text" value="<?= $r['Result_Tengah'] ?>" disabled>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-control form-control-sm" type="text" value="<?= $r['Result_Akhir'] ?>" disabled>
                                        </td>
                                    <?php } elseif ($q['Qual'] == 'X') {
                                        if ($r['Result_Awal'] == true) {
                                            $result_awal = 'checked';
                                        }
                                        if ($r['Result_Tengah'] == true) {
                                            $result_tengah = 'checked';
                                        }
                                        if ($r['Result_Akhir'] == true) {
                                            $result_akhir = 'checked';
                                        }
                                    ?>
                                        <td class="text-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" <?= str_replace("'", "", $result_awal) ?> disabled>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" <?= str_replace("'", "", $result_tengah) ?> disabled>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" <?= str_replace("'", "", $result_akhir) ?> disabled>
                                            </div>
                                        </td>
                                    <?php }
                                    ?>
                                    <td class="text-center"><input type="text" class="form-control form-control-sm" value="<?= $r['Ket_hasiltolak'] ?>" disabled></td>
                                </tr>
                            <?php
                                $i += 1;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

    <!-- Operator 1-->
    <div class="modal fade" id="searchoperator1changepersiapanpengolahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">List Operator</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="dmainresources" class="table table-striped table-sm" style="width:100%;">
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
                                        <a href="#" class="badge bg-success text-decoration-none" onclick="$('#operator1changepersiapanpengolahan').val('<?= $row['EmployeeName'] ?>'),$('#searchoperator1changepersiapanpengolahan').modal('hide')">Select</a>
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

    <!-- Operator 2-->
    <div class="modal fade" id="searchoperator2changepersiapanpengolahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">List Operator</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="dmainresources2" class="table table-striped table-sm" style="width:100%;">
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
                                        <a href="#" class="badge bg-success text-decoration-none" onclick="$('#operator2changepersiapanpengolahan').val('<?= $row['EmployeeName'] ?>'),$('#searchoperator2changepersiapanpengolahan').modal('hide')">Select</a>
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

    <!-- Operator 3-->
    <div class="modal fade" id="searchoperator3changepersiapanpengolahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">List Operator</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="dmainresources3" class="table table-striped table-sm" style="width:100%;">
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
                                        <a href="#" class="badge bg-success text-decoration-none" onclick="$('#operator3changepersiapanpengolahan').val('<?= $row['EmployeeName'] ?>'),$('#searchoperator3changepersiapanpengolahan').modal('hide')">Select</a>
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
    <!-- Pengawas Produksi-->
    <div class="modal fade" id="searchpengawasproduksichangepersiapanpengolahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">List Operator</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="dmainresources4" class="table table-striped table-sm" style="width:100%;">
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
                                        <a href="#" class="badge bg-success text-decoration-none" onclick="$('#pengawasproduksichangepersiapanpengolahan').val('<?= $row['EmployeeName'] ?>'),$('#searchpengawasproduksichangepersiapanpengolahan').modal('hide')">Select</a>
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