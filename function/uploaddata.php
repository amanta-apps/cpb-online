<?php
date_default_timezone_set('Asia/Jakarta');
error_reporting(0);
session_start();
include 'koneksi.php';
$plant = $_SESSION['plant'];
$unitcode = $_SESSION['unitcode'];
$createdon = date("Y-m-d H:i:s");
$createdby = $_SESSION['userid'];
$type_of_transaksi = $_POST['typess'];

if ($type_of_transaksi == 'analisapengemasanprimer') {
    $sql = mysqli_query($conn, "SELECT * FROM master_directions WHERE Plant='$plant' AND UnitCode='$unitcode' AND Items=1");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $dir = $r['Directions'];
    }
    $temp = $dir;
    if (!file_exists($temp))
        mkdir($temp, 0777, true);
    $planningnumber = $_POST['planningnumber'];
    $years = $_POST['years'];
    $jam = $_POST['jam'];
    $keterangan = $_POST['keterangan'];
    $return = false;

    $fileupload      = $_FILES['fileupload']['tmp_name'];
    $ImageName       = $_FILES['fileupload']['name'];
    $ImageType       = $_FILES['fileupload']['type'];
    if (!empty($fileupload)) {
        $ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
        $NewImageName   = $planningnumber . $years . '-' . date('dmYHis')  . $ImageExt;
        $sql = mysqli_query($conn, "SELECT * FROM qc_analisapengemasanprimer_three_detail WHERE Plant='$plant' AND 
                                                                                                UnitCode='$unitcode' AND
                                                                                                PlanningNumber='$planningnumber' AND
                                                                                                Years='$years' AND
                                                                                                Jam='$jam'");
        if (mysqli_num_rows($sql) == 0) {
            $query = mysqli_query($conn, "INSERT INTO qc_analisapengemasanprimer_three_detail (Plant,
                                                                                    UnitCode,
                                                                                    PlanningNumber,
                                                                                    Years,
                                                                                    Jam,
                                                                                    Keterangan,
                                                                                    GambarSachet,
                                                                                    OrgGambar,
                                                                                    CreatedOn,
                                                                                    CreatedBy)
                                VALUES('$plant',
                                        '$unitcode',
                                        '$planningnumber',
                                        '$years',
                                        '$jam',
                                        '$keterangan',
                                        '$NewImageName',
                                        '$ImageName',
                                        '$createdon',
                                        '$createdby')");
            if ($query === true) {
                move_uploaded_file($_FILES["fileupload"]["tmp_name"], $temp . $NewImageName);
                $return = true;
            }
        }
    }
    echo $return;
}
