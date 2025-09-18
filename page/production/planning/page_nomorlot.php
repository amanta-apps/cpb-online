<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/barcode.png"> Nomor Lot</h6>
    <hr class="w-50 mb-3">
    <div class="card shadow-lg border-0 mb-1" id="cardcolor">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group row mb-0">
                    <label for="nomorlotuploadnomorlot" class="col-sm-4 col-form-label">Nomor Lot</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="nomorlotuploadnomorlot">
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-sm-8 offset-4">
                        <hr>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="kodesuppliernomorlot" class="col-sm-4 col-form-label">Kode Supplier</label>
                    <div class="col-sm-4">
                        <div class="input-group mb-1">
                            <input type="text" class="form-control form-control-sm" placeholder="Supplier ID" aria-label="Recipient's username" aria-describedby="button-addon2" id="kodesuppliernomorlot">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchkodesuppliernomorlot"><span><img src="../asset/icon/cari.png"></span></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="namasuppliernomorlot" class="col-sm-4 col-form-label">Nama Supplier</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="namasuppliernomorlot">
                    </div>
                </div>
                <div class="form-group row mb-1" id="hiddenketerangannomorlot" hidden>
                    <label for="keterangannomorlot" class="col-sm-4 col-form-label">Keterangan</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" name="" id="keterangannomorlot" rows=3 readonly></textarea>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="joinnomorlot" class="col-sm-4 col-form-label">Join</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="joinnomorlot">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group row mb-0">
                    <label for="uploaddatanomorlot" class="col-sm-4 col-form-label">Upload Data <sup style="font-size: 5pt;">(Optional)</sup></label>
                    <div class="col-sm-8">
                        <input type="file" class="form-control form-control-sm" id="uploaddatanomorlot">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-2 offset-2 mt-2">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="simpandatanomorlot()"><img src="../asset/icon/save.png"> Simpan</button>
            </div>
        </div>
    </div>

    <table id="dmenu" class="table table-striped table-sm" style="width:100%">
        <thead class="bg-dark text-white">
            <tr>
                <th></th>
                <th>Nomor Lot</th>
                <th>Kode Supplier</th>
                <th>Nama Supplier</th>
                <th>Keterangan</th>
                <th>Join</th>
                <th>Status</th>
                <th>Created On</th>
                <?php
                if ($_SESSION['personnelnumber'] == '90003560') { ?>
                    <th>Act</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $sql = mysqli_query($conn, "SELECT * FROM data_lot WHERE Plant='$plant' AND UnitCode='$unitcode'");
            while ($row = mysqli_fetch_array($sql)) {
            ?>
                <tr>
                    <td>
                        <a href="#" class="badge text-dark zoom text-decoration-none bg-transparent" onclick="message(1)"><img src="../asset/icon/print.png"> Print</a>
                    </td>
                    <td class="fw-bold"><?= $row['NomorLot'] ?></td>
                    <td><?= $row['KodeSupplier'] ?></td>
                    <td><?= $row['NamaSupplier'] ?></td>
                    <td><?= $row['Keterangan'] ?></td>
                    <td><?= $row['Joins'] ?></td>
                    <td><?= $row['StatsX'] ?></td>
                    <td><?= $row['CreatedOn'] ?></td>
                    <?php
                    if ($_SESSION['personnelnumber'] == '90003560') { ?>
                        <td>
                            <a href="#" class="badge bg-danger text-decoration-none href_transform" onclick="deletedatanomorlot('<?= $row['NomorLot'] ?>')"><img src="../asset/img/delete.png"> Delete</a>
                        </td>
                    <?php } ?>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal Search Supplier-->
<div class="modal fade" id="searchkodesuppliernomorlot" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6>List Supplier</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="dsearchdata4" class="table table-striped table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 10%;">Kode</th>
                            <th style="width: 30%;">Nama</th>
                            <th>Ketarangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, "SELECT KodeSupplier,NamaSupplier,Keterangan FROM data_supplier WHERE Plant='$plant' AND UnitCode='$unitcode'");
                        while ($row = mysqli_fetch_array($sql)) { ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none href_transform" onclick="selectsuppliernomorlot('<?= $row['KodeSupplier'] ?>','<?= $row['NamaSupplier'] ?>','<?= $row['Keterangan'] ?>')"><?= $row['KodeSupplier'] ?></a>
                                </td>
                                <td class="fw-bold"><?= $row['NamaSupplier'] ?></td>
                                <td><?= $row['Keterangan'] ?></td>
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