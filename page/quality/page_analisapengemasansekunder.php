<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/lab.png"> Analisa Pengemasan Sekunder</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <label for="personalnumberemployee" class="col-sm-2 col-form-label">Planning Number</label>
        <div class="col-sm-3">
            <div class="input-group">
                <input type="text" class="form-control form-control-sm" placeholder="Planning Number" aria-label="Recipient's username" aria-describedby="button-addon2" id="planningnumberanalisapengemasansekunder">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchplanningnumberanalisapengemasansekunder"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
        <label for="yearspengemasansekunder" class="col-sm-2 col-form-label">Planning Years</label>
        <div class="col-sm-1">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="yearspengemasansekunder" readonly>
        </div>
        <label for="nomesindatepengemasansekunder" class="col-sm-2 col-form-label">No Mesin</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="nomesindatepengemasansekunder" readonly>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="productpengemasansekunder" class="col-sm-2 col-form-label">Product /ED/No. BC</label>
        <div class="col-sm-6">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="productpengemasansekunder" readonly>
        </div>
        <label for="shiftcreateplanningpengolahan" class="col-sm-2 col-form-label">Shift</label>
        <div class="col-sm-2">
            <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm" placeholder="Shift" aria-label="Recipient's username" aria-describedby="button-addon2" id="shiftpengemasansekunder" autocomplete="off">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchshiftshiftpengemasansekunder"><span><img src="../asset/icon/cari.png"> </span></button>
            </div>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="koipcpengemasansekunder" class="col-sm-1 offset-8 col-form-label">Koor.</label>
        <div class="col-sm-3">
            <div class="input-group mb-1">
                <input type="text" class="form-control" placeholder="Koor. Shift" aria-label="Recipient's username" aria-describedby="button-addon2" id="koipcpengemasansekunder" autocomplete="off">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchpernrpengemasansekunder"><span><img src="../asset/icon/cari.png"> </span></button>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-3">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>Outer Roll</th>
                        <th>Box</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tkt ins</td>
                        <td><input type="number" class="form-control form-control-sm" value="0" id="roll_inspengemasansekunder"></td>
                        <td><input type="number" class="form-control form-control-sm" value="0" id="box_inspengemasansekunder"></td>
                    </tr>
                    <tr>
                        <td>TPK</td>
                        <td><input type="text" class="form-control form-control-sm" id="roll_tpkpengemasansekunder"></td>
                        <td><input type="text" class="form-control form-control-sm" id="box_tpkpengemasansekunder"></td>
                    </tr>
                    <tr>
                        <td>Jml Cth</td>
                        <td><input type="number" class="form-control form-control-sm" value="0" id="roll_cthpengemasansekunder"></td>
                        <td><input type="number" class="form-control form-control-sm" value="0" id="box_cthpengemasansekunder"></td>
                    </tr>
                    <tr>
                        <td>Jml Msn</td>
                        <td><input type="number" class="form-control form-control-sm" value="0" id="roll_msnpengemasansekunder"></td>
                        <td><input type="number" class="form-control form-control-sm" value="0" id="box_msnpengemasansekunder"></td>
                    </tr>
                    <tr>
                        <td>L/T</td>
                        <td><input type="text" class="form-control form-control-sm" id="roll_ltpengemasansekunder"></td>
                        <td><input type="text" class="form-control form-control-sm" id="box_ltpengemasansekunder"></td>
                    </tr>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-9">
            <section id="udanalisapengemasansekunder" class="" style="pointer-events: none;opacity: 50%;">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <td colspan="6"><label class="fw-bold"><sup class="text-danger">*</sup>JML CTH/FREKUENSI PENGAMBILAN CTH</label></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Outroll</td>
                            <td style="width: 25%;"><input type="number" class="form-control form-control-sm" id="rolljmlsampelfrekuensianalisapengemasansekunder" min="1" value="0"></td>
                            <td>Setiap</td>
                            <td><input type="number" class="form-control form-control-sm" id="rollmenitfrekuensianalisapengemasansekunder" min="1" max="60" value="1" onkeyup="imposeMinMax(this)"></td>
                            <td>Menit</td>
                            <td style="width: 30%;"></td>
                        </tr>
                        <tr>
                            <td>Box</td>
                            <td><input type="number" class="form-control form-control-sm" id="boxjmlsampelfrekuensianalisapengemasansekunder" min="1" value="0"></td>
                            <td>Setiap</td>
                            <td><input type="number" class="form-control form-control-sm" id="boxmenitfrekuensianalisapengemasansekunder" min="1" max="60" value="1" onkeyup="imposeMinMax(this)"></td>
                            <td>Menit</td>
                            <td style="width: 30%;"></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <td colspan=6><label class="fw-bold"><sup class="text-danger">*</sup>Keterangan LULUS/TOLAK</label></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width: 25%;">Outer Roll/Tanpa Outer Roll</td>
                            <td>
                                <select class="form-select form-select-sm" id="roll_lulus_analisapengemasansekunder">
                                    <?php
                                    $query = mysqli_query($conn, "SELECT Descriptions FROM qc_catalog WHERE KodeCatalog='CTLG05'");
                                    while ($q = mysqli_fetch_array($query)) { ?>
                                        <option value="<?= $q['Descriptions'] ?>"><?= $q['Descriptions'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>Box</td>
                            <td>
                                <select class="form-select form-select-sm" id="box_lulus_analisapengemasansekunder">
                                    <?php
                                    $query = mysqli_query($conn, "SELECT Descriptions FROM qc_catalog WHERE KodeCatalog='CTLG05'");
                                    while ($q = mysqli_fetch_array($query)) { ?>
                                        <option value="<?= $q['Descriptions'] ?>"><?= $q['Descriptions'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end">
                                &nbsp;<button type="button" id="simpananalisapengemasansekunder" class="btn btn-success btn-sm zoom" onclick="simpananalisapengemasansekunder()" hidden><img src="../asset/icon/save.png"> Simpan Data Analisa</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </div>
    </div>

    <div class="accordion" id="accordionPanelsStayOpenExample">
        <div class="form-group row mb-0" id="cardcolor">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link nav-link-not active bg-secondary text-white" style="border-radius: 2rem; font-size: 7pt !important" id=" home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Outer Roll/Tanpa Outer Roll</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link nav-link-not bg-secondary text-white" style="border-radius: 2rem; font-size: 7pt !important" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">BOX</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="container">
                        <!-- <div class="form-group row mb-3 mt-3">
                                    <div class="col-sm-3 offset-9">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                            Outer Roll/Tanpa Outer Roll (Lulus)
                                        </div>
                                    </div>
                                </div> -->
                        <table class="table table-sm mt-3" id="tableanalisapengemasansekunder">
                            <tbody>
                                <tr>
                                    <td colspan=8 class="fw-bold">RINCIAN HASIL ANALISA</td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="setdefault1pengemasansekunder" onchange="setstrip1pengemasansekunder(this.checked)">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Set (-)
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" td>
                                    <td colspan="2" class="bg-secondary text-white text-center">Outer Roll</td>
                                </tr>
                                <tr>
                                    <td rowspan="2" style="width: 5%;"><input type="number" class="form-control form-control-sm" id="rollitemanalisapengemasansekunder" value="1" min="1"></td>
                                    <td rowspan="2"><input type="time" class="form-control form-control-sm" id="rolljamanalisapengemasansekunder" value="<?= date('H:i') ?>"></td>
                                    <td rowspan="2"><input type="text" class="form-control form-control-sm" id="rollkodesachetalisapengemasansekunder" placeholder="Kode Sachet" autocomplete="off"></td>
                                    <td rowspan="2"><input type="text" class="form-control form-control-sm" id="rolljmlsachetalisapengemasansekunder" placeholder="Jml Sachet" autocomplete="off"></td>
                                    <td rowspan="2"><input type="text" class="form-control form-control-sm" id="rollsachetbocoralisapengemasansekunder" placeholder="Sachet Bocor" autocomplete="off"></td>
                                    <td><input type="text" class="form-control form-control-sm" id="rollbocoralisapengemasansekunder" placeholder="Bocor" autocomplete="off"></td>
                                    <td><input type="text" class="form-control form-control-sm" id="rollrapialisapengemasansekunder" placeholder="Tidak Rapi" autocomplete="off"></td>
                                    <td rowspan="2"><input type="text" class="form-control form-control-sm" id="rollbrosuralisapengemasansekunder" placeholder="Tidak Ada Brosur" autocomplete="off"></td>
                                    <td rowspan="2">
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <button type="button" id="simpanrollalisapengemasansekunder" class="btn btn-outline-success btn-sm" onclick="simpanrollalisapengemasansekunder()"><img src="../asset/icon/save.png"> Submit</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="container">
                        <table class="table table-sm mt-3">
                            <tbody>
                                <tr>
                                    <td colspan=8 class="fw-bold">RINCIAN HASIL ANALISA</td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="setdefault2pengemasansekunder" onchange="setstrip2pengemasansekunder(this.checked)">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Set (-)
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"><input type="number" class="form-control form-control-sm" id="boxitemanalisapengemasansekunder" min="1" value="1"></td>
                                    <td><input type="time" class="form-control form-control-sm" id="boxjamalisapengemasansekunder" value="<?= date('H:i') ?>"></td>
                                    <td><input type="text" class="form-control form-control-sm" id="boxnumberalisapengemasansekunder" placeholder="No Box"></td>
                                    <td><input type="text" class="form-control form-control-sm" id="boxjmlsampelalisapengemasansekunder" placeholder="Jml Sampel"></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="bg-secondary text-white text-center fw-bold" style="border-right: 1px solid white;">Kodifikasi</td>
                                    <td colspan="4" class="bg-secondary text-white text-center fw-bold">Panjang Seal tape # 5-6cm</td>
                                </tr>
                                <tr>

                                    <td colspan=2><input type="text" class="form-control form-control-sm" id="boxketprodukalisapengemasansekunder" placeholder="Ket Produk"></td>
                                    <td><input type="text" class="form-control form-control-sm" id="boxkodeproduksialisapengemasansekunder" placeholder="Kode Produksi"></td>
                                    <td><input type="text" class="form-control form-control-sm" id="boxedalisapengemasansekunder" placeholder="ED/BC"></td>
                                    <td><input type="text" class="form-control form-control-sm" id="boxopralisapengemasansekunder" placeholder="Opr"></td>
                                    <td colspan="2"><input type="text" class="form-control form-control-sm" id="boxsampingatasalisapengemasansekunder" placeholder="Samping Atas"></td>
                                    <td colspan="2"><input type="text" class="form-control form-control-sm" id="boxsampingbawahalisapengemasansekunder" placeholder="Samping Bawah"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><input type="text" class="form-control form-control-sm" id="boxmelekatalisapengemasansekunder" placeholder="Tidak Melekat Sempurna"></td>
                                    <td><input type="text" class="form-control form-control-sm" id="boxjmloralisapengemasansekunder" placeholder="Jml O.R"></td>
                                    <td colspan="4"><input type="text" class="form-control form-control-sm" id="boxketalisapengemasansekunder" placeholder="Ket"></td>
                                    <td>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <button type="button" id="simpanboxalisapengemasansekunder" class="btn btn-outline-success btn-sm" onclick="simpanboxalisapengemasansekunder()"><img src="../asset/icon/save.png"> Submit</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- </div>
        </div> -->
        <div id="showdata_analisapengemasansekunder" class="p-1 table-responsive overflow-scroll" style="display: flex; font-size: 8pt !important;">

        </div>
        <div class="text-end mt-3">
            <!-- <button type="button" id="simpananalisapengemasansekunder" class="btn btn-success btn-sm" onclick="simpananalisapengemasansekunder()" hidden><img src="../asset/icon/save.png"> Simpan Hasil Analisa</button> -->
        </div>
    </div>
</div>

<!-- Planning Number-->
<div class="modal fade" id="searchplanningnumberanalisapengemasansekunder" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">List Planning Number</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="ddisplayplanning" class="table table-sm" style="width:100%;">
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
                        $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$_SESSION[plant]' AND UnitCode='$_SESSION[unitcode]' AND PreparePillow='X' AND AnalisaKemasSekunder is null");
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td><a href="#" class="badge bg-success href_transform" onclick="prosesselectprosesanalisakemasansekunder('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>')"><?= $row['PlanningNumber'] ?></a></td>
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

<!-- Modal Search Pernr Koor IPC -->
<div class="modal fade" id="searchpernrpengemasansekunder" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Search Employee Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="dsearchdata" class="table table-striped table-sm" style="width:100%;">
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
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="$('#koipcpengemasansekunder').val('<?= $row['PersonnelNumber'] . ' - ' . $row['EmployeeName'] ?>'),$('#searchpernrpengemasansekunder').modal('hide')">Select</a>
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

<!-- Modal Search Shift-->
<div class="modal fade" id="searchshiftshiftpengemasansekunder" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  " id="staticBackdropLabel">Search Shift</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="dsearchdata2" class="table table-striped table-sm" style="width:100%;">
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
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="$('#shiftpengemasansekunder').val('<?= $row['ShiftID'] ?>'),$('#searchshiftshiftpengemasansekunder').modal('hide')">Select</a>
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