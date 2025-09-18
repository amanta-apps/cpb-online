<?php
$productid = base64_decode($_GET['q']);
$bets = base64_decode($_GET['r']);
$bets = trim($bets);
$sql = mysqli_query($conn, "SELECT * FROM planning_pengolahan_detail WHERE ProductID='$productid' AND BatchNumber LIKE '%$bets%'");
if (mysqli_num_rows($sql) <> 0) {
    $r = mysqli_fetch_array($sql);
    $query = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE ProductID='$productid' AND BatchNumber = '$bets'");
    $q = mysqli_fetch_array($query);
?>
    <div class="container w-50">
        <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/product.png"> Display Batch</h6>
        <hr class="w-100 mb-3">
        <div class="border-0 mb-0 p-3">
            <div class="form-group row mb-0">
                <label for="personalnumberemployee" class="col-sm-2 col-form-label">Product ID</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm" value="<?= $r['ProductID'] ?>" readonly>
                </div>
                <!-- <label for="personalnumberemployee" class="col-sm-2 col-form-label"></label> -->
                <div class="col-sm-6">
                    <input type="text" class="form-control form-control-sm" value="<?= Getdata('ProductDescriptions', 'mara_product', 'ProductID', $productid) ?>" readonly>
                </div>
            </div>
            <div class="form-group row mb-0">
                <label for="personalnumberemployee" class="col-sm-2 col-form-label">Batch Number</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm" value="<?= $bets ?>" readonly>
                </div>
            </div>
        </div>
        <div class="form-group row mb-0 mt-0" id="cardcolor">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-basicdata" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Basic Data</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-basicdata" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="card mb-3">
                        <div class="border-0 mb-0 p-3">
                            <div class="form-group row mb-0">
                                <label for="personalnumberemployee" class="col-sm-2 col-form-label">Mixing Date</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control form-control-sm" value="<?= beautydate1($r['MixingDate']) ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="personalnumberemployee" class="col-sm-2 col-form-label">Packing Date</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control form-control-sm" value="<?= beautydate1($q['PackingDate']) ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="personalnumberemployee" class="col-sm-2 col-form-label">Expired Date</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control form-control-sm" value="<?= beautydate1($r['ExpiredDate']) ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="personalnumberemployee" class="col-sm-2 col-form-label">Created On</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-sm" value="<?= beautydate2($r['CreatedOn']) ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="personalnumberemployee" class="col-sm-2 col-form-label">Created By</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-sm" value="<?= Getpernr($r['CreatedBy']) ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="personalnumberemployee" class="col-sm-2 col-form-label">Changed On</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-sm" value="<?= beautydate2($r['ChangedOn']) ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="personalnumberemployee" class="col-sm-2 col-form-label">Changed By</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-sm" value="<?= $r['ChangedBy'] ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>