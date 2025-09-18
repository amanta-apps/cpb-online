<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/product.png"> DAFTAR PRODUK</h6>
    <hr class="w-50 mb-3">
    <div class="card shadow-lg border-0 mb-1" id="cardcolor">
        <div class="form-group row mb-0">
            <label for="idprodukdataproduk" class="col-sm-2 col-form-label">Product ID</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm text-uppercase" id="idprodukdataproduk">
            </div>
            <label for="createondatabarang" class="col-sm-2 offset-3">Created On</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" id="createondatabarang" value="<?= date('d/m/Y H:i:s') ?>" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="deskripsidataproduk" class="col-sm-2 col-form-label">Deskripsi</label>
            <div class="col-sm-5">
                <input type="text" class="form-control form-control-sm text-uppercase" id="deskripsidataproduk">
            </div>
            <label for="createondatabarang" class="col-sm-2">Created By</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm" id="createbydataproduk" value="<?= $_SESSION['userid'] ?>" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="standardrolldataproduk" class="col-sm-2 col-form-label">Standard Roll</label>
            <div class="col-sm-1">
                <input type="number" min="1" value="1" class="form-control form-control-sm" id="standardrolldataproduk">
            </div>
            <div class="col-sm-1">
                <input type="text" class="form-control form-control-sm" value="Roll" readonly>
            </div>
            <label class="col-sm-1 col-form-label text-center">=</label>
            <div class="col-sm-1">
                <input type="number" min="1" class="form-control form-control-sm" id="standardrollkonversidataproduk">
            </div>
            <div class="col-sm-1">
                <input type="text" class="form-control form-control-sm" value="SCH" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="standarddusdataproduk" class="col-sm-2 col-form-label">Standard Dus/Pill</label>
            <div class="col-sm-1">
                <input type="number" min="1" value="1" class="form-control form-control-sm" id="standarddusdataproduk">
            </div>
            <div class="col-sm-1">
                <input type="text" class="form-control form-control-sm" value="Dus" readonly>
            </div>
            <label class="col-sm-1 col-form-label text-center">=</label>
            <div class="col-sm-1">
                <input type="number" min="1" class="form-control form-control-sm" id="standarduskonversidataproduk">
            </div>
            <div class="col-sm-1">
                <input type="text" class="form-control form-control-sm" value="SCH" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="standardcartondataproduk" class="col-sm-2 col-form-label">Standard Carton</label>
            <div class="col-sm-1">
                <input type="number" min="1" value="1" class="form-control form-control-sm" id="standardcartondataproduk">
            </div>
            <div class="col-sm-1">
                <input type="text" class="form-control form-control-sm" value="Car" readonly>
            </div>
            <label class="col-sm-1 col-form-label text-center">=</label>
            <div class="col-sm-1">
                <input type="number" min="1" class="form-control form-control-sm" id="standarcarkonversidataproduk">
            </div>
            <div class="col-sm-1">
                <input type="text" class="form-control form-control-sm" value="SCH" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="standardberatprimerdataproduk" class="col-sm-2 col-form-label">Standard Berat Primer</label>
            <div class="col-sm-1">
                <input type="number" min="0" value="0" class="form-control form-control-sm text-uppercase" id="standardberatprimerdataproduk">
            </div>
            <div class="col-sm-1">
                <input type="text" class="form-control form-control-sm" value="Gram" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="totalselflifedataproduk" class="col-sm-2 col-form-label">Total Self Life</label>
            <div class="col-sm-1">
                <input type="number" min="1" value="1" class="form-control form-control-sm" id="totalselflifedataproduk">
            </div>
            <div class="col-sm-1">
                <input type="text" class="form-control form-control-sm" value="Month" readonly>
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="bobotrangetimbangfromdataproduk" class="col-sm-2 col-form-label">Bobot Range Timbang</label>
            <div class="col-sm-1">
                <input type="number" min="1" value="1" class="form-control form-control-sm" id="bobotrangetimbangfromdataproduk">
            </div>
            <div class="col-sm-1">
                <input type="text" class="form-control form-control-sm" value="Gram" readonly>
            </div>
            <label class="col-sm-1 col-form-label text-center">Hingga</label>
            <div class="col-sm-1">
                <input type="number" min="1" class="form-control form-control-sm" id="bobotrangetimbangtodataproduk">
            </div>
            <div class="col-sm-1">
                <input type="text" class="form-control form-control-sm" value="Gram" readonly>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-12">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="simpanproduk()"><img src="../asset/icon/save.png"> Save</button>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload()"><img src="../asset/icon/cancel.png"> Cancel</button>
                <label class="ms-5 fw-bold"><sup class="text-black">NB:</sup> SR = Standard Roll, SD = Standard Dus, SC = Standard Carton, SBM = Standard Berat Primer</label>
            </div>
        </div>
    </div>
    <table id="mytables" class="table table-striped table-sm" style="width:100%">
        <thead class="bg-dark text-white">
            <tr>
                <th style="width: 15%;">Option</th>
                <th>Product ID</th>
                <th>Product Description</th>
                <th>SR (Roll)</th>
                <th>SR (Sch)</th>
                <th>SD</th>
                <th>SD (Sch)</th>
                <th>SC</th>
                <th>SC (Sch)</th>
                <th>SBM</th>
                <th>Self Life (M)</th>
                <th>Bobot</th>
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
                        <a href="#" class="badge bg-warning text-decoration-none href_transform" onclick="changedataproduk('<?= $row['ProductID'] ?>')"> Change</a>
                        <a href="#" class="badge bg-danger text-decoration-none href_transform" onclick="deleteddataproduk('<?= $row['ProductID'] ?>')"> Delete</a>
                    </td>
                    <td><?= $row['ProductID'] ?></td>
                    <td><?= $row['ProductDescriptions'] ?></td>
                    <td><?= $row['StandardRoll'] ?></td>
                    <td><?= $row['StandardRollKonversi'] ?></td>
                    <td><?= $row['StandardDus'] ?></td>
                    <td><?= $row['StandardDusKonversi'] ?></td>
                    <td><?= $row['StandardCar'] ?></td>
                    <td><?= $row['StandardCarKonversi'] ?></td>
                    <td><?= $row['StandardBeratPrimer'] ?></td>
                    <td><?= $row['TotalSelfLife'] ?></td>
                    <td><?= $row['BobotTimbang'] ?></td>
                    <td><?= $row['CreatedBy'] ?></td>
                    <td><?= $row['CreatedOn'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>