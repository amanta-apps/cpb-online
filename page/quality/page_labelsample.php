<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/print2.png"> Print Label Pengambilan Sample</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <label for="personalnumberemployee" class="col-sm-2 col-form-label">Inspection Lot</label>
        <div class="col-sm-2">
            <div class="input-group mb-1">
                <input type="text" class="form-control" placeholder="Insp. Lot" aria-label="Recipient's username" aria-describedby="button-addon2" id="pruefloslabelsample">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchplanningnumberlabelsample"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
    </div>
    <div class="form-group row mb-0" hidden>
        <label for="planningnumberlabelsample" class="col-sm-2 col-form-label">Planning Number</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="planningnumberlabelsample" readonly>
        </div>
        <div class="col-sm-1">
            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" id="plannningyearslabelsample" readonly>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="yeardisplaydata" class="col-sm-2 col-form-label">Insp. Years</label>
        <div class="col-sm-1">
            <input type="number" class="form-control" id="yearslabelsample" value="<?= date('Y') ?>" max="<?= date('Y') ?>">
        </div>
    </div>
    <div class="form-group row mt-1">
        <div class="col-sm-2 offset-2">
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="showlabelambilsample(0,0,$('#pruefloslabelsample').val(),
                                                                                                        $('#yearslabelsample').val())"><img src="../asset/icon/accept.png"> Submit</button>
        </div>
    </div>
</div>

<!-- Planning Number-->
<div class="modal fade" id="searchplanningnumberlabelsample" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">List Inspection Lot</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="printlabelsample" class="table table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Inspection Lot</th>
                            <th>Years</th>
                            <th>Product ID</th>
                            <th>Description</th>
                            <th>Batch</th>
                            <th>Planning Number</th>
                            <th>Plan. Years</th>
                            <th>Status</th>
                            <th>CreatedOn</th>
                        </tr>
                    </thead>
                    <!-- <tbody>
                        <?php
                        $plant = $_SESSION['plant'];
                        $unitcode = $_SESSION['unitcode'];
                        $sql = mysqli_query($conn, "SELECT * FROM insp_pengolahan_header WHERE Plant='$plant' AND UnitCode='$unitcode'");
                        if (mysqli_num_rows($sql) != 0) {
                            while ($row = mysqli_fetch_array($sql)) {
                        ?>
                                <tr>
                                    <td style="width: 10%;"><a href="#" class="badge bg-secondary text-white text-decoration-none" onclick="$('#pruefloslabelsample').val(<?= $row['InspectionLot'] ?>),
                                                                                                                                        $('#yearslabelsample').val(<?= $row['Lotyears'] ?>),
                                                                                                                                        $('#planningnumberlabelsample').val(<?= $row['PlanningNumber'] ?>),
                                                                                                                                        $('#plannningyearslabelsample').val(<?= $row['Years'] ?>),
                                                                                                                                        $('#searchplanningnumberlabelsample').modal('hide')"><?= $row['InspectionLot'] ?></a></td>
                                    <td><?= $row['Lotyears'] ?></td>
                                    <td><?= $row['ProductID'] ?></td>
                                    <td style="width: 40%;"><?= Getdata('ProductDescriptions', 'mara_product', 'ProductID', $row['ProductID']) ?></td>
                                    <td><?= $row['BatchNumber'] ?></td>
                                    <td><?= $row['PlanningNumber'] ?></td>
                                    <td><?= $row['Years'] ?></td>
                                    <td><?= $row['StatsY'] ?></td>
                                    <td><?= $row['CreatedOn'] ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody> -->
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End -->