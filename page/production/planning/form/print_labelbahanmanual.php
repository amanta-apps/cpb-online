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
$produkid = $x[0];
$kodebahan = $x[1];
$betsbahan = strtoupper($x[2]);
$noident1 = strtoupper($x[3]);
$noident2 = strtoupper($x[4]);
$nokantong = $x[5];
$totalkantong = $x[6];
$reason = $x[7];
$sh = '-';
$jenisbahan1 = '-';
$jenisbahan2 = '-';
// $filename = $plant . $unitcode . '_' . $planningnumber . '_' . $years . '_' . $batch . '_' . $noproses . '.' . $notong . '.pdf';
$prod_desc = Getdata("ProductDescriptions", "mara_product", "ProductID", $produkid);

$barcode = $kodebahan . '#' . $noident1 . '#' . $noident2 . '#' . $produkid . '#' . $betsbahan . '#' . $nokantong . '#' . $totalkantong . '#' . $sh . '#' . $jenisbahan1 . '#' . $jenisbahan2;
$Sqrcode = new QrCode($barcode);
$qrcode = new Output\Svg();
$show_qrcode = $qrcode->output($Sqrcode);

$output = "
    <!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body>
        <table style='margin-bottom:1px;font-size:4.5pt !important' cellpadding=2 cellspacing=0>              
            <tr>   
                <td style='width:7.5cm'>   
                    <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                        <tr style='border: 1px solid black'>
                            <td rowspan=2 style='border: 1px solid black;text-align:center'><img src='../../../../asset/img/smlabel.png' style='width:10rem'></td>
                            <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>LABEL MANUAL</td>
                            <td style='border: 1px solid black;text-align:center'>" . $jenisbahan1 . "</td>
                            <td style='border: 1px solid black;text-align:center'>" . $sh . "</td>
                        </tr>
                        <tr style='border: 1px solid black'>
                            <td style='border: 1px solid black;text-align:center'>" . $jenisbahan2 . "</td>
                            <td style='border: 1px solid black;text-align:center'>" . $nokantong . "/" . $totalkantong . "</td>
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
                            <td style='border: 1px solid black;font-weight:bold'>" . $kodebahan . "</td>
                            <td style='border: 1px solid black;font-weight:bold'>" . $produkid . "</td>
                        </tr>
                        <tr style='border: 1px solid black'>
                            <td style='border: 1px solid black'>No. Identitas Bahan</td>
                            <td style='border: 1px solid black'>No Bets KB</td>
                        </tr>
                        <tr style='border: 1px solid black'>
                            <td style='border: 1px solid black;font-weight:bold'>" . $noident1 . $noident2 . "</td>
                            <td style='border: 1px solid black;font-weight:bold'>" . $betsbahan . "</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>";
// $mpdf = new \Mpdf\Mpdf();
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [100, 55]]);
// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [147, 90]]);
// left,right,top,bottom.
$mpdf->AddPage('P', '', '', '', '', 2, 2, 2, 2, 10, 10);

$mpdf->WriteHTML($output);
$mpdf->SetTitle('Print Label');

// if ($act == 1) {
$mpdf->Output($filename, 'I');
// $mpdf->Output("\\19.0.2.244\cpb-online" . $filename, \Mpdf\Output\Destination::FILE);
// $mpdf->OutputFile(__DIR__ . '/' . $filename);
