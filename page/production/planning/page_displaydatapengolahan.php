<?php
$limit = base64_decode($_GET['z']);
if (base64_decode($_GET['z']) == '') {
    $limit = 100;
}
$productid = base64_decode($_GET['x']);
$bets = base64_decode($_GET['y']);
?>
<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/display.png"> DISPLAY PLANNING PENGOLAHAN</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <label for="productidstartdisplayplanningpengolahan" class="col-sm-2 col-form-label">Product ID</label>
        <div class="col-sm-2">
            <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm" placeholder="Product ID" aria-label="Recipient's username" aria-describedby="button-addon2" id="productidstartdisplayplanningpengolahan" value="<?= $productid ?>">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchprodukstartdisplayplanningpengolahan"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="batchstartdisplayplanningpengolahan" class="col-sm-2 col-form-label">Batch Number</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm" id="batchstartdisplayplanningpengolahan" placeholder="Batch" value="<?= $bets ?>">
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="maxshowstartdisplayplanning" class="col-sm-2 col-form-label">Max. Show</label>
        <div class="col-sm-1">
            <input type="number" class="form-control form-control-sm" id="maxshowstartdisplayplanningpengolahan" min="1" value="<?= $limit ?>">
        </div>
        <div class="form-group row">
            <div class="col-sm-2 offset-2 mt-2">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="submitstartdisplayplanningpengolahan()"><img src="../asset/icon/search.png"> Submit</button>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <table id="mytable" class="table table-sm w-100" style="width:100%;">
        <thead class="bg-dark text-white">
            <tr>
                <th>Planing Number</th>
                <th>Years</th>
                <!-- <th>No Proses</th> -->
                <th>Product ID</th>
                <th>Batch Number</th>
                <th>Expired Date</th>
                <th>Mix</th>
                <th>Mixing Date</th>
                <th>Resep</th>
                <th>Created By</th>
                <th>Created On</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($productid <> "" and $bets <> "") {
                $query = "SELECT * FROM planning_pengolahan_subdetail WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND
                                                                            ProductID ='$productid' AND
                                                                            BatchNumber ='$bets' AND
                                                                            NoProses=1
                                                                            LIMIT $limit";
            } elseif ($productid <> "" && $bets == "") {
                $query = "SELECT * FROM planning_pengolahan_subdetail WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND
                                                                            ProductID ='$productid' AND
                                                                            NoProses=1
                                                                            LIMIT $limit";
            } elseif ($productid == "" && $bets <> "") {
                $query = "SELECT * FROM planning_pengolahan_subdetail WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND
                                                                            BatchNumber ='$bets' AND
                                                                            NoProses=1
                                                                            LIMIT $limit";
            } elseif ($productid == "" && $bets == "") {
                $query = "SELECT * FROM planning_pengolahan_subdetail WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND
                                                                            NoProses=1
                                                                            LIMIT $limit";
            }

            $sql = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_array($sql)) {
                $query = mysqli_query($conn, "SELECT * FROM planning_pengolahan_detail WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            PlanningNumber='$row[PlanningNumber]' AND
                                                                                            Years='$row[Years]' AND
                                                                                            Items='$row[Items]' AND
                                                                                            ProductID='$row[ProductID]' AND
                                                                                            BatchNumber LIKE '%$row[BatchNumber]%'
                                                                                            ");
                $r = mysqli_fetch_array($query);
                $approval = GetdataIV('Approval', 'planning_pengolahan_header', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $row['PlanningNumber'], 'Years', $row['Years'])
            ?>
                <tr>
                    <td>
                        <?php
                        if ($approval == 'X') { ?>
                            <a href="#" class="badge bg-success href_transform" id="planningnumberdisplayplanning" onclick="displayplanningpengolahan('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>','<?= $row['Items'] ?>','<?= $row['ProductID'] ?>','<?= $row['BatchNumber'] ?>')"><?= $row['PlanningNumber'] ?></a>
                        <?php } else { ?>
                            <a href="#" class="badge bg-danger href_transform" id="planningnumberdisplayplanning" onclick="displayplanningpengolahan('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>','<?= $row['Items'] ?>')"><?= $row['PlanningNumber'] ?></a>
                        <?php
                        } ?>
                    </td>
                    <td><?= $row['Years'] ?></td>
                    <!-- <td><?= $row['NoProses'] ?></td> -->
                    <td><?= $row['ProductID'] ?></td>
                    <td><?= $row['BatchNumber'] ?></td>
                    <td><?= $r['ExpiredDate'] ?></td>
                    <td><?= $r['ResourceIDMix'] ?></td>
                    <td><?= $r['MixingDate'] ?></td>
                    <td><?= $r['JumlahResep'] ?></td>
                    <td><?= $row['CreatedBy'] ?></td>
                    <td><?= beautydate2($row['CreatedOn'])  ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal Search Product-->
<div class="modal fade" id="searchprodukstartdisplayplanningpengolahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="dsearchdata4" class="table table-striped table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 10%;"></th>
                            <th style="width: 10%;">Product ID</th>
                            <th style="width: 70%;">Descriptions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, 'SELECT * FROM mara_product');
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none href_transform" onclick="selectproductidstartdisplayplanningpengolahan('<?= $row['ProductID'] ?>')">Select</a>
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
<!-- End -->

<!-- Modal Show Detail Data Pengolahan -->
<div class="modal fade" id="showmodaldisplayplanningpengolahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Display Planning Pengolahan</h6>
                <button type="button" class="btn btn-sm btn-dark href_transform" data-bs-dismiss="modal" aria-label="Close"><img src="../asset/icon/back.png"> Back</button>
            </div>
            <div class="modal-body">
                <div class="border-0 mb-0 bg-transparent">
                    <div class="form-group row mb-0">
                        <label for="planningnumberdisplaydataplanningpengolahan" class="col-sm-2 col-form-label">Planning Number</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="planningnumberdisplaydataplanningpengolahan" readonly>
                        </div>
                        <label for="shiftdisplaydataplanningpengolahan" class="col-sm-2 offset-3 col-form-label">Shift</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" id="shiftdisplaydataplanningpengolahan" readonly>
                        </div>

                    </div>
                    <div class="form-group row mb-0">
                        <label for="yearsdisplaydataplanningpengolahan" class="col-sm-2 col-form-label">Years</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="yearsdisplaydataplanningpengolahan" readonly>
                        </div>
                        <label for="createdondisplaydataplanningpengolahan" class="col-sm-2 offset-3 col-form-label">Dibuat Tgl</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" id="createdondisplaydataplanningpengolahan" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="itemsdataplanningpengolahan" class="col-sm-2 col-form-label">Items</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" id="itemsdataplanningpengolahan" readonly>
                        </div>
                        <label for="createdfordisplaydataplanningpengolahan" class="col-sm-2 offset-4 col-form-label">Dibuat Oleh</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" id="createdfordisplaydataplanningpengolahan" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="produkiddataplanningpengolahan" class="col-sm-2 col-form-label">Produk</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" id="produkiddataplanningpengolahan" readonly>
                        </div>
                        <label for="insplotdataplanningpengolahan" class="col-sm-2 col-form-label offset-4">Insp. Lot</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" id="insplotdataplanningpengolahan" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="batchdataplanningpengolahan" class="col-sm-2 col-form-label">Batch</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="batchdataplanningpengolahan" readonly>
                        </div>
                        <label for="inspyearsdataplanningpengolahan" class="col-sm-2 col-form-label offset-3">Insp. Years</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="inspyearsdataplanningpengolahan" readonly>
                        </div>
                    </div>
                </div>
                <!-- <section id="approvaldisplaydataplanningpengolahan"></section> -->
                <div>
                    <ul class="nav nav-tabs mb-3 mt-3 border-1 border-dark" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark active" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1" aria-selected="true">Planning</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-2" type="button" role="tab" aria-controls="pills-2" aria-selected="false" onclick="displaydrymixdatapengolahan()">Dry Mix</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark" id="pills-3-tab" data-bs-toggle="pill" data-bs-target="#pills-3" type="button" role="tab" aria-controls="pills-3" aria-selected="false" onclick="displaywetmixdatapengolahan()">Wet Mix</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark" id="pills-4-tab" data-bs-toggle="pill" data-bs-target="#pills-4" type="button" role="tab" aria-controls="pills-4" aria-selected="false" onclick="displayqualitydatapengolahan()">Quality Control</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="tabs-tabContent">
                        <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                            <!-- planning -->
                            <section id="approvaldisplaydataplanningpengolahan"></section>
                        </div>
                        <div class="tab-pane fade show" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
                            <!-- dry mix -->
                            <section id="drymixdataplanningpengolahan"></section>
                        </div>
                        <div class="tab-pane fade show" id="pills-3" role="tabpanel" aria-labelledby="pills-3-tab">
                            <!-- wet mix -->
                            <section id="wetmixdataplanningpengolahan"></section>
                        </div>
                        <div class="tab-pane fade show" id="pills-4" role="tabpanel" aria-labelledby="pills-4-tab">
                            <!-- qc -->
                            <section id="qualitycontroldataplanningpengolahan"></section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End -->