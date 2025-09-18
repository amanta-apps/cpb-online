<?php
$value = explode("*", base64_decode($_GET['x']));
// <---- Note ----->
// 0: PREPARE MIXER
// 1: QC RESULT
// 2: USAGE DECISION
if ($value[5] == 0) {
    $sql = mysqli_query($conn, "SELECT * FROM proses_prepare_mixer WHERE Plant='$plant' AND 
                                                                         UnitCode='$unitcode' AND
                                                                         PlanningNumber='$value[0]' AND
                                                                         Years='$value[1]' AND
                                                                         ProductID='$value[2]' AND
                                                                         BatchNumber='$value[3]' AND
                                                                         NoProses='$value[4]' AND
                                                                         StatsUpdate=''
                                                                         ORDER BY CreatedOn ASC");
    if (mysqli_num_rows($sql) <> 0) {
        $row = mysqli_fetch_array($sql);
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
    }
} else if ($value[5] == 1) {
    $sql = mysqli_query($conn, "SELECT * FROM qc_result WHERE Plant='$plant' AND 
                                                                         UnitCode='$unitcode' AND
                                                                         PlanningNumber='$value[0]' AND
                                                                         Years='$value[1]' AND
                                                                        --  ProductID='$value[2]' AND
                                                                        --  BatchNumber='$value[3]' AND
                                                                        Types='Pengolahan' AND
                                                                         NoProses='$value[4]' AND
                                                                         StatsUpdate=''
                                                                         ORDER BY CreatedOn ASC");
    if (mysqli_num_rows($sql) <> 0) {
        $r = mysqli_fetch_array($sql);
        $namaqc = $r['CreatedFor'];
        $pernr = Getpernr($r['CreatedBy']);
        $desc = Getdata('ProductDescriptions', 'mara_product', 'ProductID', $value[2]);
        $suhu = $r['Suhu'];
    }
} else if ($value[5] == 2) {

    $sql = mysqli_query($conn, "SELECT * FROM usage_decision WHERE Plant='$plant' AND 
                                                                         UnitCode='$unitcode' AND
                                                                         InspectionLot ='$value[6]' AND
                                                                         Lotyears ='$value[7]' AND
                                                                        --  ProductID='$value[2]' AND
                                                                        --  BatchNumber='$value[3]' AND
                                                                        -- NoProses ='Pengolahan' AND
                                                                         NoProses='$value[4]' AND
                                                                         StatsUpdate=''");
    if (mysqli_num_rows($sql) <> 0) {
        $r = mysqli_fetch_array($sql);
        $createdon = $r['CreatedOn'];
        $namaqc = Getpernr($r['CreatedBy']);
        $udcode = $r['UDcode'];
        $uddesc = GetdataII('Descriptions', 'qc_catalog', 'KodeCatalog', $udcode, 'Item', 0);
    }
} elseif ($value[5] == 3) {
    $query = mysqli_query($conn, "SELECT * FROM result_recording WHERE Plant='$plant' AND UnitCode='$unitcode' AND InspectionLot='$value[6]' AND Lotyears='$value[7]'");
    if (mysqli_num_rows($query) <> 0) {
        $r = mysqli_fetch_array($query);
        $namaqc = Getpernr($r['CreatedBy']);
    }
} ?>
<div class="container">
    <div class="card mb-3">
        <div class="border-0 mb-0 p-3 mt-3">
            <div class="form-group row mb-0">
                <label for="noproseschangepersiapanpengolahan" class="col-sm-2 col-form-label">No Proses</label>
                <div class="col-sm-1">
                    <input type="text" id="noproseschangepersiapanpengolahan" class="form-control form-control-sm" value="<?= $value[4] ?> " readonly>
                </div>
            </div>
            <div class="form-group row mb-0">
                <label for="setplanningnumberchangepersiapanpengolahan" class="col-sm-2 col-form-label">Planning Number</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm" id="setplanningnumberchangepersiapanpengolahan" value="<?= $value[0] ?>" readonly>
                </div>
                <?php
                if ($value[5] == 0) { ?>
                    <label for="personalnumberemployee" class="col-sm-2 offset-3 col-form-label">Operator 1</label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" aria-label="Recipient's username" aria-describedby="button-addon2" id="operator1changepersiapanpengolahan" value="<?= $row['Operator1'] ?>">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchoperator1changepersiapanpengolahan"><span><img src="../asset/icon/cari.png"></span></button>
                        </div>
                    </div>
                <?php
                } ?>
                <?php
                if ($value[5] == 1 || $value[5] == 3) { ?>
                    <label for="personalnumberemployee" class="col-sm-2 offset-3 col-form-label">Nama Qc</label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" aria-label="Recipient's username" aria-describedby="button-addon2" id="qcnamechangepersiapanpengolahan" value="<?= $namaqc . ' - ' . Getnamakaryawan2($namaqc)  ?>" readonly>
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchqcnamechangepersiapanpengolahan"><span><img src="../asset/icon/cari.png"></span></button>
                        </div>
                    </div>
                <?php
                } ?>
            </div>
            <div class="form-group row mb-0">
                <label for="yearschangepersiapanpengolahan" class="col-sm-2 col-form-label">Planning Years</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm" id="yearschangepersiapanpengolahan" value="<?= $value[1] ?>" readonly>
                </div>
                <?php
                if ($value[5] == 0) { ?>
                    <label for="personalnumberemployee" class="col-sm-2 offset-3 col-form-label">Operator 2</label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" aria-label="Recipient's username" aria-describedby="button-addon2" id="operator2changepersiapanpengolahan" value="<?= $row['Operator2'] ?>">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchoperator2changepersiapanpengolahan"><span><img src="../asset/icon/cari.png"></span></button>
                        </div>
                    </div>
                <?php
                } ?>
                <?php
                if ($value[5] == 3) { ?>
                    <label for="personalnumberemployee" class="col-sm-2 offset-3 col-form-label">Insp. Lot</label>
                    <div class="col-sm-2 offset-1">
                        <input type="text" class="form-control form-control-sm" id="inspyearschangepersiapanpengolahan" value="<?= $value[6] ?>" readonly>
                    </div>
                <?php
                } ?>
            </div>
            <div class="form-group row mb-0">
                <label for="productidchangepersiapanpengolahan" class="col-sm-2 col-form-label">Product ID</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm" id="productidchangepersiapanpengolahan" value="<?= $value[2] ?>" readonly>
                </div>
                <?php
                if ($value[5] == 0) { ?>
                    <label for="personalnumberemployee" class="col-sm-2 offset-3 col-form-label">Operator 3</label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" aria-label="Recipient's username" aria-describedby="button-addon2" id="operator3changepersiapanpengolahan" value="<?= $row['Operator3'] ?>">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchoperator3changepersiapanpengolahan"><span><img src="../asset/icon/cari.png"></span></button>
                        </div>
                    </div>
                <?php
                } ?>
                <?php
                if ($value[5] == 3) { ?>
                    <label for="personalnumberemployee" class="col-sm-2 offset-3 col-form-label">Insp. Years</label>
                    <div class="col-sm-2 offset-1">
                        <input type="text" class="form-control form-control-sm" id="lotyearschangepersiapanpengolahan" value="<?= $value[7] ?>" readonly>
                    </div>
                <?php
                } ?>
            </div>
            <div class="form-group row mb-3">
                <label for="batchnumberchangepersiapanpengolahan" class="col-sm-2 col-form-label">Batch Number</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm" id="batchnumberchangepersiapanpengolahan" value="<?= $value[3] ?>" readonly>
                </div>
                <?php
                if ($value[5] == 0) { ?>
                    <label for="pengawasproduksipersiapanpengolahan" class="col-sm-2 offset-3 col-form-label">Pengawas Produksi</label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" aria-label="Recipient's username" aria-describedby="button-addon2" id="pengawasproduksichangepersiapanpengolahan" value="<?= $row['PengawasProduksi'] ?>">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchpengawasproduksichangepersiapanpengolahan"><span><img src="../asset/icon/cari.png"></span></button>
                        </div>
                    </div>
                <?php
                } ?>
            </div>
            <hr>
            <?php
            if ($value[5] == 0) { ?>
                <div class="form-group row mb-0">
                    <h6 class="fw-bold">Input Parameter</h6>
                </div>
                <div class="form-group row mb-0">
                    <label for="parameter1changepersiapanpengolahan" class="col-sm-8 col-form-label">1. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 1) ?></label>
                    <div class="col-sm-4">
                        <select class="form-select form-select-sm" id="parameter1changepersiapanpengolahan">
                            <option value="<?= $param1 ?>" selected><?= $param1 ?></option>
                            <?php
                            $sql = mysqli_query($conn, "SELECT Descriptions FROM qc_catalog WHERE KodeCatalog='CTLG01' AND Descriptions <> '$param1'");
                            while ($r = mysqli_fetch_array($sql)) { ?>
                                <option value="<?= $r['Descriptions'] ?>"><?= $r['Descriptions'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
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
                        <select class="form-select form-select-sm" id="parameter3changepersiapanpengolahan">
                            <option value="<?= $param3 ?>" selected><?= $param3 ?></option>
                            <?php
                            $sql = mysqli_query($conn, "SELECT Descriptions FROM qc_catalog WHERE KodeCatalog='CTLG02' AND Descriptions <> '$param3'");
                            while ($r = mysqli_fetch_array($sql)) { ?>
                                <option value="<?= $r['Descriptions'] ?>"><?= $r['Descriptions'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="parameter4changepersiapanpengolahan" class="col-sm-8 col-form-label">4. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 4) ?></label>
                    <div class="col-sm-4">
                        <select class="form-select form-select-sm" id="parameter4changepersiapanpengolahan">
                            <option value="<?= $param4 ?>" selected><?= $param4 ?></option>
                            <?php
                            $sql = mysqli_query($conn, "SELECT Descriptions FROM qc_catalog WHERE KodeCatalog='CTLG02' AND Descriptions <> '$param4'");
                            while ($r = mysqli_fetch_array($sql)) { ?>
                                <option value="<?= $r['Descriptions'] ?>"><?= $r['Descriptions'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="parameter5changepersiapanpengolahan" class="col-sm-8 col-form-label">5. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 5) ?></label>
                    <div class="col-sm-4">
                        <select class="form-select form-select-sm" id="parameter5changepersiapanpengolahan">
                            <option value="<?= $param5 ?>" selected><?= $param5 ?></option>
                            <?php
                            $sql = mysqli_query($conn, "SELECT Descriptions FROM qc_catalog WHERE KodeCatalog='CTLG02' AND Descriptions <> '$param5'");
                            while ($r = mysqli_fetch_array($sql)) { ?>
                                <option value="<?= $r['Descriptions'] ?>"><?= $r['Descriptions'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="parameter6changepersiapanpengolahan" class="col-sm-8 col-form-label">6. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 6) ?></label>
                    <div class="col-sm-4">
                        <select class="form-select form-select-sm" id="parameter6changepersiapanpengolahan">
                            <option value="<?= $param6 ?>" selected><?= $param6 ?></option>
                            <?php
                            $sql = mysqli_query($conn, "SELECT Descriptions FROM qc_catalog WHERE KodeCatalog='CTLG03' AND Descriptions <> '$param6'");
                            while ($r = mysqli_fetch_array($sql)) { ?>
                                <option value="<?= $r['Descriptions'] ?>"><?= $r['Descriptions'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="parameter7changepersiapanpengolahan" class="col-sm-8 col-form-label">7. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 7) ?></label>
                    <div class="col-sm-4">
                        <select class="form-select form-select-sm" id="parameter7changepersiapanpengolahan">
                            <option value="<?= $param7 ?>" selected><?= $param7 ?></option>
                            <?php
                            $sql = mysqli_query($conn, "SELECT Descriptions FROM qc_catalog WHERE KodeCatalog='CTLG03' AND Descriptions <> '$param7'");
                            while ($r = mysqli_fetch_array($sql)) { ?>
                                <option value="<?= $r['Descriptions'] ?>"><?= $r['Descriptions'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="parameter8changepersiapanpengolahan" class="col-sm-8 col-form-label">8. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 8) ?></label>
                    <div class="col-sm-4">
                        <select class="form-select form-select-sm" id="parameter8changepersiapanpengolahan">
                            <option value="<?= $param8 ?>" selected><?= $param8 ?></option>
                            <?php
                            $sql = mysqli_query($conn, "SELECT Descriptions FROM qc_catalog WHERE KodeCatalog='CTLG04' AND Descriptions <> '$param8'");
                            while ($r = mysqli_fetch_array($sql)) { ?>
                                <option value="<?= $r['Descriptions'] ?>"><?= $r['Descriptions'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="parameter9changepersiapanpengolahan" class="col-sm-8 col-form-label">9. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 9) ?></label>
                    <div class="col-sm-4">
                        <select class="form-select form-select-sm" id="parameter9changepersiapanpengolahan">
                            <option value="<?= $param9 ?>" selected><?= $param9 ?></option>
                            <?php
                            $sql = mysqli_query($conn, "SELECT Descriptions FROM qc_catalog WHERE KodeCatalog='CTLG04' AND Descriptions <> '$param9'");
                            while ($r = mysqli_fetch_array($sql)) { ?>
                                <option value="<?= $r['Descriptions'] ?>"><?= $r['Descriptions'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="parameter10changepersiapanpengolahan" class="col-sm-8 col-form-label">10. <?= showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 10) ?></label>
                    <div class="col-sm-4">
                        <select class="form-select form-select-sm" id="parameter10changepersiapanpengolahan">
                            <option value="<?= $param10 ?>" selected><?= $param10 ?></option>
                            <?php
                            $sql = mysqli_query($conn, "SELECT Descriptions FROM qc_catalog WHERE KodeCatalog='CTLG04' AND Descriptions <> '$param10'");
                            while ($r = mysqli_fetch_array($sql)) { ?>
                                <option value="<?= $r['Descriptions'] ?>"><?= $r['Descriptions'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 text-end">
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="updatechangepersiapanpengolahan()"><img src="../asset/icon/save.png"> Save</button>
                    </div>
                </div>
        </div>
    <?php
            } else if ($value[5] == 1) {
    ?>
        <div class="border-0 mb-0 p-3 mt-3">
            <div class="form-group row mb-0">
                <h6 class="fw-bold">Record Result RH & Suhu</h6>
            </div>
            <div class="form-group row mb-1 ms-3">
                <table id="drhsuhu" class="table table-sm" style=" width: 50%;">
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
                            <td><input type="text" class="form-control form-control-sm border-0 bg-transparent text-start" value="<?= Getdata('Nilai', 'qc_characteristic', 'KodeProses', 'P001') ?>" readonly></td>
                            <td> °C</td>
                            <td><input type="number" class="form-control form-control-sm" id="suhu_persiapanpengolahanchangepengolahan" value="<?= $suhu ?>"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="form-group row">
                <div class="col-sm-3 mt-3 ">
                    <button type="button" id="simpanqcresulthoper" class="btn btn-outline-success btn-sm" onclick="updatechangeqcresultdatapengolahan()"><img src="../asset/icon/save.png"> Save</button>
                </div>
            </div>
        </div>
    </div>
<?php
            } else if ($value[5] == 2) {
?>
    <div class="border-0 mb-0 p-3 mt-3">
        <div class="form-group row mb-0">
            <h6 class="fw-bold">Record Usage Decision</h6>
        </div>
        <div class="form-group row mb-1 ms-3">
            <table id="drhsuhu" class="table table-sm" style=" width: 50%;">
                <thead class="fw-bold bg-secondary text-white">
                    <tr>
                        <td style="width: 20%;">UD Code</td>
                        <td>Descriptions</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><select name="" id="" class="form-select form-select-sm" onchange="updatechangeudcodedatapengolahan(this.value)">
                                <option value="<?= $udcode ?>" selected><?= $udcode ?></option>
                                <?php
                                $sql = mysqli_query($conn, "SELECT KodeCatalog FROM qc_catalog WHERE Item=0 AND KodeCatalog !='$udcode'");
                                if (mysqli_num_rows($sql) <> 0) {
                                    while ($r = mysqli_fetch_array($sql)) { ?>
                                        <option value="<?= $r['KodeCatalog'] ?>"><?= $r['KodeCatalog'] ?></option>
                                <?php }
                                } ?>
                            </select></td>
                        <td><input type="text" class="form-control form-control-sm border-0 bg-transparent" value="<?= $uddesc ?>" id="udcodedescriptiondatapengolahan" readonly></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="form-group row">
            <div class="col-sm-3 mt-3 ">
                <button type="button" id="simpanqcresulthoper" class="btn btn-outline-success btn-sm" onclick="updatechangeqcresultdatapengolahan()"><img src="../asset/icon/save.png"> Save</button>
            </div>
        </div>
    </div>
</div>
<?php
            } elseif ($value[5] == 3) { ?>
    <table id="drhsuhu" class="table table-sm w-100">
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
                                                                                InspectionLot ='$value[6]' AND
                                                                                Lotyears ='$value[7]' AND
                                                                                NoProses='$value[4]'
                                                                                AND StatsUpdate=''");
                if (mysqli_num_rows($query) <> 0) {
                    while ($r = mysqli_fetch_array($query)) {
                        $result_awal = '';
                        $result_tengah = '';
                        $result_akhir = '';
                        $sql = mysqli_query($conn, "SELECT Descriptions,Qual,Quan,FullyDesc FROM master_inspection WHERE Plant='$plant' AND 
                                                                                                        UnitCode='$unitcode' AND 
                                                                                                        MIC ='$r[MIC]'");
                        $q = mysqli_fetch_array($sql); ?>
                    <tr>
                        <td class="text-center"><?= $i ?></td>
                        <td class="text-center">
                            <input class="form-control form-control-sm  border-0 bg-transparent" type="text" id="MICupdateorganoleptis<?= $i ?>" value="<?= $r['MIC'] ?>" readonly>
                        </td>
                        <td>
                            <label class="text-decoration-underline"><?= $r['Descriptions'] ?></label>
                            <br>
                            <?= $r['FullyDesc'] ?>
                        </td>
                        <?php
                        if ($q['Quan'] == 'X') { ?>
                            <td class="text-center">
                                <input class="form-control form-control-sm" type="text" id="result_awalupdateorganoleptis<?= $i ?>" value="<?= $r['Result_Awal'] ?>">
                            </td>
                            <td class="text-center">
                                <input class="form-control form-control-sm" type="text" id="result_tengahupdateorganoleptis<?= $i ?>" value="<?= $r['Result_Tengah'] ?>">
                            </td>
                            <td class="text-center">
                                <input class="form-control form-control-sm" type="text" id="result_akhirupdateorganoleptis<?= $i ?>" value="<?= $r['Result_Akhir'] ?>">
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
                                    <input class="form-check-input" type="checkbox" id="result_awalupdateorganoleptis<?= $i ?>" <?= str_replace("'", "", $result_awal) ?>>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="result_tengahupdateorganoleptis<?= $i ?>" <?= str_replace("'", "", $result_tengah) ?>>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="result_akhirupdateorganoleptis<?= $i ?>" <?= str_replace("'", "", $result_akhir) ?>>
                                </div>
                            </td>
                        <?php }
                        ?>
                        <td class="text-center"><input type="text" class="form-control form-control-sm" id="keteranganhasiltolakupdateorganoleptis<?= $i ?>" value="<?= $r['Ket_hasiltolak'] ?>"></td>
                    </tr>

            <?php
                        $i += 1;
                    }
                }
            ?>
            <!-- <input type="text" id="lenght_updateorganoleptis" value="<?= $i ?>"> -->
        </tbody>
    </table>
    <div class="form-group row">
        <div class="col-sm-12 text-end">
            <button type="button" id="simpanqcorganoleptis" class="btn btn-outline-success btn-sm" onclick="updateorganoleptis()" <?= $hiden ?>><img src="../asset/icon/save.png"> Save</button>
        </div>
    </div>
<?php }
?>
</div>
<div class="container">
    <section>
        <?php
        $sql = mysqli_query($conn, "SELECT * FROM mapping_reviewer WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                    AND FormReviewer ='other_request' AND Pernr !='90003560'"); ?>
        <table class="table table-sm mt-3 w-50">
            <thead class="bg-dark text-white">
                <tr>
                    <td style="width: 5%;">No</td>
                    <td style="width: 30%;">Approval</td>
                    <td>Jabatan</td>
                </tr>
            </thead>
            <?php if (mysqli_num_rows($sql) != 0) { ?>
                <tbody>
                    <?php
                    $l = 0;
                    while ($r = mysqli_fetch_array($sql)) { ?>
                        <tr>
                            <td><input type="checkbox" disabled id="reviewer<?= $l ?>" class="form-check-input" checked> <?= $r['Levels'] ?><input type="text" class="form-control form-control-sm" id="levelscreateplanningpengolahan<?= $l ?>" value="<?= $r['Levels'] ?>" hidden></td>
                            <td><?= $r['Pernr'] . ' - ' . Getnamakaryawan2($r['Pernr']) ?></td>
                            <td><?= getpositionbypernr($r['Pernr']) ?></td>
                        </tr>
                    <?php
                        $l += 1;
                    } ?>
                </tbody>
            <?php  } ?>
        </table>
    </section>
</div>

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

<!-- QC Name-->
<div class="modal fade" id="searchqcnamechangepersiapanpengolahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="$('#qcnamechangepersiapanpengolahan').val('<?= $row['PersonnelNumber'] . ' - ' . $row['EmployeeName'] ?>'),$('#searchqcnamechangepersiapanpengolahan').modal('hide')">Select</a>
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