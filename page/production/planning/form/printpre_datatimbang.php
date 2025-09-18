<?php
include '../../../../function/koneksi.php';
include '../../../../function/getdata.php';
include_once '../../../../function/getvalue.php';
require_once __DIR__ . '/../../../../asset/vendor/autoload.php';
require_once __DIR__ . '/../../../../asset/vendor_qrcode/autoload.php';

use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

// echo $qrcode->output($Sqrcode, 100, 'white', 'black'); 
// ob_get_clean();
session_start();
error_reporting(0);
$plant = $_SESSION['plant'];
$unitcode = $_SESSION['unitcode'];
$var = $_GET['x'];
$x = explode('*', $var);
$planningnumber = $x[0];
$years = $x[1];
$item = $x[2];
$productid = $x[3];
$batch = $x[4];
$noproses = $x[5];
$notong = $x[6];
$qty = $x[7];
$filename = $plant . $unitcode . '_' . $planningnumber . '_' . $years . '_' . $batch . '_' . $noproses . '.' . $notong . '.pdf';
$prod_desc = Getdata("ProductDescriptions", "mara_product", "ProductID", $productid);

$sql = mysqli_query($conn, "SELECT * FROM insp_pengolahan_header WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                        AND PlanningNumber='$planningnumber'
                                                                                        AND Years='$years'
                                                                                        AND ProductID='$productid'
                                                                                        AND BatchNumber='$batch'");
if (mysqli_num_rows($sql) != 0) {
    $r = mysqli_fetch_array($sql);
    $inspectionlot = $r['InspectionLot'];
    $inpsyear = $r['Lotyears'];
}

$Sqrcode = new QrCode($plant . ',' . $unitcode . ',' . $planningnumber . ',' . $years . ',' . $item . ',' . $productid . ',' . $batch . ',' . $noproses . ',' . $notong . ',' . $qty . ',' . $inspectionlot . ',' . $inpsyear);
$qrcode = new Output\Svg();
$show_qrcode = $qrcode->output($Sqrcode, 87, 'white', 'black');

$sql = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_header WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                        AND PlanningNumber='$planningnumber'
                                                                                        AND Years='$years'
                                                                                        AND Items='$item'
                                                                                        AND ProductID='$productid'");
if (mysqli_num_rows($sql) != 0) {
    $r = mysqli_fetch_array($sql);
    $ed = $r['ExpiredDate'];
    $operator1 = Getdata('EmployeeName', 'pa001', 'PersonnelNumber', $r['Operator1']);
    $operator2 = Getdata('EmployeeName', 'pa001', 'PersonnelNumber', $r['Operator2']);
    $tgl_dry = date('d/m/Y', strtotime($r['MixingDate']));
    $nomesin = $r['ResourceIDMix'];
    $query = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                        AND PlanningNumber='$r[PlanningNumber]'
                                                                                        AND Years='$r[Years]'
                                                                                        AND Items='$r[Items]'
                                                                                        AND ProductID='$r[ProductID]'
                                                                                        AND BatchNumber='$batch'
                                                                                        AND NoProses='$noproses'
                                                                                        AND NoTong='$notong'");
    if (mysqli_num_rows($query) != 0) {
        $row = mysqli_fetch_array($query);
        $uom = $row['Satuan'];
        $berat = $row['Berat'];
        $noproses = $row['NoProses'];
        $batch = $row['BatchNumber'];
        $ed_batch = date('M y', strtotime($ed)) . ' / ' . $batch;
    }
}


$output = "
    <!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='../../../../asset/css/bootstrap.min.css' rel='stylesheet'>
        <style>
            body,
            html
            {
            font-family: Arial, Helvetica, sans-serif !important;
            font-size: 10pt !important;
            
            }

            table{
                font-family: Arial, Helvetica, sans-serif !important;
                width: 100%;
                font-size: 8.5pt;
                border-collapse: collapse;
            }
        </style>
    </head>
    <body>";
$output .= '
    <div class="container">
        <table style="border: 1px solid black">
            <tr>
                <td style="width:30%;border: 1px solid black"><center><img src="../../../../asset/img/sidomuncul.png" style="width:30%"></center></td>
                <td rowspan=3 style="width:40%;text-align:center;font-weight:bold;font-size: 12pt;border: 1px solid black">LABEL <br> HASIL PROSES <br> DRY MIXED</td>
                <td style="width:15%;">No Form</td>
                <td>:FM-053050-01-00-011</td>
            </tr>
            <tr style="border: 1px solid black">
                <td style="text-align:center;font-weight:bold">PRODUKSI</td>
                <td>Revisi</td>
                <td>:02</td>
            </tr>
            <tr style="border: 1px solid black">
                <td style="border: 1px solid black;text-align:center;font-weight:bold">SERBUK INSTAN & SEDIAAN PANGAN</td>
                <td>Tgl Berlaku</td>
                <td>:17 Juni 2019</td>
            </tr>
        </table>
        <table style="border: 1px solid black">
            <tr style="border: 1px solid black">
                <td style="width:25%;border: 1px solid black">Produk</td>
                <td colspan=3 style="border: 1px solid black;font-weight:bold;font-size:12pt"> ' . $prod_desc . '</td>
            </tr>
            <tr style="border: 1px solid black">
                <td style="width:25%;border: 1px solid black">ED/No Bets</td>
                <td colspan=3 style="border: 1px solid black">ED ' . $ed_batch . '</td>
            </tr>
            <tr style="border: 1px solid black">
                <td style="width:25%;border: 1px solid black">Tgl. Dry Mixed</td>
                <td colspan=3 style="border: 1px solid black">' . $tgl_dry . '</td>
            </tr>
            <tr style="border: 1px solid black">
                <td style="width:25%;border: 1px solid black">No Wadah</td>
                <td style="border: 1px solid black">' . $notong . ' dari 7</td>
                <td rowspan=3 style="border: 1px solid black">Berat/Wadah</td>
                <td rowspan=3 style="border: 1px solid black;text-align:center;font-weight:bold">' . $berat . '' . $uom . '</td>
            </tr>
            <tr style="border: 1px solid black">
                <td style="width:30%;border: 1px solid black">No Proses</td>
                <td style="border: 1px solid black">' . $noproses . '</td>
            </tr>
            <tr style="border: 1px solid black">
                <td style="width:30%;border: 1px solid black">No. Msn DM</td>
                <td style="border: 1px solid black">' . $nomesin . '</td>
            </tr>
            <tr style="border: 1px solid black">
                <td style="width:30%;border: 1px solid black">Operator I & II</td>
                <td colspan=3 style="border: 1px solid black">' . $operator1 . ' & ' . $operator2 . '</td>
            </tr>
            <tr style="border: 1px solid black">
                <td colspan=4 style="border: 1px solid black;font-size:0.1pt;text-align:right">' . $show_qrcode . '</td>
            </tr>
        </table>      
    </container>
    </body>
    </html>';
// $mpdf = new \Mpdf\Mpdf();
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [100, 80]]);
// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [147, 90]]);
// left,right,top,bottom.
$mpdf->AddPage('P', '', '', '', '', 2, 2, 2, 2, 10, 10);

$mpdf->WriteHTML($output);
$mpdf->SetTitle('Print Label');

// if ($act == 1) {
$mpdf->Output($filename, 'I');
// $mpdf->Output("\\19.0.2.244\cpb-online" . $filename, \Mpdf\Output\Destination::FILE);
// $mpdf->OutputFile(__DIR__ . '/' . $filename);
