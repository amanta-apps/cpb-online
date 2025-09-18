<?php
$satuan = GetdataIII('Satuan', 'mapping_timbangan', 'Plant', $_SESSION['plant'], 'UnitCode', $_SESSION['unitcode'], 'AddressOf', $_SESSION['ip']);
if ($satuan == '') {
    $satuan = 'kg';
}
?>
<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/scale2.png"> Timbang Bahan</h6>
    <hr class="w-50 mb-3">
    <div class="row mb-5">
        <div class="col-sm-2">
            <div class="form-group row mb-4" id="chart_div"></div>
        </div>
        <div class="col-sm-4">
            <div class="form-group row mb-4">
                <div class="col-sm-12">
                    <!-- <textarea class="form-control fw-bold bg-transparent border-0 text-center" style="font-size: 40pt; vertical-align: middle !important;" id="bebandatatimbangan" readonly>0KG</textarea> -->
                    <div class="form-floating">
                        <textarea class="form-control fw-bold bg-transparent border-0 text-center align-middle" style="font-size: 40pt;" placeholder="Leave a comment here" id="bebandatatimbangan" style="height: 100px" readonly>0<?= $satuan ?></textarea>
                        <label for="floatingTextarea2">Berat <sup>Kg</sup></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group row mb-0">
                <label for="personalnumberenginesetapproval" class="col-sm-3 col-form-label">Nama Timbangan</label>
                <div class="col-sm-9">
                    <div class="input-group mb-1">
                        <input type="text" class="form-control form-control-sm bg-transparent" placeholder="Pilih Timbangan" aria-label="Recipient's username" aria-describedby="button-addon2" id="namatimbangandatatimbangan" value="<?= $_SESSION['namtim'] ?>" readonly>
                        <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchnamatimbangandatatimbanganbahan"><span><img src="../asset/icon/cari.png"></span></button>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-0">
                <label for="ipaddressdatatimbangan" class="col-sm-3 col-form-label">IP Address</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm bg-transparent" id="ipaddressdatatimbangan" placeholder="19x.xxx.xxx.xxx" value="<?= $_SESSION['ip'] ?>" readonly>
                </div>
            </div>
            <div class="form-group row mb-0">
                <label for="portdatatimbangan" class="col-sm-3 col-form-label">Port</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm bg-transparent" id="portdatatimbangan" placeholder="xxxx" value="<?= $_SESSION['port'] ?>" readonly>
                </div>
            </div>
            <div class="form-group row mb-0">
                <!-- <label for="yearsreviewquality" class="col-sm-3 col-form-label">Config</label> -->
                <div class="col-sm-9 offset-3">
                    <input class="form-check-input" type="checkbox" id="autoprintdatatimbangan" disabled>
                    <label class="form-check-label" for="flexCheckDefault">
                        Auto Print
                    </label>
                    <input class="form-check-input" type="checkbox" id="autosavedatatimbangan" disabled>
                    <label class="form-check-label" for="flexCheckDefault">
                        Auto Save
                    </label>
                    <input class="form-check-input" type="checkbox" id="grossgetweightdatatimbangan" disabled hidden>
                    <label class="form-check-label" for="flexCheckDefault" id="getweightdatatimbangangross" hidden>
                        Gross
                    </label>
                    <input class="form-check-input" type="checkbox" id="taregetweightdatatimbangan" disabled hidden>
                    <label class="form-check-label" for="flexCheckDefault" id="getweightdatatimbangantare" hidden>
                        Tare
                    </label>
                    <input class="form-check-input" type="checkbox" id="netgetweightdatatimbangan" disabled hidden>
                    <label class="form-check-label" for="flexCheckDefault" id="getweightdatatimbangannet" hidden>
                        Net
                    </label>
                    &nbsp;---||---&nbsp;
                    <input class="form-check-input" type="checkbox" id="stopdatatimbangan" onchange="stopedtimbanganchange(this.checked)" disabled hidden>
                    <label class="form-check-label" for="stopdatatimbangan" hidden>
                        Stop
                    </label>
                    <button type="button" class="btn btn-sm" id="configtimbangbahan" onclick="setconfigdatatimbangan()" disabled>
                        <img src="../asset/icon/setting.png" alt="Setting"> Config
                    </button>
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-sm-9 offset-3">
                    <button type="button" class="btn btn-sm btn-outline-success" onclick="cekkoneksitimbangan()">
                        <img src="../asset/icon/connect.png">
                        <a id="koneksitimbangbahan">Connect</a>
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" id="koneksitimbangbahan" onclick="getadditionaldata()">
                        <img src="../asset/icon/info.png"> Add. Data
                    </button>
                    <button type="button" class="btn btn-sm btn-primary" id="ambildatatimbangan" onclick="getdatatimbangan()" hidden>
                        <img src="../asset/icon/scale.png"> Ambil Data
                    </button>
                    <button type="button" class="btn btn-sm btn-success" id="simpandatatimbang" onclick="simpandatatimbangan()" hidden>
                        <img src="../asset/icon/save.png"> Simpan
                    </button>
                    <button type="button" class="btn btn-sm burder-0 bg-transparent">
                        <a id="textcountdowndatatimbang" style="font-size: 14pt; font-weight: bold;color:red">Not Ready</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row mb-0" id="cardcolor">
        <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link btn-sm text-dark fw-bold active" id="pills-now-tab" data-bs-toggle="pill" data-bs-target="#pills-now" type="button" role="tab" aria-controls="pills-now" aria-selected="true">Basic Data</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-now" role="tabpanel" aria-labelledby="pills-now-tab">
                <div id="getlisttimbangan">
                    <table id="mytables" class="table table-sm" style="width:100%;">
                        <thead class="bg-dark text-white fw-bold">
                            <tr>
                                <th class="text-center align-middle" rowspan="2">#</th>
                                <!-- <th style="text-align: center !important;">Item</th> -->
                                <th class="align-middle" rowspan="2">Produk</th>
                                <th class="align-middle" style="width: 30%;" rowspan="2">Descriptions</th>
                                <th class="align-middle" rowspan="2">Bets</th>
                                <th class="align-middle" rowspan="2">Expired Date</th>
                                <th colspan="2" class="align-middle text-center">Number</th>
                                <th class="align-middle" rowspan="2">Berat<br>(Kg)</th>
                                <!-- <th class="align-middle" rowspan="2">Created On</th> -->
                                <th class="align-middle text-center" rowspan="2">Print</th>
                            </tr>
                            <tr>
                                <th style="text-align: center !important;">Proses</th>
                                <th style="text-align: center !important;">Tong</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $plant = $_SESSION['plant'];
                            $unitcode = $_SESSION['unitcode'];
                            $ip = $_SESSION['ip'];
                            $namtim = $_SESSION['namtim'];
                            $port = $_SESSION['port'];
                            $userid = $_SESSION['userid'];
                            if ($namtim !== null && $ip !== null && $port !== null) {

                                $sql = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_header WHERE Plant='$plant' AND
                                                                                                        UnitCode='$unitcode' AND
                                                                                                        AddressOf ='$ip' AND
                                                                                                        UsedBy='$userid' AND
                                                                                                        StatsX is null");
                                if (mysqli_num_rows($sql) != 0) {
                                    $row = mysqli_fetch_array($sql);

                                    $sql = mysqli_query($conn, "SELECT * FROM tb_prosestimbang_mapping WHERE Plant='$plant' AND
                                                                                                            UnitCode='$unitcode' AND
                                                                                                            PlanningNumber ='$row[PlanningNumber]' AND
                                                                                                            ProductID='$row[ProductID]' AND
                                                                                                            UsedBy ='$row[UsedBy]'");
                                    $r = mysqli_fetch_array($sql);
                                    $i = 1;
                                    $sql = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND
                                                                                                            UnitCode='$unitcode' AND
                                                                                                            PlanningNumber='$r[PlanningNumber]' AND
                                                                                                            Years='$r[Years]' AND
                                                                                                            ProductID='$r[ProductID]' AND
                                                                                                            UsedBy='$r[UsedBy]' AND
                                                                                                            BatchNumber='$r[BatchNumber]' AND
                                                                                                            Berat > 0");
                                    while ($row = mysqli_fetch_array($sql)) {
                            ?>
                                        <tr>
                                            <td><a href="#" class="badge bg-white text-dark href_transform" onclick="deletedatatimbang('<?= $row['PlanningNumber'] ?>',
                                                                                                                                        '<?= $row['Years'] ?>',
                                                                                                                                        '<?= $row['Items'] ?>',
                                                                                                                                        '<?= $row['ProductID'] ?>',
                                                                                                                                        '<?= $row['BatchNumber'] ?>',
                                                                                                                                        '<?= $row['NoProses'] ?>',
                                                                                                                                        '<?= $row['NoTong'] ?>')"><img src="../asset/img/delete.png"><?= $i ?></a></td>
                                            <!-- <td><?= $row['Items'] ?></td> -->
                                            <td><?= $row['ProductID'] ?></td>
                                            <td style="width: 50%;"><?= Getdata('ProductDescriptions', 'mara_product', 'ProductID', $row['ProductID']) ?></td>
                                            <td><?= $row['BatchNumber'] ?></td>
                                            <td><?= GetdataII('ExpiredDate', 'planning_pengolahan_detail', 'ProductID', $row['ProductID'], 'Items', $row['Items']) ?></td>
                                            <td><?= $row['NoProses'] ?></td>
                                            <td><?= $row['NoTong'] ?></td>
                                            <td><?= $row['Berat'] ?> <?= $row['Satuan'] ?></td>
                                            <!-- <td><?= $row['CreatedOn'] ?></td> -->
                                            <td><a href="#" class="badge bg-white text-dark zoom text-decoration-none" onclick="printdatatimbang('<?= $row['PlanningNumber'] ?>',
                                                                                                                                        '<?= $row['Years'] ?>',
                                                                                                                                        '<?= $row['Items'] ?>',
                                                                                                                                        '<?= $row['ProductID'] ?>',
                                                                                                                                        '<?= $row['BatchNumber'] ?>',
                                                                                                                                        '<?= $row['NoProses'] ?>',
                                                                                                                                        '<?= $row['NoTong'] ?>',
                                                                                                                                        '<?= $row['Berat'] ?>')"><img src="../asset/icon/print.png">Print</a>
                                                <a href="#" class="badge bg-white text-dark zoom text-decoration-none" onclick="previewdatatimbang('<?= $row['PlanningNumber'] ?>',
                                                                                                                                        '<?= $row['Years'] ?>',
                                                                                                                                        '<?= $row['Items'] ?>',
                                                                                                                                        '<?= $row['ProductID'] ?>',
                                                                                                                                        '<?= $row['BatchNumber'] ?>',
                                                                                                                                        '<?= $row['NoProses'] ?>',
                                                                                                                                        '<?= $row['NoTong'] ?>',
                                                                                                                                        '<?= $row['Berat'] ?>')"><img src="../asset/icon/preview.png">Preview</a>
                                            </td>
                                        </tr>
                            <?php
                                        $i += 1;
                                    }
                                }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- List Timbangan -->
<div class="modal fade" id="searchnamatimbangandatatimbanganbahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">List Timbangan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="ddisplayplanning" class="table table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>#</th>
                            <th>Nama Timbangan</th>
                            <th>Lokasi</th>
                            <th>IP Address</th>
                            <th>Port</th>
                            <th>Status</th>
                            <th>Unlock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $plant = $_SESSION['plant'];
                        $unitcode = $_SESSION['unitcode'];
                        $sql = mysqli_query($conn, "SELECT * FROM mapping_timbangan WHERE Plant='$plant' AND 
                                                                                            UnitCode='$unitcode'");
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td><button type="button" class="bg-transparent border-0 href_transform" onclick="prosesselectlisttimbangan(' <?= $row['AddressOf'] ?>')"><img src="../asset/icon/finger.png">pilih</button></td>
                                <td><?= $row['NamaTimbangan'] ?></td>
                                <td><?= $row['DetailLokasi'] ?></td>
                                <td><?= $row['AddressOf'] ?></td>
                                <td><?= $row['PortOf'] ?></td>
                                <?php
                                if ($row['StatsX'] == 'X') { ?>
                                    <td><a href="#" class="badge bg-danger text-decoration-none">Sedang digunakan <?= $row['UsedBy'] ?></a></td>
                                <?php } else { ?>
                                    <td><a href="#" class="badge bg-success text-decoration-none">Tidak digunakan</a></td>
                                <?php  } ?>
                                <td><button type="button" class="bg-transparent border-0 href_transform" onclick="prosesunlocklisttimbangan(' <?= $row['AddressOf'] ?>')"><img src="../asset/icon/unlock.png"></button></td>
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

<!-- List Planning Number -->
<div class="modal fade" id="listplanningnumbertimbangbahan" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalToggleLabel2">Planning Header List</h6>
                <button class="btn btn-outline-dark" data-bs-target="#searchadditionaldatadatatimbanganbahan" data-bs-toggle="modal" data-bs-dismiss="modal">Back</button>
            </div>
            <div class="modal-body">
                <table id="dproduct0" class="table table-striped table-sm" style="width:100%">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>#</th>
                            <th>Planning Number</th>
                            <th>Years</th>
                            <th>Resource</th>
                            <th>Produk</th>
                            <th>Created On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $plant = $_SESSION['plant'];
                        $unitcode = $_SESSION['unitcode'];
                        $usedby = $_SESSION['usedby'];
                        // // $sql = mysqli_query($conn,"")
                        // $sql = mysqli_query($conn, "SELECT * FROM planning_pengolahan_header WHERE Plant='$plant' AND UnitCode='$unitcode' 
                        //                                                                                         AND (UsedBy is null or UsedBy='')
                        //                                                                                         AND (StatsX !='X' or StatsX is null) ORDER BY Items ASC");
                        $sql = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_header WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                                                -- AND PlanningNumber='2000000091' 
                                                                                                                AND (UsedBy is null or UsedBy='')
                                                                                                                AND (StatsX !='X' or StatsX is null) ORDER BY Items ASC");
                        // echo mysqli_num_rows($sql);
                        while ($row = mysqli_fetch_array($sql)) {
                            $query = mysqli_query($conn, "SELECT * FROM planning_pengolahan_header WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                                                        AND PlanningNumber='$row[PlanningNumber]'
                                                                                                                        AND Years='$row[Years]'
                                                                                                                        AND Approval='X'
                                                                                                                        AND Del is null");
                            if (mysqli_num_rows($query) == 0) {
                                continue;
                            }
                            $query2 = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_header WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                                                        AND PlanningNumber='$row[PlanningNumber]'
                                                                                                                        AND Years='$row[Years]'
                                                                                                                        AND StatsX is null");
                            if (mysqli_num_rows($query2) == 0) {
                                continue;
                            }

                            $query3 = mysqli_query($conn, "SELECT * FROM planning_pengolahan_subdetail WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                                                        AND PlanningNumber='$row[PlanningNumber]'
                                                                                                                        AND Years='$row[Years]'
                                                                                                                        AND Stats04='X'");
                            if (mysqli_num_rows($query3) == 0) {
                                continue;
                            }
                            $prod_desc = Getdata('ProductDescriptions', 'mara_product', 'ProductID', $row['ProductID']);
                        ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none href_transform" onclick="selectgetproductid('<?= $row['PlanningNumber'] ?>','<?= $row['ProductID'] ?>','<?= $row['Years'] ?>','<?= $row['Items'] ?>')" data-bs-target="#searchadditionaldatadatatimbanganbahan" data-bs-toggle="modal" data-bs-dismiss="modal"> Select</a>
                                </td>
                                <td><?= $row['PlanningNumber'] ?></td>
                                <td><?= $row['Years'] ?></td>
                                <td><?= $row['ResourceIDMix'] ?></td>
                                <td><?= $row['ProductID'] ?></td>
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
<!-- End List Produk -->
<!-- Operator 1-->
<div class="modal fade" id="searchoperatordatatimbangan1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">List Operator</h6>
                <button class="btn btn-outline-dark" data-bs-target="#searchadditionaldatadatatimbanganbahan" data-bs-toggle="modal" data-bs-dismiss="modal">Back</button>
            </div>
            <div class="modal-body">
                <table id="mytable_operator1" class="table table-striped table-sm" style="width:100%;">
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
                        $sql = mysqli_query($conn, "SELECT * FROM pa001 WHERE PersonnelNumber != '90003560'");
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="$('#operator1datatimbangan').val(<?= $row['PersonnelNumber'] ?>),$('#searchoperatordatatimbangan1').modal('hide'),$('#searchadditionaldatadatatimbanganbahan').modal('show')">Select</a>
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
<!-- Operator 1-->
<div class="modal fade" id="searchoperatordatatimbangan2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">List Operator</h6>
                <button class="btn btn-outline-dark" data-bs-target="#searchadditionaldatadatatimbanganbahan" data-bs-toggle="modal" data-bs-dismiss="modal">Back</button>
            </div>
            <div class="modal-body">
                <table id="mytable_operator2" class="table table-striped table-sm" style="width:100%;">
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
                        $sql = mysqli_query($conn, "SELECT * FROM pa001 WHERE PersonnelNumber != '90003560'");
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="$('#operator2datatimbangan').val(<?= $row['PersonnelNumber'] ?>),$('#searchoperatordatatimbangan2').modal('hide'),$('#searchadditionaldatadatatimbanganbahan').modal('show')">Select</a>
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
<!-- Config Data -->
<div class="modal fade" id="searchconfigdatatimbanganbahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Config</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="form-group mb-0">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="autoprintmodaltimbangbahan" disabled>
                            <label class="form-check-label" for="approvalplanninggconfiguration">
                                Auto Print
                            </label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="autosavemodaltimbangbahan" disabled>
                            <label class="form-check-label" for="approvalplanninggconfiguration">
                                Auto Save
                            </label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="autotimbangmodaltimbangbahan" disabled>
                            <label class="form-check-label" for="approvalplanninggconfiguration">
                                Auto Timbang
                            </label>
                        </div>
                        <hr>
                        <p class="fw-bold">Jenis Berat</p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="grossmodaltimbangbahan">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Gross
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="netmodaltimbangbahan">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Net
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="taremodaltimbangbahan">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Tare
                            </label>
                        </div>
                        <hr>
                        <p class="fw-bold">Satuan</p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="satuan" id="satuankgmodaltimbangbahan" checked>
                            <label class="form-check-label" for="satuanmodaltimbangbahan">
                                Kg
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="satuan" id="satuangrammodaltimbangbahan" disabled>
                            <label class="form-check-label" for="satuanmodaltimbangbahan">
                                Gram
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-success mt-2" id="simpanmodaltimbangbahan" onclick="simpanmodaltimbangbahan()">
                    <img src="../asset/icon/save.png"> Simpan
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End -->

<div class="modal fade" id="searchadditionaldatadatatimbanganbahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Additional Data</h6>
                <button type="button" class="btn btn-sm btn-dark href_transform" data-bs-dismiss="modal" aria-label="Close" data-refresh="true"><img src="../asset/icon/back.png"> Back</button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="form-group row mb-0">
                        <label for="planningnumbertimbangbahan" class="col-sm-2 col-form-label">Planning Number</label>
                        <div class="col-sm-2">
                            <div class="input-group mb-1">
                                <input type="text" class="form-control form-control-sm bg-transparent" placeholder="Planning Number" aria-label="Recipient's username" aria-describedby="button-addon2" id="planningnumbertimbangbahan" readonly>
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#listplanningnumbertimbangbahan" data-bs-dismiss="modal"><span><img src="../asset/icon/cari.png"></span></button>
                            </div>
                        </div>
                        <label for="yearsdatatimbang" class="col-sm-1 col-form-label">Years</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" id="yearsdatatimbang" readonly>
                        </div>
                        <label for="operatordatatimbangan" class="col-sm-2 offset-2 col-form-label">Operator 1</label>
                        <div class="col-sm-2">
                            <div class="input-group mb-1">
                                <input type="text" class="form-control form-control-sm bg-transparent" placeholder="Operator 1" aria-label="Recipient's username" aria-describedby="button-addon2" id="operator1datatimbangan" readonly>
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchoperatordatatimbangan1" data-bs-dismiss="modal"><span><img src="../asset/icon/cari.png"></span></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="productiddatatimbang" class="col-sm-2 col-form-label">Product ID</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" id="productiddatatimbang" readonly>
                        </div>
                        <label for="operatordatatimbangan" class="col-sm-2 offset-2 col-form-label">Operator 2</label>
                        <div class="col-sm-2">
                            <div class="input-group mb-1">
                                <input type="text" class="form-control form-control-sm bg-transparent" placeholder="Operator 2" aria-label="Recipient's username" aria-describedby="button-addon2" id="operator2datatimbangan" readonly>
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchoperatordatatimbangan2" data-bs-dismiss="modal"><span><img src="../asset/icon/cari.png"></span></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="batchdatatimbangan" class="col-sm-2 col-form-label">Batch/Exp.Date</label>
                        <div class="col-sm-2">
                            <select id="batchdatatimbangan" class="form-control form-control-sm" onchange="getdetailbatchdatatimbang(this.value)"></select>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="expdatedattimbangan" readonly>
                        </div>
                        <label for="timbangandatatimbangan" class="col-sm-2 offset-2 col-form-label" hidden>Timbangan</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm text-danger fw-bold" id="timbangandatatimbangan" value="<?= $_SESSION['namtim'] ?>" readonly hidden>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="nomesindatatimbangan" class="col-sm-2 col-form-label">No Mesin/Wadah/Proses</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="nomesindatatimbangan" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="number" class="form-control form-control-sm" id="nowadahdatatimbangan" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" id="noprosesdatatimbangan" readonly>
                        </div>
                        <label for=" ipdatatimbangan" class="col-sm-2 offset-2 col-form-label" hidden>IP</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm text-danger fw-bold" id="ipdatatimbangan" value="<?= $_SESSION['ip'] ?>" readonly hidden>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="tglmixingatatimbangan" class="col-sm-2 col-form-label">Tgl Mixing</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="tglmixingatatimbangan" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" id="itemdatatimbangan" readonly hidden>
                        </div>
                        <label for="portdatatimbangan" class="col-sm-2 offset-3 col-form-label" hidden>Port</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm text-danger fw-bold" id="portdatatimbangan" value="<?= $_SESSION['port'] ?>" readonly hidden>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-sm-4 offset-2">
                            <button type="button" class="btn btn-success btn-sm" onclick="submitdatatimbangan()"><img src="../asset/icon/save.png"> Submit</button>
                        </div>
                    </div>
                    <table id="dcreateplanning" class="table table-sm" style="width:100%;">
                        <thead class="bg-dark text-white">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Planning</th>
                                <th>Years</th>
                                <th>Items</th>
                                <th>Product</th>
                                <th>Batch</th>
                                <th>Exp. Date</th>
                                <th>Kode Mesin</th>
                                <th>Mixing Date</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $plant = $_SESSION['plant'];
                            $unitcode = $_SESSION['unitcode'];
                            $usedby = $_SESSION['userid'];
                            $ip = $_SESSION['ip'];
                            $sql = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_header WHERE Plant='$plant' AND 
                                                                                                    UnitCode='$unitcode' AND
                                                                                                    UsedBy='$usedby' AND
                                                                                                    AddressOf='$ip' AND
                                                                                                    StatsX is null");
                            while ($row = mysqli_fetch_array($sql)) {
                                $query = mysqli_query($conn, "SELECT BatchNumber FROM tb_prosestimbang_mapping WHERE Plant='$plant' AND 
                                                                                                    UnitCode='$unitcode' AND
                                                                                                    PlanningNumber='$row[PlanningNumber]' AND
                                                                                                    Years='$row[Years]' AND
                                                                                                    ProductID='$row[ProductID]' AND
                                                                                                    UsedBy='$row[UsedBy]'");
                                $r = mysqli_fetch_array($query);
                                $batchnumber = $r['BatchNumber'];
                            ?>
                                <tr>
                                    <td><button class="btn btn-sm zoom p-0" onclick="deleteprosestimbang('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>','<?= $row['Items'] ?>','<?= $row['ProductID'] ?>','<?= $batchnumber ?>','<?= $row['UsedBy'] ?>','<?= $row['AddressOf'] ?>')"><img src="../asset/img/delete.png"></button></td>
                                    <td class="fw-bold"><?= $row['PlanningNumber'] ?></td>
                                    <td class="fw-bold"><?= $row['Years'] ?></td>
                                    <td class="fw-bold"><?= $row['Items'] ?></td>
                                    <td style="width: 50%;"><?= Getdata('ProductDescriptions', 'mara_product', 'ProductID', $row['ProductID']) ?></td>
                                    <!-- <td><?= GetdataVI('BatchNumber', 'tbl_hasiltimbang_detail', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $row["PlanningNumber"], 'Years', $row["Years"], 'Items', $row["Items"], 'ProductID', $row['ProductID']) ?></td> -->
                                    <td><?= $batchnumber ?></td>
                                    <td><?= $row['ExpiredDate'] ?></td>
                                    <td><?= $row['ResourceIDMix'] ?></td>
                                    <td><?= $row['MixingDate'] ?></td>
                                    <td><a href="#" class="badge bg-danger text-decoration-none" onclick="stopprosestimbang('<?= $row['PlanningNumber'] ?>',
                                                                                                                                '<?= $row['Years'] ?>',
                                                                                                                                '<?= $row['Items'] ?>',
                                                                                                                                '<?= $row['ProductID'] ?>',
                                                                                                                                '<?= $batchnumber ?>',
                                                                                                                                '<?= $row['UsedBy'] ?>')"><img src=" ../asset/icon/stop1.png">Stop</a></td>
                                </tr>
                            <?php
                            }
                            // }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../asset/js/myjavascript.js"></script>
<script>
    setInterval(cekkoneksidatatimbang, 1000)

    function endCountdown() {
        var getmanual = setInterval(function() {
            getdatatimbangmanual();
        }, 1000);
    }

    function handleTimer() {
        if (count < 1) {
            clearInterval(timer);
            $('#textcountdowndatatimbang').html('Ready');
            document.getElementById('textcountdowndatatimbang').style.color = 'green'
            endCountdown();
        } else {
            document.getElementById('textcountdowndatatimbang').style.color = ''
            $('#textcountdowndatatimbang').html(count);
            count--;
        }
    }

    function getdatatimbangmanual() {
        var namtim = $('#namatimbangandatatimbangan').val()
        var ip = $('#ipaddressdatatimbangan').val()
        var port = $('#portdatatimbangan').val()
        if (namtim != '' && ip != '' && port != '') {
            var koneksi = document.getElementById('koneksitimbangbahan').innerHTML
            if (koneksi == 'Disconnect') {
                var weight = ''
                $('#showdatatimbangan').val('')
                var gross = document.getElementById('grossgetweightdatatimbangan')
                var net = document.getElementById('netgetweightdatatimbangan')
                var tare = document.getElementById('taregetweightdatatimbangan')

                if (gross.checked === true) {
                    weight = 'gross'
                }
                if (net.checked === true) {
                    weight = 'net'
                }
                if (tare.checked === true) {
                    weight = 'tare'
                }
                $.ajax({
                    url: "../function/getdata.php",
                    dataType: "JSON",
                    type: "POST",
                    cache: false,
                    data: {
                        "prosescekkoneksitimbangan2": [ip, port, weight]
                    },
                    success: function(data) {
                        // alert(data.cb)
                        if (data.return == 1) {
                            clearInterval(timer)
                            $('#bebandatatimbangan').val(data.weight_qty + data.weight_uom)
                            simpandatatimbangan()
                        } else {
                            if (data.satuan == 'undefined') {
                                $('#bebandatatimbangan').val('0kg')
                            } else {
                                $('#bebandatatimbangan').val('0' + data.satuan)
                            }

                        }
                    }
                })
            }
        }
    }

    var count = 3;
    var timer = setInterval(function() {
        var koneksi = document.getElementById('koneksitimbangbahan').innerHTML
        var stop = document.getElementById('stopdatatimbangan').checked
        if (koneksi == 'Disconnect' && stop === false) {
            handleTimer(count);
        }
        if (stop === true) {
            document.getElementById('textcountdowndatatimbang').value = 'Stoped'
        }
    }, 1000);

    google.charts.load('current', {
        'packages': ['gauge']
    });
    google.charts.setOnLoadCallback(drawChart);
</script>