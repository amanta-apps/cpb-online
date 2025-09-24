<?php
date_default_timezone_set('Asia/Jakarta');
error_reporting(0);
session_start();
include 'koneksi.php';
$plant = $_SESSION['plant'];
$unitcode = $_SESSION['unitcode'];
$createdon = date("Y-m-d H:i:s");
$createdby = $_SESSION['userid'];
$changedon = date("Y-m-d H:i:s");
$changedby = $_SESSION['userid'];
$type_of_transaksi = $_POST['typess'];
$time = 1500;
$NewImageName = null;
$data = array();

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
} elseif ($type_of_transaksi == 'document_nomorlot') {
    try {
        mysqli_commit($conn, FALSE);
        // mysqli_begin_transaction($conn);
        $sql = mysqli_query($conn, "SELECT Directions FROM master_directions WHERE Plant='$plant' AND UnitCode='$unitcode' AND Items=2");
        if (mysqli_num_rows($sql) <> 0) {
            $r   = mysqli_fetch_array($sql);
            $dir = $r['Directions'];
        }
        $temp = $dir;
        if (!file_exists($temp)) {
            mkdir($temp, 0777, true);
        }

        $nomorlot        = $_POST['nomorlot'] ?? '';
        $kodesupplier    = $_POST['kodesupplier'] ?? '';
        include_once 'getvalue.php';
        $namasupplier    = Getdata('Descriptions', 'data_pemasok', 'Idpemasok', $kodesupplier);
        $join            = $_POST['join'] ?? '';

        $return    = false;
        $iconmsgs  = "error";
        $msg      = "Gagal simpan data";

        // =============== Upload file (jika ada) ===============
        if (!empty($_FILES['lampiran']['name'][0])) {
            $uploadedFiles = [];
            foreach ($_FILES['lampiran']['name'] as $key => $name) {
                $tmpName = $_FILES['lampiran']['tmp_name'][$key];
                $error   = $_FILES['lampiran']['error'][$key];
                $ImageName = $_FILES['lampiran']['name'];
                $ImageType  = $_FILES['lampiran']['type'];

                // if ($error === UPLOAD_ERR_OK) {
                $NewImageName   = date('dmYHis')  . '^^' . $name;
                $targetFile = $temp . $NewImageName;

                if (move_uploaded_file($tmpName, $targetFile)) {
                    $query = mysqli_query($conn, "INSERT INTO table_datadoclot
                                                    (nomorlot, documenaddress, createdby, createdon) 
                                                    VALUES 
                                                    ('$nomorlot','$NewImageName','$createdby','$createdon')");
                    $return = true;
                    $uploaded[] = $NewImageName;
                }
            }
        }

        $query = mysqli_query($conn, "SELECT NomorLot FROM data_lot WHERE NomorLot='$nomorlot'");
        if (mysqli_num_rows($query) <> 0) {
            $update = mysqli_query($conn, "UPDATE data_lot SET KodeSupplier='$kodesupplier',
                                                                NamaSupplier='$namasupplier',
                                                                Joins='$join',
                                                                changedon='$changedon',
                                                                changedby='$changedby'
                                                            WHERE Plant='$plant' AND
                                                                UnitCode='$unitcode' AND
                                                                 NomorLot='$nomorlot'");
            if (!$update) {
                throw new Exception("Gagal update header: " . mysqli_error($conn));
            }
        } else {
            $insert = mysqli_query($conn, "INSERT INTO data_lot 
                                                (Plant, 
                                                UnitCode, 
                                                NomorLot, 
                                                KodeSupplier, 
                                                NamaSupplier, 
                                                Joins,
                                                CreatedBy, 
                                                CreatedOn) 
                                VALUES('$plant',
                                '$unitcode',
                                '$nomorlot',
                                '$kodesupplier',
                                '$namasupplier',
                                '$join',
                                '$createdby',
                                '$createdon')");
            if (!$insert) {
                throw new Exception("Gagal insert header: " . mysqli_error($conn));
            }
        }

        mysqli_commit($conn);
        $msg     = "Data Tersimpan";
        $iconmsg = "success";
        $return   = true;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $msg     = $e->getMessage();
        $iconmsg = "error";
        $return   = false;
        errorlog($e->getMessage());
    }

    $data = [
        "iconmsg"  => $iconmsgs,
        "msg"      => $msg,
        "time"      => $time,
        "link" => 'nomorlot',
        "return"    => $return
    ];

    echo json_encode($data);
}
