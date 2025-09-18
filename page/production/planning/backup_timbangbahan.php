<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/scale2.png"> Timbang Bahan</h6>
    <hr class="w-50 mb-3">
    <div class="row mb-5">
        <div class="col-sm-6">
            <div class="form-group row mb-4">
                <div class="col-sm-12">
                    <!-- <textarea class="form-control fw-bold bg-transparent border-0 text-center" style="font-size: 40pt; vertical-align: middle !important;" id="bebandatatimbangan" readonly>0KG</textarea> -->
                    <div class="form-floating">
                        <textarea class="form-control fw-bold bg-transparent border-0 text-center align-middle" style="font-size: 40pt;" placeholder="Leave a comment here" id="bebandatatimbangan" style="height: 100px" readonly>0Kg</textarea>
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
                        <input type="text" class="form-control form-control-sm" placeholder="Pilih Timbangan" aria-label="Recipient's username" aria-describedby="button-addon2" id="namatimbangandatatimbangan" value="<?= $_SESSION['namtim'] ?>">
                        <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchnamatimbangandatatimbanganbahan"><span><img src="../asset/icon/cari.png"></span></button>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-0">
                <label for="ipaddressdatatimbangan" class="col-sm-3 col-form-label">IP Address</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm" id="ipaddressdatatimbangan" placeholder="19x.xxx.xxx.xxx" value="<?= $_SESSION['ip'] ?>">
                </div>
            </div>
            <div class="form-group row mb-0">
                <label for="portdatatimbangan" class="col-sm-3 col-form-label">Port</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm" id="portdatatimbangan" placeholder="xxxx" value="<?= $_SESSION['port'] ?>">
                </div>
            </div>
            <div class="form-group row mb-3">
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
                    <input class="form-check-input" type="checkbox" id="grossgetweightdatatimbangan" disabled>
                    <label class="form-check-label" for="flexCheckDefault" id="getweightdatatimbangan">
                        Gross
                    </label>
                    <input class="form-check-input" type="checkbox" id="taregetweightdatatimbangan" disabled>
                    <label class="form-check-label" for="flexCheckDefault" id="getweightdatatimbangan">
                        Tare
                    </label>
                    <input class="form-check-input" type="checkbox" id="netgetweightdatatimbangan" disabled>
                    <label class="form-check-label" for="flexCheckDefault" id="getweightdatatimbangan">
                        Net
                    </label>
                    <button type="button" class="btn btn-sm" id="configtimbangbahan" onclick="setconfigdatatimbangan()" disabled>
                        <img src="../asset/icon/setting.png" alt="Setting"> Config
                    </button>
                </div>
            </div>
            <div class="form-group row mb-1">
                <div class="col-sm-9 offset-3">
                    <button type="button" class="btn btn-sm btn-outline-success" onclick="cekkoneksitimbangan()">
                        <img src="../asset/icon/connect.png">
                        <a id="koneksitimbangbahan">Connect</a>
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" id="koneksitimbangbahan" onclick="getadditionaldata()">
                        <img src="../asset/icon/info.png"> Add. Data
                    </button>
                    <button type="button" class="btn btn-sm btn-primary" onclick="getdatatimbangan()">
                        <img src="../asset/icon/scale.png"> Ambil Data
                    </button>
                    <button type="button" class="btn btn-sm btn-success" id="simpandatatimbang" onclick="simpandatatimbangan()">
                        <img src="../asset/icon/save.png"> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container" id="getlisttimbangan">
    <table id="ddisplayplanning0" class="table table-sm" style="width:100%;">
        <thead class="bg-dark text-white fw-bold">
            <tr>
                <th style="text-align: center !important;">#</th>
                <th style="text-align: center !important;">Produk</th>
                <th style="text-align: center !important; width: 30%;">Descriptions</th>
                <th style="text-align: center !important;">Bets</th>
                <th style="text-align: center !important;">Expired Date</th>
                <th style="text-align: center !important;">No Wadah</th>
                <th style="text-align: center !important;">Berat <sup>Kg</sup></th>
                <th style="text-align: center !important;">Created On</th>
                <th>Print</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $plant = $_SESSION['plant'];
            $unitcode = $_SESSION['unitcode'];
            $namtim = $_SESSION['namtim'];
            $ip = $_SESSION['ip'];
            $port = $_SESSION['port'];
            if ($namtim !== null && $ip !== null && $port !== null) {

                $sql = mysqli_query($conn, "SELECT * FROM manualinput_dry_mixed WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                AddressOf ='$ip' AND
                                                                                StatsX='X'");
                if (mysqli_num_rows($sql) != 0) {
                    $row = mysqli_fetch_array($sql);
                    $productid = $row['ProductID'];
                    $batch = $row['BatchNumber'];
                    $i = 1;
                    $sql = mysqli_query($conn, "SELECT * FROM hasiltimbang_drymixed WHERE Plant='$plant' AND
                                                                                    UnitCode='$unitcode' AND
                                                                                    ProductID='$productid' AND
                                                                                    BatchNumber='$batch' AND
                                                                                    AddressOf ='$ip'
                                                                                    ORDER BY CreatedOn ASC");
                    while ($row = mysqli_fetch_array($sql)) {
            ?>
                        <tr>
                            <td><a href="#" class="badge bg-white text-dark href_transform" onclick="deletedatatimbang('<?= $row['ProductID'] ?>','<?= $row['BatchNumber'] ?>','<?= $row['NoWadah'] ?>')"><img src="../asset/img/delete.png"><?= $i ?></a></td>
                            <td><?= $row['ProductID'] ?></td>
                            <td><?= Getdata('ProductDescriptions', 'mara_product', 'ProductID', $row['ProductID']) ?></td>
                            <td><?= $row['BatchNumber'] ?></td>
                            <td><?= Getdata('ExpiredDate', 'manualinput_dry_mixed', 'ProductID', $row['ProductID']) ?></td>
                            <td><?= $row['NoWadah'] ?></td>
                            <td><?= $row['Berat'] ?> <?= $row['UnitofMeasure'] ?></td>
                            <td><?= $row['CreatedOn'] ?></td>
                            <td><a href="#" class="badge bg-white text-dark href_transform" onclick="printdatatimbang('<?= $row['ProductID'] ?>','<?= $row['BatchNumber'] ?>','<?= $row['NoWadah'] ?>')"><img src="../asset/icon/print.png">Print</a>
                                <a href="#" class="badge bg-white text-dark href_transform" onclick="previewdatatimbang('<?= $row['ProductID'] ?>','<?= $row['BatchNumber'] ?>','<?= $row['NoWadah'] ?>')"><img src="../asset/icon/preview.png">Preview</a>
                            </td>
                        </tr>
                    <?php
                        $i += 1;
                    }
                }
            } else {
                $i = 1;
                $sql = mysqli_query($conn, "SELECT * FROM hasiltimbang_drymixed WHERE Plant='$plant' AND
                                                                                    UnitCode='$unitcode'
                                                                                    ORDER BY CreatedOn ASC");
                while ($row = mysqli_fetch_array($sql)) {
                    ?>
                    <tr>
                        <td><a href="#" class="badge bg-white text-dark href_transform" onclick="deletedatatimbang('<?= $row['ProductID'] ?>','<?= $row['BatchNumber'] ?>','<?= $row['NoWadah'] ?>')"><img src="../asset/img/delete.png"><?= $i ?></a></td>
                        <td><?= $row['ProductID'] ?></td>
                        <td><?= Getdata('ProductDescriptions', 'mara_product', 'ProductID', $row['ProductID']) ?></td>
                        <td><?= $row['BatchNumber'] ?></td>
                        <td><?= Getdata('ExpiredDate', 'manualinput_dry_mixed', 'ProductID', $row['ProductID']) ?></td>
                        <td><?= $row['NoWadah'] ?></td>
                        <td><?= $row['Berat'] ?> <?= $row['UnitofMeasure'] ?></td>
                        <td><?= $row['CreatedOn'] ?></td>
                        <td>
                            <a href="#" class="badge bg-white text-dark href_transform" onclick="printdatatimbang('<?= $row['ProductID'] ?>','<?= $row['BatchNumber'] ?>','<?= $row['NoWadah'] ?>')"><img src="../asset/icon/print.png">Print</a>
                            <a href="#" class="badge bg-white text-dark href_transform" onclick="previewdatatimbang('<?= $row['ProductID'] ?>','<?= $row['BatchNumber'] ?>','<?= $row['NoWadah'] ?>')"><img src="../asset/icon/preview.png">Preview</a>
                        </td>
                    </tr>
            <?php
                    $i += 1;
                }
            } ?>
        </tbody>
    </table>
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
<!-- Additional Data -->
<div class="modal fade" id="searchadditionaldatadatatimbanganbahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Additional Data</h6>
                <button type="button" class="btn btn-sm btn-dark href_transform" data-bs-dismiss="modal" aria-label="Close"><img src="../asset/icon/back.png"> Back</button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="form-group row mb-0">
                        <label for="personalnumberenginesetapproval" class="col-sm-2 col-form-label">Product</label>
                        <div class="col-sm-2">
                            <div class="input-group mb-1">
                                <input type="text" class="form-control form-control-sm" placeholder="Product ID" aria-label="Recipient's username" aria-describedby="button-addon2" id="productiddatatimbangan">
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#listproduktimbangbahan" data-bs-dismiss="modal"><span><img src="../asset/icon/cari.png"></span></button>
                            </div>
                        </div>
                        <label for="tglmixingatatimbangan" class="col-sm-2 offset-4 col-form-label">Tgl Mixing</label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control form-control-sm" id="tglmixingatatimbangan" value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="productdescdatatimbangan" class="col-sm-2 col-form-label">Product Desc.</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm bg-white" id="productdescdatatimbangan" readonly>
                        </div>
                        <label for="operatordatatimbangan" class="col-sm-2 offset-2 col-form-label">Operator</label>
                        <div class="col-sm-2">
                            <div class="input-group mb-1">
                                <input type="text" class="form-control form-control-sm" placeholder="Operator" aria-label="Recipient's username" aria-describedby="button-addon2" id="operatordatatimbangan">
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchoperatordatatimbangan" data-bs-dismiss="modal"><span><img src="../asset/icon/cari.png"></span></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="batchdatatimbangan" class="col-sm-2 col-form-label">Batch/Exp.Date</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="batchdatatimbangan">
                        </div>
                        <div class="col-sm-2">
                            <input type="date" class="form-control form-control-sm" id="expdatedattimbangan" value="<?= date('Y-m-d') ?>">
                        </div>
                        <label for="timbangandatatimbangan" class="col-sm-2 offset-2 col-form-label">Timbangan</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm text-danger fw-bold" id="timbangandatatimbangan" value="<?= $_SESSION['namtim'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="nomesindatatimbangan" class="col-sm-2 col-form-label">No Mesin/Wadah/Proses</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="nomesindatatimbangan">
                        </div>
                        <div class="col-sm-1">
                            <input type="number" class="form-control form-control-sm" id="nowadahdatatimbangan" value="1">
                        </div>
                        <div class="col-sm-1">
                            <input type="number" class="form-control form-control-sm" id="noprosesdatatimbangan" value="1">
                        </div>
                        <label for="ipdatatimbangan" class="col-sm-2 offset-2 col-form-label">IP</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm text-danger fw-bold" id="ipdatatimbangan" value="<?= $_SESSION['ip'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-sm-4 offset-2">
                            <button type="button" class="btn btn-success btn-sm" onclick="submitdatatimbangan()"><img src="../asset/icon/save.png"> Submit</button>
                        </div>
                        <label for="portdatatimbangan" class="col-sm-2 offset-2 col-form-label">Port</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm text-danger fw-bold" id="portdatatimbangan" value="<?= $_SESSION['port'] ?>" readonly>
                        </div>
                    </div>
                    <table id="droles" class="table table-sm" style="width:100%;">
                        <thead class="bg-dark text-white">
                            <tr class="text-center">
                                <th rowspan=2>Product ID</th>
                                <th rowspan=2>Batch</th>
                                <th rowspan=2>Ip Address</th>
                                <th rowspan=2>Expired Date</th>
                                <th rowspan=2>Tgl Mixing</th>
                                <th colspan=3 style="text-align: center;">Nomor</th>
                                <th rowspan=2>Operator</th>
                                <th rowspan=2>Status</th>
                                <th rowspan=2>Created On</th>
                            </tr>
                            <tr class="text-center">
                                <th>Mesin</th>
                                <th>Wadah</th>
                                <th>Proses</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $plant = $_SESSION['plant'];
                            $unitcode = $_SESSION['unitcode'];
                            $status = 'Non Active';
                            $sql = mysqli_query($conn, "SELECT * FROM manualinput_dry_mixed WHERE Plant='$plant' AND 
                                                                                            UnitCode='$unitcode'");
                            while ($row = mysqli_fetch_array($sql)) {
                                if ($row['StatsX'] == 'X') {
                                    $status = 'Active';
                                } else {
                                    $status = 'Non Active';
                                }
                            ?>
                                <tr>
                                    <td class="fw-bold"><?= $row['ProductID'] ?></td>
                                    <td class="fw-bold"><?= $row['BatchNumber'] ?></td>
                                    <td class="fw-bold"><?= $row['AddressOf'] ?></td>
                                    <td><?= $row['ExpiredDate'] ?></td>
                                    <td><?= $row['Tgl_drymixed'] ?></td>
                                    <td><?= $row['NoMesin'] ?></td>
                                    <td><?= $row['NoWadah'] ?></td>
                                    <td><?= $row['NoProses'] ?></td>
                                    <td><?= $row['Operator'] ?></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <?php
                                            if ($row['StatsX'] == 'X') { ?>
                                                <input class="form-check-input" type="checkbox" id="kodifikasireviewquality" checked onchange="activemanualinput_drymixed('<?= $row['ProductID'] ?>','<?= $row['BatchNumber'] ?>','off')">
                                            <?php } else { ?>
                                                <input class="form-check-input" type="checkbox" id="kodifikasireviewquality" onchange="activemanualinput_drymixed('<?= $row['ProductID'] ?>','<?= $row['BatchNumber'] ?>','on')">
                                            <?php } ?>
                                        </div>
                                    </td>
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
</div>
<!-- End -->
<!-- List Produk -->
<div class="modal fade" id="listproduktimbangbahan" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel2">Product List</h5>
                <button class="btn btn-outline-dark" data-bs-target="#searchadditionaldatadatatimbanganbahan" data-bs-toggle="modal" data-bs-dismiss="modal">Back</button>
            </div>
            <div class="modal-body">
                <table id="dproduct0" class="table table-striped table-sm" style="width:100%">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>#</th>
                            <th>Product ID</th>
                            <th style="width: 80%;">Product Description</th>
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
                                    <a href="#" class="badge bg-success text-decoration-none href_transform" onclick="submitproducttimbangbahan('<?= $row['ProductID'] ?>','<?= $row['ProductDescriptions'] ?>')"> Select</a>
                                </td>
                                <td><?= $row['ProductID'] ?></td>
                                <td><?= $row['ProductDescriptions'] ?></td>
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
<div class="modal fade" id="searchoperatordatatimbangan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">List Operator</h6>
                <button class="btn btn-outline-dark" data-bs-target="#searchadditionaldatadatatimbanganbahan" data-bs-toggle="modal" data-bs-dismiss="modal">Back</button>
            </div>
            <div class="modal-body">
                <table id="dmainresources0" class="table table-striped table-sm" style="width:100%;">
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
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="submitoperatortimbangbahan('<?= $row['PersonnelNumber'] ?>')">Select</a>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="form-group mb-0">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="autoprintmodaltimbangbahan">
                            <label class="form-check-label" for="approvalplanninggconfiguration">
                                Auto Print
                            </label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="autosavemodaltimbangbahan">
                            <label class="form-check-label" for="approvalplanninggconfiguration">
                                Auto Save
                            </label>
                        </div>
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
                        <button type="button" class="btn btn-sm btn-success mt-2" id="simpanmodaltimbangbahan" onclick="simpanmodaltimbangbahan()">
                            <img src="../asset/icon/save.png"> Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End -->
<script>
    var intervaltime = setInterval(() => {
        var namtim = $('#namatimbangandatatimbangan').val()
        var ip = $('#ipaddressdatatimbangan').val()
        var port = $('#portdatatimbangan').val()
        if (namtim != '' && ip != '' && port != '') {
            $.ajax({
                url: "../function/getdata.php",
                dataType: "JSON",
                type: "POST",
                cache: false,
                data: {
                    "prosescekkoneksitimbangan": [namtim, ip, port, 'cekconnect']
                },
                success: function(data) {
                    // alert(data.cb)
                    if (data.return == 1) {
                        document.getElementById('koneksitimbangbahan').innerHTML = 'Disconnect'
                        $('#ipaddressdatatimbangan').val(data.ipaddress)
                        $('#portdatatimbangan').val(data.port)
                        $('#namatimbangandatatimbangan').val(data.namatimbangan)
                        document.getElementById('autoprintdatatimbangan').checked = false
                        if (data.autoprint == 'X') {
                            document.getElementById('autoprintdatatimbangan').checked = true
                        }
                        document.getElementById('autosavedatatimbangan').checked = false
                        document.getElementById('simpandatatimbang').hidden = false
                        if (data.autosave == 'X') {
                            document.getElementById('autosavedatatimbangan').checked = true
                            document.getElementById('simpandatatimbang').hidden = true
                        }
                        if (data.getweight == 'Gross') {
                            document.getElementById('grossgetweightdatatimbangan').checked = true
                            document.getElementById('taregetweightdatatimbangan').checked = false
                            document.getElementById('netgetweightdatatimbangan').checked = false
                        }
                        if (data.getweight == 'Tare') {
                            document.getElementById('grossgetweightdatatimbangan').checked = false
                            document.getElementById('taregetweightdatatimbangan').checked = true
                            document.getElementById('netgetweightdatatimbangan').checked = false
                        }
                        if (data.getweight == 'Net') {
                            document.getElementById('grossgetweightdatatimbangan').checked = false
                            document.getElementById('taregetweightdatatimbangan').checked = false
                            document.getElementById('netgetweightdatatimbangan').checked = true
                        }
                        document.getElementById('configtimbangbahan').disabled = false
                    }
                }
            });
        }
    }, 1000)
</script>