<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/tracking.png"> Tracking Batch</h6>
    <hr class="w-100 mb-3">
    <div class="form-group row mb-0">
        <label for="productidlacakplanning" class="col-sm-2 col-form-label">Product ID</label>
        <div class="col-sm-2">
            <div class="input-group mb-1">
                <input type="text" class="form-control" placeholder="Product ID" aria-label="Recipient's username" aria-describedby="button-addon2" id="productidlacakplanning" value="<?= $_GET['x'] ?>">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchproduklacakplanning"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="betslacakplanning" class="col-sm-2 col-form-label">Batch Number</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm" id="betslacakplanning" placeholder="Batch" value="<?= $_GET['y'] ?>">
        </div>
    </div>
    <div class="form-group row mt-0">
        <div class="col-sm-10 offset-2 text-start">
            <button type="button" class="btn btn-outline-secondary btn-sm" id="submitdisplaydata" onclick="submitstartlacakplanning()"><img src="../asset/icon/accept.png">Submit</button>
        </div>
    </div>
    <section class="mt-5 overflow-scroll" id="showlacakbets">

    </section>
</div>

<!-- Modal Search Product-->
<div class="modal fade" id="searchproduklacakplanning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Search Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="dsearchdata" class="table table-striped table-responsive-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 10%;">Option</th>
                            <th style="width: 10%;">Product ID</th>
                            <th>Descriptions</th>
                            <th hidden>Total Self Life</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $sql = mysqli_query($conn, 'SELECT * FROM mara_product');
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none" onclick="$('#productidlacakplanning').val('<?= $row['ProductID'] ?>'),$('#searchproduklacakplanning').modal('hide')">Select</a>
                                </td>
                                <td><?= $row['ProductID'] ?></td>
                                <td><?= $row['ProductDescriptions'] ?></td>
                                <td hidden><?= $row['TotalSelfLife'] ?></td>
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