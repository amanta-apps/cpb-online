<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/report.png"> Input Parameter Report</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <label for="personalnumberemployee" class="col-sm-2 col-form-label">Nomor Planning<sup class="text-danger">*</sup></label>
        <div class="col-sm-2">
            <div class="input-group mb-1">
                <input type="text" class="form-control" placeholder="Nomor Planning" aria-label="Recipient's username" aria-describedby="button-addon2" id="nomorplanningreport">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchplanningreport"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="personalnumberemployee" class="col-sm-2 col-form-label">Transaksi<sup class="text-danger">*</sup></label>
        <div class="col-sm-4">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="jenistransaksi" id="jenistransaksihoper" value="1" onchange="jenistransaksi(this.value)" checked>
                <label class="form-check-label" for="jenistransaksi">
                    Hopper
                </label>
            </div>
            <div id="subcekhoper" class="ps-3">
                <div class="form-check col-sm-12">
                    <input class="form-check-input" type="radio" name="subjenistransaksi" id="subjenistransaksipreparehoper" checked>
                    <label class="form-check-label" for="subjenistransaksi">
                        Prepare Hopper
                    </label>
                </div>
                <div class="form-check col-sm-12">
                    <input class="form-check-input" type="radio" name="subjenistransaksi" id="subjenistransaksiproseshoper">
                    <label class="form-check-label" for="subjenistransaksi">
                        Proses Hopper
                    </label>
                </div>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="jenistransaksi" id="jenistransaksitopack" value="2" onchange="jenistransaksi(this.value)">
                <label class="form-check-label" for="jenistransaksi">
                    Topack
                </label>
            </div>
            <div id="subcektopack" class="ps-3" hidden>
                <div class="form-check col-sm-12">
                    <input class="form-check-input" type="radio" name="subjenistransaksi" id="subjenistransaksipreparetopack">
                    <label class="form-check-label" for="subjenistransaksi">
                        Prepare Topack
                    </label>
                </div>
                <div class="form-check col-sm-12">
                    <input class="form-check-input" type="radio" name="subjenistransaksi" id="subjenistransaksiprosestopack">
                    <label class="form-check-label" for="subjenistransaksi">
                        Proses Topack
                    </label>
                </div>
                <!-- <div class="form-check col-sm-12">
                    <input class="form-check-input" type="radio" name="subjenistransaksi" id="subjenistransaksirekontopack">
                    <label class="form-check-label" for="subjenistransaksi">
                        Rekonsiliasi Topack
                    </label>
                </div> -->
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="jenistransaksi" id="jenistransaksipillow" value="3" onchange="jenistransaksi(this.value)">
                <label class="form-check-label" for="jenistransaksi">
                    Pillow
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="jenistransaksi" id="jenistransaksitinjauanqa" value="4" onchange="jenistransaksi(this.value)">
                <label class="form-check-label" for="jenistransaksi">
                    Tinjauan QA
                </label>
            </div>
            <!-- <div id="subcekpillow" class="ps-3" hidden>
                <div class="form-check col-sm-12">
                    <input class="form-check-input" type="radio" name="subjenistransaksi" id="subjenistransaksipreparepillow">
                    <label class="form-check-label" for="subjenistransaksi">
                        Prepare Pillow
                    </label>
                </div>
                <div class="form-check col-sm-12">
                    <input class="form-check-input" type="radio" name="subjenistransaksi" id="subjenistransaksiprosespillow">
                    <label class="form-check-label" for="subjenistransaksi">
                        Proses Pillow
                    </label>
                </div>
                <div class="form-check col-sm-12">
                    <input class="form-check-input" type="radio" name="subjenistransaksi" id="subjenistransaksirekonpillow">
                    <label class="form-check-label" for="subjenistransaksi">
                        Rekonsiliasi Pillow
                    </label>
                </div>
            </div> -->
        </div>
    </div>
    <!-- <div class="form-group row mb-0">
        <label for="personalnumberemployee" class="col-sm-2 col-form-label"></label>
        <div class="col-sm-10">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                <label class="form-check-label" for="flexSwitchCheckChecked">Show PDF</label>
            </div>
        </div>
    </div> -->
    <div class="form-group row mt-3">
        <div class="col-sm-2 offset-2">
            <button type="button" class="btn btn-outline-dark btn-sm" onclick="showreportcpb()"><img src="../asset/icon/accept.png"> Submit</button>
        </div>
    </div>
</div>
<!-- Planning Number-->
<div class="modal fade" id="searchplanningreport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                            <th>Product ID</th>
                            <th>Shift ID</th>
                            <th>Packing Date</th>
                            <th>Resource ID</th>
                            <th>Batch</th>
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
                        $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header");
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td><a href="#" class="badge bg-success href_transform" onclick="prosesselectreport('<?= $row['PlanningNumber'] ?>')"><?= $row['PlanningNumber'] ?></a></td>
                                <td><?= $row['ProductID'] ?></td>
                                <td><?= $row['ShiftID'] ?></td>
                                <td><?= $row['PackingDate'] ?></td>
                                <td><?= $row['ResourceID'] ?></td>
                                <td><?= $row['BatchNumber'] ?></td>
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