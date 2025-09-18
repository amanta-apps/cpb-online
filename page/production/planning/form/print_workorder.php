<?php
include '../../../../function/koneksi.php';
require '../../../../function/getdata.php';
require_once '../../../../function/getvalue.php';
require_once __DIR__ . '/../../../../asset/vendor/autoload.php';
// ob_get_clean();
$planningnumber = str_replace("'", "", $_GET['n']);
$years = $_GET['y'];
$plant = $_SESSION['plant'];
$unitcode = $_SESSION['unitcode'];
$filename = 'Work Order ' . $planningnumber . '.pdf';

$sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND
                                                                UnitCode='$unitcode' AND
                                                                PlanningNumber='$planningnumber' AND
                                                                Years='$years'");
$row = mysqli_fetch_array($sql);

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
            font-size: 6pt !important;
            
            }

            table{
                width: 100%;
                /* border: 1px solid black; */
                font-size: 6pt !important;
                table-layout: fixed !important;
                border-collapse: collapse;
            }
        </style>
    </head>";
$output .= "
    <body>
        <div class='container'>
            <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%'><center><img src='../../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                        <td style='border: 1px solid black; text-align:center;font-weight: bold' rowspan=3>LAPORAN KERJA OPERATOR MESIN PENGEMASAN PRIMER <br> MESIN ROTARY FILL & SEAL</td>
                        <td>No Form</td>
                        <td>: FM-053050-01-02-032</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center'>PRODUKSI</td>
                        <td>Revisi</td>
                        <td>: 00</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center'>SERBUK INSTAN & <br> SEDIA PANGAN</td>
                        <td>Tanggal Berlaku</td>
                        <td>: 12 December 2022</td>
                    </tr>
                </tbody>
            </table> ";
$output .= "
    <body>
        <div class='container'>
            <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black; width: 20%'>Tanggal Pengemasan</td>
                        <td style='border: 1px solid black'>" . date('d.m.Y', strtotime($row['PackingDate'])) . "</td>
                        <td rowspan=2 style='border: 1px solid black; text-align: center'>Nama Operator</td>
                        <td style='border: 1px solid black'>1.</td>
                        <td rowspan=2 style='border: 1px solid black; text-align: center'>Shift</td>
                        <td rowspan=2 style='text-align: center'>" . $row['ShiftID'] . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Nama/No Mesin</td>
                        <td style='border: 1px solid black'>" . $row['ResourceID'] . "</td>
                        <td style='border: 1px solid black'>2.</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black; text-align: center; font-weight:bold' colspan=6>RENCANA PRODUKSI</td>
                    </tr>
                </tbody>
            </table> ";
$output .= "
    <body>
        <div class='container'>
            <table style='border: 1px solid black; width:100%; margin-bottom:1px;' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black; border-bottom: none !important'>
                        <td rowspan=2 style='border: 1px solid black; text-align: center'>Produk/Jenis</td>
                        <td style='border: 1px solid black; text-align: center'>Tgl</td>
                        <td rowspan=2 style='border: 1px solid black; text-align: center'>ED/No Bets</td>
                        <td style='border: 1px solid black; text-align: center'>Berat</td>
                        <td style='border: 1px solid black; text-align: center'>No Mesin</td>
                        <td rowspan=2 style='border: 1px solid black; text-align: center'>No Proses</td>
                        <td style='border: 1px solid black; text-align: center'>Jumlah Sachet</td>
                        <td style='border: 1px solid black; text-align: center'>Paraf 1</td>
                        <td>Paraf 2</td>
                    </tr>
                    <tr>
                        <td style='border: 1px solid black; text-align: center'>PCM</td>
                        <td style='border: 1px solid black; text-align: center'>(Kg)</td>
                        <td style='border: 1px solid black; text-align: center; text-align: center'>Mixing</td>
                        <td style='border: 1px solid black; text-align: center'>(Jika ada)</td>
                        <td style='border: 1px solid black; text-align: center'>PP1</td>
                        <td style='text-align: center'>PP2</td>
                    </tr>
                    <tr style='border: 1px solid black; border-bottom: none !important'>
                        <td style='border: 1px solid black; text-align: center'>" . $row['ProductID'] . "</td>
                        <td style='border: 1px solid black; text-align: center'>" . date('d/m', strtotime($row['MixingDate'])) . "</td>
                        <td style='border: 1px solid black; text-align: center'>ED." . date('M y', strtotime($row['ExpiredDate'])) . "/" . $row['BatchNumber'] . "</td>
                        <td style='border: 1px solid black; text-align: center'></td>
                        <td style='border: 1px solid black; text-align: center'>" . $row['ResourceIDMix'] . "</td>
                        <td style='border: 1px solid black; text-align: center'>" . $row['ProcessNumber'] . "</td>
                        <td style='border: 1px solid black; text-align: center'>" . $row['Quantity'] . "</td>
                        <td style='border: 1px solid black; text-align: center'>" . Getdata('EmployeeName', 'pa001', 'CreatedBy', $_SESSION['userid']) . "</td>
                        <td></td>
                    </tr>
                    <tr style='border: 1px solid black;'>
                        <td colspan=9 style='border: 1px solid black; text-align: center; font-weight:bold'>HASIL PRODUKSI</td>
                    </tr>
                </tbody>
            </table> ";
$output .= "
    <body>
        <div class='container'>
            <table style='border: 1px solid black; width:100%; margin-bottom:1px;' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black; border-bottom: none !important'>
                        <td rowspan=2 style='border: 1px solid black; text-align: center'>Produk/Jenis</td>
                        <td rowspan=2 style='border: 1px solid black; text-align: center'>Tgl <br> Pcm</td>
                        <td rowspan=2 style='border: 1px solid black; text-align: center'>No Proses</td>
                        <td rowspan=2 style='border: 1px solid black; text-align: center'>Hasil Counter (A) <br> Sachet</td>
                        <td rowspan=2 style='border: 1px solid black; text-align: center'>Pemakaian <br> Litho</td>
                        <td colspan=2 style='border: 1px solid black; text-align: center'>Jam</td>
                        <td colspan=2 style='border: 1px solid black; text-align: center'>Sampah Kemasan</td>
                        <td colspan=4 style='border: 1px solid black; text-align: center'>Down Time Mesin</td>
                    </tr>
                    <tr style='border: 1px solid black;'>
                        <td style='border: 1px solid black; text-align: center'>Mulai</td>
                        <td style='border: 1px solid black; text-align: center'>Selesai</td>
                        <td style='border: 1px solid black; text-align: center'>Kg</td>
                        <td style='border: 1px solid black; text-align: center'>Sachet</td>
                        <td style='border: 1px solid black; text-align: center'>Waktu</td>
                        <td style='border: 1px solid black; text-align: center'>Permasalahan</td>
                        <td colspan=2 style='border: 1px solid black; text-align: center'>Perbaikan</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black; text-align: center'>" . $row['ProductID'] . "</td>
                        <td style='border: 1px solid black; text-align: center'>" . date('d/m', strtotime($row['MixingDate'])) . "</td>
                        <td style='border: 1px solid black; text-align: center'>" . $row['ProcessNumber'] . "</td>
                        <td style='border: 1px solid black; text-align: center'></td>
                        <td style='border: 1px solid black; text-align: center'></td>
                        <td style='border: 1px solid black; text-align: center'></td>
                        <td style='border: 1px solid black; text-align: center'></td>
                        <td style='border: 1px solid black; text-align: center'></td>
                        <td style='border: 1px solid black; text-align: center'></td>
                        <td style='border: 1px solid black; text-align: center'></td>
                        <td style='border: 1px solid black; text-align: center'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td rowspan=2 style='border: 1px solid black'>Hasil mesin VFS <br> G= A-B-C-D</td>
                        <td colspan=2 style='border: 1px solid black'>(B) Test kebocoran</td>
                        <td style='border: 1px solid black; text-align: center'></td>
                        <td colspan=3 style='border: 1px solid black'>(F) Karantina</td>
                        <td colspan=2 style='border: 1px solid black; text-align: center'></td>
                        <td colspan=2 style='border: 1px solid black'>KV.........................Kg</td>
                        <td rowspan=2 style='border: 1px solid black; text-align: center'>Paraf <br> Adm</td>
                        <td rowspan=2 style='border: 1px solid black; text-align: center'>Paraf <br> Spv</td>
                    </tr>
                    <tr style='border: 1px solid black; border-bottom: none !important'>
                        <td colspan=2 style='border: 1px solid black'>(C) Retained sample</td>
                        <td style='border: 1px solid black; text-align: center'></td>
                        <td colspan=3 style='border: 1px solid black'>Pemakaian litho</td>
                        <td colspan=2 style='border: 1px solid black'>Roll</td>
                        <td colspan=2 style='border: 1px solid black'>TK.........................Kg</td>
                    </tr>

                    <tr style='border: 1px solid black; border-bottom: none !important'>
                        <td rowspan=2 style='border: 1px solid black'>Hasil mesin RFS <br> G= A-B-C-E</td>
                        <td colspan=2 style='border: 1px solid black'>(E) Sisa potongan mesin</td>
                        <td style='border: 1px solid black; text-align: center'></td>
                        <td colspan=3 style='border: 1px solid black'>Waste</td>
                        <td colspan=2 style='border: 1px solid black'>Kg</td>
                        <td colspan=2 style='border: 1px solid black'>DC.........................Kg</td>
                        <td rowspan=2 style='border: 1px solid black'></td>
                        <td rowspan=2 style='border: 1px solid black'></td>
                    </tr>
                    <tr style='border: 1px solid black; border-bottom: none !important'>
                        <td colspan=2 style='border: 1px solid black;'>(C) Hasil sachet</td>
                        <td style='border: 1px solid black; text-align: center'></td>
                        <td colspan=3 style='border: 1px solid black'>Sisa hasil cekrik</td>
                        <td colspan=2 style='border: 1px solid black'>Kg</td>
                        <td colspan=2 style='border: 1px solid black'>SL.........................Kg</td>
                    </tr>
                </tbody>
            </table> ";

// $mpdf = new \Mpdf\Mpdf();
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A5-P']);
// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [147, 90]]);
// left,right,top,bottom.
$mpdf->AddPage('P', '', '', '', '', 5, 5, 5, 5, 10, 10);

$mpdf->WriteHTML($output);
$mpdf->SetTitle('Work Order');
// if ($act == 1) {
$mpdf->Output($filename, 'I');
// } else {
//     $mpdf->Output($filename, 'I');
// }
