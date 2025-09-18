<?php
$rangehasil = Getdata("Nilai", "qc_characteristic", "KodeProses", "RK01");
$uom = Getdata("UnitOfMeasures", "qc_characteristic", "KodeProses", "RK01");
?>
<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/proses.png"> Reconciliation Topack</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <label for="personalnumberemployee" class="col-sm-2 col-form-label">Planning Number</label>
        <div class="col-sm-2">
            <div class="input-group mb-4">
                <input type="text" class="form-control" placeholder="Planning Number" aria-label="Recipient's username" aria-describedby="button-addon2" id="planningnumberprosestopack">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchplanningnumberprosestopack"><span><img src="../asset/icon/cari.png"></span></button>
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
                        <label for="setplanningnumberprosestopack" class="col-sm-2 col-form-label fw-bold">Planning Number</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="setplanningnumberprosestopack" readonly>
                        </div>
                        <label for="tanggalkemasprosestopack" class="col-sm-2 offset-4 col-form-label">Tanggal Kemas</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="tanggalkemasprosestopack" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="productidprosestopack" class="col-sm-2 col-form-label">Product ID</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="productidprosestopack" readonly>
                        </div>
                        <label for="shiftidprosestopack" class="col-sm-2 offset-4 col-form-label">Shift ID</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="shiftidprosestopack" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="productidprosestopack" class="col-sm-2 col-form-label">Product Description</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="productdescriptionprosestopack" readonly>
                        </div>
                        <label for="edprosestopack" class="col-sm-2 offset-4 col-form-label">Expired Date</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="edprosestopack" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="batchprosestopack" class="col-sm-2 col-form-label">Batch</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="batchprosestopack" readonly>
                        </div>
                        <label for="tglmixingprosestopack" class="col-sm-2 offset-4 col-form-label">Tanggal Mixing</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="tglmixingprosestopack" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="nomesinprosestopack" class="col-sm-2 col-form-label">No Mesin</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="nomesinprosestopack" readonly>
                        </div>
                        <label for="yearsprosestopack" class="col-sm-2 offset-4 col-form-label">Years</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="yearsprosestopack" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="mixingprosestopack" class="col-sm-2 col-form-label">Mesin Mixing</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="mixingprosestopack" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="qtyprosestopack" class="col-sm-2 col-form-label">Quantity</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="qtyprosestopack" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="jumlahprosesprosestopack" class="col-sm-2 col-form-label">Process Number</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" id="jumlahprosesprosestopack" readonly>
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
                        <label for="jammulaiprosestopack" class="col-sm-2 col-form-label">Jam Mulai</label>
                        <div class="col-sm-2">
                            <input type="time" class="form-control form-control-sm" id="jammulaiprosestopack" value="<?= date('H:i') ?>">
                        </div>
                        <label for="jamselesaiprosestopack" class="col-sm-2 offset-1 col-form-label">Jam Selesai</label>
                        <div class="col-sm-2">
                            <input type="time" class="form-control form-control-sm" id="jamselesaiprosestopack" value="<?= date('H:i') ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="counterprinterprosestopack" class="col-sm-2 col-form-label">Counter Printer</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control form-control-sm" id="counterprinterprosestopack" min="0" value="0" onchange="Getreject()" onkeyup="Getreject()">
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                        <div class="col-sm-4 offset-2">
                            <button type="button" class="btn btn-outline-primary btn-sm href_transform" id="btn_downtimerekontopack" onclick="execnomorlot()"><img src="../asset/icon/barcode16.png"> Nomor Lot</button>
                            <button type="button" class="btn btn-danger btn-sm href_transform" id="btn_downtimerekontopack" onclick="downtimerekontopack('topack')"><img src="../asset/icon/downtime.png"> Downtime</button>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="countermesinprosestopack" class="col-sm-2 col-form-label">Counter Mesin</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control form-control-sm" id="countermesinprosestopack" min="0" value="0" onchange="Getlithoused()" onkeyup="Getlithoused()">
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="lithoterpakaiprosestopack" class="col-sm-2 col-form-label">Jumlah Kemasan Terpakai</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="lithoterpakaiprosestopack" value="0" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Roll" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="rusakprosestopack" class="col-sm-2 col-form-label">Hasil SCH Rusak</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="rusakprosestopack" value="0" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="rusakprosestopack" class="col-sm-2 col-form-label">Sampling</label>
                        <div class="col-sm-2" id="showiconsampling">
                            <!-- <input type="text" class="form-control form-control-sm" id="rusakprosestopack" value="0" readonly> -->
                            <!-- <img src="../asset/icon/no.png"> -->
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="rusakprosestopack" class="col-sm-2 col-form-label">Sampel Tes Kebocoran</label>
                        <div class="col-sm-2">
                            <input type="number" min="0" value="0" class="form-control form-control-sm" id="sampelkebocoranprosestopack" value="0">
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="rusakprosestopack" class="col-sm-2 col-form-label">Retained Sample</label>
                        <div class="col-sm-2">
                            <input type="number" min="0" value="0" class="form-control form-control-sm" id="retainedsampleprosestopack" value="0">
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                    Rekonsiliasi Hasil Pengemasan Primer
                </button>
            </h2>
            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
                <div class="accordion-body">
                    <div class="form-group row mb-0">
                        <label for="hasilteoritisrekontopack" class="col-sm-2 col-form-label">Hasil Teoritis</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="hasilteoritisrekontopack" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="hasilnyatarekontopack" class="col-sm-2 col-form-label">Hasil Nyata</label>
                        <div class="col-sm-2">
                            <input type="number" min="1" value="0" class="form-control form-control-sm" id="hasilnyatarekontopack" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="presentaserekontopack" class="col-sm-2 col-form-label">Presentase</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" id="presentaserekontopack" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" id="uom1rekontopack" value="%" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="rangehasilrekontopack" class="col-sm-2 col-form-label">Range Hasil</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" id="rangehasilrekontopack" value="<?= $rangehasil ?>" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" id="uom2rekontopack" value="<?= $uom ?>" readonly>
                        </div>
                    </div>
                    <!-- <hr> -->
                    <div class="col-sm-1 offset-11 ms-auto">
                        <label for="kodemesinmixingcreateplanning" class="form-label">&nbsp;</label>
                        <div class="input-group">
                            <button type="button" class="btn btn-outline-dark btn-sm" id="btn_saveprosestopack" onclick="saveprosestopack()" hidden><img src="../asset/icon/save.png"> Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Planning Number-->
<div class="modal fade" id="searchplanningnumberprosestopack" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                        $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE PrepareTopack='X' AND EngineSetTopack='X' AND ProsesTopack is null");
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td><a href="#" class="badge bg-success href_transform" onclick="prosesselectprosestopack('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>')"><?= $row['PlanningNumber'] ?></a></td>
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

<!-- Downtime-->
<div class="modal fade" id="searchdowntimerekontopack" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Downtime - Planning Number #<label id="titleplanningnumberrekontopack"></label></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group row mb-0">
                    <label for="jamrekontopack" class="col-sm-2 col-form-label">Jam</label>
                    <div class="col-sm-2">
                        <input type="time" class="form-control form-control-sm" id="jamrekontopack" value="<?= date('01:00') ?>">
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <label for="permasalahanrekontopack" class="col-sm-2 col-form-label">Permasalahan</label>
                    <div class="col-sm-4">
                        <textarea class="form-control form-control-sm" id="permasalahanrekontopack" cols="60" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="tindakanrekontopack" class="col-sm-2 col-form-label">Tindakan</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm" id="tindakanrekontopack">
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="hasilrekontopack" class="col-sm-2 col-form-label">Hasil</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm" id="hasilrekontopack">
                    </div>
                </div>
                <!-- <hr class="offset-2 width-50"> -->
                <div class="form-group row mb-5 offset-2">
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-outline-dark btn-sm" onclick="savedowntimerekontopack('topack')"><img src="../asset/icon/save.png"> Submit</button>
                    </div>
                </div>
                <section id="table_rekon_topack">

                </section>
            </div>
        </div>
    </div>
</div>
<!-- End -->

<!-- Search Nomor Lot-->
<div class="modal fade" id="searchexecnomorlot" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Nomor Lot - Planning Number #<label id="titleplanningnumberexecnomorlot"></label></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group row mb-0">
                    <label for="nomorlotrekontopack" class="col-sm-2 col-form-label">Nomor Lot</label>
                    <div class="col-sm-4">
                        <div class="input-group mb-1">
                            <input type="text" class="form-control form-control-sm" aria-label="Recipient's username" aria-describedby="button-addon2" id="nomorlotrekontopack">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchnomorlotrekontopack"><span><img src="../asset/icon/cari.png"></span></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="kodesupplierrekontopack" class="col-sm-2 col-form-label">Supplier</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="kodesupplierrekontopack" readonly>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" id="namasupplierrekontopack" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="joinrekontopack" class="col-sm-2 col-form-label">Join</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="joinrekontopack" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="joinrekontopack" class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-2">
                        <select id="statsX" class="form-control form-select-sm">
                            <option value="X">1. Habis</option>
                            <option value="">2. Tidak Habis</option>
                        </select>
                    </div>
                </div>
                <!-- <hr class="offset-2 width-50"> -->
                <div class="form-group row mt-1 mb-3">
                    <label for="joinrekontopack" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-outline-dark btn-sm" onclick="saveexecnomorlot()"><img src="../asset/icon/save.png"> Submit</button>
                    </div>
                </div>
                <section id="table_exec_nomorlot">

                </section>
            </div>
        </div>
    </div>
</div>
<!-- End -->

<!-- Modal Search Nomor Lot-->
<div class="modal fade" id="searchnomorlotrekontopack" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6>List Supplier</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="mytabled" class="table table-striped table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Nomor Lot</th>
                            <th style="width: 10%;">Kode</th>
                            <th style="width: 30%;">Nama</th>
                            <th>Join</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, "SELECT * FROM data_lot WHERE Plant='$plant' AND UnitCode='$unitcode' AND StatsX=''");
                        while ($row = mysqli_fetch_array($sql)) { ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none href_transform" onclick="selectexecnomorlot('<?= $row['NomorLot'] ?>','<?= $row['KodeSupplier'] ?>','<?= $row['NamaSupplier'] ?>','<?= $row['Joins'] ?>')"><?= $row['NomorLot'] ?></a>
                                </td>
                                <td class="fw-bold"><?= $row['KodeSupplier'] ?></td>
                                <td><?= $row['NamaSupplier'] ?></td>
                                <td><?= $row['Join'] ?></td>
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