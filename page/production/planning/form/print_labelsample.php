<?php
include '../../../../function/koneksi.php';
require '../../../../function/getdata.php';
require_once '../../../../function/getvalue.php';
require_once __DIR__ . '/../../../../asset/vendor/autoload.php';

$plant = $_SESSION['plant'];
$unitcode = $_SESSION['unitcode'];
// $plant = 'SM';
// $unitcode = 'S001';
$planningnumber = $_GET['w'];
$years = $_GET['x'];
$ilot = $_GET['y'];
$iyears = $_GET['z'];
// $planningnumber = '2000000000';
// $years = '2024';
if ($ilot != 0 && $iyears != 0) {
    $query = mysqli_query($conn, "SELECT * FROM insp_pengolahan_header WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        InspectionLot  ='$ilot' AND
                                                                        Lotyears ='$iyears'");
}
if ($planningnumber != 0 && $years != 0) {
    $query = mysqli_query($conn, "SELECT * FROM insp_pengolahan_header WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber ='$planningnumber' AND
                                                                        Years='$years'");
}

$output = '
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="../../../../asset/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <table>';
while ($q = mysqli_fetch_array($query)) {
    $sql = mysqli_query($conn, "SELECT * FROM planning_pengolahan_detail WHERE Plant='$plant' AND UnitCode='$unitcode' AND PlanningNumber ='$q[PlanningNumber]' AND Years='$q[Years]'");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $items = $r['Items'];
        $productid = $r['ProductID'];
        $prod_desc = Getdata("ProductDescriptions", "mara_product", "ProductID", $productid);
        $batch  = $r['BatchNumber'];
        $ed = $r['ExpiredDate'];
        $nomesin = $r['ResourceIDMix'];
        $mixingdate = $r['MixingDate'];
        $jumlahresep = $r['JumlahResep'];
        $createdon = $r['CreatedOn'];
        $createdby = $r['CreatedBy'];
    }
    $ed_batch = date('M y', strtotime($ed)) . ' / ' . $q["BatchNumber"];
    $output .= '
                <tr>
                    <td style="padding-right:100px !important">
                        <table class="table table-sm mb-0" style="border: 1px solid black;font-size:7pt;width:400px">
                            <tr>
                                <td style=" border: 1px solid black">
                                    <center><img src="../../../../asset/img/sidomuncul.png" style="width:5%"></center>
                                </td>
                                <td rowspan=3 style="text-align:center;font-weight:bold;border: 1px solid black;width:100px">LABEL <br> HASIL PROSES <br> DRY MIXED</td>
                                <td>No Form</td>
                                <td style="width:50px">:FM-053050-01-00-011</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="text-align:center;font-weight:bold">PRODUKSI</td>
                                <td>Revisi</td>
                                <td>:02</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black;text-align:center;font-weight:bold">SERB. INS. & SED. PANGAN</td>
                                <td>Tgl Berlaku</td>
                                <td>:17 Juni 2019</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Produk</td>
                                <td colspan="3" style="border: 1px solid black;font-weight:bold;font-size:10pt"> ' . $prod_desc . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">ED/No Bets</td>
                                <td colspan="3" style="border: 1px solid black">ED ' . $ed_batch . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Tgl. Dry Mixed</td>
                                <td style="border: 1px solid black">' . $mixingdate . '</td>
                                <td rowspan=2 style="border: 1px solid black">No Proses</td>
                                <td rowspan=2 style="border: 1px solid black;text-align:center;font-size:10pt;font-weight:bold;vertical-align:middle">1</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">No. Msn DM</td>
                                <td style="border: 1px solid black">' . $nomesin . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">No Wadah</td>
                                <td style="border: 1px solid black">dari</td>
                                <td style="border: 1px solid black">Berat/Wadah</td>
                                <td style="border: 1px solid black;text-align:center">' . $berat . ' ' . $uom . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Tgl. FBD</td>
                                <td style="border: 1px solid black"></td>
                                <td rowspan=2 style="border: 1px solid black">No Proses</td>
                                <td rowspan=2 style="border: 1px solid black"></td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">No. Msn FBD</td>
                                <td style="border: 1px solid black"></td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Nama Operator</td>
                                <td colspan=3 style="border: 1px solid black">' . $operator . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black;font-weight:bold;text-align:center">STATUS</td>
                                <td style="border: 1px solid black;font-weight:bold;text-align:center">KARANTINA</td>
                                <td colspan="2" rowspan="2" style="border: 1px solid black;text-align:center;font-size:15pt;font-weight:bold">AWAL</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black;text-align:center">Paraf+Nama+Tgl</td>
                                <td style="border: 1px solid black;font-weight:bold;text-align:center"></td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td colspan=4 style="border: 1px solid black">Status: LULUS distempel warna hijau, TOLAK distempel warna merah</td>
                            </tr>          
                        </table>
                    </td>
                    <td>
                        <table class="table table-sm mb-0" style="border: 1px solid black;font-size:7pt;width:400px">
                            <tr>
                                <td style=" border: 1px solid black">
                                    <center><img src="../../../../asset/img/sidomuncul.png" style="width:5%"></center>
                                </td>
                                <td rowspan=3 style="text-align:center;font-weight:bold;border: 1px solid black;width:100px">LABEL <br> HASIL PROSES <br> DRY MIXED</td>
                                <td>No Form</td>
                                <td style="width:50px">:FM-053050-01-00-011</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="text-align:center;font-weight:bold">PRODUKSI</td>
                                <td>Revisi</td>
                                <td>:02</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black;text-align:center;font-weight:bold">SERB. INS. & SED. PANGAN</td>
                                <td>Tgl Berlaku</td>
                                <td>:17 Juni 2019</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Produk</td>
                                <td colspan="3" style="border: 1px solid black;font-weight:bold;font-size:10pt"> ' . $prod_desc . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">ED/No Bets</td>
                                <td colspan="3" style="border: 1px solid black">ED ' . $ed_batch . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Tgl. Dry Mixed</td>
                                <td style="border: 1px solid black">' . $mixingdate . '</td>
                                <td rowspan=2 style="border: 1px solid black">No Proses</td>
                                <td rowspan=2 style="border: 1px solid black;text-align:center;font-size:10pt;font-weight:bold;vertical-align:middle">1</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">No. Msn DM</td>
                                <td style="border: 1px solid black">' . $nomesin . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">No Wadah</td>
                                <td style="border: 1px solid black">dari</td>
                                <td style="border: 1px solid black">Berat/Wadah</td>
                                <td style="border: 1px solid black;text-align:center">' . $berat . ' ' . $uom . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Tgl. FBD</td>
                                <td style="border: 1px solid black"></td>
                                <td rowspan=2 style="border: 1px solid black">No Proses</td>
                                <td rowspan=2 style="border: 1px solid black"></td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">No. Msn FBD</td>
                                <td style="border: 1px solid black"></td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Nama Operator</td>
                                <td colspan=3 style="border: 1px solid black">' . $operator . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black;font-weight:bold;text-align:center">STATUS</td>
                                <td style="border: 1px solid black;font-weight:bold;text-align:center">KARANTINA</td>
                                <td colspan="2" rowspan="2" style="border: 1px solid black;text-align:center;font-size:15pt;font-weight:bold">TENGAH</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black;text-align:center">Paraf+Nama+Tgl</td>
                                <td style="border: 1px solid black;font-weight:bold;text-align:center"></td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td colspan=4 style="border: 1px solid black">Status: LULUS distempel warna hijau, TOLAK distempel warna merah</td>
                            </tr>          
                        </table>
                    </td>
                    <td>
                        <table class="table table-sm mb-0" style="border: 1px solid black;font-size:7pt;width:400px">
                            <tr>
                                <td style=" border: 1px solid black">
                                    <center><img src="../../../../asset/img/sidomuncul.png" style="width:5%"></center>
                                </td>
                                <td rowspan=3 style="text-align:center;font-weight:bold;border: 1px solid black;width:100px">LABEL <br> HASIL PROSES <br> DRY MIXED</td>
                                <td>No Form</td>
                                <td style="width:50px">:FM-053050-01-00-011</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="text-align:center;font-weight:bold">PRODUKSI</td>
                                <td>Revisi</td>
                                <td>:02</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black;text-align:center;font-weight:bold">SERB. INS. & SED. PANGAN</td>
                                <td>Tgl Berlaku</td>
                                <td>:17 Juni 2019</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Produk</td>
                                <td colspan="3" style="border: 1px solid black;font-weight:bold;font-size:10pt"> ' . $prod_desc . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">ED/No Bets</td>
                                <td colspan="3" style="border: 1px solid black">ED ' . $ed_batch . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Tgl. Dry Mixed</td>
                                <td style="border: 1px solid black">' . $mixingdate . '</td>
                                <td rowspan=2 style="border: 1px solid black">No Proses</td>
                                <td rowspan=2 style="border: 1px solid black;text-align:center;font-size:10pt;font-weight:bold;vertical-align:middle">1</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">No. Msn DM</td>
                                <td style="border: 1px solid black">' . $nomesin . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">No Wadah</td>
                                <td style="border: 1px solid black">dari</td>
                                <td style="border: 1px solid black">Berat/Wadah</td>
                                <td style="border: 1px solid black;text-align:center">' . $berat . ' ' . $uom . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Tgl. FBD</td>
                                <td style="border: 1px solid black"></td>
                                <td rowspan=2 style="border: 1px solid black">No Proses</td>
                                <td rowspan=2 style="border: 1px solid black"></td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">No. Msn FBD</td>
                                <td style="border: 1px solid black"></td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Nama Operator</td>
                                <td colspan=3 style="border: 1px solid black">' . $operator . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black;font-weight:bold;text-align:center">STATUS</td>
                                <td style="border: 1px solid black;font-weight:bold;text-align:center">KARANTINA</td>
                                <td colspan="2" rowspan="2" style="border: 1px solid black;text-align:center;font-size:15pt;font-weight:bold">AKHIR</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black;text-align:center">Paraf+Nama+Tgl</td>
                                <td style="border: 1px solid black;font-weight:bold;text-align:center"></td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td colspan=4 style="border: 1px solid black">Status: LULUS distempel warna hijau, TOLAK distempel warna merah</td>
                            </tr>          
                        </table>
                    </td>          
                </tr>
                <tr>
                    <td>
                        <table class="table table-sm mb-0" style="border: 1px solid black;font-size:7pt;width:400px">
                            <tr>
                                <td style=" border: 1px solid black">
                                    <center><img src="../../../../asset/img/sidomuncul.png" style="width:5%"></center>
                                </td>
                                <td rowspan=3 style="text-align:center;font-weight:bold;border: 1px solid black;width:100px">LABEL <br> HASIL PROSES <br> DRY MIXED</td>
                                <td>No Form</td>
                                <td style="width:50px">:FM-053050-01-00-011</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="text-align:center;font-weight:bold">PRODUKSI</td>
                                <td>Revisi</td>
                                <td>:02</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black;text-align:center;font-weight:bold">SERB. INS. & SED. PANGAN</td>
                                <td>Tgl Berlaku</td>
                                <td>:17 Juni 2019</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Produk</td>
                                <td colspan="3" style="border: 1px solid black;font-weight:bold;font-size:10pt"> ' . $prod_desc . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">ED/No Bets</td>
                                <td colspan="3" style="border: 1px solid black">ED ' . $ed_batch . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Tgl. Dry Mixed</td>
                                <td style="border: 1px solid black">' . $mixingdate . '</td>
                                <td rowspan=2 style="border: 1px solid black">No Proses</td>
                                <td rowspan=2 style="border: 1px solid black;text-align:center;font-size:10pt;font-weight:bold;vertical-align:middle">2</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">No. Msn DM</td>
                                <td style="border: 1px solid black">' . $nomesin . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">No Wadah</td>
                                <td style="border: 1px solid black">dari</td>
                                <td style="border: 1px solid black">Berat/Wadah</td>
                                <td style="border: 1px solid black;text-align:center">' . $berat . ' ' . $uom . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Tgl. FBD</td>
                                <td style="border: 1px solid black"></td>
                                <td rowspan=2 style="border: 1px solid black">No Proses</td>
                                <td rowspan=2 style="border: 1px solid black"></td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">No. Msn FBD</td>
                                <td style="border: 1px solid black"></td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Nama Operator</td>
                                <td colspan=3 style="border: 1px solid black">' . $operator . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black;font-weight:bold;text-align:center">STATUS</td>
                                <td style="border: 1px solid black;font-weight:bold;text-align:center">KARANTINA</td>
                                <td colspan="2" rowspan="2" style="border: 1px solid black;text-align:center;font-size:15pt;font-weight:bold">AWAL</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black;text-align:center">Paraf+Nama+Tgl</td>
                                <td style="border: 1px solid black;font-weight:bold;text-align:center"></td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td colspan=4 style="border: 1px solid black">Status: LULUS distempel warna hijau, TOLAK distempel warna merah</td>
                            </tr>          
                        </table>
                    </td>
                    <td>
                        <table class="table table-sm mb-0" style="border: 1px solid black;font-size:7pt;width:400px">
                            <tr>
                                <td style=" border: 1px solid black">
                                    <center><img src="../../../../asset/img/sidomuncul.png" style="width:5%"></center>
                                </td>
                                <td rowspan=3 style="text-align:center;font-weight:bold;border: 1px solid black;width:100px">LABEL <br> HASIL PROSES <br> DRY MIXED</td>
                                <td>No Form</td>
                                <td style="width:50px">:FM-053050-01-00-011</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="text-align:center;font-weight:bold">PRODUKSI</td>
                                <td>Revisi</td>
                                <td>:02</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black;text-align:center;font-weight:bold">SERB. INS. & SED. PANGAN</td>
                                <td>Tgl Berlaku</td>
                                <td>:17 Juni 2019</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Produk</td>
                                <td colspan="3" style="border: 1px solid black;font-weight:bold;font-size:10pt"> ' . $prod_desc . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">ED/No Bets</td>
                                <td colspan="3" style="border: 1px solid black">ED ' . $ed_batch . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Tgl. Dry Mixed</td>
                                <td style="border: 1px solid black">' . $mixingdate . '</td>
                                <td rowspan=2 style="border: 1px solid black">No Proses</td>
                                <td rowspan=2 style="border: 1px solid black;text-align:center;font-size:10pt;font-weight:bold;vertical-align:middle">2</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">No. Msn DM</td>
                                <td style="border: 1px solid black">' . $nomesin . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">No Wadah</td>
                                <td style="border: 1px solid black">dari</td>
                                <td style="border: 1px solid black">Berat/Wadah</td>
                                <td style="border: 1px solid black;text-align:center">' . $berat . ' ' . $uom . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Tgl. FBD</td>
                                <td style="border: 1px solid black"></td>
                                <td rowspan=2 style="border: 1px solid black">No Proses</td>
                                <td rowspan=2 style="border: 1px solid black"></td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">No. Msn FBD</td>
                                <td style="border: 1px solid black"></td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Nama Operator</td>
                                <td colspan=3 style="border: 1px solid black">' . $operator . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black;font-weight:bold;text-align:center">STATUS</td>
                                <td style="border: 1px solid black;font-weight:bold;text-align:center">KARANTINA</td>
                                <td colspan="2" rowspan="2" style="border: 1px solid black;text-align:center;font-size:15pt;font-weight:bold">TENGAH</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black;text-align:center">Paraf+Nama+Tgl</td>
                                <td style="border: 1px solid black;font-weight:bold;text-align:center"></td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td colspan=4 style="border: 1px solid black">Status: LULUS distempel warna hijau, TOLAK distempel warna merah</td>
                            </tr>          
                        </table>
                    </td>
                    <td>
                        <table class="table table-sm mb-0" style="border: 1px solid black;font-size:7pt;width:400px">
                            <tr>
                                <td style=" border: 1px solid black">
                                    <center><img src="../../../../asset/img/sidomuncul.png" style="width:5%"></center>
                                </td>
                                <td rowspan=3 style="text-align:center;font-weight:bold;border: 1px solid black;width:100px">LABEL <br> HASIL PROSES <br> DRY MIXED</td>
                                <td>No Form</td>
                                <td style="width:50px">:FM-053050-01-00-011</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="text-align:center;font-weight:bold">PRODUKSI</td>
                                <td>Revisi</td>
                                <td>:02</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black;text-align:center;font-weight:bold">SERB. INS. & SED. PANGAN</td>
                                <td>Tgl Berlaku</td>
                                <td>:17 Juni 2019</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Produk</td>
                                <td colspan="3" style="border: 1px solid black;font-weight:bold;font-size:10pt"> ' . $prod_desc . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">ED/No Bets</td>
                                <td colspan="3" style="border: 1px solid black">ED ' . $ed_batch . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Tgl. Dry Mixed</td>
                                <td style="border: 1px solid black">' . $mixingdate . '</td>
                                <td rowspan=2 style="border: 1px solid black">No Proses</td>
                                <td rowspan=2 style="border: 1px solid black;text-align:center;font-size:10pt;font-weight:bold;vertical-align:middle    ">2</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">No. Msn DM</td>
                                <td style="border: 1px solid black">' . $nomesin . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">No Wadah</td>
                                <td style="border: 1px solid black">dari</td>
                                <td style="border: 1px solid black">Berat/Wadah</td>
                                <td style="border: 1px solid black;text-align:center">' . $berat . ' ' . $uom . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Tgl. FBD</td>
                                <td style="border: 1px solid black"></td>
                                <td rowspan=2 style="border: 1px solid black">No Proses</td>
                                <td rowspan=2 style="border: 1px solid black"></td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">No. Msn FBD</td>
                                <td style="border: 1px solid black"></td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black">Nama Operator</td>
                                <td colspan=3 style="border: 1px solid black">' . $operator . '</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black;font-weight:bold;text-align:center">STATUS</td>
                                <td style="border: 1px solid black;font-weight:bold;text-align:center">KARANTINA</td>
                                <td colspan="2" rowspan="2" style="border: 1px solid black;text-align:center;font-size:15pt;font-weight:bold">AKHIR</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black;text-align:center">Paraf+Nama+Tgl</td>
                                <td style="border: 1px solid black;font-weight:bold;text-align:center"></td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td colspan=4 style="border: 1px solid black">Status: LULUS distempel warna hijau, TOLAK distempel warna merah</td>
                            </tr>          
                        </table>
                    </td>          
                </tr>';
}
$output .= '
            </table>
        </div>
    </body>
</html>';

$filename = 'tes.pdf';
$mpdf = new \Mpdf\Mpdf();
// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [100, 80]]);
// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [147, 90]]);
// left,right,top,bottom.
$mpdf->AddPage('L', '', '', '', '', 5, 5, 10, 5, 10, 10);

$mpdf->WriteHTML($output);
$mpdf->SetTitle('Print Label');

// if ($act == 1) {
$mpdf->Output($filename, 'i');
