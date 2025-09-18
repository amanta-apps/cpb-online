<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/lab.png"> QC Result - Cek RH & Suhu</h6>
    <hr class="w-50 mb-0">
    <!-- <label for="" class="col-sm-2 text-dark">Transaksi</label>
    <hr class="w-25"> -->
    <div class="col-sm-6 mb-3 mt-0">
        <div class="form-check form-check-inline text-start fw-bold">
            <!-- Transaksi -->
        </div>
        <div class="p-2 text-white shadow" style="border: 1px solid black; background-color: gray">
            <div class="form-check form-switch form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="Hopper" onchange="qcresultransaksi(this.value)" checked>
                <label class="form-check-label fw-bold" for="inlineRadio1">Hopper</label>
            </div>
            <div class="form-check form-switch form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="Topack" onchange="qcresultransaksi(this.value)">
                <label class="form-check-label fw-bold" for="inlineRadio2">Topack</label>
            </div>
            <div class="form-check form-switch form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="Pengolahan" onchange="qcresultransaksi(this.value)">
                <label class="form-check-label fw-bold" for="inlineRadio2">Pengolahan (Mixing)</label>
            </div>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="personalnumberemployee" class="col-sm-2 col-form-label">Planning Number</label>
        <div class="col-sm-2">
            <div class="input-group mb-1">
                <input type="text" class="form-control" placeholder="Planning Number" aria-label="Recipient's username" aria-describedby="button-addon2" id="planningnumberqcresulthoper">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" onclick="searchplanningqcresult()"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
        <label for="yearpersiapanhoperqc" class="col-sm-2 col-form-label">Planning Years</label>
        <div class="col-sm-1">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="yearpersiapanhoperqc" readonly>
        </div>
        <label for="createdbycekrhsuhu" class="col-sm-1 offset-1 col-form-label">Nama Qc</label>
        <div class="col-sm-3">
            <div class="input-group mb-1">
                <input type="text" class="form-control" placeholder="Pernr" aria-label="Recipient's username" aria-describedby="button-addon2" id="pernrcekrhsuhu" value="<?= $_SESSION['personnelnumber'] . ' - ' . Getdata('EmployeeName', 'pa001', 'PersonnelNumber', $_SESSION['personnelnumber']) ?>">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchpernrcekrhsuhu"><span><img src="../asset/icon/cari.png"> </span></button>
            </div>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="productpersiapanhoperqc" class="col-sm-2 col-form-label">Product ID</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="productpersiapanhoperqc" readonly>
        </div>
        <label for="batchpersiapanhoperqc" class="col-sm-1 col-form-label">Batch</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="batchpersiapanhoperqc" readonly>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="deskripsipersiapanhoperqc" class="col-sm-2 col-form-label">Description</label>
        <div class="col-sm-5">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="deskripsipersiapanhoperqc" readonly>
        </div>
    </div>
    <div class="form-group row mb-1" id="tnoprosespersiapanhoperqc" hidden>
        <label for="noprosespersiapanhoperqc" class="col-sm-2 col-form-label">No Proses</label>
        <div class="col-sm-1">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="noprosespersiapanhoperqc" readonly>
        </div>
    </div>
    <div class="accordion" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                <button class="accordion-button collapsed fw-bold fs-6" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                    Hasil Analisa
                </button>
            </h2>
            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
                <div class="accordion-body">
                    <div class="form-group row mb-0">
                        <!-- <h6 class="fw-bold">Hasil Analisa</h6> -->
                    </div>
                    <div class="form-group row mb-1 ms-3">
                        <table id="drhsuhu" class="table table-sm" style=" width: 50%;">
                            <thead class="fw-bold bg-secondary text-white">
                                <tr>
                                    <td style="width: 50%;">Deskripsi</td>
                                    <td>Spesifikasi</td>
                                    <td>Satuan</td>
                                    <td>Penilaian</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="rhqualityrhsuhu">
                                    <td>RH</td>
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent" id="rh_persiapanhoperqc" value="<?= Getdata('Nilai', 'qc_characteristic', 'KodeProses', 'HP02') ?>" readonly></td>
                                    <td> %</td>
                                    <td><input type="number" class="form-control form-control-sm" id="parameter1persiapanhoperqc" value="0"></td>
                                </tr>
                                <tr>
                                    <td>Suhu</td>
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent text-start" id="suhu_persiapanhoperqc" value="<?= Getdata('Nilai', 'qc_characteristic', 'KodeProses', 'HP01') ?>" readonly></td>
                                    <td> °C</td>
                                    <td><input type="number" class="form-control form-control-sm" id="parameter2persiapanhoperqc" value="0"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mt-3 ">
                            <button type="button" id="simpanqcresulthoper" class="btn btn-outline-success btn-sm" onclick="simpanqcresult()" hidden><img src="../asset/icon/save.png"> Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Planning Number HOPER-->
<div class="modal fade" id="searchplanningnumberpersiapanhoperqc1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                                                                            Approval ='X' AND PrepareHoper is null");
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td style="width: 10%;"><a href="#" class="badge bg-success href_transform" onclick="prosesselectqcresult('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>','Hoper')"><?= $row['PlanningNumber'] ?></a></td>
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

<!-- Planning Number TOPACK-->
<div class="modal fade" id="searchplanningnumberpersiapanhoperqc2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">List Planning Number</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="ddisplayplanning3" class="table table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Planning Number</th>
                            <th>Years</th>
                            <th>Product ID</th>
                            <th>Description</th>
                            <th>Batch</th>
                            <th>Resource ID</th>
                            <th>ED</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            Approval ='X' AND PrepareTopack is null");
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td style="width: 10%;"><a href="#" class="badge bg-success href_transform" onclick="prosesselectqcresult('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>','Topack')"><?= $row['PlanningNumber'] ?></a></td>
                                <td><?= $row['Years'] ?></td>
                                <td><?= $row['ProductID'] ?></td>
                                <td style="width: 40%;"><?= Getdata('ProductDescriptions', 'mara_product', 'ProductID', $row['ProductID']) ?></td>
                                <td><?= $row['BatchNumber'] ?></td>
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

<!-- Planning Number PENGOLAHAN-->
<div class="modal fade" id="searchplanningnumberpersiapanhoperqc3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">List Planning Number</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="ddisplayplanning4" class="table table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Planning Number</th>
                            <th>Years</th>
                            <th>Product ID</th>
                            <th>Description</th>
                            <th>Batch</th>
                            <th>No Proses</th>
                            <th>ED</th>
                            <th>Resource ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // $sql = mysqli_query($conn, "SELECT * FROM planning_pengolahan_header WHERE Plant='$plant' AND
                        //                                                                     UnitCode='$unitcode' AND
                        //                                                                     Approval ='X' AND StepPrepare is null");
                        $sql = mysqli_query($conn, "SELECT * FROM planning_pengolahan_subdetail WHERE Plant='$plant' AND
                                                                                                    UnitCode='$unitcode' AND
                                                                                                    Stats01 ='X' AND Stats02='X' AND Stats03='' ORDER BY BatchNumber");
                        while ($row = mysqli_fetch_array($sql)) {
                            // $query = mysqli_query($conn, "SELECT * FROM insp_pengolahan_header WHERE Plant='$plant' AND
                            //                                                                 UnitCode='$unitcode' AND
                            //                                                                 PlanningNumber='$row[PlanningNumber]' AND 
                            //                                                                 Years='$row[Years]'");
                            // while ($r = mysqli_fetch_array($query)) {
                            $d = mysqli_query($conn, "SELECT ExpiredDate,ResourceIDMix FROM planning_pengolahan_detail WHERE Plant='$plant' AND
                                                                                                                                UnitCode='$unitcode' AND
                                                                                                                                PlanningNumber='$row[PlanningNumber]' AND
                                                                                                                                Years='$row[Years]' AND 
                                                                                                                                BatchNumber LIKE '%$row[BatchNumber]%'");
                            $sd = mysqli_fetch_array($d);

                        ?>
                            <tr>
                                <td style="width: 10%;"><a href="#" class="badge bg-success href_transform" onclick="prosesselectqcresult('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>','Pengolahan','<?= $row['BatchNumber'] ?>','<?= $row['NoProses'] ?>')"><?= $row['PlanningNumber'] ?></a></td>
                                <td><?= $row['Years'] ?></td>
                                <td><?= $row['ProductID'] ?></td>
                                <td style="width: 40%;"><?= Getdata('ProductDescriptions', 'mara_product', 'ProductID', $row['ProductID']) ?></td>
                                <td><?= $row['BatchNumber'] ?></td>
                                <td><?= $row['NoProses'] ?></td>
                                <td><?= $sd['ExpiredDate'] ?></td>
                                <td><?= $sd['ResourceIDMix'] ?></td>
                            </tr>
                        <?php
                        }
                        // }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End -->

<!-- Modal Search Pernr -->
<div class="modal fade" id="searchpernrcekrhsuhu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="selectpernrcekrhsuhu('<?= $row['PersonnelNumber'] ?>','<?= $row['EmployeeName'] ?>')">Select</a>
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