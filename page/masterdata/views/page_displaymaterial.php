<?php
$productid = base64_decode($_GET['m']);
$sql = mysqli_query($conn, "SELECT * FROM mara_product WHERE ProductID='$productid'");
if (mysqli_num_rows($sql) <> 0) {
    $r = mysqli_fetch_array($sql);
    $bobot = explode("-", $r['BobotTimbang']);
?>
    <div class="container w-75">
        <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/product.png"> Display Produk Master</h6>
        <hr class="w-100 mb-3">
        <div class="form-group row mb-0 mt-5" id="cardcolor">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-basicdata" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Basic Data</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-systems" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Systems</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-basicdata" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="card mb-3">
                        <div class="border-0 mb-0 p-3">
                            <div class="form-group row mb-0">
                                <label for="personalnumberemployee" class="col-sm-2 offset-8 col-form-label">Plant</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control form-control-sm" value="<?= $plant ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="personalnumberemployee" class="col-sm-2 col-form-label">Product ID</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control form-control-sm" value="<?= $r['ProductID'] ?>" readonly>
                                </div>
                                <label for="personalnumberemployee" class="col-sm-2 offset-4 col-form-label">Unit Code</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control form-control-sm" value="<?= $unitcode ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="personalnumberemployee" class="col-sm-2 col-form-label">Product Desc</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-sm" value="<?= Getdata('ProductDescriptions', 'mara_product', 'ProductID', $productid) ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="standardrolldataproduk" class="col-sm-2 col-form-label">Standard Roll</label>
                                <div class="col-sm-1">
                                    <input type="number" min="1" value="<?= $r['StandardRoll'] ?>" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control form-control-sm" value="Roll" readonly>
                                </div>
                                <label class="col-sm-1 col-form-label text-center">=</label>
                                <div class="col-sm-2">
                                    <input type="number" min="1" class="form-control form-control-sm" value="<?= $r['StandardRollKonversi'] ?>" readonly>
                                </div>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control form-control-sm" value="SCH" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="standarddusdataproduk" class="col-sm-2 col-form-label">Standard Dus/Pill</label>
                                <div class="col-sm-1">
                                    <input type="number" min="1" value="<?= $r['StandardDus'] ?>" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control form-control-sm" value="Dus" readonly>
                                </div>
                                <label class="col-sm-1 col-form-label text-center">=</label>
                                <div class="col-sm-2">
                                    <input type="number" min="1" value="<?= $r['StandardDusKonversi'] ?>" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control form-control-sm" value="SCH" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="standardcartondataproduk" class="col-sm-2 col-form-label">Standard Carton</label>
                                <div class="col-sm-1">
                                    <input type="number" min="1" value="<?= $r['StandardCar'] ?>" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control form-control-sm" value="Car" readonly>
                                </div>
                                <label class="col-sm-1 col-form-label text-center">=</label>
                                <div class="col-sm-2">
                                    <input type="number" min="1" value="<?= $r['StandardCarKonversi'] ?>" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control form-control-sm" value="SCH" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="standardberatprimerdataproduk" class="col-sm-2 col-form-label">Standard Berat Primer</label>
                                <div class="col-sm-1">
                                    <input type="number" min="0" value="<?= $r['StandardBeratPrimer'] ?>" class="form-control form-control-sm text-uppercase" readonly>
                                </div>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control form-control-sm" value="Gram" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="totalselflifedataproduk" class="col-sm-2 col-form-label">Total Self Life</label>
                                <div class="col-sm-1">
                                    <input type="number" min="1" value="<?= $r['TotalSelfLife'] ?>" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control form-control-sm" value="Month" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="bobotrangetimbangfromdataproduk" class="col-sm-2 col-form-label">Bobot Range Timbang</label>
                                <div class="col-sm-1">
                                    <input type="number" min="1" value="<?= $bobot[0] ?>" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control form-control-sm" value="Gram" readonly>
                                </div>
                                <label class="col-sm-1 col-form-label text-center">Hingga</label>
                                <div class="col-sm-2">
                                    <input type="number" min="1" value="<?= $bobot[1] ?>" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control form-control-sm" value="Gram" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="nav-systems" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="card mb-3">
                        <div class="border-0 mb-0 p-3">
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