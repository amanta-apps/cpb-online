<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/reviewqa.png"> QA Review</h6>
    <hr class="w-50 mb-3">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link" id="nav-pengolahan-tab" data-bs-toggle="tab" data-bs-target="#nav-pengolahan" type="button" role="tab" aria-controls="nav-pengolahan" aria-selected="false" onclick="message(1)">pengolahan</button>
            <button class="nav-link active" id="nav-pengemasan-tab" data-bs-toggle="tab" data-bs-target="#nav-pengemasan" type="button" role="tab" aria-controls="nav-pengemasan" aria-selected="true">Pengemasan</button>
            <button class="nav-link" id="nav-review-tab" data-bs-toggle="tab" data-bs-target="#nav-review" type="button" role="tab" aria-controls="nav-review" aria-selected="false">Review</button>
        </div>
    </nav>
    <div class="tab-content mt-3" id="nav-tabContent">
        <!-- Pengolahan -->
        <div class="tab-pane fade show" id="nav-pengolahan" role="tabpanel" aria-labelledby="nav-pengolahan-tab">

        </div>

        <!-- Pengemasan -->
        <div class="tab-pane fade show active" id="nav-pengemasan" role="tabpanel" aria-labelledby="nav-pengemasan-tab">
            <div class="form-group row mb-0">
                <label for="personalnumberenginesetapproval" class="col-sm-2 col-form-label">Planning Number</label>
                <div class="col-sm-2">
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" placeholder="Planning Number" aria-label="Recipient's username" aria-describedby="button-addon2" id="planningnumberreviewquality">
                        <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchplanningnumberreviewquality"><span><img src="../asset/icon/cari.png"></span></button>
                    </div>
                </div>
                <label for="yearsreviewquality" class="col-sm-2 col-form-label">Planning Years</label>
                <div class="col-sm-1">
                    <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="yearsreviewquality" readonly>
                </div>
            </div>
            <div class="form-group row mb-0">
                <label for="productreviewquality" class="col-sm-2 col-form-label">Product ID</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="productreviewquality" readonly>
                </div>
                <label for="batchreviewqualityc" class="col-sm-1 col-form-label">Batch</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="batchreviewquality" readonly>
                </div>
            </div>
            <div class="form-group row mb-0">
                <label for="deskripsireviewquality" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="deskripsireviewquality" readonly>
                </div>
            </div>
            <div class="form-group row mb-1">
                <label for="ukuranbetsreviewquality" class="col-sm-2 col-form-label">Ukuran Bets</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="ukuranbetsreviewquality" readonly>
                </div>
                <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm fw-bold bg-transparent border-0" id="uomreviewquality" readonly>
                </div>
            </div>
            <div class="accordion mb-1" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">

                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
                        <div class="accordion-body">
                            <div class="form-group row mb-0">
                                <div class="row col-4">
                                    <table class="table table-sm p-0 m-0">
                                        <caption>REKONSILISASI HASIL PACKING</caption>
                                        <thead>
                                            <tr>
                                                <th>Tanggal Packing</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input class="form-control form-control-sm bg-transparent border-0" type="text" id="tglpackingreviewquality" readonly></td>
                                                <td><input class="form-control form-control-sm bg-transparent border-0" type="text" id="jumlahreviewquality" readonly></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row col-5 offset-3">
                                    <h6 class="fw-bold">TINJAUAN QA</h6>
                                    <table class="table table-sm">
                                        <tbody>
                                            <tr>
                                                <td>Kodifikasi Kemasan Sekunder</td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="kodifikasireviewquality">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Rekonsiliasi Bahan Pengemas</td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="rekonsiliasibahankemasreviewquality">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Rekonsiliasi Produk Jadi</td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="rekonsiliasiprodukjadireviewquality">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Kebenaran kemasan</td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="kebenarankemasanreviewquality">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jalur Pengemasan (Line Clerance)</td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="jalurpengemasanreviewquality">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <h6 class="fw-bold mt-3">Kebenaran Informasi</h6>
                                    <table class="table table-sm">
                                        <tbody>
                                            <tr>
                                                <td>Kemasan Primer (sachet,strip,botol)</td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="kemasanprimerreviewquality">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Kemasan Sekunder (dus,hanger,shrink,etiket)</td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="kemasansekunderreviewquality">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Insert Brosur</td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="insertbrosurreviewquality">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                            CATATAN
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
                        <div class="accordion-body">
                            <div class="form-group row">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="lulusreviewquality" value="lulus" checked>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        LULUS
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="tidaklulusreviewquality" value="Tolak">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        TIDAK LULUS
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3 mt-3">
                                    <button type="button" id="simpanreviewquality" class="btn btn-outline-success btn-sm" onclick="simpanreviewquality()" hidden><img src="../asset/icon/save.png"> Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Review -->
        <div class="tab-pane fade show" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
            <div class="form-group row mb-0">
                <label for="personalnumberemployee" class="col-sm-2 col-form-label">Planning Number<sup class="text-danger">*</sup></label>
                <div class="col-sm-2">
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" placeholder="Nomor Planning" aria-label="Recipient's username" aria-describedby="button-addon2" id="planningnumber_result_reviewquality">
                        <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchplanningnumber2reviewquality"><span><img src="../asset/icon/cari.png"></span></button>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-0">
                <label for="yearsreviewquality2" class="col-sm-2 col-form-label">Planning Years</label>
                <div class="col-sm-1">
                    <input type="text" class="form-control form-control-sm bg-transparent" id="yearsreviewquality2" readonly>
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-sm-2 offset-2">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="showreportqualityassurance()"><img src="../asset/icon/accept.png"> Submit</button>
                </div>
            </div>
            <div class="form-group row mt-5">
                <h6 class="text-start">Pilih report yang akan ditampilkan</h6>
                <hr class="w-50 mb-3">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="cetakpreparehoperreviewquality" checked disabled>
                                <label class="form-check-label" for="cetakpreparehoperreviewquality">
                                    Prepare Hopper
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="cetakproseshoperreviewquality" checked disabled>
                                <label class="form-check-label" for="cetakproseshoperreviewquality">
                                    Proses Hopper
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="cetakpreparetopackreviewquality" checked disabled>
                                <label class="form-check-label" for="cetakpreparetopackreviewquality">
                                    Prepare Topack
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="cetakprosestopackreviewquality" checked disabled>
                                <label class="form-check-label" for="cetakprosestopackreviewquality">
                                    Proses Topack
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="cetakpreparepillowreviewquality" checked disabled>
                                <label class="form-check-label" for="cetakpreparepillowreviewquality">
                                    Prepare Pillow Pack
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="cetakprosespillowreviewquality" checked disabled>
                                <label class="form-check-label" for="cetakprosespillowreviewquality">
                                    Proses Pillow Pack
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="cetakreviewqualityreviewquality" checked disabled>
                                <label class="form-check-label" for="cetakreviewqualityreviewquality">
                                    Review Quality
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="cetakworkorderreviewquality" disabled>
                                <label class="form-check-label" for="cetakworkorderreviewquality">
                                    Work Order
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="cetakpengemasansekunderreviewquality" disabled>
                                <label class="form-check-label" for="cetakpengemasansekunderreviewquality">
                                    Analisa Pengemasan Sek.
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="cetakanalisarhsuhureviewquality" disabled>
                                <label class="form-check-label" for="cetakanalisarhsuhureviewquality">
                                    Analisa RH & Suhu
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Planning Number Review 1-->
<div class="modal fade" id="searchplanningnumberreviewquality" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">List Planning Number</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="ddisplayplanning0" class="table table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Planning Number</th>
                            <th>Years</th>
                            <th>Product ID</th>
                            <!-- <th>Description</th> -->
                            <th>Batch</th>
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
                                                                                                 ReviewMG='X' AND ReviewQA is null ORDER BY PlanningNumber ASC");
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td style="width: 10%;"><a href="#" class="badge bg-success href_transform" onclick="prosesselectreviewquality('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>',1)"><?= $row['PlanningNumber'] ?></a></td>
                                <td><?= $row['Years'] ?></td>
                                <td><?= $row['ProductID'] ?></td>
                                <!-- <td style="width: 40%;"><?= Getdata('ProductDescriptions', 'mara_product', 'ProductID', $row['ProductID']) ?></td> -->
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

<!-- Planning Number Review 2-->
<div class="modal fade" id="searchplanningnumber2reviewquality" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">List Planning Number</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="ddisplayplanning1" class="table table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Planning Number</th>
                            <th>Years</th>
                            <th>Product ID</th>
                            <!-- <th>Description</th> -->
                            <th>Batch</th>
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
                                                                                                 ReviewMG ='X' AND ReviewQA is null ORDER BY PlanningNumber ASC");
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td style="width: 10%;"><a href="#" class="badge bg-success href_transform" onclick="prosesselectreviewquality('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>',2)"><?= $row['PlanningNumber'] ?></a></td>
                                <td><?= $row['Years'] ?></td>
                                <td><?= $row['ProductID'] ?></td>
                                <!-- <td style="width: 40%;"><?= Getdata('ProductDescriptions', 'mara_product', 'ProductID', $row['ProductID']) ?></td> -->
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