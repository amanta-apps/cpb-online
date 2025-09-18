<?php
$limit = $_GET['z'];
if ($_GET['z'] == '') {
    $limit = 100;
}
?>
<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/display.png"> DISPLAY PLANNING PENGEMASAN</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <label for="productidstartdisplayplanningpengolahan" class="col-sm-2 col-form-label">Product ID</label>
        <div class="col-sm-2">
            <div class="input-group mb-1">
                <input type="text" class="form-control" placeholder="Product ID" aria-label="Recipient's username" aria-describedby="button-addon2" id="productidstartdisplayplanningpengemasan" value="<?= $_GET['x'] ?>">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchprodukstartdisplayplanningpengemasan"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="batchstartdisplayplanningpengemasan" class="col-sm-2 col-form-label">Batch Number</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm" id="batchstartdisplayplanningpengemasan" placeholder="Batch" value="<?= $_GET['y'] ?>">
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="maxshowstartdisplayplanningpengemasan" class="col-sm-2 col-form-label">Max. Show</label>
        <div class="col-sm-1">
            <input type="number" class="form-control form-control-sm" id="maxshowstartdisplayplanningpengemasan" min="1" value="<?= $limit ?>">
        </div>
        <div class="form-group row">
            <div class="col-sm-2 offset-2 mt-2">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="submitstartdisplayplanningpengemasan()"><img src="../asset/icon/search.png"> Submit</button>
            </div>
        </div>
    </div>

    <div>
        <table id="mytable" class="table table-sm" style="width:100%;">
            <thead class="bg-dark text-white">
                <tr>
                    <th>Planing Number</th>
                    <th>Years</th>
                    <th>Items</th>
                    <th>Product ID</th>
                    <th>Batch Number</th>
                    <th>Expired Date</th>
                    <th>Mix</th>
                    <th>Mixing Date</th>
                    <!-- <th>Created On</th>
                    <th>Created By</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $plant = $_SESSION['plant'];
                $unitcode = $_SESSION['unitcode'];
                $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND 
                                                                                            UnitCode='$unitcode' AND
                                                                                            ProductID LIKE '%$_GET[x]%' AND
                                                                                            BatchNumber LIKE '%$_GET[y]%'
                                                                                            ORDER BY Years DESC
                                                                                            LIMIT $_GET[z] ");
                while ($row = mysqli_fetch_array($sql)) {
                ?>
                    <tr>
                        <td>
                            <?php
                            if ($row['Approval'] == 'X') { ?>
                                <a href="#" class="badge bg-success href_transform" id="planningnumberdisplayplanning" onclick="prosesdisplayplanningpengemasan('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>')"><?= $row['PlanningNumber'] ?></a>
                            <?php } else { ?>
                                <a href="#" class="badge bg-danger href_transform" id="planningnumberdisplayplanning" onclick="prosesdisplayplanningpengemasan('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>')"><?= $row['PlanningNumber'] ?></a>
                            <?php
                            } ?>
                        </td>
                        <td><?= $row['Years'] ?></td>
                        <td><?= $row['Items'] ?></td>
                        <td><?= $row['ProductID'] ?></td>
                        <td><?= $row['BatchNumber'] ?></td>
                        <td><?= $row['ExpiredDate'] ?></td>
                        <td><?= $row['ResourceIDMix'] ?></td>
                        <td><?= $row['MixingDate'] ?></td>
                        <!-- <td><?= $row['CreatedBy'] ?></td>
                        <td><?= $row['CreatedOn'] ?></td> -->
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Search Product ID-->
    <div class="modal fade" id="searchprodukstartdisplayplanningpengemasan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                        <a href="#" class="badge bg-success text-decoration-none href_transform" onclick="selectproductidstartdisplayplanningpengemasan('<?= $row['ProductID'] ?>')">Select</a>
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

    <!-- Modal Show Detail Data Pengemasan -->
    <div class="modal fade" id="showmodaldisplayplanningpengemasan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Display Planning Pengemasan</h6>
                    <button type="button" class="btn btn-sm btn-dark href_transform" data-bs-dismiss="modal" aria-label="Close"><img src=" ../asset/icon/back.png"> Back</button>
                </div>
                <div class="modal-body">
                    <div class="border-0 mb-0 bg-transparent">
                        <div class="form-group row mb-0">
                            <label for="planningnumberdisplaydataplanningpengemasan" class="col-sm-2 col-form-label">Planning Number</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control form-control-sm" id="planningnumberdisplaydataplanningpengemasan" readonly>
                            </div>
                            <label for="shiftdisplaydataplanningpengemasan" class="col-sm-2 offset-3 col-form-label">Shift</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="shiftdisplaydataplanningpengemasan" readonly>
                            </div>

                        </div>
                        <div class="form-group row mb-0">
                            <label for="yearsdisplaydataplanningpengemasan" class="col-sm-2 col-form-label">Years</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control form-control-sm" id="yearsdisplaydataplanningpengemasan" readonly>
                            </div>
                            <label for="createdondisplaydataplanningpengemasan" class="col-sm-2 offset-3 col-form-label">Dibuat Tgl</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="createdondisplaydataplanningpengemasan" readonly>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label for="createdfordisplaydataplanningpengemasan" class="col-sm-2 offset-7 col-form-label">Dibuat Oleh</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="createdfordisplaydataplanningpengemasan" readonly>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label for="packingdatedisplaydataplanningpengemasan" class="col-sm-2 offset-7 col-form-label">Packing Date</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="packingdatedisplaydataplanningpengemasan" readonly>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label for="mixingdatedisplaydataplanningpengemasan" class="col-sm-2 offset-7 col-form-label">Mixing Date</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="mixingdatedisplaydataplanningpengemasan" readonly>
                            </div>
                        </div>
                    </div>
                    <div>
                        <ul class="nav nav-tabs mb-3 mt-3 border-1 border-dark" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-dark active" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1" aria-selected="true">Planning</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-dark" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-2" type="button" role="tab" aria-controls="pills-2" aria-selected="false" onclick="displayhoperdatapengemasan()">Hoper</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-dark" id="pills-3-tab" data-bs-toggle="pill" data-bs-target="#pills-3" type="button" role="tab" aria-controls="pills-3" aria-selected="false" onclick="displaytopackdatapengemasan()">Topack</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-dark" id="pills-4-tab" data-bs-toggle="pill" data-bs-target="#pills-4" type="button" role="tab" aria-controls="pills-4" aria-selected="false" onclick="displaypillowdatapengemasan()">Pillow</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="tabs-tabContent">
                            <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                                <section id="approvaldisplaydataplanningpengemasan"></section>
                            </div>
                            <div class="tab-pane fade show" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
                                <!-- Hoper -->
                                <section id="hoperdataplanningpengemasan"></section>
                            </div>
                            <div class="tab-pane fade show" id="pills-3" role="tabpanel" aria-labelledby="pills-3-tab">
                                <!-- Topack -->
                                <section id="topackdataplanningpengemasan"></section>
                            </div>
                            <div class="tab-pane fade show" id="pills-4" role="tabpanel" aria-labelledby="pills-4-tab">
                                <!-- Prepare Pillow -->
                                <section id="pillowdataplanningpengemasan"></section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End -->