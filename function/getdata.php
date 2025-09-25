<?php
// header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set('Asia/Jakarta');
error_reporting(0);
session_start();
include "koneksi.php";
include_once "getvalue.php";
$plant = $_SESSION['plant'];
$unitcode = $_SESSION['unitcode'];
$client = '300';
$status = false;
$return = false;
$msg = '';
$time = 3000;
$data = [];
$createdon   = date("Y-m-d H:i:s");
$createdby   = $_SESSION['userid'];
$changedon = date("Y-m-d H:i:s");
$changedby = $_SESSION['userid'];
if ($_SESSION['client'] == 'db_sisp_100') {
    $client = '100';
}

// ---------------------------------------------------------
// Global Function
// ---------------------------------------------------------
function loguser($transaction)
{
    include "koneksi.php";
    $login_time = date("Y-m-d H:i:s");
    $sql = "UPDATE user_log SET LastAct='$login_time', ActionPage='$transaction'
    WHERE UserID='$_SESSION[userid]'";
    mysqli_query($conn, $sql);
}
function getdayformat2($hari)
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
function setreviewer($prosestype, $planningnumber, $years, $addreviewer)
{
    include "koneksi.php";
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $return = false;
    $sql = mysqli_query($conn, "SELECT * FROM tb_configreviewer WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                    AND ProcessType='$prosestype'
                                                                                    AND StatsX='X'");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $additional = $r['Addreviewer'];
        $query = mysqli_query($conn, "SELECT * FROM reviewer_person WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                        AND TypeTransaction ='$prosestype'");
        while ($row = mysqli_fetch_array($query)) {
            $levels = $row['Levels'];
            $pernr = $row['PersonnelNumber'];
            mysqli_query($conn, "INSERT INTO tb_approval_viewer(Plant,UnitCode,ProcessType,PlanningNumber,Years,Levels,PersonnelNumber,CreatedOn,CreatedBy)
                                VALUES('$plant','$unitcode','$prosestype','$planningnumber','$years','$levels','$pernr','$createdon','$createdby')");
        }
        if ($additional == 'X') {
            $levels = $levels + 1;
            mysqli_query($conn, "INSERT INTO tb_approval_viewer(Plant,UnitCode,ProcessType,PlanningNumber,Years,Levels,PersonnelNumber,CreatedOn,CreatedBy)
            VALUES('$plant','$unitcode','$prosestype','$planningnumber','$years','$levels','$addreviewer','$createdon','$createdby')");
        }
        $return = true;
    }
    return $return;
}
function setreviewerpartial2($prosestype, $planningnumber, $years, $levels)
{
    include "koneksi.php";
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];


    $return = false;
    $sql = mysqli_query($conn, "SELECT * FROM tb_configreviewer WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                    AND ProcessType='$prosestype'
                                                                                    AND StatsX='X'");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $query = mysqli_query($conn, "SELECT * FROM reviewer_person WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                            AND TypeTransaction ='$prosestype'
                                                                                            AND Levels = $levels");
        while ($row = mysqli_fetch_array($query)) {
            $levels = $row['Levels'];
            $pernr = $row['PersonnelNumber'];
            mysqli_query($conn, "INSERT INTO tb_approval_viewer(Plant,UnitCode,ProcessType,PlanningNumber,Years,Levels,PersonnelNumber,CreatedOn,CreatedBy)
                                    VALUES('$plant','$unitcode','$prosestype','$planningnumber','$years','$levels','$pernr','$createdon','$createdby')");
        }
        $return = true;
    }
    return $return;
}
function setreviewertambahan2($prosestype, $planningnumber, $years, $addreviewer, $levels)
{
    include "koneksi.php";
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];


    $return = false;
    $sql = mysqli_query($conn, "SELECT * FROM tb_configreviewer WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                    AND ProcessType='$prosestype'
                                                                                    AND StatsX='X'");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $additional = $r['Addreviewer'];
        if ($additional == 'X' && $addreviewer != '') {
            $levels = $levels + 1;
            $query = mysqli_query($conn, "INSERT INTO tb_approval_viewer(Plant,UnitCode,ProcessType,PlanningNumber,Years,Levels,PersonnelNumber,CreatedOn,CreatedBy)
                VALUES('$plant','$unitcode','$prosestype','$planningnumber','$years','$levels','$addreviewer','$createdon','$createdby')");
        }
        $return = $query;
    }
    return $return;
}
function showdataII($value, $table, $where, $valuewhere, $where2, $valuewhere2)
{
    include 'koneksi.php';
    $sql = mysqli_query($conn, "SELECT $value FROM $table WHERE $where ='$valuewhere' AND $where2 ='$valuewhere2'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        return $q[$value];
    }
}
function showdataIII($value, $table, $where, $valuewhere, $where2, $valuewhere2, $where3, $valuewhere3)
{
    include 'koneksi.php';
    $sql = mysqli_query($conn, "SELECT $value FROM $table WHERE $where ='$valuewhere' AND $where2 ='$valuewhere2'
                                                                                    AND $where3 ='$valuewhere3'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        return $q[$value];
    }
}
function errorlog($errortext)
{
    // include 'koneksi.php';
    global $conn;
    $values = mysqli_real_escape_string($conn, $errortext);

    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['personnelnumber'] ?? 'System';;
    mysqli_query($conn, "INSERT INTO table_datalog (errortext,
                                                    createdon,
                                                    createdby)
                VALUES('$values',
                        '$createdon',
                        '$createdby')");
}
// ---------------------------------------------------------
// Login & Logout
// ---------------------------------------------------------
if (isset($_POST['proseslogin'])) {
    $userid = $_POST['proseslogin'][0];
    $initialpassword = base64_encode($_POST['proseslogin'][1]);
    $scaptcha = $_POST['proseslogin'][3];
    $captcha = $_POST['proseslogin'][4];
    $splant = $_POST['proseslogin'][5];
    $sunitcode = $_POST['proseslogin'][6];
    $vreason = '';
    $status = true;

    $sql = mysqli_query($conn, "SELECT * FROM tb_configlogin WHERE Plant='$splant' AND UnitCode='$sunitcode'");
    $row = mysqli_fetch_array($sql);
    $vreason = $row['Vreason'];
    if (mysqli_num_rows($sql) <> 0) {
        if ($row['Captcha'] == 'X') {
            if ($scaptcha == '' || $scaptcha <> $captcha) {
                $msg = 'Captcha Invalid';
                $status = false;
            }
        }
    }

    if ($vreason == '') {
        $status = true;
    } else {
        $status = false;
        $msg = $vreason;
    }
    if ($status) {
        $sql = mysqli_query($conn, "SELECT * FROM usr02 
                                    WHERE (UserID='$userid' OR PersonnelNumber='$userid') 
                                                            AND InitialPassword='$initialpassword'");
        $q = mysqli_fetch_array($sql);
        if (mysqli_num_rows($sql) > 0) {
            if ($q['Locked'] == 'X') {
                $msg = 'User is Locked By IT';
            } else {
                $login_time = date("Y-m-d H:i:s");
                $_SESSION["userid"] = ucfirst($q['UserID']);
                $_SESSION["personnelnumber"] = ucfirst($q['PersonnelNumber']);
                $sql = mysqli_query($conn, "SELECT * FROM user_log WHERE UserID='$q[UserID]'");
                if (mysqli_num_rows($sql) == 0) {
                    $sql = "INSERT INTO user_log (UserID,
                                                    LoginTime,
                                                    LastAct,
                                                    ActionPage) VALUES('$q[UserID]',
                                                                        '$login_time',
                                                                        '$login_time',
                                                                        'dashboard')";
                    mysqli_query($conn, $sql);
                } else {
                    $sql = "UPDATE user_log SET LoginTime='$login_time', LogoutTime='' WHERE UserID='$q[UserID]'";
                    mysqli_query($conn, $sql);
                }
                $sql = mysqli_query($conn, "SELECT A.EmployeeName, 
                                                    B.Descriptions,
                                                    B.PositionID FROM pa001 AS A
                                                INNER JOIN pa002 AS B ON A.PositionID = B.PositionID
                                                WHERE A.PersonnelNumber='$q[PersonnelNumber]'");
                $r = mysqli_fetch_array($sql);
                $_SESSION["employeename"] = ucfirst($r['EmployeeName']);
                $_SESSION["positionid"] = ucfirst($r['PositionID']);
                $_SESSION["jabatan"] = ucfirst($r['Descriptions']);
                $_SESSION["logintime"] = date("Y-m-d H:i:s");
                $_SESSION["unitcode"] = $sunitcode;
                include_once 'getvalue.php';
                $_SESSION["unitdesc"] = Getdata('Descriptions', 't001w', 'Unit', $sunitcode);
                $_SESSION["plant"] = $splant;
                $_SESSION["login"] = true;
                $return = true;
                $msg = 'Login Sukses';
            }
        } else {
            $msg = 'Incorrect User ID or Password';
        }
    }

    $data = [
        "pernr" => $_SESSION["personnelnumber"],
        "icon_s" => 'success',
        "icon_e" => 'warning',
        "msg" => $msg,
        "time" => $time,
        "link" => 'page/mainpage?p=dashboard',
        "return" => $return
    ];
    echo json_encode($data);
}
if (isset($_POST['proseslogout'])) {
    $return = false;
    $logouttime = date('Y-m-d H:i:s');
    mysqli_query($conn, "DELETE FROM user_log WHERE UserID='$_SESSION[userid]'");
    session_destroy();
    session_unset();
    $return = true;
    $data = [
        "logout" => $logouttime,
        "link" => "../index",
        "return" => $return
    ];
    echo $return;
}

// ---------------------------------------------------------
// Other
// ---------------------------------------------------------
if (isset($_POST['cekotorisasi'])) {
    $roles = array();
    $userid = $_POST['cekotorisasi'];
    // $assign = mysqli_query($conn, "SELECT * FROM agr_assignrole WHERE UserID='$userid'");
    // if (mysqli_num_rows($assign) > 0) {
    //     while ($row_assign = mysqli_fetch_array($assign)) {
    //         $role = mysqli_query($conn, "SELECT * FROM agr_role WHERE Roles='$row_assign[Roles]'");
    //         if (mysqli_num_rows($role) > 0) {
    //             $i = 0;
    //             while ($row_roles = mysqli_fetch_array($role)) {
    //                 $roles[$i] = $row_roles['Menus'];
    //                 $i += 1;
    //             }
    //         }
    //     }
    // }
    $assign = mysqli_query($conn, "SELECT B.Menus FROM agr_assignrole AS A
    INNER JOIN agr_role AS B ON A.Roles = B.Roles
    WHERE A.UserID='$userid'");
    $i = 0;
    while ($row_assign = mysqli_fetch_array($assign)) {
        $roles[$i] = $row_assign['Menus'];
        $i += 1;
    }
    $dump = [
        'roles' =>  $roles
    ];
    echo json_encode($dump);
}
if (isset($_POST['prosesredirectlink'])) {
    $link = $_POST['prosesredirectlink'][0];
    $values = base64_encode($_POST['prosesredirectlink'][1]);
    $title = base64_encode($_POST['prosesredirectlink'][2]);
    $cc = base64_encode($_POST['prosesredirectlink'][3]);

    $linked = $link . '&n=' . $values . '&t=' . $title;
    if ($title == '' & $values <> '') {
        $linked = $link . '&n=' . $values;
    } elseif ($title <> '' & $values == '') {
        $linked = $link . '&t=' . $title;
    } elseif ($title == '' & $values == '') {
        $linked = $link;
    }
    if ($cc <> '') {
        $linked = $linked . '&c=' . $cc;
    }

    $data = [
        "link" => $linked,
        "title" => $title
    ];
    echo json_encode($data);
}
if (isset($_POST['prosesdownloadlink'])) {
    $jenis = $_POST['prosesdownloadlink'][0];
    $addr = $_POST['prosesdownloadlink'][1];

    $r = mysqli_fetch_array(mysqli_query($conn, "SELECT Directions FROM master_directions 
                                    WHERE Items ='$jenis'"));
    $return = true;
    $linked = $r['Directions'] . $addr;

    $data = [
        "link" => $linked,
        "return" => $return
    ];
    echo json_encode($data);
}
if (isset($_POST['prosesdeleteimg'])) {
    $imgaddress = $_POST['prosesdeleteimg'][0];
    $dir = $_POST['prosesdeleteimg'][1];
    $table = $_POST['prosesdeleteimg'][2];
    $keys = $_POST['prosesdeleteimg'][3];

    $sql = mysqli_query($conn, "SELECT Directions FROM master_directions WHERE Items=$dir");
    if (mysqli_num_rows($sql) <> 0) {
        $r = mysqli_fetch_array($sql);
        $dir = $r['Directions'];
    }
    $file = $dir . $imgaddress;
    if (file_exists($file)) {
        unlink($file);
    }
    $query = mysqli_query($conn, "DELETE FROM $table
                                    WHERE documenid = '$keys'");

    if ($query) {
        $return = true;
        $msgs = "Data Tersimpan";
        $icon_msgs = "success";
    }
    $data = [
        "time" => $time,
        "msg" => $msgs,
        "iconmsg" => $icon_msgs,
        "link" => null,
        "norevisi" => $id,
        "return" => $return,
    ];
    echo json_encode($data);
}
if (isset($_POST['prosesceksession'])) {
    $return = false;
    $sql = mysqli_query($conn, "SELECT * FROM user_log WHERE UserID='$_SESSION[userid]'");
    $r = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) == 0) {
        session_destroy();
        $return = true;
    } else {
        $time = strtotime($r['LastAct']);
        $time_now = strtotime(date('Y-m-d H:i:s'));
        $diff = $time_now - $time;
        $jam = floor($diff / (60 * 60));
        if ($jam > 0) {
            session_destroy();
            $return = true;
        }
    }
    echo $return;
}

// ---------------------------------------------------------
// Dashboard
// ---------------------------------------------------------
if (isset($_POST['prosessaveallapprovalpengemasandanpengolahan'])) {
    $planningnumber_years = $_POST['prosessaveallapprovalpengemasandanpengolahan'][0];
    $lenght = $_POST['prosessaveallapprovalpengemasandanpengolahan'][1];
    $return = false;

    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];
    if ($lenght > 1) {
        $lenght1 = count($planningnumber_years);

        for ($i = 0; $i < $lenght1; $i++) {
            $split_planningnumber_years = explode("/", $planningnumber_years[$i]);
            $planningnumber = $split_planningnumber_years[0];
            $years = $split_planningnumber_years[1];
            $prosestype = $split_planningnumber_years[2];
            $levels = $split_planningnumber_years[3];
            $pernr = $split_planningnumber_years[4];

            $sql = mysqli_query($conn, "SELECT * FROM tb_approval_viewer WHERE Plant='$plant' 
                                                                                AND UnitCode='$unitcode' 
                                                                                AND ProcessType='$prosestype'
                                                                                AND PlanningNumber='$planningnumber' 
                                                                                AND Years='$years' 
                                                                                AND Levels = $levels 
                                                                                AND StatusApproval is null");
            if (mysqli_num_rows($sql) != 0) {
                $query = mysqli_query($conn, "UPDATE tb_approval_viewer SET StatusApproval='X', 
                                                                            ChangedBy='$changedby', 
                                                                            ChangedOn='$changedon'
                                                                        WHERE Plant='$plant' 
                                                                            AND UnitCode='$unitcode'
                                                                            AND ProcessType='$prosestype' 
                                                                            AND PlanningNumber='$planningnumber' 
                                                                            AND Years='$years' 
                                                                            AND Levels = '$levels'
                                                                            AND PersonnelNumber='$pernr'");
            }
            $return = $query;

            $sql = mysqli_query($conn, "SELECT * FROM tb_approval_viewer WHERE Plant='$plant' 
                                                                        AND UnitCode='$unitcode' 
                                                                        AND ProcessType='$prosestype'
                                                                        AND PlanningNumber='$planningnumber' 
                                                                        AND Years='$years' 
                                                                        AND StatusApproval is null");
            if (mysqli_num_rows($sql) == 0) {
                mysqli_query($conn, "INSERT INTO approval_planning (Plant,
                                                                    UnitCode,
                                                                    PlanningNumber,
                                                                    Years,
                                                                    Approval,
                                                                    ApprovalBy,
                                                                    CreatedOn,
                                                                    CreatedBy)
                                    VALUES('$plant',
                                            '$unitcode',
                                            '$planningnumber',
                                            '$years',
                                            'X',
                                            '$createdby',
                                            '$createdon',
                                            '$createdby')");

                if ($prosestype == 'planning_pengolahan') {
                    // ----> Start
                    $sql = mysqli_query($conn, "SELECT * FROM tb_eraseprosespengolahan WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                            AND PlanningNumber='$planningnumber' 
                                                                                            AND Years='$years'
                                                                                            AND JmlProses=1");
                    if (mysqli_num_rows($sql) <> 0) {
                        while ($r = mysqli_fetch_array($sql)) {
                            mysqli_query($conn, "DELETE FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                            AND PlanningNumber='$planningnumber' 
                                                                                            AND Years='$years'
                                                                                            AND BatchNumber='$r[BatchNumber]'
                                                                                            AND NoProses=2");

                            $query = mysqli_query($conn, "SELECT * FROM insp_pengolahan_header WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                                    AND PlanningNumber='$planningnumber' 
                                                                                                    AND Years='$years'
                                                                                                    AND BatchNumber='$r[BatchNumber]'
                                                                                                    AND NoProses=2");
                            if (mysqli_num_rows($query) != 0) {
                                $rows = mysqli_fetch_array($query);
                                $insp_lot = $rows['InspectionLot'];
                                $lot_years = $rows['Lotyears'];
                                mysqli_query($conn, "DELETE FROM insp_pengolahan_header WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                            AND PlanningNumber='$planningnumber' 
                                                                                            AND Years='$years'
                                                                                            AND BatchNumber='$r[BatchNumber]'
                                                                                            AND NoProses=2");
                                mysqli_query($conn, "DELETE FROM insp_pengolahan_detail WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                            AND InspectionLot='$insp_lot' 
                                                                                            AND Lotyears='$lot_years'
                                                                                            AND BatchNumber='$r[BatchNumber]'
                                                                                            AND NoProses=2");
                            }
                        }
                    }

                    // Memecah Planning
                    $sql = mysqli_query($conn, "SELECT DISTINCT Items,ProductID,BatchNumber,NoProses FROM tbl_hasiltimbang_detail 
                                                                                                        WHERE Plant='$plant' 
                                                                                                        AND UnitCode='$unitcode' 
                                                                                                        AND PlanningNumber='$planningnumber' 
                                                                                                        AND Years='$years'");
                    $a = mysqli_num_rows($sql);
                    while ($r = mysqli_fetch_array($sql)) {
                        mysqli_query($conn, "INSERT INTO planning_pengolahan_subdetail (Plant,
                                                                                        UnitCode,
                                                                                        PlanningNumber,
                                                                                        Years,
                                                                                        Items,
                                                                                        ProductID,
                                                                                        BatchNumber,
                                                                                        NoProses,
                                                                                        Stats01,
                                                                                        CreatedOn,
                                                                                        CreatedBy)
                                            VALUES('$plant',
                                            '$unitcode',
                                            '$planningnumber',
                                            '$years',
                                            '$r[Items]',
                                            '$r[ProductID]',
                                            '$r[BatchNumber]',
                                            '$r[NoProses]',
                                            'X',
                                            '$createdon',
                                            '$createdby')");
                    }
                    // End Memecah Planning
                    // ---> End

                    mysqli_query($conn, "UPDATE planning_pengolahan_header SET Approval='X',
                                                                                ChangedOn='$changedon',
                                                                                ChangedBy='$changedby' WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                                AND PlanningNumber='$planningnumber' 
                                                                                                AND Years='$years'");
                } elseif ($prosestype == 'create_planning') {
                    mysqli_query($conn, "UPDATE planning_prod_header SET Approval='X',
                                                                            ChangedOn='$changedon',
                                                                            ChangedBy='$changedby' WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                                AND PlanningNumber='$planningnumber' 
                                                                                                AND Years='$years'");
                }
            }
        }
    } else {
        $split_planningnumber_years = explode("/", $planningnumber_years[0]);
        $planningnumber = $split_planningnumber_years[0];
        $years = $split_planningnumber_years[1];
        $prosestype = $split_planningnumber_years[2];
        $levels = $split_planningnumber_years[3];
        $pernr = $split_planningnumber_years[4];
        $sql = mysqli_query($conn, "SELECT * FROM tb_approval_viewer WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                        AND ProcessType='$prosestype'
                                                                                        AND PlanningNumber='$planningnumber' 
                                                                                        AND Years='$years' 
                                                                                        AND Levels = $levels 
                                                                                        AND StatusApproval is null");
        if (mysqli_num_rows($sql) != 0) {
            $query = mysqli_query($conn, "UPDATE tb_approval_viewer SET StatusApproval='X', 
                                                                        ChangedBy='$changedby', 
                                                                        ChangedOn='$changedon'
                                                                    WHERE Plant='$plant' 
                                                                            AND UnitCode='$unitcode'
                                                                            AND ProcessType='$prosestype' 
                                                                            AND PlanningNumber='$planningnumber' 
                                                                            AND Years='$years' 
                                                                            AND Levels = '$levels'
                                                                            AND PersonnelNumber='$pernr'");
        }
        $return = $query;

        $sql = mysqli_query($conn, "SELECT * FROM tb_approval_viewer WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                        AND ProcessType='$prosestype'
                                                                                        AND PlanningNumber='$planningnumber' 
                                                                                        AND Years='$years' 
                                                                                        AND StatusApproval is null");
        if (mysqli_num_rows($sql) == 0) {
            mysqli_query($conn, "INSERT INTO approval_planning (Plant,
                                                                UnitCode,
                                                                PlanningNumber,
                                                                Years,
                                                                Approval,
                                                                ApprovalBy,
                                                                CreatedOn,
                                                                CreatedBy)
                                VALUES('$plant',
                                        '$unitcode',
                                        '$planningnumber',
                                        '$years',
                                        'X',
                                        '$createdby',
                                        '$createdon',
                                        '$createdby')");

            if ($prosestype == 'planning_pengolahan') {
                // ----> Start
                $sql = mysqli_query($conn, "SELECT * FROM tb_eraseprosespengolahan WHERE Plant='$plant' 
                                                                                            AND UnitCode='$unitcode' 
                                                                                            AND PlanningNumber='$planningnumber' 
                                                                                            AND Years='$years'
                                                                                            AND JmlProses=1");
                if (mysqli_num_rows($sql) <> 0) {
                    while ($r = mysqli_fetch_array($sql)) {
                        mysqli_query($conn, "DELETE FROM tbl_hasiltimbang_detail WHERE Plant='$plant' 
                                                                                            AND UnitCode='$unitcode' 
                                                                                            AND PlanningNumber='$planningnumber' 
                                                                                            AND Years='$years'
                                                                                            AND BatchNumber='$r[BatchNumber]'
                                                                                            AND NoProses=2");

                        $query = mysqli_query($conn, "SELECT * FROM insp_pengolahan_header WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                                    AND PlanningNumber='$planningnumber' 
                                                                                                    AND Years='$years'
                                                                                                    AND BatchNumber='$r[BatchNumber]'
                                                                                                    AND NoProses=2");
                        if (mysqli_num_rows($query) != 0) {
                            $rows = mysqli_fetch_array($query);
                            $insp_lot = $rows['InspectionLot'];
                            $lot_years = $rows['Lotyears'];
                            mysqli_query($conn, "DELETE FROM insp_pengolahan_header WHERE Plant='$plant' 
                                                                                            AND UnitCode='$unitcode' 
                                                                                            AND PlanningNumber='$planningnumber' 
                                                                                            AND Years='$years'
                                                                                            AND BatchNumber='$r[BatchNumber]'
                                                                                            AND NoProses=2");
                            mysqli_query($conn, "DELETE FROM insp_pengolahan_detail WHERE Plant='$plant' 
                                                                                            AND UnitCode='$unitcode' 
                                                                                            AND InspectionLot='$insp_lot' 
                                                                                            AND Lotyears='$lot_years'
                                                                                            AND BatchNumber='$r[BatchNumber]'
                                                                                            AND NoProses=2");
                        }
                    }
                }

                // Memecah Planning
                $sql = mysqli_query($conn, "SELECT DISTINCT Items,ProductID,BatchNumber,NoProses FROM tbl_hasiltimbang_detail 
                                                                                                        WHERE Plant='$plant' 
                                                                                                        AND UnitCode='$unitcode' 
                                                                                                        AND PlanningNumber='$planningnumber' 
                                                                                                        AND Years='$years'");
                $a = mysqli_num_rows($sql);
                while ($r = mysqli_fetch_array($sql)) {
                    mysqli_query($conn, "INSERT INTO planning_pengolahan_subdetail (Plant,
                                                                                        UnitCode,
                                                                                        PlanningNumber,
                                                                                        Years,
                                                                                        Items,
                                                                                        ProductID,
                                                                                        BatchNumber,
                                                                                        NoProses,
                                                                                        Stats01,
                                                                                        CreatedOn,
                                                                                        CreatedBy)
                                            VALUES('$plant',
                                            '$unitcode',
                                            '$planningnumber',
                                            '$years',
                                            '$r[Items]',
                                            '$r[ProductID]',
                                            '$r[BatchNumber]',
                                            '$r[NoProses]',
                                            'X',
                                            '$createdon',
                                            '$createdby')");
                }
                // End Memecah Planning
                // ---> End
                mysqli_query($conn, "UPDATE planning_pengolahan_header SET Approval='X' ,
                                                                        ChangedOn='$changedon',
                                                                        ChangedBy='$changedby'
                                                                        WHERE Plant='$plant' 
                                                                        AND UnitCode='$unitcode' 
                                                                        AND PlanningNumber='$planningnumber' 
                                                                        AND Years='$years'");
            } elseif ($prosestype == 'create_planning') {
                mysqli_query($conn, "UPDATE planning_prod_header SET Approval='X'
                                                                        ChangedOn='$changedon',
                                                                        ChangedBy='$changedby' WHERE Plant='$plant' 
                                                                                                AND UnitCode='$unitcode' 
                                                                                                AND PlanningNumber='$planningnumber' 
                                                                                                AND Years='$years'");
            }
        }
    }
    if ($return === true) {
        echo $planningnumber;
    }
    echo $return;
}
if (isset($_POST['prosessaveallapprovalproses'])) {
    $planningnumber_years = $_POST['prosessaveallapprovalproses'][0];
    $lenght = $_POST['prosessaveallapprovalproses'][1];
    $return = false;

    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];
    if ($lenght > 1) {
        $lenght1 = count($planningnumber_years);

        for ($i = 0; $i < $lenght1; $i++) {
            $split_planningnumber_years = explode("/", $planningnumber_years[$i]);
            $planningnumber = $split_planningnumber_years[0];
            $years = $split_planningnumber_years[1];

            $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND 
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years' AND
                                                                            ReviewMG is null");
            if (mysqli_num_rows($sql) != 0) {
                mysqli_query($conn, "UPDATE planning_prod_header SET ReviewMG='X' WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND 
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years'");
                $query = mysqli_query($conn, "INSERT INTO proses_review_mg(Plant,
                                                                UnitCode,
                                                                PlanningNumber,
                                                                Years,
                                                                Approved,
                                                                CreatedOn,
                                                                CreatedBy)
                                VALUES('$plant',
                                        '$unitcode',
                                        '$planningnumber',
                                        '$years',
                                        'X',
                                        '$createdon',
                                        '$createdby')");
                if ($query === true) {
                    $return = true;
                }
            }
        }
    } else {
        $split_planningnumber_years = explode("/", $planningnumber_years[0]);
        $planningnumber = $split_planningnumber_years[0];
        $years = $split_planningnumber_years[1];

        $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND 
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years' AND
                                                                            ReviewMG is null");
        if (mysqli_num_rows($sql) != 0) {
            mysqli_query($conn, "UPDATE planning_prod_header SET ReviewMG='X' WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND 
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years'");
            $query = mysqli_query($conn, "INSERT INTO proses_review_mg(Plant,
                                                                UnitCode,
                                                                PlanningNumber,
                                                                Years,
                                                                Approved,
                                                                CreatedOn,
                                                                CreatedBy)
                                VALUES('$plant',
                                        '$unitcode',
                                        '$planningnumber',
                                        '$years',
                                        'X',
                                        '$createdon',
                                        '$createdby')");
            if ($query === true) {
                $return = true;
            }
        }
    }
    echo $return;
}
if (isset($_POST['prosessaveapprovalproses'])) {
    $planningnumber = $_POST['prosessaveapprovalproses'][0] ?? '';
    $years = $_POST['prosessaveapprovalproses'][1] ?? '';
    $catatan = $_POST['prosessaveapprovalproses'][2] ?? '';

    try {
        mysqli_begin_transaction($conn);
        $sql = mysqli_query($conn, "SELECT PlanningNumber FROM planning_prod_header WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND 
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years' AND
                                                                            ReviewMG is null");
        if (mysqli_num_rows($sql) != 0) {
            $query = mysqli_query($conn, "UPDATE planning_prod_header SET ReviewMG='X'
                                            WHERE Plant='$plant' AND 
                                                UnitCode='$unitcode' AND 
                                                PlanningNumber='$planningnumber' AND
                                                Years='$years'");
            if (!$query) {
                throw new Exception("Error: " . mysqli_error($conn));
            }
            $query = mysqli_query($conn, "INSERT INTO proses_review_mg(Plant,
                                                                UnitCode,
                                                                PlanningNumber,
                                                                Years,
                                                                Approved,
                                                                Keterangan,
                                                                CreatedOn,
                                                                CreatedBy)
                                VALUES('$plant',
                                        '$unitcode',
                                        '$planningnumber',
                                        '$years',
                                        'X',
                                        '$catatan',
                                        '$createdon',
                                        '$createdby')");
            if (!$query) {
                throw new Exception("Error: " . mysqli_error($conn));
            }
        } else {
            throw new Exception("Error: " . mysqli_error($conn));
        }
        $return = true;
        mysqli_commit($conn);
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $msg = "Data gagal tersimpan";
        errorlog($e->getMessage());
        $return = false;
    }
    $data = [
        "iconmsg" => 'warning',
        "time" => $time,
        "msg" => $msg,
        "link" => null,
        "id" => $planningnumber,
        "return" => $return
    ];

    echo json_encode($data);
    exit;
}
if (isset($_POST['prosestolakapprovalproses'])) {
    $planningnumber = $_POST['prosestolakapprovalproses'][0] ?? '';
    $years = $_POST['prosestolakapprovalproses'][1] ?? '';
    $catatan = $_POST['prosestolakapprovalproses'][2] ?? '';

    try {
        mysqli_begin_transaction($conn);
        $sql = mysqli_query($conn, "SELECT PlanningNumber FROM planning_prod_header WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND 
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years' AND
                                                                            ReviewMG is null");
        if (mysqli_num_rows($sql) != 0) {
            $query = mysqli_query($conn, "UPDATE planning_prod_header SET ReviewMG='X', SttsX='DEL'
                                            WHERE Plant='$plant' AND 
                                                UnitCode='$unitcode' AND 
                                                PlanningNumber='$planningnumber' AND
                                                Years='$years'");
            if (!$query) {
                throw new Exception("Error: " . mysqli_error($conn));
            }
            $query = mysqli_query($conn, "INSERT INTO proses_review_mg(Plant,
                                                                UnitCode,
                                                                PlanningNumber,
                                                                Years,
                                                                Approved,
                                                                Keterangan,
                                                                CreatedOn,
                                                                CreatedBy)
                                VALUES('$plant',
                                        '$unitcode',
                                        '$planningnumber',
                                        '$years',
                                        '',
                                        '$catatan',
                                        '$createdon',
                                        '$createdby')");
            if (!$query) {
                throw new Exception("Error: " . mysqli_error($conn));
            }
        } else {
            throw new Exception("Error: " . mysqli_error($conn));
        }
        $return = true;
        mysqli_commit($conn);
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $msg = "Data gagal tersimpan";
        errorlog($e->getMessage());
        $return = false;
    }
    $data = [
        "iconmsg" => 'warning',
        "time" => $time,
        "msg" => $msg,
        "link" => null,
        "id" => $planningnumber,
        "return" => $return
    ];

    echo json_encode($data);
    exit;
}
if (isset($_POST['prosesapprovechangepersiapanpengolahan'])) {
    $notiket = $_POST['prosesapprovechangepersiapanpengolahan'][0];
    $tiketyears = $_POST['prosesapprovechangepersiapanpengolahan'][1];
    $obj = $_POST['prosesapprovechangepersiapanpengolahan'][2];

    $sql = mysqli_query($conn, "SELECT * FROM tbl_tempupdate WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    NoUpdate='$notiket' AND
                                                                    NoUpdateYears='$tiketyears' AND
                                                                    ObjectUpdate='$obj'");
    if (mysqli_num_rows($sql) <> 0) {
        $r = mysqli_fetch_array($sql);
        $planningnumber = $r['PlanningNumber'];
        $years = $r['Years'];
        $inspectionlot = $r['InspectionLot'];
        $lotyears = $r['Lotyears'];
        $noproses = $r['NoProses'];
        $productid = $r['ProductID'];
        $batchnumber = $r['BatchNumber'];
        $approvedon = date("Y-m-d H:i:s");
        $approvedby = $_SESSION['userid'];
        $return = false;
        if ($obj == "proses_prepare_mixer") {
            $sql =  mysqli_query($conn, "UPDATE proses_prepare_mixer SET StatsUpdate=2 WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                PlanningNumber='$planningnumber' AND
                                                                                Years='$years' AND
                                                                                ProductID='$productid' AND
                                                                                BatchNumber='$batchnumber' AND
                                                                                NoProses='$noproses' AND
                                                                                StatsUpdate=''");
            if ($sql === true) {
                mysqli_query($conn, "UPDATE proses_prepare_mixer SET StatsUpdate='' WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                PlanningNumber='$planningnumber' AND
                                                                                Years='$years' AND
                                                                                ProductID='$productid' AND
                                                                                BatchNumber='$batchnumber' AND
                                                                                NoProses='$noproses' AND
                                                                                StatsUpdate=1");
                $return = true;
            }
        } else if ($obj == "qc_result_pengolahan") {
            $sql = mysqli_query($conn, "UPDATE qc_result SET StatsUpdate=2 WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                PlanningNumber='$planningnumber' AND
                                                                                Years='$years' AND
                                                                                Types='Pengolahan' AND
                                                                                -- ProductID='$productid' AND
                                                                                BatchNumber='$batchnumber' AND
                                                                                NoProses='$noproses' AND
                                                                                StatsUpdate=''");
            if ($sql === true) {
                mysqli_query($conn, "UPDATE qc_result SET StatsUpdate='' WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                PlanningNumber='$planningnumber' AND
                                                                                Years='$years' AND
                                                                                Types='Pengolahan' AND
                                                                                -- ProductID='$productid' AND
                                                                                BatchNumber='$batchnumber' AND
                                                                                NoProses='$noproses' AND
                                                                                StatsUpdate=1");
                $return = true;
            }
        } else if ($obj == "result_recording") {
            $sql =  mysqli_query($conn, "UPDATE result_recording SET StatsUpdate=2 WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                InspectionLot='$inspectionlot' AND
                                                                                Lotyears='$lotyears' AND
                                                                                -- Types='Pengolahan' AND
                                                                                -- ProductID='$productid' AND
                                                                                -- BatchNumber='$batchnumber' AND
                                                                                NoProses='$noproses' AND
                                                                                StatsUpdate=''");
            if ($sql === true) {
                $sql =  mysqli_query($conn, "UPDATE result_recording SET StatsUpdate='' WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                InspectionLot='$inspectionlot' AND
                                                                                Lotyears='$lotyears' AND
                                                                                -- Types='Pengolahan' AND
                                                                                -- ProductID='$productid' AND
                                                                                -- BatchNumber='$batchnumber' AND
                                                                                NoProses='$noproses' AND
                                                                                StatsUpdate=1");
                $return = true;
            }
        }
        if ($return === true) {
            mysqli_query($conn, "UPDATE tbl_tempupdate SET Stats14='X',
                                                        ApproveBy='$approvedby',
                                                        ApproveOn='$approvedon' 
                                                        WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    NoUpdate='$notiket' AND
                                                                    NoUpdateYears='$tiketyears' AND
                                                                    ObjectUpdate='$obj'");
        }
    }
    echo $return;
}

// ---------------------------------------------------------
// Paging
// ---------------------------------------------------------
if (isset($_GET['p'])) {
    $page = $_GET['p'];
    loguser($page);
    switch ($page) {
        case 'dashboard':
            include "public/page_dashboard.php";
            break;
        // Master Data
        case 'shift':
            include "masterdata/page_shift.php";
            break;
        case 'shiftrangetime':
            include "masterdata/page_shift_rangetime.php";
            break;
        case 'product':
            include "masterdata/page_product.php";
            break;
        case 'mainresources':
            include "masterdata/page_mainresources.php";
            break;
        case 'primaryresources':
            include "masterdata/page_primaryresources.php";
            break;
        case 'secondaryresources':
            include "masterdata/page_secondaryresources.php";
            break;
        case 'mixingresources':
            include "masterdata/page_mixingresources.php";
            break;
        case 'employee':
            include "masterdata/page_employee.php";
            break;
        case 'userauth':
            include "masterdata/page_userauthorization.php";
            break;
        case 'roles':
            include "masterdata/page_role.php";
            break;
        case 'assignrole':
            include "masterdata/page_assignrole.php";
            break;
        case 'daftarmenu':
            include "masterdata/page_daftarmenu.php";
            break;
        case 'jobposition':
            include "masterdata/page_jobposition.php";
            break;
        // Production
        case 'createplanning':
            include "production/planning/page_createplanning.php";
            break;
        case 'createplanningpengolahan':
            include "production/planning/page_createplanningpengolahan.php";
            break;
        // case 'startdisplayplanning':
        //     include "production/planning/page_startdisplayplanning.php";
        //     break;
        case 'displaydatapengolahan':
            include "production/planning/page_displaydatapengolahan.php";
            break;
        case 'displaydatapengemasan':
            include "production/planning/page_displaydatapengemasan.php";
            break;
        case 'displayplanning':
            include "production/planning/page_displayplanning.php";
            break;
        case 'approvalplanning':
            include "production/planning/page_approval_planning.php";
            break;
        case 'displaydata':
            include "production/planning/page_displaydata.php";
            break;
        case 'showdisplaydata':
            include "production/planning/page_showdisplaydata.php";
            break;
        case 'printworkorder':
            include "production/planning/page_workorder.php";
            break;
        case 'printlabelbahan':
            include "production/planning/page_printlabelbahan.php";
            break;
        case 'persiapanpengolahan':
            include "production/prepare/page_preparepengolahan.php";
            break;
        case 'persiapanhoper':
            include "production/prepare/page_preparehoper.php";
            break;
        case 'persiapantopack':
            include "production/prepare/page_preparetopack.php";
            break;
        case 'persiapanpillow':
            include "production/prepare/page_preparepillow.php";
            break;
        case 'executionhoper':
            include "production/execution/execution_hoper/page_proseshoper.php";
            break;
        case 'nomorlot':
            include "production/planning/page_nomorlot.php";
            break;
        case 'topackengineset':
            include "production/execution/execution_topack/page_engineset_topack.php";
            break;
        case 'topackproductionsampling':
            include "production/execution/execution_topack/page_samplingtopackproduksi.php";
            break;
        case 'topackreconciles':
            include "production/execution/execution_topack/page_rekonsiliasitopack.php";
            break;
        // Approval
        case 'approvalproses':
            include "production/approvalproses/page_startapprovalproses.php";
            break;
        case 'displayapprovalproses':
            include "production/approvalproses/page_approvalproses.php";
            break;
        // Pillow       
        case 'prosespillow':
            include "production/execution/execution_pillow/page_prosespillow.php";
            break;
        case 'pillowpackreconciles':
            include "production/execution/execution_pillow/page_rekonsiliasipillow.php";
            break;
        // Quality
        case 'organoleptis':
            include "quality/page_analisaorganoleptis.php";
            break;
        case 'rh_suhu':
            include "quality/page_rh_suhu.php";
            break;
        case 'enginesetapproval':
            // include "quality/page_topackapproval.php";
            include "quality/page_analisapengemasanprimer.php";
            break;
        case 'analisapengemasanprimer':
            // include "quality/page_topackapproval.php";
            include "quality/page_analisapengemasanprimer.php";
            break;

        case 'reviewquality':
            include "quality/page_reviewquality.php";
            break;
        // Report
        case 'report':
            include "report/page_report.php";
            break;
        // System
        case 'reviewercpb':
            include "systems/page_reviewercpb.php";
            break;
        case 'profile':
            include "systems/page_profileuser.php";
            break;
        case 'userlog':
            include "systems/page_userlog.php";
            break;
        case 'changepassword':
            include "systems/page_changepassword.php";
            break;
        case 'generalsetting':
            include "systems/page_generalwebsetting.php";
            break;
        case 'sistemmanagemen':
            include "systems/page_sistemmanagemen.php";
            break;
        case 'analisapengemasansekunder':
            include "quality/page_analisapengemasansekunder.php";
            break;
        case 'configuration':
            include "systems/page_configuration.php";
            break;
        case 'timbangbahan':
            include "production/planning/page_timbangbahan.php";
            break;
        case 'historytimbang':
            include "production/timbang/page_historytimbang.php";
            break;
        case 'reviewer':
            include "masterdata/reviewer/page_reviewer.php";
            break;
        case 'mappingtimbangan':
            include "masterdata/page_datatimbangan.php";
            break;
        case 'createmic';
            include "masterdata/masterinspection/page_createmic.php";
            break;
        case 'assignmic';
            include "masterdata/masterinspection/page_assignmic.php";
            break;
        case 'cekstatusqc';
            include "quality/page_cekstatusqc.php";
            // include "production/planning/form/print_labelsample.php";
            // header("Location: http://localhost/cpb-online/page/production/planning/form/print_labelsample.php");
            break;
        case 'printlabelambilsample';
            include "quality/page_labelsample.php";
            break;
        case 'reportpengolahan';
            include "report/page_reportpengolahan.php";
            break;
        case 'reportpengemasan';
            include "report/page_reportpengemasan.php";
            break;
        case 'karantina';
            include "quality/page_karantina.php";
            break;
        case 'executionmixer';
            include "production/execution/execution_mixer/page_prosesmixer.php";
            break;
        case 'lacakbatch';
            include "production/planning/page_lacakbatch.php";
            break;
        case 'supplier';
            include "masterdata/page_datasupplier.php";
            break;
        case 'labelpalet';
            include "production/timbang/page_printlabelpalet.php";
            break;
        case 'kirimbahan';
            include "production/timbang/page_kirimbahan.php";
            break;
        case 'terimabahan';
            include "production/timbang/page_terimabahan.php";
            break;
        case 'manajemenstok';
            include "production/stok/page_manajemenstok.php";
            break;
        case 'checklistmesin';
            include "production/planning/page_checklistmesin.php";
            break;
        case 'changedatapengolahan';
            include "production/planning/change/page_changedatapengolahan.php";
            break;
        case 'displaychange';
            include "production/planning/change/page_displaychange.php";
            break;
        case 'displaymaterial';
            include "masterdata/views/page_displaymaterial.php";
            break;
        case 'displaybatch';
            include "masterdata/views/page_displaybatch.php";
            break;
        default:
            $output = '<div class="container">';
            // $output .= '<div class="card shadow-lg border-0" id="cardcolor" style="min-height:100px !important">';
            $output .= '<center style="min-height:100px !important;margin-top:200px !important">';
            // $output .= '<img src="../asset/img/yaoming.png" class="img-fluid" style="background-color:transparant !important">';
            $output .= '<h4 class="fw-bold">Page Not Found</h4>';
            $output .= '<h4>ERROR 404</h4>';
            $output .= '</center>';
            $output .= '</div>';
            echo $output;
            break;
    }
}

// ---------------------------------------------------------
// Data Produk
// ---------------------------------------------------------
if (isset($_POST['prosessimpanproduk'])) {
    $return = false;
    $produkid = strtoupper($_POST['prosessimpanproduk'][0]);
    $deskripsi = strtoupper($_POST['prosessimpanproduk'][1]);
    $standardroll = $_POST['prosessimpanproduk'][2];
    $standardprimer = $_POST['prosessimpanproduk'][3];
    $standardkonversi = $_POST['prosessimpanproduk'][4];
    $totalselflife = $_POST['prosessimpanproduk'][5];
    $bobottimbang = $_POST['prosessimpanproduk'][6];
    $standardcar = $_POST['prosessimpanproduk'][7];
    $standardcarkonversi = $_POST['prosessimpanproduk'][8];
    $standarddus = $_POST['prosessimpanproduk'][9];
    $standardduskonversi = $_POST['prosessimpanproduk'][10];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changeon = date("Y-m-d H:i:s");
    $changeby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT ProductID FROM mara_product WHERE ProductID = '$produkid'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $return = 2;
    } else {
        $sql = mysqli_query($conn, "INSERT INTO mara_product (ProductID,
                                                            ProductDescriptions,
                                                            StandardRoll,
                                                            StandardRollKonversi,
                                                            StandardDus,
                                                            StandardDusKonversi,
                                                            StandardCar,
                                                            StandardCarKonversi,
                                                            StandardBeratPrimer,
                                                            TotalSelfLife,
                                                            BobotTimbang,
                                                            CreatedOn,
                                                            CreatedBy) 
                                    VALUES('$produkid',
                                            '$deskripsi',
                                            '$standardroll',
                                            '$standardkonversi',
                                            '$standarddus',
                                            '$standardduskonversi',
                                            '$standardcar',
                                            '$standardcarkonversi',
                                            '$standardprimer',
                                            '$totalselflife',
                                            '$bobottimbang',
                                            '$createdon',
                                            '$createdby')");
        if ($sql === true) {
            $return = true;
            $msg = 'Data tersimpan';
        }
    }

    $data = [
        "icon_s" => 'success',
        "icon_e" => 'warning',
        "produk" => $produkid,
        "msg" => $msg,
        "time" => $time,
        "link" => null,
        "return" => $return
    ];
    echo json_encode($data);
}
if (isset($_POST['prosesupdateproduk'])) {
    $produkid = strtoupper($_POST['prosesupdateproduk'][0]);
    $deskripsi = strtoupper($_POST['prosesupdateproduk'][1]);
    $standardroll = $_POST['prosesupdateproduk'][2];
    $standardprimer = $_POST['prosesupdateproduk'][3];
    $standardkonversi = $_POST['prosesupdateproduk'][4];
    $totalselflife = $_POST['prosesupdateproduk'][5];
    $bobottimbang = $_POST['prosesupdateproduk'][6];
    $standardcar = $_POST['prosesupdateproduk'][7];
    $standardcarkonversi = $_POST['prosesupdateproduk'][8];
    $standarddus = $_POST['prosesupdateproduk'][9];
    $standardduskonversi = $_POST['prosesupdateproduk'][10];
    $changeon = date("Y-m-d H:i:s");
    $changeby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT ProductID FROM mara_product WHERE ProductID = '$produkid'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $sql = mysqli_query($conn, "UPDATE mara_product SET ProductDescriptions='$deskripsi',
                                    StandardRoll='$standardroll',StandardRollKonversi='$standardkonversi',
                                    StandardDus='$standarddus',StandardDusKonversi='$standardduskonversi',
                                    StandardCar='$standardcar',StandardCarKonversi='$standardcarkonversi',
                                    StandardBeratPrimer='$standardprimer',TotalSelfLife='$totalselflife',BobotTimbang='$bobottimbang',
                                    ChangeOn='$changeon',ChangeBy='$changeby' 
                                    WHERE ProductID='$produkid'");
        if ($sql === true) {
            $return = true;
            $msg = 'Data tersimpan';
        }
    }
    $data = [
        "icon_s" => 'success',
        "icon_e" => 'warning',
        "msg" => $msg,
        "time" => $time,
        "link" => null,
        "return" => $return
    ];
    echo json_encode($data);
}
if (isset($_POST['prosesdeleteproduk'])) {
    $produkid = $_POST['prosesdeleteproduk'];
    $sql = mysqli_query($conn, "DELETE FROM mara_product WHERE ProductID ='$produkid'");
    if ($sql === true) {
        $return = true;
        $msg = 'Data terhapus';
    }

    $data = [
        "icon_s" => 'success',
        "icon_e" => 'warning',
        "produk" => $produkid,
        "msg" => $msg,
        "time" => $time,
        "link" => null,
        "return" => $return
    ];
    echo json_encode($data);
}
if (isset($_POST['proseschangeproduk'])) {
    $dump[] = '';
    $produkid = $_POST['proseschangeproduk'];
    $sql = mysqli_query($conn, "SELECT * FROM mara_product WHERE ProductID = '$produkid'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['productid'] = $q['ProductID'];
        $dump['productdescriptions'] = $q['ProductDescriptions'];
        $dump['standardroll'] = $q['StandardRoll'];
        $dump['standardrollkonversi'] = $q['StandardRollKonversi'];
        $dump['standarddus'] = $q['StandardDus'];
        $dump['standardduskonversi'] = $q['StandardDusKonversi'];
        $dump['standardcar'] = $q['StandardCar'];
        $dump['standardcarkonversi'] = $q['StandardCarKonversi'];
        $dump['standarberatprimer'] = $q['StandardBeratPrimer'];
        $dump['totalselflife'] = $q['TotalSelfLife'];
        $dump['bobottimbang'] = $q['BobotTimbang'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['createdon'] = $q['CreatedOn'];
        $dump['changedby'] = $q['ChangeBy'];
        $dump['changedon'] = $q['ChangeOn'];
    }
    echo json_encode($dump);
}

// ---------------------------------------------------------
// Data Shift
// ---------------------------------------------------------
if (isset($_POST['prosessimpanshift'])) {
    $result = false;
    $shiftid = strtoupper($_POST['prosessimpanshift'][0]);
    $shiftdescription = $_POST['prosessimpanshift'][1];
    $rangetimeid = $_POST['prosessimpanshift'][2];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changeon = date("Y-m-d H:i:s");
    $changeby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT * FROM shifts WHERE ShiftID = '$shiftid'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        // $sql = mysqli_query($Xcon, "UPDATE shifts SET ShiftDescriptions='$shiftdescription',RangeTimeID='$rangetimeid' WHERE ShiftID ='$shiftid'");
        $result = 2;
    } else {
        $sql = mysqli_query($conn, "INSERT INTO shifts (ShiftID,ShiftDescriptions,RangeTimeID,CreatedOn,CreatedBy) 
                                    VALUES('$shiftid','$shiftdescription','$rangetimeid','$createdon','$createdby')");
    }
    if ($sql === true) {
        $result = true;
    }
    echo $result;
}
if (isset($_POST['prosesupdateshift'])) {
    $result = false;
    $shiftid = strtoupper($_POST['prosesupdateshift'][0]);
    $deskripsi = $_POST['prosesupdateshift'][1];
    $rangetimeid = $_POST['prosesupdateshift'][2];
    $changeon = date("Y-m-d H:i:s");
    $changeby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT * FROM shifts WHERE ShiftID = '$shiftid'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $sql = mysqli_query($conn, "UPDATE shifts SET ShiftDescriptions='$deskripsi',
                                    RangeTimeID='$rangetimeid',
                                    ChangedOn='$changeon',ChangedBy='$changeby' 
                                    WHERE ShiftID='$shiftid'");
        $result = true;
    }
    echo $result;
}
if (isset($_POST['prosesdeleteshift'])) {
    $return = false;
    $shiftid = $_POST['prosesdeleteshift'];
    $sql = mysqli_query($conn, "DELETE FROM shifts WHERE ShiftID  ='$shiftid'");
    if ($sql === true) {
        $return = true;
    }
    echo $return;
}
if (isset($_POST['proseschangeshift'])) {
    $dump[] = '';
    $shiftid = $_POST['proseschangeshift'];
    $sql = mysqli_query($conn, "SELECT * FROM shifts WHERE ShiftID = '$shiftid'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['shiftid'] = $q['ShiftID'];
        $dump['shiftdescriptions'] = $q['ShiftDescriptions'];
        $dump['rangetimeid'] = $q['RangeTimeID'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['createdon'] = $q['CreatedOn'];
        $dump['changedby'] = $q['ChangeBy'];
        $dump['changedon'] = $q['ChangeOn'];
    }
    echo json_encode($dump);
}

// ---------------------------------------------------------
// Data Shift Range
// ---------------------------------------------------------
if (isset($_POST['prosessimpanshiftrange'])) {
    $result = false;
    $rangetime = $_POST['prosessimpanshiftrange'][0];
    $deskripsi = $_POST['prosessimpanshiftrange'][1];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changeon = date("Y-m-d H:i:s");
    $changeby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT * FROM shifts_r WHERE RangeTimeID  = '$rangetime'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $result = 2;
    } else {
        $sql = mysqli_query($conn, "INSERT INTO shifts_r (RangeTimeID,RangeDescriptions) 
                                    VALUES('$rangetime','$deskripsi')");
    }
    if ($sql === true) {
        $result = true;
    }
    echo $result;
}
if (isset($_POST['prosesdeleteshiftrange'])) {
    $return = false;
    $shiftidrange = $_POST['prosesdeleteshiftrange'];
    $sql = mysqli_query($conn, "DELETE FROM shifts_r WHERE RangeTimeID   ='$shiftidrange'");
    if ($sql === true) {
        $return = true;
    }
    echo $return;
}
if (isset($_POST['proseschangeshiftrange'])) {
    $dump[] = '';
    $shiftid_r = $_POST['proseschangeshiftrange'];
    $sql = mysqli_query($conn, "SELECT * FROM shifts_r WHERE RangeTimeID  = '$shiftid_r'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['rangetimeid'] = $q['RangeTimeID'];
        $dump['rangedescriptions'] = $q['RangeDescriptions'];
    }
    echo json_encode($dump);
}
if (isset($_POST['prosesupdateshiftrange'])) {
    $result = false;
    $rangetimeid = strtoupper($_POST['prosesupdateshiftrange'][0]);
    $deskripsi = $_POST['prosesupdateshiftrange'][1];
    $sql = mysqli_query($conn, "SELECT * FROM shifts_r WHERE RangeTimeID = '$rangetimeid'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $sql = mysqli_query($conn, "UPDATE shifts_r SET RangeDescriptions='$deskripsi' 
                                    WHERE RangeTimeID='$rangetimeid'");
        $result = true;
    }
    echo $result;
}

// ---------------------------------------------------------
// Main Resource
// ---------------------------------------------------------
if (isset($_POST['prosessimpanmainresource'])) {
    $result = false;
    $idmain = strtoupper($_POST['prosessimpanmainresource'][0]);
    $deskripsi1 = ucwords($_POST['prosessimpanmainresource'][1]);
    $deskripsi2 = ucwords($_POST['prosessimpanmainresource'][2]);
    $primary = $_POST['prosessimpanmainresource'][3];
    $secondary = $_POST['prosessimpanmainresource'][4];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changeon = date("Y-m-d H:i:s");
    $changeby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT * FROM crhd WHERE ResourceID  = '$idmain'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        // $sql = mysqli_query($Xcon, "UPDATE crhd SET ResourceDescriptions1='$deskripsi1',ResourceDescriptions2='$deskripsi2',PrimaryResourceID='$primary',SecondaryResourceID='$secondary',ActiveStatus='$status' 
        //                             WHERE ResourceID  ='$idmain'");
        $result = 2;
    } else {
        $sql = mysqli_query($conn, "INSERT INTO crhd (ResourceID,ResourceDescriptions1,ResourceDescriptions2,PrimaryResourceID,SecondaryResourceID,CreatedBy,CreatedOn) 
                                    VALUES('$idmain','$deskripsi1','$deskripsi2','$primary','$secondary','$createdby','$createdon')");
    }
    if ($sql === true) {
        $result = true;
    }
    echo $result;
}
if (isset($_POST['prosesupdatemainresource'])) {
    $result = false;
    $idmain = strtoupper($_POST['prosesupdatemainresource'][0]);
    $deskripsi1 = ucwords($_POST['prosesupdatemainresource'][1]);
    $deskripsi2 = ucwords($_POST['prosesupdatemainresource'][2]);
    $primary = $_POST['prosesupdatemainresource'][3];
    $secondary = $_POST['prosesupdatemainresource'][4];
    $changeon = date("Y-m-d H:i:s");
    $changeby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT * FROM crhd WHERE ResourceID  = '$idmain'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $sql = mysqli_query($conn, "UPDATE crhd SET ResourceDescriptions1='$deskripsi1',ResourceDescriptions2='$deskripsi2',
        PrimaryResourceID='$primary',SecondaryResourceID='$secondary',ChangedBy='$changeby',ChangedOn='$changeon'
                                    WHERE ResourceID='$idmain'");
        $result = true;
    }
    echo $result;
}
if (isset($_POST['proseschangemainresource'])) {
    $dump[] = '';
    $idmain = $_POST['proseschangemainresource'];
    $sql = mysqli_query($conn, "SELECT * FROM crhd WHERE ResourceID  = '$idmain'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['resourceid'] = $q['ResourceID'];
        $dump['resourcedescriptions1'] = $q['ResourceDescriptions1'];
        $dump['resourcedescriptions2'] = $q['ResourceDescriptions2'];
        $dump['primaryresourceid'] = $q['PrimaryResourceID'];
        $dump['secondaryresourceid'] = $q['SecondaryResourceID'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['createdon'] = $q['CreatedOn'];
    }
    echo json_encode($dump);
}
if (isset($_POST['prosesdeletemainresource'])) {
    $return = false;
    $idmain = $_POST['prosesdeletemainresource'];
    $sql = mysqli_query($conn, "DELETE FROM crhd WHERE ResourceID    ='$idmain'");
    if ($sql === true) {
        $return = true;
    }
    echo $return;
}

// ---------------------------------------------------------
// Primary Resource
// ---------------------------------------------------------
if (isset($_POST['prosessimpanprimaryresource'])) {
    $result = false;
    $idprimary = $_POST['prosessimpanprimaryresource'][0];
    $deskripsi = $_POST['prosessimpanprimaryresource'][1];
    $merk = $_POST['prosessimpanprimaryresource'][2];
    $noinventaris = $_POST['prosessimpanprimaryresource'][3];
    $type = $_POST['prosessimpanprimaryresource'][4];
    $status = $_POST['prosessimpanprimaryresource'][5];
    $sql = mysqli_query($conn, "SELECT * FROM crhd_primary WHERE PrimaryResourceID = '$idprimary'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        // $sql = mysqli_query($Xcon, "UPDATE crhd_primary SET PrimaryDescriptions='$deskripsi',Merk='$merk',NoInventaris='$noinventaris',Types='$type',ActiveStatus='$status' WHERE PrimaryResourceID ='$idprimary'");
        $result = 2;
    } else {
        $sql = mysqli_query($conn, "INSERT INTO crhd_primary (PrimaryResourceID,PrimaryDescriptions,Merk,NoInventaris,Types,ActiveStatus) 
                                    VALUES('$idprimary','$deskripsi','$merk','$noinventaris','$type','$status')");
    }
    if ($sql === true) {
        $result = true;
    }
    echo $result;
}
if (isset($_POST['prosesupdateprimaryresource'])) {
    $result = false;
    $idprimary = strtoupper($_POST['prosesupdateprimaryresource'][0]);
    $deskripsi = ucwords($_POST['prosesupdateprimaryresource'][1]);
    $merk = ucwords($_POST['prosesupdateprimaryresource'][2]);
    $noinventaris = ucwords($_POST['prosesupdateprimaryresource'][3]);
    $xtype = ucwords($_POST['prosesupdateprimaryresource'][4]);
    $status = $_POST['prosesupdateprimaryresource'][5];
    $sql = mysqli_query($conn, "SELECT * FROM crhd_primary WHERE PrimaryResourceID = '$idprimary'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $sql = mysqli_query($conn, "UPDATE crhd_primary SET PrimaryDescriptions='$deskripsi',Merk='$merk',
        NoInventaris='$noinventaris',Types='$xtype',ActiveStatus='$status'
                                    WHERE PrimaryResourceID='$idprimary'");
        $result = true;
    }
    echo $result;
}
if (isset($_POST['proseschangeprimaryresource'])) {
    $dump[] = '';
    $idprimary = $_POST['proseschangeprimaryresource'];
    $sql = mysqli_query($conn, "SELECT * FROM crhd_primary WHERE PrimaryResourceID = '$idprimary'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['primaryresourceid'] = $q['PrimaryResourceID'];
        $dump['primarydescriptions'] = $q['PrimaryDescriptions'];
        $dump['merk'] = $q['Merk'];
        $dump['noinventaris'] = $q['NoInventaris'];
        $dump['types'] = $q['Types'];
        $dump['activestatus'] = $q['ActiveStatus'];
    }
    echo json_encode($dump);
}
if (isset($_POST['prosesdeleteprimaryresource'])) {
    $return = false;
    $idprimary = $_POST['prosesdeleteprimaryresource'];
    $sql = mysqli_query($conn, "DELETE FROM crhd_primary WHERE PrimaryResourceID ='$idprimary'");
    if ($sql === true) {
        $return = true;
    }
    echo $return;
}

// ---------------------------------------------------------
// Secondary Resource
// ---------------------------------------------------------
if (isset($_POST['prosessimpansecondaryresource'])) {
    $result = false;
    $idsecondary = $_POST['prosessimpansecondaryresource'][0];
    $deskripsi = $_POST['prosessimpansecondaryresource'][1];
    $merk = $_POST['prosessimpansecondaryresource'][2];
    $noinventaris = $_POST['prosessimpansecondaryresource'][3];
    $type = $_POST['prosessimpansecondaryresource'][4];
    $status = $_POST['prosessimpansecondaryresource'][5];
    $sql = mysqli_query($conn, "SELECT * FROM crhd_secondary WHERE SecondaryResourceID = '$idsecondary'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        // $sql = mysqli_query($Xcon, "UPDATE crhd_secondary SET SecondaryDescriptions='$deskripsi',Merk='$merk',NoInventaris='$noinventaris',Types='$type',ActiveStatus='$status' WHERE SecondaryResourceID ='$idsecondary'");
        $result = 2;
    } else {
        $sql = mysqli_query($conn, "INSERT INTO crhd_secondary (SecondaryResourceID,SecondaryDescriptions,Merk,NoInventaris,Types,ActiveStatus) 
                                    VALUES('$idsecondary','$deskripsi','$merk','$noinventaris','$type','$status')");
    }
    if ($sql === true) {
        $result = true;
    }
    echo $result;
}
if (isset($_POST['prosesupdatesecondaryresource'])) {
    $result = false;
    $idsecondary = strtoupper($_POST['prosesupdatesecondaryresource'][0]);
    $deskripsi = ucwords($_POST['prosesupdatesecondaryresource'][1]);
    $merk = ucwords($_POST['prosesupdatesecondaryresource'][2]);
    $noinventaris = ucwords($_POST['prosesupdatesecondaryresource'][3]);
    $xtype = ucwords($_POST['prosesupdatesecondaryresource'][4]);
    $status = $_POST['prosesupdatesecondaryresource'][5];
    $sql = mysqli_query($conn, "SELECT * FROM crhd_secondary WHERE SecondaryResourceID ='$idsecondary'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $sql = mysqli_query($conn, "UPDATE crhd_secondary SET SecondaryDescriptions='$deskripsi',Merk='$merk',
        NoInventaris='$noinventaris',Types='$xtype',ActiveStatus='$status'
                                    WHERE SecondaryResourceID='$idsecondary'");
        $result = true;
    }
    echo $result;
}
if (isset($_POST['proseschangesecondaryresource'])) {
    $dump[] = '';
    $idsecondary = $_POST['proseschangesecondaryresource'];
    $sql = mysqli_query($conn, "SELECT * FROM crhd_secondary WHERE SecondaryResourceID = '$idsecondary'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['secondaryresourceid'] = $q['SecondaryResourceID'];
        $dump['secondarydescriptions'] = $q['SecondaryDescriptions'];
        $dump['merk'] = $q['Merk'];
        $dump['noinventaris'] = $q['NoInventaris'];
        $dump['types'] = $q['Types'];
        $dump['activestatus'] = $q['ActiveStatus'];
    }
    echo json_encode($dump);
}
if (isset($_POST['prosesdeletesecondaryresource'])) {
    $return = false;
    $idsecondary = $_POST['prosesdeletesecondaryresource'];
    $sql = mysqli_query($conn, "DELETE FROM crhd_secondary WHERE SecondaryResourceID ='$idsecondary'");
    if ($sql === true) {
        $return = true;
    }
    echo $return;
}

// ---------------------------------------------------------
// Mixing Resource
// ---------------------------------------------------------
if (isset($_POST['prosessimpanmixingresource'])) {
    $result = false;
    $idmixing = $_POST['prosessimpanmixingresource'][0];
    $deskripsi = $_POST['prosessimpanmixingresource'][1];
    $merk = $_POST['prosessimpanmixingresource'][2];
    $noinventaris = $_POST['prosessimpanmixingresource'][3];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changeon = date("Y-m-d H:i:s");
    $changeby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT * FROM crhd_mixing WHERE ResourceID = '$idmixing'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        // $sql = mysqli_query($Xcon, "UPDATE crhd_mixing SET ResourceDescriptions1='$deskripsi',Merk='$merk',NoInventaris='$noinventaris',ChangedBy='$changeby',ChangedOn='$changeon' WHERE ResourceID ='$idmixing'");
        $result = 2;
    } else {
        $sql = mysqli_query($conn, "INSERT INTO crhd_mixing (ResourceID,ResourceDescriptions1,Merk,NoInventaris,CreatedBy,CreatedOn) 
                                    VALUES('$idmixing','$deskripsi','$merk','$noinventaris','$createdby','$createdon')");
    }
    if ($sql === true) {
        $result = true;
    }
    echo $result;
}
if (isset($_POST['prosesupdatemixingresource'])) {
    $result = false;
    $idmixing = strtoupper($_POST['prosesupdatemixingresource'][0]);
    $deskripsi = ucwords($_POST['prosesupdatemixingresource'][1]);
    $merk = ucwords($_POST['prosesupdatemixingresource'][2]);
    $noinventaris = ucwords($_POST['prosesupdatemixingresource'][3]);
    $changeon = date("Y-m-d H:i:s");
    $changeby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT * FROM crhd_mixing WHERE ResourceID ='$idmixing'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $sql = mysqli_query($conn, "UPDATE crhd_mixing SET ResourceDescriptions1='$deskripsi',Merk='$merk',
        NoInventaris='$noinventaris',ChangedOn='$changeon',ChangedBy='$changeby'
                                    WHERE ResourceID='$idmixing'");
        $result = true;
    }
    echo $result;
}
if (isset($_POST['proseschangemixingresource'])) {
    $dump[] = '';
    $idsecondary = $_POST['proseschangemixingresource'];
    $sql = mysqli_query($conn, "SELECT * FROM crhd_mixing WHERE ResourceID = '$idsecondary'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['resourceid'] = $q['ResourceID'];
        $dump['descriptions'] = $q['ResourceDescriptions1'];
        $dump['merk'] = $q['Merk'];
        $dump['noinventaris'] = $q['NoInventaris'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['createdon'] = $q['CreatedOn'];
    }
    echo json_encode($dump);
}
if (isset($_POST['prosesdeletemixingresource'])) {
    $return = false;
    $idmixing = $_POST['prosesdeletemixingresource'];
    $sql = mysqli_query($conn, "DELETE FROM crhd_mixing WHERE ResourceID ='$idmixing'");
    if ($sql === true) {
        $return = true;
    }
    echo $return;
}

// ---------------------------------------------------------
// Employee
// ---------------------------------------------------------
if (isset($_POST['prosessimpanemployee'])) {
    $result = false;
    $pernr = $_POST['prosessimpanemployee'][0];
    $nama = strtoupper($_POST['prosessimpanemployee'][1]);
    $posisi = strtoupper($_POST['prosessimpanemployee'][2]);
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changeon = date("Y-m-d H:i:s");
    $changeby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT * FROM pa001 WHERE PersonnelNumber = '$pernr'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        // $sql = mysqli_query($Xcon, "UPDATE pa001 SET EmployeeName='$nama',PositionID='$posisi',ChangedBy='$changeby',ChangedOn='$changeon' 
        //                             WHERE PersonnelNumber  ='$pernr'");
        $result = 2;
    } else {
        $sql = mysqli_query($conn, "INSERT INTO pa001 (PersonnelNumber,EmployeeName,PositionID,CreatedBy,CreatedOn) 
                                    VALUES('$pernr','$nama','$posisi','$createdby','$createdon')");
    }
    if ($sql === true) {
        $result = true;
    }
    echo $result;
}
if (isset($_POST['prosesupdataemployee'])) {
    $result = false;
    $pernr = $_POST['prosesupdataemployee'][0];
    $employee = ucwords($_POST['prosesupdataemployee'][1]);
    $PositionID = $_POST['prosesupdataemployee'][2];
    $changeon = date("Y-m-d H:i:s");
    $changeby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT * FROM pa001 WHERE PersonnelNumber ='$pernr'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $sql = mysqli_query($conn, "UPDATE pa001 SET EmployeeName='$employee',
        PositionID='$PositionID',ChangedOn='$changeon',ChangedBy='$changeby'
                                    WHERE PersonnelNumber ='$pernr'");
        $result = true;
    }
    echo $result;
}
if (isset($_POST['proseschangeemployee'])) {
    $dump[] = '';
    $pernr = $_POST['proseschangeemployee'];
    $sql = mysqli_query($conn, "SELECT * FROM pa001 WHERE PersonnelNumber = '$pernr'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['personnelnumber'] = $q['PersonnelNumber'];
        $dump['descriptions'] = $q['EmployeeName'];
        $dump['positionid'] = $q['PositionID'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['createdon'] = $q['CreatedOn'];
    }
    echo json_encode($dump);
}
if (isset($_POST['prosesdeleteemployee'])) {
    $return = false;
    $pernr = $_POST['prosesdeleteemployee'];
    $sql = mysqli_query($conn, "DELETE FROM pa001 WHERE PersonnelNumber ='$pernr'");
    if ($sql === true) {
        $return = true;
    }
    echo $return;
}

// ---------------------------------------------------------
// Auth
// ---------------------------------------------------------
if (isset($_POST['prosessimpanauth'])) {
    // function Getdata($value, $table, $where, $valuewhere)
    // {
    //     include 'koneksi.php';
    //     $sql = mysqli_query($conn, "SELECT $value FROM $table WHERE $where ='$valuewhere'");
    //     $q = mysqli_fetch_array($sql);
    //     if (mysqli_num_rows($sql) > 0) {
    //         return $q[$value];
    //     }
    // }
    $result = false;
    $userid = strtoupper($_POST['prosessimpanauth'][0]);
    $pernr = $_POST['prosessimpanauth'][1];
    $password = base64_encode(Getdata('PassCode', 'general_setting_web', 'UnitCode', 'S001'));
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changeon = date("Y-m-d H:i:s");
    $changeby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT * FROM usr02 WHERE UserID = '$userid'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $result = 2;
    } else {
        $sql = mysqli_query($conn, "INSERT INTO usr02 (UserID,
                                                        PersonnelNumber,
                                                        InitialPassword,
                                                        CreatedBy,
                                                        CreatedOn) 
                                            VALUES('$userid',
                                                    '$pernr',
                                                    '$password',
                                                    '$createdby',
                                                    '$createdon')");
        mysqli_query($conn, "INSERT INTO agr_assignrole (UserID,
                                                        Roles,
                                                        CreatedOn,
                                                        CreatedBy) VALUES('$userid',
                                                                            'Zsisp_umum',
                                                                            '$createdon',
                                                                            '$createdby')");
    }
    if ($sql === true) {
        $result = true;
    }
    echo $result;
}
if (isset($_POST['prosesupdataauth'])) {
    $result = false;
    $userid = strtoupper($_POST['prosesupdataauth'][0]);
    $pernr = $_POST['prosesupdataauth'][1];
    $changeon = date("Y-m-d H:i:s");
    $changeby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT * FROM usr02 WHERE UserID  ='$userid'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $sql = mysqli_query($conn, "UPDATE usr02 SET PersonnelNumber ='$pernr',
        ChangedOn='$changeon',ChangedBy='$changeby'
                                    WHERE UserID ='$userid'");
        $result = true;
    }
    echo $result;
}
if (isset($_POST['proseschangeauth'])) {
    $dump[] = '';
    $userid = $_POST['proseschangeauth'];
    $sql = mysqli_query($conn, "SELECT * FROM usr02 WHERE UserID = '$userid'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['userid'] = $q['UserID'];
        $dump['personnelnumber'] = $q['PersonnelNumber'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['createdon'] = $q['CreatedOn'];
    }
    echo json_encode($dump);
}
if (isset($_POST['prosesdeleteauth'])) {
    $return = false;
    $userid = $_POST['prosesdeleteauth'];
    $sql = mysqli_query($conn, "DELETE FROM usr02 WHERE UserID ='$userid'");
    if ($sql === true) {
        mysqli_query($conn, "DELETE FROM agr_assignrole WHERE UserID ='$userid'");
        $return = true;
    }
    echo $return;
}
if (isset($_POST['prosesgetnameauth'])) {
    $result = '';
    $pernr = $_POST['prosesgetnameauth'];
    $sql = mysqli_query($conn, "SELECT EmployeeName  FROM pa001 WHERE PersonnelNumber = '$pernr'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $result = $q['EmployeeName'];
    }
    echo $result;
}

// ---------------------------------------------------------
// Job Position
// ---------------------------------------------------------
if (isset($_POST['prosessimpanjobposition'])) {
    $result = false;
    $idposition = $_POST['prosessimpanjobposition'][0];
    $deskripsi = $_POST['prosessimpanjobposition'][1];
    $sql = mysqli_query($conn, "SELECT * FROM pa002 WHERE PositionID='$idposition'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        // $sql = mysqli_query($Xcon, "UPDATE pa002 SET Descriptions='$deskripsi'
        //                             WHERE PositionID   ='$idposition'");
        $result = 2;
    } else {
        $sql = mysqli_query($conn, "INSERT INTO pa002 (PositionID,Descriptions) 
                                    VALUES('$idposition','$deskripsi')");
    }
    if ($sql === true) {
        $result = true;
    }
    echo $result;
}
if (isset($_POST['prosesupdatejob'])) {
    $result = false;
    $idposition = $_POST['prosesupdatejob'][0];
    $deskripsi = strtoupper($_POST['prosesupdatejob'][1]);
    $sql = mysqli_query($conn, "SELECT * FROM pa002 WHERE PositionID='$idposition'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $sql = mysqli_query($conn, "UPDATE pa002 SET Descriptions='$deskripsi'
                                    WHERE PositionID ='$idposition'");
        $result = true;
    }
    echo $result;
}

if (isset($_POST['proseschangejob'])) {
    $dump[] = '';
    $positionid = $_POST['proseschangejob'];
    $sql = mysqli_query($conn, "SELECT * FROM pa002 WHERE PositionID = '$positionid'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump = [
            "positionid" => $q['PositionID'],
            "descriptions" => $q['Descriptions']
        ];
    }
    echo json_encode($dump);
}
if (isset($_POST['prosesdeletejob'])) {
    $return = false;
    $positionid = $_POST['prosesdeletejob'];
    $sql = mysqli_query($conn, "DELETE FROM pa002 WHERE PositionID ='$positionid'");
    if ($sql === true) {
        $return = true;
    }
    echo $return;
}

// ---------------------------------------------------------
// Daftar Menu
// ---------------------------------------------------------
if (isset($_POST['prosessimpandatamenu'])) {
    $result = false;
    $menu = strtolower($_POST['prosessimpandatamenu'][0]);
    $deskripsi = $_POST['prosessimpandatamenu'][1];
    $sql = mysqli_query($conn, "SELECT * FROM agr_menu WHERE Menus='$menu'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        // $sql = mysqli_query($Xcon, "UPDATE pa001 SET EmployeeName='$nama',PositionID='$posisi',ChangedBy='$changeby',ChangedOn='$changeon' 
        //                             WHERE PersonnelNumber  ='$pernr'");
        $result = 2;
    } else {
        $sql = mysqli_query($conn, "INSERT INTO agr_menu (Menus,Descriptions) 
                                    VALUES('$menu','$deskripsi')");
    }
    if ($sql === true) {
        $result = true;
    }
    echo $result;
}
if (isset($_POST['prosesupdatamenu'])) {
    $result = false;
    $menu = $_POST['prosesupdatamenu'][0];
    $deskripsi = $_POST['prosesupdatamenu'][1];
    $sql = mysqli_query($conn, "SELECT * FROM agr_menu WHERE Menus  ='$menu'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $sql = mysqli_query($conn, "UPDATE agr_menu SET Descriptions ='$deskripsi'
                                    WHERE Menus ='$menu'");
        $result = true;
    }
    echo $result;
}
if (isset($_POST['prosesdeletemenu'])) {
    $return = false;
    $menu = $_POST['prosesdeletemenu'];
    $sql = mysqli_query($conn, "DELETE FROM agr_menu WHERE menus ='$menu'");
    if ($sql === true) {
        mysqli_query($conn, "DELETE FROM agr_role WHERE menus ='$menu'");
        $return = true;
    }
    echo $return;
}

// ---------------------------------------------------------
// Role
// ---------------------------------------------------------
if (isset($_POST['prosessimpandatarole'])) {
    $result = false;
    $role = ucfirst($_POST['prosessimpandatarole'][0]);
    $menu = $_POST['prosessimpandatarole'][1];
    $query = mysqli_query($conn, "SELECT Menus FROm agr_menu WHERE Descriptions='$menu'");
    $q = mysqli_fetch_array($query);
    $menu = $q['Menus'];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT * FROM agr_role WHERE Roles ='$role' AND Menus='$menu'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $result = 2;
    } else {
        $sql = mysqli_query($conn, "INSERT INTO agr_role (Roles,Menus,Stts,CreatedOn,CreatedBy) 
                                    VALUES('$role','$menu','X','$createdon','$createdby')");
    }
    if ($sql === true) {
        $result = true;
    }
    echo $result;
}
if (isset($_POST['prosesdeleterole'])) {
    $return = false;
    $role = $_POST['prosesdeleterole'][0];
    $menu = $_POST['prosesdeleterole'][1];
    $sql = mysqli_query($conn, "DELETE FROM agr_role WHERE Roles='$role' AND menus ='$menu'");
    if ($sql === true) {
        $return = true;
    }
    echo $return;
}

// ---------------------------------------------------------
// Assign Role
// ---------------------------------------------------------
if (isset($_POST['prosesdisplayassignrole'])) {
    function cekroletick($userid, $roles)
    {
        include "koneksi.php";
        $result = '';
        $tick = mysqli_query($conn, "SELECT * FROM agr_assignrole WHERE UserID = '$userid' AND Roles ='$roles'");
        if (mysqli_num_rows($tick) > 0) {
            $result = 'Checked';
        }
        $row = mysqli_fetch_array($tick);
        $roles = $row['Roles'];
        if ($roles == 'Zsisp_umum') {
            $result = 'Checked Disabled';
        }
        return $result;
    }
    $i = 0;
    $output = '';
    $userid = $_POST['prosesdisplayassignrole'];
    $sql = mysqli_query($conn, "SELECT DISTINCT Roles FROM agr_role");
    if (mysqli_num_rows($sql) > 0) {
        $output = '
        <h6 class="fw-bold mt-5">ROLES USER</h6>
        <hr class="mb-3 w-50">
        <div class="row">';
        while ($q = mysqli_fetch_array($sql)) {
            if ($q['Roles'] == 'Zsisp_superbasis' && $userid != 'SM000') {
                $output .= '
            <div class="col-sm-3">
                <div class="form-check">
                    <input class="form-check-input" name="mySelector" type="checkbox" value="' . $q["Roles"] . '" id="roles' . $i . '" Disabled>
                    <label class="form-check-label" for="flexCheckDefault">
                        ' . $q['Roles'] . '
                    </label>';
                $output .= '
                    </div>
            </div>';
            } else {
                $output .= '
            <div class="col-sm-3">
                <div class="form-check">
                    <input class="form-check-input" name="mySelector" type="checkbox" value="' . $q["Roles"] . '" id="roles' . $i . '" ' . cekroletick($userid, $q['Roles']) . '>
                    <label class="form-check-label" for="flexCheckDefault">
                        ' . $q['Roles'] . '
                    </label>';
                $output .= '
                    </div>
            </div>';
            }
            $i += 1;
        }
        $output .= '
            </div>
        ';
    }
    echo $output;
}
if (isset($_POST['prosessimpanassignrole'])) {
    $return = false;
    $roleslist = $_POST['prosessimpanassignrole'][0];
    $userid = $_POST['prosessimpanassignrole'][1];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $count = count($roleslist);
    mysqli_query($conn, "DELETE FROM agr_assignrole WHERE UserID='$userid'");
    for ($i = 0; $i < $count; $i++) {
        $role = mysqli_query($conn, "INSERT INTO agr_assignrole (UserID,Roles,CreatedOn,CreatedBy) VALUES('$userid','$roleslist[$i]','$createdon','$createdby')");
    }
    if ($role === true) {
        $return = true;
    }
    echo $return;
}

// ---------------------------------------------------------
// Config Reviewer
// ---------------------------------------------------------
if (isset($_POST['prosessimpareviewercpb'])) {
    $return = false;
    $menu = $_POST['prosessimpareviewercpb'][0];
    $pernr = $_POST['prosessimpareviewercpb'][1];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT * FROM mapping_reviewer WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND 
                                                                        FormReviewer ='$menu' AND
                                                                        Pernr='$pernr'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) == 0) {
        $sql = mysqli_query($conn, "INSERT INTO mapping_reviewer (Plant,
                                                                    UnitCode,
                                                                    FormReviewer,
                                                                    Pernr,
                                                                    CreatedOn,
                                                                    CreatedBy) 
                                    VALUES('$plant',
                                            '$unitcode',
                                            '$menu',
                                            '$pernr',
                                            '$createdon',
                                            '$createdby')");
    }
    $return = $sql;
    $data = [
        'plant' => $plant,
        'unitcode' => $unitcode,
        'iconmsgsukses' => 'success',
        'iconmsgerror' => 'warning',
        'msgsukses' => 'Tersimpan',
        'msgerror' => 'Gagal',
        'time' => 3000,
        'return' => $return,
    ];
    echo json_encode($data);
}
if (isset($_POST['prosesdeletereviewercpb'])) {
    $return = false;
    $menu = $_POST['prosesdeletereviewercpb'][0];
    $pernr = $_POST['prosesdeletereviewercpb'][1];
    $sql = mysqli_query($conn, "DELETE FROM mapping_reviewer WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND 
                                                                    FormReviewer ='$menu' AND
                                                                    Pernr='$pernr'");
    $return = $sql;
    $data = [
        'plant' => $plant,
        'unitcode' => $unitcode,
        'iconmsgsukses' => 'success',
        'iconmsgerror' => 'warning',
        'msgsukses' => 'Terhapus',
        'msgerror' => 'Gagal',
        'time' => 3000,
        'return' => $return,
        'test' => $sql,
    ];
    echo json_encode($data);
}

// ---------------------------------------------------------
// Data Supplier
// ---------------------------------------------------------
if (isset($_POST['prosessimpandatasupplier'])) {
    $result = false;
    $kodesupplier = $_POST['prosessimpandatasupplier'][0];
    $namasupplier = $_POST['prosessimpandatasupplier'][1];
    $keterangan = $_POST['prosessimpandatasupplier'][2];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changeon = date("Y-m-d H:i:s");
    $changeby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT * FROM data_supplier WHERE Plant='$plant' AND
                                                            UnitCode='$unitcode' AND
                                                            KodeSupplier = '$kodesupplier'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $result = 2;
    } else {
        $sql = mysqli_query($conn, "INSERT INTO data_supplier (Plant,UnitCode,KodeSupplier,NamaSupplier,Keterangan,CreatedBy,CreatedOn) 
                                    VALUES('$plant','$unitcode','$kodesupplier','$namasupplier','$keterangan','$createdby','$createdon')");
    }
    if ($sql === true) {
        $result = true;
    }
    echo $result;
}
if (isset($_POST['prosesupdatedatasupplier'])) {
    $result = false;
    $kodesupplier = $_POST['prosesupdatedatasupplier'][0];
    $namasupplier = $_POST['prosesupdatedatasupplier'][1];
    $keterangan = $_POST['prosesupdatedatasupplier'][2];
    $changeon = date("Y-m-d H:i:s");
    $changeby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT * FROM data_supplier WHERE Plant='$plant' AND
                                                            UnitCode='$unitcode' AND
                                                            KodeSupplier = '$kodesupplier'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $sql = mysqli_query($conn, "UPDATE data_supplier SET NamaSupplier='$namasupplier',
                                                            Keterangan='$keterangan',
                                                            ChangedOn='$changeon',
                                                            ChangedBy='$changeby'
                                                        WHERE Plant='$plant' AND
                                                            UnitCode='$unitcode' AND
                                                            KodeSupplier = '$kodesupplier'");
        $result = true;
    }
    echo $result;
}
if (isset($_POST['proseschangedatasupplier'])) {
    $dump[] = '';
    $kodesupplier = $_POST['proseschangedatasupplier'];
    $sql = mysqli_query($conn, "SELECT * FROM data_supplier WHERE Plant='$plant' AND
                                                            UnitCode='$unitcode' AND
                                                            KodeSupplier = '$kodesupplier'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['kodesupplier'] = $q['KodeSupplier'];
        $dump['namasupplier'] = $q['NamaSupplier'];
        $dump['keterangan'] = $q['Keterangan'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['createdon'] = $q['CreatedOn'];
    }
    echo json_encode($dump);
}
if (isset($_POST['prosesdeletedatasupplier'])) {
    $return = false;
    $kodesupplier = $_POST['prosesdeletedatasupplier'];
    $sql = mysqli_query($conn, "DELETE FROM data_supplier WHERE Plant='$plant' AND 
                                                                UnitCode='$unitcode' AND
                                                                KodeSupplier='$kodesupplier'");
    if ($sql === true) {
        $return = true;
    }
    echo $return;
}

// ---------------------------------------------------------
// Planning Pengemasan
// ---------------------------------------------------------
if (isset($_POST['edautomatiscreateplanning'])) {
    $productid = $_POST['edautomatiscreateplanning'][0];
    $tglmixing = $_POST['edautomatiscreateplanning'][1];
    $tanggalautomatis = date("Y-m-d");
    $sql = mysqli_query($conn, "SELECT TotalSelfLife FROM mara_product WHERE ProductID ='$productid'");
    $q = mysqli_fetch_array($sql);
    $exp = $q['TotalSelfLife'];
    if ($exp != 0) {
        $tanggalautomatis = date('Y-m-d', strtotime('+' . $exp . ' month', strtotime($tglmixing)));
    }
    echo $tanggalautomatis;
}
if (isset($_POST['sumbitproductmanual'])) {
    $productid = $_POST['sumbitproductmanual'];
    $sql = mysqli_query($conn, "SELECT *
                                FROM mara_product 
                                WHERE ProductID = '$productid' OR 
                                        ProductDescriptions= '$productid'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $exp = $q['TotalSelfLife'];
        $date = date('Y-m-d');
        if ($exp != 0) {
            $tanggalautomatis = date('Y-m-d', strtotime($date . '+' . $exp . ' month'));
        }
        $data = [
            "statuscode" => true,
            "productid" => $q['ProductID'],
            "descriptions" => $q['ProductDescriptions'],
            "selflife" => $tanggalautomatis
        ];
    }
    echo json_encode($data);
}
if (isset($_POST['sumbitshiftmanual'])) {
    $dump[] = '';
    $shiftid = $_POST['sumbitshiftmanual'];
    $sql = mysqli_query($conn, "SELECT * FROM shifts WHERE ShiftID = '$shiftid'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['statuscode'] = true;
        $dump['shiftid'] = $q['ShiftID'];
        // $dump['descriptions'] = $q['ShiftDescriptions'];
    }
    echo json_encode($dump);
}
if (isset($_POST['sumbitkodemesinmanual'])) {
    $dump[] = '';
    $resourceid = $_POST['sumbitkodemesinmanual'];
    $sql = mysqli_query($conn, "SELECT * FROM crhd WHERE ResourceID = '$resourceid'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['statuscode'] = true;
        $dump['resourceid'] = $q['ResourceID'];
        $dump['resourcedescriptions1'] = $q['ResourceDescriptions1'];
        $dump['resourcedescriptions2'] = $q['ResourceDescriptions2'];
        $dump['primaryresourceid'] = $q['PrimaryResourceID'];
        $dump['secondaryresourceid'] = $q['SecondaryResourceID'];
    }
    echo json_encode($dump);
}
if (isset($_POST['prosessavecreateplanning'])) {
    $dump[] = '';
    $kodeplanning = '';
    $productid = $_POST['prosessavecreateplanning'][0];
    $shift = $_POST['prosessavecreateplanning'][1];
    $tglkemas = $_POST['prosessavecreateplanning'][2];
    $resourceid = $_POST['prosessavecreateplanning'][3];
    $batch = strtoupper($_POST['prosessavecreateplanning'][4]);
    $ed = $_POST['prosessavecreateplanning'][5];
    $resourceidmix = $_POST['prosessavecreateplanning'][6];
    $tglmixing = $_POST['prosessavecreateplanning'][7];
    $jumlahsachet = $_POST['prosessavecreateplanning'][8];
    $uom = $_POST['prosessavecreateplanning'][9];
    $noproses = $_POST['prosessavecreateplanning'][10];
    $tong = $_POST['prosessavecreateplanning'][11];
    $createdfor = $_POST['prosessavecreateplanning'][12];

    $createdfor = explode(" ", $createdfor);
    $createdfor = $createdfor[0];
    $reviewer_add = $_POST['prosessavecreateplanning'][13];
    $reviewer_add = explode(" ", $reviewer_add);
    $reviewer_add = $reviewer_add[0];
    $reviewer = $_POST['prosessavecreateplanning'][14];
    $reviewer_lenght = count($reviewer);
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $years = date('Y');

    // ------> Get Kode Planning
    $sql = mysqli_query($conn, "SELECT Current, Too FROM nriv WHERE NumberRangeType='Planning' AND Years='$years' ORDER BY Current DESC");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $kodeplanning = $q['Current'] + 1;
        $maxkode = $q['Too'];
        // -----> Cek Overload Number
        if ($kodeplanning > $maxkode) {
            die;
        }
    } else {
        $sql = mysqli_query($conn, "SELECT Fromm FROM nriv WHERE NumberRangeType='Planning'");
        $q = mysqli_fetch_array($sql);
        if (mysqli_num_rows($sql) > 0) {
            $kodeplanning = $q['Fromm'];
            mysqli_query($conn, "UPDATE nriv SET Current='$kodeplanning',Years='$years' WHERE NumberRangeType='Planning'");
        }
        // die;
    }
    // ------> End
    $sql = mysqli_query($conn, "INSERT INTO planning_prod_header (Plant,UnitCode,PlanningNumber,ProductID,ShiftID,PackingDate,ResourceID,BatchNumber,
                                                                ExpiredDate,ResourceIDMix,MixingDate,Quantity,UnitOfMeasures,
                                                                ProcessNumber,ContainerNumber,CreatedFor,CreatedBy,CreatedOn,Years,SttsX) 
                                VALUES('$plant',
                                        '$unitcode',
                                        '$kodeplanning',
                                        '$productid',
                                        '$shift',
                                        '$tglkemas',
                                        '$resourceid',
                                        '$batch',
                                        '$ed',
                                        '$resourceidmix',
                                        '$tglmixing',
                                        '$jumlahsachet',
                                        '$uom',
                                        '$noproses',
                                        '$tong',
                                        '$createdfor',
                                        '$createdby',
                                        '$createdon',
                                        '$years',
                                        'REL')");
    if ($sql === true) {
        mysqli_query($conn, "UPDATE nriv SET Current='$kodeplanning' WHERE NumberRangeType='Planning' AND Years='$years'");
        $dump['status'] = true;
        $dump['kodeplanning'] = $kodeplanning;

        for ($i = 1; $i <= $reviewer_lenght; $i++) {
            if ($reviewer_lenght > 1) {
                setreviewerpartial2('create_planning', $kodeplanning, $years, $reviewer[($i - 1)]);
            } else {
                $rev = str_replace(",", "", $reviewer);
                setreviewerpartial2('create_planning', $kodeplanning, $years, $rev[($i - 1)]);
            }
        }
        setreviewertambahan2('create_planning', $kodeplanning, $years, $reviewer_add, $reviewer_lenght);
    }
    // $dump['kodeplanning'] = $kodeplanning;
    echo json_encode($dump);
}
if (isset($_POST['prosessavelogprint'])) {
    $planningnumber = $_POST['prosessavelogprint'][0];
    $years = $_POST['prosessavelogprint'][1];
    $descriptions = 'Print Work Order';
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $return = false;
    mysqli_query($conn, "UPDATE planning_prod_header SET Log_print='X' WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years'");
    $sql = mysqli_query($conn, "INSERT INTO log_print (Plant,UnitCode,
                                                        Identification_log,
                                                        Years,
                                                        Descriptions,
                                                        CreatedBy,
                                                        CreatedOn)
                                VALUES('$plant','$unitcode','$planningnumber','$years','$descriptions','$createdby','$createdon')");
    if ($sql === true) {
        $return = true;
    }
    echo $return;
}
if (isset($_POST['prosesdisplayplanningnumber'])) {
    $dump[] = '';
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $prosestype = $_POST['prosesdisplayplanningnumber'][0];
    $planningnumber = $_POST['prosesdisplayplanningnumber'][1];
    $years = $_POST['prosesdisplayplanningnumber'][2];
    $dump['prosestype'] = $prosestype;
    if ($prosestype == 'planning_pengolahan') {
        $sql = mysqli_query($conn, "SELECT * FROM planning_pengolahan_detail WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            PlanningNumber = '$planningnumber' AND
                                                                                            Years='$years'");
        $output = '          
                <table class="table table-sm mt-3 w-100" id="dcreateplanning">
                    <thead class="bg-dark text-white">
                        <tr>
                            <td>#</td>
                            <td>Hari, Tanggal</td>
                            <td style="width: 50%;">Produk</td>
                            <td>Mesin</td>
                            <td>Jml Resep</td>
                            <td>ED/BC</td>
                        </tr>
                    </thead>
                    <tbody>';
        $i = 1;
        while ($r = mysqli_fetch_array($sql)) {
            $batch_show = explode(',', $r['BatchNumber']);
            $productid = $r['ProductID'];
            $query = mysqli_query($conn, "SELECT ProductDescriptions FROM mara_product WHERE ProductID='$r[ProductID]'");
            $q = mysqli_fetch_array($query);
            $output .=              '<tr>
                                        <td>' . $i . '</a></td>
                                        <td>' . getdayformat2(date('w', strtotime($r['CreatedOn']))) . ', ' . date('d/m/Y', strtotime($r['CreatedOn'])) . '</td>
                                        <td>' . $q['ProductDescriptions'] . '</td>
                                        <td>' . $r['ResourceIDMix'] . '</td>
                                        <td>' . $r['JumlahResep'] . '</td>
                                        <td>' . 'ED. ' . date('M Y', strtotime($r['ExpiredDate'])) . '/' . $r['BatchNumber'] . '</td>
                                    </tr>';
            $i++;
        }
        // <td>' . 'ED. ' . date('M Y', strtotime($r['ExpiredDate'])) . '/' . $batch_show[0] . '-' . end($batch_show) . '</td>
        $output .= '
                    </tbody>
                            </table>';
        $dump['planningnumber'] = $planningnumber;
        $dump['years'] = $years;
        $dump['productid'] = $productid;
        $query = mysqli_query($conn, "SELECT CreatedFor,CreatedOn,CreatedBy,Shift FROM planning_pengolahan_header WHERE Plant='$plant' AND
                                                                                                UnitCode='$unitcode' AND
                                                                                                PlanningNumber = '$planningnumber' AND
                                                                                                Years='$years'");
        $q = mysqli_fetch_array($query);
        $dump['createdon'] = $q['CreatedOn'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['shift'] = $q['Shift'];
        $query = mysqli_query($conn, "SELECT EmployeeName,PersonnelNumber FROM pa001 WHERE PersonnelNumber ='$q[CreatedFor]'");
        $q = mysqli_fetch_array($query);
        $dump['createdfor'] = $q['PersonnelNumber'] . ' - ' . $q['EmployeeName'];
        // Approval
        $sql = mysqli_query($conn, "SELECT * FROM tb_approval_viewer WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            ProcessType ='planning_pengolahan' AND
                                                                                            PlanningNumber = '$planningnumber' AND
                                                                                            Years='$years' ORDER BY Levels ASC");
        $output .= '
                <h6 class="mt-5 fw-bold">Reviewer</h6>          
                <table class="table table-sm w-50" id="dcreateplanning">
                    <thead class="bg-dark text-white">
                        <tr>
                            <td style="width: 5%;">No</td>
                            <td style="width: 30%;">Approval</td>
                            <td>Jabatan</td>
                            <td>Status</td>
                            <td>Tgl Approval</td>
                        </tr>
                    </thead>
                    <tbody>';
        $i = 1;
        while ($r = mysqli_fetch_array($sql)) {
            $query = mysqli_query($conn, "SELECT EmployeeName,PositionID FROM pa001 WHERE PersonnelNumber =' $r[PersonnelNumber]'");
            $q = mysqli_fetch_array($query);
            $status = '<label class="fw-bold">Belum disetujui</label>';
            $approvaldate = '-';
            if ($r['StatusApproval'] != null || $r['StatusApproval'] != '') {
                $status = '<label class="text-success fw-bold">Disetujui</label>';
                $approvaldate = $r['ChangedOn'];
            }
            if ($r['StatusApproval'] == 'T') {
                $status = '<label class="text-danger fw-bold">Ditolak</label>';
                $approvaldate = $r['ChangedOn'];
            }

            $output .=              '<tr>
                                        <td>' . $r['Levels'] . '</td>
                                        <td>' . $r['PersonnelNumber'] . ' - ' . $q['EmployeeName'] . '</td>
                                        <td>' . $q['PositionID'] . '</td>
                                        <td>' . $status . '</td>
                                        <td>' . $approvaldate . '</td>
                                    </tr>';
            $i++;
        }
        $output .= '
                    </tbody>
                            </table>';
        $sql = mysqli_query($conn, "SELECT * FROM tb_eraseprosespengolahan WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            PlanningNumber = '$planningnumber' AND
                                                                                            Years='$years'");
        if (mysqli_num_rows($sql) != 0) {
            $output .= '
                <h6 class="mt-5 fw-bold"><li>Penyesuaian Proses</li></h6>          
                <table class="table table-sm w-50" id="dcreateplanning">
                    <thead class="bg-dark text-white">
                        <tr>
                            <td style="width: 5%;">#</td>
                            <td style="width: 30%;">Product ID</td>
                            <td style="width: 5%;">Batch</td>
                            <td style="width: 5%;">Jml Proses</td>
                        </tr>
                    </thead>
                    <tbody>';
            $i = 1;
            while ($r = mysqli_fetch_array($sql)) {
                $query = mysqli_query($conn, "SELECT ProductDescriptions FROM mara_product WHERE ProductID='$r[ProductID]'");
                $q = mysqli_fetch_array($query);
                $output .=              '<tr>
                                        <td>' . $i . '</td>
                                        <td>' . $q['ProductDescriptions'] . '</td>
                                        <td>' . $r['BatchNumber'] . '</td>
                                        <td><input class="form-control form-control-sm" type="number" min="1" max="2" value="' . $r['JmlProses'] . '" onchange="updatejmlprosesdisplaypengolahan(' . $r['IndexRow'] . ',this.value)"></td>
                                    </tr>';
                $i++;
            }
            $output .= '
                    </tbody>
                            </table>';
            $dump['status'] = true;
            $dump['output'] = $output;
        }

        // ----Tambahan
        $query = mysqli_query($conn, "SELECT * FROM planning_pengolahan_detail WHERE Plant='$plant' AND
                                                                                    UnitCode='$unitcode' AND
                                                                                    PlanningNumber='$planningnumber' AND
                                                                                    Years='$years'");
        if (mysqli_num_rows($query) <> 0) {
            $r = mysqli_fetch_array($query);
            $reff = $r['ReffCode'];
            $createdon = $r['CreatedOn'];
            $createdby = $r['CreatedBy'];
            $productid = $r['ProductID'];


            $output1 = '
            <table class="table table-sm w-100">
                <tr>
                    <td>
                    <h6 class="mt-5 fw-bold"><li>List Bahan - Proses I</li></h6>
                        <table class="table table-sm table-bordered w-100">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>Kode Bahan</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                </tr>
                            </thead>';
            $sql = mysqli_query($conn, "SELECT * FROM tb_detailprosesmixing WHERE Plant='$plant' AND 
                                                                         UnitCode='$unitcode' AND
                                                                         NoProses='1' AND
                                                                         Proses='1' AND
                                                                         ReffCode='$reff'
                                                                         ORDER BY CreatedOn ASC");
            if (mysqli_num_rows($sql) != 0) {
                while ($r = mysqli_fetch_array($sql)) {
                    $output1 .= '
                     <tr>
                         <td>' . $r["KodeBahan"] . '</td>
                         <td>' . $r["Jumlah"] . '</td>
                         <td>' . $r["Satuan"] . '</td>
                     </tr>
         ';
                }
                $output1 .= '
                 </table>';
            }
            $output1 .= '
                    </td>
                    <td></td>
                    <td>
                    <h6 class="mt-5 fw-bold"><li>List Bahan - Proses II</li></h6>
                        <table class="table table-sm table-bordered w-100">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>Kode Bahan</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                </tr>
                            </thead>';
            $sql = mysqli_query($conn, "SELECT * FROM tb_detailprosesmixing WHERE Plant='$plant' AND 
                                                                         UnitCode='$unitcode' AND
                                                                         NoProses='1' AND
                                                                         Proses='2' AND
                                                                         ReffCode='$reff'
                                                                         ORDER BY CreatedOn ASC");
            if (mysqli_num_rows($sql) != 0) {
                while ($r = mysqli_fetch_array($sql)) {
                    $output1 .= '
                     <tr>
                         <td>' . $r["KodeBahan"] . '</td>
                         <td>' . $r["Jumlah"] . '</td>
                         <td>' . $r["Satuan"] . '</td>
                     </tr>
         ';
                }
                $output1 .= '
                 </table>';
            }
            $output1 .= '
                    </td>
                </tr>
            </table> ';

            //------Show Table All Proses
            $output1 .= '
            <h6 class="mt-5 fw-bold"><li>Total Bahan</li></h6> 
                <table class="table table-sm table-bordered w-25">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Kode Bahan</th>
                            <th>Jumlah Teoritis</th>
                        </tr>
                    </thead>
                ';
            $query = mysqli_query($conn, "SELECT * FROM mapping_preparemixing WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                ReffCode='$reff'");
            if (mysqli_num_rows($query) != 0) {
                while ($r = mysqli_fetch_array($query)) {
                    $q = mysqli_query($conn, "SELECT SUM(Jumlah) AS Jumlah FROM tb_detailprosesmixing WHERE Plant='$plant' AND
                                                                                        UnitCode='$unitcode' AND
                                                                                        NoProses='1' AND
                                                                                        ProductID='$r[ProductID]' AND
                                                                                        ReffCode='$reff' AND
                                                                                        KodeBahan='$r[KodeBahan]'");
                    $qr = mysqli_fetch_array($q);
                    $jumlah = number_format($qr['Jumlah'], 0);
                    $jmlteoritis = number_format($r['JmlTeoritis'], 0);
                    $output1 .= '
                        <tr>
                            <td>' . $r["KodeBahan"] . '</td>
                            <td>' . $r["JmlTeoritis"] . '</td>
                        </tr>';
                }
                $output1 .= '
                       </table>';
            }
            $dump['output1'] = $output1;
        }
    } elseif ($prosestype == 'create_planning') {
        $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                        AND PlanningNumber = '$planningnumber' 
                                                                                        AND Years='$years'");
        $q = mysqli_fetch_array($sql);
        if (mysqli_num_rows($sql) > 0) {

            $dump['status'] = true;
            $dump['planning'] = $q['PlanningNumber'];
            $dump['years'] = $q['Years'];
            $dump['productid'] = $q['ProductID'];
            $dump['shiftid'] = $q['ShiftID'];
            $dump['packingdate'] = $q['PackingDate'];
            $dump['resourceid'] = $q['ResourceID'];
            $dump['batchnumber'] = $q['BatchNumber'];
            $dump['expireddate'] = $q['ExpiredDate'];
            $dump['resourceidmix'] = $q['ResourceIDMix'];
            $dump['mixingdate'] = $q['MixingDate'];
            $dump['quantity'] = $q['Quantity'];
            $dump['unitofmeasures'] = $q['UnitOfMeasures'];
            $dump['processnumber'] = $q['ProcessNumber'];
            $dump['tong'] = $q['ContainerNumber'];
            if ($q['Approval'] == 'X') {
                $dump['statusapproval'] = 'Approved';
            } else {
                $dump['statusapproval'] = '';
            }
            // $dump['statusapproval'] = $q['Approval'];
            $dump['createdby'] = $q['CreatedBy'];
            $dump['createdon'] = $q['CreatedOn'];
            $dump['changedby'] = $q['ChangedBy'];
            $dump['changedon'] = $q['ChangedOn'];
            $dump['stts'] = $q['Stts'];
            $dump['years'] = $q['Years'];

            $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber = '$planningnumber' AND
                                                                        Years='$years'");
            $output = '          
                <table class="table table-sm mt-3 w-100" id="dcreateplanning">
                    <thead class="bg-dark text-white">
                        <tr>
                            <td>#</td>
                            <td>Hari, Tanggal</td>
                            <td style="width: 50%;">Produk</td> 
                            <td>Mesin</td>
                            <td>ResourceID</td>
                            <td>Qty</td>
                            <td>ED/BC</td>
                        </tr>
                    </thead>
                    <tbody>';
            $i = 1;
            while ($r = mysqli_fetch_array($sql)) {
                $batch_show = explode(',', $r['BatchNumber']);
                $productid = $r['ProductID'];
                $query = mysqli_query($conn, "SELECT ProductDescriptions FROM mara_product WHERE ProductID='$r[ProductID]'");
                $q = mysqli_fetch_array($query);
                $output .=              '<tr>
                                        <td>' . $i . '</a></td>
                                        <td>' . getdayformat2(date('w', strtotime($r['CreatedOn']))) . ', ' . date('d/m/Y', strtotime($r['CreatedOn'])) . '</td>
                                        <td>' . $q['ProductDescriptions'] . '</td>
                                        <td>' . $r['ResourceIDMix'] . '</td>
                                        <td>' . $r['ResourceID'] . '</td>
                                        <td>' . $r['Quantity'] . ' ' . $r['UnitOfMeasures'] . '</td>
                                        <td>' . 'ED. ' . date('M Y', strtotime($r['ExpiredDate'])) . '/' . $r['BatchNumber'] . '</td>
                                    </tr>';
                $i++;
            }
            $output .= '
                    </tbody>
                            </table>';
            $sql = mysqli_query($conn, "SELECT * FROM tb_approval_viewer WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            ProcessType ='create_planning' AND
                                                                                            PlanningNumber = '$planningnumber' AND
                                                                                            Years='$years' ORDER BY Levels ASC");
            $output .= '
                <h6 class="mt-5 fw-bold">Reviewer</h6>          
                <table class="table table-sm w-50" id="dcreateplanning">
                    <thead class="bg-dark text-white">
                        <tr>
                            <td style="width: 5%;">No</td>
                            <td style="width: 30%;">Approval</td>
                            <td>Jabatan</td>
                            <td>Status</td>
                            <td>Tgl Approval</td>
                            <td>Catatan</td>
                        </tr>
                    </thead>
                    <tbody>';
            $i = 1;
            while ($r = mysqli_fetch_array($sql)) {
                $query = mysqli_query($conn, "SELECT EmployeeName,PositionID FROM pa001 WHERE PersonnelNumber =' $r[PersonnelNumber]'");
                $q = mysqli_fetch_array($query);
                $status = '<label class="text-danger fw-bold">Belum disetujui</label>';
                $approvaldate = '-';
                if ($r['StatusApproval'] != null || $r['StatusApproval'] != '') {
                    $status = '<label class="text-success fw-bold">Disetujui</label>';
                    $approvaldate = $r['ChangedOn'];
                }

                $output .=              '<tr>
                                        <td>' . $r['Levels'] . '</td>
                                        <td>' . $r['PersonnelNumber'] . ' - ' . $q['EmployeeName'] . '</td>
                                        <td>' . $q['PositionID'] . '</td>
                                        <td>' . $status . '</td>
                                        <td>' . $approvaldate . '</td>
                                        <td>' . $r['Catatan'] . '</td>
                                    </tr>';
                $i++;
            }
            $output .= '
                    </tbody>
                            </table>';
            $dump['output'] = $output;
        }
    }
    echo json_encode($dump);
}
if (isset($_POST['prosesupdatejmlprosesdisplaypengolahan'])) {
    $dump[] = '';
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $indexrow = $_POST['prosesupdatejmlprosesdisplaypengolahan'][0];
    $jmlproses = $_POST['prosesupdatejmlprosesdisplaypengolahan'][1];

    mysqli_query($conn, "UPDATE tb_eraseprosespengolahan SET JmlProses='$jmlproses' WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            IndexRow='$indexrow'");
}
if (isset($_POST['prosesupdateproduksiplanningdisplayplanning'])) {
    $return = false;
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosesupdateproduksiplanningdisplayplanning'][0];
    $productid = $_POST['prosesupdateproduksiplanningdisplayplanning'][1];
    $shiftid = $_POST['prosesupdateproduksiplanningdisplayplanning'][2];
    $batch = $_POST['prosesupdateproduksiplanningdisplayplanning'][3];
    $ed = $_POST['prosesupdateproduksiplanningdisplayplanning'][4];
    $kodemesin = $_POST['prosesupdateproduksiplanningdisplayplanning'][5];
    $tglkemas = $_POST['prosesupdateproduksiplanningdisplayplanning'][6];
    $mixing = $_POST['prosesupdateproduksiplanningdisplayplanning'][7];
    $tglmixing = $_POST['prosesupdateproduksiplanningdisplayplanning'][8];
    $qty = $_POST['prosesupdateproduksiplanningdisplayplanning'][9];
    $uom = $_POST['prosesupdateproduksiplanningdisplayplanning'][10];
    $prosesnumber = $_POST['prosesupdateproduksiplanningdisplayplanning'][11];
    $years = $_POST['prosesupdateproduksiplanningdisplayplanning'][12];
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];

    $query = mysqli_query($conn, "UPDATE planning_prod_header SET   ProductID='$productid',
                                                                    ShiftID='$shiftid',
                                                                    PackingDate= '$tglkemas',
                                                                    ResourceID='$kodemesin',
                                                                    BatchNumber='$batch',
                                                                    ExpiredDate='$ed',
                                                                    ResourceIDMix='$mixing',
                                                                    MixingDate='$tglmixing',
                                                                    Quantity='$qty',
                                                                    UnitOfMeasures='$uom',
                                                                    ProcessNumber='$prosesnumber',
                                                                    ChangedBy='$changedby',
                                                                    ChangedOn='$changedon'
                                                                    WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                         AND PlanningNumber ='$planningnumber' 
                                                                                         AND Years='$years'   
                                                                    ");
    if ($query === true) {
        $return = true;
    }
    echo $return;
}

// ---------------------------------------------------------
// Change/Display Planning 'PENGOLAHAN'
// ---------------------------------------------------------
if (isset($_POST['prosesdisplayplanningpengolahan'])) {
    $dump[] = '';
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosesdisplayplanningpengolahan'][0];
    $years = $_POST['prosesdisplayplanningpengolahan'][1];
    $items = $_POST['prosesdisplayplanningpengolahan'][2];
    $batch = $_POST['prosesdisplayplanningpengolahan'][4];
    $sql = mysqli_query($conn, "SELECT * FROM planning_pengolahan_detail WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            PlanningNumber = '$planningnumber' AND
                                                                                            Years='$years'");
    $output = '          
                <table class="table table-sm mt-3 w-100" id="dcreateplanning">
                    <thead class="bg-dark text-white">
                        <tr>
                            <td>#</td>
                            <td>Hari, Tanggal</td>
                            <td style="width: 30%;">Produk</td>
                            <td>Mesin</td>
                            <td>Jml Resep</td>
                            <td style="width: 50%;">ED/BC</td>
                        </tr>
                    </thead>
                    <tbody>';
    $i = 1;
    while ($r = mysqli_fetch_array($sql)) {
        $batch_show = explode(',', $r['BatchNumber']);
        $productid = $r['ProductID'];
        $query = mysqli_query($conn, "SELECT ProductDescriptions FROM mara_product WHERE ProductID='$r[ProductID]'");
        $q = mysqli_fetch_array($query);
        $output .=              '<tr>
                                        <td>' . $i . '</a></td>
                                        <td>' . getdayformat2(date('w', strtotime($r['CreatedOn']))) . ', ' . date('d/m/Y', strtotime($r['CreatedOn'])) . '</td>
                                        <td>' . $q['ProductDescriptions'] . '</td>
                                        <td>' . $r['ResourceIDMix'] . '</td>
                                        <td>' . $r['JumlahResep'] . '</td>
                                        <td>' . 'ED. ' . date('M Y', strtotime($r['ExpiredDate'])) . '/' . $r['BatchNumber'] . '</td>
                                    </tr>';
        $i++;
    }
    $output .= '
                    </tbody>
                            </table>';
    $dump['planningnumber'] = $planningnumber;
    $dump['years'] = $years;
    $dump['productid'] = $productid;
    // $dump['bets'] = $bets;
    $dump['items'] = $items;
    $query = mysqli_query($conn, "SELECT CreatedFor,CreatedOn,CreatedBy,Shift FROM planning_pengolahan_header WHERE Plant='$plant' AND
                                                                                                UnitCode='$unitcode' AND
                                                                                                PlanningNumber = '$planningnumber' AND
                                                                                                Years='$years'");
    $q = mysqli_fetch_array($query);
    $dump['createdon'] = date('d.m.Y', strtotime($q['CreatedOn']));
    $dump['createdby'] = $q['CreatedBy'];
    $dump['shift'] = $q['Shift'];
    $query = mysqli_query($conn, "SELECT EmployeeName,PersonnelNumber FROM pa001 WHERE PersonnelNumber ='$q[CreatedFor]'");
    $q = mysqli_fetch_array($query);
    $dump['createdfor'] = $q['PersonnelNumber'] . ' - ' . $q['EmployeeName'];
    // Approval
    $sql = mysqli_query($conn, "SELECT * FROM tb_approval_viewer WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            ProcessType ='planning_pengolahan' AND
                                                                                            PlanningNumber = '$planningnumber' AND
                                                                                            Years='$years' ORDER BY Levels ASC");
    $output .= '
                <h6 class="mt-5 fw-bold">Reviewer</h6>          
                <table class="table table-sm w-50" id="dcreateplanning">
                    <thead class="bg-dark text-white">
                        <tr>
                            <td style="width: 5%;">No</td>
                            <td style="width: 30%;">Approval</td>
                            <td>Jabatan</td>
                            <td>Status</td>
                            <td>Tgl Approval</td>
                            <td>Catatan</td>
                        </tr>
                    </thead>
                    <tbody>';
    $i = 1;
    while ($r = mysqli_fetch_array($sql)) {
        $query = mysqli_query($conn, "SELECT EmployeeName,PositionID FROM pa001 WHERE PersonnelNumber =' $r[PersonnelNumber]'");
        $q = mysqli_fetch_array($query);
        $status = '<label class="fw-bold">Belum disetujui</label>';
        $approvaldate = '-';
        if ($r['StatusApproval'] != null || $r['StatusApproval'] != '') {
            $status = '<label class="text-success fw-bold">Disetujui</label>';
            $approvaldate = $r['ChangedOn'];
        }
        if ($r['StatusApproval'] == 'T') {
            $status = '<label class="text-danger fw-bold">Ditolak</label>';
            $approvaldate = $r['ChangedOn'];
        }

        $output .=              '<tr>
                                        <td>' . $r['Levels'] . '</td>
                                        <td>' . $r['PersonnelNumber'] . ' - ' . $q['EmployeeName'] . '</td>
                                        <td>' . $q['PositionID'] . '</td>
                                        <td>' . $status . '</td>
                                        <td>' . $approvaldate . '</td>
                                        <td>' . $r['Catatan'] . '</td>
                                    </tr>';
        $i++;
    }
    $output .= '
                    </tbody>
                            </table>';
    $sql = mysqli_query($conn, "SELECT * FROM insp_pengolahan_header WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    ProductID='$productid' AND
                                                                    BatchNumber='$batch' AND
                                                                    PlanningNumber='$planningnumber' AND
                                                                    Years='$years'");
    $r = mysqli_fetch_array($sql);
    $dump['ILot'] = $r['InspectionLot'];
    $dump['ILyears'] = $r['Lotyears'];
    $dump['status'] = true;
    $dump['output'] = $output;
    echo json_encode($dump);
}
if (isset($_POST['prosesdisplaydrymixdatapengolahan'])) {
    $dump[] = '';
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosesdisplaydrymixdatapengolahan'][0];
    $years = $_POST['prosesdisplaydrymixdatapengolahan'][1];
    $items = $_POST['prosesdisplaydrymixdatapengolahan'][2];
    $batch = $_POST['prosesdisplaydrymixdatapengolahan'][3];
    $return = false;

    $query = mysqli_query($conn, "SELECT * FROM planning_pengolahan_detail WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                PlanningNumber='$planningnumber' AND
                                                                                Years='$years' AND
                                                                                Items='$items' AND
                                                                                BatchNumber LIKE '%$batch%'");
    $row = mysqli_fetch_array($query);
    $reff = $row['ReffCode'];
    $productid = $row['ProductID'];

    $sql = mysqli_query($conn, "SELECT BatchNumber FROM planning_pengolahan_subdetail WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                PlanningNumber='$planningnumber' AND
                                                                                Years='$years' AND
                                                                                ProductID='$productid'");
    $output = '
    <div class="card">
        <div class="border-0 mb-0 p-3">
            <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark active" id="modalpills-1-tab" data-bs-toggle="pill" data-bs-target="#modalpengolahanpills-1" type="button" role="tab" aria-controls="pills-1" aria-selected="true">Scan Bahan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark" id="modalpills-2-tab" data-bs-toggle="pill" data-bs-target="#modalpengolahanpills-2" type="button" role="tab" aria-controls="pills-2" aria-selected="false">Prepare Mixing</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark" id="modalpills-3-tab" data-bs-toggle="pill" data-bs-target="#modalpengolahanpills-3" type="button" role="tab" aria-controls="pills-3" aria-selected="false">Proses Mixing</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark" id="modalpills-4-tab" data-bs-toggle="pill" data-bs-target="#modalpengolahanpills-4" type="button" role="tab" aria-controls="pills-4" aria-selected="false">Timbang Bahan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark" id="modalpills-5-tab" data-bs-toggle="pill" data-bs-target="#modalpengolahanpills-5" type="button" role="tab" aria-controls="pills-5" aria-selected="false">Kirim Bahan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark" id="modalpills-6-tab" data-bs-toggle="pill" data-bs-target="#modalpengolahanpills-6" type="button" role="tab" aria-controls="pills-6" aria-selected="false">Terima Bahan</button>
                </li>
            </ul>
            <div class="tab-content" id="tabs-tabContent">
                <div class="tab-pane fade show active" id="modalpengolahanpills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                        <!-- Scan Bahan -->';
    $sql = mysqli_query($conn, "SELECT * FROM tb_detailbahanpengolahan WHERE Plant='$plant' AND 
                                                                         UnitCode='$unitcode' AND
                                                                         PlanningNumber='$planningnumber' AND
                                                                         Years='$years' AND
                                                                         ProductID='$productid' AND
                                                                         BatchNumber='$batch' AND
                                                                         NoProses=1
                                                                         ORDER BY NoProses,CreatedOn ASC");
    if (mysqli_num_rows($sql) <> 0) {
        $output .= '                          
                                <div class="border-0 mb-0 p-3 mt-3">
                                    <div class="form-group row mb-0">
                                        <label for="parameter8persiapanhoper" class="col-sm-2 col-form-label">No Proses</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control form-control-sm" value="1" readonly>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-sm table-hover w-100">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Product ID</th>
                                            <th>Batch Number</th>
                                            <th>No Proses</th>
                                            <th>Kode Bahan</th>
                                            <th>Jumlah</th>
                                            <th>No Kantong</th>
                                            <th>Created On</th>
                                            <th>Created By</th>
                                        </tr>
                                    </thead>';

        while ($r = mysqli_fetch_array($sql)) {
            $q = mysqli_fetch_array($query);
            $output .= '
                                    <tbody>
                                        <tr>
                                            <td>' . $r["ProductID"] . '</td>
                                            <td>' . $r["BatchNumber"] . '</td>
                                            <td>' . $r["NoProses"] . '</td>
                                            <td>' . $r["KodeBahan"] . '</td>
                                            <td>' . $r["JmlNyata"] . '</td>
                                            <td>' . $r["NoKantong"] . '</td>
                                            <td>' . beautydate2($r["CreatedOn"]) . '</td>
                                            <td>' . $r["CreatedBy"] . '</td>
                                        </tr>
                                    </tbody>';
        }
    }
    $sql = mysqli_query($conn, "SELECT * FROM tb_detailbahanpengolahan WHERE Plant='$plant' AND 
                                                                         UnitCode='$unitcode' AND
                                                                         PlanningNumber='$planningnumber' AND
                                                                         Years='$years' AND
                                                                         ProductID='$productid' AND
                                                                         BatchNumber='$batch' AND
                                                                         NoProses=2
                                                                         ORDER BY NoProses,CreatedOn ASC");
    if (mysqli_num_rows($sql) <> 0) {
        $output .= '
                                </table>
                                <div class="form-group row">
                                    <div class="col-sm-12 text-end mt-5">
                                        <button type="button" class="btn btn-outline-success btn-sm" onclick="changescanbahandatapengolahan()"><img src="../asset/icon/pencil.png"> Change</button>
                                    </div>
                                </div>

                                <div class="border-0 mb-0 p-3 mt-3">
                                    <div class="form-group row mb-0">
                                        <label for="parameter8persiapanhoper" class="col-sm-2 col-form-label">No Proses</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control form-control-sm" value="2" readonly>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-sm table-hover w-100">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Product ID</th>
                                            <th>Batch Number</th>
                                            <th>No Proses</th>
                                            <th>Kode Bahan</th>
                                            <th>Jumlah</th>
                                            <th>No Kantong</th>
                                            <th>Created On</th>
                                            <th>Created By</th>
                                        </tr>
                                    </thead>';

        while ($r = mysqli_fetch_array($sql)) {
            $q = mysqli_fetch_array($query);
            $output .= '
                                    <tbody>
                                        <tr>
                                            <td>' . $r["ProductID"] . '</td>
                                            <td>' . $r["BatchNumber"] . '</td>
                                            <td>' . $r["NoProses"] . '</td>
                                            <td>' . $r["KodeBahan"] . '</td>
                                            <td>' . $r["JmlNyata"] . '</td>
                                            <td>' . $r["NoKantong"] . '</td>
                                            <td>' . beautydate2($r["CreatedOn"]) . '</td>
                                            <td>' . $r["CreatedBy"] . '</td>
                                        </tr>
                                    </tbody>';
        }
        $output .= '
                                </table>
                                <div class="form-group row">
                                    <div class="col-sm-12 text-end mt-5">
                                        <button type="button" class="btn btn-outline-success btn-sm" onclick="changescanbahandatapengolahan()"><img src="../asset/icon/pencil.png"> Change</button>
                                    </div>
                                </div>
                                ';
    }
    $output .= '
                </div>
                <div class="tab-pane fade" id="modalpengolahanpills-2" role="tabpanel" aria-labelledby="pills-2-tab">
                        <!-- Prepare Mixing -->';
    $sql = mysqli_query($conn, "SELECT * FROM proses_prepare_mixer WHERE Plant='$plant' AND 
                                                                         UnitCode='$unitcode' AND
                                                                         PlanningNumber='$planningnumber' AND
                                                                         Years='$years' AND
                                                                         ProductID='$productid' AND
                                                                         BatchNumber='$batch' AND
                                                                         StatsUpdate=''
                                                                         ORDER BY CreatedOn ASC");
    if (mysqli_num_rows($sql) <> 0) {
        while ($row = mysqli_fetch_array($sql)) {
            $output .= '
            <div class="card mb-3">
                <div class="border-0 mb-0 p-3 mt-3">
                    <div class="form-group row mb-0">
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm fw-bold bg-transparent" style="border:none;border-bottom:2px solid black" value="No: ' . $row['NoProses'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="operator1displaydata" class="col-sm-2 offset-8 col-form-label">Operator 1</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Operator1'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="operator2displaydata" class="col-sm-2 offset-8 col-form-label">Operator 2</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Operator2'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="operator2displaydata" class="col-sm-2 offset-8 col-form-label">Operator 3</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Operator3'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="changedbydisplayplanning" class="col-sm-2 offset-8">Pengawas</label>
                        <div class="col-sm-2">
                            <input type="text" value="' . $row['PengawasProduksi'] . '" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <h6 class="fw-bold">Input Parameter</h6>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter1displaydata" class="col-sm-8 col-form-label">1. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 1) . '</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_1'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter2displaydata" class="col-sm-8 col-form-label">2. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 2) . '</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_2'] . '" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="°C" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter3persiapanhoper" class="col-sm-8 col-form-label">3. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 3) . '</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_3'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter4persiapanhoper" class="col-sm-8 col-form-label">4. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 4) . '</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_4'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter5persiapanhoper" class="col-sm-8 col-form-label">5. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 5) . '</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_5'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter6persiapanhoper" class="col-sm-8 col-form-label">6. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 6) . '</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_6'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter7persiapanhoper" class="col-sm-8 col-form-label">7. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 7) . '</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_7'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter8persiapanhoper" class="col-sm-8 col-form-label">8. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 8) . '</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_8'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter8persiapanhoper" class="col-sm-8 col-form-label">9. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 9) . '</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_9'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="parameter8persiapanhoper" class="col-sm-8 col-form-label">10. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparepengolahan', 'Item', 10) . '</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_10'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-end mt-5">
                            <button type="button" class="btn btn-outline-success btn-sm" onclick="changepreparehoperdatapengolahan(' . $row["NoProses"] . ',0)"><img src="../asset/icon/pencil.png"> Change</button>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }

    $output .= '
                </div>
                <div class="tab-pane fade" id="modalpengolahanpills-3" role="tabpanel" aria-labelledby="pills-3-tab">
                        <!-- Proses Mixing -->';
    $sql = mysqli_query($conn, "SELECT * FROM tb_headerprosesmixing WHERE Plant='$plant' AND UnitCode='$unitcode' AND
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years' AND 
                                                                            ProductID='$productid' AND
                                                                            BatchNumber='$batch' AND
                                                                            SisaQty=0
                                                                            ORDER BY NoProses");
    if (mysqli_num_rows($sql) <> 0) {
        $output .= '
                    <table class="table table-sm table-hover">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>No Proses</th>
                                <th>Kode Bahan</th>
                                <th>Batch Bahan</th>
                                <th>Qty</th>
                                <th>Satuan</th>
                                <th>Created On</th>
                            </tr>
                        </thead>
                        <tbody>';
        $return = true;

        while ($row = mysqli_fetch_array($sql)) {
            $output .= '
                            <tr>
                                <td>' . $row['NoProses'] . '</td>
                                <td>' . $row['KodeBahan'] . '</td>
                                <td>' . $row['BatchLabel'] . '</td>
                                <td>' . $row['ScanQty'] . '</td>
                                <td>' . $row['Satuan'] . '</td>
                                <td>' . beautydate1($row['CreatedOn']) . '</td>
                            </tr>';
        }
    }
    $output .= '
                        </tbody>
                    </table>     
                </div>
                <div class="tab-pane fade" id="modalpengolahanpills-4" role="tabpanel" aria-labelledby="pills-4-tab">
                    <!-- Timbang Bahan -->';
    $sql = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND UnitCode='$unitcode' AND
                                                                                        PlanningNumber='$planningnumber' AND
                                                                                        Years='$years' AND 
                                                                                        Items='$items' AND
                                                                                        BatchNumber='$batch' AND
                                                                                        EnterOn <> '0000-00-00 00:00:00'");
    if (mysqli_num_rows($sql) <> 0) {
        $output .= '
                    <table class="table table-sm table-hover">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>No Proses</th>
                                <th>No Tong</th>
                                <th>Berat</th>
                                <th>Jam Timbang</th>
                            </tr>
                        </thead>
                        <tbody>';
        $return = true;

        while ($row = mysqli_fetch_array($sql)) {
            $output .= '
                            <tr>
                                <td>' . $row['NoProses'] . '</td>
                                <td>' . $row['NoTong'] . '</td>
                                <td>' . $row['Berat'] . $row['Satuan'] . '</td>
                                <td>' . beautydate2($row['EnterOn']) . '</td>
                            </tr>';
        }
    }
    $output .= '
                        </tbody>
                    </table>        
                </div>
                <div class="tab-pane fade" id="modalpengolahanpills-5" role="tabpanel" aria-labelledby="pills-5-tab">
                        <!-- Kirim Bahan -->';
    $sql = mysqli_query($conn, "SELECT * FROM tbl_movingstock WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    PlanningNumber='$planningnumber' AND
                                                                    Years='$years' AND
                                                                    BatchNumber='$batch'");
    if (mysqli_num_rows($sql) <> 0) {
        while ($row = mysqli_fetch_array($sql)) {
            $output .= '
            <div class="card mb-3">
                <div class="border-0 mb-0 p-3 mt-3">
                    <div class="form-group row mb-0">
                        <label for="parameter8persiapanhoper" class="col-sm-2 col-form-label">No Proses</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="' . $row['NoProses'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter8persiapanhoper" class="col-sm-2 col-form-label">No Pallet</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="' . $row['NoPallet'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter8persiapanhoper" class="col-sm-2 col-form-label">Quantity</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Quantity'] . ' ' . $row['Satuan'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter8persiapanhoper" class="col-sm-2 col-form-label">Tanggal Kirim</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="' . beautydate2($row['CreatedOn']) . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter8persiapanhoper" class="col-sm-2 col-form-label">Jam Kirim</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="' . $row['JamKirim'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter8persiapanhoper" class="col-sm-2 col-form-label">Pengirim</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Pengirim'] . '" readonly>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }
    $output .= '         
                </div>
                <div class="tab-pane fade" id="modalpengolahanpills-6" role="tabpanel" aria-labelledby="pills-6-tab">
                        <!-- Terima Bahan -->';
    $sql = mysqli_query($conn, "SELECT * FROM tbl_movingstock WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    PlanningNumber='$planningnumber' AND
                                                                    Years='$years' AND
                                                                    BatchNumber='$batch' AND
                                                                    JamTerima <> '00:00:00'");
    if (mysqli_num_rows($sql) <> 0) {
        while ($row = mysqli_fetch_array($sql)) {
            $output .= '
            <div class="card mb-3">
                <div class="border-0 mb-0 p-3 mt-3">
                    <div class="form-group row mb-0">
                        <label for="parameter8persiapanhoper" class="col-sm-2 col-form-label">No Proses</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="' . $row['NoProses'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter8persiapanhoper" class="col-sm-2 col-form-label">No Pallet</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="' . $row['NoPallet'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter8persiapanhoper" class="col-sm-2 col-form-label">Quantity</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Quantity'] . ' ' . $row['Satuan'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter8persiapanhoper" class="col-sm-2 col-form-label">Tanggal Terima</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="' . beautydate2($row['ChangedOn']) . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter8persiapanhoper" class="col-sm-2 col-form-label">Jam Terima</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="' . $row['JamTerima'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter8persiapanhoper" class="col-sm-2 col-form-label">Penerima</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Pengirim'] . '" readonly>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }
    $output .= '
                </div>
            </div>
    </div>';
    $return = true;
    $dump['output'] = $output;
    $dump['return'] = $return;
    echo json_encode($dump);
}
if (isset($_POST['prosesdisplayqualitydatapengolahan'])) {
    $dump[] = '';
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosesdisplayqualitydatapengolahan'][0];
    $years = $_POST['prosesdisplayqualitydatapengolahan'][1];
    $items = $_POST['prosesdisplayqualitydatapengolahan'][2];
    $batch = $_POST['prosesdisplayqualitydatapengolahan'][3];
    $productid = $_POST['prosesdisplayqualitydatapengolahan'][4];
    $insplot = $_POST['prosesdisplayqualitydatapengolahan'][5];
    $inspyears = $_POST['prosesdisplayqualitydatapengolahan'][6];
    $return = false;

    $output = '
    <div class="card">
        <div class="border-0 mb-0 p-3">
            <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark active" id="modalpills-1-tab" data-bs-toggle="pill" data-bs-target="#modalqualitydatapengolahanpills-1" type="button" role="tab" aria-controls="pills-1" aria-selected="true">RH & Suhu</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark" id="modalpills-2-tab" data-bs-toggle="pill" data-bs-target="#modalqualitydatapengolahanpills-2" type="button" role="tab" aria-controls="pills-2" aria-selected="false">Organoleptis</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark" id="modalpills-3-tab" data-bs-toggle="pill" data-bs-target="#modalqualitydatapengolahanpills-3" type="button" role="tab" aria-controls="pills-3" aria-selected="false">Usage Decision</button>
                </li>
            </ul>
            <div class="tab-content" id="tabs-tabContent">
                <div class="tab-pane fade show active" id="modalqualitydatapengolahanpills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                        <!-- Analisa RH & Suhu -->';
    $sql = mysqli_query($conn, "SELECT * FROM qc_result WHERE Plant='$plant' AND
                                                                UnitCode='$unitcode' AND
                                                                BatchNumber='$batch' AND
                                                                PlanningNumber='$planningnumber' AND
                                                                Years='$years' AND
                                                                StatsUpdate=''");
    if (mysqli_num_rows($sql) <> 0) {
        while ($row = mysqli_fetch_array($sql)) {
            $noproses = $row['NoProses'];
            $query = mysqli_query($conn, "SELECT InspectionLot,Lotyears FROM insp_pengolahan_header WHERE Plant='$plant' AND
                                                                                                        UnitCode='$unitcode' AND
                                                                                                        ProductID='$productid' AND
                                                                                                        BatchNumber='$batch' AND
                                                                                                        PlanningNumber='$planningnumber' AND
                                                                                                        Years='$years' AND
                                                                                                        NoProses='$noproses'");
            $q = mysqli_fetch_array($query);
            $output .= '
            <div class="card mb-3">
                <div class="border-0 mb-0 p-3 mt-3">
                    <div class="form-group row mb-0">
                        <label for="parameter8persiapanhoper" class="col-sm-2 col-form-label">No Proses</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="' . $noproses . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="inspetionlotterimabahan" class="col-sm-2 col-form-label">Inspection Lot</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="inspetionlotterimabahan" value="' . $q['InspectionLot'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="inspyearsterimabahan" class="col-sm-2 col-form-label">Insp. Years</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="inspyearsterimabahan" value="' . $q['Lotyears'] . '" readonly>
                        </div>
                    </div> 
                    <div class="form-group row mb-0 mt-3">
                        <div class="col-sm-8">
                            <table class="table table-sm table-bordered">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th>Suhu</th>
                                        <th>Satuan</th>
                                        <th>Nama QC</th>
                                        <th>Created On</th>
                                        <th>Created By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>' . $row['Suhu'] . '</td>
                                        <td>' . Getdata("UnitOfMeasures", "qc_characteristic", "KodeProses", "P001") . '</td>
                                        <td>' . $row['CreatedFor'] . ' - ' . Getnamakaryawan2($row['CreatedFor']) . '</td>
                                        <td>' . beautydate1($row['CreatedOn']) . '</td>
                                        <td>' . Getpernr($row['CreatedBy'])  . ' - ' . Getnamakaryawan($row['CreatedBy']) . '</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-end mt-5">
                            <button type="button" class="btn btn-outline-success btn-sm" onclick="changepreparehoperdatapengolahan(' . $row["NoProses"] . ',1)"><img src="../asset/icon/pencil.png"> Change</button>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }
    $output .= '
                </div>
                <div class="tab-pane fade" id="modalqualitydatapengolahanpills-2" role="tabpanel" aria-labelledby="pills-2-tab">
                        <!-- Organoleptis -->';
    function checklist($true)
    {
        if ($true == 'true') {
            $return = '✔';
        } else if ($true == 'false') {
            $return = 'X';
        } else {
            $return = $true;
        }
        return $return;
    }
    $sql = mysqli_query($conn, "SELECT * FROM result_recording WHERE Plant='$plant' AND
                                                                UnitCode='$unitcode' AND
                                                                InspectionLot='$insplot' AND
                                                                Lotyears='$inspyears' AND
                                                                NoProses=1 AND
                                                                StatsUpdate=''");
    if (mysqli_num_rows($sql) <> 0) {
        $output .= '
            <div class="card mb-3">
                <div class="border-0 mb-0 p-3 mt-3">
                <div class="form-group row mb-0">
                    <label for="parameter8persiapanhoper" class="col-sm-2 col-form-label">No Proses</label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control form-control-sm" value="1" readonly>
                    </div>
                </div>
                    <div class="form-group row mb-0">
                        <table class="table table-sm table-bordered">
                            <thead class="bg-dark text-white text-center" style="vertical-align: middle">
                                <tr>
                                    <th rowspan=2>Master of Insp. Char</th>
                                    <th colspan=3>Result</th>
                                    <th rowspan=2>Keterangan</th>
                                    <th rowspan=2>Created On</th>
                                    <th rowspan=2>Created By</th>
                                </tr>
                                    <th>Awal</th>
                                    <th>Tengah</th>
                                    <th>Akhir</th>
                                </tr>
                            </thead>
                            <tbody>';
        while ($row = mysqli_fetch_array($sql)) {
            $output .= '
            
                                <tr>
                                    <td>' . $row['MIC'] . '</td>
                                    <td>' . checklist($row['Result_Awal']) . '</td>
                                    <td>' . checklist($row['Result_Tengah']) . '</td>
                                    <td>' . checklist($row['Result_Akhir']) . '</td>
                                    <td>' . $row['Ket_hasiltolak'] . '</td>
                                    <td>' . beautydate1($row['CreatedOn']) . '</td>
                                    <td>' . Getpernr($row['CreatedBy']) . ' - ' . Getnamakaryawan($row['CreatedBy']) . '</td>
                                </tr>';
        }
        $output .= '
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-end mt-5">
                            <button type="button" class="btn btn-outline-success btn-sm" onclick="changeorganoleptisdatapengolahan(1,3,' . $insplot . ',' . $inspyears . ')"><img src="../asset/icon/pencil.png"> Change</button>
                        </div>
                    </div>
                    ';
        $output .= ' 
                </div>
            </div>';
    }
    $sql = mysqli_query($conn, "SELECT * FROM result_recording WHERE Plant='$plant' AND
                                                                UnitCode='$unitcode' AND
                                                                InspectionLot='$insplot' AND
                                                                Lotyears='$inspyears' AND
                                                                NoProses=2 AND
                                                                StatsUpdate=''");
    if (mysqli_num_rows($sql) <> 0) {
        $output .= '
            <div class="card mb-3">
                <div class="border-0 mb-0 p-3 mt-3">
                <div class="form-group row mb-0">
                    <label for="parameter8persiapanhoper" class="col-sm-2 col-form-label">No Proses</label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control form-control-sm" value="2" readonly>
                    </div>
                </div>
                    <div class="form-group row mb-0">
                        <table class="table table-sm table-bordered">
                            <thead class="bg-dark text-white text-center" style="vertical-align: middle">
                                <tr>
                                    <th rowspan=2>Master of Insp. Char</th>
                                    <th colspan=3>Result</th>
                                    <th rowspan=2>Keterangan</th>
                                    <th rowspan=2>Created On</th>
                                    <th rowspan=2>Created By</th>
                                </tr>
                                    <th>Awal</th>
                                    <th>Tengah</th>
                                    <th>Akhir</th>
                                </tr>
                            </thead>
                            <tbody>';
        while ($row = mysqli_fetch_array($sql)) {
            $output .= '
            
                                <tr>
                                    <td>' . $row['MIC'] . '</td>
                                    <td>' . checklist($row['Result_Awal']) . '</td>
                                    <td>' . checklist($row['Result_Tengah']) . '</td>
                                    <td>' . checklist($row['Result_Akhir']) . '</td>
                                    <td>' . $row['Ket_hasiltolak'] . '</td>
                                    <td>' . beautydate1($row['CreatedOn']) . '</td>
                                    <td>' . Getpernr($row['CreatedBy']) . ' - ' . Getnamakaryawan($row['CreatedBy']) . '</td>
                                </tr>';
        }
        $output .= '
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-end mt-5">
                            <button type="button" class="btn btn-outline-success btn-sm" onclick="changeorganoleptisdatapengolahan(2,3,' . $insplot . ',' . $inspyears . ')"><img src="../asset/icon/pencil.png"> Change</button>
                        </div>
                    </div>
                    ';
        $output .= ' 
                </div>
            </div>';
    }
    $output .= '    
                </div>
                <div class="tab-pane fade" id="modalqualitydatapengolahanpills-3" role="tabpanel" aria-labelledby="pills-3-tab">
                        <!-- Usage Decision -->';
    $sql = mysqli_query($conn, "SELECT * FROM usage_decision WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    InspectionLot='$insplot' AND
                                                                    Lotyears='$inspyears'");
    if (mysqli_num_rows($sql) <> 0) {
        while ($row = mysqli_fetch_array($sql)) {
            $output .= '
            <div class="card mb-3">
                <div class="border-0 mb-0 p-3 mt-3">
                    <div class="form-group row mb-0">
                        <label for="parameter8persiapanhoper" class="col-sm-2 col-form-label">No Proses</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="' . $row['NoProses'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="inspetionlotterimabahan" class="col-sm-2 col-form-label">Inspection Lot</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="inspetionlotterimabahan" value="' . $insplot . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="inspyearsterimabahan" class="col-sm-2 col-form-label">Insp. Years</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="inspyearsterimabahan" value="' . $inspyears . '" readonly>
                        </div>
                    </div>  
                    <div class="form-group row mb-0 mt-3">
                        <div class="col-sm-8">
                            <table class="table table-sm table-bordered">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th>UD Code</th>
                                        <th>Descriptions</th>
                                        <th>UD Date</th>
                                        <th>UD By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>' . $row['UDcode'] . '</td>
                                        <td class="fw-bold">' . Getdata("Descriptions", "qc_catalog", "KodeCatalog", $row['UDcode']) . '</td>
                                        <td>' . beautydate1($row['CreatedOn']) . '</td>
                                        <td>' . Getpernr($row['CreatedBy'])  . ' - ' . Getnamakaryawan($row['CreatedBy']) . '</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-end mt-5">
                            <button type="button" class="btn btn-outline-success btn-sm" onclick="changeuddatapengolahan(' . $row["NoProses"] . ',2,' . $insplot . ',' . $inspyears . ')"><img src="../asset/icon/pencil.png"> Change</button>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }
    $output .= '         
            </div>
        </div>
    </div>';
    $return = true;
    $dump['output'] = $output;
    $dump['return'] = $return;
    echo json_encode($dump);
}

if (isset($_POST['proseschangepreparehoperdatapengolahan'])) {
    $return = base64_encode($_POST['proseschangepreparehoperdatapengolahan']);
    echo $return;
}
if (isset($_POST['proseschangeuddatapengolahan'])) {
    $return = base64_encode($_POST['proseschangeuddatapengolahan']);
    echo $return;
}
if (isset($_POST['proseschangeorganoleptisdatapengolahan'])) {
    $return = base64_encode($_POST['proseschangeorganoleptisdatapengolahan']);
    echo $return;
}
if (isset($_POST['prosesupdatechangeqcresultdatapengolahan'])) {
    $return = false;
    $planningnumber = $_POST['prosesupdatechangeqcresultdatapengolahan'][0];
    $years = $_POST['prosesupdatechangeqcresultdatapengolahan'][1];
    $noproses = $_POST['prosesupdatechangeqcresultdatapengolahan'][2];
    $bets = $_POST['prosesupdatechangeqcresultdatapengolahan'][3];
    $qc_name = $_POST['prosesupdatechangeqcresultdatapengolahan'][4];
    $suhu = $_POST['prosesupdatechangeqcresultdatapengolahan'][5];
    $productid = $_POST['prosesupdatechangeqcresultdatapengolahan'][6];
    $qc_name = explode(" ", $qc_name);
    $qc_name = $qc_name[0];
    $types = 'Pengolahan';
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];
    $lastupdate = date("Y-m-d H:i:s");
    $statsupdate = 1;
    $objectupdate = 'qc_result_pengolahan';

    $sql = mysqli_query($conn, "SELECT CreatedOn, CreatedBy FROM qc_result WHERE Plant='$plant' AND
                                                                                        UnitCode='$unitcode' AND
                                                                                        PlanningNumber='$planningnumber' AND
                                                                                        Years='$years' AND
                                                                                        BatchNumber='$bets' AND
                                                                                        NoProses='$noproses' AND
                                                                                        StatsUpdate=''");
    $r = mysqli_fetch_array($sql);
    $createdon = $r['CreatedOn'];
    $createdby = $r['CreatedBy'];

    $sql = mysqli_query($conn, "INSERT INTO qc_result (Plant,
                                                        UnitCode,
                                                        PlanningNumber,
                                                        Years,
                                                        Types,
                                                        BatchNumber,
                                                        NoProses,
                                                        LastUpdate,
                                                        Suhu,
                                                        StatsUpdate,
                                                        CreatedFor,
                                                        CreatedBy,
                                                        CreatedOn,
                                                        ChangedBy,
                                                        ChangedOn) 
                                VALUES('$plant',
                                        '$unitcode',
                                        '$planningnumber',
                                        '$years',
                                        '$types',
                                        '$bets',
                                        '$noproses',
                                        '$lastupdate',
                                        '$suhu',
                                        '$statsupdate',
                                        '$qc_name',
                                        '$createdby',
                                        '$createdon',
                                        '$changedby',
                                        '$changedon')");
    if ($sql === true) {
        // ------> Get Kode No Update
        $sql = mysqli_query($conn, "SELECT Current, Too FROM nriv WHERE NumberRangeType='noupdate' AND Years='$years' ORDER BY Current DESC");
        $q = mysqli_fetch_array($sql);
        if (mysqli_num_rows($sql) > 0) {
            $noupdate = $q['Current'] + 1;
            $maxkode = $q['Too'];
            // -----> Cek Overload Number
            if ($noupdate > $maxkode) {
                die;
            }
        } else {
            $sql = mysqli_query($conn, "SELECT Fromm FROM nriv WHERE NumberRangeType='noupdate'");
            $q = mysqli_fetch_array($sql);
            if (mysqli_num_rows($sql) > 0) {
                $noupdate = $q['Fromm'];
                mysqli_query($conn, "UPDATE nriv SET Current='$noupdate',Years='$years' WHERE NumberRangeType='noupdate'");
            }
            // die;
        }
        mysqli_query($conn, "UPDATE nriv SET Current='$noupdate' WHERE NumberRangeType='noupdate' AND Years='$years'");
        // ------> End
        $createdon = date("Y-m-d H:i:s");
        $createdby = $_SESSION['userid'];

        mysqli_query($conn, "INSERT INTO tbl_tempupdate (Plant,
                                                        UnitCode,
                                                        NoUpdate,
                                                        NoUpdateYears,
                                                        ObjectUpdate,
                                                        PlanningNumber,
                                                        Years,
                                                        NoProses,
                                                        ProductID,
                                                        BatchNumber,
                                                        CreatedOn,
                                                        CreatedBy)
                            VALUES('$plant',
                                    '$unitcode',
                                    '$noupdate',
                                    '$years',
                                    '$objectupdate',
                                    '$planningnumber',
                                    '$years',
                                    '$noproses',
                                    '$productid',
                                    '$bets',
                                    '$createdon',
                                    '$createdby')");

        $return = true;
    }
    echo $return;
}
if (isset($_POST['prosesupdatechangeudcodedatapengolahan'])) {
    $udcode = $_POST['prosesupdatechangeudcodedatapengolahan'];
    $return = false;
    $sql = mysqli_query($conn, "SELECT Descriptions FROM qc_catalog WHERE KodeCatalog='$udcode'");
    if (mysqli_num_rows($sql) <> 0) {
        $r = mysqli_fetch_array($sql);
        $return = $r['Descriptions'];
    }
    echo $return;
}
function noupdatetiket($jenis, $years)
{
    // ------> Get Kode No Update
    include 'koneksi.php';
    $sql = mysqli_query($conn, "SELECT Current, Too FROM nriv WHERE NumberRangeType='$jenis' AND Years='$years' ORDER BY Current DESC");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $noupdate = $q['Current'] + 1;
        $maxkode = $q['Too'];
        // -----> Cek Overload Number
        if ($noupdate > $maxkode) {
            die;
        }
    } else {
        $sql = mysqli_query($conn, "SELECT Fromm FROM nriv WHERE NumberRangeType='$jenis'");
        $q = mysqli_fetch_array($sql);
        if (mysqli_num_rows($sql) > 0) {
            $noupdate = $q['Fromm'];
            mysqli_query($conn, "UPDATE nriv SET Current='$noupdate',Years='$years' WHERE NumberRangeType='$jenis'");
        }
        // die;
    }
    mysqli_query($conn, "UPDATE nriv SET Current='$noupdate' WHERE NumberRangeType='$jenis' AND Years='$years'");
    // ------> End
    return $noupdate;
}
if (isset($_POST['prosesupdateorganoleptis'])) {
    $return = false;
    $insplot = $_POST['prosesupdateorganoleptis'][0];
    $inspyears = $_POST['prosesupdateorganoleptis'][1];
    $noproses = $_POST['prosesupdateorganoleptis'][2];
    $qc_name = $_POST['prosesupdateorganoleptis'][3];
    $r1 = $_POST['prosesupdateorganoleptis'][4];
    $r2 = $_POST['prosesupdateorganoleptis'][5];
    $r3 = $_POST['prosesupdateorganoleptis'][6];
    $lenght = $_POST['prosesupdateorganoleptis'][7];
    $mic = $_POST['prosesupdateorganoleptis'][8];
    $keterangan = $_POST['prosesupdateorganoleptis'][9];
    $planningnumber = $_POST['prosesupdateorganoleptis'][10];
    $years = $_POST['prosesupdateorganoleptis'][11];
    $productid = $_POST['prosesupdateorganoleptis'][12];
    $bets = $_POST['prosesupdateorganoleptis'][13];
    $qc_name = explode(" ", $qc_name);
    $qc_name = $qc_name[0];
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];
    $lastupdate = date("Y-m-d H:i:s");
    $statsupdate = 1;
    $objectupdate = 'result_recording';

    $sql = mysqli_query($conn, "SELECT CreatedOn, CreatedBy FROM result_recording WHERE Plant='$plant' AND
                                                                                        UnitCode='$unitcode' AND
                                                                                        InspectionLot ='$insplot' AND
                                                                                        Lotyears ='$inspyears' AND
                                                                                        NoProses='$noproses' AND
                                                                                        StatsUpdate=''");
    $r = mysqli_fetch_array($sql);
    $createdon = $r['CreatedOn'];
    $createdby = $r['CreatedBy'];
    for ($i = 1; $i < $lenght; $i++) {
        $sql = mysqli_query($conn, "INSERT INTO result_recording(Plant,
                                                                UnitCode,
                                                                InspectionLot,
                                                                Lotyears,
                                                                NoProses,
                                                                MIC,
                                                                LastUpdate,
                                                                Result_Awal,
                                                                Result_Tengah,
                                                                Result_Akhir,
                                                                Ket_hasiltolak,
                                                                StatsUpdate,
                                                                CreatedOn,
                                                                CreatedBy,
                                                                ChangedOn,
                                                                ChangedBy)
                                        VALUES('$plant',
                                                '$unitcode',
                                                '$insplot',
                                                '$inspyears',
                                                '$noproses',
                                                '$mic[$i]',
                                                '$lastupdate',
                                                '$r1[$i]',
                                                '$r2[$i]',
                                                '$r3[$i]',
                                                '$keterangan[$i]',
                                                '$statsupdate',
                                                '$createdon',
                                                '$createdby',
                                                '$changedon',
                                                '$changedby')");
    }
    if ($sql === true) {
        $noupdate = noupdatetiket('noupdate', $years);
        $createdon = date("Y-m-d H:i:s");
        $createdby = $_SESSION['userid'];
        mysqli_query($conn, "INSERT INTO tbl_tempupdate (Plant,
                                                        UnitCode,
                                                        NoUpdate,
                                                        NoUpdateYears,
                                                        ObjectUpdate,
                                                        PlanningNumber,
                                                        Years,
                                                        NoProses,
                                                        ProductID,
                                                        BatchNumber,
                                                        InspectionLot,
                                                        Lotyears,
                                                        CreatedOn,
                                                        CreatedBy)
                            VALUES('$plant',
                                    '$unitcode',
                                    '$noupdate',
                                    '$years',
                                    '$objectupdate',
                                    '$planningnumber',
                                    '$years',
                                    '$noproses',
                                    '$productid',
                                    '$bets',
                                    '$insplot',
                                    '$inspyears',
                                    '$createdon',
                                    '$createdby')");

        $return = true;
    }
    echo $return;
}
if (isset($_POST['prosesupdatepersiapanpengolahan'])) {
    $return = false;
    $types = 'Pengolahan';
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosesupdatepersiapanpengolahan'][0];
    $operator1 = $_POST['prosesupdatepersiapanpengolahan'][1];
    $operator2 = $_POST['prosesupdatepersiapanpengolahan'][2];
    $operator3 = $_POST['prosesupdatepersiapanpengolahan'][3];
    $var1 = $_POST['prosesupdatepersiapanpengolahan'][4];
    $var2 = $_POST['prosesupdatepersiapanpengolahan'][5];
    $var3 = $_POST['prosesupdatepersiapanpengolahan'][6];
    $var4 = $_POST['prosesupdatepersiapanpengolahan'][7];
    $var5 = $_POST['prosesupdatepersiapanpengolahan'][8];
    $var6 = $_POST['prosesupdatepersiapanpengolahan'][9];
    $var7 = $_POST['prosesupdatepersiapanpengolahan'][10];
    $var8 = $_POST['prosesupdatepersiapanpengolahan'][11];
    $var9 = $_POST['prosesupdatepersiapanpengolahan'][12];
    $var10 = $_POST['prosesupdatepersiapanpengolahan'][13];
    $pengawas = $_POST['prosesupdatepersiapanpengolahan'][14];
    $years = $_POST['prosesupdatepersiapanpengolahan'][15];
    $bets = $_POST['prosesupdatepersiapanpengolahan'][16];
    $noproses = $_POST['prosesupdatepersiapanpengolahan'][17];
    $productid = $_POST['prosesupdatepersiapanpengolahan'][18];
    // $bets = str_replace(': ', '', $bets);
    // $productid = str_replace(': ', '', $productid);
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];
    $lastupdate = date("Y-m-d H:i:s");
    $statsupdate = 1;

    $objectupdate = 'proses_prepare_mixer';

    $sql = mysqli_query($conn, "SELECT CreatedOn, CreatedBy FROM proses_prepare_mixer WHERE Plant='$plant' AND
                                                                                        UnitCode='$unitcode' AND
                                                                                        PlanningNumber='$planningnumber' AND
                                                                                        Years='$years' AND
                                                                                        ProductID='$productid' AND
                                                                                        BatchNumber='$bets' AND
                                                                                        NoProses='$noproses' AND
                                                                                        StatsUpdate=''");
    $r = mysqli_fetch_array($sql);
    $createdon = $r['CreatedOn'];
    $createdby = $r['CreatedBy'];
    $sql = mysqli_query($conn, "INSERT INTO proses_prepare_mixer (Plant,UnitCode,PlanningNumber,Years,ProductID,BatchNumber,NoProses,LastUpdate,
                                                                Operator1,Operator2,Operator3,PengawasProduksi,
                                                                Parameter_1,
                                                                Parameter_2,
                                                                Parameter_3,
                                                                Parameter_4,
                                                                Parameter_5,
                                                                Parameter_6,
                                                                Parameter_7,
                                                                Parameter_8,
                                                                Parameter_9,
                                                                Parameter_10,
                                                                StatsUpdate,
                                                                CreatedBy,
                                                                CreatedOn,
                                                                ChangedBy,
                                                                ChangedOn) VALUES('$plant','$unitcode','$planningnumber','$years','$productid',
                                                                '$bets','$noproses','$lastupdate','$operator1','$operator2','$operator3','$pengawas'
                                                                ,'$var1','$var2','$var3','$var4','$var5',
                                                                '$var6','$var7','$var8','$var9','$var10','$statsupdate','$createdby','$createdon','$changedby','$changedon')");
    if ($sql === true) {
        // ------> Get Kode No Update
        $sql = mysqli_query($conn, "SELECT Current, Too FROM nriv WHERE NumberRangeType='noupdate' AND Years='$years' ORDER BY Current DESC");
        $q = mysqli_fetch_array($sql);
        if (mysqli_num_rows($sql) > 0) {
            $noupdate = $q['Current'] + 1;
            $maxkode = $q['Too'];
            // -----> Cek Overload Number
            if ($noupdate > $maxkode) {
                die;
            }
        } else {
            $sql = mysqli_query($conn, "SELECT Fromm FROM nriv WHERE NumberRangeType='noupdate'");
            $q = mysqli_fetch_array($sql);
            if (mysqli_num_rows($sql) > 0) {
                $noupdate = $q['Fromm'];
                mysqli_query($conn, "UPDATE nriv SET Current='$noupdate',Years='$years' WHERE NumberRangeType='noupdate'");
            }
            // die;
        }
        mysqli_query($conn, "UPDATE nriv SET Current='$noupdate' WHERE NumberRangeType='noupdate' AND Years='$years'");
        // ------> End
        $createdon = date("Y-m-d H:i:s");
        $createdby = $_SESSION['userid'];
        mysqli_query($conn, "INSERT INTO tbl_tempupdate (Plant,
                                                        UnitCode,
                                                        NoUpdate,
                                                        NoUpdateYears,
                                                        ObjectUpdate,
                                                        PlanningNumber,
                                                        Years,
                                                        NoProses,
                                                        ProductID,
                                                        BatchNumber,
                                                        CreatedOn,
                                                        CreatedBy)
                            VALUES('$plant',
                                    '$unitcode',
                                    '$noupdate',
                                    '$years',
                                    '$objectupdate',
                                    '$planningnumber',
                                    '$years',
                                    '$noproses',
                                    '$productid',
                                    '$bets',
                                    '$createdon',
                                    '$createdby')");

        $return = true;
    }
    echo $return;
}


// ---------------------------------------------------------
// Change/Display Planning 'PENGEMASAN'
// ---------------------------------------------------------
if (isset($_POST['prosesdisplayplanningpengemasan'])) {
    $dump[] = '';
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosesdisplayplanningpengemasan'][0];
    $years = $_POST['prosesdisplayplanningpengemasan'][1];
    $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber = '$planningnumber' AND
                                                                        Years='$years'");
    $output = '          
                <table class="table table-sm mt-3 w-100" id="dcreateplanning">
                    <thead class="bg-dark text-white">
                        <tr>
                            <td>#</td>
                            <td>Hari, Tanggal</td>
                            <td style="width: 50%;">Produk</td>
                            <td>Mesin</td>
                            <td>Qty</td>
                            <td>ED/BC</td>
                        </tr>
                    </thead>
                    <tbody>';
    $i = 1;
    while ($r = mysqli_fetch_array($sql)) {
        $batch_show = explode(',', $r['*']);
        $productid = $r['ProductID'];
        $query = mysqli_query($conn, "SELECT ProductDescriptions FROM mara_product WHERE ProductID='$r[ProductID]'");
        $q = mysqli_fetch_array($query);
        $output .=              '<tr>
                                        <td>' . $i . '</a></td>
                                        <td>' . getdayformat2(date('w', strtotime($r['CreatedOn']))) . ', ' . date('d/m/Y', strtotime($r['CreatedOn'])) . '</td>
                                        <td>' . $q['ProductDescriptions'] . '</td>
                                        <td>' . $r['ResourceIDMix'] . '</td>
                                        <td>' . $r['Quantity'] . ' ' . $r['UnitOfMeasures'] . '</td>
                                        <td>' . 'ED. ' . date('M Y', strtotime($r['ExpiredDate'])) . '/' . $r['BatchNumber'] . '</td>
                                    </tr>';
        $i++;
    }
    $output .= '
                    </tbody>
                            </table>';
    $dump['planningnumber'] = $planningnumber;
    $dump['years'] = $years;
    $dump['productid'] = $productid;
    $query = mysqli_query($conn, "SELECT CreatedFor,CreatedOn,CreatedBy,ShiftID,PackingDate,MixingDate FROM planning_prod_header WHERE Plant='$plant' AND
                                                                                                UnitCode='$unitcode' AND
                                                                                                PlanningNumber = '$planningnumber' AND
                                                                                                Years='$years'");
    $q = mysqli_fetch_array($query);
    $dump['createdon'] = $q['CreatedOn'];
    $dump['createdby'] = $q['CreatedBy'];
    $dump['shift'] = $q['ShiftID'];
    $dump['packingdate'] = $q['PackingDate'];
    $dump['mixingdate'] = $q['MixingDate'];
    $query = mysqli_query($conn, "SELECT EmployeeName,PersonnelNumber FROM pa001 WHERE PersonnelNumber ='$q[CreatedFor]'");
    $q = mysqli_fetch_array($query);
    $dump['createdfor'] = $q['PersonnelNumber'] . ' - ' . $q['EmployeeName'];
    // Approval
    $sql = mysqli_query($conn, "SELECT * FROM tb_approval_viewer WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            ProcessType ='create_planning' AND
                                                                                            PlanningNumber = '$planningnumber' AND
                                                                                            Years='$years' ORDER BY Levels ASC");
    $output .= '
                <h6 class="mt-5 fw-bold">Reviewer</h6>          
                <table class="table table-sm w-50" id="dcreateplanning">
                    <thead class="bg-dark text-white">
                        <tr>
                            <td style="width: 5%;">No</td>
                            <td style="width: 30%;">Approval</td>
                            <td>Jabatan</td>
                            <td>Status</td>
                            <td>Tgl Approval</td>
                            <td>Catatan</td>
                        </tr>
                    </thead>
                    <tbody>';
    $i = 1;
    while ($r = mysqli_fetch_array($sql)) {
        $query = mysqli_query($conn, "SELECT EmployeeName,PositionID FROM pa001 WHERE PersonnelNumber =' $r[PersonnelNumber]'");
        $q = mysqli_fetch_array($query);
        $status = '<label class="text-danger fw-bold">Belum disetujui</label>';
        $approvaldate = '-';
        if ($r['StatusApproval'] != null || $r['StatusApproval'] != '') {
            $status = '<label class="text-success fw-bold">Disetujui</label>';
            $approvaldate = $r['ChangedOn'];
        }

        $output .=              '<tr>
                                        <td>' . $r['Levels'] . '</td>
                                        <td>' . $r['PersonnelNumber'] . ' - ' . $q['EmployeeName'] . '</td>
                                        <td>' . $q['PositionID'] . '</td>
                                        <td>' . $status . '</td>
                                        <td>' . $approvaldate . '</td>
                                        <td>' . $r['Catatan'] . '</td>
                                    </tr>';
        $i++;
    }
    $output .= '
                    </tbody>
                            </table>';
    $dump['status'] = true;
    $dump['output'] = $output;
    echo json_encode($dump);
}
if (isset($_POST['prosesdisplayhoperdatapengemasan'])) {
    $dump[] = '';
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosesdisplayhoperdatapengemasan'][0];
    $years = $_POST['prosesdisplayhoperdatapengemasan'][1];
    $return = false;
    $output = '
    <div class="card">
                <div class="border-0 mb-0 p-3">
                    <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark active" id="modalpills-1-tab" data-bs-toggle="pill" data-bs-target="#modalhoperpills-1" type="button" role="tab" aria-controls="pills-1" aria-selected="true">Prepare Hoper</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark" id="modalpills-2-tab" data-bs-toggle="pill" data-bs-target="#modalhoperpills-2" type="button" role="tab" aria-controls="pills-2" aria-selected="false">Proses Hoper</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="tabs-tabContent">
                        <div class="tab-pane fade show active" id="modalhoperpills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                               <!-- Prepare Hoper -->';
    $sql = mysqli_query($conn, "SELECT * FROM proses_prepare WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    PlanningNumber='$planningnumber' AND 
                                                                    Years='$years' AND 
                                                                    Types='Hoper'");
    $row = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) != 0) {
        $output .= '
            <div class="card">
                <div class="border-0 mb-0 p-3 mt-3">
                    <div class="form-group row mb-0">
                        <label for="operator1displaydata" class="col-sm-2 offset-8 col-form-label">Operator 1</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Operator1'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="operator2displaydata" class="col-sm-2 offset-8 col-form-label">Operator 2</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Operator2'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="changedbydisplayplanning" class="col-sm-2 offset-8">Pengawas Produksi</label>
                        <div class="col-sm-2">
                            <input type="text" value="' . $row['PengawasProduksi'] . '" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <h6 class="fw-bold">Input Parameter</h6>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter1displaydata" class="col-sm-8 col-form-label">1. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 1) . '</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_1'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter2displaydata" class="col-sm-8 col-form-label">2. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 2) . '</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_2'] . '" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="°C" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter2suhupersiapanhoper" class="col-sm-8 ps-4 col-form-label">' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 21) . '</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_2_1'] . '" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="%" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter3persiapanhoper" class="col-sm-8 col-form-label">3. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 3) . '</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_3'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter4persiapanhoper" class="col-sm-8 col-form-label">4. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 4) . '</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_4'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter5persiapanhoper" class="col-sm-8 col-form-label">5. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 5) . '</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_5'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-sm-12 px-5">
                            <table>
                                <!-- <tr>
                                    <td>- ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 51) . ' </th>
                                    <td><input type="text" class="form-control form-control-sm" id="parameter5_1persiapanhoper" readonly></td>
                                </tr> -->
                                <tr>
                                    <td>- ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 52) . '</td>
                                    <td><input type="text" class="form-control form-control-sm" value="' . $row['Sub_parameter_5_2'] . '" readonly></td>
                                </tr>
                                <tr>
                                    <td>- ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 53) . '</td>
                                    <td><input type="text" class="form-control form-control-sm" value="' . $row['Sub_parameter_5_3'] . '" readonly></td>
                                </tr>
                                <tr>
                                    <td>- ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 54) . '</td>
                                    <td><input type="text" class="form-control form-control-sm" value="' . $row['Sub_parameter_5_4'] . '" readonly></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter6persiapanhoper" class="col-sm-8 col-form-label">6. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 6) . '</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_6'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="parameter7persiapanhoper" class="col-sm-8 col-form-label">7. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 7) . '</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_7'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="parameter8persiapanhoper" class="col-sm-8 col-form-label">8. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 8) . '</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_8'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-end mt-5">
                            <button type="button" class="btn btn-outline-success btn-sm" onclick="changepreparehoperdatapengemasan()"><img src="../asset/icon/pencil.png"> Change</button>
                        </div>
                    </div>
                </div>
            </div>';
    }
    $output .= '                    
                    </div>
                        <div class="tab-pane fade show" id="modalhoperpills-2" role="tabpanel" aria-labelledby="pills-2-tab">
                                <!-- Proses Hopper -->';
    $output .= '
                                <div class="card">
                                            <div class="border-0 mb-0 mt-3 p-3">
                                                <table class="table table-sm">
                                                    <thead class="bg-dark text-white">
                                                        <tr>
                                                            <th>Proses Number</th>
                                                            <th>No Tong</th>
                                                            <th>Waktu</th>
                                                            <th>Qty</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>';

    $sql = mysqli_query($conn, "SELECT * FROM transaksi_hoper WHERE Plant='$plant' AND
                                                                                                UnitCode='$unitcode' AND
                                                                                                PlanningNumber='$planningnumber' AND
                                                                                                Years='$years'");
    if (mysqli_num_rows($sql) != 0) {
        $return = true;
        while ($row = mysqli_fetch_array($sql)) {
            $output .= '
                                                            <tr>
                                                                <td>' . $row["ProcessNumber"] . '</td>
                                                                <td>' . $row["ContainerNumber"] . '</td>
                                                                <td>' . $row["TimeExecuted"] . '</td>
                                                                <td>' . $row["Quantity"] . '</td>
                                                            </tr>';
        }
    }
    $output .= '
                                                    </tbody>
                                                </table>
                                                <div class="form-group row">
                                                    <div class="col-sm-12 text-end mt-5">
                                                        <button type="button" class="btn btn-outline-success btn-sm" onclick="changeproseshoperdatapengemasan()"><img src="../asset/icon/pencil.png"> Change</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
    $output .= '
                                        </div>
                    </div>    
                </div>
            </div>';
    $return = true;
    $dump['output'] = $output;
    $dump['return'] = $return;
    echo json_encode($dump);
}
if (isset($_POST['prosesdisplaytopackdatapengemasan'])) {
    $dump[] = '';
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosesdisplaytopackdatapengemasan'][0];
    $years = $_POST['prosesdisplaytopackdatapengemasan'][1];
    $return = false;
    $output = '
            <div class="card">
                <div class="border-0 mb-0 p-3">
                    <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark active" id="modalpills-1-tab" data-bs-toggle="pill" data-bs-target="#modaltopackpills-1" type="button" role="tab" aria-controls="pills-1" aria-selected="true">Prepare Topack</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark" id="modalpills-2-tab" data-bs-toggle="pill" data-bs-target="#modaltopackpills-2" type="button" role="tab" aria-controls="pills-2" aria-selected="false">Engine Set</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark" id="modalpills-3-tab" data-bs-toggle="pill" data-bs-target="#modaltopackpills-3" type="button" role="tab" aria-controls="pills-3" aria-selected="false">Production Sampling</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark" id="modalpills-4-tab" data-bs-toggle="pill" data-bs-target="#modaltopackpills-4" type="button" role="tab" aria-controls="pills-4" aria-selected="false">Rekonsiliasi Topack</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark" id="modalpills-5-tab" data-bs-toggle="pill" data-bs-target="#modaltopackpills-5" type="button" role="tab" aria-controls="pills-5" aria-selected="false">Downtime Topackk</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="tabs-tabContent">
                        <div class="tab-pane fade show active" id="modaltopackpills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                               <!-- Prepare Topack -->';
    $sql = mysqli_query($conn, "SELECT * FROM proses_prepare WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    PlanningNumber='$planningnumber' AND 
                                                                    Years='$years' AND 
                                                                    Types='Topack'");
    $row = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) != 0) {
        $output .= '
                    <div class="card">
                        <div class="border-0 mb-0 p-3">
                            <div class="form-group row mb-0">
                                <label for="operator1displaydata" class="col-sm-2 offset-8 col-form-label">Operator 1</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control form-control-sm" value="' . $row['Operator1'] . '" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="operator2displaydata" class="col-sm-2 offset-8 col-form-label">Operator 2</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control form-control-sm" value="' . $row['Operator2'] . '" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="changedbydisplayplanning" class="col-sm-2 offset-8">Pengawas Produksi</label>
                                <div class="col-sm-2">
                                    <input type="text" value="' . $row['PengawasProduksi'] . '" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <h6 class="fw-bold">Input Parameter</h6>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="parameter1displaydata" class="col-sm-8 col-form-label">1. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 1) . '</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_1'] . '" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="parameter2displaydata" class="col-sm-8 col-form-label">2. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 2) . '</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_2'] . '" readonly>
                                </div>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control form-control-sm" value="°C" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="parameter2suhupersiapanhoper" class="col-sm-8 ps-4 col-form-label">' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 21) . '</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_2_1'] . '" readonly>
                                </div>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control form-control-sm" value="%" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="parameter3persiapanhoper" class="col-sm-8 col-form-label">3. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 3) . '</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_3'] . '" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="parameter4persiapanhoper" class="col-sm-8 col-form-label">4. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 4) . '</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_4'] . '" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="parameter5persiapanhoper" class="col-sm-8 col-form-label">5. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 5) . '</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_5'] . '" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-sm-12 px-5">
                                    <table>
                                        <!-- <tr>
                                            <td>- ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 51) . ' </th>
                                            <td><input type="text" class="form-control form-control-sm" id="parameter5_1persiapanhoper" readonly></td>
                                        </tr> -->
                                        <tr>
                                            <td>- ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 52) . '</td>
                                            <td><input type="text" class="form-control form-control-sm" value="' . $row['Sub_parameter_5_2'] . '" readonly></td>
                                        </tr>
                                        <tr>
                                            <td>- ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 53) . '</td>
                                            <td><input type="text" class="form-control form-control-sm" value="' . $row['Sub_parameter_5_3'] . '" readonly></td>
                                        </tr>
                                        <tr>
                                            <td>- ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 54) . '</td>
                                            <td><input type="text" class="form-control form-control-sm" value="' . $row['Sub_parameter_5_4'] . '" readonly></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="parameter6persiapanhoper" class="col-sm-8 col-form-label">6. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 6) . '</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_6'] . '" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="parameter7persiapanhoper" class="col-sm-8 col-form-label">7. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 7) . '</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_7'] . '" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="parameter8persiapanhoper" class="col-sm-8 col-form-label">8. ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 8) . '</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control form-control-sm" value="' . $row['Parameter_8'] . '" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 text-end mt-5">
                                    <button type="button" class="btn btn-outline-success btn-sm" onclick="changepreparetopackdatapengemasan()"><img src="../asset/icon/pencil.png"> Change</button>
                                </div>
                            </div>
                        </div>
                    </div>
        ';
    }
    $output .= '
                        </div>
                        <div class="tab-pane fade show" id="modaltopackpills-2" role="tabpanel" aria-labelledby="pills-2-tab">
                               <!-- Engine Set -->
                               <section class="mb-3">';
    $i = 0;
    $sql = mysqli_query($conn, "SELECT * FROM qc_characteristic WHERE KodeProses LIKE '%ES%'");
    if (mysqli_num_rows($sql) > 0) {
        while ($r = mysqli_fetch_array($sql)) {
            $output .= '
                                                                                <div class="form-group row mb-1">
                                                                                    <div class="col-sm-4">
                                                                                        <input type="text" class="form-control form-control-sm border-0 bg-transparent" id="jenispengecekanengineset' . $i . '" value="' . $r['Proses'] . '" readonly>
                                                                                    </div>
                                                                                    <div class="col-sm-1">
                                                                                        <input type="text" value="' . showdataIII("NilaiSuhu", "machine_engine", "PlanningNumber", $planningnumber, "JenisTransaksi", "Topack", "JenisPengecekan", $r['Proses']) . '" class="form-control form-control-sm" id="suhu' . $i . '" disabled>
                                                                                    </div>
                                                                                    <div class="col-sm-2">
                                                                                        <input type="text" class="form-control form-control-sm bg-transparent border-0" value="Spec: ' . $r['Nilai'] . ' ' . $r['UnitOfMeasures'] . '" readonly>
                                                                                    </div>
                                                                                </div>';
            $i++;
        }
    }
    $output .= '
                                </section>
                                <section class="mb-3">';
    $idno = 1;
    $sql = mysqli_query($conn, "SELECT * FROM text_sys WHERE JenisProses='engineset'");
    if (mysqli_num_rows($sql) > 0) {
        while ($r = mysqli_fetch_array($sql)) {
            $output .= '
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input" type="checkbox" id="textengineset' . $idno . '" checked disabled>
                                                                                    <label class="form-check-label" for="textengineset' . $idno . '">' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'engineset', 'Item', $idno) . '</label>
                                                                                </div>';
            $idno++;
        }
    }
    $output .= '
                                </section>
                    </div>
                    <div class="tab-pane fade show" id="modaltopackpills-3" role="tabpanel" aria-labelledby="pills-3-tab">
                               <!-- Production Sampling -->';
    $output .= '
                               <table class="table table-sm">
                               <thead class="bg-dark text-white">
                                   <tr>
                                       <th>Item</th>
                                       <th>Jam Timbang</th>
                                       <th>Qty</th>
                                       <th>Uom</th>
                                       <th>Bobot Timbang</th>
                                   </tr>
                               </thead>
                               <tbody>';
    $return = true;
    $sql = mysqli_query($conn, "SELECT * FROM sampling_transaksi_topack WHERE Plant='$plant' AND UnitCode='$unitcode' AND
                                                                                        PlanningNumber='$planningnumber' AND
                                                                                       Years='$years'");
    while ($row = mysqli_fetch_array($sql)) {
        $output .= '
                                       <tr>
                                           <td>' . $row['Item'] . '</td>
                                           <td>' . $row['JamTimbang'] . '</td>
                                           <td>' . $row['Qty'] . '</td>
                                           <td>' . $row['Uom'] . '</td>
                                           <td>' . $row['BobotTimbang'] . '</td>
                                       </tr>';
    }
    $output .= '
                               </tbody>
                           </table>
                    </div>
                    <div class="tab-pane fade show" id="modaltopackpills-4" role="tabpanel" aria-labelledby="pills-4-tab">
                               <!-- Rekon Topack -->';
    $sql = mysqli_query($conn, "SELECT * FROM transaksi_topack WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND
                                                                        Years='$years'");
    if (mysqli_num_rows($sql) != 0) {
        $return = true;
        $row = mysqli_fetch_array($sql);
        $output .= '
            <div class="card">
                <div class="border-0 mb-0 p-3 mt-3">
                    <div class="form-group row mb-0">
                        <label for="jammulaiprosestopack" class="col-sm-2 col-form-label">Jam Mulai</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Starttimes'] . '" readonly>
                        </div>
                        <label for="jamselesaiprosestopack" class="col-sm-2 col-form-label">Jam Selesai</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Endtimes'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="countermesinprosestopack" class="col-sm-2 col-form-label">Counter Mesin</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="' . $row['CounterMesin'] . '" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="counterprinterprosestopack" class="col-sm-2 col-form-label">Counter Printer</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control form-control-sm" value="' . $row['CounterPrinter'] . '" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="lithoterpakaiprosestopack" class="col-sm-2 col-form-label">Jumlah Kemasan Terpakai</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="' . $row['UsedListho'] . '" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Roll" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="rusakprosestopack" class="col-sm-2 col-form-label">Hasil SCH Rusak</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="' . $row['rejectedsch'] . '" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="rusakprosestopack" class="col-sm-2 col-form-label">Sampling</label>
                        <div class="col-sm-2" id="showiconsampling">
                            <!-- <input type="text" class="form-control form-control-sm" id="rusakprosestopack" value="0" readonly> -->
                            <!-- <img src="../asset/icon/no.png"> -->
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="rusakprosestopack" class="col-sm-2 col-form-label">Sampel Tes Kebocoran</label>
                        <div class="col-sm-2">
                            <input type="number" min="0" value="0" class="form-control form-control-sm" value="' . $row['SampleKebocoran'] . '" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="rusakprosestopack" class="col-sm-2 col-form-label">Retained Sample</label>
                        <div class="col-sm-2">
                            <input type="number" min="0" value="0" class="form-control form-control-sm" value="' . $row['RetainedSample'] . '" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row mb-0">
                        <label for="hasilteoritisrekontopack" class="col-sm-2 col-form-label">Hasil Teoritis</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="' . $row['HasilTeoritis'] . '" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="hasilnyatarekontopack" class="col-sm-2 col-form-label">Hasil Nyata</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" value="' . $row['HasilNyata'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="presentaserekontopack" class="col-sm-2 col-form-label">Presentase</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" value="' . $row['Persentase'] . '" readonly>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-sm" id="uom1rekontopack" value="%" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-end mt-5">
                            <button type="button" class="btn btn-outline-success btn-sm" onclick="changerekontopackdatapengemasan()"><img src="../asset/icon/pencil.png"> Change</button>
                        </div>
                    </div>
                </div>
            </div>';
    }
    $output .= '
                    </div>
                    <div class="tab-pane fade show" id="modaltopackpills-5" role="tabpanel" aria-labelledby="pills-5-tab">
                               <!-- Downtime Topack -->';
    $output .= '
                               <table class="table table-sm">
                               <thead class="bg-dark text-white">
                                   <tr>
                                        <th>Item</th>
                                        <th>Jam</th>
                                        <th>Permasalahan</th>
                                        <th>Tindakan</th>
                                        <th>Hasil</th>
                                        <th>Created On</th>
                                   </tr>
                               </thead>
                               <tbody>';
    $return = true;
    $sql = mysqli_query($conn, "SELECT * FROM downtime_rekon WHERE Plant='$plant' AND UnitCode='$unitcode' AND
                                                                                        PlanningNumber='$planningnumber' AND
                                                                                       Years='$years' AND
                                                                                       Prosestrx='topack'");
    while ($row = mysqli_fetch_array($sql)) {
        $output .= '
                                       <tr>
                                           <td>' . $row['Item'] . '</td>
                                           <td>' . $row['LamaDowntime'] . '</td>
                                           <td>' . $row['Permasalahan'] . '</td>
                                           <td>' . $row['Tindakan'] . '</td>
                                           <td>' . $row['Hasil'] . '</td>
                                           <td>' . $row['CreatedOn'] . '</td>
                                       </tr>';
    }
    $output .= '
                               </tbody>
                           </table>
                           <div class="form-group row">
                                <div class="col-sm-12 text-end mt-5">
                                    <button type="button" class="btn btn-outline-success btn-sm" onclick="changedowntimetopackdatapengemasan()"><img src="../asset/icon/pencil.png"> Change</button>
                                </div>
                            </div>
                    </div>                    
                </div>
            </div>    
        </div>';
    $return = true;
    $dump['output'] = $output;
    $dump['return'] = $return;
    echo json_encode($dump);
}
if (isset($_POST['prosesdisplaypillowdatapengemasan'])) {
    $dump[] = '';
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosesdisplaypillowdatapengemasan'][0];
    $years = $_POST['prosesdisplaypillowdatapengemasan'][1];
    $return = false;

    $output = '
    <div class="card">
                <div class="border-0 mb-0 p-3">
                    <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark active" id="modalpills-1-tab" data-bs-toggle="pill" data-bs-target="#modalpillowpills-1" type="button" role="tab" aria-controls="pills-1" aria-selected="true">Prepare Pillow</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark" id="modalpills-2-tab" data-bs-toggle="pill" data-bs-target="#modalpillowpills-2" type="button" role="tab" aria-controls="pills-2" aria-selected="false">Proses Pillow</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark" id="modalpills-3-tab" data-bs-toggle="pill" data-bs-target="#modalpillowpills-3" type="button" role="tab" aria-controls="pills-3" aria-selected="false">Rekonsiliasi Pillow</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark" id="modalpills-4-tab" data-bs-toggle="pill" data-bs-target="#modalpillowpills-4" type="button" role="tab" aria-controls="pills-4" aria-selected="false">Downtime Topackk</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="tabs-tabContent">
                        <div class="tab-pane fade show active" id="modalpillowpills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                               <!-- Prepare Pillow -->';
    $sql = mysqli_query($conn, "SELECT * FROM proses_prepare_pillow WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND
                                                                        Years='$years'");
    if (mysqli_num_rows($sql) != 0) {
        $row = mysqli_fetch_array($sql);
        $output .= '
                            <div class="card">
                                <div class="border-0 mb-0 p-3 mt-3">
                                    <div class="form-group row mb-0">
                                        <label for="personalnumberemployee" class="col-sm-2 col-form-label">Operator 1</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control form-control-sm" value="' . $row['FirstOperator'] . '" readonly>
                                        </div>
                                        <label for="personalnumberemployee" class="col-sm-2 offset-4 col-form-label">Operator 4</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control form-control-sm" value="' . $row['FourOperator'] . '" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="personalnumberemployee" class="col-sm-2 col-form-label">Operator 2</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control form-control-sm" value="' . $row['SecondOperator'] . '" readonly>
                                        </div>
                                        <label for="personalnumberemployee" class="col-sm-2 offset-4 col-form-label">Operator 5</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control form-control-sm" value="' . $row['FiveOperator'] . '" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="personalnumberemployee" class="col-sm-2 col-form-label">Operator 3</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control form-control-sm" value="' . $row['ThreeOperator'] . '" readonly>
                                        </div>
                                        <label for="personalnumberemployee" class="col-sm-2 offset-4 col-form-label">Operator 6</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control form-control-sm" value="' . $row['SixOperator'] . '" readonly>
                                        </div>

                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="changedbydisplayplanning" class="col-sm-2 offset-8">Pengawas Produksi</label>
                                        <div class="col-sm-2">
                                            <input type="text" value="' . $row['PengawasProduksi'] . '" class="form-control form-control-sm" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <h6 class="fw-bold">Uraian Pemeriksaan</h6>
                                        <hr class="width-50">
                                    </div>
                                    <section class="mb-3">';
        $idno = 1;
        $sql = mysqli_query($conn, "SELECT * FROM text_sys WHERE JenisProses='pillowpack' AND Item != 31 AND Item !=32");
        if (mysqli_num_rows($sql) > 0) {
            while ($r = mysqli_fetch_array($sql)) {
                if ($r['Item'] == 4) {
                    $output .= '
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="textpillowpack' . $idno . '" checked disabled>
                                        <label class="form-check-label" for="textpillowpack' . $idno . '">' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', $idno) . '</label>
                                        <div class="form-group row mb-1">
                                            <div class="col-sm-2">
                                                <input class="form-control border-0 bg-transparent" type="text" id="duspersiapanpillow" value="Dus">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control form-control-sm" id="qtyduspreparepillow" value="' . $row['Qty_1'] . '" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <input class="form-control border-0 bg-transparent" type="text" id="hangerpersiapanpillow" value="Hanger">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control form-control-sm" id="qtyhangerpersiapanpillow" value="' . $row['Qty_3'] . '" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <input class="form-control border-0 bg-transparent" type="text" id="boxpersiapanpillow" value="Box">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control form-control-sm" id="qtyboxpersiapanpillow" value="' . $row['Qty_5'] . '" readonly>
                                            </div>

                                        </div>
                                        <div class="form-group row mb-1">
                                            <div class="col-sm-2">
                                                <input class="form-control border-0 bg-transparent" type="text" id="brosurpersiapanpillow" value="Brosur">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control form-control-sm" id="qtybrosurpersiapanpillow" value="' . $row['Qty_2'] . '" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <input class="form-control border-0 bg-transparent" type="text" id="stikerpersiapanpillow" value="Stiker">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control form-control-sm" id="qtystikerpersiapanpillow" value="' . $row['Qty_4'] . '" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <input class="form-control border-0 bg-transparent" type="text" id="plastikpersiapanpillow" value="Plastik">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control form-control-sm" id="qtyplastikpersiapanpillow" value="' . $row['Qty_6'] . '" readonly>
                                            </div>
                                        </div>
                                    </div>';
                } elseif ($r['Item'] == 3) {
                    $output .= '
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="textpillowpack' . $idno . '" checked disabled>
                                        <label class="form-check-label" for="textpillowpack' . $idno . '">' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', $idno) . '</label>
                                        <table>
                                            <tr>
                                                <td style="color: gray;">- ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', 31) . '</td>
                                            </tr>
                                            <tr>
                                                <td style="color: gray;">- ' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', 32) . '</td>
                                            </tr>
                                        </table>
                                    </div>';
                } else {
                    $output .= '
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="textpillowpack' . $idno . '" checked disabled>
                                        <label class="form-check-label" for="textpillowpack' . $idno . '">' . showdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', $idno) . ' </label>
                                    </div>';
                }
                $idno++;
            }
        }
    }
    $output .= '
                                    </section>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="modalpillowpills-2" role="tabpanel" aria-labelledby="pills-2-tab">
                               <!-- Proses Pillow -->';
    $sql = mysqli_query($conn, "SELECT * FROM transaksi_pillow WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND
                                                                        Years='$years'");
    if (mysqli_num_rows($sql) != 0) {
        $return = true;
        $row = mysqli_fetch_array($sql);
        $output .= '
                            <div class="card">
                                <div class="border-0 mb-0 p-3 mt-3">
                                    <div class="form-group row mb-0">
                                        <label for="rentengprosespillow" class="col-sm-1 col-form-label fw-bold">Renteng</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control form-control-sm" value="' . $row['TypeRenteng'] . '" readonly>
                                        </div>
                                    </div>
                                    <hr class="width-50">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="text1prosespillowpack" checked disabled>
                                        <label class="form-check-label" for="text1prosespillowpack">1. Masukan setiap renteng kedalam plastik</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="text2prosespillowpack" checked disabled>
                                        <label class="form-check-label" for="text2prosespillowpack">2. Masukan setiap
                                            <input type="text" value="' . $row['QtyPlastik'] . '" id="qtypastikprosespillow" readonly> plastik pada poin 1 ke dalam box dengan carton sealer</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="text3prosespillowpack" checked disabled>
                                        <label class="form-check-label" for="text3prosespillowpack">3. Timbang tiap box dan cetak spesifikasi pada box</label>
                                        <table>
                                            <td style="color: grey;">(Kode Produk, Tanggal Kemas, Shift, Jam, Kode Operator, ED, Nomor Line, Nomor urut kemas bobot)</td>
                                        </table>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 text-end mt-5">
                                            <button type="button" class="btn btn-outline-success btn-sm" onclick="changepreparepillowdatapengemasan()"><img src="../asset/icon/pencil.png"> Change</button>
                                        </div>
                                    </div>
                                </div>
                            </div>';
    }
    $output .= '        </div>
                        <div class="tab-pane fade show" id="modalpillowpills-3" role="tabpanel" aria-labelledby="pills-3-tab">
                               <!-- Rekon Pillow Pillow -->';
    $sql = mysqli_query($conn, "SELECT * FROM transaksi_rekon_pillow WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years'");
    // if (mysqli_num_rows($sql) != 0) {
    $row = mysqli_fetch_array($sql);
    $output .= '
                            <div class="card">
                                <div class="border-0 mb-0 p-3 mt-3">
                                    <div class="form-group row mb-0">
                                        <label for="hasilpengemasanrekonsiliasipillow" class="col-sm-2 col-form-label">Hasil Pengemasan</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control form-control-sm" value="' . $row['HasilPengemasan'] . '" readonly>
                                        </div>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control form-control-sm" value="Car" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="countermesinrekonsiliasipillow" class="col-sm-2 col-form-label">Counter Mesin</label>
                                        <div class="col-sm-2">
                                            <input type="number" class="form-control form-control-sm" value="' . $row['CounterMesin'] . '" readonly>
                                        </div>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control form-control-sm" value="Rtg" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="lithoterpakairekonsiliasipillow" class="col-sm-4 col-form-label fw-bold">Jumlah Kemasan Terpakai</label>
                                    </div>

                                    <div class="form-group row mb-1">
                                        <div class="col-sm-2">
                                            <input class="form-control border-0 bg-transparent" type="text" id="dusrekonpillow" value="Dus" readonly>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control form-control-sm" value="' . $row['Dus'] . '" readonly>
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="form-control border-0 bg-transparent" type="text" id="hangerrekonpillow" value="Hanger" readonly>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control form-control-sm" value="' . $row['Hanger'] . '" readonly>
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="form-control border-0 bg-transparent" type="text" id="boxrekonpillow" value="Box" readonly>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control form-control-sm" value="' . $row['Tbox'] . '" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-1">
                                        <div class="col-sm-2">
                                            <input class="form-control border-0 bg-transparent" type="text" id="brosurrekonpillow" value="Brosur" readonly>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control form-control-sm" value="' . $row['Brosur'] . '" readonly>
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="form-control border-0 bg-transparent" type="text" id="stikerrekonpillow" value="Stiker" readonly>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control form-control-sm" value="' . $row['Stiker'] . '" readonly>
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="form-control border-0 bg-transparent" type="text" id="plastikrekonpillow" value="Plastik" readonly>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control form-control-sm" value="' . $row['Plastik'] . '" readonly>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row mb-0">
                                        <label for="hasilteoritisrekonpillow" class="col-sm-2 col-form-label">Hasil Teoritis</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control form-control-sm" value="' . $row['HasilTeoritis'] . '" readonly>
                                        </div>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="hasilnyatarekonpillow" class="col-sm-2 col-form-label">Hasil Nyata</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control form-control-sm" value="' . $row['HasilNyata'] . '" readonly>
                                        </div>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control form-control-sm" value="Sch" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="presentaserekonpillow" class="col-sm-2 col-form-label">Presentase</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control form-control-sm" value="' . $row['PresentaseHasil'] . '" readonly>
                                        </div>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control form-control-sm" id="uom1rekonpillow" value="%" readonly>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group row mb-0">
                                        <label for="rangehasilrekonpillow" class="col-sm-2 col-form-label">Range Hasil</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control form-control-sm" id="rangehasilrekonpillow" value="' . $rangehasil . '" readonly>
                                        </div>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control form-control-sm" id="uom2rekonpillow" value="' . $uom . '" readonly>
                                        </div>
                                    </div> -->
                                </div>
                            </div>';
    // }
    $output .= '
                        </div>
                        <div class="tab-pane fade show" id="modalpillowpills-4" role="tabpanel" aria-labelledby="pills-4-tab">
                               <!-- Downtime Pillow -->';
    $output .= '
                            <table class="table table-sm">
                                <thead class="bg-dark text-white">
                                    <tr>
                                            <th>Item</th>
                                            <th>Jam</th>
                                            <th>Permasalahan</th>
                                            <th>Tindakan</th>
                                            <th>Hasil</th>
                                            <th>Created On</th>
                                    </tr>
                                </thead>
                                <tbody>';
    $return = true;
    $sql = mysqli_query($conn, "SELECT * FROM downtime_rekon WHERE Plant='$plant' AND UnitCode='$unitcode' AND
                                                                                        PlanningNumber='$planningnumber' AND
                                                                                       Years='$years' AND
                                                                                       Prosestrx='pillow'");
    while ($row = mysqli_fetch_array($sql)) {
        $output .= '
                                    <tr>
                                       <td>' . $row['Item'] . '</td>
                                       <td>' . $row['LamaDowntime'] . '</td>
                                       <td>' . $row['Permasalahan'] . '</td>
                                       <td>' . $row['Tindakan'] . '</td>
                                       <td>' . $row['Hasil'] . '</td>
                                       <td>' . $row['CreatedOn'] . '</td>
                                   </tr>';
    }
    $output .= '
                               </tbody>
                           </table>
                           <div class="form-group row">
                                <div class="col-sm-12 text-end mt-5">
                                    <button type="button" class="btn btn-outline-success btn-sm" onclick="changedowntimetopackdatapengemasan()"><img src="../asset/icon/pencil.png"> Change</button>
                                </div>
                            </div>';
    $output .= '
                        </div>
                    </div>
                </div>
            ';
    $return = true;
    $dump['output'] = $output;
    $dump['return'] = $return;
    echo json_encode($dump);
}

// ---------------------------------------------------------
// Approval Planning
// ---------------------------------------------------------
if (isset($_POST['prosesdisplayapprovalplanning'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosesdisplayapprovalplanning'][0];
    $years = $_POST['prosesdisplayapprovalplanning'][1];
    $dump[] = '';
    $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                        AND PlanningNumber = '$planningnumber' 
                                                                                        AND Years='$years'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['status'] = true;
        $dump['planning'] = $q['PlanningNumber'];
        $dump['productid'] = $q['ProductID'];
        $single = mysqli_query($conn, "SELECT ProductDescriptions, StandardRoll, StandardRollKonversi FROM mara_product WHERE ProductID='$q[ProductID]'");
        $row = mysqli_fetch_array($single);
        $dump['productdecription'] = $row['ProductDescriptions'];
        $dump['standardroll'] = $row['StandardRoll'];
        // $dump['standardrollkonversi'] = $row['StandardRollKonversi'];
        $dump['shiftid'] = $q['ShiftID'];
        $dump['packingdate'] = $q['PackingDate'];
        $dump['resourceid'] = $q['ResourceID'];
        $dump['batchnumber'] = $q['BatchNumber'];
        $dump['expireddate'] = $q['ExpiredDate'];
        $dump['resourceidmix'] = $q['ResourceIDMix'];
        $dump['mixingdate'] = $q['MixingDate'];
        $dump['quantity'] = $q['Quantity'];
        $dump['unitofmeasures'] = $q['UnitOfMeasures'];
        $dump['processnumber'] = $q['ProcessNumber'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['createdon'] = $q['CreatedOn'];
        $dump['changedby'] = $q['ChangedBy'];
        $dump['changedon'] = $q['ChangedOn'];
        $dump['stts'] = $q['Stts'];
        $dump['years'] = $q['Years'];
    }
    echo json_encode($dump);
}
if (isset($_POST['prosesapprovalplanning'])) {
    $return = false;
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosesapprovalplanning'][0];
    $note = $_POST['prosesapprovalplanning'][1];
    $years = $_POST['prosesapprovalplanning'][2];
    $approvalby = $_POST['prosesapprovalplanning'][3];

    $approvalby = explode(" ", $approvalby);
    $approvalby = $approvalby[0];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "UPDATE planning_prod_header SET Approval='X' WHERE Plant='$plant' AND
                                                                                    UnitCode='$unitcode' AND
                                                                                    PlanningNumber='$planningnumber' AND
                                                                                     Years='$years'");
    if ($sql === true) {
        $return = true;
    }
    $sql = mysqli_query($conn, "SELECT * FROM approval_planning WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND 
                                                                        Years='$years'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) == 0) {
        $sql = mysqli_query($conn, "INSERT INTO approval_planning (Plant,
                                                                    UnitCode,
                                                                    PlanningNumber,
                                                                    Years,
                                                                    Approval,
                                                                    Note,
                                                                    ApprovalBy,
                                                                    CreatedOn,
                                                                    CreatedBy)
        VALUES('$plant',
        '$unitcode',
        '$planningnumber',
        '$years',
        'X',
        '$note',
        '$approvalby',
        '$createdon',
        '$createdby')");
    }
    echo $return;
}

// ---------------------------------------------------------
// Persiapan Hoper
// ---------------------------------------------------------
if (isset($_POST['prosesdisplaypersiapanhoper'])) {
    $planningnumber = $_POST['prosesdisplaypersiapanhoper'][0];
    $years = $_POST['prosesdisplaypersiapanhoper'][1];

    $qc = mysqli_query($conn, "SELECT Rh,Suhu FROM qc_result WHERE Plant='$plant' AND
                                                                UnitCode='$unitcode' AND
                                                                 PlanningNumber='$planningnumber' AND 
                                                                 Years='$years' AND
                                                                 Types='Hoper'");
    $row = mysqli_fetch_array($qc);
    $data['rh'] = $row['Rh'];
    $data['suhu'] = $row['Suhu'];
    $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND 
                                                                        PlanningNumber = '$planningnumber' AND 
                                                                        Years='$years'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $data['return'] = true;
        $data['planning'] = $q['PlanningNumber'];
        $data['productid'] = $q['ProductID'];
        $single = mysqli_query($conn, "SELECT ProductDescriptions, StandardRoll, StandardRollKonversi FROM mara_product WHERE ProductID='$q[ProductID]'");
        $row = mysqli_fetch_array($single);
        $data['productdecription'] = $row['ProductDescriptions'];
        $data['standardroll'] = $row['StandardRoll'];
        // $data['standardrollkonversi'] = $row['StandardRollKonversi'];
        $data['shiftid'] = $q['ShiftID'];
        $data['packingdate'] = beautydate1($q['PackingDate']);
        $data['resourceid'] = $q['ResourceID'];
        $data['batchnumber'] = $q['BatchNumber'];
        $data['expireddate'] = beautydate1($q['ExpiredDate']);
        $data['resourceidmix'] = $q['ResourceIDMix'];
        $data['mixingdate'] = beautydate1($q['MixingDate']);
        $data['quantity'] = $q['Quantity'];
        $data['unitofmeasures'] = $q['UnitOfMeasures'];
        $data['processnumber'] = $q['ProcessNumber'];
        $data['createdby'] = $q['CreatedBy'];
        $data['createdon'] = beautydate2($q['CreatedOn']);
        $data['changedby'] = $q['ChangedBy'];
        $data['changedon'] = beautydate2($q['ChangedOn']);
        $data['stts'] = $q['Stts'];
        $data['years'] = $q['Years'];
    }
    echo json_encode($data);
}
if (isset($_POST['prosessimpanpersiapanhoper'])) {
    $types = 'Hoper';
    $planningnumber = $_POST['prosessimpanpersiapanhoper'][0];
    $operator1 = $_POST['prosessimpanpersiapanhoper'][1];
    $operator2 = $_POST['prosessimpanpersiapanhoper'][2];
    $var1 = $_POST['prosessimpanpersiapanhoper'][3];
    $var2 = $_POST['prosessimpanpersiapanhoper'][4];
    $var2_1 = $_POST['prosessimpanpersiapanhoper'][5];
    $var3 = $_POST['prosessimpanpersiapanhoper'][6];
    $var4 = $_POST['prosessimpanpersiapanhoper'][7];
    $var5 = $_POST['prosessimpanpersiapanhoper'][8];
    $var5_2 = $_POST['prosessimpanpersiapanhoper'][9];
    $var5_3 = date("Y-m-d H:i:s", strtotime($_POST['prosessimpanpersiapanhoper'][10]));
    $var5_4 = date("Y-m-d H:i:s", strtotime($_POST['prosessimpanpersiapanhoper'][11]));
    $var6 = $_POST['prosessimpanpersiapanhoper'][12];
    $var7 = $_POST['prosessimpanpersiapanhoper'][13];
    $var8 = $_POST['prosessimpanpersiapanhoper'][14];
    $pengawas = $_POST['prosessimpanpersiapanhoper'][15];
    $years = $_POST['prosessimpanpersiapanhoper'][16];
    // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try {
        mysqli_begin_transaction($conn);
        $sql = mysqli_query($conn, "INSERT INTO proses_prepare (Plant,UnitCode,PlanningNumber,Years,Types,Operator1,Operator2,PengawasProduksi,
                                                                Parameter_1,
                                                                Parameter_2,
                                                                Parameter_2_1,
                                                                Parameter_3,
                                                                Parameter_4,
                                                                Parameter_5,
                                                                Sub_parameter_5_2,
                                                                Sub_parameter_5_3,
                                                                Sub_parameter_5_4,
                                                                Parameter_6,
                                                                Parameter_7,
                                                                Parameter_8,
                                                                CreatedBy,CreatedOn) VALUES('$plant','$unitcode','$planningnumber','$years','$types','$operator1','$operator2','$pengawas'
                                                                ,'$var1','$var2','$var2_1','$var3','$var4','$var5'
                                                                ,'$var5_2','$var5_3','$var5_4',
                                                                '$var6','$var7','$var8','$createdby','$createdon')");
        if (!$sql) {
            throw new Exception("Gagal insert proses_prepare: " . mysqli_error($conn));
        }
        if (!mysqli_query($conn, "UPDATE planning_prod_header SET PrepareHoper='X' WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                 PlanningNumber='$planningnumber' AND
                                                                                 Years='$years'")) {
            throw new Exception("Gagal update planning_prod_header: " . mysqli_error($conn));
        }
        $return = true;
        mysqli_commit($conn);
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $msg = "Data gagal tersimpan";
        errorlog($e->getMessage());
        $return = false;
    }
    $data = [
        "iconmsg" => 'warning',
        "time" => $time,
        "msg" => $msg,
        "link" => null,
        "id" => $planningnumber,
        "return" => $return
    ];

    echo json_encode($data);
    exit;
}

// ---------------------------------------------------------
// Persiapan Topack
// ---------------------------------------------------------
if (isset($_POST['prosesdisplaypersiapantopack'])) {
    $planningnumber = $_POST['prosesdisplaypersiapantopack'][0];
    $years = $_POST['prosesdisplaypersiapantopack'][1];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $dump[] = '';
    $qc = mysqli_query($conn, "SELECT Rh,Suhu FROM qc_result WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    PlanningNumber='$planningnumber' AND 
                                                                    Years='$years' AND Types='Topack'");
    $row = mysqli_fetch_array($qc);
    $dump['rh'] = $row['Rh'];
    $dump['suhu'] = $row['Suhu'];
    // if ($row['Rh_1'] != 0) {
    //     $dump['rh'] = $row['Rh'] . ' - ' . $row['Rh_1'];
    // }
    // if ($row['Suhu_1'] != 0) {
    //     $dump['suhu'] = $row['Suhu'] . ' - ' . $row['Suhu_1'];
    // }
    $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND 
                                                                        Years='$years' ");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['status'] = true;
        $dump['planning'] = $q['PlanningNumber'];
        $dump['productid'] = $q['ProductID'];
        $single = mysqli_query($conn, "SELECT ProductDescriptions, StandardRoll, StandardRollKonversi FROM mara_product WHERE ProductID='$q[ProductID]'");
        $row = mysqli_fetch_array($single);
        $dump['productdecription'] = $row['ProductDescriptions'];
        $dump['standardroll'] = $row['StandardRoll'];
        // $dump['standardrollkonversi'] = $row['StandardRollKonversi'];
        $dump['shiftid'] = $q['ShiftID'];
        $dump['packingdate'] = $q['PackingDate'];
        $dump['resourceid'] = $q['ResourceID'];
        $dump['batchnumber'] = $q['BatchNumber'];
        $dump['expireddate'] = $q['ExpiredDate'];
        $dump['resourceidmix'] = $q['ResourceIDMix'];
        $dump['mixingdate'] = $q['MixingDate'];
        $dump['quantity'] = $q['Quantity'];
        $dump['unitofmeasures'] = $q['UnitOfMeasures'];
        $dump['processnumber'] = $q['ProcessNumber'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['createdon'] = $q['CreatedOn'];
        $dump['changedby'] = $q['ChangedBy'];
        $dump['changedon'] = $q['ChangedOn'];
        $dump['stts'] = $q['Stts'];
        $dump['years'] = $q['Years'];
    }
    echo json_encode($dump);
}
if (isset($_POST['prosessimpanpersiapantopack'])) {
    $return = false;
    $types = 'Topack';
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosessimpanpersiapantopack'][0];
    $operator1 = $_POST['prosessimpanpersiapantopack'][1];
    $operator2 = $_POST['prosessimpanpersiapantopack'][2];
    $var1 = $_POST['prosessimpanpersiapantopack'][3];
    $var2 = $_POST['prosessimpanpersiapantopack'][4];
    $var2_1 = $_POST['prosessimpanpersiapantopack'][5];

    // *******
    // if (strpos($_POST['prosessimpanpersiapantopack'][4], '-')) {
    //     $rh = str_replace(' ', '', $_POST['prosessimpanpersiapantopack'][4]);
    //     $var2 = explode('-', $rh);
    //     $var2_v1 = explode('-', $rh);
    //     $var2 = $var2[0];
    //     $var2_v1 = $var2_v1[1];
    // } else {
    //     $var2 = $_POST['prosessimpanpersiapantopack'][4];
    //     $var2_v1 = 0;
    // }
    // if (strpos($_POST['prosessimpanpersiapantopack'][5], '-')) {
    //     $suhu = str_replace(' ', '', $_POST['prosessimpanpersiapantopack'][5]);
    //     $var2_1 = explode('-', $suhu);
    //     $var2_1_v1 = explode('-', $suhu);
    //     $var2_1 =  $var2_1[0];
    //     $var2_1_v1 = $var2_1_v1[1];
    // } else {
    //     $var2_1 = $_POST['prosessimpanpersiapantopack'][5];
    //     $var2_1_v1 = 0;
    // }
    // *******

    $var3 = $_POST['prosessimpanpersiapantopack'][6];
    $var4 = $_POST['prosessimpanpersiapantopack'][7];
    $var5 = $_POST['prosessimpanpersiapantopack'][8];
    $var5_1 = $_POST['prosessimpanpersiapantopack'][9];
    $var5_2 = $_POST['prosessimpanpersiapantopack'][10];
    $var5_3 = $_POST['prosessimpanpersiapantopack'][11];
    $var5_4 = $_POST['prosessimpanpersiapantopack'][12];
    $var6 = $_POST['prosessimpanpersiapantopack'][13];
    $var7 = $_POST['prosessimpanpersiapantopack'][14];
    $var8 = $_POST['prosessimpanpersiapantopack'][15];
    $pengawas = $_POST['prosessimpanpersiapantopack'][16];
    $years = $_POST['prosessimpanpersiapantopack'][17];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];

    $sql = mysqli_query($conn, "INSERT INTO proses_prepare (Plant,UnitCode,PlanningNumber,Years,Types,Operator1,Operator2,PengawasProduksi,
                                                                Parameter_1,
                                                                Parameter_2,
                                                                Parameter_2_1,
                                                                Parameter_3,
                                                                Parameter_4,
                                                                Parameter_5,
                                                                Sub_parameter_5_1,
                                                                Sub_parameter_5_2,
                                                                Sub_parameter_5_3,
                                                                Sub_parameter_5_4,
                                                                Parameter_6,
                                                                Parameter_7,
                                                                Parameter_8,
                                                                -- Parameter_9,
                                                                -- Parameter_10,
                                                                CreatedBy,CreatedOn) VALUES('$plant','$unitcode','$planningnumber','$years','$types','$operator1','$operator2','$pengawas'
                                                                ,'$var1','$var2','$var2_1','$var3','$var4','$var5',
                                                                '$var5_1','$var5_2','$var5_3','$var5_4',
                                                                '$var6','$var7','$var8','$createdby','$createdon')");
    if ($sql === true) {
        mysqli_query($conn, "UPDATE planning_prod_header SET PrepareTopack='X' WHERE Plant='$plant' AND
                                                                                    UnitCode='$unitcode' AND
                                                                                     PlanningNumber='$planningnumber' AND
                                                                                     Years='$years'");
        $return = true;
    }
    echo $return;
}

// ---------------------------------------------------------
// Persiapan Pengolahan
// ---------------------------------------------------------
if (isset($_POST['prosesdisplaypersiapanpengolahan'])) {
    $planningnumber = $_POST['prosesdisplaypersiapanpengolahan'][0];
    $years = $_POST['prosesdisplaypersiapanpengolahan'][1];
    $batch = $_POST['prosesdisplaypersiapanpengolahan'][2];
    $productid = $_POST['prosesdisplaypersiapanpengolahan'][3];
    $noproses = $_POST['prosesdisplaypersiapanpengolahan'][4];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $dump[] = '';
    $output = '';
    // $sql = mysqli_query($conn,"SELECT * FROM tb_headerbahanpengolahan WHERE")
    $qc = mysqli_query($conn, "SELECT Suhu FROM qc_result WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    PlanningNumber='$planningnumber' AND 
                                                                    Years='$years' AND Types='Pengolahan' AND
                                                                    BatchNumber ='$batch' AND
                                                                    NoProses='$noproses'");
    $row = mysqli_fetch_array($qc);
    // $dump['rh'] = $row['Rh'];
    $dump['suhu'] = $row['Suhu'];
    // if ($row['Rh_1'] != 0) {
    //     $dump['rh'] = $row['Rh'] . ' - ' . $row['Rh_1'];
    // }
    // if ($row['Suhu_1'] != 0) {
    //     $dump['suhu'] = $row['Suhu'] . ' - ' . $row['Suhu_1'];
    // }
    $sql = mysqli_query($conn, "SELECT * FROM planning_pengolahan_detail WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND 
                                                                        Years='$years'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['status'] = true;
        $dump['planning'] = $q['PlanningNumber'];
        $dump['productid'] = $q['ProductID'];
        $single = mysqli_query($conn, "SELECT ProductDescriptions, StandardRoll, StandardRollKonversi FROM mara_product WHERE ProductID='$q[ProductID]'");
        $row = mysqli_fetch_array($single);
        $dump['productdecription'] = $row['ProductDescriptions'];
        $dump['standardroll'] = $row['StandardRoll'];
        // $dump['standardrollkonversi'] = $row['StandardRollKonversi'];
        $dump['shiftid'] = '-';
        $dump['packingdate'] = '-';
        $dump['resourceid'] = $q['ResourceID'];
        $dump['batchnumber'] = $batch;
        $dump['expireddate'] = $q['ExpiredDate'];
        $dump['resourceidmix'] = $q['ResourceIDMix'];
        $dump['mixingdate'] = $q['MixingDate'];
        $dump['quantity'] = $q['JumlahResep'];
        $dump['unitofmeasures'] = $q['UnitOfMeasures'];
        $dump['processnumber'] = $q['ProcessNumber'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['createdon'] = $q['CreatedOn'];
        $dump['changedby'] = $q['ChangedBy'];
        $dump['changedon'] = $q['ChangedOn'];
        $dump['stts'] = $q['Stts'];
        $dump['years'] = $q['Years'];
        $dump['reffcode'] = $q['ReffCode'];
        $reffcode = $q['ReffCode'];
    }
    $output = '';
    $i = 1;
    $sql = mysqli_query($conn, "SELECT * FROM mapping_preparemixing WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                ReffCode='$reffcode'");
    if (mysqli_num_rows($sql) <> 0) {
        $output = '
            <input type="text" class="form-control form-control-sm mb-1 w-25 bg-transparent border-0 fw-bold" id="noprosespersiapanpengolahan" style="font-size:12pt" value="' . $noproses . '" readonly hidden>
            <input type="text" class="form-control form-control-sm mb-1 w-25 bg-transparent border-0 fw-bold" style="font-size:12pt" value="No. Proses ' . $noproses . '" readonly>
            <table class="table table-sm w-50 table-bordered" style="border-collapse: collapse;">
                <tr class="bg-light fw-bold">
                    <th>No</th>
                    <th>Kode Bahan</th>
                    <th>Bets Bahan</th>
                    <th>Jml Teoritis</th>
                    <th>Jml Nyata</th>
                    <th>Total Kantong</th>
                    <th>No Identitas</th>
                    <th>Tgl</th>
                    <th>Cek</th>
                </tr>';
        while ($r = mysqli_fetch_array($sql)) {
            $values = 0;
            $query = mysqli_query($conn, "SELECT * FROM tb_headerbahanpengolahan WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years' AND
                                                                            ProductID='$productid' AND
                                                                            BatchNumber='$batch' AND
                                                                            KodeBahan='$r[KodeBahan]' AND
                                                                            NoProses='$noproses'");
            $q = mysqli_fetch_array($query);
            $query = mysqli_query($conn, "SELECT * FROM tb_detailbahanpengolahan WHERE Plant='$plant' AND
                                                                                    UnitCode='$unitcode' AND
                                                                                    PlanningNumber='$planningnumber' AND
                                                                                    Years='$years' AND
                                                                                    ProductID='$productid' AND
                                                                                    BatchNumber='$batch' AND
                                                                                    KodeBahan='$r[KodeBahan]' AND
                                                                                    NoProses='$noproses'");
            $row = mysqli_fetch_array($query);
            $output .= ' 
                <tr>
                    <td>' . $i . '</td>
                    <td>' . $r["KodeBahan"] . '</td>
                    <td>' . $q["BatchLabel"] . '</td>
                    <td>' . $q["JmlTeoritis"] . '</td>
                    <td>' . $q["JmlNyata"] . '</td>
                    <td>' . $q["TotalKantong"] . '</td>
                    <td>' . $row["NoIdentitas"] . '</td>
                    <td>' . beautydate1($row["CreatedOn"]) . '</td>';

            if ($row['NoIdentitas'] == '') {
                $values = 1;
                $output .= '
                <td>
                        <span class="btn badge rounded-pill bg-dark" onclick="scanbahanmanualpreparepengolahan()">Input bahan</span>
                </td>
                        ';
            }
            $output .= '
                </tr>';
            $i += 1;
        }
    }

    $output .= '   
            </table>';
    $dump['output'] = $output;
    echo json_encode($dump);
}
if (isset($_POST['prosesshowdatabahanpersiapanpengolahan'])) {
    $planningnumber = $_POST['prosesshowdatabahanpersiapanpengolahan'][0];
    $years = $_POST['prosesshowdatabahanpersiapanpengolahan'][1];
    $batch = $_POST['prosesshowdatabahanpersiapanpengolahan'][2];
    $productid = $_POST['prosesshowdatabahanpersiapanpengolahan'][3];
    $noproses = $_POST['prosesshowdatabahanpersiapanpengolahan'][4];
    $reffcode = $_POST['prosesshowdatabahanpersiapanpengolahan'][5];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $return = false;
    $dump[] = '';
    $output = '';
    $i = 1;
    $sql = mysqli_query($conn, "SELECT * FROM mapping_preparemixing WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                ReffCode='$reffcode'");
    if (mysqli_num_rows($sql) <> 0) {
        $output = '
            <input type="text" class="form-control form-control-sm mb-1 w-25 bg-transparent border-0 fw-bold" id="noprosespersiapanpengolahan" style="font-size:12pt" value="' . $noproses . '" readonly hidden>
            <input type="text" class="form-control form-control-sm mb-1 w-25 bg-transparent border-0 fw-bold" style="font-size:12pt" value="No. Proses ' . $noproses . '" readonly>
            <table class="table table-sm w-50 table-bordered" style="border-collapse: collapse;">
                <tr class="bg-light fw-bold">
                    <th>No</th>
                    <th>Kode Bahan</th>
                    <th>Bets Bahan</th>
                    <th>Jml Teoritis</th>
                    <th>Jml Nyata</th>
                    <th>Total Kantong</th>
                    <th>No Identitas</th>
                    <th>Tgl</th>
                    <th>Cek</th>
                </tr>';
        while ($r = mysqli_fetch_array($sql)) {
            $values = 0;
            $query = mysqli_query($conn, "SELECT * FROM tb_headerbahanpengolahan WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years' AND
                                                                            ProductID='$productid' AND
                                                                            BatchNumber='$batch' AND
                                                                            KodeBahan='$r[KodeBahan]' AND
                                                                            NoProses='$noproses'");
            $q = mysqli_fetch_array($query);
            $query = mysqli_query($conn, "SELECT * FROM tb_detailbahanpengolahan WHERE Plant='$plant' AND
                                                                                    UnitCode='$unitcode' AND
                                                                                    PlanningNumber='$planningnumber' AND
                                                                                    Years='$years' AND
                                                                                    ProductID='$productid' AND
                                                                                    BatchNumber='$batch' AND
                                                                                    KodeBahan='$r[KodeBahan]' AND
                                                                                    NoProses='$noproses'");
            $row = mysqli_fetch_array($query);
            $output .= ' 
                <tr>
                    <td>' . $i . '</td>
                    <td>' . $r["KodeBahan"] . '</td>
                    <td>' . $q["BatchLabel"] . '</td>
                    <td>' . $q["JmlTeoritis"] . '</td>
                    <td>' . $q["JmlNyata"] . '</td>
                    <td>' . $q["TotalKantong"] . '</td>
                    <td>' . $row["NoIdentitas"] . '</td>
                    <td>' . beautydate1($row["CreatedOn"]) . '</td>';

            if ($row['NoIdentitas'] == '') {
                $values = 1;
                $output .= '
                <td>
                        <span class="btn badge rounded-pill bg-dark" onclick="scanbahanmanualpreparepengolahan()">Input bahan</span>
                </td>
                        ';
            }
            $output .= '
                    <td class="hidden"><input type="text" class="form-control form-control-sm" value="' . $values . '" id="inputbahanpreparepengolahan" hidden></td>
                </tr>';
            $i += 1;
        }
        $return = true;
    }

    $output .= '   
            </table>';
    $dump['output'] = $output;
    $dump['return'] = $return;
    echo json_encode($dump);
}
if (isset($_POST['prosessimpanpersiapanpengolahan'])) {
    $return = false;
    $types = 'Pengolahan';
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosessimpanpersiapanpengolahan'][0];
    $operator1 = $_POST['prosessimpanpersiapanpengolahan'][1];
    $operator2 = $_POST['prosessimpanpersiapanpengolahan'][2];
    $operator3 = $_POST['prosessimpanpersiapanpengolahan'][3];
    $var1 = $_POST['prosessimpanpersiapanpengolahan'][4];
    $var2 = $_POST['prosessimpanpersiapanpengolahan'][5];
    $var3 = $_POST['prosessimpanpersiapanpengolahan'][6];
    $var4 = $_POST['prosessimpanpersiapanpengolahan'][7];
    $var5 = $_POST['prosessimpanpersiapanpengolahan'][8];
    $var6 = $_POST['prosessimpanpersiapanpengolahan'][9];
    $var7 = $_POST['prosessimpanpersiapanpengolahan'][10];
    $var8 = $_POST['prosessimpanpersiapanpengolahan'][11];
    $var9 = $_POST['prosessimpanpersiapanpengolahan'][12];
    $var10 = $_POST['prosessimpanpersiapanpengolahan'][13];
    $pengawas = $_POST['prosessimpanpersiapanpengolahan'][14];
    $years = $_POST['prosessimpanpersiapanpengolahan'][15];
    $bets = $_POST['prosessimpanpersiapanpengolahan'][16];
    $noproses = $_POST['prosessimpanpersiapanpengolahan'][17];
    $productid = $_POST['prosessimpanpersiapanpengolahan'][18];
    $bets = str_replace(': ', '', $bets);
    $productid = str_replace(': ', '', $productid);
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $lastupdate = date("Y-m-d H:i:s");

    $sql = mysqli_query($conn, "INSERT INTO proses_prepare_mixer (Plant,UnitCode,PlanningNumber,Years,ProductID,BatchNumber,NoProses,LastUpdate,
                                                                Operator1,Operator2,Operator3,PengawasProduksi,
                                                                Parameter_1,
                                                                Parameter_2,
                                                                Parameter_3,
                                                                Parameter_4,
                                                                Parameter_5,
                                                                Parameter_6,
                                                                Parameter_7,
                                                                Parameter_8,
                                                                Parameter_9,
                                                                Parameter_10,
                                                                CreatedBy,CreatedOn) VALUES('$plant','$unitcode','$planningnumber','$years','$productid',
                                                                '$bets','$noproses','$lastupdate','$operator1','$operator2','$operator3','$pengawas'
                                                                ,'$var1','$var2','$var3','$var4','$var5',
                                                                '$var6','$var7','$var8','$var9','$var10','$createdby','$createdon')");
    if ($sql === true) {
        mysqli_query($conn, "UPDATE planning_pengolahan_subdetail SET Stats03='X' WHERE Plant='$plant' AND
                                                                                    UnitCode='$unitcode' AND
                                                                                    PlanningNumber='$planningnumber' AND
                                                                                    Years='$years' AND
                                                                                    ProductID='$productid' AND
                                                                                    BatchNumber='$bets' AND
                                                                                    NoProses='$noproses'");
        $sql = mysqli_query($conn, "SELECT * FROM tb_headerbahanpengolahan WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                PlanningNumber='$planningnumber' AND
                                                                                Years='$years' AND
                                                                                ProductID='$productid' AND
                                                                                BatchNumber='$bets' AND
                                                                                NoProses='$noproses'
                                                                                ORDER BY IndexRow ASC");
        if (mysqli_num_rows($sql) != 0) {
            $return = true;
            while ($r = mysqli_fetch_array($sql)) {
                mysqli_query($conn, "INSERT INTO tb_headerprosesmixing (Plant,
                                                                        UnitCode,
                                                                        PlanningNumber,
                                                                        Years,
                                                                        ProductID,
                                                                        BatchNumber,
                                                                        BatchLabel,
                                                                        NoProses,
                                                                        KodeBahan,
                                                                        IndexRow,
                                                                        Satuan,
                                                                        SisaQty,
                                                                        ScanQty,
                                                                        CreatedOn,
                                                                        CreatedBy)
                                    VALUES('$plant',
                                            '$unitcode',
                                            '$r[PlanningNumber]',
                                            '$r[Years]',
                                            '$r[ProductID]',
                                            '$r[BatchNumber]',
                                            '$r[BatchLabel]',
                                            '$r[NoProses]',
                                            '$r[KodeBahan]',
                                            '$r[IndexRow]',
                                            'Kantong',
                                            '$r[JmlNyata]',
                                            '$r[ScanQty]',
                                            '$createdon',
                                            '$createdby')");
            }
        }
    }
    echo $return;
}
if (isset($_POST['prosesscanbahanmanualpreparepengolahan'])) {
    $productid = $_POST['prosesscanbahanmanualpreparepengolahan'];

    $query = mysqli_query($conn, "SELECT KodeBahan FROM tbl_xmixing WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND 
                                                                        ProductID='$productid'");
    if (mysqli_num_rows($query) <> 0) {
        // $output = "<option></option>";
        // while ($r = mysqli_fetch_array($query)) {
        //     $output .= "<option value=" . $r['KodeBahan'] . ">" . $r['KodeBahan'] . "</option>";
        // }
        $r = mysqli_fetch_array($query);
        $output = $r['KodeBahan'];
    } else {
        // $output = "<option selected>Batch tidak ditemukan</option>";
        $output = "Tidak ditemukan";
    }
    $dump = [
        "output" => $output
    ];
    echo json_encode($dump);
}
if (isset($_POST['prosesgetbatchlabelmanualpreparepengolahan'])) {
    $planningnumber = $_POST['prosesgetbatchlabelmanualpreparepengolahan'][0];
    $years = $_POST['prosesgetbatchlabelmanualpreparepengolahan'][1];
    $productid = $_POST['prosesgetbatchlabelmanualpreparepengolahan'][2];
    $batchnumber = $_POST['prosesgetbatchlabelmanualpreparepengolahan'][3];

    $query = mysqli_query($conn, "SELECT DISTINCT BatchLabel FROM tb_headerbahanpengolahan WHERE Plant='$plant' AND 
                                                                                                UnitCode='$unitcode' AND 
                                                                                                PlanningNumber='$planningnumber' AND
                                                                                                Years='$years' AND
                                                                                                ProductID='$productid' AND
                                                                                                BatchNumber='$batchnumber'");
    $r = mysqli_fetch_array($query);
    $dump = [
        "batchlabel" => $r['BatchLabel']
    ];
    echo json_encode($dump);
}
if (isset($_POST['prosessimpanmanualbahanpersiapanpengolahan'])) {
    $planningnumber = $_POST['prosessimpanmanualbahanpersiapanpengolahan'][0];
    $years = $_POST['prosessimpanmanualbahanpersiapanpengolahan'][1];
    $productid = $_POST['prosessimpanmanualbahanpersiapanpengolahan'][2];
    $batchnumber = $_POST['prosessimpanmanualbahanpersiapanpengolahan'][3];
    $noproses = $_POST['prosessimpanmanualbahanpersiapanpengolahan'][4];

    $identitas1 = strtoupper($_POST['prosessimpanmanualbahanpersiapanpengolahan'][5]);
    $identitas2 = strtoupper($_POST['prosessimpanmanualbahanpersiapanpengolahan'][6]);
    $batchlabel = strtoupper($_POST['prosessimpanmanualbahanpersiapanpengolahan'][7]);
    $nokantong = $_POST['prosessimpanmanualbahanpersiapanpengolahan'][8];
    $totalkantong = $_POST['prosessimpanmanualbahanpersiapanpengolahan'][9];
    $reffcode = $_POST['prosessimpanmanualbahanpersiapanpengolahan'][10];
    $kodebahan = $_POST['prosessimpanmanualbahanpersiapanpengolahan'][11];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $noidentitas = $identitas1 . ' - ' . $identitas2;
    if ($identitas2 == '0' || $identitas2 == '') {
        $noidentitas = $identitas1;
    }
    $return = false;

    $sql = mysqli_query($conn, "SELECT JmlTeoritis,ScanQty FROM mapping_preparemixing WHERE Plant='$plant' AND 
                                                                                            UnitCode='$unitcode' AND
                                                                                            ProductID='$productid' AND
                                                                                            KodeBahan='$kodebahan' AND
                                                                                            ReffCode='$reffcode'");
    if (mysqli_num_rows($sql) <> 0) {
        $r = mysqli_fetch_array($sql);
        $jmlteoritis = $r['JmlTeoritis'];
        $jmlkonsumsi = $r['ScanQty'];
        $jmlnyata = 1;
    }

    $header = mysqli_query($conn, "SELECT * FROM tb_headerbahanpengolahan WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND
                                                                                PlanningNumber='$planningnumber' AND
                                                                                Years='$years' AND
                                                                                ProductID='$productid' AND
                                                                                BatchNumber='$batchnumber' AND
                                                                                KodeBahan='$kodebahan' AND
                                                                                BatchLabel='$batchlabel' AND
                                                                                NoProses='$noproses'");
    if (mysqli_num_rows($header) <> 0) {
        $r = mysqli_fetch_array($header);
        $jmlnyata = $r['JmlNyata'] + 1;
        if ($jmlnyata > $jmlteoritis) {
            $return = 'Jumlah konsumsi melebihi jumlah teoritis';
            echo $return;
            die;
        } else {
            mysqli_query($conn, "UPDATE tb_headerbahanpengolahan SET JmlNyata='$jmlnyata' WHERE Plant='$plant' AND 
                                                                                                UnitCode='$unitcode' AND
                                                                                                PlanningNumber='$planningnumber' AND
                                                                                                Years='$years' AND
                                                                                                ProductID='$productid' AND
                                                                                                BatchNumber='$batchnumber' AND
                                                                                                BatchLabel='$batchlabel' AND
                                                                                                NoProses='$noproses' AND
                                                                                                KodeBahan='$kodebahan'
                                                                                                ");
        }
    } else {
        mysqli_query($conn, "INSERT INTO tb_headerbahanpengolahan (Plant,
                                                                UnitCode,
                                                                PlanningNumber,
                                                                Years,
                                                                ProductID,
                                                                BatchNumber,
                                                                BatchLabel,
                                                                NoProses,
                                                                KodeBahan,
                                                                JmlTeoritis,
                                                                JmlNyata,
                                                                Totalkantong,
                                                                ScanQTy,
                                                                CreatedOn,
                                                                CreatedBy)
                            VALUES('$plant',
                                    '$unitcode',
                                    '$planningnumber',
                                    '$years',
                                    '$productid',
                                    '$batchnumber',
                                    '$batchlabel',
                                    '$noproses',
                                    '$kodebahan',
                                    '$jmlteoritis',
                                    '$jmlnyata',
                                    '$totalkantong',
                                    '$jmlkonsumsi',
                                    '$createdon',
                                    '$createdby')");
    }


    $detail = mysqli_query($conn, "SELECT * FROM tb_detailbahanpengolahan WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND
                                                                                PlanningNumber='$planningnumber' AND
                                                                                Years='$years' AND
                                                                                ProductID='$productid' AND
                                                                                BatchNumber='$batchnumber' AND
                                                                                KodeBahan='$kodebahan' AND
                                                                                NoKantong = '$nokantong' AND
                                                                                BatchLabel='$batchlabel' AND
                                                                                NoProses='$noproses'");
    if (mysqli_num_rows($detail) <> 0) {
        $return = 'No Kantong sudah pernah tersimpan';
        echo $return;
        die;
    }
    $query = mysqli_query($conn, "INSERT INTO tb_detailbahanpengolahan (Plant,
                                                                UnitCode,
                                                                PlanningNumber,
                                                                Years,
                                                                ProductID,
                                                                BatchNumber,
                                                                BatchLabel,
                                                                NoProses,
                                                                KodeBahan,
                                                                NoKantong,
                                                                NoIdentitas,
                                                                JmlNyata,
                                                                CreatedOn,
                                                                CreatedBy)
                            VALUES('$plant',
                                    '$unitcode',
                                    '$planningnumber',
                                    '$years',
                                    '$productid',
                                    '$batchnumber',
                                    '$batchlabel',
                                    '$noproses',
                                    '$kodebahan',
                                    '$nokantong',
                                    '$noidentitas',
                                    '$jmlnyata',
                                    '$createdon',
                                    '$createdby')");
    if ($query === true) {
        $return = true;
    }
    echo $return;
}
if (isset($_POST['proseschecksettingpreparemixing'])) {
    $indexrow = $_POST['proseschecksettingpreparemixing'][0];
    $value = $_POST['proseschecksettingpreparemixing'][1];
    $return = false;
    $sql = mysqli_query($conn, "SELECT * FROM tb_headerbahanpengolahan WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            IndexRow='$indexrow'");
    if (mysqli_num_rows($sql) != 0) {
        mysqli_query($conn, "UPDATE tb_headerbahanpengolahan SET ScanQty='$value' WHERE Plant='$plant' AND
                                                                                        UnitCode='$unitcode' AND
                                                                                        IndexRow='$indexrow'");
        $return = true;
    }
}

// ---------------------------------------------------------
// Proses Hoper
// ---------------------------------------------------------
if (isset($_POST['prosesdisplayproseshoper'])) {
    $planningnumber = $_POST['prosesdisplayproseshoper'][0];
    $years = $_POST['prosesdisplayproseshoper'][1];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $dump[] = '';
    $output = '';
    $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                         PlanningNumber = '$planningnumber' AND
                                                                         Years='$years'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['status'] = true;
        $dump['planning'] = $q['PlanningNumber'];
        $dump['urlcodes'] = $q['PlanningNumber'];
        $dump['productid'] = $q['ProductID'];
        $single = mysqli_query($conn, "SELECT ProductDescriptions FROM mara_product WHERE ProductID='$q[ProductID]'");
        $row = mysqli_fetch_array($single);
        $dump['productdecription'] = $row['ProductDescriptions'];
        $dump['shiftid'] = $q['ShiftID'];
        $dump['packingdate'] = $q['PackingDate'];
        $dump['resourceid'] = $q['ResourceID'];
        $dump['batchnumber'] = $q['BatchNumber'];
        $dump['expireddate'] = $q['ExpiredDate'];
        $dump['resourceidmix'] = $q['ResourceIDMix'];
        $dump['mixingdate'] = $q['MixingDate'];
        $dump['quantity'] = $q['Quantity'];
        $dump['unitofmeasures'] = $q['UnitOfMeasures'];
        $dump['processnumber'] = $q['ProcessNumber'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['createdon'] = $q['CreatedOn'];
        $dump['changedby'] = $q['ChangedBy'];
        $dump['changedon'] = $q['ChangedOn'];
        $dump['stts'] = $q['Stts'];
        $dump['years'] = $q['Years'];
    }
    echo json_encode($dump);
}
if (isset($_POST['showtableproseshoper'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['showtableproseshoper'][0];
    $years = $_POST['showtableproseshoper'][1];
    $output = '<table id="ddisplayplanning" class="table table-sm" style="width:100%;">
    <thead class="bg-dark text-white">
        <tr>
            <th rowspan=2 style="width:5%">#</th>
            <th rowspan=2 class="align-middle">Planing Number</th>
            <th rowspan=2 class="align-middle">No<br>Proses</th>
            <th rowspan=2 class="align-middle">No<br>Tong</th>
            <th rowspan=2 class="align-middle">Waktu</th>
            <th rowspan=2 class="align-middle">Qty</th>
            <th rowspan=2 class="align-middle" style="width:30%">Kondisi Ayakan</th>
            <th rowspan=2 class="align-middle">Kontaminasi</th>
            <th colspan=2 class="align-middle text-center">Temuan</th>
        </tr>
        <tr>
            <th class="align-middle">Jenis</th>
            <th class="align-middle">Jumlah</th>
        </tr>
    </thead>
    <tbody>';
    $sql = mysqli_query($conn, "SELECT * FROM transaksi_hoper WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND 
                                                                    PlanningNumber='$planningnumber' AND
                                                                    Years='$years'");
    while ($row = mysqli_fetch_array($sql)) {
        $kondisiayakan = 'kondisiayakan';
        $output .= '
        <tr>
            <td><a href="#" class="badge href_transform" id="planningnumberdisplayplanning" onclick="deleteproseshoper(' . $row['PlanningNumber'] . ',' . $row["ProcessNumber"] . ',' . $row["ContainerNumber"] . ',' . $row["Years"] . ',' . $row["Quantity"] . ')"><img src="../asset/img/delete.png"></a></td>
            <td>' . $planningnumber . '</td>
            <td>' . $row["ProcessNumber"] . '</td>
            <td>' . $row["ContainerNumber"] . '</td>
            <td>' . $row["TimeExecuted"] . '</td>
            <td>' . $row["Quantity"] . '</td>
            <td>
                <select class="form-select form-select-sm" id="kondisiayakanproseshoper" onchange="changevalueproseshoper(' . $row["PlanningNumber"] . ',' . $row["Years"] . ',' . $row["ProcessNumber"] . ',' . $row["ContainerNumber"] . ',1,this.value)">
                    <option>' . $row["KondisiAyakan"] . '</option>';
        $query1 = mysqli_query($conn, "SELECT Descriptions FROM text_sys WHERE JenisProses='proseshoperkondisiayakan' AND Descriptions !='$row[KondisiAyakan]'");
        while ($r1 = mysqli_fetch_array($query1)) {
            $output .= '<option value="' . $r1["Descriptions"] . '">' . $r1["Descriptions"] . '</option>';
        }
        $output .= '</select>
            </td>
            <td>
                <select class="form-select form-select-sm" id="kondisiayakanproseshoper" onchange="changevalueproseshoper(' . $row["PlanningNumber"] . ',' . $row["Years"] . ',' . $row["ProcessNumber"] . ',' . $row["ContainerNumber"] . ',2,this.value)">
                <option>' . $row["Kontaminasi"] . '</option>';
        $query2 = mysqli_query($conn, "SELECT Descriptions FROM qc_catalog WHERE KodeCatalog='CTLG06' AND Descriptions !='$row[Kontaminasi]' ORDER BY Item DESC");
        while ($r2 = mysqli_fetch_array($query2)) {
            $output .= '<option value="' . $r2["Descriptions"] . '">' . $r2["Descriptions"] . '</option>';
        }
        $output .= '</select>
            </td>
            <td>
                <input type="text" class="form-control form-control-sm" id="jenistemuanproseshoper" value="' . $row["JenisTemuan"] . '" onkeypress="changevalueenterproseshoper(event,' . $row["PlanningNumber"] . ',' . $row["Years"] . ',' . $row["ProcessNumber"] . ',' . $row["ContainerNumber"] . ',1,this.value)">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm" id="jenistemuanproseshoper" value="' . $row["JumlahTemuan"] . '" onkeypress="changevalueenterproseshoper(event,' . $row["PlanningNumber"] . ',' . $row["Years"] . ',' . $row["ProcessNumber"] . ',' . $row["ContainerNumber"] . ',2,this.value)">
            </td>
        </tr>';
    }
    $output .= '
    </tbody>
    </table>';
    echo $output;
}
if (isset($_POST['prosescektongproseshoper'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosescektongproseshoper'][0];
    $years = $_POST['prosescektongproseshoper'][1];
    $product = $_POST['prosescektongproseshoper'][2];
    $batch = $_POST['prosescektongproseshoper'][3];
    $noproses = $_POST['prosescektongproseshoper'][4];
    $return = false;
    $jumlahtong = 0;
    $tongtersedia = 0;
    $sumtong = mysqli_query($conn, "SELECT ContainerNumber FROM planning_prod_header WHERE Plant='$plant' AND 
                                                                                            UnitCode='$unitcode' AND
                                                                                             PlanningNumber ='$planningnumber' AND
                                                                                             Years='$years' AND
                                                                                             ProductID='$product' AND
                                                                                             BatchNumber='$batch'");
    if (mysqli_num_rows($sumtong) != 0) {
        $r = mysqli_fetch_array($sumtong);
        $tongtersedia = $r['ContainerNumber'];
        $tong = mysqli_query($conn, "SELECT ContainerNumber FROM transaksi_hoper WHERE Plant='$plant' AND 
                                                                                        UnitCode='$unitcode' AND
                                                                                        PlanningNumber ='$planningnumber' AND
                                                                                        Years='$years' AND
                                                                                        ProcessNumber ='$noproses'");
        $jumlahtong = mysqli_num_rows($tong);
        $return = $tongtersedia;
        if ($jumlahtong < $tongtersedia) {
            $return = true;
        } else {
            $return = $jumlahtong;
        }
    } else {
        $return = 'wrong';
    }

    echo $return;
}
if (isset($_POST['prosessubmitproseshoper'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $return = false;
    $planningnumber = $_POST['prosessubmitproseshoper'][0];
    $years = $_POST['prosessubmitproseshoper'][1];
    $noproses = $_POST['prosessubmitproseshoper'][2];
    $container = $_POST['prosessubmitproseshoper'][3];
    $qty = $_POST['prosessubmitproseshoper'][4];
    $prueflos = $_POST['prosessubmitproseshoper'][5];
    $lotyear = $_POST['prosessubmitproseshoper'][6];
    $product = $_POST['prosessubmitproseshoper'][7];
    $batch = $_POST['prosessubmitproseshoper'][8];
    $item = $_POST['prosessubmitproseshoper'][9];
    $planningpengolahan = $_POST['prosessubmitproseshoper'][10];
    $planningyear = $_POST['prosessubmitproseshoper'][11];

    $timeproses = date("H:i:s");
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    PlanningNumber='$planningpengolahan' AND
                                                                    Years ='$planningyear' AND
                                                                    Items ='$noproses' AND
                                                                    ProductID ='$product' AND
                                                                    BatchNumber ='$batch' AND
                                                                    NoProses ='$noproses' AND
                                                                    NoTong ='$notong' AND
                                                                    Berat=0");
    if (mysqli_num_rows($sql) == 0) {
        $sql = mysqli_query($conn, "SELECT * FROM usage_decision WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    InspectionLot ='$prueflos' AND
                                                                    Lotyears ='$lotyear' AND
                                                                    NoProses ='$noproses'");
        if (mysqli_num_rows($sql) != 0) {
            $sql = mysqli_query($conn, "SELECT * FROM transaksi_hoper WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    PlanningNumber='$planningnumber' AND
                                                                    Years='$years' AND
                                                                    ProcessNumber ='$noproses' AND
                                                                    ContainerNumber='$container'");
            if (mysqli_num_rows($sql) == 0) {
                // ---START--- Pemotongan Stok Hopper
                $query = mysqli_query($conn, "SELECT StatsX FROM tbl_configuration WHERE Plant='$plant' AND UnitCode='$unitcode' AND Items=1");
                $r = mysqli_fetch_array($query);
                if ($r['StatsX'] == 'X') {
                    $query = mysqli_query($conn, "SELECT * FROM tbl_stockhouse WHERE Plant='$plant' AND 
                                                                                        UnitCode='$unitcode' AND 
                                                                                        UnitType='HOP' AND 
                                                                                        ProductID='$product' AND
                                                                                        BatchNumber='$batch'");
                    if (mysqli_num_rows($query) <> 0) {
                        $r = mysqli_fetch_array($query);
                        $stok = $r['Quantity'];
                        $update_stok = $stok - $qty;
                        if ($update_stok >= 0) {
                            // ---UPDATE STOK---
                            mysqli_query($conn, "UPDATE tbl_stockhouse SET Quantity='$update_stok' WHERE Plant='$plant' AND 
                                                                                                            UnitCode='$unitcode' AND 
                                                                                                            UnitType='HOP' AND 
                                                                                                            ProductID='$product' AND
                                                                                                            BatchNumber='$batch'");
                            // ----
                            $sql = mysqli_query($conn, "INSERT INTO transaksi_hoper (Plant,UnitCode,
                                                                                        PlanningNumber,
                                                                                        Years,
                                                                                        ProcessNumber,
                                                                                        ContainerNumber,
                                                                                        TimeExecuted,
                                                                                        Quantity,
                                                                                        CreatedBy,
                                                                                        CreatedOn)
                                                VALUES('$plant',
                                                        '$unitcode',
                                                        '$planningnumber',
                                                        '$years',
                                                        '$noproses',
                                                        '$container',
                                                        '$timeproses',
                                                        '$qty',
                                                        '$createdby',
                                                        '$createdon')");
                            if ($sql === true) {
                                $return = true;
                            }
                        } else {
                            $return = 4;
                        }
                    }
                } else {
                    $sql = mysqli_query($conn, "INSERT INTO transaksi_hoper (Plant,UnitCode,
                                                                            PlanningNumber,
                                                                            Years,
                                                                            ProcessNumber,
                                                                            ContainerNumber,
                                                                            TimeExecuted,
                                                                            Quantity,
                                                                            CreatedBy,
                                                                            CreatedOn)
                                                VALUES('$plant',
                                                        '$unitcode',
                                                        '$planningnumber',
                                                        '$years',
                                                        '$noproses',
                                                        '$container',
                                                        '$timeproses',
                                                        '$qty',
                                                        '$createdby',
                                                        '$createdon')");
                    if ($sql === true) {
                        $return = true;
                    }
                }
                // ---END---
            } else {
                $return = 'Label sudah ter SCAN';
            }
        } else {
            $return = 'Sedang dalam pengerjaan QC';
        }
    } else {
        $return = 'Label invalid';
    }
    echo $return;
}
if (isset($_POST['prosessubmitproseshoper2'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $return = false;
    $planningnumber = $_POST['prosessubmitproseshoper2'][0];
    $years = $_POST['prosessubmitproseshoper2'][1];
    $noproses = $_POST['prosessubmitproseshoper2'][2];
    $container = $_POST['prosessubmitproseshoper2'][3];
    $qty = $_POST['prosessubmitproseshoper2'][4];
    $prueflos = $_POST['prosessubmitproseshoper2'][5];
    $lotyear = $_POST['prosessubmitproseshoper2'][6];
    $product = $_POST['prosessubmitproseshoper2'][7];
    $batch = $_POST['prosessubmitproseshoper2'][8];
    $item = $_POST['prosessubmitproseshoper2'][9];
    $planningpengolahan = $_POST['prosessubmitproseshoper2'][10];
    $planningyear = $_POST['prosessubmitproseshoper2'][11];

    $timeproses = date("H:i:s");
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    PlanningNumber='$planningpengolahan' AND
                                                                    Years ='$planningyear' AND
                                                                    Items ='$noproses' AND
                                                                    ProductID ='$product' AND
                                                                    BatchNumber ='$batch' AND
                                                                    NoProses ='$noproses' AND
                                                                    NoTong ='$notong' AND
                                                                    Berat=0");
    if (mysqli_num_rows($sql) == 0) {
        $sql = mysqli_query($conn, "SELECT * FROM usage_decision WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    InspectionLot ='$prueflos' AND
                                                                    Lotyears ='$lotyear' AND
                                                                    NoProses ='$noproses'");
        if (mysqli_num_rows($sql) != 0) {
            $sql = mysqli_query($conn, "SELECT * FROM transaksi_hoper WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    PlanningNumber='$planningnumber' AND
                                                                    Years='$years' AND
                                                                    ProcessNumber ='$noproses' AND
                                                                    ContainerNumber='$container'");
            if (mysqli_num_rows($sql) == 0) {
                $sql = mysqli_query($conn, "INSERT INTO transaksi_hoper (Plant,UnitCode,
                                                                            PlanningNumber,
                                                                            Years,
                                                                            ProcessNumber,
                                                                            ContainerNumber,
                                                                            TimeExecuted,
                                                                            Quantity,
                                                                            CreatedBy,
                                                                            CreatedOn)
                                                VALUES('$plant',
                                                        '$unitcode',
                                                        '$planningnumber',
                                                        '$years',
                                                        '$noproses',
                                                        '$container',
                                                        '$timeproses',
                                                        '$qty',
                                                        '$createdby',
                                                        '$createdon')");
                if ($sql === true) {
                    $return = true;
                }
                // ---END---
            } else {
                $return = 'Label sudah ter SCAN';
            }
        } else {
            $return = 'Sedang dalam pengerjaan QC';
        }
    } else {
        $return = 'Label invalid';
    }
    echo $return;
}
if (isset($_POST['prosesdeleteproseshoper'])) {
    $dump[] = '';
    $planningnumber = $_POST['prosesdeleteproseshoper'][0];
    $prosesnumber = $_POST['prosesdeleteproseshoper'][1];
    $container = $_POST['prosesdeleteproseshoper'][2];
    $years = $_POST['prosesdeleteproseshoper'][3];
    $qty = $_POST['prosesdeleteproseshoper'][4];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    // ---START--- Pemotongan Stok Hopper
    $query = mysqli_query($conn, "SELECT ProductID,BatchNumber FROM planning_prod_header WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years'");
    if (mysqli_num_rows($query) <> 0) {
        $r = mysqli_fetch_array($query);
        $product = $r['ProductID'];
        $batch = $r['BatchNumber'];
    }
    $query = mysqli_query($conn, "SELECT StatsX FROM tbl_configuration WHERE Plant='$plant' AND UnitCode='$unitcode' AND Items=1");
    $r = mysqli_fetch_array($query);
    if ($r['StatsX'] == 'X') {
        $query = mysqli_query($conn, "SELECT * FROM tbl_stockhouse WHERE Plant='$plant' AND 
                                                                             UnitCode='$unitcode' AND 
                                                                             UnitType='HOP' AND 
                                                                             ProductID='$product' AND
                                                                             BatchNumber='$batch'");
        if (mysqli_num_rows($query) <> 0) {
            $r = mysqli_fetch_array($query);
            $stok = $r['Quantity'];
            $update_stok = $stok + $qty;
            if ($update_stok >= 0) {
                // ---UPDATE STOK---
                mysqli_query($conn, "UPDATE tbl_stockhouse SET Quantity='$update_stok' WHERE Plant='$plant' AND 
                                                                                                 UnitCode='$unitcode' AND 
                                                                                                 UnitType='HOP' AND 
                                                                                                 ProductID='$product' AND
                                                                                                 BatchNumber='$batch'");
                // ----
            }
        }
    }
    //  ---
    $sql = mysqli_query($conn, "DELETE FROM transaksi_hoper WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND 
                                                                    PlanningNumber='$planningnumber' AND 
                                                                    ProcessNumber='$prosesnumber' AND 
                                                                    ContainerNumber='$container' AND
                                                                    Years='$years'");
    if ($sql === true) {
        $dump['statuscode'] = true;
        $dump['planningnumber'] = $planningnumber;
    }
    echo json_encode($dump);
}
if (isset($_POST['prosessimpanproseshoper'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $return = false;
    $planningnumber = $_POST['prosessimpanproseshoper'][0];
    $pengawas = $_POST['prosessimpanproseshoper'][1];
    $years = $_POST['prosessimpanproseshoper'][2];
    $createdon = date("Y-m-d H:i:s");
    $sql = mysqli_query($conn, "SELECT ProsesHoper FROM planning_prod_header WHERE Plant='$plant' AND
                                                                                    UnitCode='$unitcode' AND
                                                                                    PlanningNumber='$planningnumber' AND
                                                                                    Years='$years'");
    $row = mysqli_fetch_array($sql);
    if ($row['ProsesHoper'] != 'X') {
        // setapproval($planningnumber, 'Hoper', $years);
        mysqli_query($conn, "UPDATE planning_prod_header SET ProsesHoper='X' WHERE Plant='$plant' AND
                                                                                    UnitCode='$unitcode' AND
                                                                                        PlanningNumber='$planningnumber' AND
                                                                                        Years='$years'");
        mysqli_query($conn, "UPDATE transaksi_hoper SET PengawasProduksi='$pengawas' WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                                PlanningNumber='$planningnumber' AND
                                                                                                Years='$years'");
        $return = true;
    }
    echo $return;
}
if (isset($_POST['proseschangevalueproseshoper'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $return = false;
    $planningnumber = $_POST['proseschangevalueproseshoper'][0];
    $years = $_POST['proseschangevalueproseshoper'][1];
    $prosesnumber = $_POST['proseschangevalueproseshoper'][2];
    $notong = $_POST['proseschangevalueproseshoper'][3];
    $type = $_POST['proseschangevalueproseshoper'][4];
    $value = $_POST['proseschangevalueproseshoper'][5];
    if ($type == 1) {
        $query = "UPDATE transaksi_hoper SET KondisiAyakan='$value' WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND
                                                                        Years='$years' AND
                                                                        ProcessNumber='$prosesnumber' AND
                                                                        ContainerNumber='$notong'";
    } else if ($type == 2) {
        $query = "UPDATE transaksi_hoper SET Kontaminasi='$value' WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND
                                                                        Years='$years' AND
                                                                        ProcessNumber='$prosesnumber' AND
                                                                        ContainerNumber='$notong'";
    }
    $sql = mysqli_query($conn, $query);
    if ($sql === true) {
        $return = true;
    }
}
if (isset($_POST['proseschangevalueenterproseshoper'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $return = false;
    $planningnumber = $_POST['proseschangevalueenterproseshoper'][0];
    $years = $_POST['proseschangevalueenterproseshoper'][1];
    $prosesnumber = $_POST['proseschangevalueenterproseshoper'][2];
    $notong = $_POST['proseschangevalueenterproseshoper'][3];
    $type = $_POST['proseschangevalueenterproseshoper'][4];
    $value = $_POST['proseschangevalueenterproseshoper'][5];
    if ($type == 1) {
        $query = "UPDATE transaksi_hoper SET JenisTemuan='$value' WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND
                                                                        Years='$years' AND
                                                                        ProcessNumber='$prosesnumber' AND
                                                                        ContainerNumber='$notong'";
    } else if ($type == 2) {
        $query = "UPDATE transaksi_hoper SET JumlahTemuan='$value' WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND
                                                                        Years='$years' AND
                                                                        ProcessNumber='$prosesnumber' AND
                                                                        ContainerNumber='$notong'";
    }
    $sql = mysqli_query($conn, $query);
    if ($sql === true) {
        $return = true;
    }
}

// ---------------------------------------------------------
// QC Result
// ---------------------------------------------------------
if (isset($_POST['prosesselectqcresult'])) {
    $dump[] = '';
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = trim($_POST['prosesselectqcresult'][0]);
    $years = $_POST['prosesselectqcresult'][1];
    $jenis = $_POST['prosesselectqcresult'][2];
    $batch = $_POST['prosesselectqcresult'][3];
    $noproses = $_POST['prosesselectqcresult'][4];
    $dump['planningnumber'] = $planningnumber;
    if ($jenis != 'Pengolahan') {
        $query = mysqli_query($conn, "SELECT A.ProductID,A.BatchNumber, B.ProductDescriptions,A.Years FROM planning_prod_header AS A INNER JOIN mara_product AS B ON A.ProductID = B.ProductID WHERE A.PlanningNumber='$planningnumber' AND
                                     A.Plant='$plant' AND A.UnitCode='$unitcode' AND A.Years='$years'");
        $q = mysqli_fetch_array($query);
        $dump['productid'] = $q['ProductID'];
        $dump['deskripsi'] = $q['ProductDescriptions'];
        $dump['batch'] = $q['BatchNumber'];
        $dump['years'] = $q['Years'];
    } else {
        $query = mysqli_query($conn, "SELECT A.ProductID, B.ProductDescriptions,A.Years FROM planning_pengolahan_detail AS A INNER JOIN mara_product AS B ON A.ProductID = B.ProductID WHERE A.PlanningNumber='$planningnumber' AND
                                     A.Plant='$plant' AND A.UnitCode='$unitcode' AND A.Years='$years'");
        $q = mysqli_fetch_array($query);
        $dump['productid'] = $q['ProductID'];
        $dump['deskripsi'] = $q['ProductDescriptions'];
        $dump['batch'] = $batch;
        $dump['years'] = $q['Years'];
        $dump['noproses'] = $noproses;
        // $sql = mysqli_query($conn,"SELECT BatchNumber FROM insp")
    }
    $sql = mysqli_query($conn, "SELECT * FROM qc_result WHERE Plant='$plant' AND
                                                                UnitCode='$unitcode' AND
                                                                 PlanningNumber='$planningnumber' AND 
                                                                 Types='$jenis' AND Years='$years' AND
                                                                 BatchNumber='$batch' AND NoProses='$noproses'");


    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_array($sql);
        $createdfor = $row['CreatedFor'];
        $dump['rh'] = $row['Rh'];
        $dump['suhu'] = $row['Suhu'];
        $dump['qc_name'] = '';
        if ($createdfor !== null) {
            $sql2 = mysqli_query($conn, "SELECT * FROM pa001 WHERE PersonnelNumber='$createdfor'");
            $r = mysqli_fetch_array($sql2);
            if (mysqli_num_rows($sql2) != 0) {
                $dump['qc_name'] =  $createdfor . ' - ' . $r['EmployeeName'];
            }
        }
        $dump['CreatedFor'] = $createdfor;
    }
    $dump['jenis'] = $jenis;
    $dump['return'] = $r;
    echo json_encode($dump);
}
if (isset($_POST['prosessimpanqcresult'])) {
    $return = false;
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosessimpanqcresult'][0];
    $rh = $_POST['prosessimpanqcresult'][1];
    $suhu = $_POST['prosessimpanqcresult'][2];
    $jenis = $_POST['prosessimpanqcresult'][3];
    $qc_name = $_POST['prosessimpanqcresult'][4];
    $years = $_POST['prosessimpanqcresult'][5];
    $bets = $_POST['prosessimpanqcresult'][6];
    $noproses = $_POST['prosessimpanqcresult'][7];

    $qc_name = explode(" ", $qc_name);
    $qc_name = $qc_name[0];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];
    $lastupdate = date("Y-m-d H:i:s");
    if ($noproses == '') {
        $sql = mysqli_query($conn, "SELECT * FROM qc_result WHERE Plant='$plant' AND 
                                                            UnitCode='$unitcode' AND 
                                                            PlanningNumber='$planningnumber' AND
                                                            Years='$years' AND
                                                             Types='$jenis'");
        if (mysqli_num_rows($sql) > 0) {
            $query = mysqli_query($conn, "UPDATE qc_result SET Rh='$rh', Suhu='$suhu', CreatedFor='$qc_name', ChangedOn='$changedon', ChangedBy='$changedby' 
                                        WHERE Plant='$plant' AND
                                            UnitCode='$unitcode' AND
                                             PlanningNumber='$planningnumber' AND 
                                             Years='$years' AND
                                             Types='$jenis' AND
                                             BatchNumber='$bets'");
        } else {
            $query = mysqli_query($conn, "INSERT INTO qc_result(Plant,
                                                            UnitCode,
                                                            PlanningNumber,
                                                            Years,Types,BatchNumber,Rh,Suhu,
                                                            CreatedFor,CreatedOn,
                                                            CreatedBy) 
                                    VALUES('$plant',
                                            '$unitcode',
                                            '$planningnumber',
                                            '$years',
                                            '$jenis',
                                            '$bets',
                                            '$rh',
                                            '$suhu',
                                            '$qc_name',
                                            '$createdon',
                                            '$createdby')");
        }
        if ($query === true) {
            $return = true;
        }
    } else {
        $sql = mysqli_query($conn, "SELECT * FROM qc_result WHERE Plant='$plant' AND 
                                                            UnitCode='$unitcode' AND 
                                                            PlanningNumber='$planningnumber' AND
                                                            Years='$years' AND
                                                             Types='$jenis' AND
                                                             BatchNumber='$bets' AND
                                                             NoProses='$noproses'");
        if (mysqli_num_rows($sql) > 0) {
            $query = mysqli_query($conn, "UPDATE qc_result SET Rh='$rh', Suhu='$suhu', CreatedFor='$qc_name', LastUpdate='$lastupdate' 
                                        WHERE Plant='$plant' AND
                                            UnitCode='$unitcode' AND
                                             PlanningNumber='$planningnumber' AND 
                                             Years='$years' AND
                                             Types='$jenis' AND
                                             BatchNumber='$bets' AND
                                             NoProses='$noproses'");
        } else {
            $query = mysqli_query($conn, "INSERT INTO qc_result(Plant,
                                                            UnitCode,
                                                            PlanningNumber,
                                                            Years,Types,BatchNumber,NoProses,LastUpdate,Rh,Suhu,
                                                            CreatedFor,CreatedOn,
                                                            CreatedBy) 
                                    VALUES('$plant',
                                            '$unitcode',
                                            '$planningnumber',
                                            '$years',
                                            '$jenis',
                                            '$bets',
                                            '$noproses',
                                            '$lastupdate',
                                            '$rh',
                                            '$suhu',
                                            '$qc_name',
                                            '$createdon',
                                            '$createdby')");
        }
        if ($query === true) {
            $return = true;
        }
    }
    echo $return;
}
if (isset($_POST['jenistransaksiqcresult'])) {
    $jenistransaksi = $_POST['jenistransaksiqcresult'];
    $dump[] = '';
    // if ($jenistransaksi == 'Hopper') {
    //     $sql = mysqli_query($conn, "SELECT Nilai FROM qc_characteristic WHERE KodeProses='HP01'");
    //     $suhu = mysqli_fetch_array($sql);
    //     $dump['suhu'] = '1. Syarat Suhu: ' . $suhu['Nilai'];
    //     $sql = mysqli_query($conn, "SELECT Nilai FROM qc_characteristic WHERE KodeProses='HP02'");
    //     $rh = mysqli_fetch_array($sql);
    //     $dump['rh'] = 'RH: ' . $rh['Nilai'];
    // } elseif ($jenistransaksi == 'Topack') {
    //     $sql = mysqli_query($conn, "SELECT Nilai FROM qc_characteristic WHERE KodeProses='TP01'");
    //     $suhu = mysqli_fetch_array($sql);
    //     $dump['suhu'] = '1. Syarat Suhu: ' . $suhu['Nilai'];
    //     $sql = mysqli_query($conn, "SELECT Nilai FROM qc_characteristic WHERE KodeProses='TP02'");
    //     $rh = mysqli_fetch_array($sql);
    //     $dump['rh'] = 'RH: ' . $rh['Nilai'];
    // }
    if ($jenistransaksi == 'Hopper') {
        $sql = mysqli_query($conn, "SELECT Nilai FROM qc_characteristic WHERE KodeProses='HP01'");
        $suhu = mysqli_fetch_array($sql);
        $dump['suhu'] = $suhu['Nilai'];
        $sql = mysqli_query($conn, "SELECT Nilai FROM qc_characteristic WHERE KodeProses='HP02'");
        $rh = mysqli_fetch_array($sql);
        $dump['rh'] = $rh['Nilai'];
    } elseif ($jenistransaksi == 'Topack') {
        $sql = mysqli_query($conn, "SELECT Nilai FROM qc_characteristic WHERE KodeProses='TP01'");
        $suhu = mysqli_fetch_array($sql);
        $dump['suhu'] = $suhu['Nilai'];
        $sql = mysqli_query($conn, "SELECT Nilai FROM qc_characteristic WHERE KodeProses='TP02'");
        $rh = mysqli_fetch_array($sql);
        $dump['rh'] = $rh['Nilai'];
    } elseif ($jenistransaksi == 'Pengolahan') {
        $sql = mysqli_query($conn, "SELECT Nilai FROM qc_characteristic WHERE KodeProses='P001'");
        $suhu = mysqli_fetch_array($sql);
        $dump['suhu'] = $suhu['Nilai'];
        $dump['rh'] = 'none';
    }
    $dump['qc_name'] = $_SESSION["personnelnumber"] . ' - ' . $_SESSION["employeename"];
    echo json_encode($dump);
}

// ---------------------------------------------------------
// QC Engine Set
// ---------------------------------------------------------
if (isset($_POST['prosesselectenginesetapproval'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $dump[] = '';
    $output = '';
    $i = 0;
    $planningnumber = $_POST['prosesselectenginesetapproval'][0];
    $years = $_POST['prosesselectenginesetapproval'][1];
    $dump['planningnumber'] = $planningnumber;
    $query = mysqli_query($conn, "SELECT A.ProductID,A.BatchNumber, B.ProductDescriptions,A.Years FROM planning_prod_header AS A 
                                    INNER JOIN mara_product AS B ON A.ProductID = B.ProductID 
                                            WHERE A.Plant='$plant' AND
                                            A.UnitCode='$unitcode' AND 
                                            A.PlanningNumber='$planningnumber' AND
                                            A.Years='$years'");
    $q = mysqli_fetch_array($query);
    $dump['productid'] = $q['ProductID'];
    $dump['deskripsi'] = $q['ProductDescriptions'];
    $dump['batch'] = $q['BatchNumber'];
    $dump['years'] = $q['Years'];
    $sql = mysqli_query($conn, "SELECT * FROM qc_machine_engine WHERE PlanningNumber='$planningnumber'");
    $row = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['stats1'] = $row['Spec1'];
        $dump['stats2'] = $row['Spec2'];
        $dump['stats3'] = $row['Spec3'];
        $dump['stats4'] = $row['Spec4'];
    }
    echo json_encode($dump);
}
if (isset($_POST['prosessimpanenginesetapproval'])) {
    $return = false;
    $planningnumber = $_POST['prosessimpanenginesetapproval'][0];
    $stats1 = $_POST['prosessimpanenginesetapproval'][1];
    $stats2 = $_POST['prosessimpanenginesetapproval'][2];
    $stats3 = $_POST['prosessimpanenginesetapproval'][3];
    $stats4 = $_POST['prosessimpanenginesetapproval'][4];
    $years = $_POST['prosessimpanenginesetapproval'][5];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $codegroup = '';
    $jampemeriksaan = date("H:i:s");
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT * FROM qc_machine_engine WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                     PlanningNumber='$planningnumber' AND
                                                                     Years='$years'");
    if (mysqli_num_rows($sql) > 0) {
        $query = mysqli_query($conn, "UPDATE qc_machine_engine SET JamPemeriksaan='$jampemeriksaan', 
                                        Spec1='$stats1',Spec2='$stats2',Spec3='$stats3',Spec4='$stats4',
                                        ChangedOn='$changedon', ChangedBy='$changedby' 
                                        WHERE Plant='$plant' AND
                                        UnitCode='$unitcode' AND
                                        PlanningNumber='$planningnumber' AND
                                        Years='$years'");
    } else {
        $query = mysqli_query($conn, "INSERT INTO qc_machine_engine(Plant,UnitCode,PlanningNumber,Years,JamPemeriksaan,Spec1,Spec2,Spec3,Spec4,CreatedOn,CreatedBy)
        VALUES('$plant','$unitcode','$planningnumber','$years','$jampemeriksaan','$stats1','$stats2','$stats3','$stats4','$createdon','$createdby')");
    }
    if ($query === true) {
        // Validasi Jika Lulus semua, bisa lanjut ke proses selanjutnya.
        $sql = mysqli_query($conn, "SELECT EngineSetApproval FROM general_setting_web WHERE UnitCode='$unitcode'");
        $r = mysqli_fetch_array($sql);
        if (mysqli_num_rows($sql) > 0) {
            $sql = mysqli_query($conn, "SELECT Descriptions FROM qc_catalog WHERE KodeCatalog='$r[EngineSetApproval]' AND Item='10'");
            $r = mysqli_fetch_array($sql);
            $codegroup = $r['Descriptions'];
        }
        if ($stats1 == $codegroup || $stats2 == $codegroup || $stats3 == $codegroup || $stats4 == $codegroup) {
            mysqli_query($conn, "UPDATE planning_prod_header SET ApprovalQC='X' WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                PlanningNumber='$planningnumber' AND
                                                                                Years='$years'");
        }
        $return = true;
    }
    echo $return;
}

// ---------------------------------------------------------
// Analisa Pengemasan Primer
// ---------------------------------------------------------
if (isset($_POST['prosesselectpengemasanprimer'])) {
    $button = false;
    $dump[] = '';
    $planningnumber = $_POST['prosesselectpengemasanprimer'][0];
    $years = $_POST['prosesselectpengemasanprimer'][1];
    $dump['planningnumber'] = $planningnumber;
    $query = mysqli_query($conn, "SELECT A.ProductID,A.BatchNumber,A.ExpiredDate,A.ProcessNumber,A.MixingDate,A.ResourceID,A.ResourceIDMix, B.ProductDescriptions,B.BobotTimbang,A.Years,C.SecondaryResourceID FROM planning_prod_header AS A 
                                    INNER JOIN mara_product AS B ON A.ProductID = B.ProductID
                                    INNER JOIN crhd AS C ON A.ResourceID = C.ResourceID 
                                            WHERE A.Plant='$plant' AND
                                            A.UnitCode='$unitcode' AND 
                                            A.PlanningNumber='$planningnumber' AND
                                            A.Years='$years'");
    $q = mysqli_fetch_array($query);
    $dump['productid'] = $q['ProductID'];
    $dump['deskripsi'] = $q['ProductDescriptions'];
    $dump['batch'] = $q['BatchNumber'];
    $dump['years'] = $q['Years'];
    $dump['mixingdate'] = $q['MixingDate'];
    $dump['mesintopack'] = $q['SecondaryResourceID'];
    $dump['nomesin'] = $q['ResourceIDMix'];
    $dump['rangebobot'] = $q['BobotTimbang'];
    $dump['noproses'] = $q['ProcessNumber'];
    $dump['prod'] = $q['ProductID'] . '/ ' . date('F Y', strtotime($q['ExpiredDate'])) . '/ ' . $q['BatchNumber'];

    $query = mysqli_query($conn, "SELECT A.TingkatInspeksi,
                                            A.JmlContohFrek,
                                            A.SchSetiap,
                                            A.JumlahContoh,
                                            A.CatatanPemasok,
                                            -- A.PemasokNoroll,
                                            A.Kesimpulan,
                                            A.Ass_IPC,
                                            A.Koor_IPC,
                                            A.ShiftID,
                                            -- B.JumlahContoh AS JmlContohFrek,
                                            B.TingkatTerima,
                                            B.LulusTolak
                                         FROM qc_analisapengemasanprimer_header AS A 
                                                INNER JOIN master_military_std AS B
                                                ON A.TingkatInspeksi = B.TingkatInspec 
                                                WHERE A.Plant='$plant' AND
                                                        A.UnitCode='$unitcode' AND
                                                        A.PlanningNumber='$planningnumber' AND
                                                        A.Years='$years'");
    if (mysqli_num_rows($query) != 0) {
        $r = mysqli_fetch_array($query);
        $dump['tingkatinspeksi'] = $r['TingkatInspeksi'];
        $dump['jmlcontohfrek'] = $r['JmlContohFrek'];
        $dump['schsetiap'] = $r['SchSetiap'];
        $dump['jmlcontoh'] = $r['JumlahContoh'];
        $dump['catatanpemasok'] = $r['CatatanPemasok'];
        // $dump['pemasokroll'] = $r['PemasokNoroll'];
        $dump['kesimpulan'] = $r['Kesimpulan'];
        $dump['lulustolak'] = $r['LulusTolak'];
        include_once 'getvalue.php';
        $dump['assqc'] = $r['Ass_IPC'] . ' - ' . Getdata('EmployeeName', 'pa001', 'PersonnelNumber ', $r['Ass_IPC']);
        $dump['koorqc'] = $r['Koor_IPC'] . ' - ' . Getdata('EmployeeName', 'pa001', 'PersonnelNumber ', $r['Koor_IPC']);
        $dump['shiftid'] = $r['ShiftID'];
        if ($r['SchSetiap'] == '15') {
            $dump['brpmesin'] = 1;
        } else {
            $dump['brpmesin'] = 2;
        }
        // $query = mysqli_query($conn, "SELECT A.PemasokNoroll,B.Descriptions FROM qc_analisapengemasanprimer_one_detail AS A
        //                                     INNER JOIN data_pemasok AS B 
        //                                     ON B.Idpemasok = A.PemasokNoroll WHERE A.Plant='$plant' AND A.UnitCode='$unitcode' AND 
        //                                                                                                         A.PlanningNumber='$planningnumber' AND
        //                                                                                                         A.Years='$years'");
        // if (mysqli_num_rows($query) != 0) {
        //     $r = mysqli_fetch_array($query);
        //     $dump['pemasokroll'] = $r['PemasokNoroll'] . ' - ' . $r['Descriptions'];
        // }
        $button = true;
    }
    $dump['button'] = $button;
    echo json_encode($dump);
}
if (isset($_POST['prosesselecttingkatinspeksi'])) {
    $dump[] = '';
    $tingkatinspeksi = $_POST['prosesselecttingkatinspeksi'];

    $sql = mysqli_query($conn, "SELECT * FROM master_military_std WHERE Plant='$plant' AND TingkatInspec ='$tingkatinspeksi'");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $dump['jumlahcontoh'] = $r['JumlahContoh'];
        $dump['tingkatterima'] = $r['TingkatTerima'];
        $dump['lulustolak'] = $r['LulusTolak'];
    }
    echo json_encode($dump);
}
if (isset($_POST['prosessubmitanalisapengemasanprimer_one'])) {
    $return = false;
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];
    $planningnumber = $_POST['prosessubmitanalisapengemasanprimer_one'][0];
    $years = $_POST['prosessubmitanalisapengemasanprimer_one'][1];
    $tingkatinspeksi = $_POST['prosessubmitanalisapengemasanprimer_one'][2];
    $jmlhcontohperfrekuensi = $_POST['prosessubmitanalisapengemasanprimer_one'][3];
    $schsetiap = $_POST['prosessubmitanalisapengemasanprimer_one'][4];
    $jam = $_POST['prosessubmitanalisapengemasanprimer_one'][5];
    $tglmixing = $_POST['prosessubmitanalisapengemasanprimer_one'][6];
    $nomesindm = $_POST['prosessubmitanalisapengemasanprimer_one'][7];
    $nodm = $_POST['prosessubmitanalisapengemasanprimer_one'][8];
    $pemasok = $_POST['prosessubmitanalisapengemasanprimer_one'][9];
    $schtidakrapi = $_POST['prosessubmitanalisapengemasanprimer_one'][10];
    $misregister = $_POST['prosessubmitanalisapengemasanprimer_one'][11];
    $tdkadaeyecut = $_POST['prosessubmitanalisapengemasanprimer_one'][12];
    $posisisalaheyecut = $_POST['prosessubmitanalisapengemasanprimer_one'][13];
    $tdkadakodeproduk = $_POST['prosessubmitanalisapengemasanprimer_one'][14];
    $posisisalahkodeproduk = $_POST['prosessubmitanalisapengemasanprimer_one'][15];
    $salahkodeproduk = $_POST['prosessubmitanalisapengemasanprimer_one'][16];
    $misprintkodeproduk = $_POST['prosessubmitanalisapengemasanprimer_one'][17];
    $tdkadaembos = $_POST['prosessubmitanalisapengemasanprimer_one'][18];
    $posisisalahembos = $_POST['prosessubmitanalisapengemasanprimer_one'][19];
    $tdkjelasembos = $_POST['prosessubmitanalisapengemasanprimer_one'][20];
    $kurangkekembungan = $_POST['prosessubmitanalisapengemasanprimer_one'][21];
    $lebihkekembungan = $_POST['prosessubmitanalisapengemasanprimer_one'][22];
    $tidakngesealkondisiseal = $_POST['prosessubmitanalisapengemasanprimer_one'][23];
    $haluskondisiseal = $_POST['prosessubmitanalisapengemasanprimer_one'][24];
    $pisaupotong = $_POST['prosessubmitanalisapengemasanprimer_one'][25];
    $bobot = $_POST['prosessubmitanalisapengemasanprimer_one'][26];
    $catatan = $_POST['prosessubmitanalisapengemasanprimer_one'][27];
    $jumlahcontoh = $_POST['prosessubmitanalisapengemasanprimer_one'][28];
    $catatanpemasok = $_POST['prosessubmitanalisapengemasanprimer_one'][29];
    $kesimpulan = $_POST['prosessubmitanalisapengemasanprimer_one'][30];
    $assqc = $_POST['prosessubmitanalisapengemasanprimer_one'][31];
    $koorqc = $_POST['prosessubmitanalisapengemasanprimer_one'][32];
    $shift = $_POST['prosessubmitanalisapengemasanprimer_one'][33];
    $assqc_convert = explode(" ", $assqc);
    $assqc = $assqc_convert[0];
    $koorqc_convert = explode(" ", $koorqc);
    $koorqc = $koorqc_convert[0];

    // Insert Header
    $query = mysqli_query($conn, "SELECT PlanningNumber FROM qc_analisapengemasanprimer_header WHERE Plant='$plant' AND
                                                                                    UnitCode='$unitcode' AND
                                                                                    PlanningNumber='$planningnumber' AND
                                                                                    Years='$years'");
    if (mysqli_num_rows($sql) == 0) {
        $sql = mysqli_query($conn, "INSERT INTO qc_analisapengemasanprimer_header (Plant,
                                                                                UnitCode,
                                                                                PlanningNumber,
                                                                                Years,
                                                                                TingkatInspeksi,
                                                                                JmlContohFrek,
                                                                                SchSetiap,
                                                                                JumlahContoh,
                                                                                CatatanPemasok,
                                                                                Kesimpulan,
                                                                                Ass_IPC,
                                                                                Koor_IPC,
                                                                                ShiftID,
                                                                                CreatedOn,
                                                                                CreatedBy)
                                                                                VALUES ('$plant',
                                                                                        '$unitcode',
                                                                                        '$planningnumber',
                                                                                        '$years',
                                                                                        '$tingkatinspeksi',
                                                                                        '$jmlhcontohperfrekuensi',
                                                                                        '$schsetiap',
                                                                                        '$jumlahcontoh',
                                                                                        '$catatanpemasok',
                                                                                        '$kesimpulan',
                                                                                        '$assqc',
                                                                                        '$koorqc',
                                                                                        '$shift',
                                                                                        '$createdon',
                                                                                        '$createdby')");
        $status = true;
    } else {
        $sql =  mysqli_query($conn, "UPDATE qc_analisapengemasanprimer_header SET TingkatInspeksi='$tingkatinspeksi', 
                                                                            JmlContohFrek='$jmlhcontohperfrekuensi',
                                                                            SchSetiap='$schsetiap',
                                                                            JumlahContoh='$jumlahcontoh',
                                                                            CatatanPemasok='$catatanpemasok',
                                                                            Kesimpulan='$kesimpulan',
                                                                            Ass_IPC='$assqc',
                                                                            Koor_IPC='$koorqc',
                                                                            ShiftID='$shift',
                                                                            ChangedOn='$changedon',
                                                                            ChangedBy='$changedby'
                                                                            WHERE Plant='$plant' AND
                                                                                    UnitCode='$unitcode' AND
                                                                                    PlanningNumber='$planningnumber' AND
                                                                                    Years='$years'");
        $status = true;
    }
    if ($status == true) {
        include_once 'getvalue.php';
        $pemasok = GetdataII('Idpemasok', 'data_pemasok', 'Plant', $plant, 'Descriptions', $pemasok);

        $sql = mysqli_query($conn, "SELECT PlanningNumber FROM qc_analisapengemasanprimer_one_detail WHERE Plant='$plant' AND
                                                                                    UnitCode='$unitcode' AND
                                                                                    PlanningNumber='$planningnumber' AND
                                                                                    Years='$years' AND
                                                                                    Jam='$jam'");
        if (mysqli_num_rows($sql) == 0) {
            $query = mysqli_query($conn, "INSERT INTO qc_analisapengemasanprimer_one_detail(Plant,
                                                                        UnitCode,
                                                                        PlanningNumber,
                                                                        Years,
                                                                        Jam,
                                                                        TglFBD,
                                                                        NoMesinDM,
                                                                        NoDM,
                                                                        PemasokNoroll,
                                                                        Schtdkrapi,
                                                                        Misregister,
                                                                        Eyecut_tdkada,
                                                                        Eyecut_posisisalah,
                                                                        Kodeproduk_tdkada,
                                                                        Kodeproduk_posisisalah,
                                                                        Kodeproduk_salah,
                                                                        Kodeproduk_misprint,
                                                                        Embos_tdkada,
                                                                        Embos_posisisalah,
                                                                        Embos_tdkjelas,
                                                                        Kekembungan_kurang,
                                                                        Kekembungan_lebih,
                                                                        Ngeseal_tdkngeseal,
                                                                        Ngeseal_halus,
                                                                        PisauPotong,
                                                                        Bobot,
                                                                        Catatan,
                                                                        CreatedOn,
                                                                        CreatedBy)
                                                                        VALUES('$plant',
                                                                                '$unitcode',
                                                                                '$planningnumber',
                                                                                '$years',
                                                                                '$jam',
                                                                                '$tglmixing',
                                                                                '$nomesindm',
                                                                                '$nodm',
                                                                                '$pemasok',
                                                                                '$schtidakrapi',
                                                                                '$misregister',
                                                                                '$tdkadaeyecut',
                                                                                '$posisisalaheyecut',
                                                                                '$tdkadakodeproduk',
                                                                                '$posisisalahkodeproduk',
                                                                                '$salahkodeproduk',
                                                                                '$misprintkodeproduk',
                                                                                '$tdkadaembos',
                                                                                '$posisisalahembos',
                                                                                '$tdkjelasembos',
                                                                                '$kurangkekembungan',
                                                                                '$lebihkekembungan',
                                                                                '$tidakngesealkondisiseal',
                                                                                '$haluskondisiseal',
                                                                                '$pisaupotong',
                                                                                '$bobot',
                                                                                '$catatan',
                                                                                '$createdon',
                                                                                '$createdby')");

            if ($query === true) {
                $return = true;
            }
        }
    }
    $data = [
        "pemasok" => $pemasok,
        "id" => $planningnumber,
        "return" => $return
    ];
    echo json_encode($data);
}
if (isset($_POST['showtableanalisakemasanprimer'])) {
    $planningnumber = $_POST['showtableanalisakemasanprimer'][0];
    $years = $_POST['showtableanalisakemasanprimer'][1];

    $jumlahcontoh = 0;
    $tingkatinsp = 'I';
    $jmcontohfrek = 0;
    $schsetiap = '15';
    $jumlahcontoh = 0;
    $catatanpemasok = 0;
    $kesimpulan = '';
    $button_selesai = false;
    $query = mysqli_query($conn, "SELECT * FROM qc_analisapengemasanprimer_header WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            PlanningNumber='$planningnumber' AND
                                                                                            Years='$years'");
    if (mysqli_num_rows($query) != 0) {
        $r = mysqli_fetch_array($query);
        $tingkatinsp = $r['TingkatInspeksi'];
        $jmcontohfrek = $r['JmlContohFrek'];
        $schsetiap = $r['SchSetiap'];
        $jumlahcontoh = $r['JumlahContoh'];
        $catatanpemasok = $r['CatatanPemasok'];
        $kesimpulan = $r['Kesimpulan'];
        $jumlahcontoh2 = $r['JumlahContoh2'];
        $kesimpulan2 = $r['Kesimpulan2'];
        include_once 'getvalue.php';
        $descriptions = GetdataII('Descriptions', 'qc_catalog', 'KodeCatalog', $kesimpulan, 'Item', 0);
        $descriptions2 = GetdataII('Descriptions', 'qc_catalog', 'KodeCatalog', $kesimpulan, 'Item', 0);
        $button_selesai = true;
    }
    $output = '';
    $output = '
                <table class="table table-sm table-bordered" style="border: 2px solid black; font-size: 7pt !important;">
                    <thead class="bg-secondary text-white">
                        <tr style="text-align: center; vertical-align: middle;">
                            <th rowspan="2">Jam</th>
                            <th rowspan="2">Tgl<br>FBD</th>
                            <th rowspan="2">No<br>Mesin<br>DM</th>
                            <th rowspan="2">No<br>DM</th>
                            <th rowspan="2">Pemasok/No<br>Roll</th>
                            <th rowspan="2">Sch<br>Tdk<br>Rapi</th>
                            <th rowspan="2">Mis<br>register</th>
                            <th colspan="2">Eye cut</th>
                            <th colspan="4">Kode Produk</th>
                            <th colspan="3">Embos sachet</th>
                            <th colspan="2">Tingkat<br>kekembungan<br>sachet</th>
                            <th colspan="2">kondisi seal sachet</th>
                            <th rowspan="2">pisau<br>potong<br>sch tdk<br>tajam</th>
                            <th rowspan="2">bobot<br>-/+</th>
                            <th rowspan="2">Catatan<br>Ketidakse<br>suaian dan<br>tindakan perbaikan</th>
                        </tr>
                        <tr style="text-align: center; vertical-align: middle;">
                            <th>Tdk<br>Ada</th>
                            <th>Posisi<br>Salah</th>
                            <th>Tdk<br>Ada</th>
                            <th>Posisi<br>Salah</th>
                            <th>Salah</th>
                            <th>Mis<br>print</th>
                            <th>Tdk<br>Ada</th>
                            <th>Posisi<br>salah</th>
                            <th>Tdk<br>Jelas</th>
                            <th>Kurang</th>
                            <th>Lebih</th>
                            <th>Tdk<br>Ngeseal</th>
                            <th>Halus</th>
                        </tr>
                    </thead>
                    <tbody>';
    $sql = mysqli_query($conn, "SELECT * FROM qc_analisapengemasanprimer_one_detail WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            PlanningNumber='$planningnumber' AND
                                                                                            Years='$years'");
    while ($r = mysqli_fetch_array($sql)) {
        $output .= '
                        <tr>
                            <td><a href="#" class="badge bg-transparent href_transform" title="Hapus data tersebut?" onclick="deleteanalisapengemasanprimer_one(' . $planningnumber . ',' . $years . ',' . $r['IndexRow'] . ')"><img src="../asset/img/delete.png"></a>' . $r['Jam'] . '</td>
                            <td>' . $r['TglFBD'] . '</td>
                            <td>' . $r['NoMesinDM'] . '</td>
                            <td>' . $r['NoDM'] . '</td>
                            <td>' . $r['PemasokNoroll'] . '</td>
                            <td>' . $r['Schtdkrapi'] . '</td>
                            <td>' . $r['Misregister'] . '</td>
                            <td>' . $r['Eyecut_tdkada'] . '</td>
                            <td>' . $r['Eyecut_posisisalah'] . '</td>
                            <td>' . $r['Kodeproduk_tdkada'] . '</td>
                            <td>' . $r['Kodeproduk_posisisalah'] . '</td>
                            <td>' . $r['Kodeproduk_salah'] . '</td>
                            <td>' . $r['Kodeproduk_misprint'] . '</td>
                            <td>' . $r['Embos_tdkada'] . '</td>
                            <td>' . $r['Embos_posisisalah'] . '</td>
                            <td>' . $r['Embos_tdkjelas'] . '</td>
                            <td>' . $r['Kekembungan_kurang'] . '</td>
                            <td>' . $r['Kekembungan_lebih'] . '</td>
                            <td>' . $r['Ngeseal_tdkngeseal'] . '</td>
                            <td>' . $r['Ngeseal_halus'] . '</td>
                            <td>' . $r['PisauPotong'] . '</td>
                            <td>' . $r['Bobot'] . '</td>
                            <td>' . $r['Catatan'] . '</td>
                        </tr>
        ';
    }
    $output .= '
                        </tbody>
                </table>
                    <table class="table table-sm table-bordered w-75 fw-bold" id="showtableid">
                        <tr>
                            <td>Jumlah Contoh</td>
                            <td><input type="number" class="form-control form-control-sm" id="jumlahcontohbawahpengemasanprimer" min="0" value="' . $jumlahcontoh . '"></td>
                            <td>Kesimpulan</td>
                            <td>
                                <select id="kesimpulanpengemasanprimer" class=" form-control form-select-sm">';
    if ($kesimpulan == '') {
        $sql = mysqli_query($conn, "SELECT * FROM qc_catalog WHERE Item=0");
        if (mysqli_num_rows($sql) != 0) {
            while ($r = mysqli_fetch_array($sql)) {
                $output .= '
                                            <option value="' . $r['KodeCatalog'] . '">' . $r['Descriptions'] . '</option>';
            }
        }
    } else {
        $sql = mysqli_query($conn, "SELECT * FROM qc_catalog WHERE Item=0 AND KodeCatalog !='$kesimpulan'");
        if (mysqli_num_rows($sql) != 0) {

            $output .= '<option value="' . $kesimpulan . '">' . $descriptions . '</option>';
            while ($r = mysqli_fetch_array($sql)) {
                $output .= '
                                            <option value="' . $r['KodeCatalog'] . '">' . $r['Descriptions'] . '</option>';
            }
        }
    }
    $output .= '
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Catatan: Pemasok Kemasan 1</td>
                            <td colspan=2><input type="text" class="form-control form-control-sm bg-transparent" id="kemasanpertamapengemasanprimer" readonly></td>
                        </tr>
                    </table>
    ';

    $output2 = '
                <table class="table table-sm table-bordered text-center" style="border: 2px solid black; font-style: 7pt !important;">
                    <thead class="bg-secondary text-white">
                        <tr style="vertical-align: middle">
                            <th rowspan="2">Jam</th>
                            <th rowspan="2">Top</th>
                            <th rowspan="2">Vert1</th>
                            <th rowspan="2">Vert2</th>
                            <th rowspan="2">Hori</th>
                            <th rowspan="2">Center</th>
                            <th rowspan="2">L.J</th>
                            <th colspan=2>Cek Kontaminan</th>
                            <th rowspan="2">Catatan</th>
                        </tr>
                        <tr>
                            <th>Ada</th>
                            <th># Ada</th>
                        </tr>
                    </thead>
                    <tbody>';
    $sql = mysqli_query($conn, "SELECT * FROM qc_analisapengemasanprimer_two_detail WHERE Plant='$plant' AND 
                                                                                                            UnitCode='$unitcode' AND
                                                                                                            PlanningNumber='$planningnumber' AND
                                                                                                            Years='$years'");
    while ($r = mysqli_fetch_array($sql)) {
        $output2 .= '
                        <tr>
                            <td><a href="#" class="badge bg-transparent href_transform" title="Hapus data tersebut?" onclick="deleteanalisapengemasanprimer_two(' . $planningnumber . ',' . $years . ',' . $r['IndexRow'] . ')"><img src="../asset/img/delete.png"></a>' . $r['Jam'] . '</td>
                            <td>' . $r['Tops'] . '</td>
                            <td>' . $r['Vert1'] . '</td>
                            <td>' . $r['Vert2'] . '</td>
                            <td>' . $r['Hori'] . '</td>
                            <td>' . $r['Centre'] . '</td>
                            <td>' . $r['Lj'] . '</td>
                            <td>' . $r['AdaKontaminan'] . '</td>
                            <td>' . $r['TdkAdaKontaminan'] . '</td>
                            <td style="width:30%">' . $r['Catatan'] . '</td>
                        </tr>';
    }

    $output2 .=
        '</tbody>
                </table>
                    <table class="table table-sm table-bordered w-25 fw-bold" id="showtableid2">
                        <tr>
                            <td>Jumlah Contoh</td>
                            <td><input type="number" class="form-control form-control-sm" id="jumlahcontoh2bawahpengemasanprimer" min="0" value="' . $jumlahcontoh2 . '"></td>
                        </tr>
                        <tr>
                            <td>Kesimpulan</td>
                            <td>
                                <select id="kesimpulan2pengemasanprimer" class=" form-control form-select-sm">';
    if ($kesimpulan2 == '') {
        $sql = mysqli_query($conn, "SELECT * FROM qc_catalog WHERE Item=0");
        if (mysqli_num_rows($sql) != 0) {
            while ($r = mysqli_fetch_array($sql)) {
                $output2 .= '
                                            <option value="' . $r['KodeCatalog'] . '">' . $r['Descriptions'] . '</option>';
            }
        }
    } else {
        $sql = mysqli_query($conn, "SELECT * FROM qc_catalog WHERE Item=0 AND KodeCatalog !='$kesimpulan2'");
        if (mysqli_num_rows($sql) != 0) {

            $output2 .= '<option value="' . $kesimpulan2 . '">' . $descriptions2 . '</option>';
            while ($r = mysqli_fetch_array($sql)) {
                $output2 .= '
                                            <option value="' . $r['KodeCatalog'] . '">' . $r['Descriptions'] . '</option>';
            }
        }
    }
    $output2 .= '
                                </select>
                            </td>
                        </tr>
                    </table>
    ';

    $output3 = '
                <table class="table table-sm table-bordered text-center">
                    <thead class="bg-secondary text-white">
                        <th>No</th>
                        <th>Jam</th>
                        <th style="width: 30%;">Keterangan</th>
                        <th style="width: 50%;">Contoh Sachet</th>
                    </thead>
                    <tbody>';
    $query = mysqli_query($conn, "SELECT Directions FROM master_directions WHERE Plant='$plant' AND UnitCode='$unitcode' AND Items=1");
    $r = mysqli_fetch_array($query);
    $dir = $r['Directions'];
    $sql = mysqli_query($conn, "SELECT * FROM qc_analisapengemasanprimer_three_detail WHERE Plant='$plant' AND 
                                                                                            UnitCode='$unitcode' AND
                                                                                            PlanningNumber='$planningnumber' AND
                                                                                            Years='$years'");
    $i = 1;
    while ($r = mysqli_fetch_array($sql)) {
        $output3 .= '
                        <tr>
                            <td><a href="#" class="badge bg-transparent href_transform" title="Hapus data tersebut?" onclick="deleteanalisapengemasanprimer_three(' . $planningnumber . ',' . $years . ',' . $r['IndexRow'] . ')"><img src="../asset/img/delete.png"></a>' . $i . '</td>
                            <td>' . $r['Jam'] . '</td>
                            <td>' . $r['Keterangan'] . '</td>
                            <td style="text-align:center"><img src="' . $dir . $r['GambarSachet'] . '" class="img-thumbnail gambarzoom" style="width:20%"></td>
                        </tr>';
        $i += 1;
    }

    $output3 .=
        '</tbody>
                </table>
    ';

    // $sql = mysqli_query($conn,"SELECT * FROM qc_analisapengemasanprimer_header ")
    $dump['output1'] = $output;
    $dump['output2'] = $output2;
    $dump['output3'] = $output3;
    $dump['buttonselesai'] = $button_selesai;
    echo json_encode($dump);
}
if (isset($_POST['prosesdeleteanalisapengemasanprimer_one'])) {
    $return = false;
    $planningnumber = $_POST['prosesdeleteanalisapengemasanprimer_one'][0];
    $years = $_POST['prosesdeleteanalisapengemasanprimer_one'][1];
    $indexrow = $_POST['prosesdeleteanalisapengemasanprimer_one'][2];

    $sql = mysqli_query($conn, "SELECT * FROM qc_analisapengemasanprimer_one_detail WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            PlanningNumber='$planningnumber' AND
                                                                                            Years='$years' AND
                                                                                            IndexRow='$indexrow'");
    if (mysqli_num_rows($sql) <> 0) {
        mysqli_query($conn, "DELETE FROM qc_analisapengemasanprimer_one_detail WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            PlanningNumber='$planningnumber' AND
                                                                                            Years='$years' AND
                                                                                            IndexRow='$indexrow'");

        $sql = mysqli_query($conn, "SELECT * FROM qc_analisapengemasanprimer_one_detail WHERE Plant='$plant' AND
                                                                                        UnitCode='$unitcode' AND
                                                                                        PlanningNumber='$planningnumber' AND
                                                                                        Years='$years'");
        if (mysqli_num_rows($sql) == 0) {
            mysqli_query($conn, "DELETE FROM qc_analisapengemasanprimer_header WHERE Plant='$plant' AND
                                                                                        UnitCode='$unitcode' AND
                                                                                        PlanningNumber='$planningnumber' AND
                                                                                        Years='$years'");
        }
        $return = true;
    }
    echo $return;
}
if (isset($_POST['prosesdeleteanalisapengemasanprimer_two'])) {
    $return = false;
    $planningnumber = $_POST['prosesdeleteanalisapengemasanprimer_two'][0];
    $years = $_POST['prosesdeleteanalisapengemasanprimer_two'][1];
    $indexrow = $_POST['prosesdeleteanalisapengemasanprimer_two'][2];

    $sql = mysqli_query($conn, "SELECT * FROM qc_analisapengemasanprimer_two_detail WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            PlanningNumber='$planningnumber' AND
                                                                                            Years='$years' AND
                                                                                            IndexRow='$indexrow'");
    if (mysqli_num_rows($sql) != 0) {
        mysqli_query($conn, "DELETE FROM qc_analisapengemasanprimer_two_detail WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            PlanningNumber='$planningnumber' AND
                                                                                            Years='$years' AND
                                                                                            IndexRow='$indexrow'");

        // $sql = mysqli_query($conn, "SELECT * FROM qc_analisapengemasanprimer_two_detail WHERE Plant='$plant' AND
        //                                                                                 UnitCode='$unitcode' AND
        //                                                                                 PlanningNumber='$planningnumber' AND
        //                                                                                 Years='$years'");
        // if (mysqli_num_rows($sql) == 0) {
        //     mysqli_query($conn, "DELETE FROM qc_analisapengemasanprimer_header WHERE Plant='$plant' AND
        //                                                                                 UnitCode='$unitcode' AND
        //                                                                                 PlanningNumber='$planningnumber' AND
        //                                                                                 Years='$years'");
        // }
        $return = true;
    }
    echo $return;
}
if (isset($_POST['prosesdeleteanalisapengemasanprimer_three'])) {
    $return = false;
    $planningnumber = $_POST['prosesdeleteanalisapengemasanprimer_three'][0];
    $years = $_POST['prosesdeleteanalisapengemasanprimer_three'][1];
    $indexrow = $_POST['prosesdeleteanalisapengemasanprimer_three'][2];

    $sql = mysqli_query($conn, "SELECT * FROM qc_analisapengemasanprimer_three_detail WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            PlanningNumber='$planningnumber' AND
                                                                                            Years='$years' AND
                                                                                            IndexRow ='$indexrow'");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $gambarsachet = $r['GambarSachet'];
        $query = mysqli_query($conn, "DELETE FROM qc_analisapengemasanprimer_three_detail WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            PlanningNumber='$planningnumber' AND
                                                                                            Years='$years' AND
                                                                                            IndexRow ='$indexrow'");

        if ($query === true) {
            $sql = mysqli_query($conn, "SELECT * FROM master_directions WHERE Plant='$plant' AND UnitCode='$unitcode' AND Items=1");
            $r = mysqli_fetch_array($sql);
            $dir = $r['Directions'];
            unlink($dir . $gambarsachet);
            $return = true;
        }
    }
    echo $return;
}
if (isset($_POST['prosessubmit2analisapengemasanprimer_two'])) {
    $return = false;
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];
    $planningnumber = $_POST['prosessubmit2analisapengemasanprimer_two'][0];
    $years = $_POST['prosessubmit2analisapengemasanprimer_two'][1];
    $jam = $_POST['prosessubmit2analisapengemasanprimer_two'][2];
    $top = $_POST['prosessubmit2analisapengemasanprimer_two'][3];
    $vert1 = $_POST['prosessubmit2analisapengemasanprimer_two'][4];
    $vert2 = $_POST['prosessubmit2analisapengemasanprimer_two'][5];
    $hori = $_POST['prosessubmit2analisapengemasanprimer_two'][6];
    $centre = $_POST['prosessubmit2analisapengemasanprimer_two'][7];
    $lj = $_POST['prosessubmit2analisapengemasanprimer_two'][8];
    $adakontaminasi = $_POST['prosessubmit2analisapengemasanprimer_two'][9];
    $tidakadakontaminasi = $_POST['prosessubmit2analisapengemasanprimer_two'][10];
    $catatan = $_POST['prosessubmit2analisapengemasanprimer_two'][11];
    $jumlahcontoh = $_POST['prosessubmit2analisapengemasanprimer_two'][12];
    $kesimpulan = $_POST['prosessubmit2analisapengemasanprimer_two'][13];

    $sql = mysqli_query($conn, "SELECT * FROM qc_analisapengemasanprimer_header WHERE Plant='$plant' AND
                                                                                    UnitCode='$unitcode' AND
                                                                                    PlanningNumber='$planningnumber' AND
                                                                                    Years='$years'");
    if (mysqli_num_rows($sql) <> 0) {
        mysqli_query($conn, "UPDATE qc_analisapengemasanprimer_header SET JumlahContoh2='$jumlahcontoh',
                                                                        Kesimpulan2='$kesimpulan' WHERE Plant='$plant' AND
                                                                                                UnitCode='$unitcode' AND
                                                                                                PlanningNumber='$planningnumber' AND
                                                                                                Years='$years'");

        $sql = mysqli_query($conn, "SELECT * FROM qc_analisapengemasanprimer_two_detail WHERE Plant='$plant' AND
                                                                                        UnitCode='$unitcode' AND
                                                                                        PlanningNumber='$planningnumber' AND
                                                                                        Years='$years' AND
                                                                                        Jam='$jam'");
        if (mysqli_num_rows($sql) == 0) {
            mysqli_query($conn, "INSERT INTO qc_analisapengemasanprimer_two_detail (Plant,
                                                                                UnitCode,
                                                                                PlanningNumber,
                                                                                Years,
                                                                                Jam,
                                                                                Tops,
                                                                                Vert1,
                                                                                Vert2,
                                                                                Hori,
                                                                                Centre,
                                                                                Lj,
                                                                                AdaKontaminan,
                                                                                TdkAdaKontaminan,
                                                                                Catatan,
                                                                                CreatedOn,
                                                                                CreatedBy)
                            VALUES ('$plant',
                                    '$unitcode',
                                    '$planningnumber',
                                    '$years',
                                    '$jam',
                                    '$top',
                                    '$vert1',
                                    '$vert2',
                                    '$hori',
                                    '$centre',
                                    '$lj',
                                    '$adakontaminasi',
                                    '$tidakadakontaminasi',
                                    '$catatan',
                                    '$createdon',
                                    '$createdby')");
            $return = true;
        }
    }
    echo $return;
}
if (isset($_POST['prosessimpandataanalisapengemasanprimer'])) {
    $planningnumber = $_POST['prosessimpandataanalisapengemasanprimer'][0];
    $years = $_POST['prosessimpandataanalisapengemasanprimer'][1];
    $return = false;
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];

    $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND
                                                                        Years='$years'");
    if (mysqli_num_rows($sql) != 0) {
        $query = mysqli_query($conn, "UPDATE planning_prod_header SET ApprovalQc='X', 
                                                                        ChangedOn='$changedon', 
                                                                        ChangedBy='$changedby' WHERE Plant='$plant' AND 
                                                                                            UnitCode='$unitcode' AND
                                                                                            PlanningNumber='$planningnumber' AND
                                                                                            Years='$years'");
        $return = $query;
    }
    echo $return;
}


// ---------------------------------------------------------
// Karantina
// ---------------------------------------------------------
if (isset($_POST['prosesshowdetailkarantina'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $jenisproses = $_POST['prosesshowdetailkarantina'][0];
    $planningnumber = $_POST['prosesshowdetailkarantina'][1];
    $years = $_POST['prosesshowdetailkarantina'][2];
    $productid = $_POST['prosesshowdetailkarantina'][3];
    $bets = $_POST['prosesshowdetailkarantina'][4];
    $dump[] = '';

    if ($jenisproses == 'pengolahan') {
        $sql = mysqli_query($conn, "");
    } elseif ($jenisproses == 'pengemasan') {
        $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years'");
        if (mysqli_num_rows($sql) != 0) {
            $r = mysqli_fetch_array($sql);
            $dump['plant'] = $r['Plant'];
            $dump['unitcode'] = $r['UnitCode'];
            $dump['planningnumber'] = $r['PlanningNumber'];
            $dump['years'] = $r['Years'];
            $dump['productid'] = $r['ProductID'];
            $q = mysqli_query($conn, "SELECT ProductDescriptions FROM mara_product WHERE ProductID='$r[ProductID]'");
            $q_read = mysqli_fetch_array($q);
            $dump['productdesc'] = $q_read['ProductDescriptions'];
            $dump['bets'] = $r['BatchNumber'];
            $dump['expdate'] = $r['ExpiredDate'];
            $dump['statuscode'] = true;
        }
    }
    echo json_encode($dump);
}
if (isset($_POST['prosessubmitkarantina'])) {
    $planningnumber = $_POST['prosessubmitkarantina'][0];
    $y = $_POST['prosessubmitkarantina'][1];
    $productid = $_POST['prosessubmitkarantina'][2];
    $bets = $_POST['prosessubmitkarantina'][3];
    $jenisproses = $_POST['prosessubmitkarantina'][4];
    $stts = $_POST['prosessubmitkarantina'][5];
    $krtndate = $_POST['prosessubmitkarantina'][6];
    $createdfor = $_POST['prosessubmitkarantina'][7];
    $masalah = $_POST['prosessubmitkarantina'][8];
    $kodekarantina = 0;
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $createdfor = explode(" ", $createdfor);
    $createdfor = $createdfor[0];
    $years = date('Y');

    // ------> Get Kode Karantina
    $sql = mysqli_query($conn, "SELECT Current, Too FROM nriv WHERE NumberRangeType='karantina' AND Years='$years' ORDER BY Current DESC");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $kodekarantina = $q['Current'] + 1;
        $maxkode = $q['Too'];
        // -----> Cek Overload Number
        if ($kodekarantina > $maxkode) {
            die;
        }
    } else {
        $sql = mysqli_query($conn, "SELECT Fromm FROM nriv WHERE NumberRangeType='karantina'");
        $q = mysqli_fetch_array($sql);
        if (mysqli_num_rows($sql) > 0) {
            $kodekarantina = $q['Fromm'];
            mysqli_query($conn, "UPDATE nriv SET Current='$kodekarantina',Years='$years' WHERE NumberRangeType='karantina'");
        }
    }
    mysqli_query($conn, "UPDATE nriv SET Current='$kodekarantina' WHERE NumberRangeType='karantina' AND Years='$years'");
    $kodereff = strtoupper(substr(uniqid(mt_rand($kodekarantina . $years), false), 0, 10));
    if ($jenisproses == 'pengemasan') {
        mysqli_query($conn, "UPDATE planning_prod_header SET Stts='KRTN' WHERE Plant='$plant' AND
                                                                                    UnitCode='$unitcode' AND
                                                                                    PlanningNumber='$planningnumber' AND
                                                                                    Years='$y'");
        $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                PlanningNumber='$planningnumber' AND
                                                                                Years='$y'");
        if (mysqli_num_rows($sql) != 0) {
            $r = mysqli_fetch_array($sql);
            $get_extend = mysqli_query($conn, "SELECT ExtendExp FROM tbl_karantina WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            PlanningNumber='$planningnumber' AND
                                                                                            Years='$y' ORDER BY ExtendExp DESC");
            if (mysqli_num_rows($get_extend) == 0) {
                $extend = 1;
            } else {
                $show_extend = mysqli_fetch_array($get_extend);
                $extend = $show_extend['ExtendExp'] + 1;
            }
            mysqli_query($conn, "INSERT INTO tbl_karantina (Plant,
                                                        UnitCode,
                                                        KodeKarantina,
                                                        Qyears,
                                                        ExtendExp,
                                                        PlanningNumber,
                                                        Years,
                                                        ProductID,
                                                        BatchNumber,
                                                        ExpiredDate,
                                                        JenisProses,
                                                        KarantinaDate,
                                                        PersonInCharge,
                                                        Masalah,
                                                        KodeReff,
                                                        StatsX,
                                                        CreatedOn,
                                                        CreatedBy)
                            VALUES('$plant',
                                    '$unitcode',
                                    '$kodekarantina',
                                    '$years',
                                    '$extend',
                                    '$planningnumber',
                                    '$y',
                                    '$r[ProductID]',
                                    '$r[BatchNumber]',
                                    '$r[ExpiredDate]',
                                    '$jenisproses',
                                    '$krtndate',
                                    '$createdfor',
                                    '$masalah',
                                    '$kodereff',
                                    'REL',
                                    '$createdon',
                                    '$createdby')");
        }
    } elseif ($jenisproses == 'pengolahan') {
        # code...
    }
    echo $kodereff;
}
if (isset($_POST['prosesshowtrackingkarantina'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $kodekarantina = $_POST['prosesshowtrackingkarantina'][0];
    $qyears = $_POST['prosesshowtrackingkarantina'][1];
    $statuscode = false;
    $dump[] = '';

    $sql = mysqli_query($conn, "SELECT * FROM tbl_karantina WHERE Plant='$plant' AND
                                                                UnitCode='$unitcode' AND
                                                                KodeKarantina='$kodekarantina' AND
                                                                Qyears='$qyears'
                                                                ORDER BY ExtendExp ASC");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);

        $sql = mysqli_query($conn, "SELECT * FROM tbl_karantina WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        ProductID='$r[ProductID]' AND
                                                                        BatchNumber='$r[BatchNumber]'
                                                                        ORDER BY ExtendExp DESC");
        $Q = mysqli_fetch_array($sql);
        $max_extend = $Q['ExtendExp'];
        $dump['maxextend'] = $max_extend;

        $dump['kodekarantina'] = $r['KodeKarantina'];
        $dump['qyears'] = $r['Qyears'];
        $dump['planningnumber'] = $r['PlanningNumber'];
        $dump['years'] = $r['Years'];
        $dump['productid'] = $r['ProductID'];
        $dump['tglkarantina'] = $r['KarantinaDate'];
        $dump['createdon'] = date('d/m/Y', strtotime($r['CreatedOn']));
        $dump['createdby'] = $r['CreatedBy'];
        $dump['bets'] = $r['BatchNumber'];
        $dump['qc'] = $r['PersonInCharge'];
        $dump['expdate'] = $r['ExpiredDate'];
        $dump['extendexp'] = $r['ExtendExp'];
        // $dump['nextinsp'] = $r['KodeKarantina'];
        $dump['keterangan'] = $r['Masalah'];
        $dump['kodereff'] = $r['KodeReff'];
        $q = mysqli_query($conn, "SELECT Descriptions FROM text_status WHERE Stats='$r[StatsX]'");
        $q_read = mysqli_fetch_array($q);
        $dump['status'] = $q_read['Descriptions'];
        $q = mysqli_query($conn, "SELECT ProductDescriptions FROM mara_product WHERE ProductID='$r[ProductID]'");
        $q_read = mysqli_fetch_array($q);
        $dump['productdesc'] = $q_read['ProductDescriptions'];
        $statuscode = true;
    }
    $dump['statuscode'] = $statuscode;
    echo json_encode($dump);
}
if (isset($_POST['prosesshowextendexpkarantina'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosesshowextendexpkarantina'][0];
    $years = $_POST['prosesshowextendexpkarantina'][1];
    $extendexp = $_POST['prosesshowextendexpkarantina'][2];
    $statuscode = false;
    $dump[] = '';
    $sql = mysqli_query($conn, "SELECT * FROM tbl_karantina WHERE Plant='$plant' AND
                                                                UnitCode='$unitcode' AND
                                                                PlanningNumber='$planningnumber' AND
                                                                Years='$years'
                                                                ORDER BY ExtendExp DESC");
    $r = mysqli_fetch_array($sql);
    $max_extend = $r['ExtendExp'];
    $dump['maxextend'] = $max_extend;

    $sql = mysqli_query($conn, "SELECT * FROM tbl_karantina WHERE Plant='$plant' AND
                                                                UnitCode='$unitcode' AND
                                                                PlanningNumber='$planningnumber' AND
                                                                Years='$years' AND
                                                                ExtendExp= '$extendexp'");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $dump['kodekarantina'] = $r['KodeKarantina'];
        $dump['qyears'] = $r['Qyears'];
        $dump['planningnumber'] = $r['PlanningNumber'];
        $dump['years'] = $r['Years'];
        $dump['productid'] = $r['ProductID'];
        $dump['tglkarantina'] = $r['KarantinaDate'];
        $dump['createdon'] = date('d/m/Y', strtotime($r['CreatedOn']));
        $dump['createdby'] = $r['CreatedBy'];
        $dump['bets'] = $r['BatchNumber'];
        $dump['qc'] = $r['PersonInCharge'];
        $dump['expdate'] = $r['ExpiredDate'];
        $dump['extendexp'] = $r['ExtendExp'];
        // $dump['nextinsp'] = $r['KodeKarantina'];
        $dump['keterangan'] = $r['Masalah'];
        $dump['kodereff'] = $r['KodeReff'];
        $q = mysqli_query($conn, "SELECT Descriptions FROM text_status WHERE Stats='$r[StatsX]'");
        $q_read = mysqli_fetch_array($q);
        $dump['status'] = $q_read['Descriptions'];
        $dump['statsX'] = $r['StatsX'];
        $q = mysqli_query($conn, "SELECT ProductDescriptions FROM mara_product WHERE ProductID='$r[ProductID]'");
        $q_read = mysqli_fetch_array($q);
        $dump['productdesc'] = $q_read['ProductDescriptions'];
        $statuscode = true;
    }
    $dump['statuscode'] = $statuscode;
    echo json_encode($dump);
}
if (isset($_POST['prosesendkarantina'])) {
    $kodekarantina = $_POST['prosesendkarantina'][0];
    $qyears = $_POST['prosesendkarantina'][1];
    $prs = $_POST['prosesendkarantina'][2];

    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $return = false;

    $sql = mysqli_query($conn, "SELECT * FROM tbl_karantina WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    KodeKarantina='$kodekarantina' AND
                                                                    Qyears='$qyears'");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $a = mysqli_query($conn, "UPDATE planning_prod_header SET SttsX='REL' WHERE Plant='$plant' AND UnitCode='$unitcode' AND
                                                                                    PlannningNumber='$r[PlanningNumber]' AND
                                                                                    Years='$r[Years]'");
        // mysqli_query($conn, "UPDATE tbl_karantina SET StatsX='FNS' WHERE Plant='$plant' AND
        //                                                                 UnitCode='$unitcode' AND
        //                                                                 KodeKarantina='$kodekarantina' AND
        //                                                                 Years='$qyears'");
        $return = mysqli_num_rows($sql);
    }
    echo $return;
}


// ---------------------------------------------------------
// Revuew Quality Assurance
// ---------------------------------------------------------
if (isset($_POST['prosesselectreviewquality'])) {
    $dump[] = '';
    $planningnumber = $_POST['prosesselectreviewquality'][0];
    $years = $_POST['prosesselectreviewquality'][1];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $dump['planningnumber'] = $planningnumber;
    $query = mysqli_query($conn, "SELECT A.ProductID,A.BatchNumber,A.Years,A.UnitOfMeasures, B.ProductDescriptions, A.ExpiredDate, A.UnitOfMeasures
                                    FROM planning_prod_header AS A INNER JOIN mara_product AS B ON A.ProductID = B.ProductID 
                                    WHERE A.Plant='$plant' AND
                                    A.UnitCode='$unitcode' AND
                                    A.PlanningNumber='$planningnumber' AND
                                    A.Years='$years'");
    $q = mysqli_fetch_array($query);
    if (mysqli_num_rows($query) > 0) {
        $dump['uom'] = $q['UnitOfMeasures'];
        $dump['productid'] = $q['ProductID'];
        $dump['deskripsi'] = $q['ProductDescriptions'];
        $dump['batch'] = $q['BatchNumber'];
        $dump['ed'] = $q['ExpiredDate'];
        $dump['uom'] = $q['UnitOfMeasures'];
        $dump['years'] = $q['Years'];

        $query  = mysqli_query($conn, "SELECT CreatedOn FROM proses_prepare_pillow WHERE Plant='$plant' AND
                                                                                    UnitCode='$unitcode' AND
                                                                                    PlanningNumber='$planningnumber' AND
                                                                                    Years='$years'");
        $q = mysqli_fetch_array($query);
        $tanggalpacking = strtotime($q['CreatedOn']);
        $dump['tglpacking'] = date('d M Y', $tanggalpacking);
        $query  = mysqli_query($conn, "SELECT HasilPengemasan FROM transaksi_rekon_pillow WHERE Plant='$plant' AND
                                                                                                UnitCode='$unitcode' AND
                                                                                                PlanningNumber='$planningnumber' AND
                                                                                                Years='$years'");
        $q = mysqli_fetch_array($query);
        $dump['hasilpengemasan'] = number_format($q['HasilPengemasan'], 0, ",", ".");;
        $query  = mysqli_query($conn, "SELECT HasilNyata FROM transaksi_topack WHERE Plant='$plant' AND
                                                                                    UnitCode='$unitcode' AND
                                                                                    PlanningNumber='$planningnumber' AND
                                                                                    Years='$years'");
        $q = mysqli_fetch_array($query);
        $dump['hasilnyata'] = number_format($q['HasilNyata'], 0, ",", ".");
    }
    echo json_encode($dump);
}
if (isset($_POST['prosessimpanreviewquality'])) {
    $return = false;
    $planningnumber = $_POST['prosessimpanreviewquality'][0];
    $var1 = $_POST['prosessimpanreviewquality'][1];
    $var2 = $_POST['prosessimpanreviewquality'][2];
    $var3 = $_POST['prosessimpanreviewquality'][3];
    $var4 = $_POST['prosessimpanreviewquality'][4];
    $var5 = $_POST['prosessimpanreviewquality'][5];
    $var6 = $_POST['prosessimpanreviewquality'][6];
    $var7 = $_POST['prosessimpanreviewquality'][7];
    $var8 = $_POST['prosessimpanreviewquality'][8];
    $decision = $_POST['prosessimpanreviewquality'][9];
    $years = $_POST['prosessimpanreviewquality'][10];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];

    $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND
                                                                         UnitCode='$unitcode' AND
                                                                         PlanningNumber='$planningnumber' AND
                                                                         Years='$years' AND ReviewQA='' or ReviewQA is null");
    $row = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $insert = mysqli_query($conn, "INSERT INTO proses_review_quality
                                        VALUES ('$plant','$unitcode','$planningnumber','$years',
                                        '$var1',
                                        '$var2',
                                        '$var3',
                                        '$var4',
                                        '$var5',
                                        '$var6',
                                        '$var7',
                                        '$var8',
                                        '$decision',
                                        '$createdon',
                                        '$createdby')");
        if ($insert === true) {
            mysqli_query($conn, "UPDATE planning_prod_header SET ReviewQA='X' WHERE Plant='$plant' AND
                                                                                    UnitCode='$unitcode' AND
                                                                                    PlanningNumber='$planningnumber' AND
                                                                                    Years='$years'");
            $return = true;
        }
    }
    echo $return;
}

// ---------------------------------------------------------
// Engine Set
// ---------------------------------------------------------
if (isset($_POST['prosesdisplayenginesettopack'])) {
    $dump[] = '';
    $dump['suhuheater'] = 0;
    $dump['suhustoprun'] = 0;
    $dump['kecepatanmesin'] = 0;
    $planningnumber = $_POST['prosesdisplayenginesettopack'][0];
    $jenistransaksi = $_POST['prosesdisplayenginesettopack'][1];
    $query = mysqli_query($conn, "SELECT * FROM machine_engine WHERE PlanningNumber='$planningnumber' AND JenisTransaksi='$jenistransaksi'");
    $q = mysqli_fetch_array($query);
    if (mysqli_num_rows($query) > 0) {
        $dump['suhuheater'] = $q['SuhuHeater'];
        $dump['suhustoprun'] = $q['SuhuStopRun'];
        $dump['kecepatanmesin'] = $q['KecepatanMesin'];
    }
    $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE PlanningNumber = '$planningnumber'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['planning'] = $q['PlanningNumber'];
        $dump['productid'] = $q['ProductID'];
        $single = mysqli_query($conn, "SELECT ProductDescriptions, StandardRoll, StandardRollKonversi FROM mara_product WHERE ProductID='$q[ProductID]'");
        $row = mysqli_fetch_array($single);
        $dump['productdecription'] = $row['ProductDescriptions'];
        $dump['standardroll'] = $row['StandardRoll'];
        // $dump['standardrollkonversi'] = $row['StandardRollKonversi'];
        $dump['shiftid'] = $q['ShiftID'];
        $dump['packingdate'] = $q['PackingDate'];
        $dump['resourceid'] = $q['ResourceID'];
        $dump['batchnumber'] = $q['BatchNumber'];
        $dump['expireddate'] = $q['ExpiredDate'];
        $dump['resourceidmix'] = $q['ResourceIDMix'];
        $dump['mixingdate'] = $q['MixingDate'];
        $dump['quantity'] = $q['Quantity'];
        $dump['unitofmeasures'] = $q['UnitOfMeasures'];
        $dump['processnumber'] = $q['ProcessNumber'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['createdon'] = $q['CreatedOn'];
        $dump['changedby'] = $q['ChangedBy'];
        $dump['changedon'] = $q['ChangedOn'];
        $dump['stts'] = $q['Stts'];
        $dump['years'] = $q['Years'];
    }
    echo json_encode($dump);
}
if (isset($_POST['prosessubmitenginesettopack'])) {
    $return = false;
    $planningnumber = $_POST['prosessubmitenginesettopack'][0];
    $jenispengecekan = $_POST['prosessubmitenginesettopack'][1];
    $suhu = $_POST['prosessubmitenginesettopack'][2];
    $index = $_POST['prosessubmitenginesettopack'][3];
    $years = $_POST['prosessubmitenginesettopack'][4];
    $jenistransaksi = 'Topack';
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];


    $sql = mysqli_query($conn, "SELECT * FROM machine_engine WHERE Plant='$plant' AND UnitCode='$unitcode' AND
                                                                    PlanningNumber='$planningnumber' AND Years='$years' AND JenisTransaksi='Topack'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) == 0) {
        for ($i = 0; $i < $index; $i++) {
            $sql = mysqli_query($conn, "INSERT INTO machine_engine (Plant,UnitCode,PlanningNumber,Years,JenisTransaksi,
            JenisPengecekan,NilaiSuhu,CreatedOn,CreatedBy) VALUES('$plant','$unitcode','$planningnumber','$years',
                                        '$jenistransaksi',
                                        '$jenispengecekan[$i]',
                                        '$suhu[$i]',
                                        '$createdon',
                                        '$createdby')");
        }
    } else {
        mysqli_query($conn, "DELETE FROM machine_engine WHERE Plant='$plant' AND UnitCode='$unitcode' AND
                                                            PlanningNumber='$planningnumber' AND Years='$years' AND JenisTransaksi='Topack'");
        for ($i = 0; $i < $index; $i++) {
            $sql = mysqli_query($conn, "INSERT INTO machine_engine (Plant,UnitCode,PlanningNumber,Years,JenisTransaksi,
            JenisPengecekan,NilaiSuhu,CreatedOn,CreatedBy) VALUES('$plant','$unitcode','$planningnumber','$years',
                                        '$jenistransaksi',
                                        '$jenispengecekan[$i]',
                                        '$suhu[$i]',
                                        '$createdon',
                                        '$createdby')");
        }
    }

    if ($sql === true) {
        mysqli_query($conn, "UPDATE planning_prod_header SET EngineSetTopack='X'
                                                        WHERE PlanningNumber='$planningnumber'");
        $return = true;
    }
    echo $return;
}

// ---------------------------------------------------------
// Proses Topack
// ---------------------------------------------------------
if (isset($_POST['prosesdisplayprosestopack'])) {
    $no_iconic = 0;
    $iconic = '<img src="../asset/icon/no.png"> Incomplete';
    $planningnumber = $_POST['prosesdisplayprosestopack'][0];
    $years = $_POST['prosesdisplayprosestopack'][1];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $dump[] = '';
    $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND 
                                                                        PlanningNumber = '$planningnumber' AND
                                                                        Years='$years'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['status'] = true;
        $dump['planning'] = $q['PlanningNumber'];
        $dump['urlcodes'] = $q['PlanningNumber'];
        $dump['productid'] = $q['ProductID'];
        $dump['hasilteoritis'] = $q['Quantity'];
        $single = mysqli_query($conn, "SELECT ProductDescriptions,StandardRollKonversi FROM mara_product WHERE ProductID='$q[ProductID]'");
        $row = mysqli_fetch_array($single);
        $dump['productdecription'] = $row['ProductDescriptions'];
        $dump['shiftid'] = $q['ShiftID'];
        $dump['packingdate'] = $q['PackingDate'];
        $dump['resourceid'] = $q['ResourceID'];
        $dump['batchnumber'] = $q['BatchNumber'];
        $dump['expireddate'] = $q['ExpiredDate'];
        $dump['resourceidmix'] = $q['ResourceIDMix'];
        $dump['mixingdate'] = $q['MixingDate'];
        $dump['quantity'] = $q['Quantity'];
        $dump['unitofmeasures'] = $q['UnitOfMeasures'];
        $dump['processnumber'] = $q['ProcessNumber'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['createdon'] = $q['CreatedOn'];
        $dump['changedby'] = $q['ChangedBy'];
        $dump['changedon'] = $q['ChangedOn'];
        $dump['stts'] = $q['Stts'];
        $dump['years'] = $q['Years'];
        $single = mysqli_query($conn, "SELECT * FROM sampling_transaksi_topack WHERE PlanningNumber = '$planningnumber' AND Years='$years'");
        if (mysqli_num_rows($single) > 0) {
            $iconic = '<img src="../asset/icon/ok.png"> Complete';
            $no_iconic = 1;
        }
        $single = mysqli_query($conn, "SELECT * FROM transaksi_topack WHERE PlanningNumber = '$planningnumber' AND Years='$years'");
        $r = mysqli_fetch_array($single);
        if (mysqli_num_rows($single) > 0) {
            $dump['hasilnyata'] = $r['HasilNyata'];
            $dump['persentase'] = $r['Persentase'];
        }

        $dump['iconic'] = $iconic;
        $dump['no_iconic'] = $no_iconic;
    }
    echo json_encode($dump);
}
if (isset($_POST['prosessimpanprosestopack'])) {
    $return = false;
    $plant  = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosessimpanprosestopack'][0];
    $jammulai = $_POST['prosessimpanprosestopack'][1];
    $jamselesai = $_POST['prosessimpanprosestopack'][2];
    $countermesin = $_POST['prosessimpanprosestopack'][3];
    $counterprinter = $_POST['prosessimpanprosestopack'][4];
    $lithoused = $_POST['prosessimpanprosestopack'][5];
    $rusak = $_POST['prosessimpanprosestopack'][6];
    $hasilteoritis = $_POST['prosessimpanprosestopack'][7];
    $hasilnyata = $_POST['prosessimpanprosestopack'][8];
    $persentase = $_POST['prosessimpanprosestopack'][9];
    $samplekebocoran = $_POST['prosessimpanprosestopack'][10];
    $retainedsample = $_POST['prosessimpanprosestopack'][11];
    $years = $_POST['prosessimpanprosestopack'][12];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];

    $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant = '$plant' AND 
                                                                        UnitCode='$unitcode' AND 
                                                                        PlanningNumber='$planningnumber' AND
                                                                        Years='$years' AND 
                                                                        (ProsesTopack='' or ProsesTopack is null)");
    if (mysqli_num_rows($sql) > 0) {
        $insert = mysqli_query($conn, "INSERT INTO transaksi_topack(Plant,UnitCode,PlanningNumber,Years,Starttimes,Endtimes,CounterMesin,
        CounterPrinter,UsedListho,rejectedsch,SampleKebocoran,RetainedSample,HasilTeoritis,HasilNyata,Persentase,CreatedOn,CreatedBy) VALUES('$plant','$unitcode','$planningnumber','$years','$jammulai','$jamselesai',
        '$countermesin','$counterprinter','$lithoused','$rusak','$samplekebocoran','$retainedsample','$hasilteoritis','$hasilnyata','$persentase','$createdon','$createdby')");
        if ($insert === true) {
            // setapproval($planningnumber, 'Topack', $years);
            mysqli_query($conn, "UPDATE planning_prod_header SET ProsesTopack='X', ChangedOn='$changedon',ChangedBy='$changedby' WHERE Plant = '$plant' AND 
                                                                                                                                    UnitCode='$unitcode' AND PlanningNumber='$planningnumber' AND
                                                                                                                                    Years='$years'");
            $return = true;
        }
    }
    echo $return;
}
if (isset($_POST['prosesgetlithoused'])) {
    $productid = $_POST['prosesgetlithoused'][0];
    $counterprinter = $_POST['prosesgetlithoused'][1];

    $sql = mysqli_query($conn, "SELECT StandardRollKonversi FROM mara_product WHERE ProductID='$productid'");
    $row = mysqli_fetch_array($sql);
    $standardrollkonversi = $row['StandardRollKonversi'];
    echo $counterprinter / $standardrollkonversi;
}
if (isset($_POST['prosesshowtabledowntimerekontopack'])) {
    $planningnumber = $_POST['prosesshowtabledowntimerekontopack'][0];
    $years = $_POST['prosesshowtabledowntimerekontopack'][1];
    $proses = $_POST['prosesshowtabledowntimerekontopack'][2];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $output = ' <table id="ddisplayplanning" class="table table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th></th>
                            <th>Jam</th>
                            <th>Permasalahan</th>
                            <th>Tindakan</th>
                            <th>Hasil</th>
                            <th>Created On</th>
                        </tr>
                    </thead>
                    <tbody>';
    $sql = mysqli_query($conn, "SELECT * FROM downtime_rekon WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    PlanningNumber='$planningnumber' AND
                                                                    Years='$years' AND
                                                                    Prosestrx='$proses'");
    while ($row = mysqli_fetch_array($sql)) {
        $output .= '
                            <tr>
                                <td><button class="btn btn-sm bg-transparent zoom" onclick="deletedowntimerekontopack(' . $row["PlanningNumber"] . ',' . $row["Years"] . ',' . $row["Item"] . ',2)"><img src="../asset/img/delete.png"></button></td>
                                <td>' . date("H:i", strtotime($row["LamaDowntime"])) . '</td>
                                <td>' . $row["Permasalahan"] . '</td>
                                <td>' . $row["Tindakan"] . '</td>
                                <td>' . $row["Hasil"] . '</td>
                                <td>' . $row["CreatedOn"] . '</td>
                            </tr>';
    }
    $output .= '
                    </tbody>
                </table>';

    echo $output;
}
if (isset($_POST['prosessavedowntimerekontopack'])) {
    $planningnumber = $_POST['prosessavedowntimerekontopack'][0];
    $years = $_POST['prosessavedowntimerekontopack'][1];
    $LamaDowntime = $_POST['prosessavedowntimerekontopack'][2];
    $permasalahan = $_POST['prosessavedowntimerekontopack'][3];
    $tindakan = $_POST['prosessavedowntimerekontopack'][4];
    $hasil = $_POST['prosessavedowntimerekontopack'][5];
    $proses = $_POST['prosessavedowntimerekontopack'][6];
    $plant  = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];

    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];
    $item = 1;
    $return = false;

    $sql = mysqli_query($conn, "SELECT * FROM downtime_rekon WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND
                                                                        Prosestrx='$proses' AND
                                                                        Years='$years' ORDER BY Item DESC");
    if (mysqli_num_rows($sql) == 0) {
        $insert = mysqli_query($conn, "INSERT INTO downtime_rekon (Plant,UnitCode,
                                                    PlanningNumber,
                                                    Years,
                                                    Prosestrx,
                                                    Item,
                                                    LamaDowntime,
                                                    Permasalahan,
                                                    Tindakan,
                                                    Hasil,
                                                    CreatedOn,
                                                    CreatedBy)
                                            VALUES ('$plant','$unitcode',
                                                '$planningnumber',
                                                '$years','$proses','$item',
                                                '$LamaDowntime','$permasalahan',
                                                '$tindakan','$hasil',
                                                '$createdon','$createdby'
                                                )");
    } else {
        $row = mysqli_fetch_array($sql);
        $item = $row['Item'] + 1;
        $insert = mysqli_query($conn, "INSERT INTO downtime_rekon (Plant,UnitCode,
                                                    PlanningNumber,
                                                    Years,
                                                    Prosestrx,
                                                    Item,
                                                    LamaDowntime,
                                                    Permasalahan,
                                                    Tindakan,
                                                    Hasil,
                                                    CreatedOn,
                                                    CreatedBy)
                                            VALUES ('$plant','$unitcode',
                                                '$planningnumber',
                                                '$years','$proses','$item',
                                                '$LamaDowntime','$permasalahan',
                                                '$tindakan','$hasil',
                                                '$createdon','$createdby'
                                                )");
    }

    if ($insert === true) {
        $return = true;
    }
    echo $return;
}
if (isset($_POST['prosesdeletedowntimerekontopack'])) {
    $planningnumber = $_POST['prosesdeletedowntimerekontopack'][0];
    $years = $_POST['prosesdeletedowntimerekontopack'][1];
    $item = $_POST['prosesdeletedowntimerekontopack'][2];
    $proses = $_POST['prosesdeletedowntimerekontopack'][3];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $return = false;

    $sql = mysqli_query($conn, "DELETE FROM downtime_rekon WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND
                                                                        Years='$years' AND
                                                                        Prosestrx='$proses' AND
                                                                        Item='$item'");
    // $update = mysqli_query($conn, "SELECT * FROM downtime_rekon_topack WHERE Plant='$plant' AND
    //                                                                         UnitCode='$unitcode' AND
    //                                                                         PlanningNumber='$planningnumber' AND
    //                                                                         Years='$years'");
    // $jumlah = mysqli_num_rows($update);
    // if ($jumlah > 0) {
    //     for ($i = 0; $i < $jumlah; $i++) {
    //         mysqli_query($conn, "UPDATE downtime_rekon_topack SET Items = '$i' WHERE Plant='$plant' AND UnitCode='$unitcode' AND PlanningNumber='$planningnumber' AND Years='$years'");
    //     }
    // }
    if ($sql === true) {
        $return = true;
    }
    echo $return;
}

// ---------------------------------------------------------
// Sampling Topack Produksi
// ---------------------------------------------------------
if (isset($_POST['prosesdisplaysamplingtopackproduksi'])) {
    $planningnumber = $_POST['prosesdisplaysamplingtopackproduksi'][0];
    $years = $_POST['prosesdisplaysamplingtopackproduksi'][1];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $dump[] = '';
    $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber = '$planningnumber' AND
                                                                        Years='$years'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['status'] = true;
        $dump['planning'] = $q['PlanningNumber'];
        $dump['urlcodes'] = $q['PlanningNumber'];
        $dump['productid'] = $q['ProductID'];
        $single = mysqli_query($conn, "SELECT ProductDescriptions,BobotTimbang FROM mara_product WHERE ProductID='$q[ProductID]'");
        $row = mysqli_fetch_array($single);
        $dump['productdecription'] = $row['ProductDescriptions'];
        $dump['bobottimbang'] = $row['BobotTimbang'] . ' Gram';
        $dump['shiftid'] = $q['ShiftID'];
        $dump['packingdate'] = $q['PackingDate'];
        $dump['resourceid'] = $q['ResourceID'];
        $dump['batchnumber'] = $q['BatchNumber'];
        $dump['expireddate'] = $q['ExpiredDate'];
        $dump['resourceidmix'] = $q['ResourceIDMix'];
        $dump['mixingdate'] = $q['MixingDate'];
        $dump['quantity'] = $q['Quantity'];
        $dump['unitofmeasures'] = $q['UnitOfMeasures'];
        $dump['processnumber'] = $q['ProcessNumber'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['createdon'] = $q['CreatedOn'];
        $dump['changedby'] = $q['ChangedBy'];
        $dump['changedon'] = $q['ChangedOn'];
        $dump['stts'] = $q['Stts'];
        $dump['years'] = $q['Years'];
        $dump['item'] = '1';
        $single = mysqli_query($conn, "SELECT Item FROM sampling_transaksi_topack WHERE Plant='$plant' AND
                                                                                        UnitCode='$unitcode' AND
                                                                                        PlanningNumber = '$planningnumber' AND
                                                                                        Years='$years' ORDER BY Item DESC");
        $row = mysqli_fetch_array($single);
        if (mysqli_num_rows($single) > 0) {
            $dump['item'] = $row['Item'] + 1;
        }
    }
    echo json_encode($dump);
}
if (isset($_POST['showtablesamplingtopackproduksi'])) {
    $planningnumber = $_POST['showtablesamplingtopackproduksi'][0];
    $years = $_POST['showtablesamplingtopackproduksi'][1];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $output = '<table id="ddisplayplanning" class="table table-sm" style="width:100%;">
    <thead class="bg-dark text-white">
        <tr>
            <th style="width:5%">Item</th>
            <th>Jam</th>
            <th>Qty</th>
            <th>Uom</th> 
            <th>Bobot Timbang</th>          
        </tr>
    </thead>
    <tbody>';
    $i = 1;
    $sql = mysqli_query($conn, "SELECT * FROM sampling_transaksi_topack WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                PlanningNumber='$planningnumber' AND
                                                                                Years='$years'");
    while ($row = mysqli_fetch_array($sql)) {
        $plus = $row["PlanningNumber"] .  $row["Item"];
        $years = $row["Years"];
        $output .= '
        <tr>
            <td><a href="#" class="badge bg-danger href_transform" onclick="deletesamplingtopackproduksi(' . $plus . ',' . $years . ')"><img src="../asset/img/delete.png">' . $i . '</a></td>
            <td>' . $row["JamTimbang"] . '</td>
            <td>' . $row["Qty"] . '</td>
            <td>' . $row["Uom"] . '</td> 
            <td>' . $row["BobotTimbang"] . '</td> 
        </tr>';
        $i++;
    }
    $output .= '
    </tbody>
    </table>';
    echo $output;
}
if (isset($_POST['showtablesamplingtopackproduksi2'])) {
    $planningnumber = substr($_POST['showtablesamplingtopackproduksi2'][0], 0, 10);
    $years = $_POST['showtablesamplingtopackproduksi2'][1];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $output = '<table id="ddisplayplanning" class="table table-sm" style="width:100%;">
    <thead class="bg-dark text-white">
        <tr>
            <th style="width:5%">Item</th>
            <th>Jam</th>
            <th>Qty</th>
            <th>Uom</th>    
            <th>Bobot Timbang</th>        
        </tr>
    </thead>
    <tbody>';
    $i = 1;
    $sql = mysqli_query($conn, "SELECT * FROM sampling_transaksi_topack WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years'");
    while ($row = mysqli_fetch_array($sql)) {
        $plus = $row["PlanningNumber"] .  $row["Item"];
        $years = $row["Years"];
        $output .= '
        <tr>
            <td><a href="#" class="badge bg-danger href_transform" onclick="deletesamplingtopackproduksi(' . $plus . ',' . $years . ')"><img src="../asset/img/delete.png">' . $i . '</a></td>
            <td>' . $row["JamTimbang"] . '</td>
            <td>' . $row["Qty"] . '</td>
            <td>' . $row["Uom"] . '</td> 
            <td>' . $row["BobotTimbang"] . '</td> 
        </tr>';
        $i++;
    }
    $output .= '
    </tbody>
    </table>';
    echo $output;
}
if (isset($_POST['prosessubmitsamplingtopackproduksi'])) {
    $return = false;
    $dump[] = '';
    $planningnumber = $_POST['prosessubmitsamplingtopackproduksi'][0];
    $item = $_POST['prosessubmitsamplingtopackproduksi'][1];
    $qty = $_POST['prosessubmitsamplingtopackproduksi'][2];
    $uom = $_POST['prosessubmitsamplingtopackproduksi'][3];
    $bobottimbang = $_POST['prosessubmitsamplingtopackproduksi'][4];
    $years = $_POST['prosessubmitsamplingtopackproduksi'][5];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $jamtimbang = date('H:i:s');
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "INSERT INTO sampling_transaksi_topack (Plant,UnitCode,PlanningNumber,Years,Item,JamTimbang,Qty,Uom,BobotTimbang,CreatedOn,CreatedBy)
    VALUES('$plant','$unitcode','$planningnumber','$years','$item','$jamtimbang','$qty','$uom','$bobottimbang','$createdon','$createdby')");
    if ($sql === true) {
        $return = true;
    }
    $dump['return'] = $return;
    $dump['item'] = $item + 1;
    echo json_encode($dump);
}
if (isset($_POST['prosesdeletesamplingtopackproduksi'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $return = false;
    $dump = [];
    $item = 1;
    $planningnumber = substr($_POST['prosesdeletesamplingtopackproduksi'][0], 0, 10);
    $years = $_POST['prosesdeletesamplingtopackproduksi'][1];
    $item = substr($_POST['prosesdeletesamplingtopackproduksi'][0], 10);

    $sql = mysqli_query($conn, "DELETE FROM sampling_transaksi_topack WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years' AND Item='$item'");
    if ($sql === true) {
        $query = mysqli_query($conn, "SELECT MAX(Item) FROM sampling_transaksi_topack WHERE Plant='$plant' AND
                                                                                            UnitCode='$unitcode' AND
                                                                                            PlanningNumber='$planningnumber' AND
                                                                                            Years='$years'");
        $q = mysqli_fetch_array($query);
        $item = $q['Item'];
        $return = true;
    }
    $dump['Item'] = $item;
    $dump['return'] = $return;
    // echo json_encode($dump);
    echo $return;
}

// ---------------------------------------------------------
// Prepare Pillow Pack
// ---------------------------------------------------------
if (isset($_POST['prosesdisplaypersiapanpillow'])) {
    $planningnumber = $_POST['prosesdisplaypersiapanpillow'][0];
    $years = $_POST['prosesdisplaypersiapanpillow'][1];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $dump[] = '';
    $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND 
                                                                        PlanningNumber = '$planningnumber' AND
                                                                        Years='$years'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['status'] = true;
        $dump['planning'] = $q['PlanningNumber'];
        $dump['productid'] = $q['ProductID'];
        $single = mysqli_query($conn, "SELECT ProductDescriptions, StandardRoll, StandardRollKonversi FROM mara_product WHERE ProductID='$q[ProductID]'");
        $row = mysqli_fetch_array($single);
        $dump['productdecription'] = $row['ProductDescriptions'];
        $dump['standardroll'] = $row['StandardRoll'];
        // $dump['standardrollkonversi'] = $row['StandardRollKonversi'];
        $dump['shiftid'] = $q['ShiftID'];
        $dump['packingdate'] = $q['PackingDate'];
        $dump['resourceid'] = $q['ResourceID'];
        $dump['batchnumber'] = $q['BatchNumber'];
        $dump['expireddate'] = $q['ExpiredDate'];
        $dump['resourceidmix'] = $q['ResourceIDMix'];
        $dump['mixingdate'] = $q['MixingDate'];
        $dump['quantity'] = $q['Quantity'];
        $dump['unitofmeasures'] = $q['UnitOfMeasures'];
        $dump['processnumber'] = $q['ProcessNumber'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['createdon'] = $q['CreatedOn'];
        $dump['changedby'] = $q['ChangedBy'];
        $dump['changedon'] = $q['ChangedOn'];
        $dump['stts'] = $q['Stts'];
        $dump['years'] = $q['Years'];
    }
    echo json_encode($dump);
}
if (isset($_POST['prosessubmitpreparepillow'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosessubmitpreparepillow'][0];
    $value_parameters = $_POST['prosessubmitpreparepillow'][1];
    $operator1 = $_POST['prosessubmitpreparepillow'][2];
    $operator2 = $_POST['prosessubmitpreparepillow'][3];
    $operator3 = $_POST['prosessubmitpreparepillow'][4];
    $operator4 = $_POST['prosessubmitpreparepillow'][5];
    $operator5 = $_POST['prosessubmitpreparepillow'][6];
    $operator6 = $_POST['prosessubmitpreparepillow'][7];

    $satuan_1 = $_POST['prosessubmitpreparepillow'][8];
    $qty_1 = $_POST['prosessubmitpreparepillow'][9];
    $satuan_2 = $_POST['prosessubmitpreparepillow'][10];
    $qty_2 = $_POST['prosessubmitpreparepillow'][11];
    $satuan_3 = $_POST['prosessubmitpreparepillow'][12];
    $qty_3 = $_POST['prosessubmitpreparepillow'][13];
    $satuan_4 = $_POST['prosessubmitpreparepillow'][14];
    $qty_4 = $_POST['prosessubmitpreparepillow'][15];
    $satuan_5 = $_POST['prosessubmitpreparepillow'][16];
    $qty_5 = $_POST['prosessubmitpreparepillow'][17];
    $satuan_6 = $_POST['prosessubmitpreparepillow'][18];
    $qty_6 = $_POST['prosessubmitpreparepillow'][19];
    $pengawasproduksi = $_POST['prosessubmitpreparepillow'][20];
    $years = $_POST['prosessubmitpreparepillow'][21];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    mysqli_query($conn, "DELETE FROM proses_prepare_pillow WHERE Plant='$plant' AND
                                                                UnitCode='$unitcode' AND
                                                                PlanningNumber='$planningnumber' AND
                                                                Years='$years'");
    $sql = mysqli_query($conn, "SELECT * FROM proses_prepare_pillow WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) == 0) {
        // for ($i = 0; $i < $index; $i++) {
        $sql = mysqli_query($conn, "INSERT INTO proses_prepare_pillow (Plant,UnitCode,PlanningNumber,Years,FirstOperator,SecondOperator,
        ThreeOperator,FourOperator,FiveOperator,SixOperator,PengawasProduksi,
        Parameter_1,Parameter_2,Parameter_3,Parameter_4,Parameter_5,
        Satuan_1,Qty_1,
        Satuan_2,Qty_2,
        Satuan_3,Qty_3,
        Satuan_4,Qty_4,
        Satuan_5,Qty_5,
        Satuan_6,Qty_6,
        CreatedOn,CreatedBy)
                                    VALUES('$plant','$unitcode','$planningnumber','$years',
                                        '$operator1',
                                        '$operator2',
                                        '$operator3',
                                        '$operator4',
                                        '$operator5',
                                        '$operator6',
                                        '$pengawasproduksi',
                                        '$value_parameters[1]',
                                        '$value_parameters[2]',
                                        '$value_parameters[3]',
                                        '$value_parameters[4]',
                                        '$value_parameters[5]',
                                        '$satuan_1',
                                        '$qty_1',
                                        '$satuan_2',
                                        '$qty_2',
                                        '$satuan_3',
                                        '$qty_3',
                                        '$satuan_4',
                                        '$qty_4',
                                        '$satuan_5',
                                        '$qty_5',
                                        '$satuan_6',
                                        '$qty_6',
                                        '$createdon',
                                        '$createdby')");
    }
    if ($sql === true) {
        mysqli_query($conn, "UPDATE planning_prod_header SET PreparePillow='X'
                                                        WHERE Plant='$plant' AND UnitCode='$unitcode' AND PlanningNumber='$planningnumber' AND Years='$years'");
        $return = true;
    }
    echo $return;
}

// ---------------------------------------------------------
// Proses Pillow Pack
// ---------------------------------------------------------
if (isset($_POST['prosesdisplayprosespillow'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosesdisplayprosespillow'][0];
    $years = $_POST['prosesdisplayprosespillow'][1];
    $dump[] = '';
    $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND 
                                                                        PlanningNumber = '$planningnumber' AND
                                                                        Years='$years'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['status'] = true;
        $dump['planning'] = $q['PlanningNumber'];
        $dump['productid'] = $q['ProductID'];
        $single = mysqli_query($conn, "SELECT ProductDescriptions, StandardRoll, StandardRollKonversi FROM mara_product WHERE ProductID='$q[ProductID]'");
        $row = mysqli_fetch_array($single);
        $dump['productdecription'] = $row['ProductDescriptions'];
        $dump['standardroll'] = $row['StandardRoll'];
        $dump['shiftid'] = $q['ShiftID'];
        $dump['packingdate'] = $q['PackingDate'];
        $dump['resourceid'] = $q['ResourceID'];
        $dump['batchnumber'] = $q['BatchNumber'];
        $dump['expireddate'] = $q['ExpiredDate'];
        $dump['resourceidmix'] = $q['ResourceIDMix'];
        $dump['mixingdate'] = $q['MixingDate'];
        $dump['quantity'] = $q['Quantity'];
        $dump['unitofmeasures'] = $q['UnitOfMeasures'];
        $dump['processnumber'] = $q['ProcessNumber'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['createdon'] = $q['CreatedOn'];
        $dump['changedby'] = $q['ChangedBy'];
        $dump['changedon'] = $q['ChangedOn'];
        $dump['stts'] = $q['Stts'];
        $dump['years'] = $q['Years'];
    }
    echo json_encode($dump);
}
if (isset($_POST['prosessubmitprosespillow'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosessubmitprosespillow'][0];
    $typerenteng = $_POST['prosessubmitprosespillow'][1];
    $parameter_1 = $_POST['prosessubmitprosespillow'][2];
    $parameter_2 = $_POST['prosessubmitprosespillow'][3];
    $parameter_3 = $_POST['prosessubmitprosespillow'][4];
    $qtyplastik = $_POST['prosessubmitprosespillow'][5];
    $jammulai = $_POST['prosessubmitprosespillow'][6];
    $jamselesai = $_POST['prosessubmitprosespillow'][7];
    $years = $_POST['prosessubmitprosespillow'][8];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    // mysqli_query($conn, "DELETE FROM transaksi_pillow WHERE Plant='$plant' AND 
    //                                                         UnitCode='$unitcode' AND 
    //                                                         PlanningNumber='$planningnumber' AND
    //                                                         Years='$years'");
    $sql = mysqli_query($conn, "SELECT * FROM transaksi_pillow WHERE Plant='$plant' AND  
                                                                    UnitCode='$unitcode' AND 
                                                                    PlanningNumber='$planningnumber' AND
                                                                    Years='$years'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) == 0) {
        $sql = mysqli_query($conn, "INSERT INTO transaksi_pillow (Plant,UnitCode,PlanningNumber,Years,TypeRenteng,Jam_Mulai,Jam_Selesai,Parameter_1,Parameter_2,Parameter_3,QtyPlastik,CreatedOn,CreatedBy)
                                    VALUES('$plant','$unitcode','$planningnumber','$years',
                                        '$typerenteng',
                                        '$jammulai',
                                        '$jamselesai',
                                        '$parameter_1',
                                        '$parameter_2',
                                        '$parameter_3',
                                        '$qtyplastik',
                                        '$createdon',
                                        '$createdby')");
    }
    if ($sql === true) {
        mysqli_query($conn, "UPDATE planning_prod_header SET ProsesPillow='X'
                                                        WHERE Plant='$plant' AND 
                                                        UnitCode='$unitcode' AND 
                                                        PlanningNumber='$planningnumber' AND
                                                        Years='$years'");
        $return = true;
    }
    echo $return;
}
if (isset($_POST['prosesdisplayrekonpillow'])) {
    $planningnumber = $_POST['prosesdisplayrekonpillow'][0];
    $years = $_POST['prosesdisplayrekonpillow'][1];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $dump[] = '';
    $_SESSION['PlanningNumber'] = '';
    $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                         PlanningNumber = '$planningnumber' AND
                                                                         Years='$years'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['status'] = true;
        $dump['planning'] = $q['PlanningNumber'];
        $dump['productid'] = $q['ProductID'];
        $single = mysqli_query($conn, "SELECT ProductDescriptions, StandardRoll, StandardRollKonversi FROM mara_product WHERE ProductID='$q[ProductID]'");
        $row = mysqli_fetch_array($single);
        $dump['productdecription'] = $row['ProductDescriptions'];
        $dump['standardroll'] = $row['StandardRoll'];
        // $dump['standardrollkonversi'] = $row['StandardRollKonversi'];
        $dump['shiftid'] = $q['ShiftID'];
        $dump['packingdate'] = $q['PackingDate'];
        $dump['resourceid'] = $q['ResourceID'];
        $dump['batchnumber'] = $q['BatchNumber'];
        $dump['expireddate'] = $q['ExpiredDate'];
        $dump['resourceidmix'] = $q['ResourceIDMix'];
        $dump['mixingdate'] = $q['MixingDate'];
        $dump['quantity'] = $q['Quantity'];
        $dump['unitofmeasures'] = $q['UnitOfMeasures'];
        $dump['processnumber'] = $q['ProcessNumber'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['createdon'] = $q['CreatedOn'];
        $dump['changedby'] = $q['ChangedBy'];
        $dump['changedon'] = $q['ChangedOn'];
        $dump['stts'] = $q['Stts'];
        $dump['years'] = $q['Years'];
        $_SESSION['PlanningNumber'] = $planningnumber;
    }
    echo json_encode($dump);
}

// ---------------------------------------------------------
// Rekon Pillow Pack
// ---------------------------------------------------------
if (isset($_POST['prosesautohasilnyata'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosesautohasilnyata'][0];
    $years = $_POST['prosesautohasilnyata'][1];
    $hasilpengemasan = $_POST['prosesautohasilnyata'][2];
    $return = 0;

    $sql = mysqli_query($conn, "SELECT * FROM transaksi_pillow WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND 
                                                                    PlanningNumber='$planningnumber' AND 
                                                                    Years='$years'");
    if (mysqli_num_rows($sql) != 0) {
        $row = mysqli_fetch_array($sql);
        $return = $hasilpengemasan * $row['TypeRenteng'] * $row['QtyPlastik'];
    }
    echo $return;
}
if (isset($_POST['prosessimpanrekonpillow'])) {
    $return = false;
    $planningnumber = $_POST['prosessimpanrekonpillow'][0];
    $hasilpengemasan = $_POST['prosessimpanrekonpillow'][1];
    $countermesin = $_POST['prosessimpanrekonpillow'][2];
    $dus = $_POST['prosessimpanrekonpillow'][3];
    $brosur = $_POST['prosessimpanrekonpillow'][4];
    $hanger = $_POST['prosessimpanrekonpillow'][5];
    $stiker = $_POST['prosessimpanrekonpillow'][6];
    $box = $_POST['prosessimpanrekonpillow'][7];
    $plastik = $_POST['prosessimpanrekonpillow'][8];
    $hasilteoritis = $_POST['prosessimpanrekonpillow'][9];
    $hasilnyata = $_POST['prosessimpanrekonpillow'][10];
    $persentase = $_POST['prosessimpanrekonpillow'][11];
    $years = $_POST['prosessimpanrekonpillow'][12];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $sql = mysqli_query($conn, "SELECT * FROM transaksi_rekon_pillow WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND
                                                                             PlanningNumber='$planningnumber' AND
                                                                             Years='$years'");
    if (mysqli_num_rows($sql) == 0) {
        $query = mysqli_query($conn, "INSERT INTO transaksi_rekon_pillow
        (Plant,UnitCode,PlanningNumber,Years,
        HasilPengemasan,
        CounterMesin,
        Dus,Brosur,
        Hanger,Stiker,
        Tbox,Plastik,
        HasilTeoritis,HasilNyata,
        PresentaseHasil,
        CreatedOn,CreatedBy) VALUES('$plant','$unitcode',
                                    '$planningnumber',
                                    '$years',
                                    '$hasilpengemasan',
                                    '$countermesin',
                                    '$dus',
                                    '$brosur',
                                    '$hanger',
                                    '$stiker',
                                    '$box',
                                    '$plastik',
                                    '$hasilteoritis',
                                    '$hasilnyata',
                                    '$persentase',
                                    '$createdon',
                                    '$createdby')");
    } else {
        $query = mysqli_query($conn, "UPDATE transaksi_rekon_pillow SET HasilPengemasan='$hasilpengemasan', 
        CounterMesin='$countermesin',
        Dus='$dus',
        Brosur='$brosur',
        Hanger='$hanger',
        Stiker='$stiker',
        Tbox='$box',
        Plastik='$plastik',
        HasilTeoritis='$hasilteoritis',
        HasilNyata='$hasilnyata',
        PresentaseHasil='$persentase',
        ChangedOn='$changedon',
        ChangedBy='$changedby' 
        WHERE Plant='$plant' AND UnitCode='$unitcode' AND PlanningNumber='$planningnumber' AND Years='$years'");
    }
    if ($query === true) {
        // setapproval($planningnumber, 'Pillow Pack', $years);
        mysqli_query($conn, "UPDATE planning_prod_header SET RekonPillow='X', ChangedOn='$changedon',ChangedBy='$changedby' WHERE Plant='$plant' AND
                                                                                                                                UnitCode='$unitcode' AND
                                                                                                                                 PlanningNumber='$planningnumber' AND
                                                                                                                                 Years='$years'");
        $return = true;
    }
    echo $return;
}
if (isset($_POST['prosesshowtablerekonsiliasipillow'])) {
    $planningnumber = $_POST['prosesshowtablerekonsiliasipillow'][0];
    $years = $_POST['prosesshowtablerekonsiliasipillow'][1];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $output = ' <table id="ddisplayplanning" class="table table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th></th>
                            <th>Planing Number</th>
                            <th>Jumlah</th>
                            <th>No Container</th>
                            <th>Keterangan</th>
                            <th>Created On</th>
                        </tr>
                    </thead>
                    <tbody>';
    $sql = mysqli_query($conn, "SELECT * FROM reject_lulus_rekonsiliasipillow WHERE Plant='$plant' AND
                                                                                    UnitCode='$unitcode' AND
                                                                                    PlanningNumber='$planningnumber' AND
                                                                                    Years='$years'");
    while ($row = mysqli_fetch_array($sql)) {
        $output .= '
                            <tr>
                                <td><button class="btn btn-sm btn-danger" onclick="deletereject(' . $row["PlanningNumber"] . ',' . $row["Item"] . ',' . $row["Years"] . ')"><img src="../asset/img/delete.png"></button></td>
                                <td>' . $row["PlanningNumber"] . '</td>
                                <td>' . $row["Jumlah"] . '</td>
                                <td>' . $row["NoContainer"] . '</td>
                                <td>' . $row["Keterangan"] . '</td>
                                <td>' . $row["CreatedOn"] . '</td>
                            </tr>';
    }
    $output .= '
                    </tbody>
                </table>';

    echo $output;
}
if (isset($_POST['prosessaverejectrekonsiliasipillow'])) {
    $return = false;
    $planningnumber = $_POST['prosessaverejectrekonsiliasipillow'][0];
    $jumlah = $_POST['prosessaverejectrekonsiliasipillow'][1];
    $nocontainer = $_POST['prosessaverejectrekonsiliasipillow'][2];
    $keterangan = $_POST['prosessaverejectrekonsiliasipillow'][3];
    $years = $_POST['prosessaverejectrekonsiliasipillow'][4];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $sql = mysqli_query($conn, "SELECT MAX(Item) as Item FROM reject_lulus_rekonsiliasipillow WHERE Plant='$plant' AND
                                                                                                    UnitCode='$unitcode' AND
                                                                                                     PlanningNumber='$planningnumber' AND
                                                                                                     Years='$years'");
    $q = mysqli_fetch_array($sql);
    $item = $q['Item'] + 1;

    $sql = mysqli_query($conn, "INSERT INTO reject_lulus_rekonsiliasipillow (Plant,UnitCode,PlanningNumber,Years,Item,Jumlah,NoContainer,Keterangan,CreatedOn,CreatedBy)
                        VALUES('$plant','$unitcode','$planningnumber','$years','$item','$jumlah','$nocontainer','$keterangan','$createdon','$createdby')");
    if ($sql === true) {
        $return = true;
    }
    echo $return;
}
if (isset($_POST['prosesdeleterejectrekonsiliasipillow'])) {
    $return = false;
    $planningnumber = $_POST['prosesdeleterejectrekonsiliasipillow'][0];
    $item = $_POST['prosesdeleterejectrekonsiliasipillow'][1];
    $years = $_POST['prosesdeleterejectrekonsiliasipillow'][2];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $sql = mysqli_query($conn, "DELETE FROM reject_lulus_rekonsiliasipillow WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                 PlanningNumber='$planningnumber' AND 
                                                                                Item='$item' AND 
                                                                                Years='$years'");
    if ($sql === true) {
        $return = true;
    }
    echo $return;
}
if (isset($_POST['prosesambildatasampleprosespillow'])) {
    $return = false;
    $teoritis = 0;
    $planningnumber = $_POST['prosesambildatasampleprosespillow'][0];
    $hasilnyata = $_POST['prosesambildatasampleprosespillow'][1];
    $years = $_POST['prosesambildatasampleprosespillow'][2];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];

    // Get hasil teoritis
    $sql = mysqli_query($conn, "SELECT SampleKebocoran,RetainedSample,HasilNyata FROM transaksi_topack WHERE Plant='$plant' AND
                                                                                                            UnitCode='$unitcode' AND
                                                                                                             PlanningNumber='$planningnumber' AND
                                                                                                             Years='$years'");
    $row = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $teoritis = $row['HasilNyata'] - ($row['SampleKebocoran'] + $row['RetainedSample']);
        $return = true;
    }
    $dump['teoritis'] = $teoritis;
    $dump['return'] = $return;
    echo json_encode($dump);
}
if (isset($_POST['prosesshowtabledowntime'])) {
    $planningnumber = $_POST['prosesshowtabledowntime'][0];
    $years = $_POST['prosesshowtabledowntime'][1];
    $proses = $_POST['prosesshowtabledowntime'][2];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $output = ' <table id="ddisplayplanning" class="table table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th></th>
                            <th>Lama Downtime</th>
                            <th>Permasalahan</th>
                            <th>Tindakan</th>
                            <th>Hasil</th>
                            <th>Created On</th>
                        </tr>
                    </thead>
                    <tbody>';
    $sql = mysqli_query($conn, "SELECT * FROM downtime_rekon WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    PlanningNumber='$planningnumber' AND
                                                                    Years='$years' AND
                                                                    Prosestrx='$proses'");
    while ($row = mysqli_fetch_array($sql)) {
        $output .= '
                            <tr>
                                <td><button class="btn btn-sm bg-transparent zoom" onclick="deletedowntime(' . $row["PlanningNumber"] . ',' . $row["Years"] . ',' . $row["Item"] . ',1)"><img src="../asset/img/delete.png"></button></td>
                                <td>' . date("H:i", strtotime($row["LamaDowntime"])) . '</td>
                                <td>' . $row["Permasalahan"] . '</td>
                                <td>' . $row["Tindakan"] . '</td>
                                <td>' . $row["Hasil"] . '</td>
                                <td>' . $row["CreatedOn"] . '</td>
                            </tr>';
    }
    $output .= '
                    </tbody>
                </table>';

    echo $output;
}
if (isset($_POST['prosessavedowntime'])) {
    $planningnumber = $_POST['prosessavedowntime'][0];
    $years = $_POST['prosessavedowntime'][1];
    $LamaDowntime = $_POST['prosessavedowntime'][2];
    $permasalahan = $_POST['prosessavedowntime'][3];
    $tindakan = $_POST['prosessavedowntime'][4];
    $hasil = $_POST['prosessavedowntime'][5];
    $proses = $_POST['prosessavedowntime'][6];
    $plant  = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];

    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];
    $item = 1;
    $return = false;

    $sql = mysqli_query($conn, "SELECT * FROM downtime_rekon WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND
                                                                        Prosestrx='$proses' AND
                                                                        Years='$years' ORDER BY Item DESC");
    if (mysqli_num_rows($sql) == 0) {
        $insert = mysqli_query($conn, "INSERT INTO downtime_rekon (Plant,UnitCode,
                                                    PlanningNumber,
                                                    Years,
                                                    Prosestrx,
                                                    Item,
                                                    LamaDowntime,
                                                    Permasalahan,
                                                    Tindakan,
                                                    Hasil,
                                                    CreatedOn,
                                                    CreatedBy)
                                            VALUES ('$plant','$unitcode',
                                                '$planningnumber',
                                                '$years','$proses','$item',
                                                '$LamaDowntime','$permasalahan',
                                                '$tindakan','$hasil',
                                                '$createdon','$createdby'
                                                )");
    } else {
        $row = mysqli_fetch_array($sql);
        $item = $row['Item'] + 1;
        $insert = mysqli_query($conn, "INSERT INTO downtime_rekon (Plant,UnitCode,
                                                    PlanningNumber,
                                                    Years,
                                                    Prosestrx,
                                                    Item,
                                                    LamaDowntime,
                                                    Permasalahan,
                                                    Tindakan,
                                                    Hasil,
                                                    CreatedOn,
                                                    CreatedBy)
                                            VALUES ('$plant','$unitcode',
                                                '$planningnumber',
                                                '$years','$proses','$item',
                                                '$LamaDowntime','$permasalahan',
                                                '$tindakan','$hasil',
                                                '$createdon','$createdby'
                                                )");
    }

    if ($insert === true) {
        $return = true;
    }
    echo $return;
}
if (isset($_POST['prosesdeletedowntime'])) {
    $planningnumber = $_POST['prosesdeletedowntime'][0];
    $years = $_POST['prosesdeletedowntime'][1];
    $item = $_POST['prosesdeletedowntime'][2];
    $proses = $_POST['prosesdeletedowntime'][3];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $return = false;

    $sql = mysqli_query($conn, "DELETE FROM downtime_rekon WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND
                                                                        Years='$years' AND
                                                                        Prosestrx='$proses' AND
                                                                        Item='$item'");
    // $update = mysqli_query($conn, "SELECT * FROM downtime_rekon_topack WHERE Plant='$plant' AND
    //                                                                         UnitCode='$unitcode' AND
    //                                                                         PlanningNumber='$planningnumber' AND
    //                                                                         Years='$years'");
    // $jumlah = mysqli_num_rows($update);
    // if ($jumlah > 0) {
    //     for ($i = 0; $i < $jumlah; $i++) {
    //         mysqli_query($conn, "UPDATE downtime_rekon_topack SET Items = '$i' WHERE Plant='$plant' AND UnitCode='$unitcode' AND PlanningNumber='$planningnumber' AND Years='$years'");
    //     }
    // }
    if ($sql === true) {
        $return = true;
    }
    echo $return;
}
// ---------------------------------------------------------
// Change Password
// ---------------------------------------------------------
if (isset($_POST['proseschangepassword'])) {
    $result = 0;
    $userid = $_SESSION['userid'];
    $current = base64_encode($_POST['proseschangepassword'][0]);
    $new = $_POST['proseschangepassword'][1];
    $renew = $_POST['proseschangepassword'][2];
    $sql = mysqli_query($conn, "SELECT * FROM usr02 WHERE UserID='$userid' AND InitialPassword='$current'");
    if (mysqli_num_rows($sql) > 0) {
        $q = mysqli_fetch_array($sql);
        if ($new == $renew) {
            mysqli_query($conn, "UPDATE usr02 SET InitialPassword= '" . base64_encode($new) . "' WHERE UserID='$userid'");
            $result = 1;
        } else {
            $result = 3;
        }
    } else {
        $result = 2;
    }
    echo $result;
}

// ---------------------------------------------------------
// General Setting
// ---------------------------------------------------------
if (isset($_POST['prosessimpangeneralsetting'])) {
    $return = false;
    $dashboardtitle = ucwords($_POST['prosessimpangeneralsetting'][0]);
    $dashboardcontent = $_POST['prosessimpangeneralsetting'][1];
    $userid = ucwords($_POST['prosessimpangeneralsetting'][2]);
    $rolecode = ucfirst($_POST['prosessimpangeneralsetting'][3]);
    $passcode = $_POST['prosessimpangeneralsetting'][4];
    $shiftcode = ucwords($_POST['prosessimpangeneralsetting'][5]);
    $mainresource = ucwords($_POST['prosessimpangeneralsetting'][6]);
    $primaryresource = ucwords($_POST['prosessimpangeneralsetting'][7]);
    $secondaryresource = ucwords($_POST['prosessimpangeneralsetting'][8]);
    $mixingresource = ucwords($_POST['prosessimpangeneralsetting'][9]);
    $kodesupplier = ucwords($_POST['prosessimpangeneralsetting'][10]);

    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];

    $sql = mysqli_query($conn, "UPDATE general_setting_web SET  DashboardTitle='$dashboardtitle',
                                                                DashboardContent='$dashboardcontent',
                                                                UserIDCode='$userid',
                                                                RoleCode='$rolecode',
                                                                PassCode='$passcode',
                                                                ShiftCode='$shiftcode',
                                                                MainResourceCode='$mainresource',
                                                                PrimaryResourceCode='$primaryresource',
                                                                SecondaryResourceCode='$secondaryresource',
                                                                MixingResourceCode='$mixingresource',
                                                                KodeSupplier='$kodesupplier',
                                                                ChangedOn='$changedon',
                                                                ChangedBy='$changeby' WHERE Plant = '$plant' AND
                                                                                            UnitCode='$unitcode'");
    if ($sql === true) {
        $return = true;
    }
    echo $return;
}

// ---------------------------------------------------------
// Approval Proses -EXP
// ---------------------------------------------------------
if (isset($_POST['prosesdisplayapprovalproses'])) {
    $planningnumber = $_POST['prosesdisplayapprovalproses'][0];
    $years = $_POST['prosesdisplayapprovalproses'][1];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $dump[] = '';
    $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND 
                                                                    PlanningNumber = '$planningnumber' AND
                                                                    Years='$years'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['status'] = true;
        $dump['planning'] = $q['PlanningNumber'];
        $dump['productid'] = $q['ProductID'];
        $single = mysqli_query($conn, "SELECT ProductDescriptions, StandardRoll, StandardRollKonversi FROM mara_product WHERE ProductID='$q[ProductID]'");
        $row = mysqli_fetch_array($single);
        $dump['productdecription'] = $row['ProductDescriptions'];
        // $dump['standardroll'] = $row['StandardRoll'];
        // $dump['standardrollkonversi'] = $row['StandardRollKonversi'];
        $dump['shiftid'] = $q['ShiftID'];
        $dump['packingdate'] = $q['PackingDate'];
        $dump['resourceid'] = $q['ResourceID'];
        $dump['batchnumber'] = $q['BatchNumber'];
        $dump['expireddate'] = $q['ExpiredDate'];
        $dump['resourceidmix'] = $q['ResourceIDMix'];
        $dump['mixingdate'] = $q['MixingDate'];
        // $dump['quantity'] = $q['Quantity'];
        // $dump['unitofmeasures'] = $q['UnitOfMeasures'];
        // $dump['processnumber'] = $q['ProcessNumber'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['createdon'] = $q['CreatedOn'];
        $dump['changedby'] = $q['ChangedBy'];
        $dump['changedon'] = $q['ChangedOn'];
        $dump['stts'] = $q['Stts'];
        $dump['years'] = $q['Years'];
        $single = mysqli_query($conn, "SELECT Approval FROM approval_step_processing WHERE PlanningNumber='$q[PlanningNumber]'");
        $row = mysqli_fetch_array($single);
        // $dump['statusapproval'] = 'Not Yet Approved';
        // if ($row['Approval'] == 'X') {
        $dump['statusapproval'] = $row['Approval'];
        // }
    }
    echo json_encode($dump);
}
if (isset($_POST['prosesapprovedapprovalproses'])) {
    $return = false;
    $planningnumber = $_POST['prosesapprovedapprovalproses'][0];
    $jenisproses = $_POST['prosesapprovedapprovalproses'][1];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT * FROM approval_step_processing WHERE PlanningNumber='$planningnumber' AND JenisProses='$jenisproses'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        mysqli_query($conn, "UPDATE approval_step_processing 
                                    SET Approval='X', 
                                        CreatedOn='$createdon', 
                                        CreatedBy='$createdby'
                                    WHERE PlanningNumber='$planningnumber' AND JenisProses='$jenisproses'");
        $return = true;
    }
    echo $return;
}

// ---------------------------------------------------------
// User Log
// ---------------------------------------------------------
if (isset($_POST['proseskickuserlog'])) {
    $return = false;
    $userid = $_POST['proseskickuserlog'];
    $sql = mysqli_query($conn, "DELETE FROM user_log WHERE UserID='$userid'");
    if ($sql === true) {
        $return = true;
    }
    echo $return;
}
if (isset($_POST['proseskickuserall'])) {
    $return = false;
    $userid = $_POST['proseskickuserall'];
    $sql = mysqli_query($conn, "DELETE FROM user_log WHERE UserID !='SM000'");
    if ($sql === true) {
        $return = true;
    }
    echo $return;
}

// ---------------------------------------------------------
// System Managemen
// ---------------------------------------------------------
if (isset($_POST['prosescekmessage'])) {
    $dump[] = '';
    $plant = $_SESSION['unitcode'];
    $timenow = date('h:i:s', time());
    $return = false;

    $sql = mysqli_query($conn, "SELECT * FROM user_management WHERE Unit='$plant' AND Stats1 is null");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_array($sql);
        $dump['text'] = $row['Descriptions'];
        $dump['timeleft'] = $row['Time_from'] . ' - ' . $row['Time_to'];
        // Logical
        $a = strtotime($row['Time_from']) - strtotime($timenow);
        if (strtotime($row['Time_from']) - strtotime($timenow) <= 0) {
            mysqli_query($conn, "DELETE FROM user_log WHERE UserID !='SM000'");
            mysqli_query($conn, "UPDATE usr02 SET Locked='X' WHERE UserID !='SM000'");
            mysqli_query($conn, "UPDATE user_management SET Stats1='X' WHERE Unit='$plant'");
            $return = false;
        } else {
            $return = true;
        }
    }
    $dump['a'] = $a;
    $dump['return'] = $return;
    echo json_encode($dump);
}
if (isset($_POST['prosessimpanmessagemaintenance'])) {
    $unit = $_POST['prosessimpanmessagemaintenance'][0];
    $time_from = $_POST['prosessimpanmessagemaintenance'][1];
    $time_to = $_POST['prosessimpanmessagemaintenance'][2];
    $keterangan = ucfirst($_POST['prosessimpanmessagemaintenance'][3]);
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $return = false;

    $sql = mysqli_query($conn, "INSERT INTO user_management (Unit,Time_from,
    Time_to,
    Descriptions,
    CreatedOn,
    CreatedBy) VALUES('$unit','$time_from','$time_to','$keterangan','$createdon','$createdby')");
    if ($sql === true) {
        $return = true;
    }
    echo $return;
}
if (isset($_POST['prosessimpanusermanagemen'])) {
    $unit = $_POST['prosessimpanusermanagemen'][0];
    $type = $_POST['prosessimpanusermanagemen'][1];
    $return = false;
    mysqli_query($conn, "DELETE FROM user_log WHERE UserID !='SM000'");
    if ($type == 'lock') {
        $sql = mysqli_query($conn, "UPDATE usr02 SET Locked='X' WHERE UserID !='SM000'");
    } elseif ($type == 'unlock') {
        $sql = mysqli_query($conn, "UPDATE usr02 SET Locked='' WHERE UserID !='SM000'");
    }

    if ($sql === true) {
        $return = true;
    }
    echo $return;
}

// ---------------------------------------------------------
// Analisa Pengemasan Sekunder
// ---------------------------------------------------------
if (isset($_POST['prosesdisplayanalisakemasansekunder'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosesdisplayanalisakemasansekunder'][0];
    $years = $_POST['prosesdisplayanalisakemasansekunder'][1];
    $isi = 0;
    $dump[] = '';
    $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND 
                                                                    PlanningNumber = '$planningnumber' AND
                                                                    Years='$years'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $dump['status'] = true;
        $dump['planning'] = $q['PlanningNumber'];
        // $_SESSION['planningnumber'] = $q['PlanningNumber'];
        $dump['productid'] = $q['ProductID'];
        $single = mysqli_query($conn, "SELECT ProductDescriptions, StandardRoll, StandardRollKonversi FROM mara_product WHERE ProductID='$q[ProductID]'");
        $row = mysqli_fetch_array($single);
        $dump['productdecription'] = $row['ProductDescriptions'];
        $dump['standardroll'] = $row['StandardRoll'];
        // $dump['shiftid'] = $q['ShiftID'];
        $dump['packingdate'] = $q['PackingDate'];
        $dump['nomesin'] = $q['ResourceID'];
        $dump['batchnumber'] = $q['BatchNumber'];
        $dump['expireddate'] = $q['ExpiredDate'];
        $dump['resourceidmix'] = $q['ResourceIDMix'];
        $dump['mixingdate'] = $q['MixingDate'];
        $dump['quantity'] = $q['Quantity'];
        $dump['unitofmeasures'] = $q['UnitOfMeasures'];
        $dump['processnumber'] = $q['ProcessNumber'];
        $dump['jmlfrek'] = $q['JmlCthFrekuensi'];
        $dump['mntfrek'] = $q['MntFrekuensi'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['createdon'] = $q['CreatedOn'];
        $dump['changedby'] = $q['ChangedBy'];
        $dump['changedon'] = $q['ChangedOn'];
        $dump['stts'] = $q['Stts'];
        $dump['years'] = $q['Years'];
        $dump['prod'] = $q['ProductID'] . '/ ' . date('F Y', strtotime($q['ExpiredDate'])) . '/ ' . $q['BatchNumber'];
        $item = 1;
        $isi = false;
        $sql = mysqli_query($conn, "SELECT * FROM qc_pengemasansekunder WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND 
                                                                        PlanningNumber = '$planningnumber' AND
                                                                        Years='$years'");
        if (mysqli_num_rows($sql) > 0) {
            while ($q = mysqli_fetch_array($sql)) {
                $item = $item + 1;
                $isi = 1;
            }
            $isi = true;
        }
        $dump['item'] = $item;
    }
    $dump['isi'] = $isi;
    echo json_encode($dump);
}
if (isset($_POST['showtableanalisakemasansekunder'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['showtableanalisakemasansekunder'][0];
    $years = $_POST['showtableanalisakemasansekunder'][1];
    $output = '<table id="ddisplayplanning2" class="table table-sm overflow-scroll fw-bold text-wrap" style="width:100%;overflow-x:auto !important;">
    <thead class="text-center border-2 border-dark align-middle bg-secondary fw-bold text-white">
        <tr>
            <td rowspan="4" class="border-2">#</td>
            <td rowspan="4" class="border-2">Jam</td>
            <td rowspan="4" class="border-2">Kode<br>Sachet</td>
            <td colspan="5" class="border-2">Outer Roll/Tanpa Outer Roll</td>
            <td colspan="11" class="border-2">BOX</td>
            <td rowspan="4" class="border-2">Ket</td>   
        </tr>
        <tr>
            <td rowspan="3" class="border-2">Jml Sct<br>#Sesuai</td>
            <td rowspan="3" class="border-2">Sachet<br>Bocor</td>
            <td colspan="2" class="border-2">Outer Roll</td>
            <td rowspan="3" class="border-2">Brosur<br># ada</td>
            <td rowspan="3" class="border-2">Jml O.R/<br>sct T.O.R #sesuai</td>
            <td colspan="4" class="border-2">Kodifikasi</td>
            <td rowspan="3" class="border-2">Jam</td>
            <td rowspan="3" class="border-2">No Box</td>
            <td rowspan="3" class="border-2">Jml<br>Sampel</td>
            <td colspan="3" class="border-2">Seal Tape</td>
        </tr>
        <tr>
            <td rowspan="2" class="border-2">Bocor</td>
            <td rowspan="2" class="border-2"># Rapi</td>
            <td rowspan="2" class="border-2">Ket<br>Produk</td>
            <td rowspan="2" class="border-2">Kode<br>Produksi</td>
            <td rowspan="2" class="border-2">ED/BC</td>
            <td rowspan="2" class="border-2">Opr</td>
            <td rowspan="2" class="border-2"># Melekat Sempurna<br>pada posisinya</td>
            <td colspan="2" class="border-2">Panjang Seal Tape #5-6cm</td>
        </tr>
        <tr>
            <td class="border-2">Samping<br>Atas</td>
            <td class="border-2">Samping<br>Bawah</td>
        </tr>
    </thead>
    <tbody style="text-align:center">';
    $sql = mysqli_query($conn, "SELECT * FROM qc_pengemasansekunder WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND
                                                                    Years='$years' AND
                                                                    PlanningNumber='$planningnumber' ORDER By Items ASC");
    $tot_sampel_box = 0;
    while ($row = mysqli_fetch_array($sql)) {
        $output .= '
        <tr>
            <td><a href="#" class="badge bg-white text-dark href_transform" onclick="deleteprosesanalisapengemasansekunder(' . $row["PlanningNumber"] . ',' . $row["Items"] . ',' . $row["Years"] . ')"><img src="../asset/img/delete.png">' . $row["Items"] . '</a></td>
            <td>' . $row["Jam"] . '</td>
            <td>' . $row["KodeSachet"] . '</td>
            <td>' . $row["Roll_JmlSct"] . '</td>
            <td>' . $row["Roll_Sachet_Bocor"] . '</td>
            <td>' . $row["Roll_Bocor"] . '</td>
            <td>' . $row["Roll_Rapi"] . '</td>
            <td>' . $row["Roll_Brosur"] . '</td>

            <td>' . $row["Box_JmlSct"] . '</td>
            <td>' . $row["Box_KetProduk"] . '</td>
            <td>' . $row["Box_KodeProd"] . '</td>
            <td>' . $row["Box_EdBc"] . '</td>
            <td>' . $row["Box_Opr"] . '</td>
            <td>' . $row["Box_Jam"] . '</td>
            <td>' . $row["Box_NoBox"] . '</td>
            <td>' . $row["Box_JmlSampel"] . '</td>
            <td>' . $row["Box_mlkt"] . '</td>
            <td>' . $row["Box_atas"] . '</td>
            <td>' . $row["Box_bawah"] . '</td>
            <td>' . $row["Ket"] . '</td>
        </tr>';
        $tot_sampel_box += $row["Box_JmlSampel"];
    }
    $output .= '
        <tr style="border-top: 2px solid black">
            <td colspan=15 class="text-start fw-bold fs-6">Total Sampel</td>
            <td class="text-center fw-bold fs-6">' . $tot_sampel_box . '</td>
            <td colspan=4></td>
        </tr>
    ';
    $output .= '
    </tbody>
    </table>';
    $isi = 0;
    $sql = mysqli_query($conn, "SELECT * FROM qc_pengemasansekunder_header WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND 
                                                                        PlanningNumber = '$planningnumber' AND
                                                                        Years='$years'");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $isi = 1;
        $dump['shiftid'] = $r['ShiftID'];
        include_once 'getvalue.php';
        $dump['koor'] = $r['Koor_IPC'] . ' - ' . Getdata('EmployeeName', 'pa001', 'PersonnelNumber', $r['Koor_IPC']);
        // $dump['nomesin'] = $r['NoMesin'];

        $dump['roll_ins'] = $r['Roll_ins'];
        $dump['roll_tpk'] = $r['Roll_tpk'];
        $dump['roll_cth'] = $r['Roll_cth'];
        $dump['roll_msn'] = $r['Roll_msn'];
        $dump['roll_lt'] = $r['Roll_lt'];
        $dump['box_ins'] = $r['Box_ins'];
        $dump['box_tpk'] = $r['Box_tpk'];
        $dump['box_cth'] = $r['Box_cth'];
        $dump['box_msn'] = $r['Box_msn'];
        $dump['box_lt'] = $r['Box_lt'];

        $dump['roll_ud'] = $r['Roll_UD'];
        $dump['roll_jmlfrek'] = $r['Roll_JmlCthFrekuensi'];
        $dump['roll_mntfrek'] = $r['Roll_MntFrekuensi'];
        $dump['box_ud'] = $r['Box_UD'];
        $dump['box_jmlfrek'] = $r['Box_JmlCthFrekuensi'];
        $dump['box_mntfrek'] = $r['Box_MntFrekuensi'];

        if ($r['Roll_UD'] == '' || $r['Box_UD'] == '') {
            $dump['roll_ud'] = 'Lulus';
            $dump['box_ud'] = 'Lulus';
        }
    } else {
        $dump['roll_ins'] = 0;
        $dump['roll_tpk'] = '';
        $dump['roll_cth'] = 0;
        $dump['roll_msn'] = 0;
        $dump['roll_lt'] = '';
        $dump['box_ins'] = 0;
        $dump['box_tpk'] = '';
        $dump['box_cth'] = 0;
        $dump['box_msn'] = 0;
        $dump['box_lt'] = '';

        $dump['roll_ud'] = 'Lulus';
        $dump['roll_jmlfrek'] = 0;
        $dump['roll_mntfrek'] = $r['Roll_MntFrekuensi'];
        $dump['box_ud'] = 'Tolak';
        $dump['box_jmlfrek'] = 0;
        $dump['box_mntfrek'] = 0;
    }
    $dump['output'] = $output;
    $dump['isi'] = $isi;
    echo json_encode($dump);
}
if (isset($_POST['prosessimpanrollanalisapengemasansekunder'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosessimpanrollanalisapengemasansekunder'][0];
    $jam = $_POST['prosessimpanrollanalisapengemasansekunder'][1];
    $kodesachet = $_POST['prosessimpanrollanalisapengemasansekunder'][2];
    $jmlsachet = $_POST['prosessimpanrollanalisapengemasansekunder'][3];
    $sachetbocor = $_POST['prosessimpanrollanalisapengemasansekunder'][4];
    $bocor = $_POST['prosessimpanrollanalisapengemasansekunder'][5];
    $rapi = $_POST['prosessimpanrollanalisapengemasansekunder'][6];
    $brosur = $_POST['prosessimpanrollanalisapengemasansekunder'][7];
    $item = $_POST['prosessimpanrollanalisapengemasansekunder'][8];
    $years = $_POST['prosessimpanrollanalisapengemasansekunder'][9];
    $shiftid = $_POST['prosessimpanrollanalisapengemasansekunder'][10];
    $koor = $_POST['prosessimpanrollanalisapengemasansekunder'][11];
    $nomesin = $_POST['prosessimpanrollanalisapengemasansekunder'][12];
    $roll_ins = $_POST['prosessimpanrollanalisapengemasansekunder'][13];
    $box_ins = $_POST['prosessimpanrollanalisapengemasansekunder'][14];
    $roll_tpk = $_POST['prosessimpanrollanalisapengemasansekunder'][15];
    $box_tpk = $_POST['prosessimpanrollanalisapengemasansekunder'][16];
    $roll_cth = $_POST['prosessimpanrollanalisapengemasansekunder'][17];
    $box_cth = $_POST['prosessimpanrollanalisapengemasansekunder'][18];
    $roll_msn = $_POST['prosessimpanrollanalisapengemasansekunder'][19];
    $box_msn = $_POST['prosessimpanrollanalisapengemasansekunder'][20];
    $roll_lt = $_POST['prosessimpanrollanalisapengemasansekunder'][21];
    $box_lt = $_POST['prosessimpanrollanalisapengemasansekunder'][22];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $koor_convert = explode(" ", $koor);
    $koor = $koor_convert[0];
    $return = false;

    $sql = mysqli_query($conn, "SELECT * FROM qc_pengemasansekunder_header WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND 
                                                                                PlanningNumber='$planningnumber' AND 
                                                                                Years='$years'");
    if (mysqli_num_rows($sql) == 0) {
        $r = mysqli_fetch_array($sql);
        mysqli_query($conn, "INSERT INTO qc_pengemasansekunder_header (Plant,
                                                                        UnitCode,
                                                                        PlanningNumber,
                                                                        Years,
                                                                        ShiftID,
                                                                        NoMesin,
                                                                        Koor_IPC,
                                                                        Roll_ins,
                                                                        Roll_tpk,
                                                                        Roll_cth,
                                                                        Roll_msn,
                                                                        Roll_lt,
                                                                        Box_ins,
                                                                        Box_tpk,
                                                                        Box_cth,
                                                                        Box_msn,
                                                                        Box_lt,
                                                                        CreatedOn,
                                                                        CreatedBy)
                            VALUES('$plant',
                                    '$unitcode',
                                    '$planningnumber',
                                    '$years',
                                    '$shiftid',
                                    '$nomesin',
                                    '$koor',
                                    '$roll_ins',
                                    '$roll_tpk',
                                    '$roll_cth',
                                    '$roll_msn',
                                    '$roll_lt',
                                    '$box_ins',
                                    '$box_tpk',
                                    '$box_cth',
                                    '$box_msn',
                                    '$box_lt',
                                    '$createdon',
                                    '$createdby')");
    } else {
        mysqli_query($conn, "UPDATE qc_pengemasansekunder_header SET ShiftID='$shiftid', 
                                                                    Nomesin='$nomesin',
                                                                    Koor_IPC='$koor',
                                                                    Roll_ins='$roll_ins',
                                                                    Roll_tpk='$roll_tpk',
                                                                    Roll_cth='$roll_cth',
                                                                    Roll_msn='$roll_msn',
                                                                    Roll_lt='$roll_lt',
                                                                    Box_ins='$box_ins',
                                                                    Box_tpk='$box_tpk',
                                                                    Box_cth='$box_cth',
                                                                    Box_msn='$box_msn',
                                                                    Box_lt='$box_lt'
                                                                    WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND 
                                                                            PlanningNumber='$planningnumber' AND 
                                                                            Years='$years'");
    }

    $sql = mysqli_query($conn, "SELECT * FROM qc_pengemasansekunder WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND 
                                                                    PlanningNumber='$planningnumber' AND 
                                                                    Years='$years' AND
                                                                    Items='$item'");
    if (mysqli_num_rows($sql) == 0) {
        $query = mysqli_query($conn, "INSERT INTO qc_pengemasansekunder(Plant,
                                                                        UnitCode,
                                                                        PlanningNumber,
                                                                        Years,
                                                                        Items,
                                                                        Jam,
                                                                        KodeSachet,
                                                                        Roll_JmlSct,
                                                                        Roll_Sachet_Bocor,
                                                                        Roll_Bocor,
                                                                        Roll_Rapi,
                                                                        Roll_Brosur,
                                                                        CreatedOn,
                                                                        CreatedBy)
                                                                        VALUES ('$plant',
                                                                                '$unitcode',
                                                                                '$planningnumber',
                                                                                '$years',
                                                                                '$item',
                                                                                '$jam',
                                                                                '$kodesachet',
                                                                                '$jmlsachet',
                                                                                '$sachetbocor',
                                                                                '$bocor',
                                                                                '$rapi',
                                                                                '$brosur',
                                                                                '$createdon',
                                                                                '$createdby')");
    } else {
        $query = mysqli_query($conn, "UPDATE qc_pengemasansekunder SET Jam='$jam',
                                                                    KodeSachet='$kodesachet',
                                                                    Roll_JmlSct='$jmlsachet',
                                                                    Roll_Sachet_Bocor='$sachetbocor',
                                                                    Roll_Bocor='$bocor',
                                                                    Roll_Rapi='$rapi',
                                                                    Roll_Brosur='$brosur'
                                    WHERE Plant='$plant' AND 
                                            UnitCode='$unitcode' AND 
                                            PlanningNumber = '$planningnumber' AND
                                            Years='$years' AND
                                            Items='$item'");
    }
    if ($query === true) {
        $item = 1;
        $sql = mysqli_query($conn, "SELECT * FROM qc_pengemasansekunder WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND 
                                                                                PlanningNumber = '$planningnumber' AND
                                                                                Years='$years'");
        if (mysqli_num_rows($sql) > 0) {
            while ($q = mysqli_fetch_array($sql)) {
                $item = $item + 1;
            }
        }
        $dump['item'] = $item;
        $return = true;
    }
    $dump['return'] = $return;
    echo json_encode($dump);
}
if (isset($_POST['prosessimpananboxanalisapengemasansekunder'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosessimpananboxanalisapengemasansekunder'][0];
    $jml_or = $_POST['prosessimpananboxanalisapengemasansekunder'][1];
    $ket_produksi = $_POST['prosessimpananboxanalisapengemasansekunder'][2];
    $kodeproduksi = $_POST['prosessimpananboxanalisapengemasansekunder'][3];
    $edbc = $_POST['prosessimpananboxanalisapengemasansekunder'][4];
    $opr = $_POST['prosessimpananboxanalisapengemasansekunder'][5];
    $jam = $_POST['prosessimpananboxanalisapengemasansekunder'][6];
    $nobox = $_POST['prosessimpananboxanalisapengemasansekunder'][7];
    $jmlsampel = $_POST['prosessimpananboxanalisapengemasansekunder'][8];
    $melekat = $_POST['prosessimpananboxanalisapengemasansekunder'][9];
    $sampingatas = $_POST['prosessimpananboxanalisapengemasansekunder'][10];
    $sampingbawah = $_POST['prosessimpananboxanalisapengemasansekunder'][11];
    $ket = $_POST['prosessimpananboxanalisapengemasansekunder'][12];
    $item = $_POST['prosessimpananboxanalisapengemasansekunder'][13];
    $years = $_POST['prosessimpananboxanalisapengemasansekunder'][14];
    $shiftid = $_POST['prosessimpananboxanalisapengemasansekunder'][15];
    $koor = $_POST['prosessimpananboxanalisapengemasansekunder'][16];
    $nomesin = $_POST['prosessimpananboxanalisapengemasansekunder'][17];
    $roll_ins = $_POST['prosessimpananboxanalisapengemasansekunder'][18];
    $box_ins = $_POST['prosessimpananboxanalisapengemasansekunder'][19];
    $roll_tpk = $_POST['prosessimpananboxanalisapengemasansekunder'][20];
    $box_tpk = $_POST['prosessimpananboxanalisapengemasansekunder'][21];
    $roll_cth = $_POST['prosessimpananboxanalisapengemasansekunder'][22];
    $box_cth = $_POST['prosessimpananboxanalisapengemasansekunder'][23];
    $roll_msn = $_POST['prosessimpananboxanalisapengemasansekunder'][24];
    $box_msn = $_POST['prosessimpananboxanalisapengemasansekunder'][25];
    $roll_lt = $_POST['prosessimpananboxanalisapengemasansekunder'][26];
    $box_lt = $_POST['prosessimpananboxanalisapengemasansekunder'][27];
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];
    $return = false;

    $koor_convert = explode(" ", $koor);
    $koor = $koor_convert[0];

    // UDPATE HEADER
    $sql = mysqli_query($conn, "SELECT * FROM qc_pengemasansekunder_header WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND 
                                                                                PlanningNumber='$planningnumber' AND 
                                                                                Years='$years'");
    if (mysqli_num_rows($sql) == 0) {
        $r = mysqli_fetch_array($sql);
        mysqli_query($conn, "INSERT INTO qc_pengemasansekunder_header (Plant,
                                                                        UnitCode,
                                                                        PlanningNumber,
                                                                        Years,
                                                                        ShiftID,
                                                                        NoMesin,
                                                                        Koor_IPC,
                                                                        Roll_ins,
                                                                        Roll_tpk,
                                                                        Roll_cth,
                                                                        Roll_msn,
                                                                        Roll_lt,
                                                                        Box_ins,
                                                                        Box_tpk,
                                                                        Box_cth,
                                                                        Box_msn,
                                                                        Box_lt,
                                                                        CreatedOn,
                                                                        CreatedBy)
                            VALUES('$plant',
                                    '$unitcode',
                                    '$planningnumber',
                                    '$years',
                                    '$shiftid',
                                    '$nomesin',
                                    '$koor',
                                    '$roll_ins',
                                    '$roll_tpk',
                                    '$roll_cth',
                                    '$roll_msn',
                                    '$roll_lt',
                                    '$box_ins',
                                    '$box_tpk',
                                    '$box_cth',
                                    '$box_msn',
                                    '$box_lt',
                                    '$createdon',
                                    '$createdby')");
    } else {
        mysqli_query($conn, "UPDATE qc_pengemasansekunder_header SET ShiftID='$shiftid', 
                                                                    Nomesin='$nomesin',
                                                                    Koor_IPC='$koor',
                                                                    Roll_ins='$roll_ins',
                                                                    Roll_tpk='$roll_tpk',
                                                                    Roll_cth='$roll_cth',
                                                                    Roll_msn='$roll_msn',
                                                                    Roll_lt='$roll_lt',
                                                                    Box_ins='$box_ins',
                                                                    Box_tpk='$box_tpk',
                                                                    Box_cth='$box_cth',
                                                                    Box_msn='$box_msn',
                                                                    Box_lt='$box_lt'
                                                                    WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND 
                                                                            PlanningNumber='$planningnumber' AND 
                                                                            Years='$years'");
    }

    $sql = mysqli_query($conn, "SELECT * FROM qc_pengemasansekunder WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND 
                                                                    PlanningNumber='$planningnumber' AND 
                                                                    Years='$years' AND
                                                                    Items='$item'");
    if (mysqli_num_rows($sql) != 0) {
        $query = mysqli_query($conn, "UPDATE qc_pengemasansekunder SET Box_JmlSct='$jml_or',
                                                                        Box_KetProduk='$ket_produksi',
                                                                        Box_KodeProd='$kodeproduksi',
                                                                        Box_EdBc='$edbc',
                                                                        Box_Opr='$opr',
                                                                        Box_Jam='$jam',
                                                                        Box_NoBox='$nobox',
                                                                        Box_JmlSampel='$jmlsampel',
                                                                        Box_mlkt='$melekat',
                                                                        Box_atas='$sampingatas',
                                                                        Box_bawah='$sampingbawah',
                                                                        Ket='$ket',
                                                                        ChangedBy='$changedby',
                                                                        ChangedOn='$changedon' WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND 
                                                                                PlanningNumber='$planningnumber' AND
                                                                                Years='$years' AND 
                                                                                Items='$item'");
        if ($query === true) {
            $return = true;
        }
    } else {
        $query = mysqli_query($conn, "INSERT INTO qc_pengemasansekunder (Plant,
                                                                        UnitCode,
                                                                        PlanningNumber,
                                                                        Years,
                                                                        Items,
                                                                        Box_JmlSct,
                                                                        Box_KetProduk,
                                                                        Box_KodeProd,
                                                                        Box_EdBc,
                                                                        Box_Opr,
                                                                        Box_Jam,
                                                                        Box_NoBox,
                                                                        Box_JmlSampel,
                                                                        Box_mlkt,
                                                                        Box_atas,
                                                                        Box_bawah,
                                                                        Ket)
                                        VALUES('$plant',
                                                '$unitcode',
                                                '$planningnumber',
                                                '$years',
                                                '$item',
                                                '$jml_or',
                                                '$ket_produksi',
                                                '$kodeproduksi',
                                                '$edbc',
                                                '$opr',
                                                '$jam',
                                                '$nobox',
                                                '$jmlsampel',
                                                '$melekat',
                                                '$sampingatas',
                                                '$sampingbawah',
                                                '$ket')");
    }
    if ($query === true) {
        $item = 1;
        $sql = mysqli_query($conn, "SELECT * FROM qc_pengemasansekunder WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND 
                                                                                PlanningNumber = '$planningnumber' AND
                                                                                Years='$years'");
        if (mysqli_num_rows($sql) > 0) {
            while ($q = mysqli_fetch_array($sql)) {
                $item = $item + 1;
            }
        }
        $dump['item'] = $item;
        $return = true;
    }
    $dump['return'] = $return;
    echo json_encode($dump);
}
if (isset($_POST['prosesdeleteanalisapengemasansekunder'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosesdeleteanalisapengemasansekunder'][0];
    $item = $_POST['prosesdeleteanalisapengemasansekunder'][1];
    $years = $_POST['prosesdeleteanalisapengemasansekunder'][2];
    $return = false;

    $sql = mysqli_query($conn, "DELETE FROM qc_pengemasansekunder WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND 
                                                                    PlanningNumber='$planningnumber' AND
                                                                    Years='$years' AND
                                                                    Items='$item'");
    if ($sql === true) {
        $item = 1;
        $sql = mysqli_query($conn, "SELECT * FROM qc_pengemasansekunder WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND 
                                                                        PlanningNumber = '$planningnumber' AND
                                                                        Years='$years' ORDER By Items ASC");
        if (mysqli_num_rows($sql) > 0) {
            while ($q = mysqli_fetch_array($sql)) {
                mysqli_query($conn, "UPDATE qc_pengemasansekunder SET Items='$item' WHERE Plant='$plant' AND 
                                                                                    UnitCode='$unitcode' AND 
                                                                                    PlanningNumber = '$planningnumber' AND 
                                                                                    Years='$years' AND
                                                                                    Items='$q[Items]'");
                $item = $item + 1;
            }
        }
        $item = 1;
        $isi = false;
        $sql = mysqli_query($conn, "SELECT * FROM qc_pengemasansekunder WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND 
                                                                        PlanningNumber = '$planningnumber' AND
                                                                        Years='$years'");
        if (mysqli_num_rows($sql) > 0) {
            while ($q = mysqli_fetch_array($sql)) {
                $item = $item + 1;
            }
            $isi = true;
        }

        $sql = mysqli_query($conn, "SELECT * FROM qc_pengemasansekunder WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND 
                                                                        PlanningNumber = '$planningnumber' AND
                                                                        Years='$years'");
        if (mysqli_num_rows($sql) == 0) {
            mysqli_query($conn, "DELETE FROM qc_pengemasansekunder_header WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND 
                                                                        PlanningNumber = '$planningnumber' AND
                                                                        Years='$years'");
        }
        $dump['isi'] = $isi;
        $dump['item'] = $item;
        $return = true;
        $dump['return'] = $return;
    }

    echo json_encode($dump);
}
if (isset($_POST['prosessimpanananalisapengemasansekunder'])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $planningnumber = $_POST['prosessimpanananalisapengemasansekunder'][0];
    $box = strtolower($_POST['prosessimpanananalisapengemasansekunder'][1]);
    $roll = strtolower($_POST['prosessimpanananalisapengemasansekunder'][2]);
    $years = $_POST['prosessimpanananalisapengemasansekunder'][3];
    $rolljmlfrek = $_POST['prosessimpanananalisapengemasansekunder'][4];
    $rollmntfrek = $_POST['prosessimpanananalisapengemasansekunder'][5];
    $boxjmlfrek = $_POST['prosessimpanananalisapengemasansekunder'][6];
    $boxmntfrek = $_POST['prosessimpanananalisapengemasansekunder'][7];
    $shiftid = $_POST['prosessimpanananalisapengemasansekunder'][8];
    $koor = $_POST['prosessimpanananalisapengemasansekunder'][9];
    $nomesin = $_POST['prosessimpanananalisapengemasansekunder'][10];
    $roll_ins = $_POST['prosessimpanananalisapengemasansekunder'][11];
    $box_ins = $_POST['prosessimpanananalisapengemasansekunder'][12];
    $roll_tpk = $_POST['prosessimpanananalisapengemasansekunder'][13];
    $box_tpk = $_POST['prosessimpanananalisapengemasansekunder'][14];
    $roll_cth = $_POST['prosessimpanananalisapengemasansekunder'][15];
    $box_cth = $_POST['prosessimpanananalisapengemasansekunder'][16];
    $roll_msn = $_POST['prosessimpanananalisapengemasansekunder'][17];
    $box_msn = $_POST['prosessimpanananalisapengemasansekunder'][18];
    $roll_lt = $_POST['prosessimpanananalisapengemasansekunder'][19];
    $box_lt = $_POST['prosessimpanananalisapengemasansekunder'][20];
    $prosestype = 'analisapengemasansekunder';
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];
    $return = false;

    $koor_convert = explode(" ", $koor);
    $koor = $koor_convert[0];

    // UDPATE HEADER
    $sql = mysqli_query($conn, "SELECT * FROM qc_pengemasansekunder_header WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND 
                                                                                PlanningNumber='$planningnumber' AND 
                                                                                Years='$years'");
    if (mysqli_num_rows($sql) == 0) {
        $r = mysqli_fetch_array($sql);
        mysqli_query($conn, "INSERT INTO qc_pengemasansekunder_header (Plant,
                                                                        UnitCode,
                                                                        PlanningNumber,
                                                                        Years,
                                                                        ShiftID,
                                                                        NoMesin,
                                                                        Koor_IPC,
                                                                        Roll_ins,
                                                                        Roll_tpk,
                                                                        Roll_cth,
                                                                        Roll_msn,
                                                                        Roll_lt,
                                                                        Box_ins,
                                                                        Box_tpk,
                                                                        Box_cth,
                                                                        Box_msn,
                                                                        Box_lt,
                                                                        CreatedOn,
                                                                        CreatedBy)
                            VALUES('$plant',
                                    '$unitcode',
                                    '$planningnumber',
                                    '$years',
                                    '$shiftid',
                                    '$nomesin',
                                    '$koor',
                                    '$roll_ins',
                                    '$roll_tpk',
                                    '$roll_cth',
                                    '$roll_msn',
                                    '$roll_lt',
                                    '$box_ins',
                                    '$box_tpk',
                                    '$box_cth',
                                    '$box_msn',
                                    '$box_lt',
                                    '$createdon',
                                    '$createdby')");
    } else {
        mysqli_query($conn, "UPDATE qc_pengemasansekunder_header SET ShiftID='$shiftid', 
                                                                    Nomesin='$nomesin',
                                                                    Koor_IPC='$koor',
                                                                    Roll_ins='$roll_ins',
                                                                    Roll_tpk='$roll_tpk',
                                                                    Roll_cth='$roll_cth',
                                                                    Roll_msn='$roll_msn',
                                                                    Roll_lt='$roll_lt',
                                                                    Box_ins='$box_ins',
                                                                    Box_tpk='$box_tpk',
                                                                    Box_cth='$box_cth',
                                                                    Box_msn='$box_msn',
                                                                    Box_lt='$box_lt'
                                                                    WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND 
                                                                            PlanningNumber='$planningnumber' AND 
                                                                            Years='$years'");
    }

    $status = '';
    $sql = mysqli_query($conn, "SELECT * FROM text_sys WHERE Jenisproses='approval' AND Item='1'");
    if (mysqli_num_rows($sql) != 0) {
        $row = mysqli_fetch_array($sql);
        $status = $row['Descriptions'];
    }
    // setapproval($planningnumber, $prosestype, $years);
    mysqli_query($conn, "UPDATE qc_pengemasansekunder_header SET Roll_UD='$roll', Box_UD='$box',Roll_JmlCthFrekuensi='$rolljmlfrek', 
                                                                                        Roll_MntFrekuensi='$rollmntfrek',
                                                                                        Box_JmlCthFrekuensi='$boxjmlfrek', 
                                                                                        Box_MntFrekuensi='$boxmntfrek'

                                                        WHERE Plant='$plant' AND 
                                                        UnitCode='$unitcode' AND 
                                                        PlanningNumber='$planningnumber' AND
                                                        Years='$years'");
    $sql = mysqli_query($conn, "UPDATE planning_prod_header SET AnalisaKemasSekunder='X', 
                                                                ChangedOn='$changedon',
                                                                ChangedBy='$changedby' 
                                                        WHERE Plant='$plant' AND 
                                                        UnitCode='$unitcode' AND 
                                                        PlanningNumber='$planningnumber' AND
                                                        Years='$years'");
    if ($sql === true) {
        $return = true;
    }

    echo $return;
}

// ---------------------------------------------------------
// Data Timbangan
// ---------------------------------------------------------
if (isset($_POST['prosesdisplaydatatimbangan'])) {
    $dump[] = '';
    $return = false;
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $address = trim($_POST['prosesdisplaydatatimbangan']);
    $sql = mysqli_query($conn, "SELECT * FROM mapping_timbangan WHERE Plant='$plant' AND UnitCode='$unitcode' AND AddressOf ='$address' AND StatsX is null or StatsX=''");
    if (mysqli_num_rows($sql) != 0) {
        $row = mysqli_fetch_array($sql);
        $return = true;
        $dump['plant'] = $plant;
        $dump['unitcode'] = $unitcode;
        $dump['ipaddress'] = $row['AddressOf'];
        $dump['namatimbangan'] = $row['NamaTimbangan'];
        $dump['port'] = $row['PortOf'];
        $dump['getweight'] = $row['GetWeight'];
        $dump['autoprint'] = $row['AutoPrint'];
        $dump['autosave'] = $row['AutoSave'];
        $dump['autotimbang'] = $row['AutoTimbang'];
        $dump['stoped'] = $row['Stoped'];
        $return = true;
    } else {
        $return = 2;
    }
    $dump['return'] = $return;
    echo json_encode($dump);
}
if (isset($_POST['prosesunlocktimbangan'])) {
    $ipadd = trim($_POST['prosesunlocktimbangan']);
    $dump[] = '';
    $return = false;
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $pernr = $_SESSION['personnelnumber'];
    $return = false;

    $sql = mysqli_query($conn, "SELECT * FROM mapping_timbangan WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND 
                                                                        AddressOf='$ipadd' AND 
                                                                        StatsX='X' AND 
                                                                        UsedBy='$pernr'");
    if (mysqli_num_rows($sql) != 0) {
        $query = mysqli_query($conn, "UPDATE mapping_timbangan SET StatsX = null, UsedBy = null 
                                                                        WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND 
                                                                        AddressOf='$ipadd' AND 
                                                                        StatsX='X' AND 
                                                                        UsedBy='$pernr'");
        if ($query === true) {
            $return = true;
        }
    } else {
        $sql = mysqli_query($conn, "SELECT * FROM mapping_timbangan WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND 
                                                                        AddressOf='$ipadd'");
        if (mysqli_num_rows($sql) != 0) {
            $r = mysqli_fetch_array($sql);
            if ($r['StatsX'] == 'X') {
                $return = 'Timbangan ' . $ipadd . ' sedang dipakai oleh ' . $r['UsedBy'];
            } else {
                $return = 2;
            }
        }
    }
    $dump['return'] = $return;
    echo json_encode($dump);
}
if (isset($_POST['prosesstopedtimbanganchange'])) {
    $return = false;
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $address = trim($_POST['prosesstopedtimbanganchange'][0]);
    $values = $_POST['prosesstopedtimbanganchange'][3];
    if ($values === 'true') {
        $values = 'X';
        $autotimbang = '';
    } else {
        $values = '';
        $autotimbang = 'X';
    }
    $sql = mysqli_query($conn, "SELECT * FROM mapping_timbangan WHERE Plant='$plant' AND UnitCode='$unitcode' AND AddressOf ='$address'");
    if (mysqli_num_rows($sql) != 0) {
        $query = mysqli_query($conn, "UPDATE mapping_timbangan SET Stoped='$values' WHERE Plant='$plant' AND UnitCode='$unitcode' AND AddressOf ='$address'");
        if ($query === true) {
            $return = true;
        }
    }
    echo $return;
}
if (isset($_POST['prosescekkoneksitimbangan'])) {
    $dump[] = '';
    $namatimbangan = $_POST["prosescekkoneksitimbangan"][0];
    $ip = trim($_POST["prosescekkoneksitimbangan"][1]);
    $port = $_POST["prosescekkoneksitimbangan"][2];
    $ifconnect = $_POST["prosescekkoneksitimbangan"][3];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $pernr = $_SESSION["personnelnumber"];
    $return = '';
    $ping_modbus = exec('ping -n 1 -w 1 ' . $ip);
    $result_ping = strpos($ping_modbus, 'Packets');
    if ($ifconnect == 'connect') {
        if ($result_ping != 4) {
            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            $result = socket_connect($socket, $ip, $port);
            if ($result === true) {
                mysqli_query($conn, "UPDATE mapping_timbangan SET StatsX='X', UsedBy='$pernr' WHERE Plant='$plant' AND UnitCode='$unitcode' AND AddressOf ='$ip'");
                $_SESSION['namtim'] = $namatimbangan;
                $_SESSION['ip'] = $ip;
                $_SESSION['port'] = $port;
            }
            socket_close($socket);
            $return = true;
        } else {
            $return = 2;
        }
    }
    if ($ifconnect == 'disconnect') {
        $q = mysqli_query($conn, "UPDATE mapping_timbangan SET StatsX= null, UsedBy=null WHERE Plant='$plant' AND UnitCode='$unitcode' AND AddressOf ='$ip'");
        $_SESSION['namtim'] = null;
        $_SESSION['ip'] = null;
        $_SESSION['port'] = null;
        socket_close($socket);
        $return = true;
    }
    if ($ifconnect == 'cekconnect') {
        $sql = mysqli_query($conn, "SELECT * FROM mapping_timbangan WHERE Plant='$plant' AND UnitCode='$unitcode' AND UsedBy ='$pernr'");
        if (mysqli_num_rows($sql) != 0) {
            if ($_SESSION['namtim'] !== null && $_SESSION['ip'] !== null && $_SESSION['port'] !== null) {
                $_SESSION['namtim'] = $namatimbangan;
                $_SESSION['ip'] = $ip;
                $_SESSION['port'] = $port;
                $sql = mysqli_query($conn, "SELECT * FROM mapping_timbangan WHERE Plant='$plant' AND UnitCode='$unitcode' AND AddressOf ='$ip'");
                if (mysqli_num_rows($sql) != 0) {
                    $row = mysqli_fetch_array($sql);
                    $return = true;
                    $dump['plant'] = $plant;
                    $dump['unitcode'] = $unitcode;
                    $dump['ipaddress'] = $row['AddressOf'];
                    $dump['namatimbangan'] = $row['NamaTimbangan'];
                    $dump['port'] = $row['PortOf'];
                    $dump['getweight'] = $row['GetWeight'];
                    $dump['autoprint'] = $row['AutoPrint'];
                    $dump['autosave'] = $row['AutoSave'];
                    $dump['autotimbang'] = $row['AutoTimbang'];
                    $dump['stoped'] = $row['Stoped'];
                    $dump['satuan'] = $row['Satuan'];
                    mysqli_query($conn, "UPDATE mapping_timbangan SET StatsX='X', UsedBy='$pernr' WHERE Plant='$plant' AND UnitCode='$unitcode' AND AddressOf ='$ip'");
                }
                $return = true;
            } else {
                mysqli_query($conn, "UPDATE mapping_timbangan SET StatsX= null, UsedBy=null WHERE Plant='$plant' AND UnitCode='$unitcode' AND UsedBy ='$pernr'");
                $return = 2;
            }
        }
    }
    $dump['cb'] = $response;
    $dump['return'] = $return;
    echo json_encode($dump);
}
if (isset($_POST['prosescekkoneksitimbangan2'])) {
    $dump[] = '';
    $ip = trim($_POST["prosescekkoneksitimbangan2"][0]);
    $port = $_POST["prosescekkoneksitimbangan2"][1];
    $weight = $_POST["prosescekkoneksitimbangan2"][2];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $return = false;

    // Start
    $sql = mysqli_query($conn, "SELECT Satuan FROM mapping_timbangan WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            AddressOf='$ip'");
    if (mysqli_num_rows($sql) != 0) {
        $row = mysqli_fetch_array($sql);
        $dump['satuan'] = $row['Satuan'];
    }
    $response = '';
    $ping_modbus = exec('ping -n 1 -w 1 ' . $ip);
    $result_ping = strpos($ping_modbus, 'Packets');
    if ($result_ping != 4) {
        $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die('ERROR');
        $socket_bind = socket_bind($sock, $ip, $port);
        $socket_listen = socket_listen($sock, 1);
        $socket_accept = socket_accept($sock);
        $sock_konek = socket_connect($sock, $ip, $port) or die('ERROR');
        if ($sock_konek === true) {
            socket_set_option($sock, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 1, "usec" => 0));
            // $test = socket_set_nonblock($sock);
            $response = socket_read($sock, 2048, MSG_PEEK);
            if ($response === FALSE || strcmp($response, '') == 0) {
                $code = socket_last_error($sock);

                // You MUST clear the error, or it will not change on next read
                socket_clear_error($sock);

                // if ($code == SOCKET_EAGAIN) {
                //     // Nothing to read from non-blocking socket, try again later...

                // } else {
                //     // Connection most likely closed, especially if $code is '0'
                // }
            } else {
                $response_min = $replaced = preg_replace('/\s\s+/', ' ', $response);
                $net = explode(" ", $response_min);
                if ($weight == 'gross') {
                    $dump['weight'] = $net[0];
                    $dump['weight_qty'] = $net[1];
                    $dump['weight_uom'] = $net[2];
                }
                if ($weight == 'tare') {
                    $dump['weight'] = $net[3];
                    $dump['weight_qty'] = $net[4];
                    $dump['weight_uom'] = $net[5];
                }
                if ($weight == 'net') {
                    $dump['weight'] = $net[6];
                    $dump['weight_qty'] = $net[7];
                    $dump['weight_uom'] = $net[8];
                }
                $return = true;
            }
        }
        socket_close($sock);
    }
    // End 
    $dump['cb'] = $response;
    $dump['return'] = $return;
    echo json_encode($dump);
}
if (isset($_POST["prosesgetdatatimbangan"])) {
    $net = '';
    $address = trim($_POST["prosesgetdatatimbangan"][0]);
    $port = $_POST["prosesgetdatatimbangan"][1];
    $weight = trim($_POST["prosesgetdatatimbangan"][2]);
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $command = '';
    $return = false;
    $sql = mysqli_query($conn, "SELECT AutoCommand FROM mapping_timbangan WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            AddressOf='$address'");
    if (mysqli_num_rows($sql) != 0) {
        $row = mysqli_fetch_array($sql);
        $command = $row['AutoCommand'];
    }

    $ping_modbus = exec('ping -n 1 -w 1 ' . $address);
    $result_ping = strpos($ping_modbus, 'Packets');
    if ($result_ping != 4) {
        $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die('ERROR');
        $sock_konek = socket_connect($sock, $address, $port) or die('ERROR');
        if ($sock_konek === true) {
            $cb = socket_sendto($sock, $command, 65535, 0, $address, $port);
            if ($cb == 1) {
                $response = socket_read($sock, 65535);
                $response_min = preg_replace('/\s\s+/', ' ', $response);
                $net = explode(" ", $response_min);
                if ($weight == 'gross') {
                    $dump['weight'] = $net[1];
                    $dump['weight_qty'] = $net[2];
                    $dump['weight_uom'] = $net[3];
                }
                if ($weight == 'tare') {
                    $dump['weight'] = $net[4];
                    $dump['weight_qty'] = $net[5];
                    $dump['weight_uom'] = $net[6];
                }
                if ($weight == 'net') {
                    $dump['weight'] = $net[7];
                    $dump['weight_qty'] = $net[8];
                    $dump['weight_uom'] = $net[9];
                }
                $return = 1;
            }
        }
        socket_close($sock);
    } else {
        $return = 2;
    }
    $dump['cb'] = $net;
    $dump['return'] = $return;
    echo json_encode($dump);
}
if (isset($_POST["prosesadditionaldatatimbangan"])) {
    $dump[] = '';
    $return = false;
    $dump['namatimbangan'] = 'Tidak diketahui';
    if ($_SESSION['namtim'] !== '' && $_SESSION['ip'] !== '' && $_SESSION['port'] !== '') {
        $dump['namatimbangan'] = $_SESSION['namtim'];
        $dump['ip'] = $_SESSION['ip'];
        $dump['port'] = $_SESSION['port'];
        $return = true;
    }
    $dump['return'] = $return;
    echo json_encode($dump);
}
if (isset($_POST["prosesactivemanualinput_drymixed"])) {
    $productid = $_POST["prosesactivemanualinput_drymixed"][0];
    $batch = $_POST["prosesactivemanualinput_drymixed"][1];
    $swab = $_POST["prosesactivemanualinput_drymixed"][2];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $ip = $_SESSION['ip'];
    $port = $_SESSION['port'];
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];
    $return = false;


    if ($swab == 'on') {
        $sql = mysqli_query($conn, "SELECT * FROM manualinput_dry_mixed WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            AddressOf='' AND
                                                                            StatsX ='' or StatsX is null");
        if (mysqli_num_rows($sql) != 0) {
            $sql = mysqli_query($conn, "SELECT * FROM manualinput_dry_mixed WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            AddressOf='$ip' AND
                                                                            StatsX ='X'");
            if (mysqli_num_rows($sql) == 0) {
                $query = mysqli_query($conn, "UPDATE manualinput_dry_mixed SET AddressOf='$ip',Port='$port',StatsX='X' WHERE Plant='$plant' AND
                                                                                                UnitCode='$unitcode' AND
                                                                                                ProductID='$productid' AND
                                                                                                BatchNumber ='$batch'");
                $return = $query;
            } else {
                $row = mysqli_fetch_array($sql);
                $return = 'Timbangan sedang digunakan untuk menimbang ' . $row['ProductID'] . ' Bets ' . $row['BatchNumber'];
            }
        }
    } else {
        $query = mysqli_query($conn, "UPDATE manualinput_dry_mixed SET StatsX = null, AddressOf ='-' WHERE Plant='$plant' AND
                                                                                                    UnitCode='$unitcode' AND
                                                                                                    ProductID='$productid' AND
                                                                                                    BatchNumber ='$batch' AND
                                                                                                    AddressOf ='$ip'");

        $return = $query;
    }

    echo $return;
}
if (isset($_POST["prosessimpanhasiltimbang"])) {
    $return = false;
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $berat = $_POST["prosessimpanhasiltimbang"][0];
    $ip = $_POST["prosessimpanhasiltimbang"][1];
    $port = $_POST["prosessimpanhasiltimbang"][2];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $usedby = $_SESSION['userid'];
    $dump[] = '';
    $dump['qty'] = $berat;
    $sql = mysqli_query($conn, "SELECT Satuan FROM mapping_timbangan WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            AddressOf='$ip'");
    if (mysqli_num_rows($sql) != 0) {
        $row = mysqli_fetch_array($sql);
        $satuan = $row['Satuan'];
    }
    $sql = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_header WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            UsedBy='$usedby' AND
                                                                            AddressOf='$ip'");
    if (mysqli_num_rows($sql) != 0) {
        $row = mysqli_fetch_array($sql);
        $planningnumber = $row['PlanningNumber'];
        $dump['planningnumber'] = $row['PlanningNumber'];
        $years = $row['Years'];
        $dump['years'] = $row['Years'];
        $item = $row['Items'];
        $dump['item'] = $row['Items'];
        $produkid = $row['ProductID'];
        $ed = $row['ExpiredDate'];
        $nomixing = $row['ResourceIDMix'];
        $mixingdate = $row['MixingDate'];

        $dump['productid'] = $produkid;
        $dump['bets'] = $bets;

        $query = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND 
                                                                                    UnitCode='$unitcode' AND
                                                                                    PlanningNumber='$planningnumber' AND
                                                                                    Years='$years' AND
                                                                                    Items='$item' AND
                                                                                    ProductID='$produkid' AND
                                                                                    NoProses=1 AND
                                                                                    UsedBy='$usedby' AND
                                                                                    Berat=0 ORDER BY NoTong ASC");
        if (mysqli_num_rows($query) != 0) {
            $r = mysqli_fetch_array($query);
            $query = mysqli_query($conn, "UPDATE tbl_hasiltimbang_detail SET Berat='$berat',Satuan='$satuan',EnterOn='$createdon' WHERE Plant='$plant' AND 
                                                                                                                UnitCode='$unitcode' AND
                                                                                                                PlanningNumber='$planningnumber' AND
                                                                                                                Years='$years' AND
                                                                                                                Items='$item' AND
                                                                                                                ProductID='$produkid' AND
                                                                                                                BatchNumber='$r[BatchNumber]' AND
                                                                                                                NoProses=1 AND
                                                                                                                UsedBy='$usedby' AND
                                                                                                                Berat=0 AND
                                                                                                                NoTong='$r[NoTong]'");
            $dump['productid'] = $produkid;
            $dump['bets'] = $r['BatchNumber'];
            $dump['notong'] = $r['NoTong'];
            $dump['noproses'] = $r['NoProses'];
            if ($query === true) {
                $return = true;
            }
        } else {
            $query = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND 
                                                                                        UnitCode='$unitcode' AND
                                                                                        PlanningNumber='$planningnumber' AND
                                                                                        Years='$years' AND
                                                                                        Items='$item' AND
                                                                                        ProductID='$produkid' AND
                                                                                        NoProses=2 AND
                                                                                        UsedBy='$usedby' AND
                                                                                        Berat=0 ORDER BY NoTong ASC");
            if (mysqli_num_rows($query) != 0) {
                $r = mysqli_fetch_array($query);
                $sql = mysqli_query($conn, "UPDATE tbl_hasiltimbang_detail SET Berat='$berat',Satuan='$satuan',EnterOn='$createdon' WHERE Plant='$plant' AND 
                                                                                                                                            UnitCode='$unitcode' AND
                                                                                                                                            PlanningNumber='$planningnumber' AND
                                                                                                                                            Years='$years' AND
                                                                                                                                            Items='$item' AND
                                                                                                                                            ProductID='$produkid' AND
                                                                                                                                            BatchNumber='$r[BatchNumber]' AND
                                                                                                                                            NoProses=2 AND
                                                                                                                                            UsedBy='$usedby' AND
                                                                                                                                            Berat=0 AND
                                                                                                                                            NoTong='$r[NoTong]'");

                $dump['productid'] = $produkid;
                $dump['bets'] = $r['BatchNumber'];
                $dump['noproses'] = $r['NoProses'];
                $dump['notong'] = $r['NoTong'];
                if ($sql === true) {
                    $return = true;
                }
            } else {
                $return = 'Jumlah timbang per batch sudah melebihi batas timbang';
            }
        }
    } else {
        $return = 'Input Additional terlebih dahulu';
    }
    $dump['return'] = $return;
    echo json_encode($dump);
}

// ---------------------------------------------------------
// Configuration
// ---------------------------------------------------------
if (isset($_POST['prosessimpancorrectiondata'])) {
    $proses =  $_POST['prosessimpancorrectiondata'];
    if ($proses === 'log_print') {
        $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header");
        while ($row = mysqli_fetch_array($sql)) {
            $years = $row['Years'];
            $planning = $row['PlanningNumber'];
            mysqli_query($conn, "UPDATE  $proses SET Years='$years' WHERE Identification_log ='$planning'");
        }
    } else {
        $sql = mysqli_query($conn, "SELECT * FROM planning_prod_header");
        while ($row = mysqli_fetch_array($sql)) {
            $years = $row['Years'];
            $planning = $row['PlanningNumber'];
            mysqli_query($conn, "UPDATE  $proses SET Years='$years' WHERE PlanningNumber='$planning'");
        }
    }
    echo true;
}

// ---------------------------------------------------------
// Data Nomor Lot
// ---------------------------------------------------------
if (isset($_POST['prosessimpandatanomorlot'])) {
    try {
        mysqli_begin_transaction($conn);
        $return = false;
        $nomorlot    = $_POST['prosessimpandatanomorlot'][0];
        $kodesupplier = $_POST['prosessimpandatanomorlot'][1];
        $namasupplier = $_POST['prosessimpandatanomorlot'][2];
        $keterangan  = $_POST['prosessimpandatanomorlot'][3];
        $join        = $_POST['prosessimpandatanomorlot'][4];

        $cek = mysqli_query($conn, "SELECT NomorLot 
                                FROM data_lot 
                                WHERE Plant='$plant' 
                                  AND UnitCode='$unitcode' 
                                  AND NomorLot='$nomorlot'");
        if (!$cek) {
            throw new Exception("Query cek gagal: " . mysqli_error($conn));
        }
        if (mysqli_num_rows($cek) > 0) {
            throw new Exception("NomorLot '$nomorlot' sudah ada di data_lot!");
        }
        if (!mysqli_query($conn, "INSERT INTO data_lot 
                                                (Plant, 
                                                UnitCode, 
                                                NomorLot, 
                                                KodeSupplier, 
                                                NamaSupplier, 
                                                Keterangan, 
                                                Joins, 
                                                CreatedBy, 
                                                CreatedOn) 
                                VALUES('$plant',
                                '$unitcode',
                                '$nomorlot',
                                '$kodesupplier',
                                '$namasupplier',
                                '$keterangan',
                                '$join',
                                '$createdby',
                                '$createdon')")) {
            throw new Exception("Gagal insert data_lot: " . mysqli_error($conn));
        }
        mysqli_commit($conn);
        $msg = "Data Tersimpan";
        $return = true;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $msg = $e->getMessage();
        errorlog($e->getMessage());
    }
    $data = [
        "icon_s" => 'success',
        "icon_e" => 'warning',
        "msg" => $msg,
        "time" => $time,
        "link" => null,
        "id" => $nomorlot,
        "return" => $return
    ];
    echo json_encode($data);
}
if (isset($_POST['prosesdeletenomorlot'])) {
    try {
        mysqli_begin_transaction($conn);
        $return = false;
        $nomorlot = $_POST['prosesdeletenomorlot'];

        $sql = mysqli_query($conn, "DELETE FROM data_lot 
                                        WHERE Plant='$plant' 
                                        AND UnitCode='$unitcode' 
                                        AND NomorLot='$nomorlot'");

        if (!$sql) {
            throw new Exception("Gagal hapus data_lot: " . mysqli_error($conn));
        }
        $sql = mysqli_query($conn, "SELECT Directions FROM master_directions WHERE Plant='$plant' AND UnitCode='$unitcode' AND Items=2");
        if (mysqli_num_rows($sql) <> 0) {
            $r   = mysqli_fetch_array($sql);
            $dir = $r['Directions'];
        } else {
            throw new Exception("Mapping master_directions : " . mysqli_error($conn));
        }
        $query = mysqli_query($conn, "SELECT documenaddress FROM table_datadoclot WHERE NomorLot='$nomorlot'");
        if (mysqli_num_rows($query) <> 0) {
            while ($r = mysqli_fetch_array($query)) {
                $file = $dir . $r['documenaddress'];
                if (file_exists($file)) {
                    unlink($file);
                }
            }
            mysqli_query($conn, "DELETE FROM table_datadoclot WHERE NomorLot='$nomorlot'");
        } else {
            throw new Exception("Documen Address Kosong : " . mysqli_error($conn));
        }

        mysqli_commit($conn);
        $msg = "Data Terhapus";
        $return = true;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $msg = $e->getMessage();
        errorlog($e->getMessage());
    }
    $data = [
        "iconmsg" => 'warning',
        "msg" => $msg,
        "time" => $time,
        "link" => null,
        "id" => $nomorlot,
        "return" => $return
    ];

    echo json_encode($data);
}
if (isset($_POST['prosesshowtableexecnomorlot'])) {
    $planningnumber = $_POST['prosesshowtableexecnomorlot'][0];
    $years = $_POST['prosesshowtableexecnomorlot'][1];

    $output = ' <table id="ddisplayplanning" class="table table-sm" style="width:100%;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th></th>
                            <th>Nomor Lot</th>
                            <th>Kode Supplier</th>
                            <th>Nama Supplier</th>
                            <th>Join</th>
                            <th>Status</th>
                            <th>Created On</th>
                        </tr>
                    </thead>
                <tbody>';
    $sql = mysqli_query($conn, "SELECT * FROM exec_nomorlot WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    PlanningNumber='$planningnumber' AND
                                                                    Years='$years'");
    while ($row = mysqli_fetch_array($sql)) {
        $query = mysqli_query($conn, "SELECT * FROM data_lot WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    NomorLot='$row[NomorLot]'");
        $r = mysqli_fetch_array($query);
        $statsX = '';
        if ($r["StatsX"] == 'X') {
            $statsX = 'Habis';
        }
        $output .= '
                            <tr>
                                <td><button class="btn btn-sm bg-transparent zoom" onclick="deleteexecnomorlot(' . $row["PlanningNumber"] . ',' . $row["Years"] . ',' . $row["NomorLot"] . ')"><img src="../asset/img/delete.png"></button></td>
                                <td>' . $row["NomorLot"] . '</td>
                                <td>' . $r["KodeSupplier"] . '</td>
                                <td>' . $r["NamaSupplier"] . '</td>
                                <td>' . $r["Joins"] . '</td>
                                <td>' . $statsX . '</td>
                                <td>' . $row["CreatedOn"] . '</td>
                            </tr>';
    }
    $output .= '
                    </tbody>
                </table>';

    echo $output;
}
if (isset($_POST['prosessaveexecnomorlot'])) {
    $planningnumber = $_POST['prosessaveexecnomorlot'][0];
    $years = $_POST['prosessaveexecnomorlot'][1];
    $nomorlot = $_POST['prosessaveexecnomorlot'][2];
    $kodesupplier = $_POST['prosessaveexecnomorlot'][3];
    $statsX = $_POST['prosessaveexecnomorlot'][4];

    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];
    $item = 1;
    $return = false;

    $sql = mysqli_query($conn, "SELECT * FROM exec_nomorlot WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND
                                                                        Years='$years' AND
                                                                        NomorLot='$nomorlot'
                                                                         ORDER BY CreatedOn ASC");
    if (mysqli_num_rows($sql) == 0) {
        mysqli_query($conn, "INSERT INTO exec_nomorlot (Plant,UnitCode,
                                                    PlanningNumber,
                                                    Years,
                                                    NomorLot,
                                                    KodeSupplier,
                                                    CreatedOn,
                                                    CreatedBy)
                                            VALUES ('$plant',
                                                    '$unitcode',
                                                    '$planningnumber',
                                                    '$years',
                                                    '$nomorlot',
                                                    '$kodesupplier',
                                                    '$createdon',
                                                    '$createdby'
                                                )");

        if ($statsX == 'X') {
            mysqli_query($conn, "UPDATE data_lot SET StatsX='X' WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        NomorLot='$nomorlot' AND
                                                                        KodeSupplier='$kodesupplier'");
        }
        $return = true;
    }
    echo $return;
}
if (isset($_POST['prosesdeleteexecnomorlot'])) {
    $planningnumber = $_POST['prosesdeleteexecnomorlot'][0];
    $years = $_POST['prosesdeleteexecnomorlot'][1];
    $nomorlot = $_POST['prosesdeleteexecnomorlot'][2];
    $return = false;
    $sql = mysqli_query($conn, "SELECT * FROM exec_nomorlot WHERE Plant='$plant' AND
                                                                UnitCode='$unitcode' AND
                                                                PlanningNumber='$planningnumber' AND
                                                                Years='$years' AND
                                                                NomorLot='$nomorlot'");
    if (mysqli_num_rows($sql) != 0) {
        mysqli_query($conn, "DELETE FROM exec_nomorlot WHERE Plant='$plant' AND
                                                                UnitCode='$unitcode' AND
                                                                PlanningNumber='$planningnumber' AND
                                                                Years='$years' AND
                                                                NomorLot='$nomorlot'");
        mysqli_query($conn, "UPDATE data_lot SET StatsX='' WHERE Plant='$plant' AND
                                                                UnitCode='$unitcode' AND
                                                                NomorLot='$nomorlot'");
        $return = true;
    }
    echo $return;
}

// ---------------------------------------------------------
// Display Data Material & Batch
// ---------------------------------------------------------
if (isset($_POST['prosesdisplaymaterial'])) {
    $productid = base64_encode($_POST['prosesdisplaymaterial']);
    echo $productid;
}
if (isset($_POST['prosesdisplaybatch'])) {
    $dump = [];
    $productid = base64_encode($_POST['prosesdisplaybatch'][0]);
    $bets = base64_encode($_POST['prosesdisplaybatch'][1]);
    $dump = [
        "productid" => $productid,
        "bets" => $bets
    ];
    echo json_encode($dump);
}
if (isset($_POST['prosessubmitstartdisplayplanningpengolahan'])) {
    $dump = [];
    $productid = base64_encode($_POST['prosessubmitstartdisplayplanningpengolahan'][0]);
    $bets = base64_encode($_POST['prosessubmitstartdisplayplanningpengolahan'][1]);
    $maxs = base64_encode($_POST['prosessubmitstartdisplayplanningpengolahan'][2]);
    $dump = [
        "productid" => $productid,
        "bets" => $bets,
        "maxs" => $maxs
    ];
    echo json_encode($dump);
}
if (isset($_POST['prosesshowdatachange'])) {
    $dump = [];
    $notiket = base64_encode($_POST['prosesshowdatachange'][0]);
    $years = base64_encode($_POST['prosesshowdatachange'][1]);
    $obj = base64_encode($_POST['prosesshowdatachange'][2]);
    $dump = [
        "notiket" => $notiket,
        "years" => $years,
        "obj" => $obj
    ];
    echo json_encode($dump);
}
