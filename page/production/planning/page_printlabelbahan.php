<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/printing.png"> Input Parameter - Print Label Bahan</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <label for="produkidprintlabelbahan" class="col-sm-2 col-form-label">Produk</label>
        <div class="col-sm-2">
            <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm" placeholder="Product ID" aria-label="Recipient's username" aria-describedby="button-addon2" id="produkidprintlabelbahan">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchprodukprintlabelbahan"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
    </div>
    <div class="form-group row mb-1">
        <label for="produkdescprintlabelbahan" class="col-sm-2 col-form-label"></label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm" id="produkdescprintlabelbahan" readonly>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="kodebahanprintlabelbahan" class="col-sm-2 col-form-label">Kode Bahan</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm text-uppercase" id="kodebahanprintlabelbahan" onkeypress="cekkodebahan(event)" onkeyup="cekkodebahan(this.value)">
        </div>
        <div class="col-sm-2" id="iconprintlabelbahan" hidden>
            <img src="../asset/icon/thick_green.png"> <span style="font-size: 6pt;"><u>Kode Bahan Terdaftar</u></span>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="identitasbahan1printlabelbahan" class="col-sm-2 col-form-label">Identitas Bahan</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm text-uppercase" id="identitasbahan1printlabelbahan" placeholder="Ident. 1">
        </div>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm text-uppercase" id="identitasbahan2printlabelbahan" placeholder="Ident. 2">
        </div>
    </div>

    <div class="form-group row mb-0">
        <label for="batchbahanprintlabelbahan" class="col-sm-2 col-form-label">Batch Bahan</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm text-uppercase" id="batchbahanprintlabelbahan">
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="nomorkantongprintlabelbahan" class="col-sm-2 col-form-label">Nomor & Total Kantong</label>
        <div class="col-sm-2">
            <input type="number" class="form-control form-control-sm" id="nomorkantongprintlabelbahan" min="1" value="1">
        </div>
        <div class="col-sm-2">
            <input type="number" class="form-control form-control-sm" id="totalkantongprintlabelbahan" min="1" value="1">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-12 offset-sm-2">
            <button type="button" class="btn btn-outline-success btn-sm" onclick="simpanprintlabelbahan()"><img src="../asset/icon/submit.png"> Submit</button>
        </div>
    </div>
</div>

<!-- Modal Search Product-->
<div class="modal fade" id="searchmodalreasonprint" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Cetak Label Manual</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-10 mb-1">
                        <textarea class="form-control form-control-sm" name="" id="reasonprintlabelmanual" cols="10" rows="5" placeholder="Alasan Print Label Manual">-</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="showprintlabelbahan()"><img src="../asset/icon/print.png"> Simpan & Cetak Label</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End -->

<!-- Modal Search Product-->
<div class="modal fade" id="searchprodukprintlabelbahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="selectproductprintlabelbahan('<?= $row['ProductID'] ?>','<?= $row['ProductDescriptions'] ?>')">Select</a>
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