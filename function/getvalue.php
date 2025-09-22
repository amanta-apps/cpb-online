<?php
date_default_timezone_set('Asia/Jakarta');
function Getkode($value, $table)
{
    include 'koneksi.php';
    $sql = mysqli_query($conn, "SELECT max($value) as kode FROM $table");
    $data = mysqli_fetch_array($sql);
    $result = $data['kode'];
    if ($value == 'ResourceID' && $table == "crhd") {
        $urutan = (int) substr($result, 4, 1);
        $urutan++;
        $code = Getdata('MainResourceCode', 'general_setting_web', 'UnitCode', 'S001');
        $return = $code . sprintf("%01s", $urutan);
    } elseif ($value == 'ShiftID') {
        $urutan = (int) substr($result, 2, 1);
        $urutan++;
        $code = Getdata('ShiftCode', 'general_setting_web', 'UnitCode', 'S001');
        $return = $code . sprintf("%01s", $urutan);
    } elseif ($value == 'PrimaryResourceID') {
        $urutan = (int) substr($result, 3, 2);
        $urutan++;
        $code = Getdata('PrimaryResourceCode', 'general_setting_web', 'UnitCode', 'S001');
        $return = $code . sprintf("%02s", $urutan);
    } elseif ($value == 'SecondaryResourceID') {
        $urutan = (int) substr($result, 2, 2);
        $urutan++;
        $code = Getdata('SecondaryResourceCode', 'general_setting_web', 'UnitCode', 'S001');
        $return = $code . sprintf("%02s", $urutan);
    } elseif ($value == 'ResourceID' && $table == "crhd_mixing") {
        $urutan = (int) substr($result, 4, 2);
        $urutan++;
        $code = Getdata('MixingResourceCode', 'general_setting_web', 'UnitCode', 'S001');
        $return = $code . sprintf("%02s", $urutan);
    } elseif ($value == 'UserID') {
        $urutan = (int) substr($result, 2, 3);
        $urutan++;
        $code = Getdata('UserIDCode', 'general_setting_web', 'UnitCode', 'S001');
        $return = $code . sprintf("%03s", $urutan);
    } elseif ($value == 'KodeSupplier') {
        $urutan = (int) substr($result, 4, 6);
        $urutan++;
        $code = Getdata('KodeSupplier', 'general_setting_web', 'UnitCode', 'S001');
        $return = $code . sprintf("%04s", $urutan);
    }
    return $return;
}
// -----> Get a single data.
function Getdata($value, $table, $where, $valuewhere)
{
    include 'koneksi.php';
    $sql = mysqli_query($conn, "SELECT $value FROM $table WHERE $where ='$valuewhere'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        return $q[$value];
    }
}
// -----> END
function GetdataII($value, $table, $where, $valuewhere, $where2, $valuewhere2)
{
    include 'koneksi.php';
    $sql = mysqli_query($conn, "SELECT $value FROM $table WHERE $where ='$valuewhere' AND $where2 ='$valuewhere2'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        return $q[$value];
    }
}
function GetdataIII($value, $table, $where, $valuewhere, $where2, $valuewhere2, $where3, $valuewhere3)
{
    include 'koneksi.php';
    $sql = mysqli_query($conn, "SELECT $value FROM $table WHERE $where ='$valuewhere' AND $where2 ='$valuewhere2' AND $where3 ='$valuewhere3'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        return $q[$value];
    }
}
function GetdataIV($value, $table, $where, $valuewhere, $where2, $valuewhere2, $where3, $valuewhere3, $where4, $valuewhere4)
{
    include 'koneksi.php';
    $sql = mysqli_query($conn, "SELECT $value FROM $table WHERE $where ='$valuewhere' AND $where2 ='$valuewhere2' AND $where3 ='$valuewhere3' AND $where4 ='$valuewhere4'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        return $q[$value];
    }
}
function GetdataV($value, $table, $where, $valuewhere, $where2, $valuewhere2, $where3, $valuewhere3, $where4, $valuewhere4, $where5, $valuewhere5)
{
    include 'koneksi.php';
    $sql = mysqli_query($conn, "SELECT $value FROM $table WHERE $where ='$valuewhere' AND $where2 ='$valuewhere2' AND $where3 ='$valuewhere3' AND $where4 ='$valuewhere4' AND $where5 ='$valuewhere5'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        return $q[$value];
    }
}
function GetdataVI($value, $table, $where, $valuewhere, $where2, $valuewhere2, $where3, $valuewhere3, $where4, $valuewhere4, $where5, $valuewhere5, $where6, $valuewhere6)
{
    include 'koneksi.php';
    $sql = mysqli_query($conn, "SELECT $value FROM $table WHERE $where ='$valuewhere' AND $where2 ='$valuewhere2' AND $where3 ='$valuewhere3' AND $where4 ='$valuewhere4' AND $where5 ='$valuewhere5' AND $where6 ='$valuewhere6'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        return $q[$value];
    }
}
function GetdataVII($value, $table, $where, $valuewhere, $where2, $valuewhere2, $where3, $valuewhere3, $where4, $valuewhere4, $where5, $valuewhere5, $where6, $valuewhere6, $where7, $valuewhere7)
{
    include 'koneksi.php';
    $sql = mysqli_query($conn, "SELECT $value FROM $table WHERE $where ='$valuewhere' AND $where2 ='$valuewhere2' AND $where3 ='$valuewhere3' AND $where4 ='$valuewhere4' AND $where5 ='$valuewhere5' AND $where6 ='$valuewhere6' AND $where7 ='$valuewhere7'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        return $q[$value];
    }
}
// ----> Get Nama Karyawan
function Getnamakaryawan($userid)
{
    include 'koneksi.php';
    $sql = mysqli_query($conn, "SELECT B.EmployeeName FROM usr02 AS A INNER JOIN pa001 AS B ON A.PersonnelNumber = B.PersonnelNumber
                                WHERE A.UserID='$userid'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        return $q['EmployeeName'];
    }
}
function Getnamakaryawan2($pernr)
{
    include 'koneksi.php';
    $sql = mysqli_query($conn, "SELECT EmployeeName FROM pa001 WHERE PersonnelNumber ='$pernr'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        return $q['EmployeeName'];
    }
}

function Getpernr($userid)
{
    include 'koneksi.php';
    $sql = mysqli_query($conn, "SELECT PersonnelNumber FROM usr02 WHERE UserID='$userid'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        return $q['PersonnelNumber'];
    }
}
function Getpernrbyname($nameid)
{
    include 'koneksi.php';
    $sql = mysqli_query($conn, "SELECT PersonnelNumber FROM pa001 WHERE EmployeeName='$nameid'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        return $q['PersonnelNumber'];
    }
}

// ------> Get Jumlah Litho Terpakai (Hasil Counter Mesin/Standard Roll)
function Getlithoused($productid, $countermesin)
{
    include 'koneksi.php';
    $litho = 0;
    $sql = mysqli_query($conn, "SELECT StandardRoll FROM mara_product WHERE ProductID='$productid'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $litho =  $countermesin / $q['StandardRoll'];
    }
    return $litho;
}
function getengineset($noplan, $kodeproses)
{
    include 'koneksi.php';
    $sql = mysqli_query($conn, "SELECT B.NilaiSuhu, A.UnitOfMeasures FROM qc_characteristic AS A INNER JOIN machine_engine AS B
                                ON A.Proses=B.JenisPengecekan WHERE A.KodeProses='" . $kodeproses . "' AND B.PlanningNumber='" . $noplan . "'");
    $row = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        return $row['NilaiSuhu'] . ' ' . $row['UnitOfMeasures'];
    }
}
function getrowtable($table, $where, $valuewhere)
{
    include 'koneksi.php';
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $rows = 0;
    if ($where != '') {
        $sql = mysqli_query($conn, "SELECT * FROM $table WHERE Plant='$plant' AND UnitCode='$unitcode' AND $where ='$valuewhere'");
    } else {
        $sql = mysqli_query($conn, "SELECT * FROM $table");
    }
    if (mysqli_num_rows($sql) > 0) {
        $rows = mysqli_num_rows($sql);
    }
    return $rows;
}

function getconfigreviewer($prosestype, $where)
{
    include 'koneksi.php';
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $return = 'hidden';
    $sql = mysqli_query($conn, "SELECT $where FROM tb_configreviewer WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                            AND  ProcessType='$prosestype'
                                                                                            AND StatsX='X'");
    if (mysqli_num_rows($sql) != 0) {
        $rows = mysqli_fetch_array($sql);
        if ($rows[$where] == 'X') {
            $return = '';
        }
        if ($rows[$where] == null || $rows[$where] == '') {
            $return = 'hidden';
        }
    }
    return $return;
}
function getconfig($prosestype, $where)
{
    include 'koneksi.php';
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $return = 'checked';
    $sql = mysqli_query($conn, "SELECT $where FROM tb_configreviewer WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                            AND  ProcessType='$prosestype'");
    if (mysqli_num_rows($sql) != 0) {
        $rows = mysqli_fetch_array($sql);
        if ($rows[$where] != 'X') {
            $return = '';
        }
    }
    return $return;
}
function getconfig2($prosestype)
{
    include 'koneksi.php';
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $return = 'checked';
    $sql = mysqli_query($conn, "SELECT StatsX FROM tb_configweb WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                            AND  FormReviewer ='$prosestype'");
    if (mysqli_num_rows($sql) != 0) {
        $rows = mysqli_fetch_array($sql);
        if ($rows['StatsX'] != 'X') {
            $return = '';
        }
    }
    return $return;
}
function getconfig3($item)
{
    include 'koneksi.php';
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $return = 'checked';
    $sql = mysqli_query($conn, "SELECT StatsX FROM tbl_configuration WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                        AND  Items  = $item");
    if (mysqli_num_rows($sql) != 0) {
        $rows = mysqli_fetch_array($sql);
        if ($rows['StatsX'] != 'X') {
            $return = '';
        }
    }
    return $return;
}
function getdayformat($hari)
{

    switch ($hari) {
        case '0':
            $return_hari = "Minggu";
            break;
        case '1':
            $return_hari = "Senin";
            break;
        case '2':
            $return_hari = "Selasa";
            break;
        case '3':
            $return_hari = "Rabu";
            break;
        case '4':
            $return_hari = "Kamis";
            break;
        case '5':
            $return_hari = "Jumat";
            break;
        case '6':
            $return_hari = "Sabtu";
            break;
        default:
            $return_hari = "Tidak di ketahui";
            break;
    }
    return $return_hari;
}
function getdayformat3($hari)
{
    $daysInIndonesian = array(
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    );

    // $timestamp = strtotime($hari);
    $dayInEnglish = date('l', strtotime($hari));

    // Mengembalikan nama hari dalam bahasa Indonesia
    return $daysInIndonesian[$dayInEnglish];
}

function getbulanformat($bulan)
{

    switch ($bulan) {
        case '1':
            $return_bulan = "Januari";
            break;
        case '2':
            $return_bulan = "Febuari";
            break;
        case '3':
            $return_bulan = "Maret";
            break;
        case '4':
            $return_bulan = "April";
            break;
        case '5':
            $return_bulan = "Mei";
            break;
        case '6':
            $return_bulan = "Juni";
            break;
        case '7':
            $return_bulan = "Juli";
            break;
        case '8':
            $return_bulan = "Agustus";
            break;
        case '9':
            $return_bulan = "September";
            break;
        case '10':
            $return_bulan = "Oktober";
            break;
        case '11':
            $return_bulan = "November";
            break;
        case '12':
            $return_bulan = "Desember";
            break;
        default:
            $return_bulan = "Tidak di ketahui";
            break;
    }
    return $return_bulan;
}

function getpositionbypernr($pernr)
{
    include 'koneksi.php';
    $return = 'OK';

    $sql = mysqli_query($conn, "SELECT pa002.Descriptions FROM pa001 
                                INNER JOIN pa002 
                                ON pa001.PositionID = pa002.PositionID 
                                WHERE pa001.PersonnelNumber='$pernr'");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $return = $r['Descriptions'];
    }
    return $return;
}
function getexpdate($productid, $batch, $planningnumebr = null, $years = null)
{
    include 'koneksi.php';
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];

    $query = mysqli_query($conn, "SELECT ExpiredDate FROM planning_pengolahan_detail WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            PlanningNumber='$planningnumebr' AND
                                                                                            Years='$years' AND
                                                                                            ProductID='$productid' AND
                                                                                            BatchNumber LIKE '%$batch%'");
    if (mysqli_num_rows($query) <> 0) {
        $r = mysqli_fetch_array($query);
        return $r['ExpiredDate'];
    }
}
function beautydate1($tanggal)
{
    if ($tanggal == '') {
        $tgl = '';
    } else {
        $tgl = date('d.m.Y', strtotime($tanggal));
        if ($tgl == '01.01.1970 07:00:00' || $tgl == NULL) {
            $tgl = '';
        }
    }
    return $tgl;
}
function beautydate2($tanggal)
{
    $tgl =  date('d.m.Y H:i:s', strtotime($tanggal));
    if ($tgl == '01.01.1970 07:00:00') {
        $tgl = '';
    }
    return $tgl;
}
function errorlog($errortext)
{
    include 'koneksi.php';
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['personnelnumber'];
    $query = "INSERT INTO table_errorlog (errortext,createdon,createdby)
                VALUES('$errortext','$createdon','$createdby')";
    mysqli_query($conn, $query);
}
