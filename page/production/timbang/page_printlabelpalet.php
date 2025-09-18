<?php
$var = $_GET['x'];
$x = explode('*', $var);
$planningnumber = $x[0];
$years = $x[1];
$productid = $x[2];
$batch = $x[3];
$noproses = $x[4];
$prod_desc = Getdata("ProductDescriptions", "mara_product", "ProductID", $productid);
?>
<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/wooden.png"> Print Label Palet</h6>
    <hr class="w-50 mb-3">

    <div class="form-group row mb-0">
        <label for="personalnumberemployee" class="col-sm-2 col-form-label">Planning Number</label>
        <div class="col-sm-2">
            <div class="input-group mb-1">
                <input type="text" class="form-control" placeholder="Planning Number" aria-label="Recipient's username" aria-describedby="button-addon2" id="planningnumberlabelpalet" readonly value="<?= $planningnumber ?>">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchplanningnumberlabelpalet"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
        <label for="yearsanalisaorganoleptis" class="col-sm-2 col-form-label">Years</label>
        <div class="col-sm-1">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="yearsanalisaorganoleptis" readonly value="<?= $years ?>">
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="productlabelpalet" class="col-sm-2 col-form-label">Product ID</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="productlabelpalet" readonly value="<?= $productid ?>">
        </div>
        <label for="batchlabelpalet" class="col-sm-1 col-form-label">Batch</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="batchlabelpalet" readonly value="<?= $batch ?>">
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="deskripsilabelpalet" class="col-sm-2 col-form-label">Description</label>
        <div class="col-sm-5">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="deskripsilabelpalet" readonly value="<?= $prod_desc ?>">
        </div>
    </div>
    <div class="form-group row mb-1">
        <label for="prosesnumberlabelpalet" class="col-sm-2 col-form-label">Proses Number</label>
        <div class="col-sm-2">
            <select id="prosesnumberlabelpalet" class="form-select form-select-sm">
                <?php
                $i = 1;
                for ($i = 1; $i <= 2; $i++) {
                    $selected = '';
                    if ($i == $noproses) {
                        $selected = 'selected';
                    }
                    // if ($noproses == NULL) {
                    //     $selected = "";
                    //     $sel = 'selected';
                    // } else {
                    //     $selected = 'selected';
                    //     $sel = '';
                    // }
                ?>
                    <option value="<?= $i ?>" <?= $selected ?>><?= $i ?></option>
                <?php } ?>
                <!-- <option value="all" <?= $sel ?>>All Proses</option> -->
            </select>

        </div>
    </div>
    <div class="form-group row mb-0">
        <div class="col-sm-4 offset-2">
            <button type="button" class="btn btn-sm btn-outline-success zoom" onclick="prosesviewlabelpalet()"><img src="../asset/icon/submit.png"> Submit</button>
        </div>
    </div>
</div>


<!-- Planning Number-->
<div class="modal fade" id="searchplanningnumberlabelpalet" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">List Planning Number</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="ddisplayplanning0" class="table table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Planing Number</th>
                            <th>Years</th>
                            <th>Product ID</th>
                            <th>Descriptions</th>
                            <th>Batch</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $plant = $_SESSION['plant'];
                        $unitcode = $_SESSION['unitcode'];
                        $sql = mysqli_query($conn, "SELECT DISTINCT PlanningNumber,
                                                                    BatchNumber,
                                                                    Years,
                                                                    ProductID FROM planning_pengolahan_subdetail WHERE Plant='$plant' AND
                                                                                                                        UnitCode='$unitcode'");
                        while ($row = mysqli_fetch_array($sql)) {
                            $prod_desc = Getdata('ProductDescriptions', 'mara_product', 'ProductID', $row['ProductID']);
                        ?>
                            <tr>
                                <td><a href="#" class="badge bg-success href_transform" onclick="prosesselectlabelpalet('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>','<?= $row['ProductID'] ?>','<?= $row['BatchNumber'] ?>','<?= $prod_desc ?>')"><?= $row['PlanningNumber'] ?></a></td>
                                <td><?= $row['Years'] ?></td>
                                <td><?= $row['ProductID'] ?></td>
                                <td style="width: 70%;"><?= $prod_desc ?></td>
                                <td><?= $row['BatchNumber'] ?></td>
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