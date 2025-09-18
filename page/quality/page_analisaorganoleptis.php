<?php
$inspectionlot = $_GET['x'];
$years = $_GET['y'];
$noproses = $_GET['z'];
$plant = $_SESSION['plant'];
$unitcode = $_SESSION['unitcode'];

$hiden = 'hidden';
$sql = mysqli_query($conn, "SELECT * FROM insp_pengolahan_header WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    InspectionLot ='$inspectionlot' AND
                                                                    Lotyears='$years'");
if (mysqli_num_rows($sql) != 0) {
    $row = mysqli_fetch_array($sql);
    $product =  $row['ProductID'];
    $batch =  $row['BatchNumber'];
    $query = mysqli_query($conn, "SELECT ProductDescriptions FROM mara_product WHERE ProductID='$row[ProductID]'");
    $r = mysqli_fetch_array($query);
    $desc = $r['ProductDescriptions'];
    $hiden = '';
}
?>
<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/lab.png"> QC Result - Organoleptis</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <label for="inspectionlotanalisaorganoleptis" class="col-sm-2 col-form-label">Inspection Lot</label>
        <div class="col-sm-2">
            <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm" placeholder="Inspection Lot" aria-label="Recipient's username" aria-describedby="button-addon2" id="inspectionlotanalisaorganoleptis" value="<?= $inspectionlot ?>" readonly>
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchinspectionlotanalisaorganoleptis"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
        <label for="inspyearsanalisaorganoleptis" class="col-sm-2 col-form-label">Insp. Lot Years</label>
        <div class="col-sm-1">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="inspyearsanalisaorganoleptis" readonly value="<?= $years ?>">
        </div>
        <label for="pernranalisaorganoleptis" class="col-sm-1 offset-1 col-form-label">Nama Qc</label>
        <div class="col-sm-3">
            <div class="input-group mb-1">
                <input type="text" class="form-control" placeholder="Pernr" aria-label="Recipient's username" aria-describedby="button-addon2" id="pernranalisaorganoleptis" value="<?= $_SESSION['personnelnumber'] . ' - ' . Getdata('EmployeeName', 'pa001', 'PersonnelNumber', $_SESSION['personnelnumber']) ?>">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchpernrorganoleptis"><span><img src="../asset/icon/cari.png"> </span></button>
            </div>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="productanalisaorganoleptis" class="col-sm-2 col-form-label">Product ID</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="productanalisaorganoleptis" readonly value="<?= $product ?>">
        </div>
        <label for="batchanalisaorganoleptis" class="col-sm-1 col-form-label">Batch</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="batchanalisaorganoleptis" readonly value="<?= $batch ?>">
        </div>
    </div>
    <div class="form-group row mb-1">
        <label for="deskripsianalisaorganoleptis" class="col-sm-2 col-form-label">Description</label>
        <div class="col-sm-5">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="deskripsianalisaorganoleptis" readonly value="<?= $desc ?>">
        </div>
    </div>
    <div class="form-group row mb-1">
        <label for="prosesnumberalisaorganoleptis" class="col-sm-2 col-form-label">Proses Number</label>
        <div class="col-sm-1">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="prosesnumberalisaorganoleptis" value="<?= $noproses ?>" readonly>
        </div>
    </div>
    <div class="accordion" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                    Record Result Organoleptis
                </button>
            </h2>
            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
                <div class="accordion-body">
                    <div class="form-group row mb-1 ms-3">
                        <table id="mytabled" class="table table-sm w-100">
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
                                $sql = mysqli_query($conn, "SELECT * FROM insp_pengolahan_detail WHERE Plant='$plant' AND 
                                                                                                        UnitCode='$unitcode' AND 
                                                                                                        InspectionLot ='$inspectionlot' AND
                                                                                                        Lotyears ='$years' AND
                                                                                                        NoProses='$noproses'");
                                while ($r = mysqli_fetch_array($sql)) {
                                    $rr = mysqli_query($conn, "SELECT * FROM result_recording WHERE Plant='$plant' AND 
                                                                                                    UnitCode='$unitcode' AND 
                                                                                                    InspectionLot ='$inspectionlot' AND
                                                                                                    Lotyears ='$years' AND
                                                                                                    NoProses='$noproses'");
                                    if (mysqli_num_rows($rr) == 1) {
                                        continue;
                                    } else {
                                        $query = mysqli_query($conn, "SELECT * FROM master_inspection WHERE Plant='$plant' AND 
                                                                                                        UnitCode='$unitcode' AND 
                                                                                                        MIC ='$r[MIC]'");
                                        $q = mysqli_fetch_array($query); ?>
                                        <tr>
                                            <td class="text-center"><?= $i ?></td>
                                            <td class="text-center">
                                                <input class="form-control form-control-sm  border-0 bg-transparent" type="text" id="MICorganoleptis<?= $i ?>" value="<?= $r['MIC'] ?>" readonly>
                                            </td>
                                            <td>
                                                <label class="text-decoration-underline"><?= $r['Descriptions'] ?></label>
                                                <br>
                                                <?= $r['FullyDesc'] ?>
                                            </td>
                                            <?php
                                            if ($q['Quan'] == 'X') { ?>
                                                <td class="text-center">
                                                    <input class="form-control form-control-sm" type="text" id="result_awalorganoleptis<?= $i ?>">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-control form-control-sm" type="text" id="result_tengahorganoleptis<?= $i ?>">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-control form-control-sm" type="text" id="result_akhirorganoleptis<?= $i ?>">
                                                </td>
                                            <?php } elseif ($q['Qual'] == 'X') { ?>
                                                <td class="text-center">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="result_awalorganoleptis<?= $i ?>">
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="result_tengahorganoleptis<?= $i ?>">
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="result_akhirorganoleptis<?= $i ?>">
                                                    </div>
                                                </td>
                                            <?php }
                                            ?>
                                            <td class="text-center"><input type="text" class="form-control form-control-sm" id="keteranganhasiltolakorganoleptis<?= $i ?>"></td>
                                        </tr>
                                <?php
                                        $i += 1;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <input type="text" id="lenght_updateorganoleptis" value="<?= $i ?>" hidden>
                        <?php
                        if ($_GET['x'] != 0) { ?>
                            <section id="kesimpulananalisaorganoleptis">
                                <hr>
                                <h6 class="fw-bold">Kesimpulan</h6>
                                <table class="table w-50">
                                    <tbody>
                                        <tr>
                                            <!-- <td style="width: 25%;">Kesimpulan</td> -->
                                            <td style="width: 25%;">
                                                <select class="form-select form-select-sm" id="usagedecisionanalisaorganoleptis">
                                                    <?php
                                                    $query = mysqli_query($conn, "SELECT KodeCatalog,Descriptions FROM qc_catalog WHERE Item='0'");
                                                    while ($q = mysqli_fetch_array($query)) { ?>
                                                        <option value="<?= $q['KodeCatalog'] ?>"><?= $q['Descriptions'] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </section>
                        <?php }
                        ?>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-end">
                            <button type="button" id="simpanqcorganoleptis" class="btn btn-outline-success btn-sm" onclick="simpanqcorganoleptis()" <?= $hiden ?>><img src="../asset/icon/save.png"> Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Planning Number -->
<!-- <div class="modal fade" id="searchplanningnumberpersiapanhoperqc1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                            <th>Planning Number</th>
                            <th>Years</th>
                            <th>Product ID</th>
                            <th>Description</th>
                            <th>Batch</th>
                            <th>Resource ID</th>
                            <th>ED</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $plant = $_SESSION['plant'];
                        $unitcode = $_SESSION['unitcode'];
                        $sql = mysqli_query($conn, "SELECT * FROM insp_pengolahan WHERE Plant='$plant' AND
                                                                                        UnitCode='$unitcode' AND
                                                                                        StatsX =''");
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td style="width: 10%;"><a href="#" class="badge bg-success href_transform" onclick="prosesselectqcresult('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>','Hoper')"><?= $row['PlanningNumber'] ?></a></td>
                                <td><?= $row['Years'] ?></td>
                                <td><?= $row['ProductID'] ?></td>
                                <td style="width: 40%;"><?= Getdata('ProductDescriptions', 'mara_product', 'ProductID', $row['ProductID']) ?></td>
                                <td><?= $row['BatchNumber'] ?></td>
                                <td><?= $row['ResourceID'] ?></td>
                                <td><?= $row['ExpiredDate'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> -->
<!-- End -->

<!-- Insepction Lot -->
<div class="modal fade" id="searchinspectionlotanalisaorganoleptis" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">List Inspection Lot</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="mytable_inspectionlot" class="table table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Inspection Lot</th>
                            <th>Years</th>
                            <th>Product ID</th>
                            <th>Description</th>
                            <th>No Proses</th>
                            <th>Batch</th>
                            <th>Planning Number</th>
                            <th>Plan. Years</th>
                            <th>Status</th>
                            <th>CreatedOn</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, "SELECT * FROM insp_pengolahan_header WHERE Plant='$plant' AND
                                                                                        UnitCode='$unitcode' AND
                                                                                        NoProses != 0 AND
                                                                                        StatsX=''");
                        while ($row = mysqli_fetch_array($sql)) {
                            $query = mysqli_query($conn, "SELECT * FROM planning_pengolahan_header WHERE Plant='$plant' AND 
                                                                                                     UnitCode='$unitcode' AND
                                                                                                     PlanningNumber='$row[PlanningNumber]' AND
                                                                                                     Years='$row[Years]' AND
                                                                                                     Approval='X' AND
                                                                                                     Del is null");
                            if (mysqli_num_rows($query) == 0) {
                                continue;
                            }

                            $query = mysqli_query($conn, "SELECT * FROM planning_pengolahan_subdetail WHERE Plant='$plant' AND 
                                                                                                     UnitCode='$unitcode' AND
                                                                                                     PlanningNumber='$row[PlanningNumber]' AND
                                                                                                     Years='$row[Years]' AND
                                                                                                     ProductID ='$row[ProductID]' AND
                                                                                                     BatchNumber = '$row[BatchNumber]' AND
                                                                                                     NoProses='$row[NoProses]' AND
                                                                                                     Stats04='X'");
                            if (mysqli_num_rows($query) == 0) {
                                continue;
                            }
                        ?>
                            <tr>
                                <?php
                                if ($row['StatsY'] == 'CRTD') { ?>
                                    <td style="width: 10%;"><a href="#" class="badge bg-danger text-white text-decoration-none" onclick="showinspanalisaorganoleptis('<?= $row['InspectionLot'] ?>','<?= $row['Lotyears'] ?>','<?= $row['ProductID'] ?>')"><?= $row['InspectionLot'] ?></a></td>
                                <?php } else { ?>
                                    <td style="width: 10%;"><a href="#" class="badge bg-success zoom text-decoration-none" onclick="selectinspanalisaorganoleptis('<?= $row['InspectionLot'] ?>','<?= $row['Lotyears'] ?>','<?= $row['NoProses'] ?>')"><?= $row['InspectionLot'] ?></a></td>
                                <?php
                                } ?>
                                <td><?= $row['Lotyears'] ?></td>
                                <td><?= $row['ProductID'] ?></td>
                                <td style="width: 40%;"><?= Getdata('ProductDescriptions', 'mara_product', 'ProductID', $row['ProductID']) ?></td>
                                <td><?= $row['NoProses'] ?></td>
                                <td><?= $row['BatchNumber'] ?></td>
                                <td><?= $row['PlanningNumber'] ?></td>
                                <td><?= $row['Years'] ?></td>
                                <td><?= $row['StatsY'] ?></td>
                                <td><?= $row['CreatedOn'] ?></td>
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
<!-- End -->

<!-- Modal Search Pernr -->
<div class="modal fade" id="searchpernrorganoleptis" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Search Employee Name</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="mytable" class="table table-striped table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 10%;">Option</th>
                            <th style="width: 10%;">PersonnelNumber</th>
                            <th style="width: 80%;">EmployeeName</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, 'SELECT PersonnelNumber,EmployeeName FROM pa001');
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="$('#pernranalisaorganoleptis').val('<?= $row['PersonnelNumber'] . ' - ' . $row['EmployeeName'] ?>'),$('#searchpernrorganoleptis').modal('hide')">Select</a>
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

<!-- Change Insepction Lot -->
<div class="modal fade" id="searchchangeinspectionlotanalisaorganoleptis" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Change Inspection Lot</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="$('#searchchangeinspectionlotanalisaorganoleptis').modal('hide'),$('#searchinspectionlotanalisaorganoleptis').modal('show')"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="form-group row mb-0">
                        <label for="insplotchangeilanalisaorganoleptis" class="col-sm-2 col-form-label">Insp. Lot</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent" id="insplotchangeilanalisaorganoleptis" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="inspyearschangeilanalisaorganoleptis" class="col-sm-2 col-form-label">Insp. Year</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm bg-transparent" id="inspyearschangeilanalisaorganoleptis" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="materialchangeilanalisaorganoleptis" class="col-sm-2 col-form-label">Material</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent" id="materialchangeilanalisaorganoleptis" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <!-- <label for="planningnumbertimbangbahan" class="col-sm-2 col-form-label">Insp. Lot</label> -->
                        <div class="col-sm-6 offset-2">
                            <input type="text" class="form-control form-control-sm border-0 bg-white fw-bold" id="deskripsichangeilanalisaorganoleptis" readonly>
                        </div>
                    </div>
                    <div id="table_changeinspanalisaorganoleptis"></div>
                    <div class="form-group row mb-0 ms-1" id="itemokeanalisaorganoleptis" hidden>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="okeanalisaorganoleptis" checked>
                            <label class="form-check-label" for="flexCheckDefault">
                                Items Oke
                            </label>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-sm-4">
                            <button type="button" id="assignmicanalisaorganoleptis" class="btn btn-primary btn-sm" onclick="assignmicanalisaorganoleptis()" hidden><img src="../asset/icon/save.png"> Assign Master of Insp. Char</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End -->