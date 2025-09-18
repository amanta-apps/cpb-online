<?php
$productid = base64_decode($_GET['v']);
$desc = Getdata('ProductDescriptions', 'mara_product', 'ProductID', $productid);
$sql = "SELECT * FROM tbl_movingstock WHERE Plant='$plant' AND UnitCode='$unitcode' AND ProductID='$productid' AND Zterima='X'";
if ($productid == 'all') {
    $productid = '*';
    $desc = 'All Produk';
    $sql = "SELECT * FROM tbl_movingstock WHERE Plant='$plant' AND UnitCode='$unitcode' AND Zterima='X'";
}

?>
<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/express.png"> Manajemen Stok</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <label for="productidmanajemenstok" class="col-sm-2 col-form-label">Product ID</label>
        <div class="col-sm-2">
            <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm" placeholder="Product ID" aria-label="Recipient's username" aria-describedby="button-addon2" id="productidmanajemenstok" value="<?= $productid ?>">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchprodukmanajemenstok"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
    </div>
    <div class="form-group row mb-5">
        <label for="productdescmanajemenstok" class="col-sm-2 col-form-label"></label>
        <div class="col-sm-4">
            <input type="text" class="form-control form-control-sm" id="productdescmanajemenstok" value="<?= $desc ?>" readonly>
        </div>
    </div>
    <table class="table table-sm w-50 table-bordered">
        <thead class="bg-dark text-white text-center">
            <tr>
                <!-- <th>Plant</th>
                <th>UnitCode</th> -->
                <th></th>
                <th>ProductID</th>
                <th>Desc</th>
                <th>Batch</th>
                <th>No Pallet</th>
                <th>No Proses</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <?php
        $qty = 0;
        $query = mysqli_query($conn, $sql);
        if (mysqli_num_rows($query) <> 0) {
            while ($r = mysqli_fetch_array($query)) { ?>
                <tbody>
                    <tr>
                        <!-- <td><?= $r['Plant'] ?></td>
                    <td><?= $r['UnitCode'] ?></td> -->
                        <td></td>
                        <td><?= $r['ProductID'] ?></td>
                        <td><?= Getdata('ProductDescriptions', 'mara_product', 'ProductID', $r['ProductID']) ?></td>
                        <td><?= $r['BatchNumber'] ?></td>
                        <td class="text-center"><?= $r['NoPallet'] ?></td>
                        <td class="text-center"><?= $r['NoProses'] ?></td>
                        <td><?= $r['Quantity'] . ' ' . $r['Satuan'] ?></td>
                    </tr>
                </tbody>
        <?php
                $qty = $qty + $r['Quantity'];
                $satuan = $r['Satuan'];
            }
        }
        ?>

        <tfoot>
            <tr>
                <td class="fw-bold" colspan="6">Total</td>
                <td class="bg-secondary text-white fw-bold"><?= $qty . ' ' . $satuan ?></td>
            </tr>
        </tfoot>
    </table>
</div>

<!-- Modal Search Product-->
<div class="modal fade" id="searchprodukmanajemenstok" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  " id="staticBackdropLabel">Search Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="dsearchdata" class="table table-striped table-responsive-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 10%;">Option</th>
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
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="submitprodumanajemenstok('<?= $row['ProductID'] ?>')">Select</a>
                                </td>
                                <td><?= $row['ProductID'] ?></td>
                                <td><?= $row['ProductDescriptions'] ?></td>
                                <td hidden><?= $row['TotalSelfLife'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <thead>
                            <th colspan=""><a href="#" class="badge bg-success text-decoration-none" onclick="submitprodumanajemenstok('all')">Select</a></th>
                            <th colspan=3>Tampilkan semua stok produk</th>
                        </thead>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End -->