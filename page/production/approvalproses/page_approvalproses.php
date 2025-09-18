<?php
$variabel = $_GET['v'];
$x = explode("*", $variabel);
$jenisproses = $x[0];
$status = $x[1];
// if ($x[1] == 'disetujui') {
//     $status = 'X';
// } else if ($x[1] == 'belumdisetujui') {
//     $status = '';
// } else {
//     $status = 'all';
// }
$createonfrom = $x[2];
$createonto = $x[3];
$plant = $_SESSION['plant'];
$unitcode = $_SESSION['unitcode'];
?>
<div class="container">
    <h6 class="fw-bold mt-3 text-start">APPROVAL PROSES</h6>
    <hr class="w-50 mb-3">
    <!-- <div class="table-responsive"> -->
    <table id="ddisplayplanning0" class="table table-sm" style="width:100%;">
        <thead class="bg-dark text-white">
            <tr>
                <th>Planing Number</th>
                <th>Years</th>
                <th>Product ID</th>
                <th>Bacth</th>
                <th>Jenis Proses</th>
                <th>Created On</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($jenisproses == '' && $status == '') {
                $sql = mysqli_query($conn, "SELECT * FROM approval_step_processing
                    WHERE (Date(DateTimeCreated) >= '" . $createonfrom . "' AND Date(DateTimeCreated) <= '" . $createonto . "') AND 
                    Plant='$plant' AND UnitCode='$unitcode' AND Approval=''");
            } elseif ($jenisproses != '' && $status == '') {
                $sql = mysqli_query($conn, "SELECT * FROM approval_step_processing
                        WHERE (Date(DateTimeCreated) >= '" . $createonfrom . "' AND Date(DateTimeCreated) <= '" . $createonto . "') AND 
                        JenisProses='$jenisproses' AND Approval='' AND Plant='$plant' AND UnitCode='$unitcode'");
            } elseif ($jenisproses == '' && $status != '') {
                $sql = mysqli_query($conn, "SELECT * FROM approval_step_processing
                        WHERE (Date(DateTimeCreated) >= '" . $createonfrom . "' AND Date(DateTimeCreated) <= '" . $createonto . "') AND 
                        Approval='$status' AND Plant='$plant' AND UnitCode='$unitcode'");
                if ($status == 'all') {
                    $sql = mysqli_query($conn, "SELECT * FROM approval_step_processing
                        WHERE (Date(DateTimeCreated) >= '" . $createonfrom . "' AND Date(DateTimeCreated) <= '" . $createonto . "') AND
                        Plant='$plant' AND UnitCode='$unitcode'");
                }
            } elseif ($jenisproses != '' && $status != '') {
                $sql = mysqli_query($conn, "SELECT * FROM approval_step_processing
                    WHERE (Date(DateTimeCreated) >= '" . $createonfrom . "' AND Date(DateTimeCreated) <= '" . $createonto . "') AND 
                    JenisProses='$jenisproses' AND Approval='$status' AND Plant='$plant' AND UnitCode='$unitcode'");
                if ($status == 'all') {
                    $sql = mysqli_query($conn, "SELECT * FROM approval_step_processing
                    WHERE (Date(DateTimeCreated) >= '" . $createonfrom . "' AND Date(DateTimeCreated) <= '" . $createonto . "') AND 
                    JenisProses='$jenisproses' AND Plant='$plant' AND UnitCode='$unitcode'");
                }
            }
            while ($row = mysqli_fetch_array($sql)) {
            ?>
                <tr>
                    <td>
                        <?php
                        if ($row['Approval'] == 'X') { ?>
                            <a href="#" class="badge bg-success href_transform" id="planningnumberdisplayplanning" onclick="prosesdisplayapprovalproses('<?= $row['PlanningNumber'] ?>','<?= $row['JenisProses'] ?>','<?= $row['Years'] ?>')"><?= $row['PlanningNumber'] ?></a>
                        <?php } else { ?>
                            <a href="#" class="badge bg-danger href_transform" id="planningnumberdisplayplanning" onclick="prosesdisplayapprovalproses('<?= $row['PlanningNumber'] ?>','<?= $row['JenisProses'] ?>','<?= $row['Years'] ?>')"><?= $row['PlanningNumber'] ?></a>
                        <?php
                        } ?>
                    </td>
                    <td><?= $row['Years'] ?></td>
                    <td><?= GetdataIV('ProductID', 'planning_prod_header', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $row['PlanningNumber'], 'Years', $row['Years']) ?></td>
                    <td><?= GetdataIV('BatchNumber', 'planning_prod_header', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $row['PlanningNumber'], 'Years', $row['Years']) ?></td>
                    <td><?= $row['JenisProses'] ?></td>
                    <td><?= $row['DateTimeCreated'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <!-- </div> -->
</div>
<!-- Modal Display Approval Proses-->
<div class="modal fade" id="modaldisplayapprovalproses" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Display Approval Proses - <label id="titleapprovalproses"></label></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="border-0 mb-0">
                    <div class="form-group row mb-0">
                        <label for="planningnumberapprovalproses" class="col-sm-2 offset-8 col-form-label">Planning Number</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="planningnumberapprovalproses" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="productidapprovalproses" class="col-sm-2 col-form-label">Product ID</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="productidapprovalproses" readonly>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0 fw-bold" id="descriptionproductapprovalproses" readonly>
                        </div>
                        <label for="createonapprovalproses" class="col-sm-2">Created On</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="createonapprovalproses" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="batchapprovalproses" class="col-sm-2 form-label">Batch</label>
                        <div class="col-sm-2">
                            <input type="text" id="batchapprovalproses" class="form-control form-control-sm text-uppercase" readonly>
                        </div>
                        <label for="createbyapprovalproses" class="col-sm-2 offset-4">Created By</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="createbyapprovalproses" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="expireddateapprovalproses" class="col-sm-2 form-label">Expired Date</label>
                        <div class="col-sm-2">
                            <input type="text" id="expireddateapprovalproses" class="form-control form-control-sm" readonly>
                        </div>
                        <label for="changedonapprovalproses" class="col-sm-2 offset-4">Changed On</label>
                        <div class="col-sm-2">
                            <input type="text" id="changedonapprovalproses" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="shiftapprovalproses" class="col-sm-2 col-form-label">Shift</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="shiftapprovalproses" readonly>
                        </div>
                        <label for="changedbyapprovalproses" class="col-sm-2 offset-4">Changed By</label>
                        <div class="col-sm-2">
                            <input type="text" id="changedbyapprovalproses" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="kodemesinapprovalproses" class="col-sm-2 col-form-label">Kode Mesin</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="kodemesinapprovalproses" readonly>
                        </div>
                        <label for="tglkemasapprovalproses" class="col-sm-2">Tgl Kemas</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="tglkemasapprovalproses" readonly>
                        </div>
                        <label for="statusapprovalapprovalproses" class="col-sm-2">Status</label>
                        <div class="col-sm-2">
                            <input type="text" id="statusapprovalapprovalproses" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="kodemesinmixingapprovalproses" class="col-sm-2">Kode Mesin Mixing</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="kodemesinmixingapprovalproses" readonly>
                        </div>
                        <label for="tglmixingapprovalproses" class="col-sm-2 form-label">Tgl Mixing</label>
                        <div class="col-sm-2">
                            <input type="text" id="tglmixingapprovalproses" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-end">
                            <button type="button" class="btn btn-outline-success btn-sm" id="savechangeplanning" onclick="approvedapprovalproses()" hidden><img src="../asset/icon/like.png"> Approved</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End -->