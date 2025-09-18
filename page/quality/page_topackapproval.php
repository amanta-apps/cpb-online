<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/lab.png"> QC Result - Engine Set Approval</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <label for="personalnumberenginesetapproval" class="col-sm-2 col-form-label">Planning Number</label>
        <div class="col-sm-2">
            <div class="input-group mb-1">
                <input type="text" class="form-control" placeholder="Planning Number" aria-label="Recipient's username" aria-describedby="button-addon2" id="planningnumberenginesetapproval">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchplanningnumberenginesetapproval"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
        <label for="yearsenginesetapproval" class="col-sm-2 col-form-label">Planning Years</label>
        <div class="col-sm-1">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="yearsenginesetapproval" readonly>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="productenginesetapproval" class="col-sm-2 col-form-label">Product ID</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="productenginesetapproval" readonly>
        </div>
        <label for="batchenginesetapprovalc" class="col-sm-1 col-form-label">Batch</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="batchenginesetapproval" readonly>
        </div>
    </div>
    <div class="form-group row mb-1">
        <label for="deskripsipersiapanhoperqc" class="col-sm-2 col-form-label">Description</label>
        <div class="col-sm-5">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="deskripsipersiapanhoperqc" readonly>
        </div>
    </div>
    <div class="accordion" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                    Sampling Awal QC
                </button>
            </h2>
            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
                <div class="accordion-body">
                    <div class="form-group row mb-0">
                        <label for="stats1enginesetapproval" class="col-sm-2 col-form-label">1. <?= GetdataII("Descriptions", "text_sys", "JenisProses", "enginesetapproval", "Item", 1) ?></label>
                        <div class="col-sm-2">
                            <select class="form-select form-select-sm" id="stats1enginesetapproval">
                                <option></option>
                                <?php
                                $query = mysqli_query($conn, "SELECT Descriptions FROM qc_catalog WHERE KodeCatalog='" . Getdata("EngineSetApproval", "general_setting_web", "UnitCode", "S001") . "'");
                                while ($q = mysqli_fetch_array($query)) { ?>
                                    <option value="<?= $q['Descriptions'] ?>"><?= $q['Descriptions'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="stats2enginesetapproval" class="col-sm-2 col-form-label">2. <?= GetdataII("Descriptions", "text_sys", "JenisProses", "enginesetapproval", "Item", 2) ?></label>
                        <div class="col-sm-2">
                            <select class="form-select form-select-sm" id="stats2enginesetapproval">
                                <option></option>
                                <?php
                                $query = mysqli_query($conn, "SELECT Descriptions FROM qc_catalog WHERE KodeCatalog='" . Getdata("EngineSetApproval", "general_setting_web", "UnitCode", "S001") . "'");
                                while ($q = mysqli_fetch_array($query)) { ?>
                                    <option value="<?= $q['Descriptions'] ?>"><?= $q['Descriptions'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="stats3enginesetapproval" class="col-sm-2 col-form-label">3. <?= GetdataII("Descriptions", "text_sys", "JenisProses", "enginesetapproval", "Item", 3) ?></label>
                        <div class="col-sm-2">
                            <select class="form-select form-select-sm" id="stats3enginesetapproval">
                                <option></option>
                                <?php
                                $query = mysqli_query($conn, "SELECT Descriptions FROM qc_catalog WHERE KodeCatalog='" . Getdata("EngineSetApproval", "general_setting_web", "UnitCode", "S001") . "'");
                                while ($q = mysqli_fetch_array($query)) { ?>
                                    <option value="<?= $q['Descriptions'] ?>"><?= $q['Descriptions'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="stats4enginesetapproval" class="col-sm-2 col-form-label">4. <?= GetdataII("Descriptions", "text_sys", "JenisProses", "enginesetapproval", "Item", 4) ?></label>
                        <div class="col-sm-2">
                            <select class="form-select form-select-sm" id="stats4enginesetapproval">
                                <option></option>
                                <?php
                                $query = mysqli_query($conn, "SELECT Descriptions FROM qc_catalog WHERE KodeCatalog='" . Getdata("EngineSetApproval", "general_setting_web", "UnitCode", "S001") . "'");
                                while ($q = mysqli_fetch_array($query)) { ?>
                                    <option value="<?= $q['Descriptions'] ?>"><?= $q['Descriptions'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mt-3 text-end">
                            <button type="button" id="simpanqenginesetapproval" class="btn btn-outline-success btn-sm" onclick="simpanqenginesetapproval()" hidden><img src="../asset/icon/save.png"> Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Planning Number HOPER-->
<div class="modal fade" id="searchplanningnumberenginesetapproval" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                <td style="width: 10%;"><a href="#" class="badge bg-success href_transform" onclick="prosesselectenginesetapproval('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>')"><?= $row['PlanningNumber'] ?></a></td>
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