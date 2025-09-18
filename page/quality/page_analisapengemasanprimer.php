<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/lab.png"> Analisa Pengemasan Primer</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <label for="personalnumberenginesetapproval" class="col-sm-2 col-form-label">Planning Number</label>
        <div class="col-sm-3">
            <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm bg-transparent fw-bold" aria-label="Recipient's username" aria-describedby="button-addon2" id="planningnumberpengemasanprimer" readonly>
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchplanningnumberpengemasanprimer"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
        <label for="yearspengemasanprimer" class="col-sm-2 col-form-label">Planning Years</label>
        <div class="col-sm-1">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="yearspengemasanprimer" readonly>
        </div>
        <label for="mixingdatepengemasanprimer" class="col-sm-2 col-form-label">Mixing Date</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="mixingdatepengemasanprimer" readonly>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="productpengemasanprimer" class="col-sm-2 col-form-label">Product /ED/No. BC</label>
        <div class="col-sm-6">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="productpengemasanprimer" readonly>
        </div>
        <label for="nomesindatepengemasanprimer" class="col-sm-2 col-form-label">No Mesin</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="nomesindatepengemasanprimer" readonly>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="createdbycekrhsuhu" class="col-sm-2  col-form-label">Asst. Qc / Koor. Qc</label>
        <div class="col-sm-3">
            <div class="input-group mb-1">
                <input type="text" class="form-control" placeholder="Ass. IPC Unit" aria-label="Recipient's username" aria-describedby="button-addon2" id="assqcpengemasanprimer" autocomplete="off">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchpernrpengemasanprimer1"><span><img src="../asset/icon/cari.png"> </span></button>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="input-group mb-1">
                <input type="text" class="form-control" placeholder="Ko. IPC Unit" aria-label="Recipient's username" aria-describedby="button-addon2" id="koipcpengemasanprimer" autocomplete="off">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchpernrpengemasanprimer2"><span><img src="../asset/icon/cari.png"> </span></button>
            </div>
        </div>
        <label for="shiftcreateplanningpengolahan" class="col-sm-2 col-form-label">Shift</label>
        <div class="col-sm-2">
            <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm" placeholder="Shift" aria-label="Recipient's username" aria-describedby="button-addon2" id="shiftpengemasanprimer" autocomplete="off">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchshiftshiftpengemasanprimer"><span><img src="../asset/icon/cari.png"> </span></button>
            </div>
        </div>
    </div>
    <hr>
    <div class="form-group row mb-0">
        <table class="table table-sm table-bordered">
            <tr>
                <td>Tingkat Inspeksi</td>
                <td>
                    <select class="form-select form-select-sm" id="tingkatinspeksidatepengemasanprimer" onchange="selecttingkatinspeksi(this.value)">
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM master_military_std WHERE Plant='$plant'");
                        while ($q = mysqli_fetch_array($query)) { ?>
                            <option value="<?= $q['TingkatInspec'] ?>"><?= $q['TingkatInspec'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
                <td>Jumlah Contoh</td>
                <td><input type="text" class="form-control form-control-sm bg-transparent" id="jumlahcontohpengemasanprimer" readonly></td>
                <td>Tgkt. Terima Kualitas</td>
                <td><input type="text" class="form-control form-control-sm bg-transparent" id="terimakualitaspengemasanprimer" readonly></td>
                <td>Lulus/Tolak</td>
                <td><input type="text" class="form-control form-control-sm bg-transparent" id="lulustolakpengemasanprimer" readonly></td>
            </tr>
            <tr>
                <td colspan="2">Jumlah Contoh per frekuensi pengambilan contoh :</td>
                <td><input type="number" min="1" value="0" class="form-control form-control-sm" id="jmlcontohfrekuensipengemasanprimer"></td>
                <td>Sachet Setiap</td>
                <td>
                    <select class="form-select form-select-sm" id="sachetsetiappengemasanprimer" onchange="selectsachetsetiap(this.value)">
                        <option value="15">15</option>
                        <option value="25">25</option>
                    </select>
                </td>
                <td>Menit dari</td>
                <td><input type="text" class="form-control form-control-sm bg-transparent" id="mesindaripengemasanprimer" readonly></td>
                <td>Mesin</td>
            </tr>
            <tr>
                <td>Range Bobot</td>
                <td><label for="" id="rangebobotpengemasanprimer"></label> gram</td>
                <td colspan="6" class="text-end"><button type="button" class="btn btn-success btn-sm zoom" id="buttonselesaipengemasanprimer" hidden onclick="simpandataanalisapengemasanprimer()"><img src="../asset/icon/save.png"> Simpan Data Analisa</button></td>
            </tr>
        </table>
    </div>
    <div class="form-group row mb-0" id="cardcolor">
        <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link btn-sm text-dark fw-bold active border-dark bg-secondary text-white" style="border-radius: 2rem; font-size: 7pt !important;" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1" aria-selected="true">A. ANALISA VISUAL SACHET DAN BOBOT</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link btn-sm text-dark fw-bold border-dark bg-secondary text-white" style="border-radius: 2rem; font-size: 7pt !important;" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-2" type="button" role="tab" aria-controls="pills-2" aria-selected="true">B. ANALISA TINGKAT KEBOCORAN MESIN SACHET</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link btn-sm text-dark fw-bold border-dark bg-secondary text-white" style="border-radius: 2rem; font-size: 7pt !important;" id="pills-3-tab" data-bs-toggle="pill" data-bs-target="#pills-3" type="button" role="tab" aria-controls="pills-3" aria-selected="true">C. PENGECEKAN KODIFIKASI SACHET PRODUK JADI</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                <table class="table table-sm table-bordered mb-1">
                    <tbody>
                        <tr>
                            <td colspan="8" class="fw-bold">RINCIAN HASIL ANALISA </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="setdefault1pengemasanprimer" onchange="setstrippengemasanprimer(this.checked)">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Set (-)
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="time" class="form-control form-control-sm" id="jam1pengemasanprimer" value="<?= date('H:i') ?>"></td>
                            <td><input type="date" class="form-control form-control-sm" id="tanggalpengemasanprimer" autocomplete="off" value="<?= date('Y-m-d') ?>" readonly></td>
                            <td><input type="text" class="form-control form-control-sm" id="nomesindmpengemasanprimer" placeholder="No Mesin DM" autocomplete="off" readonly></td>
                            <td><input type="number" class="form-control form-control-sm" id="nodmpengemasanprimer" autocomplete="off" value="1" min="1"></td>
                            <td colspan=3>
                                <select id="pemasokpengemasanprimer" class=" form-control form-select-sm" onchange="changepemasokpengemasanprimer(this.value)">
                                    <?php
                                    $sql = mysqli_query($conn, "SELECT * FROM data_pemasok WHERE Plant='$plant'");
                                    if (mysqli_num_rows($sql) != 0) {
                                        while ($r = mysqli_fetch_array($sql)) { ?>
                                            <option value="<?= $r['Descriptions'] ?>"><?= $r['Idpemasok'] . ' - ' . $r['Descriptions'] ?></option>
                                    <?php
                                        }
                                    } ?>
                                </select>
                                <!-- <input type="number" class="form-control form-control-sm" id="pemasokpengemasanprimer" autocomplete="off" value="1" min="1"> -->
                            </td>
                            <td><input type="text" class="form-control form-control-sm" id="schtidakrapipengemasanprimer" placeholder="Sch Tdk Rapi" autocomplete="off"></td>
                            <td><input type="text" class="form-control form-control-sm" id="misregisterpengemasanprimer" placeholder="Misregister" autocomplete="off"></td>
                        </tr>
                        <tr class="text-center">
                            <th colspan="2" class="bg-secondary text-white">Eye Cut</th>
                            <th colspan="4" class="bg-secondary text-white">Produk</th>
                            <th colspan="3" class="bg-secondary text-white">Embos Sachet</th>
                        </tr>
                        <tr>
                            <td><input type="text" class="form-control form-control-sm" id="tdkadaeyecutpengemasanprimer" placeholder="Tdk ada" autocomplete="off"></td>
                            <td><input type="text" class="form-control form-control-sm" id="posisisalaheyecutpengemasanprimer" placeholder="Posisi Salah" autocomplete="off"></td>
                            <td><input type="text" class="form-control form-control-sm" id="tdkadakodeprodukpengemasanprimer" placeholder="Tdk ada" autocomplete="off"></td>
                            <td><input type="text" class="form-control form-control-sm" id="posisisalahkodeprodukpengemasanprimer" placeholder="Posisi salah" autocomplete="off"></td>
                            <td><input type="text" class="form-control form-control-sm" id="salahkodeprodukpengemasanprimer" placeholder="Salah" autocomplete="off"></td>
                            <td><input type="text" class="form-control form-control-sm" id="misprintkodeprodukpengemasanprimer" placeholder="Misprint" autocomplete="off"></td>
                            <td><input type="text" class="form-control form-control-sm" id="tdkadaembospengemasanprimer" placeholder="Tdk ada" autocomplete="off"></td>
                            <td><input type="text" class="form-control form-control-sm" id="posisisalahembospengemasanprimer" placeholder="Posisi salah" autocomplete="off"></td>
                            <td><input type="text" class="form-control form-control-sm" id="tdkjelasembospengemasanprimer" placeholder="Tdk jelas" autocomplete="off"></td>
                        </tr>
                        <tr class="text-center">
                            <th colspan="2" class="bg-secondary text-white">Tingkat Kekembungan Sachet</th>
                            <th colspan="2" class="bg-secondary text-white">Kondisi seal sachet</th>
                            <th colspan="4"></th>
                            <td rowspan="2" style="vertical-align: middle;">
                                <button type="button" id="simpanrollalisapengemasansekunder" class="btn btn-outline-success btn-sm" onclick="submitanalisapengemasanprimer_one()"><img src="../asset/icon/save.png"> Submit</button>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="text" class="form-control form-control-sm" id="kurangkekembunganpengemasanprimer" placeholder="Kurang" autocomplete="off"></td>
                            <td><input type="text" class="form-control form-control-sm" id="lebihkekembunganpengemasanprimer" placeholder="Lebih" autocomplete="off"></td>
                            <td><input type="text" class="form-control form-control-sm" id="tidakngesealkondisisealpengemasanprimer" placeholder="Tidak Ngeseal" autocomplete="off"></td>
                            <td><input type="text" class="form-control form-control-sm" id="haluskondisisealpengemasanprimer" placeholder="Halus" autocomplete="off"></td>
                            <td><input type="text" class="form-control form-control-sm" id="pisaupotongpengemasanprimer" placeholder="Pisau Potong Sch tdk tajam" autocomplete="off"></td>
                            <td><input type="text" class="form-control form-control-sm" id="bobotpengemasanprimer" placeholder="Bobot -/+" autocomplete="off"></td>
                            <td colspan="2"><input type="text" class="form-control form-control-sm" id="catatan1pengemasanprimer" placeholder="Catatan" autocomplete="off"></td>
                        </tr>
                    </tbody>
                </table>
                <section id="showdata_analisapengemasanprimer"></section>
            </div>
            <div class="tab-pane fade show" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
                <table class="table table-sm table-bordered mb-1">
                    <tbody>
                        <tr>
                            <td colspan="6" class="fw-bold">RINCIAN HASIL ANALISA</td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="setdefault2pengemasanprimer" onchange="setstrip2pengemasanprimer(this.checked)">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Set (-)
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="time" class="form-control form-control-sm" id="jam2pengemasanprimer" value="<?= date('H:i') ?>"></td>
                            <td><input type="text" class="form-control form-control-sm" id="toppengemasanprimer" placeholder="Top" autocomplete="off"></td>
                            <td><input type="text" class="form-control form-control-sm" id="vert1pengemasanprimer" placeholder="Vert1" autocomplete="off"></td>
                            <td><input type="text" class="form-control form-control-sm" id="vert2pengemasanprimer" placeholder="Vert2" autocomplete="off"></td>
                            <td><input type="text" class="form-control form-control-sm" id="horipengemasanprimer" placeholder="Hori" autocomplete="off"></td>
                            <td><input type="text" class="form-control form-control-sm" id="centrepengemasanprimer" placeholder="Centre" autocomplete="off"></td>
                            <td><input type="text" class="form-control form-control-sm" id="ljpengemasanprimer" placeholder="L.J" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-center bg-secondary text-white">Cek Kontaminan</th>
                            <th colspan="4"></th>
                            <td rowspan="2" style="vertical-align: middle; text-align: center;">
                                <button type="button" id="simpanrollalisapengemasansekunder" class="btn btn-outline-success btn-sm" onclick="submit2analisapengemasanprimer_two()"><img src="../asset/icon/save.png"> Submit</button>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="text" class="form-control form-control-sm" id="adakontaminanpengemasanprimer" placeholder="Ada" autocomplete="off"></td>
                            <td><input type="text" class="form-control form-control-sm" id="tidakadakontaminanpengemasanprimer" placeholder="# Ada" autocomplete="off"></td>
                            <td colspan="4"><input type="text" class="form-control form-control-sm" id="catatan2pengemasanprimer" placeholder="Catatan" autocomplete="off"></td>
                        </tr>
                    </tbody>
                </table>
                <div id="showdata_analisapengemasanprimer2"></div>
            </div>
            <div class="tab-pane fade show" id="pills-3" role="tabpanel" aria-labelledby="pills-3-tab">
                <table class="table table-sm table-bordered mb-1">
                    <tbody>
                        <tr>
                            <td><input type="time" class="form-control form-control-sm" id="jam3pengemasanprimer" value="<?= date('H:i') ?>"></td>
                            <td><input type="text" class="form-control form-control-sm" id="keteranganpengemasanprimer" placeholder="Keterangan" autocomplete="off"></td>
                            <td><input type="file" class="form-control form-control-sm" id="gambarpengemasanprimer" autocomplete="off"></td>
                            <td style="vertical-align: middle; text-align: center;"><button type="button" id="simpanrollalisapengemasansekunder" class="btn btn-outline-success btn-sm" onclick="submit3analisapengemasanprimer_three()"><img src="../asset/icon/save.png"> Submit</button></td>
                        </tr>
                    </tbody>
                </table>
                <div id="showdata_analisapengemasanprimer3"></div>
            </div>
        </div>
    </div>
</div>

<!-- Planning Number -->
<div class="modal fade" id="searchplanningnumberpengemasanprimer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                            <th>Planning Number</th>
                            <th>Years</th>
                            <th>Batch</th>
                            <th>Product ID</th>
                            <th>Description</th>
                            <th>Resource ID</th>
                            <th>ED</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $plant = $_SESSION['plant'];
                        $unitcode = $_SESSION['unitcode'];
                        $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND
                                                                                                UnitCode='$unitcode' AND
                                                                                                EngineSetTopack='X' AND ApprovalQc is null");
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td style="width: 10%;"><a href="#" class="badge bg-success href_transform" onclick="selectpengemasanprimer('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>')"><?= $row['PlanningNumber'] ?></a></td>
                                <td><?= $row['Years'] ?></td>
                                <td><?= $row['BatchNumber'] ?></td>
                                <td><?= $row['ProductID'] ?></td>
                                <td style="width: 40%;"><?= Getdata('ProductDescriptions', 'mara_product', 'ProductID', $row['ProductID']) ?></td>
                                <td><?= $row['ResourceID'] ?></td>
                                <td><?= $row['ExpiredDate'] ?></td>
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
<div class="modal fade" id="searchshiftshiftpengemasanprimer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="$('#shiftpengemasanprimer').val('<?= $row['ShiftID'] ?>'),$('#searchshiftshiftpengemasanprimer').modal('hide')">Select</a>
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

<!-- Modal Search Pernr Ass. QC -->
<div class="modal fade" id="searchpernrpengemasanprimer1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Search Employee Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="dsearchdata5" class="table table-striped table-sm" style="width:100%;">
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
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="$('#assqcpengemasanprimer').val('<?= $row['PersonnelNumber'] . ' - ' . $row['EmployeeName'] ?>'),$('#searchpernrpengemasanprimer1').modal('hide')">Select</a>
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

<!-- Modal Search Pernr Koor IPC -->
<div class="modal fade" id="searchpernrpengemasanprimer2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="$('#koipcpengemasanprimer').val('<?= $row['PersonnelNumber'] . ' - ' . $row['EmployeeName'] ?>'),$('#searchpernrpengemasanprimer2').modal('hide')">Select</a>
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