<?php
// include '../../../../function/koneksi.php';
include '../../../../function/getdata.php';
// include '../../../../function/getvalue.php';
require_once __DIR__ . '/../../../../asset/vendor/autoload.php';
require_once __DIR__ . '/../../../../asset/vendor_qrcode/autoload.php';

use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

loguser('Show Report CPB');
$plant = $_SESSION['plant'];
$unitcode = $_SESSION['unitcode'];
$var = $_GET['x'];
$x = explode('*', $var);
$planningnumber = $x[0];
$years = $x[1];
$productid = $x[2];
$batch = $x[3];
$noproses = $x[4];
$filename = $plant . $unitcode . '_' . $planningnumber . '_' . $years . '_' . $batch . '.pdf';
$prod_desc = Getdata("ProductDescriptions", "mara_product", "ProductID", $productid);
$Y = date('Y');
$createdon = date("Y-m-d H:i:s");
$createdby = $_SESSION['userid'];

//  ---------------- SET No Pallet
$query = mysqli_query($conn, "SELECT * FROM tbl_paletmixer WHERE Plant='$plant' AND
                                                                UnitCode='$unitcode' AND
                                                                -- NoPallet='$nopallet' 
                                                                -- AND
                                                                PlanningNumber='$planningnumber' AND
                                                                Years='$years' AND
                                                                NoProses='$noproses' AND
                                                                ProductID='$productid' AND
                                                                BatchNumber='$batch'
                                                                ");
if (mysqli_num_rows($query) == 0) {
    // ------> Get No Pallet
    $sql = mysqli_query($conn, "SELECT Current, Too FROM nriv WHERE NumberRangeType='pallet' AND Years='$Y' ORDER BY Current DESC");
    $q = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) <> 0) {
        $nopallet = $q['Current'] + 1;
        $maxkode = $q['Too'];
        // -----> Cek Overload Number
        if ($nopallet > $maxkode) {
            die;
        }
    } else {
        $sql = mysqli_query($conn, "SELECT Fromm FROM nriv WHERE NumberRangeType='pallet'");
        $q = mysqli_fetch_array($sql);
        if (mysqli_num_rows($sql) <> 0) {
            $nopallet = $q['Fromm'];
        }
        // die;
    }
    mysqli_query($conn, "UPDATE nriv SET Current='$nopallet',Years='$Y' WHERE NumberRangeType='pallet'");
    // ------> End
    if ($noproses == 'all') {
        for ($i = 1; $i <= 2; $i++) {
            mysqli_query($conn, "INSERT INTO tbl_paletmixer (Plant,
                                                            UnitCode,
                                                            NoPallet,
                                                            PlanningNumber,
                                                            Years,
                                                            NoProses,
                                                            ProductID,
                                                            BatchNumber,
                                                            CreatedOn,
                                                            CreatedBy)
                                VALUES('$plant',
                                '$unitcode',
                                '$nopallet',
                                '$planningnumber',
                                '$years',
                                '$i',
                                '$productid',
                                '$batch',
                                '$createdon',
                                '$createdby'
                                )");
        }
    } else {
        mysqli_query($conn, "INSERT INTO tbl_paletmixer (Plant,
                                                    UnitCode,
                                                    NoPallet,
                                                    PlanningNumber,
                                                    Years,
                                                    NoProses,
                                                    ProductID,
                                                    BatchNumber,
                                                    CreatedOn,
                                                    CreatedBy)
                        VALUES('$plant',
                                '$unitcode',
                                '$nopallet',
                                '$planningnumber',
                                '$years',
                                '$noproses',
                                '$productid',
                                '$batch',
                                '$createdon',
                                '$createdby')");
    }
}

// -------END


if ($noproses <> 'all') {

    $sql = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_header WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                        AND PlanningNumber='$planningnumber'
                                                                                        AND Years='$years'
                                                                                        AND ProductID='$productid'");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $ed = $r['ExpiredDate'];
        $op1 = Getdata('EmployeeName', 'pa001', 'PersonnelNumber', $r['Operator1']);
        $operator1 = explode(" ",  Getdata('EmployeeName', 'pa001', 'PersonnelNumber', $r['Operator1']));
        $operator2 = explode(" ",  Getdata('EmployeeName', 'pa001', 'PersonnelNumber', $r['Operator2']));
        $tgl_dry = date('d/m/Y', strtotime($r['MixingDate']));
        $nomesin = $r['ResourceIDMix'];

        $query = mysqli_query($conn, "SELECT * FROM insp_pengolahan_header WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                        AND PlanningNumber='$planningnumber'
                                                                                        AND Years='$years'
                                                                                        -- AND Items='$r[Items]'
                                                                                        AND ProductID='$productid'
                                                                                        AND BatchNumber='$batch'
                                                                                        AND NoProses='$noproses'
                                                                                        -- AND StatsX ='X'
                                                                                        ");
        if (mysqli_num_rows($query) <> 0) {
            $r = mysqli_fetch_array($query);
            $insp_lot = $r['InspectionLot'];
            $insp_years = $r['Lotyears'];
        }
        $query = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                        AND PlanningNumber='$r[PlanningNumber]'
                                                                                        AND Years='$r[Years]'
                                                                                        AND Items='$r[Items]'
                                                                                        AND ProductID='$r[ProductID]'
                                                                                        AND BatchNumber='$batch'
                                                                                        AND NoProses='$noproses'");
        if (mysqli_num_rows($query) <> 0) {
            $row = mysqli_fetch_array($query);
            // $uom = $row['Satuan'];
            $berat = $row['Berat'];
            // $noproses = $row['NoProses'];
            $batch = $row['BatchNumber'];
            $ed_batch = date('M y', strtotime($ed)) . ' / ' . $batch;
        }
    }
    $nopallet = GetdataVII('NoPallet', 'tbl_paletmixer', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $planningnumber, 'Years', $years, 'NoProses', $noproses, 'ProductID', $productid, 'BatchNumber', $batch);


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
        <table style="border: 1px solid black" cellpadding=2>
            <tr>
                <td style="width:30%;border: 1px solid black"><center><img src="../../../../asset/img/sidomuncul.png" style="width:30%"></center></td>
                <td rowspan=3 style="width:40%;text-align:center;font-weight:bold;font-size: 12pt;border: 1px solid black">LABEL HASIL PENGOLAHAN</td>
                <td style="width:10%;">No Form</td>
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
                <td style="border: 1px solid black;font-weight:bold"> ' . $prod_desc . '</td>
                <td style="border: 1px solid black">ED/BC</td>
                <td colspan=3 style="border: 1px solid black;font-weight:bold" colspan=3>ED.' . date('M y', strtotime($ed)) . ' / ' . $batch . '</td>
            </tr>
            <tr style="border: 1px solid black">
                <td style="border: 1px solid black">Nama/No. Mesin</td>
                <td style="border: 1px solid black">' . $nomesin . '</td>
                <td style="border: 1px solid black">Jumlah resep</td>
                <td style="border: 1px solid black;text-align:center">2</td>
                <td style="border: 1px solid black" rowspan2>Nama Operator</td>
                <td style="border: 1px solid black">' . $operator1[0] . '</td>
            </tr>
            <tr style="border: 1px solid black">
                <td style="border: 1px solid black">Tanggal Proses</td>
                <td style="border: 1px solid black">' . $tgl_dry . '</td>
                <td style="border: 1px solid black">Jumlah Tong</td>
                <td style="border: 1px solid black;text-align:center">14</td>
                <td style="border: 1px solid black">Timbang</td>
                <td style="border: 1px solid black">' . $operator1[0] . '</td>
            </tr>
        </table>
        <table style="border: 1px solid black">
            <tr  style="border: 1px solid black">
                <td style="border: 1px solid black;vertical-align: top">
                    <table style="border: 1px solid black">
                        <tr>
                            <td style="border: 1px solid black;text-align:center;font-weight:bold">Nomor Proses</td>
                            <td style="border: 1px solid black;text-align:center;font-weight:bold">Nomor Tong</td>
                            <td style="border: 1px solid black;text-align:center;font-weight:bold">Jumlah Berat</td>
                        </tr>';
    $totalberat = 0;
    $query = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                         PlanningNumber='$planningnumber' AND 
                                                                         Years='$years' AND 
                                                                         ProductID='$productid' AND
                                                                         BatchNumber='$batch'AND 
                                                                         NoProses='$noproses'
                                                                         ");
    $count = mysqli_num_rows($query);
    while ($r = mysqli_fetch_array($query)) {
        $totalberat = $totalberat + $r["Berat"];
        $satuan = $r['Satuan'];
        if ($r['NoProses'] == $noproses) {

            $output .= '
                        <tr style="border: 1px solid black">
                            <td style="border: 1px solid black;text-align:center">' . $r["NoProses"] . '</td>
                            <td style="border: 1px solid black;text-align:center">' . $r["NoTong"] . '</td>
                            <td style="border: 1px solid black;text-align:center">' . $r["Berat"] . ' ' . $r['Satuan'] . '</td>
                        </tr>';
        }
    }
    for ($i = 0; $i < $count; $i++) {
        $output .= '
                        <tr style="border: 1px solid black">
                            <td style="border: 1px solid black;text-align:center">&nbsp;</td>
                            <td style="border: 1px solid black;text-align:center">&nbsp;</td>
                            <td style="border: 1px solid black;text-align:center">&nbsp;</td>
                        </tr>';
    }

    $Sqrcode = new QrCode($plant . ',' . $unitcode . ',' . $planningnumber . ',' . $years . ',' . $productid . ',' . $batch . ',' . $totalberat . ',' . $satuan . ',' . $insp_lot . ',' . $insp_years . ',' . $nopallet . ',' . $noproses);
    $qrcode = new Output\Svg();
    $show_qrcode = $qrcode->output($Sqrcode, 150, 'white', 'black');
    $output .= '
                    </table>
                </td>
                <td style="vertical-align: top">
                    <table style="border: 1px solid black;border-bottom:none">
                        <tr>
                            <td rowspan=2 style="vertical-align: top;border: 1px solid black;text-align:center;font-weight:bold;vertical-align:middle">Jam Kirim</td>
                            <td colspan=2 style="vertical-align: top;border: 1px solid black;text-align:center;font-weight:bold">Paraf</td>
                        </tr>
                        <tr style="border: 1px solid black">
                            <td style="border: 1px solid black;text-align:center;font-weight:bold">Pengirim</td>
                            <td style="border: 1px solid black;text-align:center;font-weight:bold">Penerima</td>
                        </tr>
                        <tr style="border: 1px solid black">
                            <td style="border: 1px solid black;text-align:center;font-weight:bold">&nbsp;</td>
                            <td style="border: 1px solid black;text-align:center;font-weight:bold">&nbsp;</td>
                            <td style="border: 1px solid black;text-align:center;font-weight:bold">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;font-weight:bold;border: 1px solid black">No Pallet</td>
                            <td colspan=2 style="text-align:center;font-weight:bold">Total Berat</td>
                        </tr>
                        <tr style="border: 1px solid black">
                            <td style="border: 1px solid black;text-align:center;font-weight:bold;font-size:16pt">' . $nopallet . '</td>
                            <td colspan=2 style="border: 1px solid black;text-align:center;font-weight:bold;font-size:16pt">' . $totalberat . ' Kg</td>
                        </tr>
                        <tr style="border-top: 1px solid black;border-bottom:none !important">
                            <td colspan=3 style="border: 1px solid black;font-size:0.1pt;text-align:center;border-bottom:none !important;padding-top:1000px !important">' . $show_qrcode . '</td>
                        </tr>
                        
                    </table>
                </td>
            </tr>
        </table>    
            
    </container>
    </body>
    </html>';
}



// $mpdf = new \Mpdf\Mpdf();
// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Legal']);
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [210, 297]]);
// left,right,top,bottom.
$mpdf->AddPage('P', '', '', '', '', 5, 5, 5, 5, 10, 10);
$mpdf->WriteHTML($output);
$mpdf->SetTitle('Print Label');
$mpdf->Output($filename, 'I');
