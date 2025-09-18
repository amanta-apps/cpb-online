<?php
$plant = $_SESSION['plant'];
$unitcode = $_SESSION['unitcode'];
$noproses = $_GET['z'];
$planning = $_GET['v'];
$years = $_GET['w'];
$product = $_GET['x'];
$batch = $_GET['y'];
$var = 'hidden';
if ($planning != "") {
    $var = '';
}
$desc = Getdata('ProductDescriptions', 'mara_product', 'ProductID', $product);
?>
<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/scale2.png"> History Timbang</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <label for="personalnumberemployee" class="col-sm-2 col-form-label">Planning Number</label>
        <div class="col-sm-2">
            <div class="input-group mb-1">
                <input type="text" class="form-control" placeholder="Planning Number" aria-label="Recipient's username" aria-describedby="button-addon2" id="planningnumberhistorytimbang" readonly value="<?= $planning ?>">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchplanningnumberhistorytimbang"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
        <label for="inspyearsanalisaorganoleptis" class="col-sm-2 col-form-label">Insp. Lot Years</label>
        <div class="col-sm-1">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="inspyearsanalisaorganoleptis" readonly value="<?= $years ?>">
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
        <div class="col-sm-2">
            <select id="prosesnumberalisaorganoleptis" class="form-select form-select-sm" onchange="changevalueprosesnumberhistorytimbang('<?= $planning ?>','<?= $years ?>','<?= $product ?>','<?= $batch ?>',this.value)">
                <?php
                $i = 1;
                for ($i = 1; $i <= 2; $i++) {
                    $selected = '';
                    if ($i == $noproses) {
                        $selected = 'selected';
                    }
                ?>
                    <option value="<?= $i ?>" <?= $selected ?>><?= $i ?></option>
                <?php } ?>
            </select>

        </div>
    </div>

    <hr class="mb-3 mt-3">
    <table id="drhsuhu" class="table table-sm w-50">
        <thead class="bg-dark text-white fw-bold">
            <tr>
                <td>#</td>
                <td>No Proses</td>
                <td>No Tong</td>
                <td>Berat</td>
                <td>Jam Timbang</td>
                <!-- <td>Nama Timbangan</td>
                    <td>IP Timbangan</td>
                    <td>Port</td> -->
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $berat = 0;
            $satuan = 'Kg';
            $sql = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND 
                                                                                        UnitCode='$unitcode' AND
                                                                                        PlanningNumber='$planning' AND
                                                                                        Years='$years' AND
                                                                                        BatchNumber='$batch' AND
                                                                                        NoProses='$noproses'");
            while ($r = mysqli_fetch_array($sql)) {
                $berat = $berat + $r['Berat'];
                $satuan = $r['Satuan'];
                $iptimbangan = GetdataV(
                    'AddressOf',
                    'tbl_hasiltimbang_header',
                    'Plant',
                    $plant,
                    'UnitCode',
                    $unitcode,
                    'PlanningNumber',
                    $r["PlanningNumber"],
                    'Years',
                    $r["Years"],
                    'Items',
                    $r["Items"],
                    'ProductID',
                    $r["ProductID"],
                );
                $query = mysqli_query($conn, "SELECT * FROM mapping_timbangan WHERE Plant='$plant' AND UnitCode='$unitcode' AND AddressOf='$iptimbangan'");
                if (mysqli_num_rows($query) != 0) {
                    $q = mysqli_fetch_array($query);
                }
            ?>
                <tr>
                    <td><a href="#" class="badge bg-white text-dark zoom text-decoration-none" onclick="previewdatatimbang('<?= $r['PlanningNumber'] ?>',
                                                                                                                                        '<?= $r['Years'] ?>',
                                                                                                                                        '<?= $r['Items'] ?>',
                                                                                                                                        '<?= $r['ProductID'] ?>',
                                                                                                                                        '<?= $r['BatchNumber'] ?>',
                                                                                                                                        '<?= $r['NoProses'] ?>',
                                                                                                                                        '<?= $r['NoTong'] ?>',
                                                                                                                                        '<?= $r['Berat'] ?>')"><img src="../asset/icon/preview.png">Preview</a>
                    </td>
                    <td><?= $r['NoProses'] ?></td>
                    <td><?= $r['NoTong'] ?></td>
                    <td><?= $r['Berat'] . ' ' . $r['Satuan'] ?></td>
                    <td><?= $r['EnterOn'] ?></td>
                    <!-- <td><?= $q['NamaTimbangan'] ?></td>
                        <td><?= $iptimbangan ?></td>
                        <td><?= $q['PortOf'] ?></td> -->
                </tr>
            <?php
                $i += 1;
            }
            ?>
        </tbody>
    </table>
    <?php
    if ($berat <> 0) { ?>
        <table class="table table-sm w-50">
            <tr>
                <th class="fs-6 text-end" id="totalberathistorytimbang">Total: <a href="#" onclick="previewlabelpalet()" title="Print Label Timbang"><?= $berat . " " . $satuan ?></a> </th>
            </tr>
        </table>
    <?php }
    ?>

</div>
</div>

<!-- Planning Number-->
<div class="modal fade" id="searchplanningnumberhistorytimbang" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                        $sql = mysqli_query($conn, "SELECT * FROM planning_pengolahan_subdetail WHERE Plant='$plant' AND
                                                                                                UnitCode='$unitcode' AND
                                                                                                NoProses=1 AND
                                                                                                Stats06='X'");
                        while ($row = mysqli_fetch_array($sql)) {

                        ?>
                            <tr>
                                <td><a href="#" class="badge bg-success href_transform" onclick="prosesselecthistorytimbang('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>','<?= $row['ProductID'] ?>','<?= $row['BatchNumber'] ?>')"><?= $row['PlanningNumber'] ?></a></td>
                                <td><?= $row['Years'] ?></td>
                                <td><?= $row['ProductID'] ?></td>
                                <td style="width: 70%;"><?= Getdata('ProductDescriptions', 'mara_product', 'ProductID', $row['ProductID']) ?></td>
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