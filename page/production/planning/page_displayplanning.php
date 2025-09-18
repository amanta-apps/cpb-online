<?php
$variabel = $_GET['v'];
$x = explode("*", $variabel);
$productid = $x[0];
$batch = $x[1];
$packingdatefrom = $x[2];
$packingdateto = $x[3];
$mixingdatefrom = $x[4];
$mixingdateto = $x[5];
$max_hint = $x[6];
?>
<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/display.png"> DISPLAY PLANNING</h6>
    <hr class="w-50 mb-3">
    <div class="table-responsive" id="">
        <table id="ddisplayplanning" class="table table-sm" style="width:100%;">
            <thead class="bg-dark text-white">
                <tr>
                    <th>Planing Number</th>
                    <th>Years</th>
                    <th>Product ID</th>
                    <th>Shift ID</th>
                    <th>Packing Date</th>
                    <th>Resource ID</th>
                    <th>Batch</th>
                    <th>ED</th>
                    <th>Resource ID Mix</th>
                    <th>Mixing Date</th>
                    <th>Qty</th>
                    <th>Uom</th>
                    <th>Process</th>
                    <th>Tong</th>
                    <!-- <th>Approval</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $plant = $_SESSION['plant'];
                $unitcode = $_SESSION['unitcode'];
                $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header
                WHERE Plant='$plant' AND UnitCode='$unitcode' AND (PackingDate >= '" . $packingdatefrom . "' AND PackingDate <= '" . $packingdateto . "') AND
                (MixingDate >= '" . $mixingdatefrom . "' AND MixingDate <= '" . $mixingdateto . "') AND                                                                 
                ProductID LIKE '%" . $productid . "%' AND BatchNumber LIKE '%" . $batch . "%' LIMIT " . $max_hint . "");
                while ($row = mysqli_fetch_array($sql)) {
                ?>
                    <tr>
                        <td>
                            <?php
                            if ($row['Approval'] == 'X') { ?>
                                <a href="#" class="badge bg-success href_transform" id="planningnumberdisplayplanning" onclick="prosesdisplayplanning('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>')"><?= $row['PlanningNumber'] ?></a>
                            <?php } else { ?>
                                <a href="#" class="badge bg-danger href_transform" id="planningnumberdisplayplanning" onclick="prosesdisplayplanning('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>')"><?= $row['PlanningNumber'] ?></a>
                            <?php
                            } ?>
                        </td>
                        <td><?= $row['Years'] ?></td>
                        <td><?= $row['ProductID'] ?></td>
                        <td><?= $row['ShiftID'] ?></td>
                        <td><?= $row['PackingDate'] ?></td>
                        <td><?= $row['ResourceID'] ?></td>
                        <td><?= $row['BatchNumber'] ?></td>
                        <td><?= $row['ExpiredDate'] ?></td>
                        <td><?= $row['ResourceIDMix'] ?></td>
                        <td><?= $row['MixingDate'] ?></td>
                        <td><?= $row['Quantity'] ?></td>
                        <td><?= $row['UnitOfMeasures'] ?></td>
                        <td><?= $row['ProcessNumber'] ?></td>
                        <td><?= $row['ContainerNumber'] ?></td>
                        <!-- <td>
                            <?php
                            if ($row['Approval'] == 'X') { ?>
                                <a href="#" class="badge bg-secondary href_transform" hidden><img src="../asset/icon/accept.png"> Accept</a>
                            <?php } else { ?>
                                <a href="#" class="badge bg-secondary href_transform" id="planningnumberdisplayplanning" onclick="prosesapprovalplanning('<?= $row['PlanningNumber'] ?>')"><img src="../asset/icon/accept.png"> Accept</a>
                            <?php } ?>
                        </td> -->
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal Display Planning-->
<div class="modal fade" id="modaldisplayplanning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Display Planning</h5>
                <button type="button" class="btn btn-sm btn-dark href_transform" data-bs-dismiss="modal" aria-label="Close"><img src="../asset/icon/back.png"> Back</button>
            </div>
            <div class="modal-body">
                <div class="border-0 mb-0">
                    <div class="form-group row mb-0">
                        <label for="planningnumberdisplayplanning" class="col-sm-2 col-form-label">Planning Number</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="numberdisplayplanning" readonly>
                        </div>
                        <label for="planningnumberdisplayplanning" class="col-sm-2 offset-4 col-form-label">Years</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="yearsdisplayplanning" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="productiddisplayplanning" class="col-sm-2 col-form-label">Product ID</label>
                        <div class="col-sm-2">
                            <div class="input-group mb-0">
                                <input type="text" class="form-control form-control-sm" placeholder="Product ID" aria-label="Recipient's username" aria-describedby="button-addon2" id="productiddisplayplanning">
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-target="#listprodukdisplayplanning" data-bs-toggle="modal" data-bs-dismiss="modal"><span><img src="../asset/icon/cari.png"></span></button>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0 fw-bold" id="descriptionproductdisplayplanning" value="Susu Jahe" readonly>
                        </div>
                        <label for="createonisplayplanning" class="col-sm-2">Created On</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="createonisplayplanning" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="batchdisplayplanning" class="col-sm-2 form-label">Batch</label>
                        <div class="col-sm-2">
                            <input type="text" id="batchdisplayplanning" class="form-control form-control-sm text-uppercase">
                        </div>
                        <label for="createbydisplayplanning" class="col-sm-2 offset-4">Created By</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="createbydisplayplanning" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="expireddatedisplayplanning" class="col-sm-2 form-label">Expired Date</label>
                        <div class="col-sm-2">
                            <input type="date" id="expireddatedisplayplanning" class="form-control form-control-sm">
                        </div>
                        <label for="changedondisplayplanning" class="col-sm-2 offset-4">Changed On</label>
                        <div class="col-sm-2">
                            <input type="text" id="changedondisplayplanning" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="kodemesindisplayplanning" class="col-sm-2 col-form-label">Shift</label>
                        <div class="col-sm-2">
                            <div class="input-group mb-0">
                                <input type="text" class="form-control form-control-sm" placeholder="Machine" aria-label="Recipient's username" aria-describedby="button-addon2" id="shiftdisplayplanning">
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#listshiftdisplayplanning" data-bs-toggle="modal" data-bs-dismiss="modal"><span><img src="../asset/icon/cari.png"></span></button>
                            </div>
                        </div>
                        <label for="changedbydisplayplanning" class="col-sm-2 offset-4">Changed By</label>
                        <div class="col-sm-2">
                            <input type="text" id="changedbydisplayplanning" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="kodemesindisplayplanning" class="col-sm-2 col-form-label">Kode Mesin</label>
                        <div class="col-sm-2">
                            <div class="input-group mb-0">
                                <input type="text" class="form-control form-control-sm" placeholder="Machine" aria-label="Recipient's username" aria-describedby="button-addon2" id="kodemesindisplayplanning">
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#listmesindisplayplanning" data-bs-toggle="modal" data-bs-dismiss="modal"><span><img src="../asset/icon/cari.png"></span></button>
                            </div>
                        </div>
                        <label for="tglkemasdisplayplanning" class="col-sm-2">Tgl Kemas</label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control form-control-sm" id="tglkemasdisplayplanning">
                        </div>
                        <label for="statusapprovaldisplayplanning" class="col-sm-2">Status</label>
                        <div class="col-sm-2">
                            <input type="text" id="statusapprovaldisplayplanning" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="kodemesinmixingdisplayplanning" class="col-sm-2">Kode Mesin Mixing</label>
                        <div class="col-sm-2">
                            <div class="input-group mb-0">
                                <input type="text" class="form-control form-control-sm" placeholder="Mixing" aria-label="Recipient's username" aria-describedby="button-addon2" id="kodemesinmixingdisplayplanning">
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#listmixingdisplayplanning" data-bs-toggle="modal" data-bs-dismiss="modal" s><span><img src="../asset/icon/cari.png"></span></button>
                            </div>
                        </div>
                        <label for="tglmixingdisplayplanning" class="col-sm-2 form-label">Tgl Mixing</label>
                        <div class="col-sm-2">
                            <input type="date" id="tglmixingdisplayplanning" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="qtydisplayplanning" class="col-sm-2">Qty</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control form-control-sm" id="qtydisplayplanning" min="1">
                        </div>
                        <div class="col-sm-1">
                            <input type="text" id="uomdisplayplanning" class="form-control form-control-sm bg-transparent fw-bold border-0" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="prosesnumberdisplayplanning" class="col-sm-2">Process Number</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control form-control-sm" id="prosesnumberdisplayplanning" min="1">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="notongdisplayplanning" class="col-sm-2">Total Tong</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control form-control-sm" id="notongdisplayplanning" min="1">
                        </div>
                    </div>
                    <div class="form-group row">
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

<!-- List Produk -->
<div class="modal fade" id="listprodukdisplayplanning" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel2">Product List</h5>
                <button type="button" class="btn btn-sm btn-dark href_transform" data-bs-target="#modaldisplayplanning" data-bs-toggle="modal" data-bs-dismiss="modal" aria-label="Close"><img src="../asset/icon/back.png"> Back</button>
            </div>
            <div class="modal-body">
                <table id="dproduct" class="table table-striped table-sm" style="width:100%">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 5%;">Option</th>
                            <th>Product ID</th>
                            <th>Product Description</th>
                            <th>Standard Roll</th>
                            <th>Standard Berat Primer</th>
                            <th>Created By</th>
                            <th>Created On</th>
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
                                    <a href="#" class="badge bg-success text-decoration-none href_transform" onclick="submitproductdisplayplanning('<?= $row['ProductID'] ?>','<?= $row['ProductDescriptions'] ?>')"> Select</a>
                                </td>
                                <td><?= $row['ProductID'] ?></td>
                                <td><?= $row['ProductDescriptions'] ?></td>
                                <td><?= $row['StandardRoll'] ?></td>
                                <td><?= $row['StandardBeratPrimer'] ?></td>
                                <td><?= $row['CreatedBy'] ?></td>
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

<!-- List Mesin -->
<div class="modal fade" id="listmesindisplayplanning" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel2">Machine List</h5>
                <button type="button" class="btn btn-sm btn-dark href_transform" data-bs-target="#modaldisplayplanning" data-bs-toggle="modal" data-bs-dismiss="modal" aria-label="Close"><img src="../asset/icon/back.png"> Back</button>
            </div>
            <div class="modal-body">
                <table id="dmainresources" class="table table-striped table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 5%;">Option</th>
                            <th>Resource ID</th>
                            <th>Resource Description I</th>
                            <th>Resource Description II</th>
                            <th>Primary Resource ID</th>
                            <th>Secondary Resource ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $sql = mysqli_query($conn, 'SELECT * FROM crhd');
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="submitmachinedisplayplanning('<?= $row['ResourceID'] ?>')">Select</a>
                                </td>
                                <td><?= $row['ResourceID'] ?></td>
                                <td><?= $row['ResourceDescriptions1'] ?></td>
                                <td><?= $row['ResourceDescriptions2'] ?></td>
                                <td><?= $row['PrimaryResourceID'] ?></td>
                                <td><?= $row['SecondaryResourceID'] ?></td>
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

<!-- List Mixing -->
<div class="modal fade" id="listmixingdisplayplanning" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel2">Mixing List</h5>
                <button type="button" class="btn btn-sm btn-dark href_transform" data-bs-target="#modaldisplayplanning" data-bs-toggle="modal" data-bs-dismiss="modal" aria-label="Close"><img src="../asset/icon/back.png"> Back</button>
            </div>
            <div class="modal-body">
                <table id="dmainresources" class="table table-striped table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 5%;">Option</th>
                            <th>ResourceID</th>
                            <th>Descriptions</th>
                            <th>Merk</th>
                            <th>NoInventaris</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $sql = mysqli_query($conn, 'SELECT * FROM crhd_mixing');
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="submitmixingdisplayplanning('<?= $row['ResourceID'] ?>')">Select</a>
                                </td>
                                <td><?= $row['ResourceID'] ?></td>
                                <td><?= $row['ResourceDescriptions1'] ?></td>
                                <td><?= $row['Merk'] ?></td>
                                <td><?= $row['NoInventaris'] ?></td>
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

<!-- List Shift -->
<div class="modal fade" id="listshiftdisplayplanning" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel2">Shift List</h5>
                <button type="button" class="btn btn-sm btn-dark href_transform" data-bs-target="#modaldisplayplanning" data-bs-toggle="modal" data-bs-dismiss="modal"><img src="../asset/icon/back.png"> Back</button>
            </div>
            <div class="modal-body">
                <table id="dshift" class="table table-striped table-sm" style="width:100%">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 5%;">Option</th>
                            <th>Shift ID</th>
                            <th>Shift Description</th>
                            <th>Range Time ID</th>
                            <th>Created By</th>
                            <th>Created On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $sql = mysqli_query($conn, 'SELECT * FROM shifts');
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none href_transform" onclick="submitshiftdisplayplanning('<?= $row['ShiftID'] ?>')">Select</a>
                                </td>
                                <td><?= $row['ShiftID'] ?></td>
                                <td><?= $row['ShiftDescriptions'] ?></td>
                                <td><?= $row['RangeTimeID'] ?></td>
                                <td><?= $row['CreatedBy'] ?></td>
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