<?php
error_reporting();
// session_start();
include '../../../function/koneksi.php';
include '../../../function/getdata.php';
// include '../../../function/getvalue.php';
require_once __DIR__ . '/../../../asset/vendor/autoload.php';
// require_once __DIR__ . '/../../../asset/vendor_qrcode/autoload.php';
require_once __DIR__ . '/../../../asset/vendor_qrcode/autoload.php';

use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

// ob_get_clean();
session_start();
$laporan = str_replace("'", "", $_GET['v']);
$planningnumber = str_replace("'", "", $_GET['n']);
$years = str_replace("'", "", $_GET['y']);
$nomix = str_replace("'", "", $_GET['z']);
$plant = $_SESSION['plant'];
$unitcode = $_SESSION['unitcode'];
$output = '';
$output1 = '';
loguser('Show Report ' . $laporan);

// $sql = mysqli_query($conn, "SELECT * FROM planning_pengolahan_header WHERE PlanningNumber='$planningnumber' AND Years='$years'");
// $r = mysqli_fetch_array($sql);
$header = mysqli_query($conn, "SELECT * FROM planning_pengolahan_detail WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND 
                                                                            PlanningNumber='$planningnumber' AND 
                                                                            Years='$years'");
$rows = mysqli_fetch_array($header);


if ($laporan == 'rencanakerjapencampuran') {
    $sql = mysqli_query($conn, "SELECT * FROM planning_pengolahan_detail WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND 
                                                                            PlanningNumber='$planningnumber' AND 
                                                                            Years='$years'");

    $output = "
    <!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
        // <link rel='stylesheet' href='../../../asset/css/css_report.css'>
    </head>";
    $output .= "
    <body>
        <div class='container'>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black;border-bottom: none !important'>
                        <td style='width:15%;font-weight:bold'><center><img src='../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                        <td style='border: 1px solid black; text-align:center;width:50%;border-bottom: none !important'><p style='font-size:9pt;font-weight:bold'>RENCANA KERJA PENCAMPURAN</p></td>
                        <td style='width:5%;border-bottom: none'>NoForm</td>
                        <td style='width:15%'>: FM-053050-05-00-002</td>
                    </tr>
                    <tr style='border: 1px solid black;border-bottom: none !important;border-top: none !important'>
                        <td style='width:15%; text-align:center'>PRODUKSI</td>
                        <td style='border: 1px solid black;border-bottom: none !important' rowspan=2>PERIODE KERJA: <b>" . date('d', strtotime($rows['CreatedOn'])) . ' ' . getbulanformat(date('m', strtotime($rows['CreatedOn']))) . ' ' . date('Y', strtotime($rows['CreatedOn'])) . "</td>
                        <td style='width:5%;border-bottom: none !important'>Revisi</td>
                        <td style='width:15%'>: 00</td>
                    </tr>
                    <tr style='border: 1px solid black;border-bottom: none !important'>
                        <td style='width:15%; text-align:center'>SERBUK INSTAN & <br> SEDIA PANGAN</td>
                        <td style='width:5%;border-bottom: none !important'>Tgl Berlaku</td>
                        <td style='width:15%'>: 01 Agustus 2016</td>
                    </tr>
                </tbody>
            </table>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <thead>
                    <tr style='border: 1px solid black'>
                        <th style='border: 1px solid black;text-align:center'>Hari</th>
                        <th style='border: 1px solid black;text-align:center'>Tanggal</th>
                        <th style='border: 1px solid black;text-align:center'>Produk</th>
                        <th style='border: 1px solid black;text-align:center'>Mesin</th>
                        <th style='border: 1px solid black;text-align:center'>Jumlah Bets</th>
                        <th style='border: 1px solid black;text-align:center'>ED/BC</th>
                    </tr>
                </thead>
                <tbody>";
    while ($row = mysqli_fetch_array($sql)) {
        $batch_show = explode(',', $row['BatchNumber']);
        $output .= "   <tr style='border: 1px solid black'>
                                <td style='border: 1px solid black'>" . getdayformat(date('w', strtotime($row['CreatedOn']))) . "</td>
                                <td style='border: 1px solid black'>" . date('d/m/Y', strtotime($row['CreatedOn'])) . "</td>
                                <td style='width:40%;border: 1px solid black'>" . Getdata('ProductDescriptions', 'mara_product', 'ProductID', $row['ProductID']) . "</td>
                                <td style='border: 1px solid black'>" . $row['ResourceIDMix'] . "</td>
                                <td style='border: 1px solid black;text-align:center'>" . $row['JumlahResep'] . "</td>
                                <td style='border: 1px solid black'>" . 'ED. ' . date('M Y', strtotime($row['ExpiredDate'])) . '/' . $batch_show[0] . '-' . end($batch_show) . "</td>
                            </tr>";
    }
    $output .= "   
                </tbody>
            </table>
        </div>
    </body>
";
} elseif ($laporan == 'hasiltimbang') {
    $sql = mysqli_query($conn, "SELECT * FROM planning_pengolahan_detail WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND 
                                                                            PlanningNumber='$planningnumber' AND 
                                                                            Years='$years' AND 
                                                                            ResourceIDMix='$nomix'");
    $row = mysqli_fetch_array($sql);
    $hasiltimbang = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber='$planningnumber' AND 
                                                                        Years='$years' AND 
                                                                        Items='$row[Items]' AND
                                                                        Berat >0 AND 
                                                                        ProductID='$row[ProductID]' GROUP BY NoProses, BatchNumber ORDER BY BatchNumber,NoProses ASC");
    $head = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_header WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND 
                                                                        PlanningNumber='$planningnumber' AND 
                                                                        Years='$years' AND 
                                                                        Items='$row[Items]' AND
                                                                        ProductID='$row[ProductID]' AND
                                                                        ResourceIDMix='$nomix'");
    $head_value = mysqli_fetch_array($head);

    $reproses = mysqli_query($conn, "SELECT * FROM table_bahanreproses WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND 
                                                                        PlanningNumber='$planningnumber' AND 
                                                                        Years='$years' AND
                                                                        ProductID='$row[ProductID]'");
    $output = "
    <!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
        // <link rel='stylesheet' href='../../../asset/css/css_report.css'>
    </head>";
    $output .= "
    <body>
        <div class='container'>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black;border-bottom: none !important'>
                        <td style='width:15%;font-weight:bold'><center><img src='../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                        <td style='border: 1px solid black; text-align:center;width:50%;border-bottom: none !important'><p style='font-size:9pt;font-weight:bold'>LAPORAN HASIL PENCAMPURAN KERING (<i>DRY MIX</i>) BETS</p></td>
                        <td style='width:8%;border-bottom: none'>NoForm</td>
                        <td style='width:15%'>: FM-053050-05-00-002</td>
                    </tr>
                    <tr style='border: 1px solid black;border-top: none !important'>
                        <td style='width:15%; text-align:center'>PRODUKSI</td>
                        <td style='border: 1px solid black;border-bottom: none !important' rowspan=2>TANGGAL: <b>" . date('d', strtotime($row['CreatedOn'])) . ' ' . getbulanformat(date('m', strtotime($row['CreatedOn']))) . ' ' . date('Y', strtotime($row['CreatedOn'])) . "</b></td>
                        <td style='width:8%;border-bottom: none !important'>Revisi</td>
                        <td style='width:15%'>: 00</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center'>SERBUK INSTAN & <br> SEDIA PANGAN</td>
                        <td style='width:8%'>Tgl Berlaku</td>
                        <td style='width:15%'>: 01 Agustus 2016</td>
                    </tr>
                </tbody>
            </table>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td rowspan=2 style='border: 1px solid black'>Nama Produk</td>
                        <td rowspan=2 style='border: 1px solid black'><b>" . Getdata('ProductDescriptions', 'mara_product', 'ProductID', $row['ProductID']) . "</b></td>
                        <td style='border: 1px solid black'>Nama/No Mesin</td>
                        <td style='border: 1px solid black'><b>" . $nomix . "</b></td>
                        <td style='border: 1px solid black'>Nama Operator</td>
                        <td>" . Getdata('EmployeeName', 'pa001', 'PersonnelNumber', $head_value['Operator1'])  . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Jumlah Resep</td>
                        <td style='border: 1px solid black'>" . $row['JumlahResep'] . "</td>
                        <td style='border: 1px solid black'>Timbang</td>
                        <td>" . Getdata('EmployeeName', 'pa001', 'PersonnelNumber', $head_value['Operator2']) . "</td>
                    </tr>
                </tbody>
            </table>
            <p style='font-size: 8pt;margin-bottom:0px'>Penggunaan Bahan:</p>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr>
                        <td>
                            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                                <tbody>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>Bahan</td>
                                        <td colspan=6 style='border: 1px solid black'>Tanggal Pencampuran</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>.</td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>.</td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>.</td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                                <tbody>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>Bahan</td>
                                        <td colspan=6 style='border: 1px solid black;text-align:center'>Tanggal Pencampuran</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>.</td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>.</td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>.</td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p style='font-size: 8pt;margin-bottom:0px'>Bahan:</p>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr>
                        <td>
                            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                                <tbody>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>Bahan</td>
                                        <td style='border: 1px solid black'>Jumlah (Kg)</td>
                                        <td style='border: 1px solid black'>Jml Ktng</td>
                                        <td style='border: 1px solid black'>Sisa (Kg)</td>
                                    </tr>";
    if (mysqli_num_rows($reproses) == 0) {
        $output .= "
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>.</td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                    </>
        ";
    }
    while ($br = mysqli_fetch_array($reproses)) {
        $output .= "
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>." . $br['ProductID'] . "</td>
                                        <td style='border: 1px solid black'>" . $br['Berat'] . "</td>
                                        <td style='border: 1px solid black'>" . $br['Bulk'] . "</td>
                                        <td style='border: 1px solid black'>" . $br['BeratKhusus'] . "</td>
                                    </tr>";
    }
    $output .= "
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                                <tbody>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>Bahan</td>
                                        <td style='border: 1px solid black'>Jumlah (Kg)</td>
                                        <td style='border: 1px solid black'>Jml Ktng</td>
                                        <td style='border: 1px solid black'>Sisa (Kg)</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>.</td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <th rowspan=2 style='border: 1px solid black;text-align:center'>No Proses</th>
                        <th rowspan=2 style='border: 1px solid black;text-align:center'>Berat (Kg)</th>
                        <th rowspan=2 style='border: 1px solid black;text-align:center'>Jml Ktng</th>
                        <th rowspan=2 style='border: 1px solid black;text-align:center'>Sisa (Kg)</th>
                        <th rowspan=2 style='border: 1px solid black;text-align:center'>Total (Kg)</th>
                        <th rowspan=2 style='border: 1px solid black;text-align:center'>Bets</th>
                        <th rowspan=2 style='border: 1px solid black;text-align:center'>Jam Kirim</th>
                        <th colspan=2 style='border: 1px solid black;text-align:center'>Paraf</th>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <th style='border: 1px solid black;text-align:center;width:20%'>Pengirim</th>
                        <th style='border: 1px solid black;text-align:center;width:20%'>Penerima</th>
                    </tr>";
    while ($q = mysqli_fetch_array($hasiltimbang)) {
        $query = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND
                                                                                                        UnitCode='$unitcode' AND
                                                                                                        PlanningNumber='$q[PlanningNumber]' AND
                                                                                                        Years='$q[Years]' AND
                                                                                                        Items='$q[Items]' AND
                                                                                                        ProductID='$q[ProductID]' AND
                                                                                                        BatchNumber='$q[BatchNumber]' AND
                                                                                                        NoProses='$q[NoProses]' AND
                                                                                                        Berat >0");
        $jumlahkantong = mysqli_num_rows($query);
        if ($jumlahkantong > 6) {
            $jumlahkantong = 6;
        }
        $query = mysqli_query($conn, "SELECT  Berat FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND
                                                                                                        UnitCode='$unitcode' AND
                                                                                                        PlanningNumber='$q[PlanningNumber]' AND
                                                                                                        Years='$q[Years]' AND
                                                                                                        Items='$q[Items]' AND
                                                                                                        ProductID='$q[ProductID]' AND
                                                                                                        BatchNumber='$q[BatchNumber]' AND
                                                                                                        NoProses='$q[NoProses]'");
        // $r = mysqli_fetch_array($query);
        $totalberat = 0;
        while ($r = mysqli_fetch_array($query)) {
            $totalberat = $r['Berat'] + $totalberat;
        }
        // $totalberat = number_format($r['Berat'], 2);
        $query = mysqli_query($conn, "SELECT Berat FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND
                                                                                        UnitCode='$unitcode' AND
                                                                                        PlanningNumber='$q[PlanningNumber]' AND
                                                                                        Years='$q[Years]' AND
                                                                                        Items='$q[Items]' AND
                                                                                        ProductID='$q[ProductID]' AND
                                                                                        BatchNumber='$q[BatchNumber]' AND
                                                                                        NoProses='$q[NoProses]' AND
                                                                                        NoTong='7'");
        $r = mysqli_fetch_array($query);
        $sisa = $r['Berat'];
        $query = mysqli_query($conn, "SELECT ExpiredDate FROM tbl_hasiltimbang_header WHERE Plant='$plant' AND
                                                                                        UnitCode='$unitcode' AND
                                                                                        PlanningNumber='$q[PlanningNumber]' AND
                                                                                        Years='$q[Years]' AND
                                                                                        Items='$q[Items]' AND
                                                                                        ResourceIDMix='$nomix'");
        $r = mysqli_fetch_array($query);
        $expdate = $r['ExpiredDate'];
        $output .= "
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>" . $q['NoProses'] . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $q['Berat'] . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $jumlahkantong . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $sisa . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $totalberat . "</td>
                        <td style='border: 1px solid black;text-align:center'>ED " . date('M y', strtotime($expdate)) . '/' . $q['BatchNumber'] . "</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                    </tr>";
    }
    $output .= "            
                </tbody>
            </table>
            ";
} elseif ($laporan == 'lampiranpengolahan') {
    $output = "
    <!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body>";
    $query = mysqli_query($conn, "SELECT * FROM planning_pengolahan_subdetail WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND 
                                                                                PlanningNumber='$planningnumber' AND
                                                                                Years='$years'");
    if (mysqli_num_rows($query) <> 0) {
        $r = mysqli_fetch_array($query);
        // $noproses = 1;
        $productid = $r['ProductID'];
        $batchnumber = $r['BatchNumber'];
        $sql = mysqli_query($conn, "SELECT * FROM tb_detailbahanpengolahan WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND 
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years' AND
                                                                            ProductID='$productid' AND
                                                                            BatchNumber='$batchnumber' AND
                                                                            NoProses=1");
        if (mysqli_num_rows($sql) <> 0) {
            $output .= "
            <p class='fw-bold' style='text-align:center;font-size:8pt;font-weight:bold'>PROSES I</p>
            <hr style='margin-bottom:3rem;width:50%'>
            <table style='margin-bottom:1px;font-size:5.4pt;margin-bottom:5px' cellpadding=2 cellspacing=0>              
                    ";
            $lampiranlabelbahan = array();
            while ($q = mysqli_fetch_array($sql)) {
                $kodebahan = $q['KodeBahan'];
                $batchlabel = $q['BatchLabel'];
                $nokantong = $q['NoKantong'];
                $sh = $q['SH'];
                $jenisbahan1 = $q['JenisBahan1'];
                $jenisbahan2 = $q['JenisBahan2'];
                $query = mysqli_query($conn, "SELECT TotalKantong FROM tb_headerbahanpengolahan  WHERE Plant='$plant' AND 
                                                                                                        UnitCode='$unitcode' AND 
                                                                                                        PlanningNumber='$planningnumber' AND
                                                                                                        Years='$years' AND
                                                                                                        ProductID='$productid' AND
                                                                                                        BatchNumber='$batchnumber' AND
                                                                                                        BatchLabel='$batchlabel' AND
                                                                                                        NoProses=1 AND
                                                                                                        KodeBahan='$kodebahan'");
                $z = mysqli_fetch_array($query);
                $totalkantong = $z['TotalKantong'];
                $identitas = trim($q['NoIdentitas']);
                $identitas_split = explode("-", $identitas);
                $identitas1 = $identitas_split[0];
                $identitas2 = $identitas_split[1];
                if ($identitas2 == '') {
                    $identitas2 = 0;
                }
                $barcode = $kodebahan . '#' . $identitas1 . '#' . $identitas2 . '#' . $productid . '#' . $batchnumber . '#' . $nokantong . '#' . $totalkantong . '#' . $sh . '#' . $jenisbahan1 . '#' . $jenisbahan2;
                $Sqrcode = new QrCode($barcode);
                $qrcode = new Output\Svg();
                $show_qrcode = $qrcode->output($Sqrcode);

                $lampiranlabelbahan[] = array(
                    'kodebahan' => $kodebahan,
                    'identitas1' => $identitas1,
                    'identitas2' => $identitas2,
                    'productid' => $productid,
                    'batchlabel' => $batchlabel,
                    'nokantong' => $nokantong,
                    'totalkantong' => $totalkantong,
                    'barcode' => $barcode,
                    'noproses' => 1,
                    'sh' => $sh,
                    'jenisbahan1' => $jenisbahan1,
                    'jenisbahan2' => $jenisbahan2
                );
            }
            $totalscan_proses1 = count($lampiranlabelbahan) - 1;

            for ($i = 0; $i <= $totalscan_proses1; $i++) {
                if ($i <= $totalscan_proses1) {
                    $Sqrcode = new QrCode($lampiranlabelbahan[$i]['barcode']);
                    $qrcode = new Output\Svg();
                    $show_qrcode = $qrcode->output($Sqrcode, 60, 'white', 'black');
                    $output .= "                  
                        <tr>   
                            <td style='width:7.5cm'>   
                                <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                                    <tr style='border: 1px solid black'>
                                        <td rowspan=2 style='border: 1px solid black;text-align:center'><img src='../../../asset/img/smlabel.png' style='width:10rem'></td>
                                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>BAHAN SUDAH DITIMBANG</td>
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan[$i]['jenisbahan1'] .  "</td>
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan[$i]['sh'] . "</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan[$i]['jenisbahan2'] . "</td>
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan[$i]['nokantong'] . "/" . $lampiranlabelbahan[$i]['totalkantong'] . "</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border-left: 1px solid black'>PRODUKSI/PPBBNS</td>
                                        <td>LB-051020-02-00-006</td>
                                        <td>No Rev: 01</td>
                                        <td style='border-right: 1px solid black'>02 Juni 2022</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>Kode Bahan</td>
                                        <td style='border: 1px solid black'>Untuk Produk</td>
                                        <td colspan=2 rowspan=4 style='border: 1px solid black;font-size:0.1pt;font-weight:bold;text-align:center'>" . $show_qrcode . "</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan[$i]['kodebahan'] . "</td>
                                        <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan[$i]['productid'] . "</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>No. Identitas Bahan</td>
                                        <td style='border: 1px solid black'>No Bets KB</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan[$i]['identitas1'] . $lampiranlabelbahan[$i]['identitas2'] . "</td>
                                        <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan[$i]['batchlabel'] . "</td>
                                    </tr>
                                </table>
                            </td>";
                }
                $i += 1;
                if ($i <= $totalscan_proses1) {
                    $Sqrcode = new QrCode($lampiranlabelbahan[$i]['barcode']);
                    $qrcode = new Output\Svg();
                    $show_qrcode = $qrcode->output($Sqrcode, 60, 'white', 'black');
                    $output .= "
                            <td style='width:7.5cm'>   
                                <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                                    <tr style='border: 1px solid black'>
                                        <td rowspan=2 style='border: 1px solid black;text-align:center'><img src='../../../asset/img/smlabel.png' style='width:10rem'></td>
                                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>BAHAN SUDAH DITIMBANG</td>
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan[$i]['jenisbahan1'] . "</td>
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan[$i]['sh'] . "</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan[$i]['jenisbahan2'] . "</td>
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan[$i]['nokantong'] . "/" . $lampiranlabelbahan[$i]['totalkantong'] . "</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border-left: 1px solid black'>PRODUKSI/PPBBNS</td>
                                        <td >LB-051020-02-00-006</td>
                                        <td >No Rev: 01</td>
                                        <td style='border-right: 1px solid black'>02 Juni 2022</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>Kode Bahan</td>
                                        <td style='border: 1px solid black'>Untuk Produk</td>
                                        <td colspan=2 rowspan=4 style='border: 1px solid black;font-size:0.1pt;font-weight:bold;text-align:center'>" . $show_qrcode . "</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan[$i]['kodebahan'] . "</td>
                                        <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan[$i]['productid'] . "</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>No. Identitas Bahan</td>
                                        <td style='border: 1px solid black'>No Bets KB</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan[$i]['identitas1'] . $lampiranlabelbahan[$i]['identitas2'] . "</td>
                                        <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan[$i]['batchlabel'] . "</td>
                                    </tr>
                                </table>
                            </td>              
                        ";
                }
                $i += 1;
                if ($i <= $totalscan_proses1) {
                    $Sqrcode = new QrCode($lampiranlabelbahan[$i]['barcode']);
                    $qrcode = new Output\Svg();
                    $show_qrcode = $qrcode->output($Sqrcode, 60, 'white', 'black');
                    $output .= "
                            <td style='width:7.5cm'>   
                                <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                                    <tr style='border: 1px solid black'>
                                        <td rowspan=2 style='border: 1px solid black;text-align:center'><img src='../../../asset/img/smlabel.png' style='width:10rem'></td>
                                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>BAHAN SUDAH DITIMBANG</td>
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan[$i]['jenisbahan1'] . "</td>
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan[$i]['sh'] . "</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan[$i]['jenisbahan2'] . "</td>
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan[$i]['nokantong'] . "/" . $lampiranlabelbahan[$i]['totalkantong'] . "</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border-left: 1px solid black'>PRODUKSI/PPBBNS</td>
                                        <td >LB-051020-02-00-006</td>
                                        <td >No Rev: 01</td>
                                        <td style='border-right: 1px solid black'>02 Juni 2022</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>Kode Bahan</td>
                                        <td style='border: 1px solid black'>Untuk Produk</td>
                                        <td colspan=2 rowspan=4 style='border: 1px solid black;font-size:0.1pt;font-weight:bold;text-align:center'>" . $show_qrcode . "</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan[$i]['kodebahan'] . "</td>
                                        <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan[$i]['productid'] . "</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>No. Identitas Bahan</td>
                                        <td style='border: 1px solid black'>No Bets KB</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan[$i]['identitas1'] . $lampiranlabelbahan[$i]['identitas2'] . "</td>
                                        <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan[$i]['batchlabel'] . "</td>
                                    </tr>
                                </table>
                            </td>";
                }
                $output .= "</tr>";
            }
            $output .= "
                </table>
                ";
        }
    }
    // ----No Proses 2
    $sql = mysqli_query($conn, "SELECT * FROM tb_detailbahanpengolahan WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND 
                                                                            PlanningNumber='$planningnumber' AND
                                                                            Years='$years' AND
                                                                            ProductID='$productid' AND
                                                                            BatchNumber='$batchnumber' AND
                                                                            NoProses=2");
    if (mysqli_num_rows($sql) <> 0) {
        $output1 = "
            <p class='fw-bold' style='text-align:center;font-size:8pt;font-weight:bold;margin-top:3rem'>PROSES II</p>
            <hr style='margin-bottom:3rem;width:50%'>
            <table style='margin-bottom:1px;font-size:5.4pt' cellpadding=2 cellspacing=0>             
                    ";
        $lampiranlabelbahan2 = array();
        while ($q = mysqli_fetch_array($sql)) {
            $kodebahan = $q['KodeBahan'];
            $batchlabel = $q['BatchLabel'];
            $sh = $q['SH'];
            $jenisbahan1 = $q['JenisBahan1'];
            $jenisbahan2 = $q['JenisBahan2'];
            $query = mysqli_query($conn, "SELECT TotalKantong FROM tb_headerbahanpengolahan  WHERE Plant='$plant' AND 
                                                                                                        UnitCode='$unitcode' AND 
                                                                                                        PlanningNumber='$planningnumber' AND
                                                                                                        Years='$years' AND
                                                                                                        ProductID='$productid' AND
                                                                                                        BatchNumber='$batchnumber' AND
                                                                                                        BatchLabel='$batchlabel' AND
                                                                                                        NoProses=2 AND
                                                                                                        KodeBahan='$kodebahan'");
            $z = mysqli_fetch_array($query);
            $totalkantong = $z['TotalKantong'];
            $nokantong = $q['NoKantong'];
            $identitas = trim($q['NoIdentitas']);
            $identitas_split = explode("-", $identitas);
            $identitas1 = $identitas_split[0];
            $identitas2 = $identitas_split[1];
            if ($identitas2 == '') {
                $identitas2 = 0;
            }
            $barcode = $kodebahan . '#' . $identitas1 . '#' . $identitas2 . '#' . $productid . '#' . $batchnumber . '#' . $nokantong . '#' . $totalkantong . '#' . $sh . '#' . $jenisbahan1 . '#' . $jenisbahan2;
            $lampiranlabelbahan2[] = array(
                'kodebahan' => $kodebahan,
                'identitas1' => $identitas1,
                'identitas2' => $identitas2,
                'productid' => $productid,
                'batchlabel' => $batchlabel,
                'nokantong' => $nokantong,
                'totalkantong' => $totalkantong,
                'barcode' => $barcode,
                'noproses' => 2,
                'sh' => $sh,
                'jenisbahan1' => $jenisbahan1,
                'jenisbahan2' => $jenisbahan2
            );
        }
        $totalscan_proses2 = count($lampiranlabelbahan2);
        for ($i = 0; $i < $totalscan_proses2; $i++) {
            if ($i < $totalscan_proses2) {
                $Sqrcode = new QrCode($lampiranlabelbahan2[$i]['barcode']);
                $qrcode = new Output\Svg();
                $show_qrcode = $qrcode->output($Sqrcode, 60, 'white', 'black');

                $output1 .= "                  
                        <tr>   
                            <td style='width:7.5cm'>   
                                <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                                    <tr style='border: 1px solid black'>
                                        <td rowspan=2 style='border: 1px solid black;text-align:center'><img src='../../../asset/img/smlabel.png' style='width:10rem'></td>
                                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>BAHAN SUDAH DITIMBANG</td>
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan2[$i]['jenisbahan1'] . "</td>
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan2[$i]['sh'] . "</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan2[$i]['jenisbahan2'] . "</td>
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan2[$i]['nokantong'] . "/" . $lampiranlabelbahan2[$i]['totalkantong'] . "</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border-left: 1px solid black'>PRODUKSI/PPBBNS</td>
                                        <td>LB-051020-02-00-006</td>
                                        <td>No Rev: 01</td>
                                        <td style='border-right: 1px solid black'>02 Juni 2022</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>Kode Bahan</td>
                                        <td style='border: 1px solid black'>Untuk Produk</td>
                                        <td colspan=2 rowspan=4 style='border: 1px solid black;font-size:0.1pt;font-weight:bold;text-align:center'>" . $show_qrcode . "</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan2[$i]['kodebahan'] . "</td>
                                        <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan2[$i]['productid'] . "</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>No. Identitas Bahan</td>
                                        <td style='border: 1px solid black'>No Bets KB</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan2[$i]['identitas1'] . $lampiranlabelbahan2[$i]['identitas2'] . "</td>
                                        <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan2[$i]['batchlabel'] . "</td>
                                    </tr>
                                </table>
                            </td>";
            }
            $i += 1;
            if ($i < $totalscan_proses2) {
                $Sqrcode = new QrCode($lampiranlabelbahan2[$i]['barcode']);
                $qrcode = new Output\Svg();
                $show_qrcode = $qrcode->output($Sqrcode, 60, 'white', 'black');
                $output1 .= "
                            <td style='width:7.5cm'>   
                                <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                                    <tr style='border: 1px solid black'>
                                        <td rowspan=2 style='border: 1px solid black;text-align:center'><img src='../../../asset/img/smlabel.png' style='width:10rem'></td>
                                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>BAHAN SUDAH DITIMBANG</td>
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan2[$i]['jenisbahan1'] . "</td>
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan2[$i]['sh'] . "</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan2[$i]['jenisbahan2'] . "</td>
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan2[$i]['nokantong'] . "/" . $lampiranlabelbahan2[$i]['totalkantong'] . "</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border-left: 1px solid black'>PRODUKSI/PPBBNS</td>
                                        <td >LB-051020-02-00-006</td>
                                        <td >No Rev: 01</td>
                                        <td style='border-right: 1px solid black'>02 Juni 2022</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>Kode Bahan</td>
                                        <td style='border: 1px solid black'>Untuk Produk</td>
                                        <td colspan=2 rowspan=4 style='border: 1px solid black;font-size:0.1pt;font-weight:bold;text-align:center'>" . $show_qrcode . "</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan2[$i]['kodebahan'] . "</td>
                                        <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan2[$i]['productid'] . "</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>No. Identitas Bahan</td>
                                        <td style='border: 1px solid black'>No Bets KB</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan2[$i]['identitas1'] . $lampiranlabelbahan2[$i]['identitas2'] . "</td>
                                        <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan2[$i]['batchlabel'] . "</td>
                                    </tr>
                                </table>
                            </td>              
                        ";
            }
            $i = $i + 1;
            if ($i < $totalscan_proses2) {
                $Sqrcode = new QrCode($lampiranlabelbahan2[$i]['barcode']);
                $qrcode = new Output\Svg();
                $show_qrcode = $qrcode->output($Sqrcode, 60, 'white', 'black');
                $output1 .= "
                                <td style='width:7.5cm'>   
                                    <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                                        <tr style='border: 1px solid black'>
                                            <td rowspan=2 style='border: 1px solid black;text-align:center'><img src='../../../asset/img/smlabel.png' style='width:10rem'></td>
                                            <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>BAHAN SUDAH DITIMBANG</td>
                                            <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan2[$i]['jenisbahan1'] . "</td>
                                            <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan2[$i]['sh'] . "</td>
                                        </tr>
                                        <tr style='border: 1px solid black'>
                                            <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan2[$i]['jenisbahan2'] . "</td>
                                            <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan2[$i]['nokantong'] . "/" . $lampiranlabelbahan2[$i]['totalkantong'] . "</td>
                                        </tr>
                                        <tr style='border: 1px solid black'>
                                            <td style='border-left: 1px solid black'>PRODUKSI/PPBBNS</td>
                                            <td >LB-051020-02-00-006</td>
                                            <td >No Rev: 01</td>
                                            <td style='border-right: 1px solid black'>02 Juni 2022</td>
                                        </tr>
                                        <tr style='border: 1px solid black'>
                                            <td style='border: 1px solid black'>Kode Bahan</td>
                                            <td style='border: 1px solid black'>Untuk Produk</td>
                                            <td colspan=2 rowspan=4 style='border: 1px solid black;font-size:0.1pt;font-weight:bold;text-align:center'>" . $show_qrcode . "</td>
                                        </tr>
                                        <tr style='border: 1px solid black'>
                                            <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan2[$i]['kodebahan'] . "</td>
                                            <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan2[$i]['productid'] . "</td>
                                        </tr>
                                        <tr style='border: 1px solid black'>
                                            <td style='border: 1px solid black'>No. Identitas Bahan</td>
                                            <td style='border: 1px solid black'>No Bets KB</td>
                                        </tr>
                                        <tr style='border: 1px solid black'>
                                            <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan2[$i]['identitas1'] . $lampiranlabelbahan2[$i]['identitas2'] . "</td>
                                            <td style='border: 1px solid black;font-weight:bold'>" . $lampiranlabelbahan2[$i]['batchlabel'] . "</td>
                                        </tr>
                                    </table>
                                </td>";
            }
            $output1 .= "</tr>";
        }
        $output1 .= "
                </table>
                ";
    }
    $output .= "
                    </div>
                </body>
                ";
}


$mpdf = new \Mpdf\Mpdf();
// left,right,top,bottom.
$mpdf->AddPage('P', '', '', '', '', 5, 5, 5, 5, 10, 10);
$mpdf->WriteHTML($output);
if ($output1 <> '') {
    $mpdf->AddPage('P', '', '', '', '', 5, 5, 5, 5, 10, 10);
    $mpdf->WriteHTML($output1);
}

$mpdf->SetTitle('Laporan Data Pengolahan');
$mpdf->Output($filename, 'I');
