<?php
$kodesupplier = $namasupplier = $nomorlot = $joins = $readonly = null;
if (isset($_GET['n'])) {
    $readonly = 'readonly';
    $nomorlot = base64_decode($_GET['n']);
    $r = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM data_lot WHERE Plant='$plant' AND NomorLot='$nomorlot'"));
    $kodesupplier = $r['KodeSupplier'];
    $namasupplier = $r['NamaSupplier'];
    $nomorlot  = $r['NomorLot'];
    $joins = $r['Joins'];
}
?>
<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/barcode.png"> Nomor Lot</h6>
    <hr class="w-50 mb-3">
    <div class="card shadow-lg border-0 mb-1" id="cardcolor">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group row mb-0">
                    <label for="nomorlotuploadnomorlot" class="col-sm-4 col-form-label">Nomor Lot</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="nomorlotuploadnomorlot" value="<?= $nomorlot ?>" <?= $readonly ?>>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-sm-8 offset-4">
                        <hr>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="namasuppliernomorlot2" class="col-sm-4 col-form-label">Supplier/Vendor</label>
                    <div class="col-sm-8">
                        <select id="kodesuppliernomorlot" class="select2">
                            <option value="<?= $kodesupplier ?>"><?= $namasupplier ?></option>
                            <?php
                            $query = mysqli_query($conn, "SELECT Idpemasok,Descriptions FROM data_pemasok");
                            while ($r = mysqli_fetch_array($query)) { ?>
                                <option value="<?= $r['Idpemasok'] ?>"><?= $r['Descriptions'] ?></option>
                            <?php
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="joinnomorlot" class="col-sm-4 col-form-label">Join</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="joinnomorlot" value="<?= $joins ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-8 offset-4 mt-2">
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="simpandatanomorlot()"><img src="../asset/icon/save.png"> Simpan</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                Upload Files
                <div class="col-sm-12">
                    <input type="file" id="lampiran" name="lampiran[]" multiple class="form-control mb-2" accept="image/*">
                    <ol id="filelist" class="mt-2"></ol>
                    <input type="text" class="form-control form-control-sm" id="descimgdraftsp" readonly hidden>
                </div>
                <?php
                $query = mysqli_query($conn, "SELECT documenid,documenaddress,createdon,createdby FROM table_datadoclot WHERE nomorlot='$nomorlot'");
                if (mysqli_num_rows($query)) { ?>
                    <div class="form-group row mb-1">
                        <fieldset class="border rounded p-2 mb-3">
                            <legend class="float-none w-auto px-2">Files</legend>
                            <table class="table table-borderless w-75">
                                <tbody>
                                    <?php
                                    while ($r = mysqli_fetch_array($query)) { ?>
                                        <tr>
                                            <td>
                                                <a href="#" onclick="downloadlink(2,'<?= $r['documenaddress'] ?>',2)"><?= $r['documenaddress'] ?></a>
                                            </td>
                                            <td class="text-end opacity-50 fs-7"><?= Getpernr($r['createdby']) . ' - ' . Getnamakaryawan($r['createdby']) . ', ' . beautydate2($r['createdon']) ?></td>
                                            <td style="width: 10%;">
                                                <img src="../asset/icon/trash10.png" class="zoom opacity-50" style="cursor: pointer;" title="delete" onclick="deleteimg('<?= $r['documenaddress'] ?>',2,'table_datadoclot','<?= $r['documenid'] ?>')">
                                                <img src="../asset/icon/download15.png" class="zoom opacity-50" style="cursor: pointer;" title="download" onclick="downloadlink(16,'<?= $r['imgnotice'] ?>',1)">
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </fieldset>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <table id="dmenu" class="table table-striped table-sm" style="width:100%">
        <thead class="bg-dark text-white">
            <tr>
                <th>#</th>
                <th>Nomor Lot</th>
                <th>Kode Supplier</th>
                <th>Nama Supplier</th>
                <th>Join</th>
                <th>Status</th>
                <th>Created On</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $sql = mysqli_query($conn, "SELECT * FROM data_lot WHERE Plant='$plant' AND UnitCode='$unitcode'");
            while ($row = mysqli_fetch_array($sql)) {
            ?>
                <tr>
                    <td>
                        <img src="../asset/icon/pencil10.png" class="zoom" style="cursor: pointer;" title="Change" onclick="redirectlink('nomorlot','<?= $row['NomorLot'] ?>')"> |
                        <img src="../asset/icon/trash10.png" class="zoom" style="cursor: pointer;" title="Delete" onclick="deletenomorlot('<?= $row['NomorLot'] ?>')">
                    </td>
                    <td><?= $row['NomorLot'] ?></td>
                    <td><?= $row['KodeSupplier'] ?></td>
                    <td><?= $row['NamaSupplier'] ?></td>
                    <td><?= $row['Joins'] ?></td>
                    <td><?= $row['StatsX'] ?></td>
                    <td><?= $row['CreatedOn'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
</div>

<!-- Modal Search Supplier-->
<!-- <div class="modal fade" id="searchkodesuppliernomorlot" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6>List Supplier</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="dsearchdata4" class="table table-striped table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="width: 10%;">Kode</th>
                            <th style="width: 30%;">Nama</th>
                            <th>Ketarangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, "SELECT KodeSupplier,NamaSupplier,Keterangan FROM data_supplier WHERE Plant='$plant' AND UnitCode='$unitcode'");
                        while ($row = mysqli_fetch_array($sql)) { ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-success text-decoration-none href_transform" onclick="selectsuppliernomorlot('<?= $row['KodeSupplier'] ?>','<?= $row['NamaSupplier'] ?>','<?= $row['Keterangan'] ?>')"><?= $row['KodeSupplier'] ?></a>
                                </td>
                                <td class="fw-bold"><?= $row['NamaSupplier'] ?></td>
                                <td><?= $row['Keterangan'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> -->

<script>
    document.getElementById("lampiran").addEventListener("change", function() {
        let files = this.files;
        let fileNames = [];
        let fileList = document.getElementById("filelist");
        fileList.innerHTML = ""; // reset list

        for (let file of files) {
            fileNames.push(file.name);

            // buat <a> link preview
            let li = document.createElement("li");
            let a = document.createElement("a");
            a.textContent = file.name;
            a.href = URL.createObjectURL(file);
            a.target = "_blank"; // biar buka di tab baru
            li.appendChild(a);

            fileList.appendChild(li);
        }

        // gabungkan semua nama file ke input text
        document.getElementById("descimgdraftsp").value = fileNames.join(", ");
    });
</script>