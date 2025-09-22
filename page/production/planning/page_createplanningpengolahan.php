<?php

use Mpdf\Tag\Code;

$shift = '';
$addreviewer = '';
$createdfor = $_SESSION['personnelnumber'] . ' - ' . Getdata('EmployeeName', 'pa001', 'PersonnelNumber', $_SESSION['personnelnumber']);
$show_button = 0;
$sql = mysqli_query($conn, "SELECT Shift,Addreviewer,CreatedFor FROM planning_pengolahan_header WHERE Plant='$_SESSION[plant]' AND 
                                                                                UnitCode='$_SESSION[unitcode]' AND 
                                                                                (PlanningNumber='' or PlanningNumber is null) AND
                                                                                 CreatedBy='$_SESSION[userid]'");
if (mysqli_num_rows($sql) != 0) {
    $r = mysqli_fetch_array($sql);
    $shift = $r['Shift'];
    if ($r['Addreviewer'] != '') {
        $addreviewer = $r['Addreviewer'] . ' - ' . Getdata('EmployeeName', 'pa001', 'PersonnelNumber', $r['Addreviewer']);
    }
    $createdfor = $r['CreatedFor'] . ' - ' . Getdata('EmployeeName', 'pa001', 'PersonnelNumber', $r['CreatedFor']);
    $show_button = 1;
}
$query = mysqli_query($conn, "SELECT * FROM planning_pengolahan_detail WHERE Plant='$_SESSION[plant]' AND 
                                                                                UnitCode='$_SESSION[unitcode]' AND CreatedBy='$_SESSION[userid]'");
if (mysqli_num_rows($query) == 0) {
    mysqli_query($conn, "DELETE FROM planning_pengolahan_header WHERE Plant='$_SESSION[plant]' AND
                                                                            PlanningNumber='' AND 
                                                                            UnitCode='$_SESSION[unitcode]' AND 
                                                                            CreatedBy='$_SESSION[userid]'");
}
$a = base64_encode(date('dmY His'));
$filename = "../asset/data/data.txt";
$file_contents = file_get_contents($filename);
$file = fopen($filename, "r");
?>

<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/createplanning.png"> Create Planning - Pengolahan</h6>
    <hr class="w-100 mb-3">
    <div class="border-0 mb-0">
        <div class="form-group row mb-0">
            <label for="productidcreateplanningpengolahan" class="col-sm-2 col-form-label">Product ID</label>
            <div class="col-sm-2">
                <div class="input-group mb-1">
                    <input type="text" class="form-control form-control-sm bg-transparent" placeholder="Product ID" aria-label="Recipient's username" aria-describedby="button-addon2" id="productidcreateplanningpengolahan" onkeypress="submitproductcreateplanningpengolahan()" readonly>
                    <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchprodukcreateplanningpengolahan"><span><img src="../asset/icon/cari.png"></span></button>
                </div>
            </div>
            <label for="pernrcreateplanningpengolahan" class="col-sm-2 offset-3 col-form-label">Dibuat Oleh</label>
            <div class="col-sm-3">
                <div class="input-group mb-1">
                    <input type="text" class="form-control form-control-sm" placeholder="Dibuat Oleh" aria-label="Recipient's username" aria-describedby="button-addon2" id="pernrcreateplanningpengolahan" value="<?= $createdfor ?>">
                    <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchpernrcreateplanningpengolahan"><span><img src="../asset/icon/cari.png"> </span></button>
                </div>
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-sm-4 offset-2">
                <input type="text" class="form-control form-control-sm bg-transparent border-0 fw-bold" id="descriptionproductcreateplanningpengolahan" disabled>
            </div>
            <label for="shiftcreateplanningpengolahan" class="col-sm-3 offset-1 col-form-label">Shift</label>
            <div class="col-sm-2">
                <div class="input-group mb-1">
                    <input type="text" class="form-control form-control-sm" placeholder="Shift" aria-label="Recipient's username" aria-describedby="button-addon2" id="shiftcreateplanningpengolahan" onkeypress="submitshiftcreateplanningpengolahan()" value="<?= $shift ?>">
                    <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchshiftcreateplanningpengolahan"><span><img src="../asset/icon/cari.png"> </span></button>
                </div>
            </div>
        </div>
        <div class="form-group row mb-0" id="cardcolor">
            <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn-sm text-dark fw-bold active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Basic Data</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn-sm text-dark fw-bold" id="pills-bahan-tab" data-bs-toggle="pill" data-bs-target="#pills-bahan" type="button" role="tab" aria-controls="pills-bahan" aria-selected="true">List Bahan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn-sm text-dark fw-bold" id="pills-approval-tab" data-bs-toggle="pill" data-bs-target="#pills-approval" type="button" role="tab" aria-controls="pills-approval" aria-selected="true">Approval</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="form-group row mb-0">
                        <label for="batchcreateplanningpengolahan" class="col-sm-2 col-form-label">Batch</label>
                        <div class="col-sm-10 mb-1">
                            <div class="input-group">
                                <input name="tags" class="form-control form-control-sm text-uppercase" id="batchcreateplanningpengolahan">
                                <button type="button" class="btn btn-sm btn-outline-secondary" style="font-size: 6pt !important;" onclick="konfirmbatchauto($('#productidcreateplanningpengolahan').val(),$('#jumlahresepcreateplanningpengolahan').val())"><img src="../asset/icon/matic.png"> Auto</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" style="font-size: 6pt !important;" onclick="$('#batchcreateplanningpengolahan').val('')"><img src="../asset/img/delete.png"> Clear</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="expireddatecreateplanningpengolahan" class="col-sm-2 col-form-label">Expired Date</label>
                        <div class="col-sm-2">
                            <input type="date" id="expireddatecreateplanningpengolahan" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" value="<?= date('Y-m-d'); ?>" readonly>
                        </div>
                        <label for="tglmixingcreateplanningpengolahan" class="col-sm-2 offset-4 col-form-label">Tgl Mixing</label>
                        <div class="col-sm-2">
                            <input type="date" id="tglmixingcreateplanningpengolahan" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" value="<?= date('Y-m-d') ?>" onchange="getkadaluarsapengolahan(this.value)" onkeyup="getkadaluarsapengolahan(this.value)">
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="jumlahresepcreateplanningpengolahan" class="col-sm-2 col-form-label">Jumlah Resep</label>
                        <div class="col-sm-1">
                            <input type="number" id="jumlahresepcreateplanningpengolahan" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" min="1" value="1">
                        </div>
                        <label for="kodemesinmixingcreateplanningpengolahan" class="col-sm-2 offset-5 col-form-label">No Mesin Mixing</label>
                        <div class="col-sm-2">
                            <div class="input-group mb-1">
                                <input type="text" class="form-control form-control-sm" placeholder="Code" aria-label="Recipient's username" aria-describedby="button-addon2" id="kodemesinmixingcreateplanningpengolahan">
                                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchmesinmixingcreateplanningpengolahan"><span><img src="../asset/icon/cari.png"> </span></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0 offset-2" hidden>
                        <label for="nohoppercreateplanning" class="col-sm-2 col-form-label">No Hopper</label>
                        <div class="col-sm-2">
                            <input type="text" id="nohoppercreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                        <label for="descriptionhoppercreateplanning" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-4">
                            <input type="text" id="descriptionhoppercreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                        <label for="noruanghoppercreateplanning" class="col-sm-2 col-form-label" hidden>No Ruang Hopper</label>
                        <div class="col-sm-2" hidden>
                            <input type="text" id="noruanghoppercreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                        <label for="namaruanghoppercreateplanning" class="col-sm-2 col-form-label" hidden>Nama Ruang</label>
                        <div class="col-sm-4" hidden>
                            <input type="text" id="namaruanghoppercreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0 offset-2" hidden>
                        <label for="nomesintopackcreateplanning" class="col-sm-2 col-form-label">No Topack</label>
                        <div class="col-sm-2">
                            <input type="text" id="nomesintopackcreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                        <label for="descriptiontopackcreateplanning" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-4">
                            <input type="text" id="descriptiontopackcreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                        <label for="noruangtopackcreateplanning" class="col-sm-2 col-form-label" hidden>No Ruang Topack</label>
                        <div class="col-sm-2" hidden>
                            <input type="text" id="noruangtopackcreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                        <label for="namruangtopackcreateplanning" class="col-sm-2 col-form-label" hidden>Nama Ruang</label>
                        <div class="col-sm-4" hidden>
                            <input type="text" id="namruangtopackcreateplanning" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" readonly>
                        </div>
                    </div>
                    <?php
                    $plant = $_SESSION['plant'];
                    $unitcode = $_SESSION['unitcode'];
                    $userid = $_SESSION['userid'];
                    $sql = mysqli_query($conn, "SELECT * FROM planning_pengolahan_detail WHERE Plant='$plant' AND 
                                                                                                UnitCode='$unitcode' AND
                                                                                                (PlanningNumber = '' or PlanningNumber is null) AND 
                                                                                                CreatedBy='$userid'"); ?>
                    <table class="table table-sm mt-3 w-100" id="mytabled">
                        <thead class="bg-dark text-white">
                            <tr>
                                <td>#</td>
                                <td>Hari, Tanggal</td>
                                <td style="width: 50%;">Produk</td>
                                <td>Mesin</td>
                                <td>Jml Resep</td>
                                <td>ED/BC</td>
                            </tr>
                        </thead>
                        <?php if (mysqli_num_rows($sql) != 0) { ?>
                            <tbody>
                                <?php
                                $i = 1;
                                while ($r = mysqli_fetch_array($sql)) {
                                    $batch_show = explode(',', $r['BatchNumber']);
                                ?>
                                    <tr>
                                        <td>
                                            <a href="#" class="badge bg-white text-dark zoom text-decoration-none" onclick="viewlistbahan('<?= $r['ReffCode'] ?>')"><img src="../asset/icon/glasses20.png"> List Bahan</a>
                                            <a href="#" class="badge bg-white text-dark zoom text-decoration-none" onclick="viewaddreproses('<?= $r['ProductID'] ?>')"><img src="../asset/icon/plus.png"> Add Reproses</a>
                                            <a href="#" class="badge bg-white text-dark href_transform" onclick="deletedatacreateplanningpengolahan('<?= $r['Items'] ?>','<?= $r['ProductID'] ?>','<?= $r['CreatedBy'] ?>','<?= $r['Years'] ?>','<?= $r['ReffCode'] ?>')"><img src="../asset/img/delete.png"><?= $i ?></a>
                                        </td>
                                        <td><?= getdayformat(date('w', strtotime($r['CreatedOn']))) . ', ' . date('d/m/Y', strtotime($r['CreatedOn'])) ?></td>
                                        <td><?= Getdata('ProductDescriptions', 'mara_product', 'ProductID', $r['ProductID']) ?></td>
                                        <td><?= $r['ResourceIDMix'] ?></td>
                                        <td class="text-center"><?= $r['JumlahResep'] ?></td>
                                        <td><?= 'ED. ' . date('M Y', strtotime($r['ExpiredDate'])) . '/' . $batch_show[0] . '-' . end($batch_show) ?></td>
                                    </tr>
                                <?php
                                    $i++;
                                } ?>
                            </tbody>
                        <?php  } ?>
                    </table>
                    <hr class="mt-3">
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <?php
                            if ($show_button == 1) { ?>
                                <button type="button" class="btn btn-outline-success btn-sm" id="selesaicreateplanningpengolahan" onclick="selesaicreateplanningpengolahan()"><img src="../asset/icon/save.png"> Save Planning</button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-outline-success btn-sm" id="selesaicreateplanningpengolahan" onclick="selesaicreateplanningpengolahan()" hidden><img src="../asset/icon/save.png"> Save Planning</button>
                            <?php }
                            ?>
                        </div>
                        <div class="col-sm-9 text-end">
                            <button type="button" class="btn btn-outline-success btn-sm text-end" onclick="simpancreateplanningpengolahan()"><img src="../asset/icon/save.png"> Submit</button>
                            <button type="button" class="btn btn-outline-danger btn-sm text-end" onclick="location.reload()"><img src="../asset/icon/cancel.png"> Cancel</button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="pills-bahan" role="tabpanel" aria-labelledby="pills-bahan-tab">
                    <div class="form-group row mb-1">
                        <label for="koderefflistbahancreatepengolahan" class="col-sm-2 col-form-label">Reff.</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control form-control-sm border-0 border-bottom text-uppercase fw-bold" id="koderefflistbahancreatepengolahan" value="<?= $a ?>" readonly>
                        </div>
                        <div class="col-sm-5 text-end">
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchlistbahancreateplanningpengolahan" hidden><span><img src="../asset/icon/kamus.png"> Reff. Planning Plan</span></button>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="kodebahanlistbahancreatepengolahan" class="col-sm-2 col-form-label">Kode Bahan</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm border-0 border-bottom text-uppercase" id="kodebahanlistbahancreatepengolahan" placeholder="Kode Bahan" onkeypress="validasikodebahan(event)" onkeyup="validasijmlteoritis(this.value)">
                        </div>
                        <label for="proseslistbahancreatepengolahan" class="col-sm-2 col-form-label">Proses</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control form-control-sm border-0 border-bottom" id="proseslistbahancreatepengolahan" value="1" min="1" max="2" onchange="prosescreatepengolahan(this.value)">
                        </div>
                        <label for="urutanproseslistbahancreatepengolahan" class="col-sm-2 col-form-label">Urutan Proses</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control form-control-sm border-0 border-bottom" id="urutanproseslistbahancreatepengolahan" min="1" value="1" readonly>
                        </div>

                    </div>
                    <div class="form-group row mb-1">
                        <label for="jmlteoritislistbahancreatepengolahan" class="col-sm-2 col-form-label">Jml Teoritis</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control form-control-sm border-0 border-bottom" id="jmlteoritislistbahancreatepengolahan" value="1" min="1">
                        </div>
                        <label for="jmlkonsumsilistbahancreatepengolahan" class="col-sm-2 offset-1 col-form-label">Jml Konsumsi</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control form-control-sm border-0 border-bottom" id="jmlkonsumsilistbahancreatepengolahan" min="0.5" value="1" step="0.5">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-sm-2 offset-2">
                            <button type="button" onclick="tambahkodebahancreatepengolahan()" class="btn btn-sm btn-outline-primary"><img src="../asset/icon/plus.png"> Tambah</button>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-sm-6">
                            <li class="mb-1 fw-bold">Proses 1</li>
                            <section id="listbahan1createplanningpengolahan">
                                <table class="table table-sm w-100">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Kode Bahan</th>
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                        </tr>
                                    </thead>
                                </table>
                            </section>
                        </div>
                        <div class="col-sm-6">
                            <li class="mb-1 fw-bold">Proses 2</li>
                            <section id="listbahan2createplanningpengolahan">
                                <table class="table table-sm w-100">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Kode Bahan</th>
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                        </tr>
                                    </thead>
                                </table>
                            </section>
                        </div>
                    </div>
                    <div>
                        <li class="mb-1 fw-bold">List Bahan</li>
                        <section id="listbahancreateplanningpengolahan">
                            <table class="table table-sm w-25">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th>Kode Bahan</th>
                                        <th>Jml Teoritis</th>
                                    </tr>
                                </thead>
                            </table>
                        </section>
                    </div>
                </div>
                <div class="tab-pane fade show" id="pills-approval" role="tabpanel" aria-labelledby="pills-approval-tab">
                    <section id="tbl_reviewerplanning">
                        <div class="form-group row mb-0" <?= getconfigreviewer('planning_pengolahan', 'Addreviewer') ?>>
                            <label for="revieweraddcreateplanningpengolahan" class="col-sm-2 col-form-label">Tambah Approval <sup style="font-size: 7pt;">(optional)</sup></label>
                            <div class="col-sm-4">
                                <div class="input-group mb-1">
                                    <input type="text" class="form-control form-control-sm" placeholder="Pernr" aria-label="Recipient's username" aria-describedby="button-addon2" id="revieweraddcreateplanningpengolahan" value="<?= $addreviewer ?>">
                                    <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchpernr2createplanningpengolahan"><span><img src="../asset/icon/cari.png"> </span></button>
                                </div>
                            </div>
                        </div>

                        <section <?= getconfigreviewer('planning_pengolahan', 'ShowReviewer') ?>>
                            <?php
                            $plant = $_SESSION['plant'];
                            $unitcode = $_SESSION['unitcode'];
                            $sql = mysqli_query($conn, "SELECT * FROM reviewer_person WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                                            AND TypeTransaction ='planning_pengolahan' ORDER BY Levels ASC"); ?>
                            <table class="table table-sm mt-3 w-100">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <td style="width: 5%;">No</td>
                                        <td style="width: 30%;">Approval</td>
                                        <td>Jabatan</td>
                                    </tr>
                                </thead>
                                <?php if (mysqli_num_rows($sql) != 0) { ?>
                                    <tbody>
                                        <?php
                                        $l = 0;
                                        while ($r = mysqli_fetch_array($sql)) { ?>
                                            <tr>
                                                <td><input type="checkbox" id="reviewer<?= $l ?>" class="form-check-input" checked disabled> <?= $r['Levels'] ?><input type="text" class="form-control form-control-sm" id="levelscreateplanningpengolahan<?= $l ?>" value="<?= $r['Levels'] ?>" hidden></td>
                                                <td><?= $r['PersonnelNumber'] . ' - ' . ucwords(strtolower($r['EmployeeName'])) ?></td>
                                                <td><?= $r['PositionID'] ?></td>
                                            </tr>
                                        <?php
                                            $l += 1;
                                        } ?>
                                    </tbody>
                                <?php  } ?>
                            </table>
                            <div class="form-group row mb-0">
                                <label for="revieweraddcreateplanningpengolahan" class="col-sm-2 col-form-label">Total Reviewer</label>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-sm-1">
                                    <input type="text" class="form-control form-control-sm" id="totalreviewercreateplanningpengolahan" value="<?= $l ?>" readonly>
                                </div>
                            </div>
                        </section>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Search Product-->
<div class="modal fade" id="searchprodukcreateplanningpengolahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Search Product</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="mytable_produk" class="table table-striped table-responsive-sm" style="width:100%;">
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
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="selectproductcreateplanningpengolahan('<?= $row['ProductID'] ?>','<?= $row['ProductDescriptions'] ?>','<?= $row['TotalSelfLife'] ?>')">Select</a>
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

<!-- Modal Search Shift-->
<div class="modal fade" id="searchshiftcreateplanningpengolahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title  " id="staticBackdropLabel">Search Shift</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="mytable_shift" class="table table-striped table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 10%;">Option</th>
                            <th style="width: 10%;">Shift ID</th>
                            <th>Descriptions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, 'SELECT * FROM shifts');
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="$('#shiftcreateplanningpengolahan').val('<?= $row['ShiftID'] ?>'),$('#searchshiftcreateplanningpengolahan').modal('hide')">Select</a>
                                </td>
                                <td><?= $row['ShiftID'] ?></td>
                                <td><?= $row['ShiftDescriptions'] ?></td>
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

<!-- Modal Search Mixing Mesin-->
<div class="modal fade" id="searchmesinmixingcreateplanningpengolahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Search Machine Mixing</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="mytable_mesin" class="table table-striped table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 10%;">Option</th>
                            <th style="width: 10%;">Resource ID</th>
                            <th style="width: 80%;">Descriptions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, 'SELECT * FROM crhd_mixing');
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="$('#kodemesinmixingcreateplanningpengolahan').val('<?= $row['ResourceID'] ?>'),$('#searchmesinmixingcreateplanningpengolahan').modal('hide')">Select</a>
                                </td>
                                <td><?= $row['ResourceID'] ?></td>
                                <td><?= $row['ResourceDescriptions1'] ?></td>
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

<!-- Modal Search Pernr 1-->
<div class="modal fade" id="searchpernrcreateplanningpengolahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Search Employee Name</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="mytable_pernr" class="table table-striped table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 10%;">Option</th>
                            <th style="width: 10%;">PersonnelNumber</th>
                            <th style="width: 80%;">EmployeeName</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, 'SELECT * FROM pa001');
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="$('#pernrcreateplanningpengolahan').val('<?= $row['PersonnelNumber'] ?> - <?= ucwords(strtolower($row['EmployeeName'])) ?>'),$('#searchpernrcreateplanningpengolahan').modal('hide')">Select</a>
                                </td>
                                <td><?= $row['PersonnelNumber'] ?></td>
                                <td><?= $row['EmployeeName'] ?></td>
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

<!-- Modal Search Pernr 2-->
<div class="modal fade" id="searchpernr2createplanningpengolahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Search Employee Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="dsearchdata6" class="table table-striped table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 10%;">Option</th>
                            <th style="width: 10%;">PersonnelNumber</th>
                            <th style="width: 80%;">EmployeeName</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, 'SELECT * FROM usr02 AS A INNER JOIN pa001 AS B ON A.PersonnelNumber=B.PersonnelNumber');
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="$('#revieweraddcreateplanningpengolahan').val('<?= $row['PersonnelNumber'] ?> - <?= ucwords(strtolower($row['EmployeeName'])) ?>'),$('#searchpernr2createplanningpengolahan').modal('hide')">Select</a>
                                </td>
                                <td><?= $row['PersonnelNumber'] ?></td>
                                <td><?= $row['EmployeeName'] ?></td>
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

<!-- Modal View Reproses-->
<div class="modal fade" id="searchaddreprosescreateplanningpengolahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Bahan Untuk Reproses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-sm w-100 mb-5">
                    <thead class="fw-bold">
                        <tr>
                            <th rowspan="2" style="width: 5%;" class="align-middle">No</th>
                            <th rowspan="2" class="align-middle">Product ID</th>
                            <th rowspan="2" class="align-middle" style="width: 20%;">Asal</th>
                            <th rowspan="2" class="align-middle">ED/BC</th>
                            <th rowspan="2" class="align-middle">Bets Reproses</th>
                            <th rowspan="2" class="align-middle">Berat</th>
                            <th colspan="3" class="text-center">Detail</th>
                            <th rowspan="2" class="align-middle"></th>
                        </tr>
                        <tr>
                            <th>Bulk</th>
                            <th>@</th>
                            <th>Sisa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width: 5%;">#</td>
                            <td><input type="text" id="productidreprosescreateplanningpengolahan" class="form-control form-control-sm" readonly></td>
                            <td style="width: 20%;"><input type="text" id="asalreprosescreateplanningpengolahan" class="form-control form-control-sm" placeholder="Asal"></td>
                            <td><input type="text" id="edbcreprosescreateplanningpengolahan" maxlength="8" class="form-control form-control-sm" placeholder="ED/BC"></td>
                            <td><input type="text" id="betsreprosesreprosescreateplanningpengolahan" maxlength="8" class="form-control form-control-sm" placeholder="Bets Repro."></td>
                            <td><input type="number" id="beratreprosescreateplanningpengolahan" class="form-control form-control-sm" value="0"></td>
                            <td><input type="number" id="bulkreprosescreateplanningpengolahan" class="form-control form-control-sm" value="0"></td>
                            <td><input type="number" id="berat2reprosescreateplanningpengolahan" class="form-control form-control-sm" value="0"></td>
                            <td><input type="number" id="sisareprosescreateplanningpengolahan" class="form-control form-control-sm" value="0"></td>
                            <td><button type="button" class="btn btn-primary btn-sm text-end" onclick="simpanreprosescreateplanningpengolahan()"><img src="../asset/icon/save.png"> Submit</button></td>
                        </tr>
                    </tbody>
                </table>
                <?php
                $sql = mysqli_query($conn, "SELECT * FROM table_bahanreproses WHERE PlanningNumber='' AND CreatedBy='$_SESSION[userid]'");
                if (mysqli_num_rows($sql) != 0) { ?>
                    <table class="table table-sm w-100" border="3">
                        <thead>
                            <tr>
                                <th rowspan="2" style="width: 5%;" class="align-middle">No</th>
                                <th rowspan="2" class="align-middle">Product ID</th>
                                <th rowspan="2" class="align-middle" style="width: 20%;">Asal</th>
                                <th rowspan="2" class="align-middle">ED/BC</th>
                                <th rowspan="2" class="align-middle">Bets Reproses</th>
                                <th rowspan="2" class="align-middle">Berat</th>
                                <th colspan="3" class="text-center">Detail</th>
                                <th rowspan="2" class="align-middle"></th>
                            </tr>
                            <tr>
                                <th>Bulk</th>
                                <th>@</th>
                                <th>Sisa</th>
                            </tr>
                        </thead>
                        <tbody class="border-0">
                            <?php
                            $i = 1;
                            while ($r = mysqli_fetch_array($sql)) { ?>
                                <tr>
                                    <td style="width: 5%;"><a href="#" class="badge bg-white text-dark href_transform" onclick="deletedatareprosescreateplanningpengolahan('<?= $r['ProductID'] ?>','<?= $r['BatchAsal'] ?>','<?= $r['BatchReproses'] ?>','<?= $r['CreatedBy'] ?>')"><img src="../asset/img/delete.png"><?= $i ?></a></td>
                                    <td><input type="text" class="form-control form-control-sm" value="<?= $r["ProductID"] ?>" readonly></td>
                                    <td style="width: 20%;"><input type="text" class="form-control form-control-sm" value="<?= $r["Asal"] ?>" readonly></td>
                                    <td><input type="text" class="form-control form-control-sm" value="<?= $r["BatchAsal"] ?>" readonly></td>
                                    <td><input type="text" class="form-control form-control-sm" value="<?= $r["BatchReproses"] ?>" readonly></td>
                                    <td><input type="number" class="form-control form-control-sm" min="0" value="<?= $r["Berat"] ?>" readonly></td>
                                    <td><input type="number" class="form-control form-control-sm" min="0" value="<?= $r["Bulk"] ?>" readonly></td>
                                    <td><input type="number" class="form-control form-control-sm" min="0" value="<?= $r["BeratUmum"] ?>" readonly></td>
                                    <td><input type="number" class="form-control form-control-sm" min="0" value="<?= $r["BeratKhusus"] ?>" readonly></td>
                                    <td></td>
                                </tr>
                            <?php
                                $i += 1;
                            }
                            ?>
                        </tbody>
                    </table>
                <?php
                } ?>
            </div>
        </div>
    </div>
</div>
<!-- End -->

<!-- Modal View List Bahan-->
<div class="modal fade" id="viewlistbahancreateplanningpengolahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">View List Bahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group row mb-0">
                    <label for="modalproductidplanningpengolahan" class="col-sm-2 col-form-label">Product ID</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm fw-bold" id="modalproductidplanningpengolahan" readonly>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="modalreffcodeplanningpengolahan" class="col-sm-2 col-form-label">Reff Code</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm fw-bold" id="modalreffcodeplanningpengolahan" readonly>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-sm-6">
                        <li class="mb-1 fw-bold">Proses 1</li>
                        <section id="listbahan1modalcreateplanningpengolahan">
                        </section>
                    </div>
                    <div class="col-sm-6">
                        <li class="mb-1 fw-bold">Proses 2</li>
                        <section id="listbahan2modalcreateplanningpengolahan">
                        </section>
                    </div>
                </div>
                <div>
                    <li class="mb-1 fw-bold">List Bahan</li>
                    <section id="listbahanmodalcreateplanningpengolahan">
                    </section>
                </div>
                <div class="form-group row mb-0 text-end">
                    <label for="modalcreateonplanningpengolahan" class="col-sm-2 offset-7 col-form-label">Created On</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm fw-bold" id="modalcreateonplanningpengolahan" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0 text-end">
                    <label for="modalcreatebyplanningpengolahan" class="col-sm-2 offset-7 col-form-label">Created By</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm fw-bold" id="modalcreatebyplanningpengolahan" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End -->

<!-- Reff. List bahan on Planning -->
<div class="modal fade" id="searchlistbahancreateplanningpengolahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Refferensi Planning</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="kembalirefflistbahancreateplanningpengolahan()"></button>
            </div>
            <div class="modal-body">
                <section id="tablerefflistbahan">
                    <table id="mytables" class="table table-striped table-responsive-sm mb-5" style="width:100%;">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th style="width: 10%;">Option</th>
                                <th>Planning Number</th>
                                <th>Years</th>
                                <th>Product ID</th>
                                <th>Bets</th>
                                <th>ReffCode</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $sql = mysqli_query($conn, "SELECT * FROM planning_pengolahan_detail
                                                            WHERE Plant='$plant' AND UnitCode='$unitcode' AND PlanningNumber !='' AND ReffCode !='' ORDER BY CreatedOn DESC LIMIT 10 ");
                            while ($row = mysqli_fetch_array($sql)) {
                                $batch_show = explode(',', $row['BatchNumber']);
                                $query = mysqli_query($conn, "SELECT * FROM mapping_preparemixing WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        ReffCode='$row[ReffCode]'");
                                if (mysqli_num_rows($query) == 0) {
                                    continue;
                                }
                            ?>
                                <tr>
                                    <td>
                                        <a href="#" class="badge bg-success text-decoration-none" onclick="viewlistbahan2('<?= $row['ReffCode'] ?>','<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>','<?= $batch_show[0] . ' - ' . end($batch_show) ?>','<?= $row['ProductID'] ?>')">View Detail</a>
                                    </td>
                                    <td><?= $row['PlanningNumber'] ?></td>
                                    <td><?= $row['Years'] ?></td>
                                    <td><?= $row['ProductID'] ?></td>
                                    <td><?= $row['BatchNumber'] ?></td>
                                    <td><?= $row['ReffCode'] ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </section>
                <section id="refflistbahan" hidden>
                    <div class="form-group row mb-0">
                        <label for="modalplanningnumberlistbahanplanningpengolahan" class="col-sm-2 col-form-label">Plan. Number</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm fw-bold" id="modalplanningnumberlistbahanplanningpengolahan" readonly>
                        </div>
                        <div class="col-sm-4 offset-4 text-end">
                            <button type="button" class="btn btn-sm btn-outline-success" id="modalcopylistbahanplanningpengolahan" onclick="salinrefflistbahancreateplanningpengolahan()"><img src="../asset/icon/copy.png"> Salin List Bahan</button>
                            <button type="button" class="btn btn-sm btn-outline-danger" id="modalcopylistbahanplanningpengolahan" onclick="kembalirefflistbahancreateplanningpengolahan()">Kembali</button>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="modalyearslistbahanplanningpengolahan" class="col-sm-2 col-form-label">Years</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm fw-bold" id="modalyearslistbahanplanningpengolahan" readonly>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row mb-0">
                        <label for="modalproductidlistbahanplanningpengolahan" class="col-sm-2 col-form-label">Product ID</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm fw-bold" id="modalproductidlistbahanplanningpengolahan" readonly>
                        </div>
                        <label for="modalbetslistbahanplanningpengolahan" class="col-sm-1 col-form-label">Bets</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control form-control-sm fw-bold" id="modalbetslistbahanplanningpengolahan" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="modalreffcodelistbahanplanningpengolahan" class="col-sm-2 col-form-label">Reff Code</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-sm fw-bold" id="modalreffcodelistbahanplanningpengolahan" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-sm-6">
                            <li class="mb-1 fw-bold">Proses 1</li>
                            <section id="refflistbahan1modalcreateplanningpengolahan">
                            </section>
                        </div>
                        <div class="col-sm-6">
                            <li class="mb-1 fw-bold">Proses 2</li>
                            <section id="refflistbahan2modalcreateplanningpengolahan">
                            </section>
                        </div>
                    </div>
                    <div>
                        <li class="mb-1 fw-bold">List Bahan</li>
                        <section id="refflistbahanmodalcreateplanningpengolahan">
                        </section>
                    </div>
                    <div class="form-group row mb-0 text-end">
                        <label for="modalcreateonreffplanningpengolahan" class="col-sm-2 offset-7 col-form-label">Created On</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm fw-bold" id="modalcreateonreffplanningpengolahan" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0 text-end">
                        <label for="modalcreatebyreffplanningpengolahan" class="col-sm-2 offset-7 col-form-label">Created By</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm fw-bold" id="modalcreatebyreffplanningpengolahan" readonly>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<!-- End -->

<!-- Modal Search Mixing Mesin-->
<div class="modal fade" id="konfirmasilastbatch" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" id="modalproductidbetsotomatis"></h6>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <div class="form-group row mb-0">
                    <label for="modalbetsotomatis" class="col-sm-4 col-form-label">Bets</label>
                    <div class="col-sm-6">
                        <div class="input-group mb-1">
                            <input type="text" class="form-control form-control-sm bg-transparent" placeholder="Bets" aria-label="Recipient's username" aria-describedby="button-addon2" id="modalbetsotomatis" onkeypress="submitproductcreateplanningpengolahan()">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchbetsmodalbetsotomatis"><span><img src="../asset/icon/cari.png"></span></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="modaltotalresepsotomatis" class="col-sm-4 col-form-label">Total Resep</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control form-control-sm" id="modaltotalresepsotomatis" min="1" value="1">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-success" onclick="batchauto($('#productidcreateplanningpengolahan').val())">Lanjut</button>
                <button class="btn btn-sm btn-danger" data-bs-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>
<!-- End -->
<script src="../asset/js/tagify.min.js"></script>
<script src="../asset/js/tagify.polyfills.min.js"></script>
<script src="../asset/js/myjavascript.js"></script>
<script>
    var input = document.querySelector('input[name=tags]');
    new Tagify(input)

    function cekmissingkodebahan(kodebahan) {
        $('#kodebahanlistbahancreatepengolahan').val(kodebahan)
        validasijmlteoritis(kodebahan)

        // ---Auto Scroll TOP
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
        // ---
    }
</script>