<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/menu.png"> DAFTAR MENU</h6>
    <hr class="w-50 mb-3">
    <div class="card shadow-lg border-0 mb-1" id="cardcolor">
        <div class="form-group row mb-0">
            <label for="idprodukdataproduk" class="col-sm-2 col-form-label">Menu</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm text-lowercase" id="menudaftarmenu">
            </div>
        </div>
        <div class="form-group row mb-0">
            <label for="deskripsidataproduk" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-5">
                <input type="text" class="form-control form-control-sm" id="deskripsidaftarmenu">
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-4">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="simpanmenu()"><img src="../asset/icon/save.png"> Save</button>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload()"><img src="../asset/icon/cancel.png"> Cancel</button>
            </div>
        </div>
    </div>
    <table id="configmenu" class="table table-striped table-sm" style="width:100%">
        <thead class="bg-dark text-white">
            <tr>
                <th style="width: 5%;"></th>
                <th>Menu</th>
                <th>Description</th>
            </tr>
        </thead>
        <!-- <tbody>
            <?php
            $i = 1;
            $sql = mysqli_query($conn, 'SELECT * FROM agr_menu');
            while ($row = mysqli_fetch_array($sql)) {
            ?>
                <tr>
                    <td>
                        <a href="#" class="badge bg-danger text-decoration-none href_transform" onclick="deletedatamenu('<?= $row['Menus'] ?>')"> Delete</a>
                    </td>
                    <td><?= $row['Menus'] ?></td>
                    <td><?= $row['Descriptions'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody> -->
    </table>
</div>