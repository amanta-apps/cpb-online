<?php
$plant = $_SESSION['plant'];
$unitcode = $_SESSION['unitcode'];
$productid = $_GET['x'];
$desc = $_GET['y'];
?>
<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/machine.png"> Assign Master of Inspection</h6>
    <hr class="w-50 mb-3">
    <div class="card shadow-lg border-0 mb-1" id="cardcolor">
        <div class="form-group row mb-0">
            <label for="productidassignmic" class="col-sm-2 col-form-label">Product ID</label>
            <div class="col-sm-2">
                <div class="input-group mb-1">
                    <input type="text" class="form-control form-control-sm bg-transparent" placeholder="Product ID" aria-label="Recipient's username" aria-describedby="button-addon2" id="productidassignmic" autocomplete="off" value="<?= $productid ?>" readonly>
                    <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchprodukassignmic"><span><img src=" ../asset/icon/cari.png"></span></button>
                </div>
            </div>
            <label for="createonassignmic" class="col-sm-2 offset-3 text-right">Created On</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" id="createonassignmic" value="<?= date('d/m/Y H:i:s') ?>" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="descassignmic" class="col-sm-2 col-form-label">Desc.</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm bg-transparent" id="descassignmic" maxlength="40" value="<?= $desc ?>" readonly>
            </div>
            <label for="createbyassignmic" class="col-sm-2 offset-1 text-right">Created By</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm" id="createbyassignmic" value="<?= $_SESSION['userid'] ?>" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="micassignmic" class="col-sm-2 col-form-label">Master Insp. Char</label>
            <div class="col-sm-4 mb-1">
                <select id="micassignmic" class="select2">
                    <option value=""></option>
                    <?php
                    $i = 1;
                    $sql = mysqli_query($conn, "SELECT MIC,Descriptions,FullyDesc FROM master_inspection WHERE Plant='$plant' AND UnitCode='$unitcode' AND MIC NOT IN (SELECT MIC FROM assign_mic WHERE Plant='$plant' AND UnitCode='$unitcode' AND ProductID='$productid')");
                    while ($r  = mysqli_fetch_array($sql)) { ?>
                        <option value="<?= $r['MIC'] ?>"><?= $r['MIC'] . ' - ' . $r['Descriptions'] . ' (' . $r['FullyDesc'] . ')' ?></option>
                    <?php
                        $i += 1;
                    }
                    ?>
                </select>
            </div>
        </div>

        <hr>
        <div class="form-group row">
            <div class="col-sm-4">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="simpanassignmic()"><img src="../asset/icon/save.png"> Simpan</button>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload()"><img src="../asset/icon/cancel.png"> Cancel</button>
            </div>
        </div>
        <table id="mytables" class="table table-striped table-sm" style="width:100%;">
            <thead class="bg-dark text-white">
                <tr>
                    <th rowspan="2" class="align-middle text-center" style="width: 15%;">Option</th>
                    <th rowspan="2" class="align-middle text-center">Master of Insp.</th>
                    <th rowspan="2" class="align-middle text-center">Deskripsi</th>
                    <th rowspan="2" class="align-middle text-center">Spesifikasi</th>
                    <th colspan="2" class="align-middle text-center">Type</th>
                    <th rowspan="2" class="align-middle text-center">Created On</th>
                </tr>
                <tr>
                    <th>Qualitatif</th>
                    <th>Quantitatif</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $plant = $_SESSION['plant'];
                $unitcode = $_SESSION['unitcode'];
                $sql = mysqli_query($conn, "SELECT * FROM assign_mic AS A INNER JOIN 
                                                            master_inspection AS B ON A.MIC = B.MIC WHERE A.Plant='$plant' AND A.UnitCode='$unitcode' AND A.ProductID='$productid'");
                while ($row = mysqli_fetch_array($sql)) {
                ?>
                    <tr>
                        <td>
                            <a href="#" class="badge bg-danger text-decoration-none href_transform" onclick="deleteddataassignmic('<?= $row['ProductID'] ?>','<?= $row['MIC'] ?>')">Delete</a>
                        </td>
                        <td><?= $row['MIC'] ?></td>
                        <td><?= $row['Descriptions'] ?></td>
                        <td><?= $row['FullyDesc'] ?></td>
                        <td><?= $row['Qual'] ?></td>
                        <td><?= $row['Quan'] ?></td>
                        <td><?= $row['CreatedOn'] ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Search Product-->
<div class="modal fade" id="searchprodukassignmic" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title  " id="staticBackdropLabel">Search Product</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="mytable" class="table table-striped table-responsive-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 10%;">#</th>
                            <th style="width: 10%;">Product ID</th>
                            <th>Descriptions</th>
                            <th hidden>Total Self Life</th>
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
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="selectproductassignmic('<?= $row['ProductID'] ?>','<?= $row['ProductDescriptions'] ?>')">Select</a>
                                </td>
                                <td><?= $row['ProductID'] ?></td>
                                <td><?= $row['ProductDescriptions'] ?></td>
                                <td hidden><?= $row['TotalSelfLife'] ?></td>
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