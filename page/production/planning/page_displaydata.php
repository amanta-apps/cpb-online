<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/input.png"> Input Parameter</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <label for="personalnumberemployee" class="col-sm-2 col-form-label">Nomor Planning<sup class="text-danger">*</sup></label>
        <div class="col-sm-2">
            <div class="input-group mb-1">
                <input type="text" class="form-control" placeholder="Nomor Planning" aria-label="Recipient's username" aria-describedby="button-addon2" id="nomorplanningdisplaydata">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchplanningdisplaydata"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="yeardisplaydata" class="col-sm-2 col-form-label">Planning Years</label>
        <div class="col-sm-1">
            <input type="number" class="form-control" id="yeardisplaydata" value="<?= date('Y') ?>" max="<?= date('Y') ?>">
        </div>
    </div>
    <div class="form-group row mt-3">
        <div class="col-sm-10 offset-2 text-start">
            <button type="button" class="btn btn-outline-dark btn-sm" id="submitdisplaydata" onclick="submitstartdisplaydata()"><img src="../asset/icon/accept.png">Submit</button>
        </div>
    </div>
</div>
</div>

<!-- Planning Number-->
<div class="modal fade" id="searchplanningdisplaydata" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                <td><a href="#" class="badge bg-success href_transform" onclick="prosesselectdisplaydata('<?= $row['PlanningNumber'] ?>','<?= $row['Years'] ?>')"><?= $row['PlanningNumber'] ?></a></td>
                                <td><?= $row['Years'] ?></td>
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