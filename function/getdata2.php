<?php
date_default_timezone_set('Asia/Jakarta');
error_reporting(0);
session_start();
include "koneksi.php";
// include "getdata.php"; 
include_once "getvalue.php";
$plant = $_SESSION['plant'];
$unitcode = $_SESSION['unitcode'];
$msg = "Something wrong";
function loguser2($transaction)
{
    include "koneksi.php";
    $login_time = date("Y-m-d H:i:s");
    $sql = "UPDATE user_log SET LastAct='$login_time', ActionPage='$transaction'
    WHERE UserID='$_SESSION[userid]'";
    mysqli_query($conn, $sql);
}
function setreviewer2($prosestype, $planningnumber, $years, $addreviewer)
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
        if ($additional == 'X' && $addreviewer != '') {
            $levels = $levels + 1;
            mysqli_query($conn, "INSERT INTO tb_approval_viewer(Plant,UnitCode,ProcessType,PlanningNumber,Years,Levels,PersonnelNumber,CreatedOn,CreatedBy)
            VALUES('$plant','$unitcode','$prosestype','$planningnumber','$years','$levels','$addreviewer','$createdon','$createdby')");
        }
        $return = true;
    }
    return $return;
}
function setreviewer3($prosestype, $planningnumber, $years, $addreviewer, $reviewer)
{
    // include "koneksi.php";
    // $plant = $_SESSION['plant'];
    // $unitcode = $_SESSION['unitcode'];
    // $createdon = date("Y-m-d H:i:s");
    // $createdby = $_SESSION['userid'];


    // $return = false;
    // $sql = mysqli_query($conn, "SELECT * FROM tb_configreviewer WHERE Plant='$plant' AND UnitCode='$unitcode'
    //                                                                                 AND ProcessType='$prosestype'
    //                                                                                 AND StatsX='X'");
    // if (mysqli_num_rows($sql) != 0) {
    //     $r = mysqli_fetch_array($sql);
    //     if ($reviewer != null) {
    //         $reviewer_lenght = count($reviewer);
    //         if ($reviewer_lenght > 1) {
    //             $rev = explode(",", $reviewer);
    //             for ($i = 1; $i <= $reviewer_lenght; $i++) {
    //                 $query = mysqli_query($conn, "SELECT * FROM reviewer_person WHERE Plant='$plant' AND UnitCode='$unitcode'
    //                                                                                         AND TypeTransaction ='$prosestype'
    //                                                                                         AND Levels = $rev[$i]");
    //                 while ($row = mysqli_fetch_array($query)) {
    //                     $levels = $row['Levels'];
    //                     $pernr = $row['PersonnelNumber'];
    //                     mysqli_query($conn, "INSERT INTO tb_approval_viewer(Plant,UnitCode,ProcessType,PlanningNumber,Years,Levels,PersonnelNumber,CreatedOn,CreatedBy)
    //                                 VALUES('$plant','$unitcode','$prosestype','$planningnumber','$years','$levels','$pernr','$createdon','$createdby')");
    //                 }
    //             }
    //         } else {
    //             $query = mysqli_query($conn, "SELECT * FROM reviewer_person WHERE Plant='$plant' AND UnitCode='$unitcode'
    //                                                                                         AND TypeTransaction ='$prosestype'
    //                                                                                         AND Levels = $reviewer");
    //             while ($row = mysqli_fetch_array($query)) {
    //                 $levels = $row['Levels'];
    //                 $pernr = $row['PersonnelNumber'];
    //                 mysqli_query($conn, "INSERT INTO tb_approval_viewer(Plant,UnitCode,ProcessType,PlanningNumber,Years,Levels,PersonnelNumber,CreatedOn,CreatedBy)
    //                                 VALUES('$plant','$unitcode','$prosestype','$planningnumber','$years','$levels','$pernr','$createdon','$createdby')");
    //             }
    //         }
    //     }
    //     $additional = $r['Addreviewer'];
    //     if ($additional == 'X' && $addreviewer != '') {
    //         $levels = $levels + 1;
    //         mysqli_query($conn, "INSERT INTO tb_approval_viewer(Plant,UnitCode,ProcessType,PlanningNumber,Years,Levels,PersonnelNumber,CreatedOn,CreatedBy)
    //         VALUES('$plant','$unitcode','$prosestype','$planningnumber','$years','$levels','$addreviewer','$createdon','$createdby')");
    //     }
    //     $return = true;
    // }
    return $reviewer;
}
function setreviewerpartial($prosestype, $planningnumber, $years, $levels)
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
function setreviewertambahan($prosestype, $planningnumber, $years, $addreviewer, $levels)
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
function getvaluetoX($value)
{
    $return = '';
    if ($value == 'true') {
        $return = 'X';
    }
    return $return;
}
function getautokode($value)
{
    include "koneksi.php";
    $years = date('Y');
    $sql = mysqli_query($conn, "SELECT Current, Too FROM nriv WHERE NumberRangeType='$value' AND Years='$years' ORDER BY Current DESC");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) > 0) {
        $kodeauto = $q['Current'] + 1;
        $maxkode = $q['Too'];
        // -----> Cek Overload Number
        if ($kodeauto > $maxkode) {
            die;
        }
    } else {
        $sql = mysqli_query($conn, "SELECT Fromm FROM nriv WHERE NumberRangeType='$value'");
        $q = mysqli_fetch_array($sql);
        if (mysqli_num_rows($sql) > 0) {
            $kodeauto = $q['Fromm'];
            mysqli_query($conn, "UPDATE nriv SET Current='$kodeauto',Years='$years' WHERE NumberRangeType='$value'");
        }
    }
    return $kodeauto;
}

// ---------------------------------------------------------
// Data Timbang MD
// ---------------------------------------------------------
if (isset($_POST["prosessimpandatatimbangan"])) {
    $ipadd = $_POST["prosessimpandatatimbangan"][0];
    $namatimbangan = $_POST["prosessimpandatatimbangan"][1];
    $detaillokasi = $_POST["prosessimpandatatimbangan"][2];
    $port = $_POST["prosessimpandatatimbangan"][3];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $return = false;

    $sql = mysqli_query($conn, "SELECT * FROM mapping_timbangan WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND
                                                                    AddressOf='$ipadd'");
    if (mysqli_num_rows($sql) != 0) {
        $return = 2;
    } else {
        $query = mysqli_query($conn, "INSERT INTO mapping_timbangan (Plant,
                                                            UnitCode,
                                                            AddressOf,
                                                            NamaTimbangan,
                                                            DetailLokasi,
                                                            PortOf,
                                                            AutoCommand,
                                                            AutoTimbang,
                                                            AutoSave,
                                                            AutoPrint,
                                                            Satuan,
                                                            Stoped,
                                                            GetWeight,
                                                            CreatedOn,
                                                            CreatedBy)
                                    VALUES('$plant',
                                            '$unitcode',
                                            '$ipadd',
                                            '$namatimbangan',
                                            '$detaillokasi',
                                            '$port',
                                            'P',
                                            '',
                                            'X',
                                            'X',
                                            'Kg',
                                            'X',
                                            'Net',
                                            '$createdon',
                                            '$createdby')");
        if ($query === true) {
            $return = true;
        }
    }
    echo $return;
}
if (isset($_POST["prosesupdatedatatimbangan"])) {
    $ipadd = trim($_POST["prosesupdatedatatimbangan"][0]);
    $namatimbangan = $_POST["prosesupdatedatatimbangan"][1];
    $detaillokasi = $_POST["prosesupdatedatatimbangan"][2];
    $port = $_POST["prosesupdatedatatimbangan"][3];
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];
    $return = false;

    $sql = mysqli_query($conn, "SELECT * FROM mapping_timbangan WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND
                                                                    AddressOf='$ipadd'");
    if (mysqli_num_rows($sql) != 0) {
        $query = mysqli_query($conn, "UPDATE mapping_timbangan SET NamaTimbangan='$namatimbangan',
                                                                    DetailLokasi='$detaillokasi',
                                                                    PortOf='$port',
                                                                    ChangedOn='$changedon',
                                                                    ChangedBy='$changedby'
                                    WHERE Plant='$plant' AND 
                                            UnitCode='$unitcode' AND 
                                            AddressOf='$ipadd'");
        if ($query === true) {
            $return = true;
        }
    }
    echo $return;
}
if (isset($_POST["prosesdeletedatatimbangan"])) {
    $ipadd = $_POST["prosesdeletedatatimbangan"];
    $return = false;

    $sql = mysqli_query($conn, "SELECT * FROM mapping_timbangan WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND
                                                                    AddressOf='$ipadd'");
    if (mysqli_num_rows($sql) != 0) {
        $query = mysqli_query($conn, "DELETE FROM mapping_timbangan WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND 
                                                                                AddressOf='$ipadd'");
        if ($query === true) {
            $return = true;
        }
    }
    echo $return;
}
if (isset($_POST['proseschangedatatimbangan'])) {
    $dump[] = '';
    $ipadd = trim($_POST['proseschangedatatimbangan']);
    $sql = mysqli_query($conn, "SELECT * FROM mapping_timbangan WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND
                                                                        AddressOf='$ipadd'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) != 0) {
        $dump['ipaddress'] = $q['AddressOf'];
        $dump['namatimbangan'] = $q['NamaTimbangan'];
        $dump['detaillokasi'] = $q['DetailLokasi'];
        $dump['port'] = $q['PortOf'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['createdon'] = $q['CreatedOn'];
    }
    echo json_encode($dump);
}
// ---------------------------------------------------------
// Master Insp. Char MD
// ---------------------------------------------------------
if (isset($_POST['prosessimpanmic'])) {
    $mic = $_POST['prosessimpanmic'][0];
    $desc = $_POST['prosessimpanmic'][1];
    $fulldesc = $_POST['prosessimpanmic'][2];
    $qual = $_POST['prosessimpanmic'][3];
    $quan = $_POST['prosessimpanmic'][4];

    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $return = false;

    $sql = mysqli_query($conn, "SELECT * FROM master_inspection WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND
                                                                    MIC='$mic'");
    if (mysqli_num_rows($sql) == 0) {
        $query = mysqli_query($conn, "INSERT INTO master_inspection (Plant,
                                                            UnitCode,
                                                            MIC,
                                                            Descriptions,
                                                            FullyDesc,
                                                            Qual,
                                                            Quan,
                                                            CreatedOn,
                                                            CreatedBy)
                                    VALUES('$plant',
                                            '$unitcode',
                                            '$mic',
                                            '$desc',
                                            '$fulldesc',
                                            '$qual',
                                            '$quan',
                                            '$createdon',
                                            '$createdby')");
        if ($query === true) {
            $return = true;
        }
    } else {
        $return = 'Proses gagal';
    }
    echo $return;
}
if (isset($_POST['proseschangedatamic'])) {
    $dump[] = '';
    $mic = trim($_POST['proseschangedatamic']);
    $sql = mysqli_query($conn, "SELECT * FROM master_inspection WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND
                                                                        MIC='$mic'");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) != 0) {
        $dump['mic'] = $q['MIC'];
        $dump['desc'] = $q['Descriptions'];
        $dump['fulldesc'] = $q['FullyDesc'];
        $dump['qual'] = $q['Qual'];
        $dump['quan'] = $q['Quan'];
        $dump['createdby'] = $q['CreatedBy'];
        $dump['createdon'] = $q['CreatedOn'];
    }
    echo json_encode($dump);
}
if (isset($_POST["prosesdeleteddatamic"])) {
    $mic = $_POST["prosesdeleteddatamic"];
    $return = 'Proses gagal';

    $sql = mysqli_query($conn, "SELECT * FROM master_inspection WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND
                                                                    MIC='$mic'");
    if (mysqli_num_rows($sql) != 0) {
        $query = mysqli_query($conn, "DELETE FROM master_inspection WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND
                                                                    MIC='$mic'");
        if ($query === true) {
            $return = true;
        }
    }
    echo $return;
}
// ---------------------------------------------------------
// Assign Master Insp. Char MD
// ---------------------------------------------------------
if (isset($_POST['prosessimpanassignmic'])) {
    $productid = $_POST['prosessimpanassignmic'][0];
    $mic = $_POST['prosessimpanassignmic'][1];

    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $return = false;

    $sql = mysqli_query($conn, "SELECT * FROM assign_mic WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND
                                                                    ProductID='$productid'");
    $items = mysqli_num_rows($sql) + 1;
    $query = mysqli_query($conn, "INSERT INTO assign_mic (Plant,
                                                            UnitCode,
                                                            ProductID,
                                                            Items,
                                                            MIC,
                                                            CreatedOn,
                                                            CreatedBy)
                                    VALUES('$plant',
                                            '$unitcode',
                                            '$productid',
                                            '$items',
                                            '$mic',
                                            '$createdon',
                                            '$createdby')");
    if ($query === true) {
        $return = true;
    }
    echo $return;
}
if (isset($_POST["prosesdeleteddataassignmic"])) {
    $productid = $_POST["prosesdeleteddataassignmic"][0];
    $mic = $_POST["prosesdeleteddataassignmic"][1];
    $return = 'Proses gagal';

    $sql = mysqli_query($conn, "SELECT * FROM assign_mic WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND
                                                                    ProductID ='$productid' AND
                                                                    MIC='$mic'");
    if (mysqli_num_rows($sql) != 0) {
        $query = mysqli_query($conn, "DELETE FROM assign_mic WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND
                                                                    ProductID='$productid' AND
                                                                    MIC='$mic'");
        if ($query === true) {
            $sql = mysqli_query($conn, "SELECT * FROM assign_mic WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND
                                                                    ProductID='$productid' ORDER BY Items ASC");
            $i = 1;
            while ($r = mysqli_fetch_array($sql)) {
                mysqli_query($conn, "UPDATE assign_mic SET Items='$i' WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND
                                                                        ProductID='$productid' AND
                                                                        MIC='$r[MIC]'");
                $i += 1;
            }
            $return = true;
        }
    }
    echo $return;
}

// ---------------------------------------------------------
// Timbang Bahan - Pengolahan
// ---------------------------------------------------------
if (isset($_POST["prosesdeletehasiltimbang"])) {
    $return = false;

    $planningnumber = $_POST["prosesdeletehasiltimbang"][0];
    $years = $_POST["prosesdeletehasiltimbang"][1];;
    $items = $_POST["prosesdeletehasiltimbang"][2];;
    $productid = $_POST["prosesdeletehasiltimbang"][3];;
    $batch = $_POST["prosesdeletehasiltimbang"][4];;
    $noproses = $_POST["prosesdeletehasiltimbang"][5];;
    $notong = $_POST["prosesdeletehasiltimbang"][6];;

    $sql = mysqli_query($conn, "UPDATE tbl_hasiltimbang_detail SET Berat=0, Satuan= null
                                                                WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    PlanningNumber='$planningnumber' AND
                                                                    Years='$years' AND
                                                                    Items='$items' AND
                                                                    ProductID='$productid' AND
                                                                    BatchNumber='$batch' AND
                                                                    NoProses='$noproses' AND
                                                                    NoTong='$notong'");
    if ($sql === true) {
        $return = $sql;
    }
    echo $return;
}
if (isset($_POST["prosesprinthasiltimbang"])) {
    // $smilg = "^FO200,10^GFA,203,203,7,,::::0PFE,03OF8,00OF8,003NF8,I0NF8,I03MF8,I01MF8,J07LF8,J01LF8,K07KF8,K01KFC,L07JF8,L01JF,M07IF,M03FFE,N0FFC,N03FC,O0F8,O038,P0C,,:::^FS";

    // $comd  = "";
    // $comd .= "^XA";
    // $comd .= "^FO300,10^BQN,2,3^FDMM,A123456789012^FS";
    // $comd .= "^FO500,10^BQN,2,3^FDMM,A123456789012^FS";
    // $comd .= $smilg;
    // $comd .= "^XZ";

    // try {
    //     $fp = pfsockopen("193.13.7.32", 9100);
    //     if (fputs($fp, $comd)) {
    //         fclose($fp);
    //         echo "Print Success";
    //     } else {
    //         echo "Not Success";
    //     }
    // } catch (Exception $e) {
    //     echo 'Caught exception: ',  $e->getMessage(), "\n";
    // }
    $myfile = fopen("//193.10.3.109/sga/sisptimbang.txt", "w") or die("Unable to open file!");
    $txt = "John Doe\n";
    fwrite($myfile, $txt);
    fclose($myfile);
    // $myfile = fopen("D:\sisptimbang.txt", "w") or die("Unable to open file!");
    // $txt = "John Doe\n";
    // fwrite($myfile, $txt);
    // $txt = "Jane Doe\n";
    // fwrite($myfile, $txt);
    // fclose($myfile);
}
if (isset($_POST["prosessetconfigdatatimbangan"])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $namatimbangan = $_SESSION['namtim'];
    $ip = $_SESSION['ip'];
    $port = $_SESSION['port'];
    $dump[] = '';
    $return = false;
    $sql = mysqli_query($conn, "SELECT * FROM mapping_timbangan WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    AddressOf ='$ip'");
    if (mysqli_num_rows($sql) != 0) {
        $row = mysqli_fetch_array($sql);
        $dump['autoprint'] =  $row['AutoPrint'];
        $dump['autosave'] =  $row['AutoSave'];
        $dump['getweight'] =  $row['GetWeight'];
        $return = true;
    }
    $dump['return'] = $return;
    echo json_encode($dump);
}
if (isset($_POST["prosessimpanmodaltimbangbahan"])) {
    $autoprint = $_POST["prosessimpanmodaltimbangbahan"][0];
    $autosave = $_POST["prosessimpanmodaltimbangbahan"][1];
    $getweight = $_POST["prosessimpanmodaltimbangbahan"][2];
    $autotimbang = $_POST["prosessimpanmodaltimbangbahan"][3];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $namatimbangan = $_SESSION['namtim'];
    $return = false;
    $ip = $_SESSION['ip'];
    $port = $_SESSION['port'];

    $sql = mysqli_query($conn, "UPDATE mapping_timbangan SET AutoPrint='$autoprint', AutoSave='$autosave', GetWeight='$getweight',AutoTimbang='$autotimbang' WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                                                                                    AND AddressOf='$ip'");

    if ($sql === true) {
        $return = true;
    }
    echo $return;
}
if (isset($_POST["prosessimpanapprovalreviewer"])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $prosestype = $_POST["prosessimpanapprovalreviewer"][0];
    $planningnumber = $_POST["prosessimpanapprovalreviewer"][1];
    $years = $_POST["prosessimpanapprovalreviewer"][2];
    $levels = $_POST["prosessimpanapprovalreviewer"][3];
    $pernr = $_POST["prosessimpanapprovalreviewer"][4];
    $stats = $_POST["prosessimpanapprovalreviewer"][5];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];
    $return = false;
    $x = 'X';
    if ($stats == 'T') {
        $x = 'T';
    }
    $sql = mysqli_query($conn, "SELECT * FROM tb_approval_viewer WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                        AND ProcessType='$prosestype'
                                                                                        AND PlanningNumber='$planningnumber' 
                                                                                        AND Years='$years' 
                                                                                        AND Levels = $levels 
                                                                                        AND StatusApproval is null");
    if (mysqli_num_rows($sql) != 0) {
        $query = mysqli_query($conn, "UPDATE tb_approval_viewer SET StatusApproval='$x', 
                                                                    ChangedBy='$changedby', 
                                                                    ChangedOn='$changedon'
                                                                WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                            AND ProcessType='$prosestype' 
                                                                            AND PlanningNumber='$planningnumber' 
                                                                            AND Years='$years' 
                                                                            AND Levels = '$levels'
                                                                            AND PersonnelNumber='$pernr'");
    }

    // sleep(2);

    $sql = mysqli_query($conn, "SELECT * FROM tb_approval_viewer WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                        AND ProcessType='$prosestype'
                                                                                        AND PlanningNumber='$planningnumber' 
                                                                                        AND Years='$years' 
                                                                                        AND StatusApproval is null");
    if (mysqli_num_rows($sql) < 1) {
        mysqli_query($conn, "INSERT INTO approval_planning (Plant,UnitCode,
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
            if ($stats == 'Y') {
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
                $return = $query;
                $query = mysqli_query($conn, "SELECT * FROM tb_approval_viewer WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                AND ProcessType='$prosestype' 
                                                                                AND PlanningNumber='$planningnumber' 
                                                                                AND Years='$years'
                                                                                AND StatusApproval='T'");
                if (mysqli_num_rows($query) <> 0) {
                    // $a = 'T';
                    mysqli_query($conn, "UPDATE planning_pengolahan_header SET Approval='X',
                                                                                    Del='X',
                                                                                    ChangedOn='$changedon',
                                                                                    ChangedBy='$changedby' WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                                                                AND PlanningNumber='$planningnumber' 
                                                                                                                                AND Years='$years'");
                } else {
                    // $a = 'Y';
                    mysqli_query($conn, "UPDATE planning_pengolahan_header SET Approval='X',
                                                                                    ChangedOn='$changedon',
                                                                                    ChangedBy='$changedby' 
                                                                                WHERE Plant='$plant' 
                                                                                        AND UnitCode='$unitcode' 
                                                                                        AND PlanningNumber='$planningnumber' 
                                                                                        AND Years='$years'");
                }
            } else if ($stats == 'T') {
                mysqli_query($conn, "UPDATE planning_pengolahan_header SET Approval='X',Del='X' WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                            AND PlanningNumber='$planningnumber' 
                                                                                            AND Years='$years'");
            }
        } elseif ($prosestype == 'create_planning') {
            mysqli_query($conn, "UPDATE planning_prod_header SET Approval='X' WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                                AND PlanningNumber='$planningnumber' 
                                                                                                AND Years='$years'");
        }
    }
    $dump = [
        "planningnumber" => $planningnumber,
        "return" => $return,
        "test" => $a,

    ];
    echo json_encode($dump);
}
if (isset($_POST["prosessavedatareviewer"])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $type_transaksi = $_POST["prosessavedatareviewer"][0];
    $pernr = $_POST["prosessavedatareviewer"][1];
    $employeename = $_POST["prosessavedatareviewer"][2];
    $position = $_POST["prosessavedatareviewer"][3];
    $levels = $_POST["prosessavedatareviewer"][4];

    $sql = mysqli_query($conn, "SELECT * FROM reviewer_person WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                    AND TypeTransaction='$type_transaksi' 
                                                                                    AND Levels='$levels'");
    if (mysqli_num_rows($sql) == 0) {
        $query = mysqli_query($conn, "INSERT INTO reviewer_person(Plant,
                                                                UnitCode,
                                                                TypeTransaction,
                                                                Levels,
                                                                PersonnelNumber,
                                                                EmployeeName,
                                                                PositionID,
                                                                CreatedOn,
                                                                CreatedBy) VALUES('$plant',
                                                                                    '$unitcode',
                                                                                    '$type_transaksi',
                                                                                    '$levels',
                                                                                    '$pernr',
                                                                                    '$employeename',
                                                                                    '$position',
                                                                                    '$createdon',
                                                                                    '$createdby')");
        $return = $query;
    } else {
        $row = mysqli_fetch_array($sql);
        $return = 'Reviewer Level 2 sudah ada atas nama ' . $row['EmployeeName'];
    }
    echo $return;
}
if (isset($_POST["prosesselectlevelsdatareviewer"])) {
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $type = $_POST["prosesselectlevelsdatareviewer"];
    $return = 1;
    $i = 0;

    $sql = mysqli_query($conn, "SELECT * FROM reviewer_person WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                    AND TypeTransaction='$type'");
    if (mysqli_num_rows($sql) != 0) {
        while ($row = mysqli_fetch_array($sql)) {
            $return = $return + 1;
        }
        // $return = $i;
    }
    echo $return;
}
if (isset($_POST["prosesdeletedatareviewer"])) {
    $type_transaksi = $_POST["prosesdeletedatareviewer"][0];
    $level = $_POST["prosesdeletedatareviewer"][1];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $return = false;

    $sql = mysqli_query($conn, "SELECT * FROM reviewer_person WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                    AND TypeTransaction='$type_transaksi' 
                                                                                    AND Levels > '$level'");
    if (mysqli_num_rows($sql) == 0) {
        $query = mysqli_query($conn, "DELETE FROM reviewer_person WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                        AND TypeTransaction='$type_transaksi' 
                                                                                        AND Levels='$level'");
        $return = $query;
    } else {
        $return = 'Hapus reviewer level ' . ($level + 1) . ' terlebih dahulu';
    }
    echo $return;
}
if (isset($_POST["prosesselectgetproductid"])) {
    $planningnumber = $_POST["prosesselectgetproductid"][0];
    $productid = $_POST["prosesselectgetproductid"][1];
    $years = $_POST["prosesselectgetproductid"][2];
    $items = $_POST["prosesselectgetproductid"][3];
    $usedby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT DISTINCT BatchNumber  FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND 
                                                                                            UnitCode='$unitcode' AND 
                                                                                            PlanningNumber='$planningnumber' AND 
                                                                                            Years='$years' AND
                                                                                            Items='$items' AND
                                                                                            (UsedBy !='$usedby' or UsedBy is null) AND
                                                                                            Berat =0 AND
                                                                                            ProductID='$productid'");
    if (mysqli_num_rows($sql) != 0) {
        while ($r = mysqli_fetch_array($sql)) {
            $query = mysqli_query($conn, "SELECT * FROM planning_pengolahan_subdetail WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                                        AND PlanningNumber='$planningnumber'
                                                                                                        AND Years='$years'
                                                                                                        AND ProductID='$productid'
                                                                                                        AND BatchNumber = '$r[BatchNumber]'
                                                                                                        AND Stats04='X'");
            if (mysqli_num_rows($query) == 0) {
                continue;
            } else {
?>
                <option value="<?= $r['BatchNumber'] ?>"><?= $r['BatchNumber'] ?></option>
        <?php
            }
        }
    } else {
        echo "<option selected>Batch tidak ditemukan</option>";
    }
}
if (isset($_POST["prosesgetdetailbatchdatatimbang"])) {
    $dump[] = '';
    $planningnumber = $_POST["prosesgetdetailbatchdatatimbang"][0];
    $productid = $_POST["prosesgetdetailbatchdatatimbang"][1];
    $years = $_POST["prosesgetdetailbatchdatatimbang"][2];
    $batch = $_POST["prosesgetdetailbatchdatatimbang"][3];
    $return = false;
    $dump['noproses'] = '';
    $dump['nowadah'] = '';
    $dump['tglmixing'] = '';
    $dump['nomesin'] = '';
    $dump['ed'] = '';
    $np = '';

    $sql = mysqli_query($conn, "SELECT max(NoProses) as proses,max(NoTong) as tong FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years' AND
                                                                            ProductID ='$productid' AND
                                                                            BatchNumber='$batch'");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $dump['noproses'] = $r['proses'];
        $dump['nowadah'] = $r['tong'];
        $sql = mysqli_query($conn, "SELECT DISTINCT NoProses FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years' AND
                                                                            ProductID ='$productid' AND
                                                                            BatchNumber='$batch'");

        while ($r = mysqli_fetch_array($sql)) {
            if ($np == '') {
                $np = $r['NoProses'];
            } else {
                $np = $np . '-' . $r['NoProses'];
            }
        }
        $dump['noproses'] = $np;
        $sql = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_header WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years' AND
                                                                            ProductID ='$productid'");
        $q = mysqli_fetch_array($sql);
        $dump['tglmixing'] = $q['MixingDate'];
        $dump['nomesin'] = $q['ResourceIDMix'];
        $dump['ed'] = $q['ExpiredDate'];
    }

    echo json_encode($dump);
}
if (isset($_POST["prosessubmitdatatimbangan"])) {
    $planningnumber = $_POST["prosessubmitdatatimbangan"][0];
    $years = $_POST["prosessubmitdatatimbangan"][1];
    $productid = $_POST["prosessubmitdatatimbangan"][2];
    $batch = $_POST["prosessubmitdatatimbangan"][3];
    // $noproses = $_POST["prosessubmitdatatimbangan"][4];
    $operator1 = $_POST["prosessubmitdatatimbangan"][4];
    $operator2 = $_POST["prosessubmitdatatimbangan"][5];
    $item = $_POST["prosessubmitdatatimbangan"][6];
    $ip = $_POST["prosessubmitdatatimbangan"][7];

    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $usedby = $_SESSION['userid'];
    $return = false;

    $sql = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_header WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years' AND
                                                                            -- ProductID='$productid' AND
                                                                            -- Items='$item' AND 
                                                                            UsedBy ='$usedby' AND
                                                                            (StatsX ='' or StatsX is null)");
    if (mysqli_num_rows($sql) != 0) {
        $return = 'Proses timbang sebelumnya belum usai';
    } else {
        $sql = mysqli_query($conn, "UPDATE tbl_hasiltimbang_header SET UsedBy='$usedby',
                                                                        AddressOf='$ip',
                                                                        Operator1='$operator1',
                                                                        Operator2='$operator2' WHERE Plant='$plant' AND UnitCode='$unitcode' AND
                                                                                                                        PlanningNumber='$planningnumber' AND
                                                                                                                        Years='$years' AND
                                                                                                                        ProductID='$productid' AND
                                                                                                                        Items='$item' AND 
                                                                                                                        (UsedBy is null or UsedBy='') AND
                                                                                                                        (StatsX !='X' or StatsX is null)");
        $sql = mysqli_query($conn, "UPDATE tbl_hasiltimbang_detail SET UsedBy='$usedby' WHERE Plant='$plant' AND UnitCode='$unitcode' AND
                                                                                                                PlanningNumber='$planningnumber' AND
                                                                                                                Years='$years' AND
                                                                                                                ProductID='$productid' AND
                                                                                                                Items='$item' AND
                                                                                                                BatchNumber='$batch' AND
                                                                                                                (UsedBy is null or UsedBy='')");
        mysqli_query($conn, "INSERT INTO tb_prosestimbang_mapping (Plant,UnitCode,PlanningNumber,Years,ProductID,BatchNumber,UsedBy) VALUES('$plant',
                                                                                                                                                '$unitcode',
                                                                                                                                                '$planningnumber',
                                                                                                                                                '$years',
                                                                                                                                                '$productid',
                                                                                                                                                '$batch',
                                                                                                                                                '$usedby')");
        if ($sql === true) {
            $return = true;
        }
    }
    echo $return;
}
if (isset($_POST["prosesdeleteprosestimbang"])) {
    $planningnumber = $_POST["prosesdeleteprosestimbang"][0];
    $years = $_POST["prosesdeleteprosestimbang"][1];
    $item = $_POST["prosesdeleteprosestimbang"][2];
    $productid = $_POST["prosesdeleteprosestimbang"][3];
    $batch = $_POST["prosesdeleteprosestimbang"][4];
    $usedby = $_POST["prosesdeleteprosestimbang"][5];
    $addressof = $_POST["prosesdeleteprosestimbang"][6];
    $return = false;

    $sql = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_header WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years' AND
                                                                            Items='$item' AND
                                                                            ProductID='$productid' AND
                                                                            UsedBy='$usedby' AND
                                                                            AddressOf='$addressof'");
    if (mysqli_num_rows($sql) != 0) {
        $query = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND
                                                                                PlanningNumber='$planningnumber' AND
                                                                                Years='$years' AND
                                                                                Items='$item' AND
                                                                                ProductID='$productid' AND
                                                                                BatchNumber='$batch' AND
                                                                                UsedBy='$usedby'");
        if (mysqli_num_rows($query) != 0) {
            $r = mysqli_fetch_array($query);
            mysqli_query($conn, "UPDATE tbl_hasiltimbang_detail SET EnterOn = '0000-00-00 00:00:00',
                                                                    Berat=0,
                                                                    Satuan = null,
                                                                    UsedBy=null
                                                                    WHERE Plant='$plant'AND 
                                                                    UnitCode='$unitcode'AND 
                                                                    PlanningNumber= '$r[PlanningNumber]' AND 
                                                                    Years='$r[Years]' AND 
                                                                    Items='$r[Items]' AND 
                                                                    ProductID='$r[ProductID]' AND 
                                                                    BatchNumber='$r[BatchNumber]'");
            mysqli_query($conn, "UPDATE tbl_hasiltimbang_header SET Operator1 = null,
                                                                    Operator2=null,
                                                                    UsedBy= null,
                                                                    AddressOf=null,
                                                                    StatsX=null
                                                                    WHERE Plant='$plant'AND 
                                                                    UnitCode='$unitcode'AND 
                                                                    PlanningNumber= '$r[PlanningNumber]' AND 
                                                                    Years='$r[Years]' AND 
                                                                    Items='$r[Items]' AND 
                                                                    ProductID='$r[ProductID]'");
            mysqli_query($conn, "DELETE FROM tb_prosestimbang_mapping WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    PlanningNumber='$planningnumber' AND
                                                                    Years='$years' AND
                                                                    ProductID='$productid' AND
                                                                    BatchNumber='$batch' AND
                                                                    UsedBy ='$usedby'");
            $return = true;
        }
    }
    echo $return;
}
if (isset($_POST["prosesstopprosestimbang"])) {
    $planningnumber = $_POST["prosesstopprosestimbang"][0];
    $years = $_POST["prosesstopprosestimbang"][1];
    $item = $_POST["prosesstopprosestimbang"][2];
    $productid = $_POST["prosesstopprosestimbang"][3];
    $batch = $_POST["prosesstopprosestimbang"][4];
    $usedby = $_POST["prosesstopprosestimbang"][5];
    $return = false;
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];

    $sql = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_header WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years' AND
                                                                            Items='$item' AND
                                                                            ProductID='$productid' AND
                                                                            UsedBy='$usedby'");
    if (mysqli_num_rows($sql) != 0) {
        $query = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND
                                                                        Years='$years' AND
                                                                        Items='$item' AND
                                                                        ProductID='$productid' AND
                                                                        BatchNumber='$batch' AND
                                                                        UsedBy ='$usedby' AND
                                                                        Berat=0");
        if (mysqli_num_rows($query) != 0) {
            $minus = mysqli_num_rows($query);
            $r = mysqli_fetch_array($query);
            $return = "Proses timbang kurang " . $minus . " step";
        } else {
            $update = mysqli_query($conn, "UPDATE tbl_hasiltimbang_header SET AddressOf=null, UsedBy=null WHERE Plant='$plant' AND
                                                                                                 UnitCode='$unitcode' AND
                                                                                                 PlanningNumber='$planningnumber' AND
                                                                                                 Years='$years' AND
                                                                                                 Items='$item' AND
                                                                                                 ProductID='$productid' AND
                                                                                                 UsedBy='$usedby'");
            mysqli_query($conn, "DELETE FROM tb_prosestimbang_mapping WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years' AND
                                                                            ProductID='$productid' AND
                                                                            BatchNumber='$batch' AND
                                                                            UsedBy ='$usedby'");
            $query = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND
                                                                         UnitCode='$unitcode' AND
                                                                         PlanningNumber='$planningnumber' AND
                                                                         Years='$years' AND
                                                                         Items='$item' AND
                                                                         ProductID='$productid' AND
                                                                         UsedBy is null");
            if (mysqli_num_rows($query) == 0) {
                mysqli_query($conn, "UPDATE tbl_hasiltimbang_header SET StatsX='X' WHERE Plant='$plant' AND
                                                                                                 UnitCode='$unitcode' AND
                                                                                                 PlanningNumber='$planningnumber' AND
                                                                                                 Years='$years' AND
                                                                                                 Items='$item' AND
                                                                                                 ProductID='$productid'");
            }

            //--------UPDATE Stats06 - sudah Timbang Bahan 
            $query = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND
                                                                         UnitCode='$unitcode' AND
                                                                         PlanningNumber='$planningnumber' AND
                                                                         Years='$years' AND
                                                                         BatchNumber='$batch' AND
                                                                         Items='$item' AND
                                                                         ProductID='$productid' AND
                                                                         UsedBy is null");
            if (mysqli_num_rows($query) == 0) {
                mysqli_query($conn, "UPDATE planning_pengolahan_subdetail SET Stats06='X' WHERE Plant='$plant' AND
                                                                                                 UnitCode='$unitcode' AND
                                                                                                 PlanningNumber='$planningnumber' AND
                                                                                                 Years='$years' AND
                                                                                                 Items='$item' AND
                                                                                                 ProductID='$productid' AND
                                                                                                 BatchNumber='$batch'");
            }
            //------End

            $return = $update;
        }
    }
    echo $return;
}
if (isset($_POST["proseskonfirmbatchauto"])) {
    $productid = $_POST["proseskonfirmbatchauto"][0];
    $resep = $_POST["proseskonfirmbatchauto"][1];
    $return = false;

    $sql = mysqli_query($conn, "SELECT * FROM planning_pengolahan_subdetail WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                ProductID='$productid' AND
                                                                                NoProses='1' ORDER BY CreatedOn DESC LIMIT 1");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $bets = $r['BatchNumber'];

        $lenght = strlen($bets);
        $a = ceil($resep / 2);
        $return = '';
        $bets_auto = array();
        $z = 0;

        $return = $bets;
        $setlenght = $lenght - 2;
        $bets_auto = [];
        if ($a >= 1) {
            while ($z < $a) {
                $code = substr($return, 0, 2);
                $bets_r = (int) substr($return, 2, $setlenght);
                $bets_r += 1;
                $return = $code . sprintf("%0" . $setlenght . "s", $bets_r);
                array_push($bets_auto, $return);
                $z += 1;
            }
        }
        $dump['test'] = $bets_r;
        $dump['bets'] = $bets_auto;
        $dump['return'] = true;
    } else {
        $dump['return'] = false;
    }
    echo json_encode($dump);
}
if (isset($_POST["prosesbatchauto"])) {
    $productid = $_POST["prosesbatchauto"][0];
    $bets = $_POST["prosesbatchauto"][1];
    $resep = $_POST["prosesbatchauto"][2];
    $lenght = strlen($bets);
    $a = ceil($resep / 2);
    $return = '';
    $bets_auto = array();
    $z = 1;

    $return = $bets;

    $bets_auto = [$return];
    $setlenght = $lenght - 2;

    if ($a > 1) {
        while ($z < $a) {
            $code = substr($return, 0, 2);
            $bets_r = (int) substr($return, 2, $setlenght);
            $bets_r++;
            $return = $code . sprintf("%0" . $setlenght . "s", $bets_r);
            array_push($bets_auto, $return);
            $z += 1;
        }
    }

    $dump['bets'] = $bets_auto;
    $dump['a'] = $setlenght;
    echo json_encode($dump);
}

// ---------------------------------------------------------
// History Timbang - Pengolahan
// ---------------------------------------------------------
if (isset($_POST["prosesviewlabelpalet"])) {
    $planningnumber = $_POST["prosesviewlabelpalet"][0];
    $years = $_POST["prosesviewlabelpalet"][1];
    $productid = $_POST["prosesviewlabelpalet"][2];
    $batchnumber = $_POST["prosesviewlabelpalet"][3];
    $return = false;
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];

    $query = mysqli_query($conn, "SELECT * FROM tbl_movingstock WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    PlanningNumber='$planningnumber' AND
                                                                    Years='$years'");
    if (mysqli_num_rows($query) == 0) {
        $insert = mysqli_query($conn, "INSERT INTO tbl_movingstock (Plant,
                                                            UnitCode,
                                                            PlanningNumber,
                                                            Years,
                                                            ProductID,
                                                            BatchNumber,
                                                            NoPallet,
                                                            PalletYears,
                                                            Quantity,
                                                            JamKirim,
                                                            Pengirim,
                                                            CreatedOn,
                                                            CreatedBy)
                            VALUES('$plant',
                                    '$unitcode',
                                    '$planningnumber',
                                    '$years',
                                    '$productid',
                                    '$batchnumber',
                                    '$nopallet',
                                    '$palletyears',
                                    '$quantity',
                                    '$jamkirim',
                                    '$pengirim',
                                    '$createdon',
                                    '$createdby')");

        if ($insert === true) {
            $return = true;
        }
    }
    echo $return;
}

// ---------------------------------------------------------
// History Timbang - Pengolahan
// ---------------------------------------------------------
if (isset($_POST["prosessubmitkirimbahan"])) {
    $barcode = $_POST["prosessubmitkirimbahan"];
    $data = explode(',', $barcode);
    $plant = $data[0];
    $unitcode = $data[1];
    $planningnumber = $data[2];
    $years = $data[3];
    $productid = $data[4];
    $batchnumber = $data[5];
    $berat = $data[6];
    $satuan = $data[7];
    $insplot = $data[8];
    $inspyears = $data[9];
    $nopallet = $data[10];
    $noproses = $data[11];
    $return = false;
    $statusud_1 = '';
    $createdon_1 = '';
    $statusud_2 = '';
    $createdon_2 = '';
    $kirim = false;

    $query = mysqli_query($conn, "SELECT * FROM tbl_paletmixer WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND 
                                                                    NoPallet = '$nopallet' AND
                                                                    PlanningNumber='$planningnumber' AND 
                                                                    Years='$years' AND
                                                                    ProductID='$productid' AND
                                                                    batchNumber='$batchnumber' AND
                                                                    NoProses='$noproses'");
    if (mysqli_num_rows($query) == 0) {
        $dump = [
            'info' => 'Data tidak ditemukan',
            'return' =>  false,
        ];
    } else {
        $r = mysqli_fetch_array($query);
        $dataprint = $r['CreatedOn'];
        $diprintoleh = $r['CreatedBy'];
        $query = mysqli_query($conn, "SELECT * FROM tbl_movingstock WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND 
                                                                    -- NoPallet = '$nopallet' AND
                                                                    PlanningNumber='$planningnumber' AND 
                                                                    Years='$years' AND
                                                                    ProductID='$productid' AND
                                                                    batchNumber='$batchnumber' AND
                                                                    NoProses='$noproses'");
        if (mysqli_num_rows($query) <> 0) {
            $dump = [
                'info' => 'Data sudah pernah terSCAN',
                'return' =>  false,
            ];
        } else {
            $desc = Getdata('ProductDescriptions', 'mara_product', 'ProductID', $productid);
            $expdate = getexpdate($productid, $batchnumber, $planningnumber, $years);

            $output = '
    <table id="drhsuhu" class="table table-sm">
                        <thead class="bg-dark text-white fw-bold">
                            <tr>
                                <td>No Proses</td>
                                <td>No Tong</td>
                                <td>Berat</td>
                                <td>Jam Timbang</td>
                            </tr>
                        </thead>
                        <tbody>';

            $i = 1;
            $sql = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND 
                                                                                        UnitCode='$unitcode' AND
                                                                                        PlanningNumber='$planningnumber' AND
                                                                                        Years='$years' AND
                                                                                        BatchNumber='$batchnumber' AND
                                                                                        NoProses='$noproses'");
            while ($r = mysqli_fetch_array($sql)) {
                $output .= '
                                <tr>
                                    <td>' . $r['NoProses'] . '</td>
                                    <td>' . $r['NoTong'] . '</td>
                                    <td>' . $r['Berat'] . ' ' . $r['Satuan'] . '</td>
                                    <td>' . beautydate2($r['EnterOn']) . '</td>
                                </tr>';
                $i += 1;
            }
            $output .= '
                        </tbody>
                    </table>';
            $output2 = '
    <table id="drhsuhu" class="table table-sm">
                        <thead class="bg-dark text-white fw-bold">
                            <tr>
                                <td>No Proses</td>
                                <td>No Tong</td>
                                <td>Berat</td>
                                <td>Jam Timbang</td>
                            </tr>
                        </thead>
                        <tbody>';

            $i = 1;
            $sql = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND 
                                                                                        UnitCode='$unitcode' AND
                                                                                        PlanningNumber='$planningnumber' AND
                                                                                        Years='$years' AND
                                                                                        BatchNumber='$batchnumber' AND
                                                                                        NoProses='$noproses'");
            while ($r = mysqli_fetch_array($sql)) {
                $output2 .= '
                                <tr>
                                    <td>' . $r['NoProses'] . '</td>
                                    <td>' . $r['NoTong'] . '</td>
                                    <td>' . $r['Berat'] . ' ' . $r['Satuan'] . '</td>
                                    <td>' . $r['EnterOn'] . '</td>
                                </tr>';
                $i += 1;
            }
            $output2 .= '
            </tbody>
    </table>';
            $query = mysqli_query($conn, "SELECT * FROM usage_decision WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND
                                                                    InspectionLot='$insplot' AND
                                                                    Lotyears='$inspyears' AND
                                                                    NoProses='$noproses'");
            if (mysqli_num_rows($query) <> 0) {
                $r = mysqli_fetch_array($query);
                $statusud_1 = $r['UDcode'];
                $createdon_1 = $r['CreatedOn'];
                $noproses_1 = $r['NoProses'];
                $uddesc1 = GetdataII('Descriptions', 'qc_catalog', 'KodeCatalog', $statusud_1, 'Item', 0);
                $udby = $r['CreatedBy'];
            }

            // $query = mysqli_query($conn, "SELECT * FROM usage_decision WHERE Plant='$plant' AND 
            //                                                         UnitCode='$unitcode' AND
            //                                                         InspectionLot='$insplot' AND
            //                                                         Lotyears='$inspyears' AND
            //                                                         NoProses='$noproses'");
            // if (mysqli_num_rows($query) <> 0) {
            //     $r = mysqli_fetch_array($query);
            //     $statusud_2 = $r['UDcode'];
            //     $createdon_2 = $r['CreatedOn'];
            //     $noproses_2 = $noproses;
            //     $uddesc2 = GetdataII('Descriptions', 'qc_catalog', 'KodeCatalog', $statusud_2, 'Item', 0);
            // }

            if ($statusud_1 == 'UD0001') {
                $kirim = true;
                $infobarcode = 'Ok !';
                // $return = true;
            } else if ($statusud_1 == '') {
                $kirim = false;
                $infobarcode = 'Barang belum lolos QC !';
            } elseif ($statusud_1 == 'UD0002') {
                $kirim = false;
                $infobarcode = 'Barang Tidak lolos QC ! Mohon untuk dikarantina';
            }
            $dump = [
                'plant' =>  $plant,
                'unitcode' =>  $unitcode,
                'unitdesc' => $_SESSION["unitdesc"],
                'planningnumber' =>  $planningnumber,
                'years' =>  $years,
                'productid' =>  $productid,
                'productdesc' =>  $desc,
                'batchnumber' =>  $batchnumber,
                'expdate' =>  beautydate1($expdate),

                // Pallet
                'berat' =>  $berat,
                'satuan' =>  $satuan,
                'nopallet' =>  $nopallet,
                'output_1' => $output,
                'output_2' => $output2,

                // Status QC
                'insplot' =>  $insplot,
                'inspyears' =>  $inspyears,
                'udcode1' =>  $statusud_1,
                'uddesc1' =>  $uddesc1,
                'uddate1' => beautydate2($createdon_1),
                'noproses1' =>  $noproses_1,
                'udby' => Getpernr($udby),

                // 'udcode2' =>  $statusud_2,
                // 'uddesc2' =>  $uddesc2,
                // 'uddate2' => date('d.m.Y H:i:s', strtotime($createdon_2)),
                // 'noproses2' =>  $noproses_2,

                // Data Label
                'printlabel' => beautydate2($dataprint),
                'diprintoleh' => $diprintoleh,

                'kirim' => $kirim,
                'info' => $infobarcode,
                'return' => true
            ];
        }
    }
    echo json_encode($dump);
}
if (isset($_POST["prosessimpankirimbahan"])) {
    $planningnumber = $_POST["prosessimpankirimbahan"][0];
    $years = $_POST["prosessimpankirimbahan"][1];
    $productid = $_POST["prosessimpankirimbahan"][2];
    $batchnumber = $_POST["prosessimpankirimbahan"][3];
    $nopallet = $_POST["prosessimpankirimbahan"][4];
    $qty = $_POST["prosessimpankirimbahan"][5];
    $noproses = $_POST["prosessimpankirimbahan"][6];
    $satuan = $_POST["prosessimpankirimbahan"][7];
    $jamkirim = date('H:i:s');
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $return = false;

    $query = mysqli_query($conn, "SELECT * FROM tbl_paletmixer WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND 
                                                                    NoPallet = '$nopallet' AND
                                                                    PlanningNumber='$planningnumber' AND 
                                                                    Years='$years' AND
                                                                    ProductID='$productid' AND
                                                                    batchNumber='$batchnumber' AND
                                                                    NoProses='$noproses'");
    if (mysqli_num_rows($query) <> 0) {
        $query = mysqli_query($conn, "SELECT * FROM tbl_movingstock WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND 
                                                                    NoPallet = '$nopallet' AND
                                                                    PlanningNumber='$planningnumber' AND 
                                                                    Years='$years' AND
                                                                    ProductID='$productid' AND
                                                                    batchNumber='$batchnumber' AND
                                                                    NoProses='$noproses' AND
                                                                    Zkirim <> 'X'");
        if (mysqli_num_rows($query) == 0) {
            $pengirim = Getpernr($createdby);
            $sql = mysqli_query($conn, "INSERT INTO tbl_movingstock (Plant,
                                                            UnitCode,
                                                            PlanningNumber,
                                                            Years,
                                                            ProductID,
                                                            BatchNumber,
                                                            NoProses,
                                                            NoPallet,
                                                            Quantity,
                                                            Satuan,
                                                            JamKirim,
                                                            Pengirim,
                                                            Zkirim,
                                                            CreatedOn,
                                                            CreatedBy)
                            VALUES ('$plant',
                            '$unitcode',
                            '$planningnumber',
                            '$years',
                            '$productid',
                            '$batchnumber',
                            '$noproses',
                            '$nopallet',
                            '$qty',
                            '$satuan',
                            '$jamkirim',
                            '$pengirim',
                            'X',
                            '$createdon',
                            '$createdby')");
            if ($sql === true) {
                $return = true;
            }
        }
    }
    echo $return;
}
if (isset($_POST["prosessubmitterimabahan"])) {
    $barcode = $_POST["prosessubmitterimabahan"];
    $data = explode(',', $barcode);
    $plant = $data[0];
    $unitcode = $data[1];
    $planningnumber = $data[2];
    $years = $data[3];
    $productid = $data[4];
    $batchnumber = $data[5];
    $berat = $data[6];
    $satuan = $data[7];
    $insplot = $data[8];
    $inspyears = $data[9];
    $nopallet = $data[10];
    $noproses = $data[11];
    $return = false;
    $statusud_1 = '';
    $createdon_1 = '';
    $statusud_2 = '';
    $createdon_2 = '';
    $terima = false;

    $query = mysqli_query($conn, "SELECT * FROM tbl_paletmixer WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND 
                                                                    NoPallet = '$nopallet' AND
                                                                    PlanningNumber='$planningnumber' AND 
                                                                    Years='$years' AND
                                                                    ProductID='$productid' AND
                                                                    batchNumber='$batchnumber' AND 
                                                                    Noproses='$noproses'");
    if (mysqli_num_rows($query) == 0) {
        $dump = [
            'info' => 'Data tidak ditemukan',
            'return' =>  false,
        ];
    } else {
        $query = mysqli_query($conn, "SELECT * FROM tbl_movingstock WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND 
                                                                    NoPallet = '$nopallet' AND
                                                                    PlanningNumber='$planningnumber' AND 
                                                                    Years='$years' AND
                                                                    ProductID='$productid' AND
                                                                    BatchNumber='$batchnumber' AND
                                                                    NoProses='$noproses' AND
                                                                    Zterima = 'X'");
        if (mysqli_num_rows($query) <> 0) {
            $dump = [
                'info' => 'Data sudah pernah terSCAN',
                'return' =>  false,
            ];
        } else {
            $query = mysqli_query($conn, "SELECT * FROM tbl_movingstock WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND 
                                                                    -- NoPallet = '$nopallet' AND
                                                                    PlanningNumber='$planningnumber' AND 
                                                                    Years='$years' AND
                                                                    ProductID='$productid' AND
                                                                    batchNumber='$batchnumber'");
            $r = mysqli_fetch_array($query);
            $jamkirim = $r['JamKirim'];
            $pengirim = $r['Pengirim'];
            $tglkirim = date('d.m.Y', strtotime($r['CreatedOn']));
            $namapengirim = Getnamakaryawan($r['CreatedBy']);
            $desc = Getdata('ProductDescriptions', 'mara_product', 'ProductID', $productid);
            $expdate = getexpdate($productid, $batchnumber, $planningnumber, $years);

            $output = '
    <table id="drhsuhu" class="table table-sm">
                        <thead class="bg-dark text-white fw-bold">
                            <tr>
                                <td>No Proses</td>
                                <td>No Tong</td>
                                <td>Berat</td>
                                <td>Jam Timbang</td>
                            </tr>
                        </thead>
                        <tbody>';

            $i = 1;
            $sql = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND 
                                                                                        UnitCode='$unitcode' AND
                                                                                        PlanningNumber='$planningnumber' AND
                                                                                        Years='$years' AND
                                                                                        BatchNumber='$batchnumber' AND
                                                                                        NoProses='$noproses'");
            while ($r = mysqli_fetch_array($sql)) {
                $output .= '
                                <tr>
                                    <td>' . $r['NoProses'] . '</td>
                                    <td>' . $r['NoTong'] . '</td>
                                    <td>' . $r['Berat'] . ' ' . $r['Satuan'] . '</td>
                                    <td>' . beautydate2($r['EnterOn']) . '</td>
                                </tr>';
                $i += 1;
            }
            $output .= '
                        </tbody>
                    </table>';
            $output2 = '
    <table id="drhsuhu" class="table table-sm">
                        <thead class="bg-dark text-white fw-bold">
                            <tr>
                                <td>No Proses</td>
                                <td>No Tong</td>
                                <td>Berat</td>
                                <td>Jam Timbang</td>
                            </tr>
                        </thead>
                        <tbody>';

            $i = 1;
            $sql = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND 
                                                                                        UnitCode='$unitcode' AND
                                                                                        PlanningNumber='$planningnumber' AND
                                                                                        Years='$years' AND
                                                                                        BatchNumber='$batchnumber' AND
                                                                                        NoProses='$noproses'");
            while ($r = mysqli_fetch_array($sql)) {
                $output2 .= '
                                <tr>
                                    <td>' . $r['NoProses'] . '</td>
                                    <td>' . $r['NoTong'] . '</td>
                                    <td>' . $r['Berat'] . ' ' . $r['Satuan'] . '</td>
                                    <td>' . $r['EnterOn'] . '</td>
                                </tr>';
                $i += 1;
            }
            $output2 .= '
            </tbody>
    </table>';
            $query = mysqli_query($conn, "SELECT * FROM usage_decision WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND
                                                                    InspectionLot='$insplot' AND
                                                                    Lotyears='$inspyears' AND
                                                                    NoProses='$noproses'");
            if (mysqli_num_rows($query) <> 0) {
                $r = mysqli_fetch_array($query);
                $statusud_1 = $r['UDcode'];
                $createdon_1 = $r['CreatedOn'];
                $noproses_1 = $noproses;
                $uddesc1 = GetdataII('Descriptions', 'qc_catalog', 'KodeCatalog', $statusud_1, 'Item', 0);
                $udby = $r['CreatedBy'];
            }

            // $query = mysqli_query($conn, "SELECT * FROM usage_decision WHERE Plant='$plant' AND 
            //                                                         UnitCode='$unitcode' AND
            //                                                         InspectionLot='$insplot' AND
            //                                                         Lotyears='$inspyears' AND
            //                                                         NoProses='$noproses'");
            // if (mysqli_num_rows($query) <> 0) {
            //     $r = mysqli_fetch_array($query);
            //     $statusud_2 = $r['UDcode'];
            //     $createdon_2 = $r['CreatedOn'];
            //     $noproses_2 = $noproses;
            //     $uddesc2 = GetdataII('Descriptions', 'qc_catalog', 'KodeCatalog', $statusud_2, 'Item', 0);
            // }

            if ($statusud_1 == 'UD0001') {
                $terima = true;
                $infobarcode = 'Ok!';
                // $return = true;
            } else if ($statusud_1 == '') {
                $terima = false;
                $infobarcode = 'Barang belum lolos QC !';
            } elseif ($statusud_1 == 'UD0002') {
                $terima = false;
                $infobarcode = 'Barang Tidak lolos QC ! Mohon untuk dikarantina';
            }
            $dump = [
                'plant' =>  $plant,
                'unitcode' =>  $unitcode,
                'unitdesc' => $_SESSION["unitdesc"],
                'planningnumber' =>  $planningnumber,
                'years' =>  $years,
                'productid' =>  $productid,
                'productdesc' =>  $desc,
                'batchnumber' =>  $batchnumber,
                'expdate' => beautydate1($expdate),

                // Pallet
                'berat' =>  $berat,
                'satuan' =>  $satuan,
                'nopallet' =>  $nopallet,
                'output_1' => $output,
                'output_2' => $output2,

                // Status QC
                'insplot' =>  $insplot,
                'inspyears' =>  $inspyears,
                'udcode1' =>  $statusud_1,
                'uddesc1' =>  $uddesc1,
                'uddate1' => beautydate2($createdon_1),
                'udby' => Getpernr($udby),
                'noproses1' =>  $noproses_1,

                'udcode2' =>  $statusud_2,
                'uddesc2' =>  $uddesc2,
                'uddate2' => beautydate2($createdon_2),
                'noproses2' =>  $noproses_2,

                // Pengirim
                'jamkirim' => $jamkirim,
                'pengirim' => $pengirim,
                'namapengirim' => $namapengirim,
                'tglkirim' => $tglkirim,

                'terima' => $terima,
                'info' => $infobarcode,
                'return' => true


            ];
        }
    }
    echo json_encode($dump);
}
if (isset($_POST["prosessimpanterimabahan"])) {
    $planningnumber = $_POST["prosessimpanterimabahan"][0];
    $years = $_POST["prosessimpanterimabahan"][1];
    $productid = $_POST["prosessimpanterimabahan"][2];
    $batchnumber = $_POST["prosessimpanterimabahan"][3];
    $nopallet = $_POST["prosessimpanterimabahan"][4];
    $qty = $_POST["prosessimpanterimabahan"][5];
    $noproses = $_POST["prosessimpanterimabahan"][6];
    $satuan = $_POST["prosessimpanterimabahan"][7];
    $jamterima = date('H:i:s');
    $penerima = Getnamakaryawan($_SESSION['userid']);
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];
    $return = false;

    $query = mysqli_query($conn, "SELECT * FROM tbl_movingstock WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND 
                                                                    NoPallet = '$nopallet' AND
                                                                    PlanningNumber='$planningnumber' AND 
                                                                    Years='$years' AND
                                                                    ProductID='$productid' AND
                                                                    batchNumber='$batchnumber' AND
                                                                    NoProses='$noproses' AND
                                                                    Zterima <> 'X'");
    if (mysqli_num_rows($query) <> 0) {
        $penerima = Getpernr($createdby);
        $sql = mysqli_query($conn, "UPDATE tbl_movingstock SET JamTerima='$jamterima',
                                                                Zterima='X',
                                                                Penerima='$penerima',
                                                                ChangedOn='$changedon',
                                                                ChangedBy='$changedby'
                                                                WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND 
                                                                    NoPallet = '$nopallet' AND
                                                                    PlanningNumber='$planningnumber' AND 
                                                                    Years='$years' AND
                                                                    ProductID='$productid' AND
                                                                    batchNumber='$batchnumber' AND
                                                                    NoProses='$noproses'");
        if ($sql === true) {
            $query = mysqli_query($conn, "SELECT * FROM tbl_stockhouse WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            UnitType='HOP' AND
                                                                            ProductID='$productid' AND
                                                                            BatchNumber='$batchnumber' AND
                                                                            Satuan='$satuan'");
            if (mysqli_num_rows($query) == 0) {
                mysqli_query($conn, "INSERT INTO tbl_stockhouse(Plant,
                                                            UnitCode,
                                                            UnitType,
                                                            ProductID,
                                                            BatchNumber,
                                                            Quantity,
                                                            Satuan,
                                                            CreatedOn,
                                                            CreatedBy)
                                VALUES('$plant',
                                        '$unitcode',
                                        'HOP',
                                        '$productid',
                                        '$batchnumber',
                                        '$qty',
                                        '$satuan',
                                        '$createdon',
                                        '$createdby')");
            } else {
                $r = mysqli_fetch_array($query);
                $qty = $qty + $r['Quantity'];
                mysqli_query($conn, "UPDATE tbl_stockhouse SET Quantity='$qty',
                                                                ChangedOn='$changedon',
                                                                ChangedBy='$changedby'
                                                            WHERE Plant='$plant' AND
                                                                UnitCode='$unitcode' AND
                                                                UnitType='HOP' AND
                                                                ProductID='$productid' AND
                                                                BatchNumber='$batchnumber' AND
                                                                Satuan='$satuan'");
            }
            $return = true;
        }
    }
    echo $return;
}

// ---------------------------------------------------------
// Manajemen Stok
// ---------------------------------------------------------
if (isset($_POST["prosessubmitprodumanajemenstok"])) {
    $productid = $_POST["prosessubmitprodumanajemenstok"];
    $return = false;
    if ($productid <> 'all') {
        $query = mysqli_query($conn, "SELECT * FROM mara_product WHERE ProductID='$productid'");
        if (mysqli_num_rows($query) <> 0) {
            $r = mysqli_fetch_array($query);
            $return = true;
            $productid = $r['ProductID'];
        }
    } else if ($productid == 'all') {
        $return = true;
    }
    $dump = [
        "return" => $return,
        "productid" => base64_encode($productid)
    ];
    echo json_encode($dump);
}


// ---------------------------------------------------------
// Create Planning - Pengolahan
// ---------------------------------------------------------
if (isset($_POST['prosesviewlistbahan'])) {
    $reff = $_POST['prosesviewlistbahan'];
    $return = false;

    $sql = mysqli_query($conn, "SELECT * FROM mapping_preparemixing WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        ReffCode='$reff'");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $createdon = $r['CreatedOn'];
        $createdby = $r['CreatedBy'];
        $productid = $r['ProductID'];
        //------Show Table Proses 1
        $output1 = '
         <table class="table table-sm table-bordered w-100">
             <thead class="bg-dark text-white">
                 <tr>
                     <th>Kode Bahan</th>
                     <th>Jumlah</th>
                     <th>Satuan</th>
                 </tr>
             </thead>
         ';
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

        //------Show Table Proses 2
        $output2 = '
         <table class="table table-sm table-bordered w-100">
             <thead class="bg-dark text-white">
                 <tr>
                     <th>Kode Bahan</th>
                     <th>Jumlah</th>
                     <th>Satuan</th>
                 </tr>
             </thead>
         ';
        $sql = mysqli_query($conn, "SELECT * FROM tb_detailprosesmixing WHERE Plant='$plant' AND 
                                                                         UnitCode='$unitcode' AND
                                                                         NoProses='1' AND
                                                                         Proses='2' AND
                                                                         ReffCode='$reff'
                                                                         ORDER BY CreatedOn ASC");
        if (mysqli_num_rows($sql) != 0) {
            while ($r = mysqli_fetch_array($sql)) {
                $output2 .= '
                     <tr>
                         <td>' . $r["KodeBahan"] . '</td>
                         <td>' . $r["Jumlah"] . '</td>
                         <td>' . $r["Satuan"] . '</td>
                     </tr>
         ';
            }
            $output2 .= '
                 </table>';
        }

        //------Show Table All Proses
        $output3 = '
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
                $output3 .= '
                        <tr>
                            <td>' . $r["KodeBahan"] . '</td>
                            <td>' . $r["JmlTeoritis"] . '</td>
                        </tr>';
            }
            $output3 .= '
                       </table>';
        }
        $return = true;
    }
    $dump['reffcode'] = $reff;
    $dump['output1'] = $output1;
    $dump['output2'] = $output2;
    $dump['output3'] = $output3;
    $dump['createdon'] = date('d-m-Y', strtotime($createdon));
    $dump['createdby'] = Getpernr($createdby);
    $dump['productid'] = $productid;
    $dump['status'] = $return;

    echo json_encode($dump);
}
if (isset($_POST['prosessavecreateplanningpengolahan'])) {
    $productid = $_POST['prosessavecreateplanningpengolahan'][0];
    $shift = $_POST['prosessavecreateplanningpengolahan'][1];
    $ed = $_POST['prosessavecreateplanningpengolahan'][2];
    $batch = strtoupper($_POST['prosessavecreateplanningpengolahan'][3]);
    $mesin_mix = $_POST['prosessavecreateplanningpengolahan'][4];
    $tglmixing = $_POST['prosessavecreateplanningpengolahan'][5];
    $jumlahresep = $_POST['prosessavecreateplanningpengolahan'][6];
    $createdfor = $_POST['prosessavecreateplanningpengolahan'][7];

    $createdfor = explode(" ", $createdfor);
    $createdfor = $createdfor[0];
    $reviewer_add = $_POST['prosessavecreateplanningpengolahan'][8];
    $reffcode = $_POST['prosessavecreateplanningpengolahan'][9];
    $reviewer_add = explode(" ", $reviewer_add);
    $reviewer_add = $reviewer_add[0];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $years = date('Y');
    $return = false;
    $status = false;

    $sql = mysqli_query($conn, "SELECT JmlTeoritis,KodeBahan FROM mapping_preparemixing WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        ReffCode='$reffcode'");
    if (mysqli_num_rows($sql) <> 0) {
        while ($row = mysqli_fetch_array($sql)) {
            $total = $row['JmlTeoritis'];
            $kodebahan = $row['KodeBahan'];
            // ----Proses 1
            $jumlah = 0;
            $query1 = mysqli_query($conn, "SELECT Jumlah FROM tb_detailprosesmixing WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        NoProses='1' AND
                                                                        Proses='1' AND
                                                                        ReffCode='$reffcode' AND
                                                                        KodeBahan='$kodebahan'");
            if (mysqli_num_rows($query1) <> 0) {
                while ($r = mysqli_fetch_array($query1)) {
                    $jumlah = $jumlah + $r['Jumlah'];
                }
                $jumlah = floor($jumlah);
                if ($jumlah == $total) {
                    $status = true;
                } else {
                    $msg = 'List bahan pengolahan belum Komplit';
                }
            }

            $jumlah = 0;
            $query2 = mysqli_query($conn, "SELECT Jumlah FROM tb_detailprosesmixing WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        NoProses='1' AND
                                                                        Proses='2' AND
                                                                        ReffCode='$reffcode' AND
                                                                        KodeBahan='$kodebahan'");
            if (mysqli_num_rows($query2) <> 0) {
                while ($r = mysqli_fetch_array($query2)) {
                    $jumlah = $jumlah + $r['Jumlah'];
                }
                $jumlah = floor($jumlah);
                if ($jumlah == $total) {
                    $status = true;
                } else {
                    $msg = 'List bahan pengolahan belum Komplit';
                }
            }
        }
    } else {
        $msg = 'Input kode bahan';
    }

    $status = false;
    $sql = mysqli_query($conn, "SELECT Items FROM planning_pengolahan_detail WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                            AND CreatedBy='$createdby'
                                                                                            AND (PlanningNumber is null or PlanningNumber='') 
                                                                                            ORDER BY Items DESC");
    if (mysqli_num_rows($sql) == 0) {
        $item = 1;
    } else {
        $r = mysqli_fetch_array($sql);
        $item = $r['Items'];
    }
    $item = mysqli_num_rows($sql) + 1;
    $sql = mysqli_query($conn, "INSERT INTO planning_pengolahan_detail (Plant,
                                                                            UnitCode,
                                                                            Years,
                                                                            Items,
                                                                            ProductID,
                                                                            BatchNumber,
                                                                            ExpiredDate,
                                                                            ResourceIDMix,
                                                                            MixingDate,
                                                                            JumlahResep,
                                                                            ReffCode,
                                                                            CreatedBy,
                                                                            CreatedOn) 
                                VALUES('$plant',
                                        '$unitcode',
                                        '$years',
                                        '$item',
                                        '$productid',
                                        '$batch',
                                        '$ed',
                                        '$mesin_mix',
                                        '$tglmixing',
                                        '$jumlahresep',
                                        '$reffcode',
                                        '$createdby',
                                        '$createdon')");
    if ($sql === true) {
        $status = true;
    }
    if ($status) {
        mysqli_query($conn, "DELETE FROM planning_pengolahan_header WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND
                                                                                PlanningNumber='' AND 
                                                                                CreatedBy='$createdby'");
        mysqli_query($conn, "INSERT INTO planning_pengolahan_header (Plant,
                                                                        UnitCode,
                                                                        Years,Shift,
                                                                        Addreviewer,
                                                                        CreatedFor,
                                                                        CreatedOn,
                                                                        CreatedBy)
                            VALUES('$plant',
                                    '$unitcode',
                                    '$years',
                                    '$shift',
                                    '$reviewer_add',
                                    '$createdfor',
                                    '$createdon',
                                    '$createdby')");
        $status = true;
    }
    // <------ Edit 21 Agustus 2025 -------> REVISI Pemekaran detail proses mixing berdasarkan batch
    $batch_loop = explode(",", $batch);
    $jumlah_loop = count($batch_loop);

    if ($status) {
        for ($i = 0; $i < $jumlah_loop; $i++) {
            $query = mysqli_query($conn, "SELECT * FROM tb_detailprosesmixing WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            -- Proses='1' AND
                                                                            ReffCode='$reffcode'");
            while ($r = mysqli_fetch_array($query)) {
                mysqli_query($conn, "INSERT INTO tb_subdetailprosesmixing (Plant,
                                                                UnitCode,
                                                                ProductID,
                                                                NoProses,
                                                                Proses,
                                                                UrutanProses,
                                                                KodeBahan,
                                                                ReffCode,
                                                                Jumlah,
                                                                BatchNumber,
                                                                Satuan,
                                                                UsedTo,
                                                                CreatedOn,
                                                                CreatedBy)
                            VALUES ('$r[Plant]',
                                    '$r[UnitCode]',
                                    '$r[ProductID]',
                                    '$r[NoProses]',
                                    '$r[Proses]',
                                    '$r[UrutanProses]',
                                    '$r[KodeBahan]',
                                    '$r[ReffCode]',
                                    '$r[Jumlah]',
                                    '$batch_loop[$i]',
                                    '$r[Satuan]',
                                    '$r[UsedTo]',
                                    '$r[CreatedOn]',
                                    '$r[CreatedBy]')");
            }
        }
        $return = true;
    }
    // <------ End ------->

    $data = [
        "msg" => $msg,
        "status" => $status,
        "return" => $return
    ];
    echo json_encode($data);
}
if (isset($_POST['prosescopycreateplanningpengolahan'])) {
    $productid = $_POST['prosescopycreateplanningpengolahan'][0];
    $reffcode = $_POST['prosescopycreateplanningpengolahan'][1];
    $reffcode_copy = trim($_POST['prosescopycreateplanningpengolahan'][2]);

    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $years = date('Y');
    $return = false;
    $status = '';

    $sql = mysqli_query($conn, "SELECT * FROM mapping_preparemixing WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND
                                                                            ProductID='$productid' AND
                                                                            ReffCode='$reffcode_copy'");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $output1 = '
                <table class="table table-sm table-bordered w-100">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Kode Bahan</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                ';

        $sql = mysqli_query($conn, "SELECT * FROM tb_detailprosesmixing WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND
                                                                        ProductID='$productid' AND
                                                                        ReffCode='$reffcode_copy'");
        if (mysqli_num_rows($sql) != 0) {
            while ($row = mysqli_fetch_array($sql)) {
                mysqli_query($conn, "INSERT INTO tb_detailprosesmixing (Plant,
                                                                UnitCode,
                                                                ProductID,
                                                                NoProses,
                                                                Proses,
                                                                UrutanProses,
                                                                KodeBahan,
                                                                ReffCode,
                                                                Jumlah,
                                                                Satuan,
                                                                CreatedOn,
                                                                CreatedBy)
                            VALUES ('$plant',
                                    '$unitcode',
                                    '$row[ProductID]',
                                    '$row[NoProses]',
                                    '$row[Proses]',
                                    '$row[UrutanProses]',
                                    '$row[KodeBahan]',
                                    '$reffcode',
                                    '$row[Jumlah]',
                                    '$row[Satuan]',
                                    '$createdon',
                                    '$createdby')");
            }
        }

        //------Show Table Proses 1
        $sql = mysqli_query($conn, "SELECT * FROM tb_detailprosesmixing WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND
                                                                                ProductID='$productid' AND
                                                                                NoProses= '1' AND
                                                                                Proses='1' AND
                                                                                -- KodeBahan='$kodebahan' AND
                                                                                ReffCode='$reffcode'
                                                                                ORDER BY CreatedOn, UrutanProses ASC");
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
        //------End

        //------Show Table Proses 2
        $output2 = '
                <table class="table table-sm table-bordered w-100">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Kode Bahan</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                ';
        $sql = mysqli_query($conn, "SELECT * FROM tb_detailprosesmixing WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND
                                                                                ProductID='$productid' AND
                                                                                NoProses='2' AND
                                                                                Proses='2' AND
                                                                                -- KodeBahan='$kodebahan' AND
                                                                                ReffCode='$reffcode'
                                                                                ORDER BY CreatedOn, UrutanProses ASC");
        if (mysqli_num_rows($sql) != 0) {
            while ($r = mysqli_fetch_array($sql)) {
                $output2 .= '
                            <tr>
                                <td>' . $r["KodeBahan"] . '</td>
                                <td>' . $r["Jumlah"] . '</td>
                                <td>' . $r["Satuan"] . '</td>
                            </tr>
                ';
            }
            $output2 .= '
                        </table>';
        }
        //-----End

        //------COPY Total Receipe
        $return = true;

        $query = mysqli_query($conn, "SELECT * FROM mapping_preparemixing WHERE Plant='$plant' AND
                                                                                        UnitCode='$unitcode' AND
                                                                                        -- ProductID='$productid' AND
                                                                                        ReffCode='$reffcode_copy'");
        if (mysqli_num_rows($query) != 0) {
            while ($r = mysqli_fetch_array($query)) {
                mysqli_query($conn, "INSERT INTO mapping_preparemixing (Plant,
                                                                            UnitCode,
                                                                            ProductID,
                                                                            KodeBahan,
                                                                            ReffCode,
                                                                            JmlTeoritis,
                                                                            ScanQty,
                                                                            CreatedOn,
                                                                            CreatedBy)
                                        VALUES('$plant',
                                                '$unitcode',
                                                '$r[ProductID]',
                                                '$r[KodeBahan]',
                                                '$reffcode',
                                                '$r[JmlTeoritis]',
                                                '$r[ScanQty]',
                                                '$createdon',
                                                '$createdby')");
            }
        }
        //------End

        $output3 = '
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
                                                                                -- ProductID='$productid' AND
                                                                                ReffCode='$reffcode'");
        if (mysqli_num_rows($query) != 0) {
            while ($r = mysqli_fetch_array($query)) {
                $output3 .= '
                        <tr>
                            <td>' . $r["KodeBahan"] . '</td>
                            <td>' . $r["JmlTeoritis"] . '</td>
                        </tr>';
            }
            $output3 .= '
                       </table>';
        }

        //---Urutan Proses
        $sql = mysqli_query($conn, "SELECT * FROM tb_detailprosesmixing WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND
                                                                            -- ProductID='$productid' AND
                                                                            NoProses='1' AND
                                                                            Proses='1' AND
                                                                            ReffCode='$reffcode'
                                                                            ORDER BY UrutanProses DESC");
        if (mysqli_num_rows($sql) != 0) {
            $row = mysqli_fetch_array($sql);
            $urutanproses = $row['UrutanProses'] + 1;
        } else {
            $urutanproses = 1;
        }
        //----End

        $dump['urutanproses'] = $urutanproses;
        // $dump['proses'] = $proses;
        $dump['output1'] = $output1;
        $dump['output2'] = $output2;
        $dump['output3'] = $output3;
        $dump['return'] = $return;
        $dump['a'] = $a;
        $dump['b'] = $b;
        loguser2('Copy Kode Bahan Planning');
        echo json_encode($dump);
    }
}
if (isset($_POST['prosesdeletecreateplanningpengolahan'])) {
    $item = $_POST['prosesdeletecreateplanningpengolahan'][0];
    $productid = $_POST['prosesdeletecreateplanningpengolahan'][1];
    $createdby = $_POST['prosesdeletecreateplanningpengolahan'][2];
    $years = $_POST['prosesdeletecreateplanningpengolahan'][3];
    $reff = $_POST['prosesdeletecreateplanningpengolahan'][4];
    // $years = date('Y');
    $return = false;

    $sql = mysqli_query($conn, "DELETE FROM planning_pengolahan_detail WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND
                                                                            Items='$item' AND
                                                                            (PlanningNumber='' or PlanningNumber is null) AND
                                                                            ProductID='$productid' AND
                                                                            CreatedBy='$createdby' AND
                                                                            Years='$years'");

    // ------Delete List Bahan
    mysqli_query($conn, "DELETE FROM mapping_preparemixing WHERE Plant='$plant' AND
                                                                UnitCode='$unitcode' AND
                                                                ReffCode='$reff'");
    mysqli_query($conn, "DELETE FROM tb_detailprosesmixing WHERE Plant='$plant' AND
                                                                UnitCode='$unitcode' AND
                                                                ProductID='$productid' AND
                                                                ReffCode='$reff'");
    // ------End

    // if ($sql === true) {
    $sql = mysqli_query($conn, "SELECT * FROM table_bahanreproses WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND
                                                                            (PlanningNumber='' or PlanningNumber is null) AND
                                                                            Years='$years' AND
                                                                            ProductID='$productid' AND
                                                                            CreatedBy='$createdby'");
    if (mysqli_num_rows($sql) != 0) {
        $sql = mysqli_query($conn, "DELETE FROM table_bahanreproses WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND
                                                                                (PlanningNumber='' or PlanningNumber is null) AND
                                                                                Years='$years' AND
                                                                                ProductID='$productid' AND
                                                                                CreatedBy='$createdby'");
    }
    $return = true;
    $query = mysqli_query($conn, "SELECT * FROM planning_pengolahan_detail WHERE Plant='$plant' AND 
                                                                                    UnitCode='$unitcode' AND
                                                                                    Items='$item' AND
                                                                                    (PlanningNumber='' or PlanningNumber is null) AND
                                                                                    ProductID='$productid' AND
                                                                                    CreatedBy='$createdby' AND
                                                                                    Years='$years'");
    if (mysqli_fetch_array($query) == 0) {
        mysqli_query($conn, "DELETE FROM planning_pengolahan_header WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND
                                                                            (PlanningNumber='' or PlanningNumber is null) AND
                                                                            Years='$years'");
    }
    // }
    echo $return;
}
if (isset($_POST['prosessimpancreateplanningpengolahan'])) { // --- > selesai planning
    $dump[] = '';
    $shift = $_POST['prosessimpancreateplanningpengolahan'][0];
    $createdfor = $_POST['prosessimpancreateplanningpengolahan'][1];
    $reviewer_add = $_POST['prosessimpancreateplanningpengolahan'][2];
    $reviewer = $_POST['prosessimpancreateplanningpengolahan'][3];
    $reviewer_lenght = count($reviewer);
    $createdfor = explode(" ", $createdfor);
    $createdfor = $createdfor[0];
    $reviewer_add = explode(" ", $reviewer_add);
    $reviewer_add = $reviewer_add[0];
    $years = date('Y');
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $return = false;
    $jmlproses = 2;

    // ------> Get Kode Planning
    $kodeplanning = getautokode('Planning2');
    // ------> End

    // --------> Update Head Temp

    mysqli_query($conn, "UPDATE planning_pengolahan_header SET PlanningNumber='$kodeplanning',
                                                                    Shift='$shift',
                                                                    Addreviewer='$reviewer_add',
                                                                    CreatedFor='$createdfor'
                                                                WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    PlanningNumber='' AND
                                                                    CreatedBy='$createdby'");
    // --------> End

    $sql = mysqli_query($conn, "SELECT * FROM planning_pengolahan_detail WHERE Plant='$plant' AND 
                                                                                    UnitCode='$unitcode' AND
                                                                                    PlanningNumber ='' AND 
                                                                                    CreatedBy='$createdby' ORDER BY Items ASC");
    if (mysqli_num_rows($sql) != 0) {
        $i = 1;
        while ($r = mysqli_fetch_array($sql)) {

            mysqli_query($conn, "UPDATE planning_pengolahan_detail SET PlanningNumber ='$kodeplanning' WHERE Plant='$plant' AND 
                                                                                                            UnitCode='$unitcode' AND
                                                                                                            (PlanningNumber='' or PlanningNumber is null) AND
                                                                                                            Years='$r[Years]' AND
                                                                                                            Items='$i' AND
                                                                                                            ProductID='$r[ProductID]' AND
                                                                                                            CreatedBy='$createdby'");
            mysqli_query($conn, "UPDATE table_bahanreproses SET PlanningNumber ='$kodeplanning' WHERE Plant='$plant' AND 
                                                                                                        UnitCode='$unitcode' AND
                                                                                                        (PlanningNumber='' or PlanningNumber is null) AND
                                                                                                        Years='$r[Years]' AND
                                                                                                        ProductID='$r[ProductID]' AND
                                                                                                        CreatedBy='$createdby'");

            mysqli_query($conn, "INSERT INTO tbl_hasiltimbang_header (Plant,
                                                                        UnitCode,
                                                                        PlanningNumber,
                                                                        Years,
                                                                        Items,
                                                                        ProductID,
                                                                        ExpiredDate,
                                                                        ResourceIDMix,
                                                                        MixingDate,
                                                                        CreatedOn,
                                                                        CreatedBy)
                                            VALUES('$plant',
                                            '$unitcode',
                                            '$kodeplanning',
                                            '$r[Years]',
                                            '$i',
                                            '$r[ProductID]',
                                            '$r[ExpiredDate]',
                                            '$r[ResourceIDMix]',
                                            '$r[MixingDate]',
                                            '$createdon',
                                            '$createdby')");

            $drop_bets = explode(',', $r['BatchNumber']);
            $jml_batch = count($drop_bets);
            for ($z = 0; $z < $jml_batch; $z++) {
                $realbatch =  $drop_bets[$z];
                // ------> Get Kode Planning
                $inspectionlot = getautokode('prueflos');
                // ---
                // ------> Analisa Pengemasan Sekunder
                for ($noproses_qc = 1; $noproses_qc < 3; $noproses_qc++) {
                    mysqli_query($conn, "INSERT INTO insp_pengolahan_header(Plant,
                                            UnitCode,
                                            InspectionLot,
                                            Lotyears,
                                            NoProses,
                                            ProductID,
                                            BatchNumber,
                                            PlanningNumber,
                                            Years,
                                            StatsY,
                                            CreatedOn,
                                            CreatedBy)
                            VALUES('$plant',
                                    '$unitcode',
                                    '$inspectionlot',
                                    '$years',
                                    '$noproses_qc',
                                    '$r[ProductID]',
                                    '$realbatch',
                                    '$kodeplanning',
                                    '$r[Years]',
                                    'CRTD',
                                    '$createdon',
                                    '$createdby')");

                    $cek_spec = mysqli_query($conn, "SELECT A.ProductID,
                                                            A.MIC,
                                                            B.Descriptions,
                                                            B.FullyDesc 
                                                    FROM assign_mic AS A INNER JOIN
                                                    master_inspection AS B ON A.MIC = B.MIC WHERE A.Plant='$plant' AND 
                                                                                        A.UnitCode='$unitcode' AND 
                                                                                        A.ProductID='$r[ProductID]'");
                    if (mysqli_num_rows($cek_spec) != 0) {
                        while ($c = mysqli_fetch_array($cek_spec)) {
                            mysqli_query($conn, "INSERT INTO insp_pengolahan_detail(Plant,
                                            UnitCode,
                                            InspectionLot,
                                            Lotyears,
                                            NoProses,
                                            MIC,
                                            Descriptions,
                                            FullyDesc,
                                            ProductID,
                                            BatchNumber,
                                            CreatedOn,
                                            CreatedBy)
                            VALUES('$plant',
                                    '$unitcode',
                                    '$inspectionlot',
                                    '$years',
                                    '$noproses_qc',
                                    '$c[MIC]',
                                    '$c[Descriptions]',
                                    '$c[FullyDesc]',
                                    '$c[ProductID]',
                                    '$realbatch',
                                    '$createdon',
                                    '$createdby')");

                            mysqli_query($conn, "UPDATE insp_pengolahan_header SET StatsY='REL' WHERE Plant='$plant' AND 
                                                                                                UnitCode='$unitcode' AND
                                                                                                InspectionLot='$inspectionlot' AND
                                                                                                Lotyears='$years' AND
                                                                                                ProductID='$c[ProductID]' AND
                                                                                                BatchNumber='$realbatch' AND
                                                                                                NoProses='$noproses_qc'");
                        }
                    }
                }
                mysqli_query($conn, "UPDATE nriv SET Current='$inspectionlot' WHERE NumberRangeType='prueflos' AND Years='$years'");
                for ($k = 1; $k <= $jmlproses; $k++) {
                    for ($w = 1; $w <= 7; $w++) {
                        mysqli_query($conn, "INSERT INTO tbl_hasiltimbang_detail (Plant,
                                                                                UnitCode,
                                                                                PlanningNumber,
                                                                                Years,
                                                                                Items,
                                                                                ProductID,
                                                                                BatchNumber,
                                                                                NoProses,
                                                                                NoTong,
                                                                                CreatedOn,
                                                                                CreatedBy)
                                        VALUES('$plant',
                                                '$unitcode',
                                                '$kodeplanning',
                                                '$r[Years]',
                                                '$i',
                                                '$r[ProductID]',
                                                '$realbatch',
                                                '$k',
                                                '$w',
                                                '$createdon',
                                                '$createdby')");
                    }
                }
                $indexrow = 1;
                $getindexrow = mysqli_query($conn, "SELECT IndexRow FROM tb_eraseprosespengolahan WHERE Plant='$plant' AND
                                                                                                        UnitCode='$unitcode' AND
                                                                                                        PlanningNumber='$kodeplanning' AND
                                                                                                        Years='$r[Years]' ORDER BY IndexRow DESC");
                if (mysqli_num_rows($getindexrow) != 0) {
                    $show_getindexrow = mysqli_fetch_array($getindexrow);
                    $indexrow = $show_getindexrow['IndexRow'] + 1;
                }
                // ----------------- Update 24 July 2024 * tbl_eraseprosespengolahan
                mysqli_query($conn, "INSERT tb_eraseprosespengolahan (Plant,
                                                                        UnitCode,
                                                                        PlanningNumber,
                                                                        Years,
                                                                        IndexRow,
                                                                        ProductID,
                                                                        BatchNumber,
                                                                        JmlProses,
                                                                        CreatedOn,
                                                                        CreatedBy)
                                    VALUES('$plant',
                                            '$unitcode',
                                            '$kodeplanning',
                                            '$r[Years]',
                                            '$indexrow',
                                            '$r[ProductID]',
                                            '$realbatch',
                                            '$jmlproses',
                                            '$createdon',
                                            '$createdby')");
                // ----------------->
            }
            $i = $i + 1;
        }
        mysqli_query($conn, "UPDATE nriv SET Current='$kodeplanning' WHERE NumberRangeType='Planning2' AND Years='$years'");
        for ($i = 1; $i <= $reviewer_lenght; $i++) {
            if ($reviewer_lenght > 1) {
                setreviewerpartial('planning_pengolahan', $kodeplanning, $years, $reviewer[($i - 1)]);
            } else {
                $rev = str_replace(",", "", $reviewer);
                setreviewerpartial('planning_pengolahan', $kodeplanning, $years, $rev[($i - 1)]);
            }
        }
        setreviewertambahan('planning_pengolahan', $kodeplanning, $years, $reviewer_add, $reviewer_lenght);

        $dump['status'] = true;
        $dump['planningnumber'] = $kodeplanning;
        $dump['years'] = $years;
        mysqli_query($conn, "UPDATE nriv SET Current='$inspectionlot' WHERE NumberRangeType='prueflos' AND Years='$years'");
    }

    // $dump['reviewer'] = $reviewer_add;
    echo json_encode($dump);
}
if (isset($_POST['prosesdeletedatareprosescreateplanningpengolahan'])) {
    $productid = $_POST['prosesdeletedatareprosescreateplanningpengolahan'][0];
    $betsasal = $_POST['prosesdeletedatareprosescreateplanningpengolahan'][1];
    $betreproses = $_POST['prosesdeletedatareprosescreateplanningpengolahan'][2];
    $createdby = $_POST['prosesdeletedatareprosescreateplanningpengolahan'][3];
    $years = date('Y');
    $return = false;

    $sql = mysqli_query($conn, "SELECT *  FROM table_bahanreproses WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND
                                                                        (PlanningNumber='' or PlanningNumber is null) AND
                                                                        Years='$years' AND
                                                                        ProductID='$productid' AND
                                                                        BatchAsal='$betsasal' AND
                                                                        BatchReproses='$betreproses' AND
                                                                        CreatedBy='$createdby'");
    if (mysqli_num_rows($sql) != 0) {
        $sql = mysqli_query($conn, "DELETE FROM table_bahanreproses WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND
                                                                    (PlanningNumber='' or PlanningNumber is null) AND
                                                                    Years='$years' AND
                                                                    ProductID='$productid' AND
                                                                    BatchAsal='$betsasal' AND
                                                                    BatchReproses='$betreproses' AND
                                                                    CreatedBy='$createdby'");
        if ($sql === true) {
            $return = true;
        }
    }
    echo $return;
}
if (isset($_POST['prosessimpanreprosescreateplanningpengolahan'])) {
    $productid = $_POST['prosessimpanreprosescreateplanningpengolahan'][0];
    $asal = $_POST['prosessimpanreprosescreateplanningpengolahan'][1];
    $edbc = $_POST['prosessimpanreprosescreateplanningpengolahan'][2];
    $betsrepro = $_POST['prosessimpanreprosescreateplanningpengolahan'][3];
    $berat = $_POST['prosessimpanreprosescreateplanningpengolahan'][4];
    $bulk = $_POST['prosessimpanreprosescreateplanningpengolahan'][5];
    $berat2 = $_POST['prosessimpanreprosescreateplanningpengolahan'][6];
    $sisa = $_POST['prosessimpanreprosescreateplanningpengolahan'][7];
    $years = date('Y');
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $return = false;

    $sql = mysqli_query($conn, "SELECT * FROM table_bahanreproses WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND
                                                                        (PlanningNumber='' or PlanningNumber is null) AND
                                                                        Years='$years' AND
                                                                        ProductID='$productid'");
    if (mysqli_num_rows($sql) == 0) {
        $query = mysqli_query($conn, "INSERT INTO table_bahanreproses (Plant,
                                                                    UnitCode,
                                                                    Years,
                                                                    ProductID,
                                                                    BatchAsal,
                                                                    BatchReproses,
                                                                    Asal,
                                                                    Berat,
                                                                    Bulk,
                                                                    BeratUmum,
                                                                    BeratKhusus,
                                                                    CreatedOn,
                                                                    CreatedBy)
                                        VALUES('$plant',
                                                '$unitcode',
                                                '$years',
                                                '$productid',
                                                '$edbc',
                                                '$betsrepro',
                                                '$asal',
                                                '$berat',
                                                '$bulk',
                                                '$berat2',
                                                '$sisa',
                                                '$createdon',
                                                '$createdby')");
        if ($query === true) {
            $return = true;
        }
    }
    echo $return;
}
if (isset($_POST['prosestambahkodebahancreatepengolahan'])) {
    $productid = $_POST['prosestambahkodebahancreatepengolahan'][0];
    $reff = $_POST['prosestambahkodebahancreatepengolahan'][1];
    $kodebahan = strtoupper($_POST['prosestambahkodebahancreatepengolahan'][2]);
    $jmlteoritis = $_POST['prosestambahkodebahancreatepengolahan'][3];
    $proses = $_POST['prosestambahkodebahancreatepengolahan'][4];
    $urutanproses = $_POST['prosestambahkodebahancreatepengolahan'][5];
    $jmlkonsumsi = $_POST['prosestambahkodebahancreatepengolahan'][6];
    $return = false;
    $dump[] = '';
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];

    if ($jmlkonsumsi >= 1) {
        $scanqty = 1;
    } else {
        $scanqty = 0.5;
    }

    $sql = mysqli_query($conn, "SELECT JmlTeoritis,ScanQty FROM mapping_preparemixing WHERE Plant='$plant' AND 
                                                                                            UnitCode='$unitcode' AND
                                                                                            ProductID='$productid' AND
                                                                                            KodeBahan='$kodebahan' AND
                                                                                            ReffCode='$reff'");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $jmlteoritis_max = $r['JmlTeoritis'];
        $jmlkonsumsi_now = $r['ScanQty'];
    } else {
        $jmlteoritis_max = $jmlteoritis;
        $jmlkonsumsi_now = 0;
    }

    $jmlkonsumsi_tot = $jmlkonsumsi_now + $jmlkonsumsi;
    $output1 = '
                <table class="table table-sm table-bordered w-100">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Kode Bahan</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                ';

    $sql = mysqli_query($conn, "SELECT * FROM tb_detailprosesmixing WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND
                                                                        ProductID='$productid' AND
                                                                        Proses='$proses' AND
                                                                        UrutanProses='$urutanproses' AND
                                                                        KodeBahan='$kodebahan' AND
                                                                        ReffCode='$reff'");
    if (mysqli_num_rows($sql) != 0) {
        $return = 'Bahan sudah masuk kedalam list';
    } else {
        if ($jmlkonsumsi_tot <= $jmlteoritis_max) {
            mysqli_query($conn, "INSERT INTO tb_detailprosesmixing (Plant,
                                                                UnitCode,
                                                                ProductID,
                                                                NoProses,
                                                                Proses,
                                                                UrutanProses,
                                                                KodeBahan,
                                                                ReffCode,
                                                                Jumlah,
                                                                Satuan,
                                                                CreatedOn,
                                                                CreatedBy)
                            VALUES ('$plant',
                                    '$unitcode',
                                    '$productid',
                                    '1',
                                    '$proses',
                                    '$urutanproses',
                                    '$kodebahan',
                                    '$reff',
                                    '$jmlkonsumsi',
                                    'Kantong',
                                    '$createdon',
                                    '$createdby')");

            mysqli_query($conn, "INSERT INTO tb_detailprosesmixing (Plant,
                                                                    UnitCode,
                                                                    ProductID,
                                                                    NoProses,
                                                                    Proses,
                                                                    UrutanProses,
                                                                    KodeBahan,
                                                                    ReffCode,
                                                                    Jumlah,
                                                                    Satuan,
                                                                    CreatedOn,
                                                                    CreatedBy)
                            VALUES ('$plant',
                            '$unitcode',
                            '$productid',
                            '2',
                            '$proses',
                            '$urutanproses',
                            '$kodebahan',
                            '$reff',
                            '$jmlkonsumsi',
                            'Kantong',
                            '$createdon',
                            '$createdby')");
        } else {
            $return = 'Jumlah konsumsi melebihi jumlah teoritis';
        }

        //------Show Table Proses 1
        $sql = mysqli_query($conn, "SELECT * FROM tb_detailprosesmixing WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND
                                                                                ProductID='$productid' AND
                                                                                NoProses= '1' AND
                                                                                Proses='1' AND
                                                                                -- KodeBahan='$kodebahan' AND
                                                                                ReffCode='$reff'
                                                                                ORDER BY CreatedOn, UrutanProses ASC");
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

        //------Show Table Proses 2
        $output2 = '
                <table class="table table-sm table-bordered w-100">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Kode Bahan</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                ';
        $sql = mysqli_query($conn, "SELECT * FROM tb_detailprosesmixing WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND
                                                                                ProductID='$productid' AND
                                                                                NoProses='2' AND
                                                                                Proses='2' AND
                                                                                -- KodeBahan='$kodebahan' AND
                                                                                ReffCode='$reff'
                                                                                ORDER BY CreatedOn, UrutanProses ASC");
        if (mysqli_num_rows($sql) != 0) {
            while ($r = mysqli_fetch_array($sql)) {
                $output2 .= '
                            <tr>
                                <td>' . $r["KodeBahan"] . '</td>
                                <td>' . $r["Jumlah"] . '</td>
                                <td>' . $r["Satuan"] . '</td>
                            </tr>
                ';
            }
            $output2 .= '
                        </table>';
        }
        $return = true;

        $sql = mysqli_query($conn, "SELECT DISTINCT ProductID,
                                                    ReffCode,
                                                    KodeBahan FROM tb_detailprosesmixing WHERE Plant='$plant' AND 
                                                                                            UnitCode='$unitcode' AND
                                                                                            ProductID='$productid' AND
                                                                                            NoProses= 1 AND
                                                                                            KodeBahan='$kodebahan' AND
                                                                                            ReffCode='$reff'");
        if (mysqli_num_rows($sql) != 0) {
            while ($r = mysqli_fetch_array($sql)) {
                $query = mysqli_query($conn, "SELECT * FROM mapping_preparemixing WHERE Plant='$plant' AND
                                                                                        UnitCode='$unitcode' AND
                                                                                        ProductID='$r[ProductID]' AND
                                                                                        ReffCode='$r[ReffCode]' AND
                                                                                        KodeBahan='$r[KodeBahan]'");
                if (mysqli_num_rows($query) == 0) {
                    mysqli_query($conn, "INSERT INTO mapping_preparemixing (Plant,
                                                                            UnitCode,
                                                                            ProductID,
                                                                            KodeBahan,
                                                                            ReffCode,
                                                                            JmlTeoritis,
                                                                            ScanQty,
                                                                            CreatedOn,
                                                                            CreatedBy)
                                        VALUES('$plant',
                                                '$unitcode',
                                                '$r[ProductID]',
                                                '$r[KodeBahan]',
                                                '$r[ReffCode]',
                                                '$jmlteoritis',
                                                '$scanqty',
                                                '$createdon',
                                                '$createdby')");
                }
            }
        }
        $output3 = '
                <table class="table table-sm table-bordered w-25">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Kode Bahan</th>
                            <th>Jumlah Teoritis</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                ';
        $query = mysqli_query($conn, "SELECT * FROM mapping_preparemixing WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                ProductID='$productid' AND
                                                                                ReffCode='$reff'");
        if (mysqli_num_rows($query) != 0) {
            while ($r = mysqli_fetch_array($query)) {
                $q = mysqli_query($conn, "SELECT SUM(Jumlah) AS Jumlah FROM tb_detailprosesmixing WHERE Plant='$plant' AND
                                                                                        UnitCode='$unitcode' AND
                                                                                        NoProses='1' AND
                                                                                        ProductID='$productid' AND
                                                                                        ReffCode='$reff' AND
                                                                                        KodeBahan='$r[KodeBahan]'");
                $qr = mysqli_fetch_array($q);
                $jumlah = number_format($qr['Jumlah'], 0);
                $jmlteoritis = number_format($r['JmlTeoritis'], 0);
                if ($qr['Jumlah'] == '0.5') {
                    $stats = '<button type="button" class="btn btn-sm btn-light" value="' . $r['KodeBahan'] . '" onclick="cekmissingkodebahan(this.value)">(X) <img src="../asset/icon/cari.png"></button>';
                } else {
                    if ($jumlah < $jmlteoritis) {
                        $stats = '<button type="button" class="btn btn-sm btn-light" value="' . $r['KodeBahan'] . '" onclick="cekmissingkodebahan(this.value)">(X) <img src="../asset/icon/cari.png"></button>';
                    } else if ($jmlteoritis == $jumlah) {
                        $stats = '<input type="text" class="form-control form-control-sm border-0 bg-transparent" value="(√)" readonly>';
                    }
                }

                $output3 .= '
                        <tr>
                            <td>' . $r["KodeBahan"] . '</td>
                            <td>' . $r["JmlTeoritis"] . '</td>
                            <td>' . $stats . '</td>
                        </tr>';
            }
            $output3 .= '
                       </table>';
        }
    }

    $sql = mysqli_query($conn, "SELECT * FROM tb_detailprosesmixing WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND
                                                                            -- ProductID='$productid' AND
                                                                            NoProses='1' AND
                                                                            Proses='1' AND
                                                                            ReffCode='$reff'
                                                                            ORDER BY UrutanProses DESC");
    if (mysqli_num_rows($sql) != 0) {
        $row = mysqli_fetch_array($sql);
        $urutanproses = $row['UrutanProses'] + 1;
    } else {
        $urutanproses = 1;
    }
    $dump['urutanproses'] = $urutanproses;
    // $dump['proses'] = $proses;
    $dump['output1'] = $output1;
    $dump['output2'] = $output2;
    $dump['output3'] = $output3;
    $dump['return'] = $return;
    $dump['a'] = $a;
    $dump['b'] = $b;
    loguser2('Input Kode Bahan Planning');
    echo json_encode($dump);
}
if (isset($_POST['prosesvalidasijmlteoritis'])) {
    $reffcode = $_POST['prosesvalidasijmlteoritis'][0];
    $kodebahan = $_POST['prosesvalidasijmlteoritis'][1];
    $return = false;
    $totaljumlah = 0;

    $sql = mysqli_query($conn, "SELECT JmlTeoritis FROM mapping_preparemixing WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        KodeBahan='$kodebahan' AND
                                                                        ReffCode='$reffcode'");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $jmlteoritis = number_format($r['JmlTeoritis']);
        $query = mysqli_query($conn, "SELECT Jumlah FROM tb_detailprosesmixing WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND
                                                                                NoProses='1' AND
                                                                                KodeBahan='$kodebahan' AND
                                                                                ReffCode='$reffcode'");
        if (mysqli_num_rows($query) != 0) {
            while ($row = mysqli_fetch_array($query)) {
                if ($row['Jumlah'] > 1) {
                    $jumlah = number_format($row['Jumlah'], 0);
                } else {
                    $jumlah = $row['Jumlah'];
                }

                $totaljumlah = $totaljumlah + $row['Jumlah'];
            }
        }
        $return = true;
    }
    $dump['return'] = $return;
    $dump['jmlteoritis'] = $jmlteoritis;
    $dump['jumlah'] = $jumlah;
    $dump['totjumlah'] = $totaljumlah;
    echo json_encode($dump);
}
if (isset($_POST['prosesvalidasikodebahan'])) {
    $kodebahan = strtoupper($_POST['prosesvalidasikodebahan']);
    $return = false;
    $filename = "../asset/data/data.txt";
    $file_contents = file_get_contents($filename);
    $file_array = explode(PHP_EOL, $file_contents);
    $file = json_encode($file_array);
    $file_1 = str_replace('"', '', $file);
    $file_1 = str_replace('[', '', $file_1);
    $file_1 = str_replace(']', '', $file_1);
    $file_explode = explode(",", $file_1);
    $i = 0;
    $lenght = count($file_explode);
    for ($i = 0; $i < $lenght; $i++) {
        if ($kodebahan == $file_explode[$i]) {
            $return = true;
            continue;
        }
    }
    echo $return;
}
if (isset($_POST['prosesprosescreatepengolahan'])) {
    $proses = $_POST['prosesprosescreatepengolahan'][0];
    $reff = $_POST['prosesprosescreatepengolahan'][1];

    $sql = mysqli_query($conn, "SELECT * FROM tb_detailprosesmixing WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND
                                                                            Proses='$proses' AND
                                                                            ReffCode='$reff'
                                                                            ORDER BY UrutanProses DESC");
    if (mysqli_num_rows($sql) != 0) {
        $row = mysqli_fetch_array($sql);
        $urutanproses = $row['UrutanProses'] + 1;
    } else {
        $urutanproses = 1;
    }
    $dump['urutanproses'] = $urutanproses;
    $dump['return'] = true;
    echo json_encode($dump);
}

// ---------------------------------------------------------
// Analisa Organoleptis - QC
// ---------------------------------------------------------
if (isset($_POST["prosessimpanqcorganoleptis"])) {
    $prueflos = $_POST["prosessimpanqcorganoleptis"][0];
    $years = $_POST["prosessimpanqcorganoleptis"][1];
    $noproses = $_POST["prosessimpanqcorganoleptis"][2];
    $ud = $_POST["prosessimpanqcorganoleptis"][3];
    $result_awal = $_POST["prosessimpanqcorganoleptis"][4];
    $result_tengah = $_POST["prosessimpanqcorganoleptis"][5];
    $result_akhir = $_POST["prosessimpanqcorganoleptis"][6];
    $lenght = $_POST["prosessimpanqcorganoleptis"][7];
    $mic = $_POST["prosessimpanqcorganoleptis"][8];
    $keterangan = $_POST["prosessimpanqcorganoleptis"][9];

    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $return = false;

    $sql = mysqli_query($conn, "SELECT * FROM result_recording WHERE Plant='$plant' AND
                                                                    UnitCode='$unitcode' AND
                                                                    InspectionLot='$prueflos' AND
                                                                    Lotyears='$years' AND
                                                                    NoProses='$noproses'");
    if (mysqli_num_rows($sql) == 0) {
        $a = $lenght;
        for ($i = 1; $i < $lenght; $i++) {
            $sql = mysqli_query($conn, "INSERT INTO result_recording(Plant,
                                                                    UnitCode,
                                                                    InspectionLot,
                                                                    Lotyears,
                                                                    NoProses,
                                                                    MIC,
                                                                    Result_Awal,
                                                                    Result_Tengah,
                                                                    Result_Akhir,
                                                                    Ket_hasiltolak,
                                                                    CreatedOn,
                                                                    CreatedBy)
                                        VALUES('$plant',
                                                '$unitcode',
                                                '$prueflos',
                                                '$years',
                                                '$noproses',
                                                '$mic[$i]',
                                                '$result_awal[$i]',
                                                '$result_tengah[$i]',
                                                '$result_akhir[$i]',
                                                '$keterangan[$i]',
                                                '$createdon',
                                                '$createdby')");
        }
        mysqli_query($conn, "INSERT INTO usage_decision (Plant,
                                                        UnitCode,
                                                        InspectionLot,
                                                        Lotyears,
                                                        NoProses,
                                                        UDcode,
                                                        CreatedOn,
                                                        CreatedBy)
                                VALUES ('$plant',
                                        '$unitcode',
                                        '$prueflos',
                                        '$years',
                                        '$noproses',
                                        '$ud',
                                        '$createdon',
                                        '$createdby')");


        if ($sql === true) {
            $query = mysqli_query($conn, "SELECT PlanningNumber,Years,BatchNumber FROM insp_pengolahan_header WHERE Plant='$plant' AND 
                                                                                                                    UnitCode='$unitcode' AND 
                                                                                                                    InspectionLot='$prueflos' AND
                                                                                                                    Lotyears='$years'");
            if (mysqli_num_rows($query) != 0) {
                $row = mysqli_fetch_array($query);
                $planningnumber = $row['PlanningNumber'];
                $years = $row['Years'];
                $bets = $row['BatchNumber'];
                $productid = $row['ProductID'];
                //-------UPDATE Stats05 - Sdh dianalisa organo oleh QC
                mysqli_query($conn, "UPDATE planning_pengolahan_subdetail SET Stats05='X' WHERE Plant='$plant' AND
                                                                                                UnitCode='$unitcode' AND
                                                                                                PlanningNumber='$planningnumber' AND
                                                                                                Years='$years' AND
                                                                                                ProductID='$productid' AND
                                                                                                BatchNumber='$bets' AND
                                                                                                NoProses='$noproses'");
                //------End
                $get_jmlproses = mysqli_query($conn, "SELECT JmlProses FROM tb_eraseprosespengolahan WHERE Plant='$plant' AND 
                                                                                                            UnitCode='$unitcode' AND 
                                                                                                            PlanningNumber='$planningnumber' AND
                                                                                                            Years='$years' AND
                                                                                                            BatchNumber='$bets'");
                $show_jmlproses = mysqli_fetch_array($get_jmlproses);
            }
            if ($noproses == $show_jmlproses['JmlProses']) {
                mysqli_query($conn, "UPDATE insp_pengolahan_header SET StatsX='X' WHERE Plant='$plant' AND
                                                                                    UnitCode='$unitcode' AND
                                                                                    InspectionLot='$prueflos' AND
                                                                                    Lotyears='$years'");
            }
            $return = true;
        }
    }
    $data = [
        "return" => $return,
        "prueflos" => $a,
    ];
    echo json_encode($data);
}
if (isset($_POST["prosesshowinspanalisaorganoleptis"])) {
    $insplot = $_POST["prosesshowinspanalisaorganoleptis"][0];
    $years = $_POST["prosesshowinspanalisaorganoleptis"][1];
    $productid = $_POST["prosesshowinspanalisaorganoleptis"][2];
    $noproses = $_POST["prosesshowinspanalisaorganoleptis"][3];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];

    $sql = mysqli_query($conn, "SELECT * FROM insp_pengolahan_header WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        InspectionLot='$insplot' AND
                                                                        Lotyears='$years' AND
                                                                        NoProses='$noproses' AND
                                                                        StatsY !='REL'");
    if (mysqli_num_rows($sql) != 0) {
        $row = mysqli_fetch_array($sql);
        $batch = $row['BatchNumber'];
        $mic = mysqli_query($conn, "SELECT  A.MIC,
                                            B.Descriptions,
                                            B.FullyDesc,
                                            B.Qual,
                                            B.Quan FROM assign_mic AS A INNER JOIN master_inspection AS B
                                            ON A.MIC = B.MIC WHERE A.Plant='$plant' AND
                                                                    B.Plant='$plant' AND
                                                                    A.UnitCode='$unitcode' AND
                                                                    A.ProductID='$productid'");
        if (mysqli_num_rows($mic) != 0) {
            $output = '
                <table class="table table-sm w-75">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>Master Of Insp. Char</th>
                                    <th style="width: 30%;">Deskripsi</th>
                                    <th>Spesifiaksi</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>';
            while ($row = mysqli_fetch_array($mic)) {
                $type = 'Quan';
                if ($row["Qual"] = 'X') {
                    $type = 'Qual';
                }
                $output .= '<tr>
                                <td>' . $row["MIC"] . '</td>
                                <td>' . $row["Descriptions"] . '</td>
                                <td>' . $row["FullyDesc"] . '</td>
                                <td>' . $row["MIC"] . '</td>
                            </tr>';
            }
            $output .= '
            </tbody>
            </table>';
        }
    }
    echo $output;
}
if (isset($_POST["prosesgetdescmaterial"])) {
    $productid = $_POST["prosesgetdescmaterial"];
    $sql = mysqli_query($conn, "SELECT ProductDescriptions FROM mara_product WHERE ProductID='$productid'");
    $row = mysqli_fetch_array($sql);
    echo $row['ProductDescriptions'];
}
if (isset($_POST["prosesassignmicanalisaorganoleptis"])) {
    $insplot = $_POST["prosesassignmicanalisaorganoleptis"][0];
    $years = $_POST["prosesassignmicanalisaorganoleptis"][1];
    $productid = $_POST["prosesassignmicanalisaorganoleptis"][2];
    $createdon = date("Y-m-d H:i:s");
    $createdby = $_SESSION['userid'];
    $return = false;

    $sql = mysqli_query($conn, "SELECT * FROM insp_pengolahan_header WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        InspectionLot='$insplot' AND
                                                                        Lotyears='$years' AND
                                                                        StatsY !='REL'");
    if (mysqli_num_rows($sql) != 0) {
        $row = mysqli_fetch_array($sql);
        $batch = $row['BatchNumber'];
        $mic = mysqli_query($conn, "SELECT  A.MIC,
                                            B.Descriptions,
                                            B.FullyDesc,
                                            B.Qual,
                                            B.Quan FROM assign_mic AS A INNER JOIN master_inspection AS B
                                            ON A.MIC = B.MIC WHERE A.Plant='$plant' AND
                                                                    B.Plant='$plant' AND
                                                                    A.UnitCode='$unitcode' AND
                                                                    A.ProductID='$productid'");
        if (mysqli_num_rows($mic) != 0) {
            while ($row = mysqli_fetch_array($mic)) {
                mysqli_query($conn, "INSERT INTO insp_pengolahan_detail (Plant,
                                                                        UnitCode,
                                                                        InspectionLot,
                                                                        Lotyears,
                                                                        MIC,
                                                                        Descriptions,
                                                                        FullyDesc,
                                                                        ProductID,
                                                                        BatchNumber,
                                                                        CreatedOn,
                                                                        CreatedBy)
                                    VALUES('$plant',
                                            '$unitcode',
                                            '$insplot',
                                            '$years',
                                            '$row[MIC]',
                                            '$row[Descriptions]',
                                            '$row[FullyDesc]',
                                            '$productid',
                                            '$batch',
                                            '$createdon',
                                            '$createdby')");
            }
            mysqli_query($conn, "UPDATE insp_pengolahan_header SET StatsY='REL' WHERE Plant='$plant' AND
                                                                                    UnitCode='$unitcode' AND
                                                                                    InspectionLot='$insplot' AND
                                                                                    Lotyears='$years'");
            $return = true;
        }
    }
    echo $return;
}


// ---------------------------------------------------------
// Cek Status - QC
// ---------------------------------------------------------
if (isset($_POST["prosescekstatusqc"])) {
    $value = $_POST["prosescekstatusqc"];
    $barcode = explode(',', $value);
    $return = 'On Progress';
    $sql = mysqli_query($conn, "SELECT * FROM insp_pengolahan_header WHERE Plant='$barcode[0]' AND
                                                                            UnitCode='$barcode[1]' AND
                                                                            PlanningNumber='$barcode[2]' AND
                                                                            Years='$barcode[3]' AND
                                                                            ProductID='$barcode[5]' AND
                                                                            BatchNumber='$barcode[6]'");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        if ($r['StatsX'] == 'X') {
            $return = 'LULUS';
        }
    }
    echo $return;
}

// ---------------------------------------------------------
// Report Pengolahan
// ---------------------------------------------------------
if (isset($_POST["prosespilihanpengolahan"])) {
    $planningnumber = $_POST["prosespilihanpengolahan"][0];
    $years = $_POST["prosespilihanpengolahan"][1];

    $usedby = $_SESSION['userid'];
    $sql = mysqli_query($conn, "SELECT ResourceIDMix  FROM tbl_hasiltimbang_header WHERE Plant='$plant' AND 
                                                                                            UnitCode='$unitcode' AND 
                                                                                            PlanningNumber='$planningnumber' AND 
                                                                                            Years='$years' 
                                                                                            GROUP BY ResourceIDMix");
    if (mysqli_num_rows($sql) != 0) { ?>
        <?php
        while ($r = mysqli_fetch_array($sql)) {
            $query = mysqli_query($conn, "SELECT ResourceDescriptions1 FROM crhd_mixing WHERE ResourceID='$r[ResourceIDMix]'");
            $q = mysqli_fetch_array($query);
        ?>
            <option value="<?= $r['ResourceIDMix'] ?>"><?= $r['ResourceIDMix'] . ' - ' . $q['ResourceDescriptions1'] ?></option>
<?php
        }
    } else {
        echo "<option selected>Data not Found</option>";
    }
}

// ---------------------------------------------------------
// Lacak Planning
// ---------------------------------------------------------
if (isset($_POST["prosessubmitstartlacakplanning"])) {
    $productid = $_POST["prosessubmitstartlacakplanning"][0];
    $bets = $_POST["prosessubmitstartlacakplanning"][1];
    $plan_peng = 0;

    //---Pengolahan
    $sql = mysqli_query($conn, "SELECT * FROM planning_pengolahan_subdetail WHERE Plant='$plant' AND 
                                                                                    UnitCode='$unitcode' AND 
                                                                                    ProductID='$productid' AND
                                                                                    BatchNumber='$bets' AND
                                                                                    NoProses='1'");
    if (mysqli_num_rows($sql) != 0) {
        $query = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND
                                                                                ProductID='$productid' AND 
                                                                                BatchNumber='$bets'");
        if (mysqli_num_rows($query) != 0) {
            $row = mysqli_fetch_array($query);
            $plan_peng = 1;
            $planning_pengemasan = $row['PlanningNumber'];
            $years_pengemasan = $row['Years'];
        }
        $i = 1;
        // $no = 1;
        $output = "";
        while ($r = mysqli_fetch_array($sql)) {
            $no = 1;
            include_once "getvalue.php";
            $desc = Getdata('ProductDescriptions', 'mara_product', 'ProductID', $r['ProductID']);
            $insp_lot = GetdataIV('InspectionLot', 'insp_pengolahan_header', 'Plant', $r['Plant'], 'UnitCode', $r['UnitCode'], 'PlanningNumber', $r['PlanningNumber'], 'Years', $r['Years']);
            $insp_years = GetdataIV('Lotyears', 'insp_pengolahan_header', 'Plant', $r['Plant'], 'UnitCode', $r['UnitCode'], 'PlanningNumber', $r['PlanningNumber'], 'Years', $r['Years']);
            $output .= "
                <div class='mb-5'>
                    <p class='fw-bold mb-5'>Data Planning #" . $i . "</p>
                    <hr class='w-50'>
                    <div class='form-group row mb-3'>
                        <div class='col-sm-8'>
                            <table class='table table-sm w-50'>
                                <tr>
                                    <td>Product</td>
                                    <td>:</td>
                                    <td>" . $r['ProductID'] . "</td>
                                </tr>
                                <tr>
                                    <td>Desc</td>
                                    <td>:</td>
                                    <td>" . $desc . "</td>
                                </tr>
                                <tr>
                                    <td>Bets</td>
                                    <td>:</td>
                                    <td>" . $r['BatchNumber'] . "</td>
                                </tr>
                            </table>
                        </div>
                        <div class='col-sm-4'>
                            <table class='table table-sm'>
                                <tr>
                                    <td>Planning Number (Pengolahan)</td>
                                    <td>:</td>
                                    <td>" . $r['PlanningNumber'] . "</td>
                                </tr>
                                <tr>
                                    <td>Years (Pengolahan)</td>
                                    <td>:</td>
                                    <td>" . $r['Years'] . "</td>
                                </tr>
                                <tr>
                                    <td>Planning Number (Pengemasan)</td>
                                    <td>:</td>
                                    <td>" . $row['PlanningNumber'] . "</td>
                                </tr>
                                <tr>
                                    <td>Years (Pengemasan)</td>
                                    <td>:</td>
                                    <td>" . $row['Years'] . "</td>
                                </tr>
                                <tr>
                                    <td>Created On</td>
                                    <td>:</td>
                                    <td>" . $r['CreatedOn'] . "</td>
                                </tr>
                                <tr>
                                    <td>Created By</td>
                                    <td>:</td>
                                    <td>" . $r['CreatedBy'] . "</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <p class='fw-bold'>----- Tracking Bets</p>";

            $output .= "
                
                    <div class='form-group row mb-0'>
                        <div class='col-sm-6'>
                            <table class='table table-sm w-100'>
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th style='width:50%'>Descriptions</th>
                                    <th>Created On</th>
                                    <th>Created By</th>    
                                </tr>";
            $output .= "
                               <tr>
                                    <td colspan=4 class='fw-bold'>Planning Pengolahan</td>
                                </tr>";

            // ------Create Planning
            if ($r['Stats01'] == 'X') {
                $createdon = '';
                $createdby = '';
                $createdon = GetdataIV('CreatedOn', 'planning_pengolahan_header', 'Plant', $r['Plant'], 'UnitCode', $r['UnitCode'], 'PlanningNumber', $r['PlanningNumber'], 'Years', $r['Years']);
                $createdby = Getpernr(GetdataIV('CreatedBy', 'planning_pengolahan_header', 'Plant', $r['Plant'], 'UnitCode', $r['UnitCode'], 'PlanningNumber', $r['PlanningNumber'], 'Years', $r['Years']));
                $output .= "
                                <tr>
                                    <td>" . $no . ".</td>
                                    <td style='width:50%'>Create Planning Pengolahan</td>
                                    <td>" . $createdon . "</td>
                                    <td>" . $createdby . "</td>    
                                </tr>";
                $no += 1;
            }
            // -------Aprov Planning
            if ($r['Stats01'] == 'X') {
                $createdon = '';
                $createdby = '';
                $createdon = GetdataIV('ChangedOn', 'planning_pengolahan_header', 'Plant', $r['Plant'], 'UnitCode', $r['UnitCode'], 'PlanningNumber', $r['PlanningNumber'], 'Years', $r['Years']);
                $createdby = Getpernr(GetdataIV('ChangedBy', 'planning_pengolahan_header', 'Plant', $r['Plant'], 'UnitCode', $r['UnitCode'], 'PlanningNumber', $r['PlanningNumber'], 'Years', $r['Years']));
                $output .= "
                                <tr>
                                    <td>" . $no . ".</td>
                                    <td style='width:50%'>Approval Planning Pengolahan</td>
                                    <td>" . $createdon . "</td>
                                    <td>" . $createdby . "</td>    
                                </tr>";
                $no += 1;
            }
            // ----Prepare Mixing
            if ($r['Stats02'] == 'X') {
                $createdon = '';
                $createdby = '';
                $createdon = GetdataIV('CreatedOn', 'tb_headerbahanpengolahan', 'Plant', $r['Plant'], 'UnitCode', $r['UnitCode'], 'PlanningNumber', $r['PlanningNumber'], 'Years', $r['Years']);
                $createdby = Getpernr(GetdataIV('CreatedBy', 'tb_headerbahanpengolahan', 'Plant', $r['Plant'], 'UnitCode', $r['UnitCode'], 'PlanningNumber', $r['PlanningNumber'], 'Years', $r['Years']));
                $output .= "
                                <tr>
                                    <td>" . $no . ".</td>
                                    <td style='width:50%'>Persiapan Mixing (Scan Bahan)</td>
                                    <td>" . $createdon . "</td>
                                    <td>" . $createdby . "</td>
                                </tr>";
                $no += 1;
            }
            // ----Prepare Mixing (Ruangan)
            if ($r['Stats03'] == 'X') {
                $createdon = '';
                $createdby = '';
                $createdon = GetdataIV('CreatedOn', 'proses_prepare_mixer', 'Plant', $r['Plant'], 'UnitCode', $r['UnitCode'], 'PlanningNumber', $r['PlanningNumber'], 'Years', $r['Years']);
                $createdby = Getpernr(GetdataIV('CreatedBy', 'proses_prepare_mixer', 'Plant', $r['Plant'], 'UnitCode', $r['UnitCode'], 'PlanningNumber', $r['PlanningNumber'], 'Years', $r['Years']));
                $output .= "
                                <tr>
                                    <td>" . $no . ".</td>
                                    <td style='width:50%'>Persiapan Bahan (Ruangan)</td>
                                    <td>" . $createdon . "</td>
                                    <td>" . $createdby . "</td>
                                </tr>";
                $no += 1;
            }
            //----Proses Mixing
            if ($r['Stats04'] == 'X') {
                $createdon = '';
                $createdby = '';
                $createdon = GetdataIV('CreatedOn', 'tb_headerprosesmixing', 'Plant', $r['Plant'], 'UnitCode', $r['UnitCode'], 'PlanningNumber', $r['PlanningNumber'], 'Years', $r['Years']);
                $createdby = Getpernr(GetdataIV('CreatedBy', 'tb_headerprosesmixing', 'Plant', $r['Plant'], 'UnitCode', $r['UnitCode'], 'PlanningNumber', $r['PlanningNumber'], 'Years', $r['Years']));
                $output .= "
                                <tr>
                                    <td>" . $no . ".</td>
                                    <td style='width:50%'>Proses Mixing</td>
                                    <td>" . $createdon . "</td>
                                    <td>" . $createdby . "</td>
                                </tr>";
                $no += 1;
            }
            //---- Organo
            if ($r['Stats05'] == 'X') {
                $createdon = '';
                $createdby = '';
                $createdon = GetdataIV('CreatedOn', 'usage_decision', 'Plant', $r['Plant'], 'UnitCode', $r['UnitCode'], 'InspectionLot ', $insp_lot, 'Lotyears', $insp_years);
                $createdby = Getpernr(GetdataIV('CreatedBy', 'usage_decision', 'Plant', $r['Plant'], 'UnitCode', $r['UnitCode'], 'InspectionLot ', $insp_lot, 'Lotyears', $insp_years));
                $output .= "
                                <tr>
                                    <td>" . $no . ".</td>
                                    <td style='width:50%'>QC Organo</td>
                                    <td>" . $createdon . "</td>
                                    <td>" . $createdby . "</td>
                                </tr>";
                $no += 1;
            }
            //-----Timbang Bahan
            if ($r['Stats06'] == 'X') {
                $createdon = '';
                $createdby = '';
                $createdon = GetdataIV('CreatedOn', 'tbl_hasiltimbang_header', 'Plant', $r['Plant'], 'UnitCode', $r['UnitCode'], 'PlanningNumber', $r['PlanningNumber'], 'Years', $r['Years']);
                $createdby = Getpernr(GetdataIV('CreatedBy', 'tbl_hasiltimbang_header', 'Plant', $r['Plant'], 'UnitCode', $r['UnitCode'], 'PlanningNumber', $r['PlanningNumber'], 'Years', $r['Years']));
                $output .= "
                                <tr>
                                    <td>" . $no . ".</td>
                                    <td style='width:50%'>Timbang Bahan</td>
                                    <td>" . $createdon . "</td>
                                    <td>" . $createdby . "</td>
                                </tr>";
                $no += 1;
            }

            //-------Pengemasan
            if ($plan_peng == 1) {
                $no = 1;
                $createdon = $row['CreatedOn'];
                $createdby = $row['CreatedBy'];
                $output .= "
                               <tr>
                                    <td colspan=4 class='fw-bold'>Planning Pengemasan</td>
                                </tr>";
                $output .= "
                               <tr>
                                    <td>" . $no . ".</td>
                                    <td style='width:50%'>Create Planning Pengemasan</td>
                                    <td>" . $createdon . "</td>
                                    <td>" . Getpernr($createdby) . "</td>
                                </tr>";
                $no += 1;
                if ($row['Approval'] == 'X') {
                    $output .= "
                               <tr>
                                    <td>" . $no . ".</td>
                                    <td style='width:50%'>Approval Planning</td>
                                    <td>" . $createdon . "</td>
                                    <td>" . Getpernr($createdby) . "</td>
                                </tr>";
                    $no += 1;
                }
                if ($row['PrepareHoper'] == 'X') {
                    $output .= "
                               <tr>
                                    <td>" . $no . ".</td>
                                    <td style='width:50%'>Prepare Hoper</td>
                                    <td>" . $createdon . "</td>
                                    <td>" . Getpernr($createdby) . "</td>
                                </tr>";
                    $no += 1;
                }
                if ($row['ProsesHoper'] == 'X') {
                    $output .= "
                               <tr>
                                    <td>" . $no . ".</td>
                                    <td style='width:50%'>Proses Hoper</td>
                                    <td>" . $createdon . "</td>
                                    <td>" . Getpernr($createdby) . "</td>
                                </tr>";
                    $no += 1;
                }
                if ($row['PrepareTopack'] == 'X') {
                    $output .= "
                               <tr>
                                    <td>" . $no . ".</td>
                                    <td style='width:50%'>Prepare Topack</td>
                                    <td>" . $createdon . "</td>
                                    <td>" . Getpernr($createdby) . "</td>
                                </tr>";
                    $no += 1;
                }
                if ($row['ProsesTopack'] == 'X') {
                    $output .= "
                               <tr>
                                    <td>" . $no . ".</td>
                                    <td style='width:50%'>Proses Topack</td>
                                    <td>" . $createdon . "</td>
                                    <td>" . Getpernr($createdby) . "</td>
                                </tr>";
                    $no += 1;
                }
                if ($row['EngineSetTopack'] == 'X') {
                    $output .= "
                               <tr>
                                    <td>" . $no . ".</td>
                                    <td style='width:50%'>Engine Set Topack</td>
                                    <td>" . $createdon . "</td>
                                    <td>" . Getpernr($createdby) . "</td>
                                </tr>";
                    $no += 1;
                }
                if ($row['ApprovalQc'] == 'X') {
                    $output .= "
                               <tr>
                                    <td>" . $no . ".</td>
                                    <td style='width:50%'>Approval QC</td>
                                    <td>" . $createdon . "</td>
                                    <td>" . Getpernr($createdby) . "</td>
                                </tr>";
                    $no += 1;
                }
                if ($row['PreparePillow'] == 'X') {
                    $output .= "
                               <tr>
                                    <td>" . $no . ".</td>
                                    <td style='width:50%'>Prepare Pillow</td>
                                    <td>" . $createdon . "</td>
                                    <td>" . Getpernr($createdby) . "</td>
                                </tr>";
                    $no += 1;
                }
                if ($row['AnalisaKemasSekunder'] == 'X') {
                    $output .= "
                               <tr>
                                    <td>" . $no . ".</td>
                                    <td style='width:50%'>Analisa Pengemasan Sekunder</td>
                                    <td>" . $createdon . "</td>
                                    <td>" . Getpernr($createdby) . "</td>
                                </tr>";
                    $no += 1;
                }
                if ($row['ProsesPillow'] == 'X') {
                    $output .= "
                               <tr>
                                    <td>" . $no . ".</td>
                                    <td style='width:50%'>Proses Pillow</td>
                                    <td>" . $createdon . "</td>
                                    <td>" . Getpernr($createdby) . "</td>
                                </tr>";
                    $no += 1;
                }
                if ($row['RekonPillow'] == 'X') {
                    $output .= "
                               <tr>
                                    <td>" . $no . ".</td>
                                    <td style='width:50%'>Rekonsiliasi Pillow Pack</td>
                                    <td>" . $createdon . "</td>
                                    <td>" . Getpernr($createdby) . "</td>
                                </tr>";
                    $no += 1;
                }
                if ($row['ReviewMG'] == 'X') {
                    $output .= "
                               <tr>
                                    <td>" . $no . ".</td>
                                    <td style='width:50%'>Review Manager/KA Unit</td>
                                    <td>" . $createdon . "</td>
                                    <td>" . Getpernr($createdby) . "</td>
                                </tr>";
                    $no += 1;
                }
                if ($row['ReviewQA'] == 'X') {
                    $output .= "
                               <tr>
                                    <td>" . $no . ".</td>
                                    <td style='width:50%'>Review Quality Assurance</td>
                                    <td>" . $createdon . "</td>
                                    <td>" . Getpernr($createdby) . "</td>
                                </tr>";
                    $no += 1;
                }
            }
            $output .= "
                            </tbody>
                        </table>";
            $output .= "
                </div>
            </div>
        </div>";
            $i += 1;
        }
    }
    $dump['output'] = $output;
    echo json_encode($dump);
}

// ---------------------------------------------------------
// Config Web
// ---------------------------------------------------------
if (isset($_POST["prosessimpanconfigdataconfiguration"])) {
    $values = $_POST["prosessimpanconfigdataconfiguration"][0];
    $plant = $_SESSION['plant'];
    $unitcode = $_SESSION['unitcode'];
    $return = false;
    $changedon = date("Y-m-d H:i:s");
    $changedby = $_SESSION['userid'];
    if ($values == 1) {
        $dashboard_createplanning = getvaluetoX($_POST["prosessimpanconfigdataconfiguration"][1]);
        $usedstokhopper = getvaluetoX($_POST["prosessimpanconfigdataconfiguration"][2]);
        $sql = mysqli_query($conn, "UPDATE tb_configweb SET StatsX='$dashboard_createplanning',
                                                            ChangedBy='$changedby',
                                                            ChangedOn='$changedon'
                                                        WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                             AND FormReviewer ='create_planning'");
        $sql = mysqli_query($conn, "UPDATE tb_configweb SET StatsX='$usedstokhopper',
                                                                             ChangedBy='$changedby',
                                                                             ChangedOn='$changedon'
                                                                         WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                              AND FormReviewer ='used_stock_hopper'");
        $return = $sql;
    } elseif ($values == 2) {
        $used_reviewercreateplanning = getvaluetoX($_POST["prosessimpanconfigdataconfiguration"][1]);
        $show_reviewercreateplanning = getvaluetoX($_POST["prosessimpanconfigdataconfiguration"][2]);
        $add_reviewercreateplanning = getvaluetoX($_POST["prosessimpanconfigdataconfiguration"][3]);

        $sql = mysqli_query($conn, "UPDATE tb_configreviewer SET ShowReviewer='$show_reviewercreateplanning',
                                                            Addreviewer='$add_reviewercreateplanning',
                                                            StatsX='$used_reviewercreateplanning',
                                                            ChangedBy='$changedby',
                                                            ChangedOn='$changedon'
                                                        WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                             AND ProcessType='create_planning'");
        $return = $sql;
    } elseif ($values == 3) {
        $usedstokhopper = getvaluetoX($_POST["prosessimpanconfigdataconfiguration"][1]);
        $items_1 = $_POST["prosessimpanconfigdataconfiguration"][2];

        $sql = mysqli_query($conn, "UPDATE tbl_configuration SET StatsX='$usedstokhopper',
                                                            ChangedBy='$changedby',
                                                            ChangedOn='$changedon'
                                                        WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                             AND Items=$items_1");
        $return = $sql;
    }
    echo $return;
}

// ---------------------------------------------------------
// Config Web
// ---------------------------------------------------------

if (isset($_POST["prosesshowprintlabelbahan"])) {
    $return = 1;
    // Logic save label manual
    echo $return;
}
