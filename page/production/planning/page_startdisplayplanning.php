<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/display.png"> DISPLAY PLANNING</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <label for="productidstartdisplayplanning" class="col-sm-2 col-form-label">Product ID</label>
        <div class="col-sm-2">
            <div class="input-group mb-1">
                <input type="text" class="form-control" placeholder="Product ID" aria-label="Recipient's username" aria-describedby="button-addon2" id="productidstartdisplayplanning">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchprodukstartdisplayplanning"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="batchstartdisplayplanning" class="col-sm-2 col-form-label">Batch Number</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm" id="batchstartdisplayplanning" placeholder="Batch">
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="packingdatefromstartdisplayplanning" class="col-sm-2 col-form-label">Packing Date</label>
        <div class="col-sm-2">
            <input type="date" class="form-control form-control-sm" id="packingdatefromstartdisplayplanning" value="<?= date('Y-m-d', strtotime('-7 days', strtotime(date('Y-m-d'))));  ?>">
        </div>
        <label for="packingdatetostartdisplayplanning" class="col-sm-1 col-form-label">To</label>
        <div class="col-sm-2">
            <input type="date" class="form-control form-control-sm" id="packingdatetostartdisplayplanning" value="<?= date('Y-m-d') ?>">
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="mixingdatefromstartdisplayplanning" class="col-sm-2 col-form-label">Mixing Date</label>
        <div class="col-sm-2">
            <input type="date" class="form-control form-control-sm" id="mixingdatefromstartdisplayplanning" value="<?= date('Y-m-d', strtotime('-7 days', strtotime(date('Y-m-d')))); ?>">
        </div>
        <label for="mixingdatetostartdisplayplanning" class="col-sm-1 col-form-label">To</label>
        <div class="col-sm-2">
            <input type="date" class="form-control form-control-sm" id="mixingdatetostartdisplayplanning" value="<?= date('Y-m-d') ?>">
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="maxshowstartdisplayplanning" class="col-sm-2 col-form-label">Max. Show</label>
        <div class="col-sm-1">
            <input type="number" class="form-control form-control-sm" id="maxshowstartdisplayplanning" value="100" min="1">
        </div>
        <div class="form-group row">
            <div class="col-sm-2 offset-2 mt-2">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="submitstartdisplayplanning()"><img src="../asset/icon/search.png"> Submit</button>
            </div>
        </div>
    </div>

    <!-- Modal Search Mixing Mesin-->
    <div class="modal fade" id="searchprodukstartdisplayplanning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="dsearchdata4" class="table table-striped table-sm" style="width:100%;">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th style="width: 10%;"></th>
                                <th style="width: 10%;">Product ID</th>
                                <th style="width: 70%;">Descriptions</th>
                                <th>Batch</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = mysqli_query($conn, 'SELECT DISTINCT ProductID FROM planning_prod_header');
                            while ($row = mysqli_fetch_array($sql)) {
                                $productid = $row['ProductID'];
                            ?>
                                <tr>
                                    <td>
                                        <a href="#" class="badge bg-success text-decoration-none href_transform" onclick="selectproductidstartdisplayplanning('<?= $productid ?>','<?= $row['BatchNumber'] ?>')">Select</a>
                                    </td>
                                    <td><?= $productid ?></td>
                                    <td><?= Getdata("ProductDescriptions", "mara_product", "ProductID", "$productid") ?></td>
                                    <td><?= $row['BatchNumber'] ?></td>
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