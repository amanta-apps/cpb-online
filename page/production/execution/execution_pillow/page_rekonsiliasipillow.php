<?php
$rangehasil = Getdata("Nilai", "qc_characteristic", "KodeProses", "RK01");
$uom = Getdata("UnitOfMeasures", "qc_characteristic", "KodeProses", "RK01");
?>
<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/proses.png"> Reconciliation Pillow Pack</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <label for="personalnumberemployee" class="col-sm-2 col-form-label">Planning Number</label>
        <div class="col-sm-2">
            <div class="input-group mb-4">
                <input type="text" class="form-control" placeholder="Planning Number" aria-label="Recipient's username" aria-describedby="button-addon2" id="planningnumberrekonpillow">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchplanningnumberrekonpillow"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
    </div>
    <div class="accordion" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                    Detail Planning Number
                </button>
            </h2>
            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                <div class="accordion-body">
                    <div class="form-group row mb-0">
                        <label for="setplanningnumberrekonpillow" class="col-sm-2 col-form-label fw-bold">Planning Number</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="setplanningnumberrekonpillow" readonly>
                        </div>
                        <label for="tanggalkemasrekonpillow" class="col-sm-2 offset-4 col-form-label">Tanggal Kemas</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="tanggalkemasrekonpillow" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="productidrekonpillow" class="col-sm-2 col-form-label">Product ID</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="productidrekonpillow" readonly>
                        </div>
                        <label for="shiftidrekonpillow" class="col-sm-2 offset-4 col-form-label">Shift ID</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="shiftidrekonpillow" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="productidrekonpillow" class="col-sm-2 col-form-label">Product Description</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="productdescriptionrekonpillow" readonly>
                        </div>
                        <label for="edrekonpillow" class="col-sm-2 offset-4 col-form-label">Expired Date</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="edrekonpillow" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="batchrekonpillow" class="col-sm-2 col-form-label">Batch</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="batchrekonpillow" readonly>
                        </div>
                        <label for="tglmixingrekonpillow" class="col-sm-2 offset-4 col-form-label">Tanggal Mixing</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="tglmixingrekonpillow" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="nomesinrekonpillow" class="col-sm-2 col-form-label">No Mesin</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="nomesinrekonpillow" readonly>
                        </div>
                        <label for="yearsrekonpillow" class="col-sm-2 offset-4 col-form-label">Years</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="yearsrekonpillow" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="mixingrekonpillow" class="col-sm-2 col-form-label">Mesin Mixing</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="mixingrekonpillow" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="qtyrekonpillow" class="col-sm-2 col-form-label">Quantity</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="qtyrekonpillow" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="prosesnumberrekonpillow" class="col-sm-2 col-form-label">Process Number</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="prosesnumberrekonpillow" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                    Data
                </button>
            </h2>
            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
                <div class="accordion-body">
                    <div class="form-group row mb-0">
                        <label for="hasilpengemasanrekonsiliasipillow" class="col-sm-2 col-form-label">Hasil Pengemasan</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control form-control-sm" id="hasilpengemasanrekonsiliasipillow" min="0" value="0" onchange="autohasilnyata()" onkeyup="autohasilnyata()">
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Car" readonly>
                        </div>
                        <div class="col-sm-2 offset-5">
                            <button type="button" class="btn btn-dark btn-sm href_transform" id="btn_downtimerekonsiliasipillow" onclick="downtimerekonpillow('pillowpack')"><img src="../asset/icon/downtime.png"> Downtime</button>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="countermesinrekonsiliasipillow" class="col-sm-2 col-form-label">Counter Mesin</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control form-control-sm" id="countermesinrekonsiliasipillow" min="0" value="0">
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Rtg" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="lithoterpakairekonsiliasipillow" class="col-sm-2 col-form-label fw-bold">Jumlah Kemasan Terpakai</label>
                        <!-- <div class="col-sm-2">
                            <input type="number" min="0" value="0" class="form-control form-control-sm" id="lithoterpakairekonsiliasipillow" value="0">
                        </div> -->
                    </div>

                    <div class="form-group row mb-1">
                        <div class="col-sm-2">
                            <input class="form-control border-0 bg-transparent" type="text" id="dusrekonpillow" value="Dus" readonly>
                        </div>
                        <div class="col-sm-2">
                            <input type="number" min="0" value="0" class="form-control form-control-sm" id="qtydusrekonpillow">
                        </div>
                        <div class="col-sm-2">
                            <input class="form-control border-0 bg-transparent" type="text" id="hangerrekonpillow" value="Hanger" readonly>
                        </div>
                        <div class="col-sm-2">
                            <input type="number" min="0" value="0" class="form-control form-control-sm" id="qtyhangerrekonpillow">
                        </div>
                        <div class="col-sm-2">
                            <input class="form-control border-0 bg-transparent" type="text" id="boxrekonpillow" value="Box" readonly>
                        </div>
                        <div class="col-sm-2">
                            <input type="number" min="0" value="0" class="form-control form-control-sm" id="qtyboxrekonpillow">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <div class="col-sm-2">
                            <input class="form-control border-0 bg-transparent" type="text" id="brosurrekonpillow" value="Brosur" readonly>
                        </div>
                        <div class="col-sm-2">
                            <input type="number" min="0" value="0" class="form-control form-control-sm" id="qtybrosurrekonpillow">
                        </div>
                        <div class="col-sm-2">
                            <input class="form-control border-0 bg-transparent" type="text" id="stikerrekonpillow" value="Stiker" readonly>
                        </div>
                        <div class="col-sm-2">
                            <input type="number" min="0" value="0" class="form-control form-control-sm" id="qtystikerrekonpillow">
                        </div>
                        <div class="col-sm-2">
                            <input class="form-control border-0 bg-transparent" type="text" id="plastikrekonpillow" value="Plastik" readonly>
                        </div>
                        <div class="col-sm-2">
                            <input type="number" min="0" value="0" class="form-control form-control-sm" id="qtyplastikrekonpillow">
                        </div>
                    </div>
                    <div class="form-group row mb-1 ">
                        <div class="col-sm-2 offset-2">
                            <button class="btn btn-sm btn-dark rounded-3 btn-reject href_transform" onclick="showinoutreject()">Input Reject</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                    Rekonsiliasi Sekunder-Akhir
                </button>
            </h2>
            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
                <div class="accordion-body">
                    <div class="form-group row mb-0">
                        <label for="hasilteoritisrekonpillow" class="col-sm-2 col-form-label">Hasil Teoritis</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="hasilteoritisrekonpillow" value="0" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="hasilnyatarekonpillow" class="col-sm-2 col-form-label">Hasil Nyata</label>
                        <div class="col-sm-2">
                            <input type="number" min="0" value="0" class="form-control form-control-sm" id="hasilnyatarekonpillow" onchange="hasilrekonpillow()" onkeyup="hasilrekonpillow()" disabled>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="presentaserekonpillow" class="col-sm-2 col-form-label">Presentase</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" id="presentaserekonpillow" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" id="uom1rekonpillow" value="%" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="rangehasilrekonpillow" class="col-sm-2 col-form-label">Range Hasil</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" id="rangehasilrekonpillow" value="<?= $rangehasil ?>" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" id="uom2rekonpillow" value="<?= $uom ?>" readonly>
                        </div>
                    </div>
                    <!-- <hr> -->
                    <div class="col-sm-1 offset-11 ms-auto">
                        <label for="kodemesinmixingcreateplanning" class="form-label">&nbsp;</label>
                        <div class="input-group">
                            <button type="button" class="btn btn-outline-dark btn-sm" id="saverekonpillow" onclick="saverekonpillow()" hidden><img src="../asset/icon/save.png"> Submit</button>
                        </div>
                    </div>
                    <!-- <div class="form-group row mb-1">
                        <div class="col-sm-2 offset-4">
                            <button class="btn btn-sm rounded-3 btn-reject" data-bs-toggle="modal" data-bs-target="#searchrejectrekonsiliasipillow">Input Reject</button>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Planning Number-->
<div class="modal fade" id="searchplanningnumberrekonpillow" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">List Planning Number</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="mytables" class="table table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Planing Number</th>
                            <th>Years</th>
                            <th>Product ID</th>
                            <th>Batch</th>
                            <th>Shift ID</th>
                            <th>Packing Date</th>
                            <th>Resource ID</th>
                            <th>ED</th>
                            <th>Resource ID Mix</th>
                            <th>Mixing Date</th>
                            <th>Qty</th>
                            <th>Uom</th>
                            <th>Process</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $plant = $_SESSION['plant'];
                        $unitcode = $_SESSION['unitcode'];
                        $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND
                                                                                                UnitCode='$unitcode' AND
                                                                                                ProsesPillow='X' AND RekonPillow is null");
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td><a href="#" class="badge bg-success href_transform" onclick="prosesselectrekonpillow('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>')"><?= $row['PlanningNumber'] ?></a></td>
                                <td><?= $row['Years'] ?></td>
                                <td><?= $row['ProductID'] ?></td>
                                <td><?= $row['BatchNumber'] ?></td>
                                <td><?= $row['ShiftID'] ?></td>
                                <td><?= $row['PackingDate'] ?></td>
                                <td><?= $row['ResourceID'] ?></td>
                                <td><?= $row['ExpiredDate'] ?></td>
                                <td><?= $row['ResourceIDMix'] ?></td>
                                <td><?= $row['MixingDate'] ?></td>
                                <td><?= $row['Quantity'] ?></td>
                                <td><?= $row['UnitOfMeasures'] ?></td>
                                <td><?= $row['ProcessNumber'] ?></td>
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
<!-- Reject-->
<div class="modal fade" id="searchrejectrekonsiliasipillow" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Reject - Planning Number #<label id="titleplanningnumberrekonsiliasipillow"></label></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group row mb-0">
                    <label for="jumlahrekonsiliasipillow" class="col-sm-2 col-form-label">Jumlah</label>
                    <div class="col-sm-2">
                        <input type="number" min="0" value="0" class="form-control form-control-sm" id="Jumlahrekonsiliasipillow" value="0">
                    </div>
                    <div class="col-sm-1">
                        <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="nocontainerrekonsiliasipillow" class="col-sm-2 col-form-label">No Container</label>
                    <div class="col-sm-2">
                        <input type="number" min="0" value="0" class="form-control form-control-sm" id="nocontainerrekonsiliasipillow" value="0">
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <label for="keteranganrekonsiliasipillow" class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-4">
                        <textarea class="form-control form-control-sm" id="keteranganrekonsiliasipillow" cols="60" rows="3"></textarea>
                    </div>
                </div>
                <!-- <hr class="offset-2 width-50"> -->
                <div class="form-group row mb-3 offset-2">
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-outline-dark btn-sm" onclick="saverejectrekonpillow()"><img src="../asset/icon/save.png"> Submit</button>
                    </div>
                </div>
                <section id="table_reject_pillowpack">

                </section>
            </div>
        </div>
    </div>
</div>
<!-- End -->

<!-- Downtime-->
<div class="modal fade" id="searchdowntimerekonpillow" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Downtime - Planning Number #<label id="titleplanningnumberrekonpillow"></label></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group row mb-0">
                    <label for="jamrekonpillow" class="col-sm-2 col-form-label">Jam</label>
                    <div class="col-sm-2">
                        <input type="time" class="form-control form-control-sm" id="jamrekonpillow" value="<?= date('01:00') ?>">
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <label for="permasalahanrekonpillow" class="col-sm-2 col-form-label">Permasalahan</label>
                    <div class="col-sm-4">
                        <textarea class="form-control form-control-sm" id="permasalahanrekonpillow" cols="60" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="tindakanrekonpillow" class="col-sm-2 col-form-label">Tindakan</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm" id="tindakanrekonpillow">
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="hasilrekonpillow" class="col-sm-2 col-form-label">Hasil</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm" id="hasilrekonpillow">
                    </div>
                </div>
                <!-- <hr class="offset-2 width-50"> -->
                <div class="form-group row mb-5 offset-2">
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-outline-dark btn-sm" onclick="savedowntimerekonpillow('pillowpack')"><img src="../asset/icon/save.png"> Submit</button>
                    </div>
                </div>
                <section id="table_rekon_pillow">

                </section>
            </div>
        </div>
    </div>
</div>
<!-- End -->