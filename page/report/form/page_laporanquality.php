<?php

include '../../../function/koneksi.php';
include '../../../function/getdata.php';
// include '../../../function/getvalue.php';
require_once __DIR__ . '/../../../asset/vendor/autoload.php';
require_once __DIR__ . '/../../../asset/vendor_qrcode/autoload.php';

use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;


// *****************************************************************
// // ------> START INITIALIZATION <------
// *****************************************************************
function deletenol($value)
{
    if ($value == 0) {
        $value = '';
    }
    return $value;
}
function cekparameter($a, $b, $c, $d, $e, $f, $g, $par)
{
    $return = '';
    include '../../../function/koneksi.php';
    $sql99 = mysqli_query($conn, "SELECT $par FROM tb_confirmprosesmixing WHERE Plant='$a' AND
                                                                                UnitCode='$b' AND
                                                                                PlanningNumber='$c' AND
                                                                                Years='$d' AND
                                                                                ProductID='$e' AND
                                                                                BatchNumber='$f' AND
                                                                                Noproses='$g'");
    $row = mysqli_fetch_array($sql99);
    if ($row[$par] == 'X') {
        $return = '☑';
    } else {
        $return = '☐';
    }
    return $return;
}
$planningnumber = str_replace("'", "", $_GET['n']);
$years = str_replace("'", "", $_GET['y']);
$filename = 'Rekap Transaksi CPB #' . $planningnumber . '.pdf';
$title = 'Rekap Transaksi CPB ' . $planningnumber . '';
$plant = $_SESSION['plant'];
$unitcode = $_SESSION['unitcode'];
loguser('Show Report CPB');

$person1 = '';
$person2 = '';
$person3 = '';
$person4 = '';

$person1_post = '';
$person2_post = '';
$person3_post = '';
$person4_post = '';

$onedate = '';
$twodate = '';
$threedate = '';
$fourdate = '';

$proseshoper = false;
$prosestopack = false;
$preparepillow = false;
$prosespillow = false;
$rekonpillow = false;
$pengemasanprimer = false;
$pengemasansekunder = false;
// *****************************************************************
// // ------> END INITIALIZATION <------
// *****************************************************************

$sql = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                        AND PlanningNumber='$planningnumber' 
                                                                                        AND Years='$years'");

if (mysqli_num_rows($sql) != 0) {
    $header = mysqli_fetch_array($sql);
    $productid = $header['ProductID'];
    $product_description = Getdata('ProductDescriptions', 'mara_product', 'ProductID', $productid);
    $totalselflife = Getdata('TotalSelfLife', 'mara_product', 'ProductID', $productid);
    $batch = $header['BatchNumber'];
    $expdate = strtoupper('ED. ' . date('M y', strtotime($header['ExpiredDate'])));
    $quantity = $header['Quantity'];
    $uom = $header['UnitOfMeasures'];
    $range_bobot = Getdata('BobotTimbang', 'mara_product', 'ProductID', $productid);

    $proseshoper = strtoupper($header['ProsesHoper']);
    $prosestopack = strtoupper($header['ProsesTopack']);
    $preparepillow = strtoupper($header['PreparePillow']);
    $prosespillow = strtoupper($header['ProsesPillow']);
    $rekonpillow = strtoupper($header['RekonPillow']);
    $pengemasanprimer = strtoupper($header['ApprovalQc']);
    $pengemasansekunder = strtoupper($header['AnalisaKemasSekunder']);
    $namamesin = $header['ResourceIDMix'];
    $packingdate = date('d/m', strtotime($header['PackingDate']));
    $mixingdate = $header['MixingDate'];
    $resourceid = $header['ResourceID'];
    $shiftid = $header['ShiftID'];
    if ($produkid == 'KJ') {
        $batch = $batch . ' ' . 'BC';
    }
}

// *****************************************************************
// // ------> Tinjauan QA <------
// *****************************************************************
$output1 = "
    <!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='../../../asset/css/css_report.css'>
    </head>";
$output1 .= "
    <body>
        <div class='container'>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%;font-weight:bold'><center><img src='../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                        <td rowspan=2 colspan=5 style='border: 1px solid black; text-align:center;width:50%'><p style='font-weight:bold'>TINJAUAN QA <br> CATATAN PENGOLAHAN BETS</p></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center;font-weight:bold'>PEMASTIAN MUTU</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%;border: 1px solid black'>No. Dokumen</td>
                        <td style='width:15%;border: 1px solid black'>FM-0200000-01-00-021</td>
                        <td style='width:15%;border: 1px solid black'>No Revisi</td>
                        <td style='width:15%;border: 1px solid black'>01</td>
                        <td style='width:15%;border: 1px solid black'>Tanggal Berlaku</td>
                        <td style='width:15%;border: 1px solid black'>17 Februari 2020</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%;border: 1px solid black'>Mengganti No.</td>
                        <td style='width:15%;border: 1px solid black'>FM-0200000-01-00-021</td>
                        <td style='width:15%;border: 1px solid black'>No Revisi</td>
                        <td style='width:15%;border: 1px solid black'>00</td>
                        <td style='width:15%;border: 1px solid black'>Tanggal Berlaku</td>
                        <td style='width:15%;border: 1px solid black'>03 Oktober 2016</td>
                    </tr>
                    <tr>
                        <td colspan=3 style='width:15%'></td>
                        <td colspan=3 style='width:15%'>Rujukan: Dokumen Produksi Induk No DP.021020.08.12.030</td>
                    </tr>
                </tbody>
            </table>
            <table style='margin-bottom:2rem;width:300px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr>
                        <td style='width: 5%'>Nama Produk</td>
                        <td style='width: 5%'>: " . $product_description . "</td>
                    </tr>
                    <tr>
                        <td>No Bets</td>
                        <td>: " . $expdate  . ' / ' . $batch . "</td>
                    </tr>
                </tbody>
            </table>
            <table style='width:100%' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr>
                        <td style='padding-right:2rem;width:40%'>
                            <table cellpadding=2 cellspacing=0>
                                <tbody>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>Komposisi</td>
                                        <td style='border: 1px solid black;width:5%'></td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>Prosedur Pengolahan</td>
                                        <td style='border: 1px solid black;width:5%'></td>
                                    </tr>
                                </tbody>
                            </table>                               
                        </td>
                        <td>
                            <table cellpadding=2 cellspacing=0>
                                <tbody>
                                    <tr style='border: 1px solid black'>
                                        <td rowspan=2 style='border: 1px solid black;text-align:center'>Rekonsiliasi Hasil</td>
                                        <td style='border: 1px solid black'>Sachet</td>
                                        <td style='border: 1px solid black'>Strip</td>
                                        <td style='border: 1px solid black'>Botol</td>
                                        <td rowspan=2 style='border: 1px solid black;width:5%'></td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>...%</td>
                                        <td style='border: 1px solid black'>...%</td>
                                        <td style='border: 1px solid black'>...%</td>
                                    </tr>
                                </tbody>
                            </table>                               
                        </td>                 
                    </tr>
                </tbody>
            </table>
            <table style='width:100%' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr>
                        <td style='padding-right:2rem;width:40%'>
                            <table cellpadding=2 cellspacing=0>
                                <tbody>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>Kodifikasi Kemasan Primer</td>
                                        <td style='border: 1px solid black;width:5%'></td>
                                    </tr>
                                </tbody>
                            </table>                               
                        </td>
                        <td>
                            <table cellpadding=2 cellspacing=0>
                                <tbody>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>Sertifikasi Analisa dinyatakan memenuhi syarat (MS)</td>
                                        <td style='border: 1px solid black;width:5%'></td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>Label</td>
                                        <td style='border: 1px solid black;width:5%'></td>
                                    </tr>
                                </tbody>
                            </table>                               
                        </td>                 
                    </tr>
                </tbody>
            </table>
            <table style='width:100%' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr>
                        <td style='padding-right:2rem;width:40%'>
                            <table cellpadding=2 cellspacing=0>
                                <tbody>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>IPC</td>
                                        <td style='border: 1px solid black;width:5%'></td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>Penyimpangan Selama Proses<br>(Status dinyatakan closed)</td>
                                        <td style='border: 1px solid black;width:5%'></td>
                                    </tr>
                                </tbody>
                            </table>                            
                        </td>
                        <td>&nbsp;</td>                 
                    </tr>
                </tbody>
            </table>
            <table cellpadding=2 cellspacing=0 style='margin-top:3%'>
                <tbody>
                    <tr>
                        <td>CATATAN</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>HASIL</td>
                        <td>:</td>
                        <td><img src='../../../asset/icon/rectangle.png'>LULUS</td>
                        <td><img src='../../../asset/icon/rectangle.png'>TIDAK LULUS</td>
                    </tr>
                </tbody>
            </table>
            <hr>
            <table cellpadding=2 cellspacing=0>
                <tbody>
                    <tr>
                        <td style='text-align:center'>Pemeriksaan Catatan Pengolahan Bets</td>
                        <td style='text-align:center'>Peninjauan Catatan Pengolahan Bets</td>
                    </tr>
                    <tr>
                        <td style='text-align:center'>Kepala Produksi</td>
                        <td style='text-align:center'>Manajer Pemastian Mutu</td>
                    </tr>
                    <tr>
                        <td style='padding-bottom:3rem'></td>
                        <td style='padding-bottom:3rem'></td>
                    </tr>
                    <tr>
                        <td style='text-align:center'>Kab. Semarang," . date('d M Y') . "</td>
                        <td style='text-align:center'>Kab. Semarang," . date('d M Y') . "</td>
                    </tr>
                </tbody>
            </table>
            <hr style='margin-bottom:3rem'>


            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%;font-weight:bold'><center><img src='../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                        <td rowspan=2 colspan=5 style='border: 1px solid black; text-align:center;width:50%'><p style='font-weight:bold'>TINJAUAN QA <br> CATATAN PENGEMASAN BETS</p></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center;font-weight:bold'>PEMASTIAN MUTU</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%;border: 1px solid black'>No. Dokumen</td>
                        <td style='width:15%;border: 1px solid black'>FM-0200000-01-00-021</td>
                        <td style='width:15%;border: 1px solid black'>No Revisi</td>
                        <td style='width:15%;border: 1px solid black'>01</td>
                        <td style='width:15%;border: 1px solid black'>Tanggal Berlaku</td>
                        <td style='width:15%;border: 1px solid black'>17 Februari 2020</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%;border: 1px solid black'>Mengganti No.</td>
                        <td style='width:15%;border: 1px solid black'>FM-0200000-01-00-021</td>
                        <td style='width:15%;border: 1px solid black'>No Revisi</td>
                        <td style='width:15%;border: 1px solid black'>00</td>
                        <td style='width:15%;border: 1px solid black'>Tanggal Berlaku</td>
                        <td style='width:15%;border: 1px solid black'>03 Oktober 2016</td>
                    </tr>
                    <tr>
                        <td colspan=3 style='width:15%'></td>
                        <td colspan=3 style='width:15%'>Rujukan: Dokumen Produksi Induk No DP.021020.08.12.030</td>
                    </tr>
                </tbody>
            </table>
            <table style='margin-bottom:3rem;width:300px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr>
                        <td style='width: 5%'>Nama Produk</td>
                        <td style='width: 5%'>: " . $product_description . "</td>
                    </tr>
                    <tr>
                        <td>No Bets</td>
                        <td>: " . $expdate  . ' / ' . $batch . "</td>
                    </tr>
                    <tr>
                        <td>Ukuran Bets</td>
                        <td>: " . number_format($quantity) . ' ' . $uom . "</td>
                    </tr>
                </tbody>
            </table>
            <table style='width:100%' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr>
                        <td style='padding-right:2rem;width:40%'>
                            <table cellpadding=2 cellspacing=0>
                                <tbody>
                                    <tr>
                                        <td colspan=3 style='font-weight:bold'>REKONSILIASI HASIL PACKING</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black;text-align:center'>Tgl. Packing</td>
                                        <td style='border: 1px solid black;text-align:center'>Jumlah</td>
                                        <td style='border: 1px solid black;text-align:center'>Jenis Kemasan</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>                            
                        </td>
                        <td>
                            <table cellpadding=2 cellspacing=0>
                                <tbody>
                                    <tr>
                                        <td style='font-weight:bold'>TINJAUAN QA</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>Kodifikasi Kemasan Sekunder</td>
                                        <td style='border: 1px solid black;width:5%'></td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>Rekonsiliasi Bahan Pengemas</td>
                                        <td style='border: 1px solid black;width:5%'></td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>Rekonsiliasi Produk Jadi</td>
                                        <td style='border: 1px solid black;width:5%'></td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>Kebenaran Kemasan</td>
                                        <td style='border: 1px solid black;width:5%'></td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>Jalur Pengemasan (<i>Line Clearance</i>)</td>
                                        <td style='border: 1px solid black;width:5%'></td>
                                    </tr>
                                </tbody>
                            </table> 
                        </td>                 
                    </tr>
                </tbody>
            </table>
            <table cellpadding=2 cellspacing=0 style='margin-top:3%'>
                <tbody>
                    <tr>
                        <td>CATATAN</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>HASIL</td>
                        <td>:</td>
                        <td><img src='../../../asset/icon/rectangle.png'>LULUS</td>
                        <td><img src='../../../asset/icon/rectangle.png'>TIDAK LULUS</td>
                    </tr>
                </tbody>
            </table>
            <hr>
            <table cellpadding=2 cellspacing=0>
                <tbody>
                    <tr>
                        <td style='text-align:center'>Pemeriksaan Catatan Pengemasan Bets</td>
                        <td style='text-align:center'>Peninjauan Catatan Pengemasan Bets</td>
                    </tr>
                    <tr>
                        <td style='text-align:center'>Kepala Produksi</td>
                        <td style='text-align:center'>Manajer Pemastian Mutu</td>
                    </tr>
                    <tr>
                        <td style='padding-bottom:3rem'></td>
                        <td style='padding-bottom:3rem'></td>
                    </tr>
                    <tr>
                        <td style='text-align:center'>Kab. Semarang," . date('d M Y') . "</td>
                        <td style='text-align:center'>Kab. Semarang," . date('d M Y') . "</td>
                    </tr>
                </tbody>
            </table>         
        </div>
    </body>
</html>";

// *****************************************************************
// ------> Prepare & Proses Pengolahan <------
// *****************************************************************
$sql = mysqli_query($conn, "SELECT * FROM frm_approval WHERE Plant='$plant' AND
                                                            UnitCode='$unitcode' AND 
                                                            FormTypes ='preparepengolahan'");
if (mysqli_num_rows($sql) != 0) {
    $row = mysqli_fetch_array($sql);
    $pengawasproduksi = $row['OnePerson'];
    $ka_unit = $row['TwoPerson'];
    $man_qc = $row['ThreePerson'];
    $man_qa = $row['FourPerson'];

    $jab_pengawas = $row['OnePost'];
    $jab_ka = $row['TwoPost'];
    $jab_manqc = $row['ThreePost'];
    $jab_manqa = $row['FourPost'];

    $onedate = date('d-m-Y', strtotime($row['OneDate']));
    $twodate = date('d-m-Y', strtotime($row['TwoDate']));
    $threedate = date('d-m-Y', strtotime($row['ThreeDate']));
    $fourdate = date('d-m-Y', strtotime($row['FourDate']));
}

$sql = mysqli_query($conn, "SELECT * FROM planning_pengolahan_subdetail WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND 
                                                                                ProductID='$productid' AND 
                                                                                BatchNumber='$batch' AND 
                                                                                NoProses='1'");
if (mysqli_num_rows($sql) != 0) {
    $r = mysqli_fetch_array($sql);
    $planningnumber_pengolahan = $r['PlanningNumber'];
    $items = $r['Items'];
    $years = $r['Years'];
    // $batchnumber = $r['BatchNumber'];
    $noproses = $r['NoProses'];
    $query = mysqli_query($conn, "SELECT A.Shift,B.ResourceIDMix,B.MixingDate,A.CreatedOn,B.ReffCode FROM planning_pengolahan_header AS A 
                                    INNER JOIN  planning_pengolahan_detail AS B
                                    ON A.PlanningNumber=B.PlanningNumber WHERE B.Plant='$plant' AND
                                                                            B.UnitCode='$unitcode' AND
                                                                            B.ProductID='$productid' AND
                                                                            B.BatchNumber LIKE '%$batch%'");
    $row = mysqli_fetch_array($query);
    $resourceidmix = $row['ResourceIDMix'];
    $mixingdate = $row['MixingDate'];
    $shift = $row['Shift'];
    $createdon = date('d F Y', strtotime($row['CreatedOn']));
    $reffcode = $row['ReffCode'];
    $prepare_mixer = mysqli_query($conn, "SELECT * FROM proses_prepare_mixer WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                PlanningNumber='$r[PlanningNumber]' AND
                                                                                Years='$r[Years]' AND
                                                                                NoProses='$noproses' AND
                                                                                -- ProductID='$productid' AND
                                                                                BatchNumber='$batch'");
    if (mysqli_num_rows($prepare_mixer) != 0) {
        $show_mixer = mysqli_fetch_array($prepare_mixer);
        $operator_mixer1 = $show_mixer['Operator1'];
        $operator_mixer2 = $show_mixer['Operator2'];
        $operator_mixer3 = $show_mixer['Operator3'];
        $pengawas = $show_mixer['PengawasProduksi'];
        $parameter_mixer1 = $show_mixer['Parameter_1'];
        $parameter_mixer2 = $show_mixer['Parameter_2'];
        $parameter_mixer3 = $show_mixer['Parameter_3'];
        $parameter_mixer4 = $show_mixer['Parameter_4'];
        $parameter_mixer5 = $show_mixer['Parameter_5'];
        $parameter_mixer6 = $show_mixer['Parameter_6'];
        $parameter_mixer7 = $show_mixer['Parameter_7'];
        $parameter_mixer8 = $show_mixer['Parameter_8'];
        $parameter_mixer9 = $show_mixer['Parameter_9'];
        $parameter_mixer10 = $show_mixer['Parameter_10'];
        // $shift = GetdataIV('Shift', 'planning_pengolahan_header', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $show_mixer['PlanningNumber'], 'Years', $show_mixer['PlanningNumber']);
    }

    $output2 = "
    <!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='../../../asset/css/css_report.css'>
     </head>";
    $output2 .= "
    <body>
        <div class='container'>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%;font-weight:bold'><center><img src='../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                        <td rowspan=3 colspan=5 style='border: 1px solid black; text-align:center;width:50%'><p style='font-weight:bold'>CATATAN PENGOLAHAN BETS<br>" . $product_description  . "</p></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center;font-weight:bold'>PRODUKSI</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center;font-weight:bold'>SERBUK INSTAN & SEDIAAN PANGAN</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%;border: 1px solid black'>No. Dokumen</td>
                        <td style='width:15%;border: 1px solid black'>FM-053050-04-04-002</td>
                        <td style='width:15%;border: 1px solid black'>No Revisi</td>
                        <td style='width:15%;border: 1px solid black'>09</td>
                        <td style='width:15%;border: 1px solid black'>Tanggal Berlaku</td>
                        <td style='width:15%;border: 1px solid black'>09 Oktober 2023</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%;border: 1px solid black'>Mengganti No.</td>
                        <td style='width:15%;border: 1px solid black'>FM-053050-04-04-002</td>
                        <td style='width:15%;border: 1px solid black'>No Revisi</td>
                        <td style='width:15%;border: 1px solid black'>08</td>
                        <td style='width:15%;border: 1px solid black'>Tanggal Berlaku</td>
                        <td style='width:15%;border: 1px solid black'>08 Oktober 2022</td>
                    </tr>
                </tbody>
            </table>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Disusun Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Diperiksa Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Diperiksa Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Disetujui Oleh</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $pengawasproduksi . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $ka_unit . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $man_qc . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $man_qa . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $jab_pengawas . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $jab_ka . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $jab_manqc . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $jab_manqa . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $onedate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $twodate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $threedate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $fourdate . "</td>
                    </tr>
                </tbody>
            </table>
            <table cellpadding=2 cellspacing=0 style='border: 1px solid black;'>
                <tr>
                    <td>Nama Produk</td>
                    <td>: " . $product_description . "</td>
                    <td style='width:30%'>&nbsp;</td>
                    <td>Rujukan</td>
                    <td>: Dokumen Produksi Induk No. DP-021020-08-12-030</td>
                </tr>
                <tr>
                    <td>Kode Formula</td>
                    <td>: F-81</td>
                    <td>&nbsp;</td>
                    <td>Ukuran Bets</td>
                    <td>: 255 Kg</td>
                </tr>
                <tr>
                    <td colspan=3>&nbsp;</td>
                    <td>Masa Kadaluarsa</td>
                    <td>: " . $totalselflife . " Bulan</td>
                </tr>
            </table>
            <table cellpadding=2 cellspacing=0 style='border: 1px solid black;'>
                <tr>
                    <td style='font-weight:bold'>Nama Operator</td>
                    <td style='font-weight:bold'>Nama & No Mesin</td>
                    <td style='font-weight:bold'>ED/No. Bets</td>
                    <td style='font-weight:bold'>No. Proses</td>
                    <td style='font-weight:bold'>Hari/Tgl</td>
                    <td>: " . $createdon . "</td>
                </tr>
                <tr>
                    <td>1. " . $operator_mixer1 . "</td>
                    <td rowspan=3>" . $resourceidmix . "</td>
                    <td rowspan=3>" . $expdate . "/<br>" . $batch . "</td>
                    <td rowspan=3>" . $noproses . "</td>
                    <td style='font-weight:bold'>Shift</td>
                    <td>: " . $shift . "</td>
                </tr>
                <tr>
                    <td>2. " . $operator_mixer2 . "</td>
                    <td style='font-weight:bold'>Jam Mulai</td>
                    <td>: <i>Jam Mulai</i></td>
                </tr>
                <tr>
                    <td>3. " . $operator_mixer3 . "</td>
                    <td style='font-weight:bold'>Jam Selesai</td>
                    <td>: <i>Jam Selesai</i></td>
                </tr>
            </table>
            <table cellpadding=2 cellspacing=0 style='border: 1px solid black;'>
                <tr>
                    <td rowspan=2 style='vertical-align: top;'>Perhatian</td>
                    <td>
                        : Apabila terjadi penyimpangan terhadap suatu ketetapan laporkan dan tangani sesuai Prosedur Tindakan Perbaikan dan Pencegahan
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;No. PS-020000-01-00-004 </td>
                </tr>
            </table>
            <table cellpadding=2 cellspacing=0 style='border: 1px solid black;'>
                <tr style='border: 1px solid black;'>
                    <td colspan=4>. Gunakan APD sesuai standard, pelindung pernapasan (masker) dan pakai sarung tangan</td>
                </tr>
                <tr style='border: 1px solid black;'>
                    <td style='border: 1px solid black;width:15%'>
                        <table cellpadding=2 cellspacing=0>
                            <tr>
                                <td style='font-weight:bold'>I. Persiapan Bahan<br>Tgl : <i>14.06</i></td>
                            </tr>
                        </table>
                    </td>
                    <td colspan=3>
                        <table cellpadding=2 cellspacing=0>
                            <tr>
                                <td style='font-weight:bold;width:16%'>Kode Bahan</td>
                                <td style='font-weight:bold;width:16%'>Jml Teoritis</td>
                                <td style='font-weight:bold;width:16%'>Jml Nyata</td>
                                <td style='font-weight:bold;width:16%'>Tanggal</td>
                                <td style='font-weight:bold;width:16%'>No. Identitas</td>
                                <td style='font-weight:bold;width:10%'>Pelaksana</td>
                                <td style='font-weight:bold;width:10%'>Pemeriksa</td>
                            </tr>";
    $sql = mysqli_query($conn, "SELECT * FROM tb_headerbahanpengolahan WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            ProductID='$productid' AND
                                                                            BatchNumber='$batch' AND
                                                                            NoProses='$noproses'");
    while ($r = mysqli_fetch_array($sql)) {
        $d = mysqli_query($conn, "SELECT NoIdentitas FROM tb_detailbahanpengolahan WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            PlanningNumber='$r[PlanningNumber]' AND
                                                                            Years='$r[Years]' AND
                                                                            ProductID='$productid' AND
                                                                            BatchNumber='$batch' AND
                                                                            BatchLabel='$r[BatchLabel]' AND
                                                                            KodeBahan='$r[KodeBahan]' AND
                                                                            NoProses='$noproses'");
        $show_d = mysqli_fetch_array($d);
        $output2 .= "
                            <tr>
                                <td>" . $r['KodeBahan'] . "</td>
                                <td>" . $r['JmlTeoritis'] . "</td>
                                <td>" . $r['JmlNyata'] . "</td>
                                <td>" . date('d-M-Y', strtotime($r['CreatedOn']))  . "</td>
                                <td>" . $show_d['NoIdentitas'] . "</td>
                                <td>" . $r['CreatedBy'] . "</td>
                                <td></td>
                            </tr>";
    }
    $output2 .= "
                        </table>
                    </td>
                </tr>
            </table>
            <table cellpadding=2 cellspacing=0>
                <tr style='border: 1px solid black'>
                    <td rowspan=13 style='width:15%;font-weight:bold'>II. Daftar Periksa<br>Kesiapan<br>Pencampuran<br>Serbuk</td>
                    <td colspan=7 style='border: 1px solid black;font-weight:bold'>CATATAN: DALAM RUANGAN TIDAK BOLEH ADA PRODUK SELAIN YANG AKAN DIKERJAKAN</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td colspan=2 rowspan=2 style='border: 1px solid black;width:50%;font-weight:bold;text-align:center'> Uraian Pemeriksaan</td>
                    <td rowspan=2 style='border: 1px solid black;width:10%;font-weight:bold;text-align:center'>Hasil Periksa</td>
                    <td colspan=2 style='border: 1px solid black;width:15%;font-weight:bold;text-align:center'>Pelaksana</td>
                    <td colspan=2 style='border: 1px solid black;width:15%;font-weight:bold;text-align:center'>Pemeriksa</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black;width:10%;font-weight:bold;text-align:center'>Nama</td>
                    <td style='border: 1px solid black;width:10%;font-weight:bold;text-align:center'>Paraf</td>
                    <td style='border: 1px solid black;width:10%;font-weight:bold;text-align:center'>Nama</td>
                    <td style='border: 1px solid black;width:10%;font-weight:bold;text-align:center'>Paraf</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black;width:2%'>a.</td>
                    <td style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'Jenisproses', 'preparepengolahan', 'Item', 1) . "</td>
                    <td style='border: 1px solid black'>" . $parameter_mixer1 . "</td>
                    <td style='border: 1px solid black'>" . $operator_mixer1 . "</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>" . $pengawas . "</td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>b.</td>
                    <td style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'Jenisproses', 'preparepengolahan', 'Item', 2) . "</td>
                    <td style='border: 1px solid black'>" . $parameter_mixer2 . "</td>
                    <td style='border: 1px solid black'>" . $operator_mixer1 . "</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>" . $pengawas . "</td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>c.</td>
                    <td style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'Jenisproses', 'preparepengolahan', 'Item', 3) . "</td>
                    <td style='border: 1px solid black'>" . $parameter_mixer3 . "</td>
                    <td style='border: 1px solid black'>" . $operator_mixer1 . "</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>" . $pengawas . "</td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>d.</td>
                    <td style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'Jenisproses', 'preparepengolahan', 'Item', 4) . "</td>
                    <td style='border: 1px solid black'>" . $parameter_mixer4 . "</td>
                    <td style='border: 1px solid black'>" . $operator_mixer1 . "</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>" . $pengawas . "</td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>e.</td>
                    <td style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'Jenisproses', 'preparepengolahan', 'Item', 5) . "</td>
                    <td style='border: 1px solid black'>" . $parameter_mixer5 . "</td>
                    <td style='border: 1px solid black'>" . $operator_mixer1 . "</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>" . $pengawas . "</td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>f.</td>
                    <td style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'Jenisproses', 'preparepengolahan', 'Item', 6) . "</td>
                    <td style='border: 1px solid black'>" . $parameter_mixer6 . "</td>
                    <td style='border: 1px solid black'>" . $operator_mixer1 . "</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>" . $pengawas . "</td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>g.</td>
                    <td style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'Jenisproses', 'preparepengolahan', 'Item', 7) . "</td>
                    <td style='border: 1px solid black'>" . $parameter_mixer7 . "</td>
                    <td style='border: 1px solid black'>" . $operator_mixer1 . "</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>" . $pengawas . "</td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>h.</td>
                    <td style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'Jenisproses', 'preparepengolahan', 'Item', 8) . "</td>
                    <td style='border: 1px solid black'>" . $parameter_mixer8 . "</td>
                    <td style='border: 1px solid black'>" . $operator_mixer1 . "</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>" . $pengawas . "</td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>i.</td>
                    <td style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'Jenisproses', 'preparepengolahan', 'Item', 9) . "</td>
                    <td style='border: 1px solid black'>" . $parameter_mixer9 . "</td>
                    <td style='border: 1px solid black'>" . $operator_mixer1 . "</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>" . $pengawas . "</td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>j.</td>
                    <td style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'Jenisproses', 'preparepengolahan', 'Item', 10) . "</td>
                    <td style='border: 1px solid black'>" . $parameter_mixer10 . "</td>
                    <td style='border: 1px solid black'>" . $operator_mixer1 . "</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>" . $pengawas . "</td>
                    <td style='border: 1px solid black'></td>
                </tr>
            </table>
            <table>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black;width:15%;font-weight:bold'>III. Pencampuran<br>Kering</td>
                    <td>
                        <table cellpadding=2 cellspacing=0 style='width:70%'>
                            <tr>
                                <td colspan=6>a. " . GetdataIV('Descriptions', 'md_proses_mixer', 'Plant', $plant, 'UnitCode', $unitcode, 'ProductID', $productid, 'Items', 1) . "</td>
                            </tr>
                            <tr style='border: 1px solid black;'>
                                <td style='text-align:center;border: 1px solid black;font-weight:bold'>Bahan</td>
                                <td style='text-align:center;border: 1px solid black;font-weight:bold'>Jumlah</td>
                                <td style='text-align:center;border: 1px solid black;font-weight:bold'>Satuan</td>
                                <td style='text-align:center;border: 1px solid black;font-weight:bold'>(√)</td>
                            </tr>
                            ";
    $sql = mysqli_query($conn, "SELECT * FROM tb_detailprosesmixing WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            -- PlanningNumber='$planningnumber' AND
                                                                            -- Years='$years' AND
                                                                            ReffCode='$reffcode' AND
                                                                            ProductID='$productid' AND
                                                                            Proses='1' AND
                                                                            NoProses='$noproses'");
    while ($r = mysqli_fetch_array($sql)) {
        $status = '';
        if ($r['Jumlah'] == $r['UsedTo']) {
            $status = '(√)';
        }
        $output2 .= "
                            <tr style='border: 1px solid black;'>
                                <td style='border: 1px solid black;'>" . $r['KodeBahan'] . "</td>
                                <td style='border: 1px solid black;text-align:center'>" . $r['Jumlah'] . "</td>
                                <td style='border: 1px solid black;'>" . $r['Satuan'] . "</td>
                                <td style='border: 1px solid black;text-align:center'>" . $status . "</td>
                            </tr>";
    }
    $output2 .= "
                        </table>
                    </td>
                    <td style='text-align:center;border: 1px solid black;font-weight:bold;vertical-align:top;width:10%'>Pelaksana</td>
                    <td style='text-align:center;border: 1px solid black;font-weight:bold;vertical-align:top;width:10%'>Pemeriksa</td>
                </tr>
            </table>
        </div>
    </body>
    </html>";


    // *****************************************************************
    // -------> Proses Mixing <------
    // *****************************************************************
    $sql = mysqli_query($conn, "SELECT * FROM frm_approval WHERE Plant='$plant' AND
                                                            UnitCode='$unitcode' AND 
                                                            FormTypes ='prosespengolahan'");
    if (mysqli_num_rows($sql) != 0) {
        $row = mysqli_fetch_array($sql);
        $pengawasproduksi = $row['OnePerson'];
        $ka_unit = $row['TwoPerson'];
        $man_qc = $row['ThreePerson'];
        $man_qa = $row['FourPerson'];

        $jab_pengawas = $row['OnePost'];
        $jab_ka = $row['TwoPost'];
        $jab_manqc = $row['ThreePost'];
        $jab_manqa = $row['FourPost'];

        $onedate = date('d-m-Y', strtotime($row['OneDate']));
        $twodate = date('d-m-Y', strtotime($row['TwoDate']));
        $threedate = date('d-m-Y', strtotime($row['ThreeDate']));
        $fourdate = date('d-m-Y', strtotime($row['FourDate']));
    }

    $noproses = 1;
    $sql = mysqli_query($conn, "SELECT * FROM insp_pengolahan_detail WHERE Plant='$plant' AND UnitCode='$unitcode' AND ProductID='$productid' AND BatchNumber='$batch'");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $inspectionlot = $r['InspectionLot'];
        $lotyears = $r['Lotyears'];
    }

    $output3 .= "
<!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='../../../asset/css/css_report.css'>
    </head>";

    $output3 .= "
<body>
        <div class='container'>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%;font-weight:bold'><center><img src='../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                        <td rowspan=3 colspan=5 style='border: 1px solid black;font-weight:bold; text-align:center;width:50%'>CATATAN PENGOLAHAN BETS<br>" . $product_description . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center;font-weight:bold'>PRODUKSI</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center;font-weight:bold'>SERBUK INSTAN &<br>SEDIAAN PANGAN</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%;border: 1px solid black'>No. Dokumen</td>
                        <td style='width:15%;border: 1px solid black'>FM-053050-04-04-002</td>
                        <td style='width:15%;border: 1px solid black'>No Revisi</td>
                        <td style='width:15%;border: 1px solid black'>09</td>
                        <td style='width:15%;border: 1px solid black'>Tanggal Berlaku</td>
                        <td style='width:15%;border: 1px solid black'>09 Oktober 2023</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%;border: 1px solid black'>Mengganti No.</td>
                        <td style='width:15%;border: 1px solid black'>FM-053050-04-04-002</td>
                        <td style='width:15%;border: 1px solid black'>No Revisi</td>
                        <td style='width:15%;border: 1px solid black'>08</td>
                        <td style='width:15%;border: 1px solid black'>Tanggal Berlaku</td>
                        <td style='width:15%;border: 1px solid black'>08 Oktober 2022</td>
                    </tr>
                </tbody>
            </table>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Disusun Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Diperiksa Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Diperiksa Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Disetujui Oleh</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $pengawasproduksi . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $ka_unit . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $man_qc . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $man_qa . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $jab_pengawas . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $jab_ka . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $jab_manqc . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $jab_manqa . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $onedate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $twodate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $threedate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $fourdate . "</td>
                    </tr>
                </tbody>
            </table>
            <table cellpadding=2 cellspacing=0>
                <tr style='border: 1px solid black'>
                    <td rowspan=9 style='width:15%;border: 1px solid black'></td>
                    <td colspan=2 style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>Pelaksana</td>
                    <td style='border: 1px solid black'>Pemeriksa</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='width:2%'>b.</td>
                    <td>Nyalakan aiator Mixer selama 2 menit dengan kecepatan blade 75rpm dan chopper 'On' campur hingga homogen Waktu: 2 menit</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='width:2%'>c.</td>
                    <td>Ayak C LSJ3 secara manual menggunakan ayakan mesh 18, tampung dalam wadah yang sudah tersedia</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='width:2%'>d.</td>
                    <td>
                        Masukan CLSJ3 yang lolos mesh 18 dan tambahkan SJ jika ada kedalam mesin mixer<br>
                        <table style='width:50%'>
                            <tr style='border: 1px solid black'>
                                <td style='border: 1px solid black;text-align:center;font-weight:bold'>Bahan</td>
                                <td style='border: 1px solid black;text-align:center;font-weight:bold'>Jumlah</td>
                                <td style='border: 1px solid black;text-align:center;font-weight:bold'>Satuan</td>
                                <td style='border: 1px solid black;text-align:center;font-weight:bold'>(√)</td>
                            </tr>";
    $mix_proses2 = mysqli_query($conn, "SELECT * FROM tb_detailprosesmixing WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                ProductID='$productid' AND
                                                                                NoProses='1' AND
                                                                                Proses='2' AND
                                                                                ReffCode='$reffcode'");
    while ($show_mix_proses2 = mysqli_fetch_array($mix_proses2)) {
        if ($show_mix_proses2['Jumlah'] == $show_mix_proses2['UsedTo']) {
            $status = '(√)';
        }

        $output3 .= "                                                       
                            <tr style='border: 1px solid black'>
                                <td style='border: 1px solid black;text-align:center'>" . $show_mix_proses2['KodeBahan'] . "</td>
                                <td style='border: 1px solid black;text-align:center'>" . $show_mix_proses2['Jumlah'] . "</td>
                                <td style='border: 1px solid black;text-align:center'>Kantong</td>
                                <td style='border: 1px solid black;text-align:center'>" . $status . "</td>
                            </tr>";
    }
    $output3 .= "
                            <tr style='border: 1px solid black'>
                                <td style='border: 1px solid black;text-align:center'>Tamb. Susu Jahe</td>
                                <td style='border: 1px solid black;text-align:center'>-</td>
                                <td style='border: 1px solid black;text-align:center'>Kantong</td>
                                <td style='border: 1px solid black;text-align:center'>-</td>
                            </tr>
                        </table>
                    </td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='width:2%'>e.</td>
                    <td>
                        Pastikan setelah bahan dimasukan plastik waduh bahan dalam kondisi utuh dan rapikan sebelum dikumpulkan<br>
                        
                        <table style='width:50%'>
                            <tr>
                                <td colspan=3 style='text-align:center;font-weight:bold'><h5 >KONDISI BAHAN KEMAS</h5></td>
                            </tr>";
    $output3 .= "
                            <tr>
                                <td rowspan=2>Plastik</td>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber_pengolahan, $years, $productid, $batch, 1, "Par1_1") . " Jumlah sesuai</td>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber_pengolahan, $years, $productid, $batch, 1, "Par1_2") . " Utuh</td>
                            </tr>
                            <tr>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber_pengolahan, $years, $productid, $batch, 1, "Par1_3") . " Jumlah tidak sesuai</td>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber_pengolahan, $years, $productid, $batch, 1, "Par1_4") . " tidak Utuh</td>
                            </tr>
                            <tr>
                                <td rowspan=2>Rafia</td>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber_pengolahan, $years, $productid, $batch, 1, "Par2_1") . " Jumlah sesuai</td>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber_pengolahan, $years, $productid, $batch, 1, "Par2_2") . " Utuh</td>
                            </tr>
                            <tr>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber_pengolahan, $years, $productid, $batch, 1, "Par2_3") . " Jumlah tidak sesuai</td>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber_pengolahan, $years, $productid, $batch, 1, "Par2_4") . " tidak Utuh</td>
                            </tr>
                            <tr>
                                <td rowspan=2>Label Bahan</td>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber_pengolahan, $years, $productid, $batch, 1, "Par3_1") . " Jumlah sesuai</td>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber_pengolahan, $years, $productid, $batch, 1, "Par3_2") . " Utuh</td>
                            </tr>
                            <tr>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber_pengolahan, $years, $productid, $batch, 1, "Par3_3") . " Jumlah tidak sesuai</td>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber_pengolahan, $years, $productid, $batch, 1, "Par3_4") . " tidak Utuh</td>
                            </tr>
                        </table>
                    </td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='width:2%'>f.</td>
                    <td>Nyalakan agiator mixer selama 4 menit kecepatan blade 75rpm dan chopper 'On', campur hingga homogen waktu: 4 menit</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='width:2%'>g.</td>
                    <td>keluarkan serbuk hasil pencampuran dan tampung dalam tong yang sudah diberi plastik</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='width:2%'>h.</td>
                    <td>Ambil sampel ditong ke 1,4 dan 7 oleh IPC sebanyak ± 130gr(3 sendok)</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='width:2%'>i.</td>
                    <td>Timbang hasil dalam tong @40kg kemudian ikat plastik dan tong ditutup</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'></td>
                </tr>
            </table>";
    $showhasiltimbang = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND
                                                                                                UnitCode='$unitcode' AND
                                                                                                PlanningNumber='$planningnumber_pengolahan' AND
                                                                                                Years='$years' AND
                                                                                                Items='$items' AND
                                                                                                ProductID='$productid' AND
                                                                                                BatchNumber='$batch' AND
                                                                                                NoProses='1' ORDER BY NoTong DESC");
    if (mysqli_num_rows($showhasiltimbang) != 0) {
        $r = mysqli_fetch_array($showhasiltimbang);
        $sisa = $r['Berat'];

        $showhasiltimbang2 = mysqli_query($conn, "SELECT SUM(Berat) AS B FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND
                                                                                                UnitCode='$unitcode' AND
                                                                                                PlanningNumber='$planningnumber_pengolahan' AND
                                                                                                Years='$years' AND
                                                                                                Items='$items' AND
                                                                                                ProductID='$productid' AND
                                                                                                BatchNumber='$batch' AND
                                                                                                NoProses='1'");
        $sum_berat = mysqli_fetch_array($showhasiltimbang2);
        $berat = $sum_berat['B'];
        $present_berat = $berat / 255 * 100;
    }
    $output3 .= "
            <table>
                <tr style='border: 1px solid black'>
                    <td rowspan=9 style='width:15%;border: 1px solid black;font-weight:bold'>IV. Hasil &<br>Rekonsiliasi Hasil<br>Pencampuran</td>
                    <td style='border: 1px solid black'>HASIL " . $product_description . "</td>
                    <td style='border: 1px solid black;width:10%'>Pelaksana</td>
                    <td style='border: 1px solid black;width:10%'>Pemeriksa</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>
                        Timbang tiap tong dengan timbangan, catat dalam form data label. Pasang label pada tiap tong. Kirim produk ruahan ke proses selanjutnya (pengemasan)<br>
                        <table cellpadding=2 cellspacing=0 style='width:50%'>
                            <tr style='border: 1px solid black'>
                                <td style='border: 1px solid black;font-weight:bold'>Nama bahan</td>
                                <td style='border: 1px solid black;font-weight:bold'>Jml Tong @40kg</td>
                                <td style='border: 1px solid black;font-weight:bold'>Sisa (Kg)</td>
                            </tr>
                            <tr style='border: 1px solid black'>
                                <td style='border: 1px solid black'>" . $product_description . "</td>
                                <td style='border: 1px solid black'>6</td>
                                <td style='border: 1px solid black'>" . $sisa . "</td>
                            </tr>
                        </table>
                    </td>
                    <td rowspan=5 style='border: 1px solid black;width:10%'></td>
                    <td rowspan=5 style='border: 1px solid black;width:10%'></td>
                </tr>
                <tr>
                    <td style='border: 1px solid black'>
                        <table cellpadding=2 cellspacing=0 >
                            <tr>
                                <td colspan=2 style='font-weight:bold'>REKONSILIASI</td>
                                <td colspan=2 style='font-weight:bold'>Keterangan</td>
                            </tr>
                            <tr>
                                <td>Hasil Teoritis</td>
                                <td>: 255 Kg</td>
                                <td>Hasil Nyata</td>
                                <td>: Hasil + Sampel Pengambilan QC</td>
                            </tr>
                            <tr>
                                <td>Hasil Nyata</td>
                                <td>: " . $berat . " Kg</td>
                                <td></td>
                                <td>Hasil Nyata(Kg)</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>: " . number_format($present_berat, 2) . " %</td>
                                <td></td>
                                <td>Hasil Teoritis(Kg)</td>
                            </tr>
                            <tr>
                                <td>Batas Hasil</td>
                                <td>: 97,0 - 105 %</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>Hasil Penyelidikan</td>
                </tr>
                <tr>
                    <td>Keputusan <img src='../../../asset/icon/rectangle.png'>OK <img src='../../../asset/icon/rectangle.png'>TIDAK OK</td>
                </tr>
                <tr style='border: 1px solid black;border-top:none !important'>
                    <td style='font-weight:bold;text-align:right'><i>(Lampirkan dokumen berkaitan)</i></td>
                </tr>
            </table>
            <table>
                <tr style='border: 1px solid black'>
                    <td rowspan=2 style='width:15%;border: 1px solid black;font-weight:bold'>V. Pemeriksaan</td>
                    <td style='border: 1px solid black'><li>Pemeriksaan dilakukan oleh IPC Unit Hasil pemeriksaan organoleptis LULUS beri tanda √, hasil TOLAK beri tanda x</td>
                </tr>
                <tr style='border: 1px solid black'>    
                    <td>
                        <table style='width:100%' cellpadding=2 cellspacing=0>
                            <thead>
                                <tr style='border: 1px solid black'>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Parameter</th>
                                    <th colspan=3 style='border: 1px solid black;text-align:center'>Hasil Pemeriksaan</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Keterangan Hasil TOLAK</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Pelaksana</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Pemeriksa</th>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <th style='border: 1px solid black;text-align:center'>Awal</th>
                                    <th style='border: 1px solid black;text-align:center'>Tengah</th>
                                    <th style='border: 1px solid black;text-align:center'>Akir</th>
                                </tr>";
    $kodeud = GetdataV('UDcode', 'usage_decision', 'Plant', $plant, 'UnitCode', $unitcode, 'InspectionLot', $inspectionlot, 'Lotyears', $lotyears, 'NoProses', 1);
    $usage_decision = Getdata('Descriptions', 'qc_catalog', 'KodeCatalog', $kodeud);
    $sql = mysqli_query($conn, "SELECT * FROM result_recording WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND 
                                                                    InspectionLot='$inspectionlot' AND 
                                                                    Lotyears='$lotyears' AND
                                                                    NoProses ='1'");
    $i = 1;
    while ($r = mysqli_fetch_array($sql)) {
        $result_awal = '';
        $result_tengah = '';
        $result_akhir = '';
        if ($r['Result_Awal'] == 'true') {
            $result_awal = '&#10003';
        }
        if ($r['Result_Tengah'] == 'true') {
            $result_tengah = '&#10003';
        }
        if ($r['Result_Akhir'] == 'true') {
            $result_akhir = '&#10003';
        }
        $name = explode(' ', Getnamakaryawan($r['CreatedBy']));
        $output3 .= "
                                <tr style='border: 1px solid black'>
                                    <td style='border: 1px solid black'>
                                        " . $i . ". <u>" . GetdataV('Descriptions', 'insp_pengolahan_detail', 'Plant', $plant, 'UnitCode', $unitcode, 'InspectionLot', $inspectionlot, 'Lotyears', $lotyears, 'MIC', $r['MIC']) . "</u><br>
                                        " . GetdataV('FullyDesc', 'insp_pengolahan_detail', 'Plant', $plant, 'UnitCode', $unitcode, 'InspectionLot', $inspectionlot, 'Lotyears', $lotyears, 'MIC', $r['MIC']) . "
                                    </td>
                                    <td style='border: 1px solid black;text-align:center'>" . $result_awal . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $result_tengah . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $result_akhir . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Ket_hasiltolak'] . "</td>
                                    <td style='border: 1px solid black'>" . $name[0] . "</td>
                                    <td style='border: 1px solid black'></td>
                                </tr>
";
        $i += 1;
    };
    $output3 .= "
                                <tr style='border: 1px solid black'>
                                    <td colspan=7 style='border: 1px solid black'>
                                        <p style='font-weight:normal'>KESIMPULAN (diisi LULUS / TOLAK)<br><h5 style='font-weight:bold;font-size:14pt'>" . strtoupper($usage_decision) . "</h5><p style='font-weight:normal'>Jika hasil tidak lulus, tunggu tindak lanjutndari IPC atau R&D</p>
                                        </p>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </td>
                </tr>
            </table>
            <table cellpadding=2 cellspacing=0 style='width:100%'>
                <tr style='border: 1px solid black'>
                    <td colspan=5 style='text-align:center;border: 1px solid black'>Dibuat oleh,</td>
                    <td colspan=5 style='text-align:center;border: 1px solid black'>Diperiksa oleh,</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td colspan=5 style='padding-bottom:3rem;border: 1px solid black'></td>
                    <td colspan=5 style='padding-bottom:3rem;border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>Nama</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>Jabatan</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>Tgl</td>
                    <td style='border: 1px solid black'>Nama</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>Jabatan</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>Tgl</td>
                </tr>
            </table>
        </div>
    </body>
</html>";
} else {
    $output2 = false;
    $output3 = false;
}

// ------------------------- PROSES 2----------------------------------------
$sql = mysqli_query($conn, "SELECT * FROM frm_approval WHERE Plant='$plant' AND
                                                            UnitCode='$unitcode' AND 
                                                            FormTypes ='preparepengolahan'");
if (mysqli_num_rows($sql) != 0) {
    $row = mysqli_fetch_array($sql);
    $pengawasproduksi = $row['OnePerson'];
    $ka_unit = $row['TwoPerson'];
    $man_qc = $row['ThreePerson'];
    $man_qa = $row['FourPerson'];

    $jab_pengawas = $row['OnePost'];
    $jab_ka = $row['TwoPost'];
    $jab_manqc = $row['ThreePost'];
    $jab_manqa = $row['FourPost'];

    $onedate = date('d-m-Y', strtotime($row['OneDate']));
    $twodate = date('d-m-Y', strtotime($row['TwoDate']));
    $threedate = date('d-m-Y', strtotime($row['ThreeDate']));
    $fourdate = date('d-m-Y', strtotime($row['FourDate']));
}

$sql = mysqli_query($conn, "SELECT * FROM planning_pengolahan_subdetail WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            ProductID='$productid' AND
                                                                            BatchNumber ='$batch' AND
                                                                            NoProses='2'");
if (mysqli_num_rows($sql) != 0) {
    $query = mysqli_query($conn, "SELECT A.Shift,B.ResourceIDMix,B.MixingDate,A.CreatedOn,B.ReffCode FROM planning_pengolahan_header AS A 
                                    INNER JOIN  planning_pengolahan_detail AS B
                                    ON A.PlanningNumber=B.PlanningNumber WHERE B.Plant='$plant' AND
                                                                            B.UnitCode='$unitcode' AND
                                                                            B.ProductID='$productid' AND
                                                                            B.BatchNumber LIKE '%$batch%'");
    $row = mysqli_fetch_array($query);
    $r = mysqli_fetch_array($sql);
    $resourceidmix = $row['ResourceIDMix'];
    $mixingdate = $row['MixingDate'];
    $shift = $row['Shift'];
    $createdon = date('d F Y', strtotime($row['CreatedOn']));
    $reffcode = $row['ReffCode'];
    // $planningnumber = $r['PlannningNumber'];
    $years = $r['Years'];
    $noproses = $r['NoProses'];

    $prepare_mixer = mysqli_query($conn, "SELECT * FROM proses_prepare_mixer WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            PlanningNumber='$r[PlanningNumber]' AND
                                                                            Years='$r[Years]' AND
                                                                            NoProses='$noproses' AND
                                                                            -- ProductID='$productid' AND
                                                                            BatchNumber='$batch'");
    if (mysqli_num_rows($prepare_mixer) != 0) {
        $show_mixer = mysqli_fetch_array($prepare_mixer);
        $operator_mixer1 = $show_mixer['Operator1'];
        $operator_mixer2 = $show_mixer['Operator2'];
        $operator_mixer3 = $show_mixer['Operator3'];
        $pengawas = $show_mixer['PengawasProduksi'];
        $parameter_mixer1 = $show_mixer['Parameter_1'];
        $parameter_mixer2 = $show_mixer['Parameter_2'];
        $parameter_mixer3 = $show_mixer['Parameter_3'];
        $parameter_mixer4 = $show_mixer['Parameter_4'];
        $parameter_mixer5 = $show_mixer['Parameter_5'];
        $parameter_mixer6 = $show_mixer['Parameter_6'];
        $parameter_mixer7 = $show_mixer['Parameter_7'];
        $parameter_mixer8 = $show_mixer['Parameter_8'];
        $parameter_mixer9 = $show_mixer['Parameter_9'];
        $parameter_mixer10 = $show_mixer['Parameter_10'];
        // $shift = GetdataIV('Shift', 'planning_pengolahan_header', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $show_mixer['PlanningNumber'], 'Years', $show_mixer['PlanningNumber']);
    }

    $output2_1 = "
    <!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='../../../asset/css/css_report.css'>
    </head>";
    $output2_1 .= "
    <body>
        <div class='container'>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%;font-weight:bold'><center><img src='../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                        <td rowspan=3 colspan=5 style='border: 1px solid black; text-align:center;width:50%'><p style='font-weight:bold'>CATATAN PENGOLAHAN BETS<br>" . $product_description . "</p></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center;font-weight:bold'>PRODUKSI</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center;font-weight:bold'>SERBUK INSTAN & SEDIAAN PANGAN</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%;border: 1px solid black'>No. Dokumen</td>
                        <td style='width:15%;border: 1px solid black'>FM-053050-04-04-002</td>
                        <td style='width:15%;border: 1px solid black'>No Revisi</td>
                        <td style='width:15%;border: 1px solid black'>09</td>
                        <td style='width:15%;border: 1px solid black'>Tanggal Berlaku</td>
                        <td style='width:15%;border: 1px solid black'>09 Oktober 2023</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%;border: 1px solid black'>Mengganti No.</td>
                        <td style='width:15%;border: 1px solid black'>FM-053050-04-04-002</td>
                        <td style='width:15%;border: 1px solid black'>No Revisi</td>
                        <td style='width:15%;border: 1px solid black'>08</td>
                        <td style='width:15%;border: 1px solid black'>Tanggal Berlaku</td>
                        <td style='width:15%;border: 1px solid black'>08 Oktober 2022</td>
                    </tr>
                </tbody>
            </table>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Disusun Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Diperiksa Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Diperiksa Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Disetujui Oleh</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $pengawasproduksi . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $ka_unit . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $man_qc . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $man_qa . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $jab_pengawas . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $jab_ka . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $jab_manqc . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $jab_manqa . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $onedate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $twodate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $threedate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $fourdate . "</td>
                    </tr>
                </tbody>
            </table>
            <table cellpadding=2 cellspacing=0 style='border: 1px solid black;'>
                <tr>
                    <td>Nama Produk</td>
                    <td>: " . $product_description . "</td>
                    <td style='width:30%'>&nbsp;</td>
                    <td>Rujukan</td>
                    <td>: Dokumen Produksi Induk No. DP-021020-08-12-030</td>
                </tr>
                <tr>
                    <td>Kode Formula</td>
                    <td>: F-81</td>
                    <td>&nbsp;</td>
                    <td>Ukuran Bets</td>
                    <td>: 255 Kg</td>
                </tr>
                <tr>
                    <td colspan=3>&nbsp;</td>
                    <td>Masa Kadaluarsa</td>
                    <td>: " . Getdata('TotalSelfLife', 'mara_product', 'ProductID', $productid) . " Bulan</td>
                </tr>
            </table>
            <table cellpadding=2 cellspacing=0 style='border: 1px solid black;'>
                <tr>
                    <td style='font-weight:bold'>Nama Operator</td>
                    <td style='font-weight:bold'>Nama & No Mesin</td>
                    <td style='font-weight:bold'>ED/No. Bets</td>
                    <td style='font-weight:bold'>No. Proses</td>
                    <td style='font-weight:bold'>Hari/Tgl</td>
                    <td>: " . $createdon . "</td>
                </tr>
                <tr>
                    <td>1. " . $operator_mixer1 . "</td>
                    <td rowspan=3>" . $resourceidmix . "</td>
                    <td rowspan=3>" . $expdate . "/<br>" . $batch . "</td>
                    <td rowspan=3>" . $noproses . "</td>
                    <td style='font-weight:bold'>Shift</td>
                    <td>: " . $shift . "</td>
                </tr>
                <tr>
                    <td>2. " . $operator_mixer2 . "</td>
                    <td style='font-weight:bold'>Jam Mulai</td>
                    <td>: <i>Jam Mulai</i></td>
                </tr>
                <tr>
                    <td>3. " . $operator_mixer3 . "</td>
                    <td style='font-weight:bold'>Jam Selesai</td>
                    <td>: <i>Jam Selesai</i></td>
                </tr>
            </table>
            <table cellpadding=2 cellspacing=0 style='border: 1px solid black;'>
                <tr>
                    <td rowspan=2 style='vertical-align: top;'>Perhatian</td>
                    <td>
                        : Apabila terjadi penyimpangan terhadap suatu ketetapan laporkan dan tangani sesuai Prosedur Tindakan Perbaikan dan Pencegahan
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;No. PS-020000-01-00-004 </td>
                </tr>
            </table>
            <table cellpadding=2 cellspacing=0 style='border: 1px solid black;'>
                <tr style='border: 1px solid black;'>
                    <td colspan=4>. Gunakan APD sesuai standard, pelindung pernapasan (masker) dan pakai sarung tangan</td>
                </tr>
                <tr style='border: 1px solid black;'>
                    <td style='border: 1px solid black;width:15%'>
                        <table cellpadding=2 cellspacing=0>
                            <tr>
                                <td style='font-weight:bold'>I. Persiapan Bahan<br>Tgl : <i>14.06</i></td>
                            </tr>
                        </table>
                    </td>
                    <td colspan=3>
                        <table cellpadding=2 cellspacing=0>
                            <tr>
                                <td style='font-weight:bold;width:16%'>Kode Bahan</td>
                                <td style='font-weight:bold;width:16%'>Jml Teoritis</td>
                                <td style='font-weight:bold;width:16%'>Jml Nyata</td>
                                <td style='font-weight:bold;width:16%'>Tanggal</td>
                                <td style='font-weight:bold;width:16%'>No. Identitas</td>
                                <td style='font-weight:bold;width:10%'>Pelaksana</td>
                                <td style='font-weight:bold;width:10%'>Pemeriksa</td>
                            </tr>";
    $sql = mysqli_query($conn, "SELECT * FROM tb_headerbahanpengolahan WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            ProductID='$productid' AND
                                                                            BatchNumber='$batch' AND
                                                                            NoProses='$noproses'");
    while ($r = mysqli_fetch_array($sql)) {
        $d = mysqli_query($conn, "SELECT NoIdentitas FROM tb_detailbahanpengolahan WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            PlanningNumber='$r[PlanningNumber]' AND
                                                                            Years='$r[Years]' AND
                                                                            ProductID='$productid' AND
                                                                            BatchNumber='$batch' AND
                                                                            BatchLabel='$r[BatchLabel]' AND
                                                                            KodeBahan='$r[KodeBahan]' AND
                                                                            NoProses='$noproses'");
        $show_d = mysqli_fetch_array($d);
        $output2_1 .= "
                            <tr>
                                <td>" . $r['KodeBahan'] . "</td>
                                <td>" . $r['JmlTeoritis'] . "</td>
                                <td>" . $r['JmlNyata'] . "</td>
                                <td>" . date('d-M-Y', strtotime($r['CreatedOn']))  . "</td>
                                <td>" . $show_d['NoIdentitas'] . "</td>
                                <td>" . $r['CreatedBy'] . "</td>
                                <td></td>
                            </tr>";
    }
    $output2_1 .= "
                        </table>
                    </td>
                </tr>
            </table>
            <table cellpadding=2 cellspacing=0>
                <tr style='border: 1px solid black'>
                    <td rowspan=13 style='width:15%;font-weight:bold'>II. Daftar Periksa<br>Kesiapan<br>Pencampuran<br>Serbuk</td>
                    <td colspan=7 style='border: 1px solid black;font-weight:bold'>CATATAN: DALAM RUANGAN TIDAK BOLEH ADA PRODUK SELAIN YANG AKAN DIKERJAKAN</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td colspan=2 rowspan=2 style='border: 1px solid black;width:50%;font-weight:bold;text-align:center'> Uraian Pemeriksaan</td>
                    <td rowspan=2 style='border: 1px solid black;width:10%;font-weight:bold;text-align:center'>Hasil Periksa</td>
                    <td colspan=2 style='border: 1px solid black;width:15%;font-weight:bold;text-align:center'>Pelaksana</td>
                    <td colspan=2 style='border: 1px solid black;width:15%;font-weight:bold;text-align:center'>Pemeriksa</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black;width:10%;font-weight:bold;text-align:center'>Nama</td>
                    <td style='border: 1px solid black;width:10%;font-weight:bold;text-align:center'>Paraf</td>
                    <td style='border: 1px solid black;width:10%;font-weight:bold;text-align:center'>Nama</td>
                    <td style='border: 1px solid black;width:10%;font-weight:bold;text-align:center'>Paraf</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black;width:2%'>a.</td>
                    <td style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'Jenisproses', 'preparepengolahan', 'Item', 1) . "</td>
                    <td style='border: 1px solid black'>" . $parameter_mixer1 . "</td>
                    <td style='border: 1px solid black'>" . $operator_mixer1 . "</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>" . $pengawas . "</td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>b.</td>
                    <td style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'Jenisproses', 'preparepengolahan', 'Item', 2) . "</td>
                    <td style='border: 1px solid black'>" . $parameter_mixer2 . "</td>
                    <td style='border: 1px solid black'>" . $operator_mixer1 . "</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>" . $pengawas . "</td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>c.</td>
                    <td style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'Jenisproses', 'preparepengolahan', 'Item', 3) . "</td>
                    <td style='border: 1px solid black'>" . $parameter_mixer3 . "</td>
                    <td style='border: 1px solid black'>" . $operator_mixer1 . "</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>" . $pengawas . "</td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>d.</td>
                    <td style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'Jenisproses', 'preparepengolahan', 'Item', 4) . "</td>
                    <td style='border: 1px solid black'>" . $parameter_mixer4 . "</td>
                    <td style='border: 1px solid black'>" . $operator_mixer1 . "</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>" . $pengawas . "</td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>e.</td>
                    <td style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'Jenisproses', 'preparepengolahan', 'Item', 5) . "</td>
                    <td style='border: 1px solid black'>" . $parameter_mixer5 . "</td>
                    <td style='border: 1px solid black'>" . $operator_mixer1 . "</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>" . $pengawas . "</td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>f.</td>
                    <td style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'Jenisproses', 'preparepengolahan', 'Item', 6) . "</td>
                    <td style='border: 1px solid black'>" . $parameter_mixer6 . "</td>
                    <td style='border: 1px solid black'>" . $operator_mixer1 . "</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>" . $pengawas . "</td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>g.</td>
                    <td style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'Jenisproses', 'preparepengolahan', 'Item', 7) . "</td>
                    <td style='border: 1px solid black'>" . $parameter_mixer7 . "</td>
                    <td style='border: 1px solid black'>" . $operator_mixer1 . "</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>" . $pengawas . "</td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>h.</td>
                    <td style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'Jenisproses', 'preparepengolahan', 'Item', 8) . "</td>
                    <td style='border: 1px solid black'>" . $parameter_mixer8 . "</td>
                    <td style='border: 1px solid black'>" . $operator_mixer1 . "</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>" . $pengawas . "</td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>i.</td>
                    <td style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'Jenisproses', 'preparepengolahan', 'Item', 9) . "</td>
                    <td style='border: 1px solid black'>" . $parameter_mixer9 . "</td>
                    <td style='border: 1px solid black'>" . $operator_mixer1 . "</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>" . $pengawas . "</td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>j.</td>
                    <td style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'Jenisproses', 'preparepengolahan', 'Item', 10) . "</td>
                    <td style='border: 1px solid black'>" . $parameter_mixer10 . "</td>
                    <td style='border: 1px solid black'>" . $operator_mixer1 . "</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>" . $pengawas . "</td>
                    <td style='border: 1px solid black'></td>
                </tr>
            </table>
            <table>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black;width:15%;font-weight:bold'>III. Pencampuran<br>Kering</td>
                    <td>
                        <table cellpadding=2 cellspacing=0 style='width:70%'>
                            <tr>
                                <td colspan=6>a. " . GetdataIV('Descriptions', 'md_proses_mixer', 'Plant', $plant, 'UnitCode', $unitcode, 'ProductID', $productid, 'Items', 1) . "</td>
                            </tr>
                            <tr style='border: 1px solid black;'>
                                <td style='text-align:center;border: 1px solid black;font-weight:bold'>Bahan</td>
                                <td style='text-align:center;border: 1px solid black;font-weight:bold'>Jumlah</td>
                                <td style='text-align:center;border: 1px solid black;font-weight:bold'>Satuan</td>
                                <td style='text-align:center;border: 1px solid black;font-weight:bold'>(√)</td>
                            </tr>
                            ";
    $sql = mysqli_query($conn, "SELECT * FROM tb_detailprosesmixing WHERE Plant='$plant' AND
                                                                            UnitCode='$unitcode' AND
                                                                            -- PlanningNumber='$planningnumber' AND
                                                                            -- Years='$years' AND
                                                                            ReffCode='$reffcode' AND
                                                                            ProductID='$productid' AND
                                                                            Proses='1' AND
                                                                            NoProses='$noproses'");
    while ($r = mysqli_fetch_array($sql)) {
        $status = '';
        if ($r['Jumlah'] == $r['UsedTo']) {
            $status = '(√)';
        }
        $output2_1 .= "
                            <tr style='border: 1px solid black;'>
                                <td style='border: 1px solid black;'>" . $r['KodeBahan'] . "</td>
                                <td style='border: 1px solid black;text-align:center'>" . $r['Jumlah'] . "</td>
                                <td style='border: 1px solid black;'>" . $r['Satuan'] . "</td>
                                <td style='border: 1px solid black;text-align:center'>" . $status . "</td>
                            </tr>";
    }
    $output2_1 .= "
                        </table>
                    </td>
                    <td style='text-align:center;border: 1px solid black;font-weight:bold;vertical-align:top;width:10%'>Pelaksana</td>
                    <td style='text-align:center;border: 1px solid black;font-weight:bold;vertical-align:top;width:10%'>Pemeriksa</td>
                </tr>
            </table>
        </div>
    </body>
</html>";

    // *****************************************************************
    // -------> Proses Mixing <------
    // *****************************************************************
    $sql = mysqli_query($conn, "SELECT * FROM frm_approval WHERE Plant='$plant' AND
                                                            UnitCode='$unitcode' AND 
                                                            FormTypes ='prosespengolahan'");
    if (mysqli_num_rows($sql) != 0) {
        $row = mysqli_fetch_array($sql);
        $pengawasproduksi = $row['OnePerson'];
        $ka_unit = $row['TwoPerson'];
        $man_qc = $row['ThreePerson'];
        $man_qa = $row['FourPerson'];

        $jab_pengawas = $row['OnePost'];
        $jab_ka = $row['TwoPost'];
        $jab_manqc = $row['ThreePost'];
        $jab_manqa = $row['FourPost'];

        $onedate = date('d-m-Y', strtotime($row['OneDate']));
        $twodate = date('d-m-Y', strtotime($row['TwoDate']));
        $threedate = date('d-m-Y', strtotime($row['ThreeDate']));
        $fourdate = date('d-m-Y', strtotime($row['FourDate']));
    }

    $noproses = 1;
    $sql = mysqli_query($conn, "SELECT * FROM insp_pengolahan_detail WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND 
                                                                            ProductID='$productid' AND 
                                                                            BatchNumber='$batch'");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $inspectionlot = $r['InspectionLot'];
        $lotyears = $r['Lotyears'];
    }

    $output3_1 .= "
<!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='../../../asset/css/css_report.css'>
    </head>";

    $output3_1 .= "
<body>
        <div class='container'>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%;font-weight:bold'><center><img src='../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                        <td rowspan=3 colspan=5 style='border: 1px solid black;font-weight:bold; text-align:center;width:50%'>CATATAN PENGOLAHAN BETS<br>" . $product_description . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center;font-weight:bold'>PRODUKSI</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center;font-weight:bold'>SERBUK INSTAN &<br>SEDIAAN PANGAN</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%;border: 1px solid black'>No. Dokumen</td>
                        <td style='width:15%;border: 1px solid black'>FM-053050-04-04-002</td>
                        <td style='width:15%;border: 1px solid black'>No Revisi</td>
                        <td style='width:15%;border: 1px solid black'>09</td>
                        <td style='width:15%;border: 1px solid black'>Tanggal Berlaku</td>
                        <td style='width:15%;border: 1px solid black'>09 Oktober 2023</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%;border: 1px solid black'>Mengganti No.</td>
                        <td style='width:15%;border: 1px solid black'>FM-053050-04-04-002</td>
                        <td style='width:15%;border: 1px solid black'>No Revisi</td>
                        <td style='width:15%;border: 1px solid black'>08</td>
                        <td style='width:15%;border: 1px solid black'>Tanggal Berlaku</td>
                        <td style='width:15%;border: 1px solid black'>08 Oktober 2022</td>
                    </tr>
                </tbody>
            </table>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Disusun Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Diperiksa Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Diperiksa Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Disetujui Oleh</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $pengawasproduksi . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $ka_unit . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $man_qc . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $man_qa . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $jab_pengawas . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $jab_ka . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $jab_manqc . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $jab_manqa . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $onedate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $twodate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $threedate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $fourdate . "</td>
                    </tr>
                </tbody>
            </table>
            <table cellpadding=2 cellspacing=0>
                <tr style='border: 1px solid black'>
                    <td rowspan=9 style='width:15%;border: 1px solid black'></td>
                    <td colspan=2 style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>Pelaksana</td>
                    <td style='border: 1px solid black'>Pemeriksa</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='width:2%'>b.</td>
                    <td>Nyalakan aiator Mixer selama 2 menit dengan kecepatan blade 75rpm dan chopper 'On' campur hingga homogen Waktu: 2 menit</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='width:2%'>c.</td>
                    <td>Ayak C LSJ3 secara manual menggunakan ayakan mesh 18, tampung dalam wadah yang sudah tersedia</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='width:2%'>d.</td>
                    <td>
                        Masukan CLSJ3 yang lolos mesh 18 dan tambahkan SJ jika ada kedalam mesin mixer<br>
                        <table style='width:50%'>
                            <tr style='border: 1px solid black'>
                                <td style='border: 1px solid black;text-align:center;font-weight:bold'>Bahan</td>
                                <td style='border: 1px solid black;text-align:center;font-weight:bold'>Jumlah</td>
                                <td style='border: 1px solid black;text-align:center;font-weight:bold'>Satuan</td>
                                <td style='border: 1px solid black;text-align:center;font-weight:bold'>(√)</td>
                            </tr>";
    $mix_proses2 = mysqli_query($conn, "SELECT * FROM tb_detailprosesmixing WHERE Plant='$plant' AND
                                                                                UnitCode='$unitcode' AND
                                                                                ProductID='$productid' AND
                                                                                NoProses='1' AND
                                                                                Proses='2' AND
                                                                                ReffCode='$reffcode'");
    while ($show_mix_proses2 = mysqli_fetch_array($mix_proses2)) {
        if ($show_mix_proses2['Jumlah'] == $show_mix_proses2['UsedTo']) {
            $status = '(√)';
        }

        $output3_1 .= "                                                       
                            <tr style='border: 1px solid black'>
                                <td style='border: 1px solid black;text-align:center'>" . $show_mix_proses2['KodeBahan'] . "</td>
                                <td style='border: 1px solid black;text-align:center'>" . $show_mix_proses2['Jumlah'] . "</td>
                                <td style='border: 1px solid black;text-align:center'>Kantong</td>
                                <td style='border: 1px solid black;text-align:center'>" . $status . "</td>
                            </tr>";
    }
    $output3_1 .= "
                            <tr style='border: 1px solid black'>
                                <td style='border: 1px solid black;text-align:center'>Tamb. Susu Jahe</td>
                                <td style='border: 1px solid black;text-align:center'>-</td>
                                <td style='border: 1px solid black;text-align:center'>Kantong</td>
                                <td style='border: 1px solid black;text-align:center'>-</td>
                            </tr>
                        </table>
                    </td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='width:2%'>e.</td>
                    <td>
                        Pastikan setelah bahan dimasukan plastik waduh bahan dalam kondisi utuh dan rapikan sebelum dikumpulkan<br>
                        
                        <table style='width:50%'>
                            <tr>
                                <td colspan=3 style='text-align:center;font-weight:bold'><h5 >KONDISI BAHAN KEMAS</h5></td>
                            </tr>";
    $output3_1 .= "
                            <tr>
                                <td rowspan=2>Plastik</td>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber, $years, $productid, $batch, 2, "Par1_1") . " Jumlah sesuai</td>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber, $years, $productid, $batch, 2, "Par1_2") . " Utuh</td>
                            </tr>
                            <tr>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber, $years, $productid, $batch, 2, "Par1_3") . " Jumlah tidak sesuai</td>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber, $years, $productid, $batch, 2, "Par1_4") . " tidak Utuh</td>
                            </tr>
                            <tr>
                                <td rowspan=2>Rafia</td>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber, $years, $productid, $batch, 2, "Par2_1") . " Jumlah sesuai</td>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber, $years, $productid, $batch, 2, "Par2_2") . " Utuh</td>
                            </tr>
                            <tr>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber, $years, $productid, $batch, 2, "Par2_3") . " Jumlah tidak sesuai</td>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber, $years, $productid, $batch, 2, "Par2_4") . " tidak Utuh</td>
                            </tr>
                            <tr>
                                <td rowspan=2>Label Bahan</td>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber, $years, $productid, $batch, 2, "Par3_1") . " Jumlah sesuai</td>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber, $years, $productid, $batch, 2, "Par3_2") . " Utuh</td>
                            </tr>
                            <tr>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber, $years, $productid, $batch, 2, "Par3_3") . " Jumlah tidak sesuai</td>
                                <td>" . cekparameter($plant, $unitcode, $planningnumber, $years, $productid, $batch, 2, "Par3_4") . " tidak Utuh</td>
                            </tr>
                        </table>
                    </td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='width:2%'>f.</td>
                    <td>Nyalakan agiator mixer selama 4 menit kecepatan blade 75rpm dan chopper 'On', campur hingga homogen waktu: 4 menit</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='width:2%'>g.</td>
                    <td>keluarkan serbuk hasil pencampuran dan tampung dalam tong yang sudah diberi plastik</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='width:2%'>h.</td>
                    <td>Ambil sampel ditong ke 1,4 dan 7 oleh IPC sebanyak ± 130gr(3 sendok)</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='width:2%'>i.</td>
                    <td>Timbang hasil dalam tong @40kg kemudian ikat plastik dan tong ditutup</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'></td>
                </tr>
            </table>";
    $sisa = '';
    $berat = '';
    $present_berat = '';
    $showhasiltimbang = mysqli_query($conn, "SELECT * FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND
                                                                                                UnitCode='$unitcode' AND
                                                                                                PlanningNumber='$planningnumber_pengolahan' AND
                                                                                                Years='$years' AND
                                                                                                Items='$items' AND
                                                                                                ProductID='$productid' AND
                                                                                                BatchNumber='$batch' AND
                                                                                                NoProses='2' ORDER BY NoTong DESC");
    if (mysqli_num_rows($showhasiltimbang) != 0) {
        $r = mysqli_fetch_array($showhasiltimbang);
        $sisa = $r['Berat'];

        $showhasiltimbang2 = mysqli_query($conn, "SELECT SUM(Berat) AS B FROM tbl_hasiltimbang_detail WHERE Plant='$plant' AND
                                                                                                UnitCode='$unitcode' AND
                                                                                                PlanningNumber='$planningnumber_pengolahan' AND
                                                                                                Years='$years' AND
                                                                                                Items='$items' AND
                                                                                                ProductID='$productid' AND
                                                                                                BatchNumber='$batch' AND
                                                                                                NoProses='2'");
        $sum_berat = mysqli_fetch_array($showhasiltimbang2);
        $berat = $sum_berat['B'];
        $present_berat = $berat / 255 * 100;
    }
    $output3_1 .= "
            <table>
                <tr style='border: 1px solid black'>
                    <td rowspan=9 style='width:15%;border: 1px solid black;font-weight:bold'>IV. Hasil &<br>Rekonsiliasi Hasil<br>Pencampuran</td>
                    <td style='border: 1px solid black'>HASIL " . $product_description . "</td>
                    <td style='border: 1px solid black;width:10%'>Pelaksana</td>
                    <td style='border: 1px solid black;width:10%'>Pemeriksa</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>
                        Timbang tiap tong dengan timbangan, catat dalam form data label. Pasang label pada tiap tong. Kirim produk ruahan ke proses selanjutnya (pengemasan)<br>
                        <table cellpadding=2 cellspacing=0 style='width:50%'>
                            <tr style='border: 1px solid black'>
                                <td style='border: 1px solid black;font-weight:bold'>Nama bahan</td>
                                <td style='border: 1px solid black;font-weight:bold'>Jml Tong @40kg</td>
                                <td style='border: 1px solid black;font-weight:bold'>Sisa (Kg)</td>
                            </tr>
                            <tr style='border: 1px solid black'>
                                <td style='border: 1px solid black'>" . $product_description . "</td>
                                <td style='border: 1px solid black'>6</td>
                                <td style='border: 1px solid black'>" . $sisa . "</td>
                            </tr>
                        </table>
                        </td>
                    <td rowspan=5 style='border: 1px solid black;width:10%'></td>
                    <td rowspan=5 style='border: 1px solid black;width:10%'></td>
                </tr>
                <tr>
                    <td style='border: 1px solid black'>
                        <table cellpadding=2 cellspacing=0 >
                            <tr>
                                <td colspan=2 style='font-weight:bold'>REKONSILIASI</td>
                                <td colspan=2 style='font-weight:bold'>Keterangan</td>
                            </tr>
                            <tr>
                                <td>Hasil Teoritis</td>
                                <td>: 255 Kg</td>
                                <td>Hasil Nyata</td>
                                <td>: Hasil + Sampel Pengambilan QC</td>
                            </tr>
                            <tr>
                                <td>Hasil Nyata</td>
                                <td>: " . $berat . " Kg</td>
                                <td></td>
                                <td>Hasil Nyata(Kg)</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>: " . number_format($present_berat, 2) . " %</td>
                                <td></td>
                                <td>Hasil Teoritis(Kg)</td>
                            </tr>
                            <tr>
                                <td>Batas Hasil</td>
                                <td>: 97,0 - 105 %</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>Hasil Penyelidikan</td>
                </tr>
                <tr>
                    <td>Keputusan <img src='../../../asset/icon/rectangle.png'>OK <img src='../../../asset/icon/rectangle.png'>TIDAK OK</td>
                </tr>
                <tr style='border: 1px solid black;border-top:none !important'>
                    <td style='font-weight:bold;text-align:right'><i>(Lampirkan dokumen berkaitan)</i></td>
                </tr>
            </table>
            <table>
                <tr style='border: 1px solid black'>
                    <td rowspan=2 style='width:15%;border: 1px solid black;font-weight:bold'>V. Pemeriksaan</td>
                    <td style='border: 1px solid black'><li>Pemeriksaan dilakukan oleh IPC Unit Hasil pemeriksaan organoleptis LULUS beri tanda √, hasil TOLAK beri tanda x</td>
                </tr>
                <tr style='border: 1px solid black'>    
                    <td>
                        <table style='width:100%' cellpadding=2 cellspacing=0>
                            <thead>
                                <tr style='border: 1px solid black'>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Parameter</th>
                                    <th colspan=3 style='border: 1px solid black;text-align:center'>Hasil Pemeriksaan</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Keterangan Hasil TOLAK</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Pelaksana</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Pemeriksa</th>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <th style='border: 1px solid black;text-align:center'>Awal</th>
                                    <th style='border: 1px solid black;text-align:center'>Tengah</th>
                                    <th style='border: 1px solid black;text-align:center'>Akir</th>
                                </tr>";
    $kodeud = GetdataV('UDcode', 'usage_decision', 'Plant', $plant, 'UnitCode', $unitcode, 'InspectionLot', $inspectionlot, 'Lotyears', $lotyears, 'NoProses', 1);
    $usage_decision = Getdata('Descriptions', 'qc_catalog', 'KodeCatalog', $kodeud);
    $sql = mysqli_query($conn, "SELECT * FROM result_recording WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND 
                                                                    InspectionLot='$inspectionlot' AND 
                                                                    Lotyears='$lotyears' AND
                                                                    NoProses ='2'");
    $i = 1;
    while ($r = mysqli_fetch_array($sql)) {
        $result_awal = '';
        $result_tengah = '';
        $result_akhir = '';
        if ($r['Result_Awal'] == 'true') {
            $result_awal = '&#10003';
        }
        if ($r['Result_Tengah'] == 'true') {
            $result_tengah = '&#10003';
        }
        if ($r['Result_Akhir'] == 'true') {
            $result_akhir = '&#10003';
        }
        $name = explode(' ', Getnamakaryawan($r['CreatedBy']));
        $output3_1 .= "
                                <tr style='border: 1px solid black'>
                                    <td style='border: 1px solid black'>
                                        " . $i . ". <u>" . GetdataV('Descriptions', 'insp_pengolahan_detail', 'Plant', $plant, 'UnitCode', $unitcode, 'InspectionLot', $inspectionlot, 'Lotyears', $lotyears, 'MIC', $r['MIC']) . "</u><br>
                                        " . GetdataV('FullyDesc', 'insp_pengolahan_detail', 'Plant', $plant, 'UnitCode', $unitcode, 'InspectionLot', $inspectionlot, 'Lotyears', $lotyears, 'MIC', $r['MIC']) . "
                                    </td>
                                    <td style='border: 1px solid black;text-align:center'>" . $result_awal . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $result_tengah . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $result_akhir . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Ket_hasiltolak'] . "</td>
                                    <td style='border: 1px solid black'>" . $name[0] . "</td>
                                    <td style='border: 1px solid black'></td>
                                </tr>
";
        $i += 1;
    };
    $output3_1 .= "
                                <tr style='border: 1px solid black'>
                                    <td colspan=7 style='border: 1px solid black'>
                                        <p style='font-weight:normal'>KESIMPULAN (diisi LULUS / TOLAK)<br><h5 style='font-weight:bold;font-size:14pt'>" . strtoupper($usage_decision) . "</h5><p style='font-weight:normal'>Jika hasil tidak lulus, tunggu tindak lanjutndari IPC atau R&D</p>
                                        </p>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </td>
                </tr>
            </table>
            <table cellpadding=2 cellspacing=0 style='width:100%'>
                <tr style='border: 1px solid black'>
                    <td colspan=5 style='text-align:center;border: 1px solid black'>Dibuat oleh,</td>
                    <td colspan=5 style='text-align:center;border: 1px solid black'>Diperiksa oleh,</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td colspan=5 style='padding-bottom:3rem;border: 1px solid black'></td>
                    <td colspan=5 style='padding-bottom:3rem;border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>Nama</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>Jabatan</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>Tgl</td>
                    <td style='border: 1px solid black'>Nama</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>Jabatan</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>Tgl</td>
                </tr>
            </table>
        </div>
    </body>
</html>";
} else {
    $output2_1 = false;
    $output3_1 = false;
}

// *****************************************************************
// // ------>Proses Hoper <------
// *****************************************************************
if ($proseshoper == 'X') {
    $sql = mysqli_query($conn, "SELECT * FROM frm_approval WHERE UnitCode='$unitcode' AND FormTypes ='proseshoper'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_array($sql);
        $person1 = $row['OnePerson'];
        $person2 = $row['TwoPerson'];
        $person3 = $row['ThreePerson'];
        $person4 = $row['FourPerson'];

        $person1_post = $row['OnePost'];
        $person2_post = $row['TwoPost'];
        $person3_post = $row['ThreePost'];
        $person4_post = $row['FourPost'];

        $onedate = date('d-m-Y', strtotime($row['OneDate']));
        $twodate = date('d-m-Y', strtotime($row['TwoDate']));
        $threedate = date('d-m-Y', strtotime($row['ThreeDate']));
        $fourdate = date('d-m-Y', strtotime($row['FourDate']));
    }

    $sql = mysqli_query($conn, "SELECT * FROM transaksi_hoper WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                    AND PlanningNumber='$planningnumber'
                                                                                    AND Years='$years'");
    if (mysqli_num_rows($sql) != 0) {
        $row = mysqli_fetch_array($sql);
        $operator = Getnamakaryawan($row['CreatedBy']);
        $tanggal = date('d/m', strtotime($row['CreatedOn']));
        $operator_preparehoper1 = Getdata('Operator1', 'proses_prepare', 'PlanningNumber', $planningnumber);
        $operator_preparehoper2 = Getdata('Operator2', 'proses_prepare', 'PlanningNumber', $planningnumber);
        $operator_preparehoper = $operator_preparehoper1 . ', ' . $operator_preparehoper2;
        $pp = explode(' ', $row['PengawasProduksi']);
        $pengawas = $row['PengawasProduksi'];
        $createdon = date('d/m/Y', strtotime($row['CreatedOn']));
        $createdby = $row['CreatedBy'];
        $createby_proseshoper = Getdata('PersonnelNumber', 'usr02', 'UserID', $row['CreatedBy']);
        $createby_proseshoper = Getdata('EmployeeName', 'pa001', 'PersonnelNumber ', $createby_proseshoper);
        $createby_proseshoper = explode(' ', $createby_proseshoper);
        $createby_proseshoper = $createby_proseshoper[0];
    }

    $sql_loop = mysqli_query($conn, "SELECT * FROM transaksi_hoper WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                        AND PlanningNumber ='$planningnumber'
                                                                                        AND Years='$years'");
    $output4 = "
    <!doctype html>
    <html lang='en'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='../../../asset/css/css_report.css'>
    </head>";
    $output4 .= "
    <body>
        <div class='container'>
            <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%'><center><img src='../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                        <td style='border: 1px solid black;font-weight:bold; text-align:center' rowspan=3>CATATAN PENGEMASAN BETS <br> PRIMER - SEKUNDER</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center'>PRODUKSI " . $planningnumber . $years . $plant . $unitcode . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center'>SERBUK INSTAN & <br> SEDIA PANGAN</td>
                    </tr>
                </tbody>
            </table>
            <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;width:15%;'>No Dokumen</td>
                        <td style='border: 1px solid black;width:20%;'>FM-053050-05-00-002</td>
                        <td style='border: 1px solid black;width:15%;'>No Revisi</td>
                        <td style='border: 1px solid black;width:10%;'>01</td>
                        <td style='border: 1px solid black;width:15%;'>Tanggal Berlaku</td>
                        <td style='border: 1px solid black;width:25%;'>01 Juli 2023</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Mengganti No</td>
                        <td style='border: 1px solid black'>FM-053050-05-00-002</td>
                        <td style='border: 1px solid black'>No Revisi</td>
                        <td style='border: 1px solid black'>00</td>
                        <td style='border: 1px solid black'>Tanggal Berlaku</td>
                        <td style='border: 1px solid black'>0 Februari 2022</td>
                    </tr>
                </tbody>
            </table>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Disusun Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Diperiksa Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Diperiksa Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Disetujui Oleh</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $person1 . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $person2 . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $person3 . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $person4 . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $person1_post . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $person2_post . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $person3_post . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $person4_post . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $onedate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $twodate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $threedate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $fourdate . "</td>
                    </tr>
                </tbody>
            </table>
            <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr>
                        <td style='border: 1px solid black' rowspan=6 style='width:15%;border: 1px solid black'>II. Catatan Penuanangan Produk Ruahan<br>Tgl: " . $packingdate . "</td>
                        <td style='width: 15%;'>Nama Produk</td>
                        <td style='width: 15%;'>ED/No Bets</td>
                        <td style='width: 15%;'>Nama Operator</td>
                        <td style='width: 20%;'>Nama & No Mesin</td>
                        <td style='width: 20%;'>Shift</td>
                    </tr>
                    <tr>
                        <td style='text-align:center;padding-bottom:1rem;'>" . $produkname . "</td>
                        <td style='text-align:center;padding-bottom:1rem;'>" . $expdate . " <br>" . $batch . "</td>
                        <td style='text-align:center;padding-bottom:1rem;'>" . $operator_preparehoper . "</td>
                        <td style='text-align:center;padding-bottom:1rem;'>" . Getdata('PrimaryResourceID', 'crhd', 'ResourceID', $resourceid) . "</td>
                        <td style='text-align:center;padding-bottom:1rem;'>" . Getdata('ShiftDescriptions', 'shifts', 'ShiftID ', $shiftid) . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='vertical-align: text-top;width:5%'>Perhatian</td>
                        <td colspan=4 >
                            <li> Apabila terjadi penyimpangan terhadap suatu ketetapan dilaporkan dan tangani sesuai prosedur tindakan perbaikan dan pencegahan No PS-020000-01-00-004</li>
                            <li>Gunakan APD sesuai standar pelindung pernapasan (masker), sarung tangan wol dan sarung tangan karet diperiksa oleh .......... (paraf).......</li>
                        </td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 rowspan=3 style='border: 1px solid black'>
                            <ol>
                                <li>Periksa kebenaran produk ruahan yag akan dibuang kedalam Hopper<br>Pastikan identitas Produk & Nomor Bets sesuai dengan planning pengemasan primer</li>
                                <li>Lakukan pengayakan serbuk sebelum dituang ke dalam hopper mesh: ....</li>
                                <li>Pastikan sisa serbuk yang menempel pada mulut hopper melewati ayakan dan bersihkan sisa serbuk pada badan mesin dan lantai (waste)</li> 
                            </ol>
                        </td>
                        <td style='border: 1px solid black;text-align:center;width:10%'>Pelaksana</td>
                        <td style='border: 1px solid black;text-align:center;width:10%'>Pemeriksa</td>
                    </tr>
                    <tr>
                        <td style='border: 1px solid black;text-align:center;'>" . $createby_proseshoper . "</td>
                        <td style='border: 1px solid black;text-align:center;'>" . $pp[0] . "</td>
                    </tr>
                    <tr>
                        <td style='border: 1px solid black;text-align:center;'>" . $createby_proseshoper . "</td>
                        <td style='border: 1px solid black;text-align:center;'>" . $pp[0] . "</td>
                    </tr>
                </tbody>
            </table>
            <table style='border: 1px solid black;margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black;text-align:center'>
                        <td colspan='6' style='border: 1px solid black;text-align:center;font-weight:bold'>Penuangan Bahan</td>
                        <td colspan='6' style='border: 1px solid black;text-align:center;font-weight:bold'>Pengecekan Hasil Ayak</td>
                    </tr>
                    <tr>
                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>Tgl<br>PCM</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>Jam</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>No<br>Proses</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>No<br>Tong</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>Berat<br>(Kg)</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>No<br>Mixer</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>Kondisi<br>Ayakan</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center;font-weight:bold' >Kontaminasi</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>Temuan</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>PP</td>
                    </tr>
                    <tr style='border: 1px solid black;'>
                        <td style='border: 1px solid black;text-align:center;font-weight:bold'>Ya</td>
                        <td style='border: 1px solid black;text-align:center;font-weight:bold'>Tidak</td>
                        <td style='border: 1px solid black;text-align:center;font-weight:bold'>Jenis</td>
                        <td style='border: 1px solid black;text-align:center;font-weight:bold'>Jumlah</td>
                    </tr>";
    while ($q = mysqli_fetch_array($sql_loop)) {
        $kontaminasi_ya = '';
        $kontaminasi_tidak = '&#10003;';
        if ($q['Kontaminasi'] == 'Ya') {
            $kontaminasi_ya = '&#10003;';
            $kontaminasi_tidak = '';
        }
        if ($q['KondisiAyakan'] == 'Tidak sobek, tidak ada sambungan') {
            $kondisiayakan = '&#x2299;';
        }
        if ($q['KondisiAyakan'] == 'Tidak sobek, ada sambungan') {
            $kondisiayakan = '&#x22BF;';
        }
        if ($q['KondisiAyakan'] == 'Sobek, tidak ada sambungan') {
            $kondisiayakan = '&#x2610;';
        }
        if ($q['KondisiAyakan'] == 'Sobek, ada sambungan') {
            $kondisiayakan = '&#120;';
        }
        $output4 .= "
                        <tr style='border: 1px solid black'>
                            <td style='border: 1px solid black;text-align:center;width:5%'> " . date('d/m', strtotime(Getdata('MixingDate', 'planning_prod_header', 'PlanningNumber', $planningnumber))) . "</td>
                            <td style='border: 1px solid black;text-align:center;width:5%'>" . date('H:i', strtotime($q['CreatedOn'])) . "</td>
                            <td style='border: 1px solid black;text-align:center;width:5%'>" . $q['ProcessNumber'] . "</td>
                            <td style='border: 1px solid black;text-align:center;width:5%'>" . $q['ContainerNumber'] . "</td>
                            <td style='border: 1px solid black;text-align:center;width:5%'>" . $q['Quantity'] . "</td>
                            <td style='border: 1px solid black;text-align:center;width:10%'>" . $namamesin . "</td>
                            <td style='border: 1px solid black;text-align:center;width:5%'>" . $kondisiayakan . "</td>
                            <td style='border: 1px solid black;text-align:center;width:5%'>" . $kontaminasi_ya . "</td>
                            <td style='border: 1px solid black;text-align:center;width:5%'>" . $kontaminasi_tidak . "</td>
                            <td style='border: 1px solid black;text-align:center;width:25%'>" . $q['JenisTemuan'] . "</td>
                            <td style='border: 1px solid black;text-align:center;width:5%'>" . $q['JumlahTemuan'] . "</td>
                            <td style='border: 1px solid black;text-align:center;width:10%'>" . $pp[0] . "</td>
                        </tr>";
    }
    $output4 .= "
                </tbody>
            </table>
            <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr>
                        <td colspan=6 style='border: 1px solid black;text-align:center;font-weight:bold'>Keterangan pengecekan kondisi ayakan</td>
                        <td colspan=6 style='text-align:center;font-weight:bold;border:none;border-bottom:1px solid black !important'>Kriteria Pengecekan</td>
                    </tr>
                    <tr>
                        <td colspan=6 style='border: 1px solid black;'>Pengecekan ayakan oleh operator dilakukan setiap pergantian nomor proses</td>
                        <td colspan=3>&#x2299; Tidak Sobek, Tidak Ada Sambungan</td>
                        <td colspan=3>&#x2610; Sobek, Tidak Ada Sambungan</td>
                    </tr>
                    <tr>
                        <td colspan=6 style='border: 1px solid black'>Pengecekan oleh PP dilakukan setiap proses tuang bahan</td>
                        <td colspan=3>&#x22BF; Tidak Sobek, Ada Sambungan</td>
                        <td colspan=3>&#120; Sobek, Ada Sambungan</td>
                    </tr>
                    <tr>
                        <td colspan=6 style='border: 1px solid black'>Segera hentikan proses jika kondisi ayakan dalam kriteria &#x2610; dan &#120;</td>
                        <td colspan=6></td>
                    </tr>          
                </tbody>
            </table>
            <table>
                <tr style='border: 1px solid black'>
                    <td colspan=4 style='border: 1px solid black'>Jika saat proses mengalami kendala, catat pada tabel dan tunggu tindak lanjut dari IPC/unit terkait</td>
                    <td colspan=2 style='border: 1px solid black;text-align:center'>Dibuat Oleh</td>
                    <td colspan=2 style='border: 1px solid black;text-align:center'>Diperiksa Oleh</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black;text-align:center'>Jam</td>
                    <td style='border: 1px solid black;text-align:center'>Permasalahan</td>
                    <td style='border: 1px solid black;text-align:center'>Tindakan</td>
                    <td style='border: 1px solid black;text-align:center'>Hasil</td>
                    <td colspan=2 style='border: 1px solid black;padding-bottom:2rem'>&nbsp;</td>
                    <td colspan=2 style='border: 1px solid black;padding-bottom:2rem'>&nbsp;</td>
                </tr>";
    $sql = mysqli_query($conn, "SELECT * FROM downtime_rekon WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND
                                                                    PlanningNumber='$planningnumber' AND 
                                                                    Years='$years' AND  
                                                                    Prosestrx ='hopper'");
    $downtime_hopper = array();
    while ($q = mysqli_fetch_assoc($sql)) {
        $downtime_hopper[] = array(
            'lamadowntime' => $q['LamaDowntime'],
            'permasalahan' => $q['Permasalahan'],
            'tindakan' => $q['Tindakan'],
            'hasil' => $q['Hasil']
        );
    }
    $output4 .= "
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>" . $downtime_hopper[0]['lamadowntime'] . "</td>
                    <td style='border: 1px solid black'>" . $downtime_hopper[0]['permasalahan'] . "</td>
                    <td style='border: 1px solid black'>" . $downtime_hopper[0]['tindakan'] . "</td>
                    <td style='border: 1px solid black'>" . $downtime_hopper[0]['hasil'] . "</td>
                    <td style='border: 1px solid black'>Nama</td>
                    <td style='border: 1px solid black;width:10%'>" . $createby_proseshoper . "</td>
                    <td style='border: 1px solid black'>Nama</td>
                    <td style='border: 1px solid black;width:10%'>" . $pp[0] . "</td>
                </tr>
                 <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>" . $downtime_hopper[1]['lamadowntime'] . "</td>
                    <td style='border: 1px solid black'>" . $downtime_hopper[1]['permasalahan'] . "</td>
                    <td style='border: 1px solid black'>" . $downtime_hopper[1]['tindakan'] . "</td>
                    <td style='border: 1px solid black'>" . $downtime_hopper[1]['hasil'] . "</td>
                    <td style='border: 1px solid black'>Jabatan</td>
                    <td style='border: 1px solid black'>" . Getdata('PositionID', 'pa001', 'PersonnelNumber', Getpernr($createdby)) . "</td>
                    <td style='border: 1px solid black'>Jabatan</td>
                    <td style='border: 1px solid black'>" . Getdata('PositionID', 'pa001', 'PersonnelNumber', Getpernrbyname($pengawas)) . "</td>
                </tr>
                 <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>" . $downtime_hopper[2]['lamadowntime'] . "</td>
                    <td style='border: 1px solid black'>" . $downtime_hopper[2]['permasalahan'] . "</td>
                    <td style='border: 1px solid black'>" . $downtime_hopper[2]['tindakan'] . "</td>
                    <td style='border: 1px solid black'>" . $downtime_hopper[2]['hasil'] . "</td>
                    <td style='border: 1px solid black'>Tanggal</td>
                    <td style='border: 1px solid black'>" . $createdon . "</td>
                    <td style='border: 1px solid black'>Tanggal</td>
                    <td style='border: 1px solid black'>" . $createdon . "</td>
                </tr>
            </table>
        </div>
    </body>
</html>";
} else {
    $output4 = false;
}

// *****************************************************************
// // ------> Proses Topack <------
// *****************************************************************
if ($prosestopack == 'X') {
    $sql = mysqli_query($conn, "SELECT * FROM machine_engine WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND 
                                                                    PlanningNumber='$planningnumber' AND 
                                                                    Years='$years'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_array($sql);
        $starttime = $row['Starttimes'];
    }
    $sql = mysqli_query($conn, "SELECT * FROM transaksi_topack WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND 
                                                                        PlanningNumber='$planningnumber' AND 
                                                                        Years='$years'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_array($sql);
        $starttime = $row['Starttimes'];
        $endtime = $row['Endtimes'];
        $countermesin = $row['CounterMesin'];
        $counterprinter = $row['CounterPrinter'];
        $usedlistho = $row['UsedListho'];
        $rejectedsch = $row['rejectedsch'];
        $samplekebocoran = $row['SampleKebocoran'];
        $retainedsample = $row['RetainedSample'];
        $hasilteoritis = $row['HasilTeoritis'];
        $hasilnyata = $row['HasilNyata'];
        $persentase = $row['Persentase'];
        $createdon = date('d-m-Y', strtotime($row['CreatedOn']));
        $createdby = $row['CreatedBy'];
        $dibuatoleh = Getnamakaryawan($createdby);
        $pernr = Getpernrbyname($dibuatoleh);
        $jabatan = Getdata('PositionID', 'pa001', 'PersonnelNumber', $pernr);
        $dibuatoleh = explode(' ', $dibuatoleh);
    }
    $operator_preparetopack = GetdataV('Operator1', 'proses_prepare', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $planningnumber, 'Years', $years, 'Types', 'Topack');
    if ($operator_preparetopack == '') {
        $operator_preparetopack = GetdataV('Operator2', 'proses_prepare', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $planningnumber, 'Years', $years, 'Types', 'Topack');
    }
    $operator_preparetopack = explode(' ', ucfirst(strtolower($operator_preparetopack)));
    $pengawas = GetdataV('PengawasProduksi', 'proses_prepare', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $planningnumber, 'Years', $years, 'Types', 'Topack');
    $jabatan_pengawas_topack = Getpernrbyname($pengawas);
    $jabatan_pengawas_topack = Getdata('PositionID', 'pa001', 'PersonnelNumber', $jabatan_pengawas_topack);
    $pengawas = explode(' ', ucfirst(strtolower($pengawas)));

    $sql = mysqli_query($conn, "SELECT * FROM frm_approval WHERE UnitCode='$unitcode' AND FormTypes ='prosestopack'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_array($sql);
        $person1 = $row['OnePerson'];
        $person2 = $row['TwoPerson'];
        $person3 = $row['ThreePerson'];
        $person4 = $row['FourPerson'];

        $person1_post = $row['OnePost'];
        $person2_post = $row['TwoPost'];
        $person3_post = $row['ThreePost'];
        $person4_post = $row['FourPost'];

        $onedate = date('d-m-Y', strtotime($row['OneDate']));
        $twodate = date('d-m-Y', strtotime($row['TwoDate']));
        $threedate = date('d-m-Y', strtotime($row['ThreeDate']));
        $fourdate = date('d-m-Y', strtotime($row['FourDate']));
    }

    $sql = mysqli_query($conn, "SELECT * FROM transaksi_topack WHERE Plant='$plant' AND 
                                                                        UnitCode='$unitcode' AND 
                                                                        PlanningNumber='$planningnumber' AND
                                                                        Years='$years'");
    $transaksi_topack = mysqli_fetch_array($sql);
    $output5 = "
    <!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='../../../asset/css/css_report.css'>
        <link href='../../../../asset/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'>
    </head>";
    $output5 .= "
    <body>
        <div class='container'>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%'><center><img src='../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                        <td style='border: 1px solid black;font-weight:bold;text-align:center' rowspan=3>CATATAN PENGEMASAN BETS <br> PRIMER - SEKUNDER</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center'>PRODUKSI</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center'>SERBUK INSTAN & <br> SEDIA PANGAN</td>
                    </tr>
                </tbody>
            </table>
            <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;width:15%;'>No Dokumen</td>
                        <td style='border: 1px solid black;width:20%;'>FM-053050-05-00-002</td>
                        <td style='border: 1px solid black;width:15%;'>No Revisi</td>
                        <td style='border: 1px solid black;width:10%;'>00</td>
                        <td style='border: 1px solid black;width:15%;'>Tanggal Berlaku</td>
                        <td style='border: 1px solid black;width:25%;'>07 Februari 2022</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Mengganti No</td>
                        <td style='border: 1px solid black'>-</td>
                        <td style='border: 1px solid black'>No Revisi</td>
                        <td style='border: 1px solid black'>-</td>
                        <td style='border: 1px solid black'>Tanggal Berlaku</td>
                        <td style='border: 1px solid black'>-</td>
                    </tr>
                </tbody>
            </table>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Disusun Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Diperiksa Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Diperiksa Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Disetujui Oleh</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $person1 . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $person2 . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $person3 . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $person4 . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $person1_post . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $person2_post . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $person3_post . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $person4_post . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $onedate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $twodate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $threedate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $fourdate . "</td>
                    </tr>
                </tbody>
            </table>
            <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td>Perhatian</td>
                        <td colspan=10>
                            <li>Apabila terjadi penyimpangan terhadap suatu ketetapan  laporkan dan tangani sesuai prosedur tindakan perbaikan dan pencegahan No PS-020000-01-00-004</li>
                            <li>Gunakan APD sesuai standard , pelindung pernapasan (masker) dan sarung tangan DIperiksa Oleh ..... (paraf).....</li>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan=22 style='border: 1px solid black;vertical-align:text-top;width:10%;font-weight:bold'>III. Pengemasan Primer<br><br> Tgl: " . $packingdate . "</td>
                        <td colspan=2 style='border: 1px solid black;width:15%'>Nama Produk</td>
                        <td colspan=2 style='border: 1px solid black;width:15%'>ED/No Bets</td>
                        <td colspan=2 style='border: 1px solid black;width:15%'>Nama Operator</td>
                        <td colspan=2 style='border: 1px solid black;width:15%'>Nama No Mesin</td>
                        <td style='width:10%'>Shift </td>
                        <td style='width:10%'>: " . $shiftid . "</td>
                    </tr>
                    <tr>
                        <td colspan=2 rowspan=2 style='border: 1px solid black;width:15%;vertical-align:top'>" . $product_description . "</td>
                        <td colspan=2 style='border: 1px solid black;'>" . $expdate . ' / ' . $batch . "</td>
                        <td colspan=2 style='border: 1px solid black;'>" . $operator_preparetopack[0] . "</td>
                        <td colspan=2 rowspan=2 style='border: 1px solid black;vertical-align:top'>" . $resourceid . "</td>
                        <td>Jam Mulai</td>
                        <td>: " . $starttime . "</td>
                    </tr>
                    <tr>
                        <td colspan=2 style='border: 1px solid black;'></td>
                        <td colspan=2 style='border: 1px solid black;'></td>
                        <td>Jam Selesai</td>
                        <td>: " . $endtime . "</td>
                    </tr>
                    <tr style='border: 1px solid black;'>
                        <td colspan=8></td>
                        <td style='border: 1px solid black;text-align:center'>Pelaksana</td>
                        <td style='border: 1px solid black;text-align:center'>Pemeriksa</td>
                    </tr>
                    <tr style='border: 1px solid black;'>
                        <td colspan=8>1. Pasang kemasan roll (litho) pada mesin dan setting mesin sesuai dengan bentuk sachet yang akan dibuat (renteng/potong)</td>
                        <td style='border: 1px solid black;text-align:center'>" . $operator_preparetopack[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $pengawas[0] . "</td>
                    </tr>
                    <tr style='border: 1px solid black;'>
                        <td colspan=8>2. Setting mesin sesuai dengan parameter berikut ini:</td>
                        <td style='border: 1px solid black;text-align:center'>" . $operator_preparetopack[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $pengawas[0] . "</td>
                    </tr>
                    <tr style='border: 1px solid black;'>
                        <td rowspan=2 style='border: 1px solid black;text-align:center'>Standard</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>Horizontal</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>Pre-Heater</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>Stop/Run(Vertical)</td>
                        <td style='border: 1px solid black;text-align:center'>Speed</td>
                        <td rowspan=3 style='border: 1px solid black;text-align:center'>" . $operator_preparetopack[0] . "</td>
                        <td rowspan=3 style='border: 1px solid black;text-align:center'>" . $pengawas[0] . "</td>
                    </tr>
                    <tr style='border: 1px solid black;'>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>160°-200° C</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>160°-200° C</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>65-85 %</td>
                        <td style='border: 1px solid black;text-align:center'>365-600 rpm</td>
                    </tr>
                    <tr style='border: 1px solid black;'>
                        <td style='border: 1px solid black;text-align:center'>Nyata</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>" . GetdataII('NilaiSuhu', 'machine_engine', 'PlanningNumber', $planningnumber, 'JenisPengecekan', 'Horizontal') . " °C </td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>" . GetdataII('NilaiSuhu', 'machine_engine', 'PlanningNumber', $planningnumber, 'JenisPengecekan', 'Pre Heater') . " °C </td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>" . GetdataII('NilaiSuhu', 'machine_engine', 'PlanningNumber', $planningnumber, 'JenisPengecekan', 'Stop / Run') . " °C</td>
                        <td style='border: 1px solid black;text-align:center'>" . GetdataII('NilaiSuhu', 'machine_engine', 'PlanningNumber', $planningnumber, 'JenisPengecekan', 'Kecepatan Mesin') . " rpm</td>
                        </tr>
                    <tr style='border: 1px solid black;'>
                        <td colspan=8>3. Setting printer untuk mencetak No Bets dan Tgl. Kadaluarsa pada sisi yang sudah ditentukan</td>
                        <td style='border: 1px solid black;text-align:center'>" . $operator_preparetopack[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $pengawas[0] . "</td>
                    </tr>
                    <tr style='border: 1px solid black;'>
                        <td colspan=8>4. Setting mesin untuk pengisian serbuk  ke dalam sachet dengan berat sesuai <br> Berat serbuk/sch: .... g</td>
                        <td style='border: 1px solid black;text-align:center'>" . $operator_preparetopack[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $pengawas[0] . "</td>
                    </tr>
                    <tr style='border: 1px solid black;'>
                        <td colspan=8>5. Lakukan pemeriksaan terhadap fisik sachet, ED/No Bets, bobot dan kebocoran sachet pada awal pengemasan dan selama proses pengemasan </td>
                        <td style='border: 1px solid black;text-align:center'>" . $operator_preparetopack[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $pengawas[0] . "</td>
                    </tr>
                    <tr style='border: 1px solid black;'>
                        <td colspan=8>6. Jika ada sachet yang tidak memenuhi syarat, lakukan pengguntingan dan isikan kembali kedalam mesin (lewatkan pada ayakan sebelum masuk ke hopper)</td>
                        <td style='border: 1px solid black;text-align:center'>" . $operator_preparetopack[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $pengawas[0] . "</td>
                    </tr>
                    <tr style='border: 1px solid black;'>
                        <td colspan=8>7. Catat hasil pemeriksaan keseragaman bobot dalam tabel dibawah ini</td>
                        <td style='border: 1px solid black;text-align:center'>" . $operator_preparetopack[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $pengawas[0] . "</td>
                    </tr>
                    <tr style='border: 1px solid black;'>
                        <td colspan=8>8. Bersihkan mesin sesuai intruksi kerja pembersihan mesin</td>
                        <td style='border: 1px solid black;text-align:center'>" . $operator_preparetopack[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $pengawas[0] . "</td>
                    </tr>
                </tbody>
            </table>

            <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tr>
                    <td>
                        <table>
                            <tr style='border: 1px solid black'>
                                <td style='border: 1px solid black;width:5%;text-align:center'>No</td>
                                <td style='border: 1px solid black;width:20%;text-align:center'>No Bets/No Proses</td>
                                <td style='border: 1px solid black;width:20%;text-align:center'>Jam Tmbg</td>
                                <td style='border: 1px solid black;text-align:center'>Bobot (gram/sachet)</td>
                            </tr>";
    $sql = mysqli_query($conn, "SELECT * FROM sampling_transaksi_topack WHERE PlanningNumber ='$planningnumber' AND Years='$years'");
    $s = 1;
    while ($row = mysqli_fetch_array($sql)) {
        $output5 .= "<tr style='border: 1px solid black'>
        <td style='border: 1px solid black;text-align:center'>" . $s . "</td>
        <td style='border: 1px solid black;text-align:center'>" . Getdata('BatchNumber', 'planning_prod_header', 'PlanningNumber', $planningnumber) . "</td>
        <td style='border: 1px solid black;text-align:center'>" . $row['JamTimbang'] . "</td>
        <td style='border: 1px solid black;text-align:center'>" . $row['BobotTimbang'] . "</td>";
        $output5 .= "</tr>";
        $s += 1;
    }
    $sql = mysqli_query($conn, "SELECT * FROM downtime_rekon WHERE Plant='$plant' AND 
                                                                    UnitCode='$unitcode' AND
                                                                    PlanningNumber='$planningnumber' AND 
                                                                    Years='$years' AND  
                                                                    Prosestrx ='topack'");
    $downtime_topack = array();
    while ($q = mysqli_fetch_assoc($sql)) {
        $downtime_topack[] = array(
            'lamadowntime' => $q['LamaDowntime'],
            'permasalahan' => $q['Permasalahan'],
            'tindakan' => $q['Tindakan'],
            'hasil' => $q['Hasil']
        );
    }
    $output5 .= "
                        </table>
                    </td>
                    <td style='vertical-align:top;width:50%'>
                        <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                            <tbody>
                                <tr style='border: 1px solid black'>
                                    <td style='border: 1px solid black;text-align:center'>Jam</td>
                                    <td style='border: 1px solid black;text-align:center'>Permasalahan</td>
                                    <td style='border: 1px solid black;text-align:center'>Tindakan</td>
                                    <td style='border: 1px solid black;text-align:center'>Hasil</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td style='border: 1px solid black;text-align:center'>&nbsp;" . $downtime_topack[0]['lamadowntime'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $downtime_topack[0]['permasalahan'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $downtime_topack[0]['tindakan'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $downtime_topack[0]['hasil'] . "</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td style='border: 1px solid black;text-align:center'>&nbsp;" . $downtime_topack[1]['lamadowntime'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $downtime_topack[1]['permasalahan'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $downtime_topack[1]['tindakan'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $downtime_topack[1]['hasil'] . "</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td style='border: 1px solid black;text-align:center'>&nbsp;" . $downtime_topack[2]['lamadowntime'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $downtime_topack[2]['permasalahan'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $downtime_topack[2]['tindakan'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $downtime_topack[2]['hasil'] . "</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td colspan=2 style='border: 1px solid black;text-align:center'>Hasil counter mesin (Sach)</td>
                                    <td colspan=2 style='border: 1px solid black;text-align:center'>Jumlah Hasil (sach)</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td colspan=2 style='border: 1px solid black;text-align:center'>" . $countermesin . "</td>
                                    <td colspan=2 style='border: 1px solid black;text-align:center'>" . $transaksi_topack['CounterPrinter'] . "</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td colspan=2 style='border: 1px solid black;text-align:center'>Rusak (sach)</td>
                                    <td colspan=2 style='border: 1px solid black;text-align:center'>Jml litho terpakai (roll)</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td colspan=2 style='border: 1px solid black;text-align:center'>" . $transaksi_topack['rejectedsch'] . "</td>
                                    <td colspan=2 style='border: 1px solid black;text-align:center'>" . $usedlistho . "</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>";
    $output5 .= "
            <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td colspan=7 style='width:10%; font-weight:bold'>IV. Rekonsiliasi Pengemasan Primer Tgl: " . date('d/m') . "</td>
                        <td colspan=7 style='width:20%;text-align:right'>Berat serbuk per sachet: .... gr</td>
                    </tr>
                    <tr style='border: 1px solid black;text-align:center'>
                        <td style='border: 1px solid black;text-align:center'>a</td>
                        <td style='border: 1px solid black;text-align:center'>b</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>c</td>
                        <td style='border: 1px solid black;text-align:center'>d=b+c</td>
                        <td style='border: 1px solid black;text-align:center'>e=d/brt sach</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>Hasil Pengemasan</td>
                        <td style='border: 1px solid black;text-align:center'>h=f+g</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>i</td>
                        <td style='border: 1px solid black;text-align:center'>j</td>
                        <td style='border: 1px solid black;text-align:center'>k=h(i+j)</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td rowspan=2 style='border: 1px solid black;text-align:center'>Jml R</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center'>Berat Teori (kg)</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>Permintaan Bulk</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center'>Berat Nyata</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center'>Jml Sachet Teoritis</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center'>Sachet</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center'>Renteng</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center'>Total Hasil Sachet</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>Untuk IPC</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center'>Waste</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center'>Hasil AKhir Sachet</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>Kg</td>
                        <td style='border: 1px solid black;text-align:center'>Ktg</td>
                        <td style='border: 1px solid black;text-align:center'>Tes Bocor</td>
                        <td style='border: 1px solid black;text-align:center'>Retained Sample</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td rowspan=4 style='border: 1px solid black'></td>
                        <td rowspan=4 style='border: 1px solid black'></td>
                        <td rowspan=4 style='border: 1px solid black'></td>
                        <td rowspan=4 style='border: 1px solid black'></td>
                        <td rowspan=4 style='border: 1px solid black'></td>
                        <td rowspan=4 style='border: 1px solid black'></td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>Tgl " . date('d/m') . "</td>
                        <td rowspan=4 style='border: 1px solid black'></td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>Berat (kg)</td>
                        <td rowspan=4 style='border: 1px solid black'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>&nbsp;</td>
                        <td style='border: 1px solid black'>&nbsp;</td>
                        <td style='border: 1px solid black'>&nbsp;</td>
                        <td style='border: 1px solid black'>&nbsp;</td>
                        <td style='border: 1px solid black'>&nbsp;</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>Tgl</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>Konversi Sachet</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>&nbsp;</td>
                        <td style='border: 1px solid black'>&nbsp;</td>
                        <td style='border: 1px solid black'>&nbsp;</td>
                        <td style='border: 1px solid black'>&nbsp;</td>
                        <td style='border: 1px solid black'>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan=9 style='font-weight:bold'>REKONSILIASI HASIL</td>
                        <td colspan=4 style='font-weight:bold'>Hasil Penyelidikan:</td>
                    </tr>
                    <tr>
                        <td colspan=2>Hasil Teoritis</td>
                        <td>:" . $hasilteoritis . "</td>
                        <td colspan=10>Sachet</td>
                    </tr>
                    <tr>
                        <td colspan=2>Hasil Nyata</td>
                        <td>:" . $hasilnyata . "</td>
                        <td colspan=10>Sachet</td>
                    </tr>
                    <tr>
                        <td colspan=2></td>
                        <td>:" . $persentase . "</td>
                        <td colspan=10>%</td>
                    </tr>
                    <tr>
                        <td colspan=2>Batas Hasil</td>
                        <td>:" . Getdata("Nilai", "qc_characteristic", "KodeProses", "RK01") . "</td>
                        <td colspan=6>" . Getdata("UnitOfMeasures", "qc_characteristic", "KodeProses", "RK01") . "</td>
                        <td colspan=4 style='font-weight:bold'>Keputusan:</td>
                    </tr>
                    <tr>
                        <td colspan=9><ul><li>Bila hasil nyata diluar batas hasil tersebut diatas laporkan kepada pengawas<br>dan lakukan 'Penyelidikan terhadap kegagalan'</li></ul></td>
                        <td colspan=2>OK <img src='../../../asset/icon/rectangle.png'></td>
                        <td colspan=2>TIDAK OK<img src='../../../asset/icon/rectangle.png'></td>
                    </tr>
                </table>
                <table cellpadding=2 cellspacing=0>
                    <tr style='border: 1px solid black'>
                        <td colspan=7 style='border: 1px solid black;text-align:center'>Dibuat Oleh</td>r
                        <td colspan=7 style='border: 1px solid black;text-align:center'>Diperiksa Oleh</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=7 style='border: 1px solid black;text-align:center;padding-bottom:3rem'>&nbsp;</td>r
                        <td colspan=7 style='border: 1px solid black;text-align:center;padding-bottom:3rem'>&nbsp;</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Nama</td>
                        <td colspan=2 style='border: 1px solid black'>" . $dibuatoleh[0] . "</td>
                        <td style='border: 1px solid black'>Jabatan</td>
                        <td style='border: 1px solid black'>" . $jabatan . "</td>
                        <td style='border: 1px solid black'>Tgl</td>
                        <td style='border: 1px solid black'>" . $createdon . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td colspan=2 style='border: 1px solid black'>" . $pengawas[0] . "</td>
                        <td style='border: 1px solid black'>Jabatan</td>
                        <td style='border: 1px solid black'>" . $jabatan_pengawas_topack . "</td>
                        <td style='border: 1px solid black'>Tgl</td>
                        <td style='border: 1px solid black'>" . $createdon . "</td>
                    </tr>
                </tbody>
            </table>
            ";
    $output5 .= "
            
        </div>
    </body>
";
} else {
    $output5 = false;
}
// *****************************************************************
// // ------> Prepare Pillow <------
// *****************************************************************
if ($preparepillow == 'X') {
    $jml_kemasan_terpakai = '';
    $sql = mysqli_query($conn, "SELECT * FROM transaksi_rekon_pillow WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber ='$planningnumber' AND
                                                                        Years='$years'");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $hasilnyata = $r['HasilNyata'];
        $hasilteoritis = $r['HasilTeoritis'];
        $hasilpengemasan = $r['HasilPengemasan'];
        $countermesin = $r['CounterMesin'];
        $presentasehasil = $r['PresentaseHasil'];
        $dus = deletenol($r['Dus']);
        $brosur = deletenol($r['Brosur']);
        $hanger = deletenol($r['Hanger']);
        $stiker = deletenol($r['Stiker']);
        $tbox = deletenol($r['Tbox']);
        $plastik = deletenol($r['Plastik']);
        $createdon_rekonpillow = date('d/m', strtotime($r['CreatedOn']));
        $createdby_rekonpillow = Getdata('PersonnelNumber', 'usr02', 'UserID', $r['CreatedBy']);
        $createdby_rekonpillow = Getdata('EmployeeName', 'pa001', 'PersonnelNumber ', $createdby_rekonpillow);
        $createdby_rekonpillow = explode(' ', $createdby_rekonpillow);
        $createdby_rekonpillow = $createdby_rekonpillow[0];
        $dibuatoleh = Getnamakaryawan($createdby);
        $pernr = Getpernrbyname($dibuatoleh);
        $jabatan_rekonpillow = Getdata('PositionID', 'pa001', 'PersonnelNumber', $pernr);
    }
    function gethasilperiksa_preparepillow($planningnumber, $years, $parameter)
    {
        include '../../../function/koneksi.php';
        session_start();
        $plant = $_SESSION['plant'];
        $unitcode = $_SESSION['unitcode'];
        $return = '';
        $values = GetdataIV($parameter, 'proses_prepare_pillow', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $planningnumber, 'Years', $years);
        if ($values == 'true') {
            $return = 'OK';
        } else {
            $return = $values;
        }
        return $return;
    }
    $sql = mysqli_query($conn, "SELECT * FROM transaksi_pillow WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber ='$planningnumber' AND
                                                                        Years='$years'");
    if (mysqli_num_rows($sql) != 0) {
        $transaksi = mysqli_fetch_array($sql);
        $type_renteng = $transaksi['TypeRenteng'];
        $jml_plastik = $transaksi['QtyPlastik'];
    }

    $sql = mysqli_query($conn, "SELECT * FROM reject_lulus_rekonsiliasipillow WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber ='$planningnumber' AND
                                                                        Years='$years'");
    $jumlah_reject = 0;
    if (mysqli_num_rows($sql) != 0) {
        while ($reject_pillow = mysqli_fetch_array($sql)) {
            $jumlah_reject = $jumlah_reject + $reject_pillow['Jumlah'];
        }
    }

    $sql = mysqli_query($conn, "SELECT * FROM frm_approval WHERE UnitCode='$unitcode' AND FormTypes ='preparepillow'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_array($sql);
        $person1 = $row['OnePerson'];
        $person2 = $row['TwoPerson'];
        $person3 = $row['ThreePerson'];
        $person4 = $row['FourPerson'];

        $person1_post = $row['OnePost'];
        $person2_post = $row['TwoPost'];
        $person3_post = $row['ThreePost'];
        $person4_post = $row['FourPost'];

        $onedate = date('d-m-Y', strtotime($row['OneDate']));
        $twodate = date('d-m-Y', strtotime($row['TwoDate']));
        $threedate = date('d-m-Y', strtotime($row['ThreeDate']));
        $fourdate = date('d-m-Y', strtotime($row['FourDate']));
    }
    $sql = mysqli_query($conn, "SELECT * FROM proses_prepare_pillow WHERE Plant='$plant' AND
                                                                        UnitCode='$unitcode' AND
                                                                        PlanningNumber ='$planningnumber' AND
                                                                        Years='$years'");
    $row = mysqli_fetch_array($sql);
    $operator = explode(' ', $row['FirstOperator']);
    $pengawas = explode(' ', $row['PengawasProduksi']);

    $output6 = "
    <!doctype html>
    <html lang='en'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='../../../asset/css/css_report.css'>
    </head>";
    $output6 .= "
    <body>
        <div class='container'>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%'><center><img src='../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                        <td style='border: 1px solid black;font-weight:bold; text-align:center' rowspan=3>CATATAN PENGEMASAN BETS <br> PRIMER - SEKUNDER</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center'>PRODUKSI</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center'>SERBUK INSTAN & <br> SEDIA PANGAN</td>
                    </tr>
                </tbody>
            </table>
            <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;width:15%;'>No Dokumen</td>
                        <td style='border: 1px solid black;width:20%;'>FM-053050-05-00-002</td>
                        <td style='border: 1px solid black;width:15%;'>No Revisi</td>
                        <td style='border: 1px solid black;width:10%;'>00</td>
                        <td style='border: 1px solid black;width:15%;'>Tanggal Berlaku</td>
                        <td style='border: 1px solid black;width:25%;'>07 Februari 2022</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Mengganti No</td>
                        <td style='border: 1px solid black'>-</td>
                        <td style='border: 1px solid black'>No Revisi</td>
                        <td style='border: 1px solid black'>-</td>
                        <td style='border: 1px solid black'>Tanggal Berlaku</td>
                        <td style='border: 1px solid black'>-</td>
                    </tr>
                </tbody>
            </table>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Disusun Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Diperiksa Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Diperiksa Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Disetujui Oleh</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $person1 . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $person2 . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $person3 . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $person4 . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $person1_post . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $person2_post . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $person3_post . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $person4_post . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $onedate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $twodate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $threedate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $fourdate . "</td>
                    </tr>
                </tbody>
            </table>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>       
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black; text-align:center;width: 15%'>Nama Produk</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center;width: 15%'>Jenis Produk</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center;width: 15%'>ED/No Bets</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center;width: 15%'>No Mesin/Meja</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center;width: 15%'>Tgl Pengemasan</td>
                        <td style='border: text-align:center;width: 10%'>Shift</td>
                        <td style='border: text-align:center;width: 15%'>: " . Getdata('ShiftDescriptions', 'shifts', 'ShiftID', $shiftid) . "</td>
                    </tr>
                    <tr style='border-bottom: 1px solid black;border-right: 1px solid black;border-left: 1px solid black'>
                        <td colspan=2 rowspan=2 style='border: 1px solid black; text-align:center'>$product_description</td>
                        <td colspan=2 rowspan=2 style='border: 1px solid black; text-align:center'>Renteng " . $transaksi['TypeRenteng'] . "</td>
                        <td colspan=2 rowspan=2 style='text-align:center'>$expdate <br> $batch</td>
                        <td colspan=2 rowspan=2 style='border: 1px solid black; text-align:center'>$resourceid</td>
                        <td colspan=2 rowspan=2 style='border: 1px solid black; text-align:center'>$packingdate</td>
                        <td>Jam Mulai</td>
                        <td>: " . date('H:i', strtotime($transaksi['Jam_Mulai'])) . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td>Jam Selesai</td>
                        <td>: " . date('H:i', strtotime($transaksi['Jam_Selesai'])) . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black; text-align:center;width: 15%;vertical-align: text-top'>Nama Operator 1 <br>" . $row['FirstOperator'] . "</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center;width: 15%;vertical-align: text-top'>Nama Operator 2 <br>$row[SecondOperator]</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center;width: 15%;vertical-align: text-top'>Nama Operator 3 <br>$row[ThreeOperator]</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center;width: 15%;vertical-align: text-top'>Nama Operator 4 <br>$row[FourOperator]</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center;width: 15%;vertical-align: text-top'>Nama Operator 5 <br>$row[FiveOperator]</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center;width: 25%;vertical-align: text-top'>Nama Operator 6 <br>$row[SixOperator]</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black'>Perhatian</td>
                        <td colspan=10>
                         Apabila terjadi penyimpangan terhadap suatu ketetapan laporkan dan tangani sesuai prosedur tindakan perbaikan dan pencegahan No PS-020000-01-00-04
                        </td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=12 style='border: 1px solid black;font-weight:bold'>V. DAFTAR PERIKSA KESIAPAN JALUR PENGEMASAN SEKUNDER</td>
                    </tr>
                </tbody>
            </table>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td rowspan=2 style='border: 1px solid black;font-weight:bold;text-align:center'>No</td>
                        <td rowspan=2 colspan=6 style='border: 1px solid black;font-weight:bold;text-align:center;width:50%'>Uraian Pemeriksaan</td>
                        <td rowspan=2 style='border: 1px solid black;font-weight:bold;text-align:center'>Hasil Periksa</td>
                        <td colspan=2 style='border: 1px solid black;font-weight:bold;text-align:center'>Pelaksana</td>
                        <td colspan=4 style='border: 1px solid black;font-weight:bold;text-align:center'>Pemeriksa</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;font-weight:bold;text-align:center'>Nama</td>
                        <td style='border: 1px solid black;font-weight:bold;text-align:center'>Paraf</td>
                        <td style='border: 1px solid black;font-weight:bold;text-align:center'>PP</td>
                        <td style='border: 1px solid black;font-weight:bold;text-align:center'>Paraf</td>
                        <td style='border: 1px solid black;font-weight:bold;text-align:center'>IPC</td>
                        <td style='border: 1px solid black;font-weight:bold;text-align:center'>Paraf</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>1</td>
                        <td colspan=6 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', 1) . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_preparepillow($planningnumber, $years, 'Parameter_1') . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $operator[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'>" . $pengawas[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>2</td>
                        <td colspan=6 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', 2) . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_preparepillow($planningnumber, $years, 'Parameter_2') . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $operator[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'>" . $pengawas[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td rowspan=3 style='border: 1px solid black;text-align:center'>3</td>
                        <td colspan=6 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', 3) . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_preparepillow($planningnumber, $years, 'Parameter_3') . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $operator[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'>" . $pengawas[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=6 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', 31) . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_preparepillow($planningnumber, $years, 'Parameter_3') . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $operator[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'>" . $pengawas[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=6 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', 32) . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_preparepillow($planningnumber, $years, 'Parameter_3') . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $operator[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'>" . $pengawas[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td rowspan=3 style='border: 1px solid black;text-align:center'>4</td>
                        <td colspan=6 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', 4) . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_preparepillow($planningnumber, $years, 'Parameter_4') . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $operator[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'>" . $pengawas[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_preparepillow($planningnumber, $years, 'Satuan_1') . "</td>
                        <td style='border: 1px solid black'>" . gethasilperiksa_preparepillow($planningnumber, $years, 'Qty_1') . "</td>
                        <td style='border: 1px solid black'>" . gethasilperiksa_preparepillow($planningnumber, $years, 'Satuan_3') . "</td>
                        <td style='border: 1px solid black'>" . gethasilperiksa_preparepillow($planningnumber,  $years, 'Qty_3') . "</td>
                        <td style='border: 1px solid black'>" . gethasilperiksa_preparepillow($planningnumber, $years, 'Satuan_5') . "</td>
                        <td style='border: 1px solid black'>" . gethasilperiksa_preparepillow($planningnumber, $years, 'Qty_5') . "</td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_preparepillow($planningnumber, $years, 'Satuan_2') . "</td>
                        <td style='border: 1px solid black'>" . gethasilperiksa_preparepillow($planningnumber, $years, 'Qty_1') . "</td>
                        <td style='border: 1px solid black'>" . gethasilperiksa_preparepillow($planningnumber, $years, 'Satuan_4') . "</td>
                        <td style='border: 1px solid black'>" . gethasilperiksa_preparepillow($planningnumber, $years, 'Qty_4') . "</td>
                        <td style='border: 1px solid black'>" . gethasilperiksa_preparepillow($planningnumber, $years, 'Satuan_6') . "</td>
                        <td style='border: 1px solid black'>" . gethasilperiksa_preparepillow($planningnumber, $years, 'Qty_6') . "</td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td rowspan=5 style='border: 1px solid black;text-align:center'>5</td>
                        <td colspan=6 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', 5) . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_preparepillow($planningnumber, $years, 'Parameter_5') . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $operator[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'>" . $pengawas[0] . "</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                    </tr>
                </tbody>
            </table>
            <table style='margin-bottom:1px;border: 1px solid black' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td colspan=9 style='border: 1px solid black;font-weight:bold'>VI. PENGEMASAN SEKUNDER</td>
                        <td style='border: 1px solid black;font-weight:bold;text-align:center'>Pelaksana</td>
                        <td style='border: 1px solid black;font-weight:bold;text-align:center'>Pemeriksa</td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td colspan=9 style='border: 1px solid black;font-weight:bold'>A. DOS</td>
                        <td rowspan=5 style='border: 1px solid black;text-align:center'></td>
                        <td rowspan=5 style='border: 1px solid black;text-align:center'></td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td>1</td>
                        <td colspan=8>Masukan setiap (5,10,11,30)* sachet bersama 1 lembar brosur (jika ada) dalam inner dos</td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td>2</td>
                        <td colspan=8>Tutup dos dan segel kedua sisi dengan isolasi</td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td style='vertical-align:text-top'>3</td>
                        <td colspan=8>Masukan setiap (10,20,24,30,36,40,120)* dos kedalam box & segel box menggunakan carton sealer</td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td style='vertical-align:text-top'>4</td>
                        <td colspan=8>
                         Timbang tiap box dan cetak spesifikasi pada box<br>
                         (kodeproduk,tanggal kemas,shift,jam,kode operator,ED,nomor line, nomor urut kemas,bobot)<br>
                         Hasil pencetakan pada box: ..............
                        </td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td colspan=9 style='border: 1px solid black;font-weight:bold'>B. RENTENG DAN HANGER (" . $type_renteng . ")*</td>
                        <td rowspan=4 style='border: 1px solid black;text-align:center'>" . $operator[0] . "</td>
                        <td rowspan=4 style='border: 1px solid black;text-align:center'>" . $pengawas[0] . "</td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td>1</td>
                        <td colspan=8>Masukan setiap renteng dan hanger (bila ada) kedalam plastik ukuran</td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td>2</td>
                        <td colspan=8>Masukan setiap <b>(" . $jml_plastik . ")</b>* plastik pada point 1 ke dalam box dan segel box dengan carton sealer</td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td style='vertical-align:text-top'>3</td>
                        <td colspan=8>Timbang tiap box dan cetak spesifikasi pada box <br> (kode produk, tanggal kemas,shift,jam,kode operator, ED,Nomor Line,nomor untuk kemas,bobot)</td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td colspan=9 style='border: 1px solid black;font-weight:bold'>C. PAK (RENTENG DAN POTONG)*</td>
                        <td rowspan=5 style='border: 1px solid black;text-align:center'></td>
                        <td rowspan=5 style='border: 1px solid black;text-align:center'></td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td>1</td>
                        <td colspan=8>Masukan setiap (1,6,10)* renteng/sachet ke dalam plastik ukuran .....</td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td>2</td>
                        <td colspan=8>Tutup plastik dan seal menggunakan mesin las plastik</td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td style='vertical-align:text-top'>3</td>
                        <td colspan=8>Masukan setiap (8,12,20,24)* plastik pada poin 1 kedalam box dan segel box menggunakan carton sealer</td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td style='vertical-align:text-top'>4</td>
                        <td colspan=8>Timbang tiap box dan cetak spesifikasi pada box<br>
                            (Kode produk, tanggal kemas, shift, jam, kode operator,ED,Nomor Line,Nomor urut kemas,Bobot)<br>
                            Hasil pencetakan pada box: ............</td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td colspan=9 style='border: 1px solid black;font-weight:bold'>D. STOPLES</td>
                        <td rowspan=6 style='border: 1px solid black;text-align:center'></td>
                        <td rowspan=6 style='border: 1px solid black;text-align:center'></td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td>1</td>
                        <td colspan=8>Siapkan stoples dan tempelkan stiker pada badan stoples</td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td>2</td>
                        <td colspan=8>Masukan setiap (20,25,30)* sachet kedalam stoples, tutup stoples dan isolasi</td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td style='vertical-align:text-top'>3</td>
                        <td colspan=8>Masukan setiap (10,12)* stoples kedalam box</td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td style='vertical-align:text-top'>4</td>
                        <td colspan=8>Segel box menggunakan carton sealer</td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td style='vertical-align:text-top'>5</td>
                        <td colspan=8>Timbang tiap box dan cetak spesifikasi pada box<br>
                            (Kode produk, tanggal kemas, shift, jam, kode operator,ED,Nomor Line,Nomor urut kemas,Bobot)<br>
                            Hasil pencetakan pada box: ............</td>
                    </tr>
                </tbody>
            </table>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td colspan=11 style='border: 1px solid black;font-weight:bold'>VII. HASIL PENGEMASAN SEKUNDER</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td rowspan=2 style='border: 1px solid black;font-weight:bold;text-align:center'>Hasil Pengemasan</td>
                        <td rowspan=2 colspan=2 style='border: 1px solid black;font-weight:bold;text-align:center'>Hsl Counter Mesin</td>
                        <td rowspan=2 style='border: 1px solid black;font-weight:bold;text-align:center'>Jml Out Roll</td>
                        <td colspan=4 style='border: 1px solid black;font-weight:bold;text-align:center'>Tidak Lulus/Reject</td>
                        <td colspan=3 style='border: 1px solid black;font-weight:bold;text-align:center'>Identitas Label</td>
                    </tr>
                    <tr style='border: 1px solid black'> 
                        <td style='border: 1px solid black;text-align:center;font-weight:bold'>Jumlah</td>
                        <td style='border: 1px solid black;text-align:center;font-weight:bold'>No. Kont</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>Keterangan</td>
                        <td style='border: 1px solid black;text-align:center;font-weight:bold'>Jam Tuang</td>
                        <td style='border: 1px solid black;text-align:center;font-weight:bold'>No. Msn</td>
                        <td style='border: 1px solid black;text-align:center;font-weight:bold'>No. Kont</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>" . $hasilpengemasan . "</td>
                        <td colspan=2 rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>" . $countermesin . "</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'></td>
                        <td style='border: 1px solid black;text-align:center'>&nbsp;</td>
                        <td style='border: 1px solid black;text-align:center'>&nbsp;</td>
                        <td style='border: 1px solid black;text-align:center'>&nbsp;</td>
                        <td style='border: 1px solid black;text-align:center'>&nbsp;</td>
                        <td style='border: 1px solid black;text-align:center'>&nbsp;</td>
                        <td style='border: 1px solid black;text-align:center'>&nbsp;</td>
                        <td style='border: 1px solid black;text-align:center'>&nbsp;</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>&nbsp;</td>
                        <td style='border: 1px solid black;text-align:center'>&nbsp;</td>
                        <td style='border: 1px solid black;text-align:center'>&nbsp;</td>
                        <td style='border: 1px solid black;text-align:center'>&nbsp;</td>
                        <td style='border: 1px solid black;text-align:center'>&nbsp;</td>
                        <td style='border: 1px solid black;text-align:center'>&nbsp;</td>
                        <td style='border: 1px solid black;text-align:center'>&nbsp;</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center;font-weight:bold'>Pengambilan Kemasan</td>
                        <td style='border: 1px solid black;text-align:center;font-weight:bold'>Dos</td>
                        <td style='border: 1px solid black;text-align:center;font-weight:bold'>Brosur</td>
                        <td style='border: 1px solid black;text-align:center;font-weight:bold'>Hanger</td>
                        <td style='border: 1px solid black;text-align:center;font-weight:bold'>Stiker</td>
                        <td style='border: 1px solid black;text-align:center;font-weight:bold'>Stoples</td>
                        <td style='border: 1px solid black;text-align:center;font-weight:bold'>Plastik</td>
                        <td style='border: 1px solid black;text-align:center;font-weight:bold'>Box</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center;font-weight:bold'>Total Pemakaian Kemasan</td>
                        <td style='border: 1px solid black;text-align:center'>" . $dus . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $brosur . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $hanger . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $stiker . "</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'>" . $plastik . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $tbox . "</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center;font-weight:bold'>Sisa / Kembali</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center;font-weight:bold'>Retur/Rusak</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='font-weight:bold'>Keterangan: Lingkari salah satu yang sesuai</td>
                        <td colspan=8 style='font-weight:bold'>Untuk Produk Colatrend dan kunyit asam Exp Taiwan lakukan shrink dos sebelum masuk box<br>
                            Untuk produk yang dikemas dengan pillowpack gunakan plastik outroll</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>";
} else {
    $output6 = false;
}
// *****************************************************************
// // ------> Pillow Pack <------
// *****************************************************************
if ($prosespillow == 'X' && $rekonpillow == 'X') {
    $sql = mysqli_query($conn, "SELECT * FROM frm_approval WHERE UnitCode='$unitcode' AND FormTypes ='preparepillow'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_array($sql);
        $person1 = $row['OnePerson'];
        $person2 = $row['TwoPerson'];
        $person3 = $row['ThreePerson'];
        $person4 = $row['FourPerson'];

        $person1_post = $row['OnePost'];
        $person2_post = $row['TwoPost'];
        $person3_post = $row['ThreePost'];
        $person4_post = $row['FourPost'];

        $onedate = date('d-m-Y', strtotime($row['OneDate']));
        $twodate = date('d-m-Y', strtotime($row['TwoDate']));
        $threedate = date('d-m-Y', strtotime($row['ThreeDate']));
        $fourdate = date('d-m-Y', strtotime($row['FourDate']));
    }
    $output7 = "
    <!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='../../../asset/css/css_report.css'>
    </head>";
    $output7 .= "
    <body>
        <div class='container'>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%'><center><img src='../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                        <td style='border: 1px solid black;font-weight:bold;text-align:center' rowspan=3>CATATAN PENGEMASAN BETS <br> PRIMER - SEKUNDER</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center'>PRODUKSI</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center'>SERBUK INSTAN & <br> SEDIA PANGAN</td>
                    </tr>
                </tbody>
            </table>
            <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;width:15%;'>No Dokumen</td>
                        <td style='border: 1px solid black;width:20%;'>FM-053050-05-00-002</td>
                        <td style='border: 1px solid black;width:15%;'>No Revisi</td>
                        <td style='border: 1px solid black;width:10%;'>00</td>
                        <td style='border: 1px solid black;width:15%;'>Tanggal Berlaku</td>
                        <td style='border: 1px solid black;width:25%;'>07 Februari 2022</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Mengganti No</td>
                        <td style='border: 1px solid black'>-</td>
                        <td style='border: 1px solid black'>No Revisi</td>
                        <td style='border: 1px solid black'>-</td>
                        <td style='border: 1px solid black'>Tanggal Berlaku</td>
                        <td style='border: 1px solid black'>-</td>
                    </tr>
                </tbody>
            </table>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Disusun Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Diperiksa Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Diperiksa Oleh</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Disetujui Oleh</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:3rem'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $person1 . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $person2 . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $person3 . "</td>
                        <td style='border: 1px solid black'>Nama</td>
                        <td style='border: 1px solid black'>" . $person4 . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $person1_post . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $person2_post . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $person3_post . "</td>
                        <td style='border: 1px solid black;width: 5%;'>Jabatan</td>
                        <td style='border: 1px solid black;width: 20%;'>" . $person4_post . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $onedate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $twodate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $threedate . "</td>
                        <td style='border: 1px solid black'>Tanggal</td>
                        <td style='border: 1px solid black'>" . $fourdate . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=8 style='border: 1px solid black'>Perhatian: Apabila terjadi penyimpangan terhadap suatu ketetapan laporkan dan tangani sesuai prosedur tindakan perbaikan dan pencegahan No. PS-02000-01-00-004</td>
                    </tr>
                </tbody>
            </table>
             <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black;border-bottom:none'>
                        <td rowspan=10 style='border: 1px solid black;border-bottom:none;width:10%;font-weight:bold'>VIII. Penerimaan dan Rekonsiliasi Bahan Pengemas Sekunder " . $createdon . "</td>
                        <td rowspan=3 style='border: 1px solid black; text-align:center'>Bahan Kemas</td>
                        <td colspan=5 style='border: 1px solid black; text-align:center'>Jumlah</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Nama Produk</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Catatan</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td rowspan=2 style='border: 1px solid black; text-align:center'>Kebutuhan</td>
                        <td rowspan=2 style='border: 1px solid black; text-align:center'>Tambahan</td>
                        <td rowspan=2 style='border: 1px solid black; text-align:center'>Pemakaian</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Pengembalian</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>" . $product_description . "</td>
                        <td colspan=2 rowspan=3 style='border: 1px solid black; text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black; text-align:center'>Cacat Suplier</td>
                        <td style='border: 1px solid black; text-align:center'>Kelebihan</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>ED/BC</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black; text-align:center'>Dos</td>
                        <td style='border: 1px solid black; text-align:center'>" . $dus . "</td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'>" . $dus . "</td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>" . $batch . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black; text-align:center'>Brosur</td>
                        <td style='border: 1px solid black; text-align:center'>" . $brosur . "</td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'>" . $brosur . "</td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Produksi</td>
                        <td colspan=2 style='border: 1px solid black; text-align:center'>Gudang</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black; text-align:center'>Plastik</td>
                        <td style='border: 1px solid black; text-align:center'>" . $plastik . "</td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'>" . $plastik . "</td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td colspan=2 rowspan=2 style='border: 1px solid black; text-align:center'></td>
                        <td colspan=2 rowspan=2 style='border: 1px solid black; text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black; text-align:center'>Hanger</td>
                        <td style='border: 1px solid black; text-align:center'>" . $hanger . "</td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'>" . $hanger . "</td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black; text-align:center'>Stiker</td>
                        <td style='border: 1px solid black; text-align:center'>" . $stiker . "</td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'>" . $stiker . "</td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'>Nama</td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'>Nama</td>
                        <td style='border: 1px solid black; text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black; text-align:center'>Stoples</td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'>Jbtn</td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'>Jbtn</td>
                        <td style='border: 1px solid black; text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black; text-align:center'>Box</td>
                        <td style='border: 1px solid black; text-align:center'>" . $tbox . "</td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'>" . $tbox . "</td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'>Tgl</td>
                        <td style='border: 1px solid black; text-align:center'></td>
                        <td style='border: 1px solid black; text-align:center'>Tgl</td>
                        <td style='border: 1px solid black; text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black;border-bottom:none;border-top:none'>
                        <td rowspan=7 style='width:10%;font-weight:bold;border: 1px solid black;vertical-align:top'>IX. Kodifikasi Kemasan Dos</td>
                        <td colspan=10 style='border: 1px solid black'><li>Gunakan APD sesuai standar, pelindung pernapasan (masker) dan pelindung telinga (sesuai rambu APD)</li>
                                                                        <li>Periksa kebersihan ruangan, peralatan dan wadah sebelum melakukan kodifikasi kemasan</li></td>
                    </tr>
                    <tr style='border: 1px solid black;border-bottom:none'>
                        <td colspan=3 style='vertical-align:top'>
                            <p>PENCETAKAN KODE KEMASAN DOS</p>
                            <p>Nama & No Mesin: .....</p>
                            <p>Sebelumnya digunakan untuk</p>
                            <table style='border: 1px solid black'>
                                <tr style='border: 1px solid black'>
                                    <td>Produk</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td>No Bets</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td>Tgl Kadaluarsa</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td>Nama Operator</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                        <td></td>
                        <td colspan=6 style='vertical-align:top'>
                            <p>Sebelumnya digunakan untuk</p>
                            <table style='border: 1px solid black'>
                                <tr style='border: 1px solid black'>
                                    <td style='width:50%'>Tanggal Cetak</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td>Nama Operator</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td>Nama Produk</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td>No Bets</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td>Tgl Kadaluarsa</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td>Jam Mulai/Selesai</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td>Pemeriksa/paraf</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style='border: 1px solid black;border-bottom:none;border-top:none'>
                        <td colspan=10><li>Periksakan hasil pencetakan kepada pengawas pengemasan sekunder dan lampirkan 1 lembar kemasan dos yang telah tercetak pada lembar sebaliknya</li></td>
                    </tr>
                    <tr style='border: 1px solid black;border-bottom:none;border-top:none'>
                        <td colspan=4>
                            <p>REKONSILIASI HASIL CETAK</p>
                            <table>
                                <tr>
                                    <td>(a) Jumlah yg diterima dari gudang</td>
                                    <td>=... Lmbr</td>
                                </tr>
                                <tr>
                                    <td>(b) Jumlah yg dikembalikan</td>
                                    <td>=... Lmbr</td>
                                </tr>
                                <tr>
                                    <td>(c) Jumlah yg dicetak</td>
                                    <td>=... Lmbr</td>
                                </tr>
                                <tr>
                                    <td>(d) Jumlah yg rusak selama percetakan</td>
                                    <td>=... Lmbr</td>
                                </tr>
                                <tr>
                                    <td style='padding-left:100px'>(e) Selisih</td>
                                    <td>=... Lmbr</td>
                                </tr>
                                <tr>
                                    <td style='padding-left:100px'>(f) Persentase</td>
                                    <td>=... %</td>
                                </tr>
                            </table>
                        </td>
                        <td>&nbsp;</td>
                        <td colspan=5>
                            <table style='border: 1px solid black'>
                                <tr>
                                    <td colspan=2>Keterangan perhitungan:</td>
                                </tr>
                                <tr>
                                    <td><li>(e) =</li></td>
                                    <td> a-(b+c+d)</td>
                                </tr>
                                <tr>
                                    <td><li>(f) = </li></td>
                                    <td><u>&nbsp;&nbsp;&nbsp;(c)&nbsp;&nbsp;&nbsp;</u> x 100%</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>a-(b+d)</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style='border: 1px solid black;border-bottom:none;border-top:none'>
                        <td colspan=10>Bila hasil diluar batas hasil tersebut diatas, laporkan kepada pengawas dan lakukan 'Penyelidikan terhadap kegagalan'.</td>
                    </tr>
                    <tr style='border: 1px solid black;border-bottom:none;border-top:none'>
                        <td colspan=10>Hasil Penyelidikan:</td>
                    </tr>
                    <tr style='border: 1px solid black;border-bottom:none;border-top:none'>
                        <td>Keputusan: </td>
                        <td colspan=2><img src='../../../asset/icon/rectangle.png'>OK</td>
                        <td colspan=2><img src='../../../asset/icon/rectangle.png'>TIDAK OK</td>
                        <td colspan=5><i>(Lampirkan dokumen berkaitan)</i></td>
                    </tr>
                    <tr style='border: 1px solid black;border-bottom:none;border-top:none'>
                        <td rowspan=2 style='width:10%;font-weight:bold;border: 1px solid black;vertical-align:top'>X. Rekonsiliasi Pengemasan Sekunder <br> Tgl. " . $createdon_rekonpillow . "</td>
                        <td colspan=10>
                            <table style='text-align:center'>
                                <tr style='border: 1px solid black'>
                                    <td colspan=2 style='border: 1px solid black'>Tanggal</td>
                                    <td colspan=5 style='border: 1px solid black'>Hasil Pengemasan Utuh (Karton) (a)</td>
                                    <td colspan=3 style='border: 1px solid black'>Hasil tdk utuh (b)</td>
                                    <td rowspan=2 style='border: 1px solid black'>Rejected<br>(c)</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td style='border: 1px solid black'>Kemas</td>
                                    <td style='border: 1px solid black'>Kirim</td>
                                    <td style='border: 1px solid black'>Dos</td>
                                    <td style='border: 1px solid black'>Dos Plastik</td>
                                    <td style='border: 1px solid black'>Pak</td>
                                    <td style='border: 1px solid black'>Hanger</td>
                                    <td style='border: 1px solid black'>Stopies</td>
                                    <td style='border: 1px solid black'>Sachet</td>
                                    <td style='border: 1px solid black'>Renteng</td>
                                    <td style='border: 1px solid black'>Dos</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td colspan=2 style='border: 1px solid black'>Jumlah</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td colspan=2 style='border: 1px solid black'>Sachet</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td colspan=4 style='border: 1px solid black'>Hasil akhir sachet</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                    <td style='border: 1px solid black'>&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style='border: 1px solid black;border-top:none'>
                        <td colspan=3>
                            <table>
                                <tr>
                                    <td colspan=2>REKONSILIASI HASIL</td>
                                </tr>
                                <tr>
                                    <td>Hasil Teoritis</td>
                                    <td>: " . $hasilteoritis . "</td>
                                    <td>Sachet</td>
                                </tr>
                                <tr>
                                    <td>Hasil Nyata</td>
                                    <td>: " . $hasilnyata . "</td>
                                    <td>Sachet</td>
                                </tr>
                                <tr>
                                    <td>Presentase Hasil</td>
                                    <td>: " . $presentasehasil . "</td>
                                    <td>%</td>
                                </tr>
                                <tr>
                                    <td>Batas Hasil</td>
                                    <td colspan=2>: 97,0 - 105%</td>
                                </tr>
                                <tr>
                                    <td colspan=3>Bila hasil nyata diluar batas hasil tersebut diatas, laporkan kepada pengawas dan lakukan 'Penyelidikan terhadap kegagalan'</td>
                                </tr>
                            </table>
                        </td>
                        <td colspan=3>
                            <table style='border: 1px solid black'>
                                <tr>
                                    <td colspan=2>keterangan</td>
                                </tr>
                                <tr>
                                    <td>Hasil Nyata</td>
                                    <td>:Hasil akhir (sachet)</td>
                                </tr>
                                <tr>
                                    <td><u>Hasil Nyata (sachet)</u></td>
                                    <td>x 100%</td>
                                </tr>
                                <tr>
                                    <td colspan=2>Hasil Teoritis (sachet)</td>
                                </tr>
                            </table>
                        </td>
                        <td colspan=4>
                            <table>
                                <tr>
                                    <td colspan=2  style='font-weight:bold'>Hasil Penyelidikan</td>
                                </tr>
                                <tr>
                                    <td style='font-weight:bold'>Keputusan</td>
                                </tr>
                                <tr>
                                    <td><img src='../../../asset/icon/rectangle.png'>OK</td>
                                    <td><img src='../../../asset/icon/rectangle.png'>TIDAK OK</td>
                                </tr>
                                <tr>
                                    <td colspan=2><i>(lampirkan dokumen berkaitan)</i></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table cellpadding=2 cellspacing=0 style='width:100%'>
                <tr style='border: 1px solid black'>
                    <td colspan=5 style='text-align:center;border: 1px solid black'>Dibuat oleh,</td>
                    <td colspan=5 style='text-align:center;border: 1px solid black'>Diperiksa oleh,</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td colspan=5 style='padding-bottom:3rem;border: 1px solid black'></td>
                    <td colspan=5 style='padding-bottom:3rem;border: 1px solid black'></td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='border: 1px solid black'>Nama</td>
                    <td style='border: 1px solid black'>" . $createdby_rekonpillow . "</td>
                    <td style='border: 1px solid black'>Jabatan</td>
                    <td style='border: 1px solid black'>" . $jabatan_rekonpillow . "</td>
                    <td style='border: 1px solid black'>Tgl</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>Jabatan</td>
                    <td style='border: 1px solid black'></td>
                    <td style='border: 1px solid black'>Tgl</td>
                </tr>
            </table>
        </div>
    </body>
</html>";
} else {
    $output7 = false;
}
// *****************************************************************
// // ------> ANALISA PENGEMASAN PRIMER <------
// *****************************************************************
if ($pengemasanprimer == 'X') {
    $sql = mysqli_query($conn, "SELECT * FROM qc_analisapengemasanprimer_header WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                                AND PlanningNumber='1000002243'
                                                                                                AND Years='2024'");
    if (mysqli_num_rows($sql) != 0) {
        $r = mysqli_fetch_array($sql);
        $day = getdayformat3($r['CreatedOn']);
        $createdon = $day . ' / ' . date('d-m-Y', strtotime($r['CreatedOn']));
        $createdby = $r['CreatedBy'];
        $ass_qc = $r['Ass_IPC'];
        $koor_qc = $r['Koor_IPC'];
        $shiftid = $r['ShiftID'];

        $qc = Getnamakaryawan($createdby);
        $pernr = Getpernrbyname($qc);
        $jabatan_qc = Getdata('PositionID', 'pa001', 'PersonnelNumber', $pernr);
        // $dibuatoleh = explode(' ', $dibuatoleh);
        $jabatan_assqc = Getdata('PositionID', 'pa001', 'PersonnelNumber', $ass_qc);
        $jabatan_koor = Getdata('PositionID', 'pa001', 'PersonnelNumber', $koor_qc);

        $tingkatinspeksi = $r['TingkatInspeksi'];
        $jmlcontohfrek = $r['JmlContohFrek'];
        $schsetiap = $r['SchSetiap'];
        $menitdarimesin = 1;
        if ($schsetiap == '25') {
            $menitdarimesin = 2;
        }
        $jmlcontoh = $r['JumlahContoh'];
        $catatanpemasok = $r['CatatanPemasok'];
        $kesimpulan = $r['Kesimpulan'];
        $jmlcontoh2 = $r['JumlahContoh2'];
        $kesimpulan2 = $r['Kesimpulan2'];
        $sql = mysqli_query($conn, "SELECT * FROM master_military_std WHERE Plant='$plant' AND TingkatInspec ='$tingkatinspeksi'");
        if (mysqli_num_rows($sql) != 0) {
            $r = mysqli_fetch_array($sql);
            $jmlcontoh = $r['JumlahContoh'];
            $tingkatterima = $r['TingkatTerima'];
            $lulustolak = $r['LulusTolak'];
        }
    }
    $output8 = "
    <!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='../../../asset/css/css_report.css'>
    </head>";
    $output8 .= "
    <body>
        <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
            <tbody>
                <tr style='border: 1px solid black'>
                    <td style='width:15%'><center><img src='../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                    <td colspan=5 style='border: 1px solid black;font-weight:bold;border-bottom:none !important'>LAPORAN ANALISA PROSES PENGEMASAN PRIMER PRODUK SERBUK</td>
                    <td style='border-left: 1px solid black'>No. Form</td>
                    <td>: FM-031000-15-01-017</td>
                </tr>
                <tr style='border: 1px solid black'>                        
                    <td style='width:15%; text-align:center'>PENGAWASAN MUTU</td>
                    <td style='width:10%;border-left: 1px solid black;border-bottom:none !important'>Hari/Tanggal/Shift</td>
                    <td style='width:20%'>: " . $createdon . " / " . $shiftid . "</td>
                    <td style='width:30%'></td>
                    <td style='width:10%'>Tanggal DM</td>
                    <td style='width:10%'>:  " . $createdon . "</td>
                    <td style='width:10%;border-left: 1px solid black;border-bottom: none !important;border-top: none !important'>Revisi</td>
                    <td style='width:10%'>: 02</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td style='width:15%; text-align:center'>IPC</td>
                    <td style='border-left: 1px solid black;'>Produk/ED/No. BC</td>
                    <td>: " . $product_description . " / " . $expdate . " / " . $batch . "</td>
                    <td></td>
                    <td>No. Mesin Kemas</td>
                    <td>:</td>
                    <td style='border-left: 1px solid black'>Tgl Berlaku</td>
                    <td>: 25 Maret 2024</td>
                </tr>
            </tbody>
        </table>
        <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
            <tbody>
                <tr style='border: 1px solid black'>
                    <td colspan=8 style='font-weight:bold'>METODE RENCANA PENGAMBILAN CONTOH: MILITARY STANDART</td>
                    <td colspan=4 style='font-weight:bold;border-left: 1px solid black'>C.PENGECEKAN KODIFIKASI SACHET PRODUK JADI</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td>Tingkat Inspeksi</td>
                    <td style='border: 1px solid black'>" . $tingkatinspeksi . "</td>
                    <td>Jumlah Contoh</td>
                    <td style='border: 1px solid black'>" . $jmlcontoh . "</td>
                    <td>Tgkt. Terima Kualitas</td>
                    <td style='border: 1px solid black'>" . $tingkatterima . "</td>
                    <td>Lulus/Tolak</td>
                    <td style='border: 1px solid black'>" . $lulustolak . "</td>
                    <td colspan=4 rowspan=14 style='width:40%;vertical-align:top'>
                        <table style='margin-bottom:1px;border: 1px solid black; padding:0' cellpadding=0 cellspacing=0>
                            <thead>
                                <tr style='border: 1px solid black;text-align:center'>
                                    <th style='border: 1px solid black;text-align:center'>No</th>
                                    <th style='border: 1px solid black;text-align:center'>Jam</th>
                                    <th style='border: 1px solid black;text-align:center'>Keterangan</th>
                                    <th style='border: 1px solid black;text-align:center'>Contoh Sachet</th>
                                </tr>
                                <tbody>";
    $i = 1;
    $query = mysqli_query($conn, "SELECT * FROM qc_analisapengemasanprimer_three_detail WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                                                AND PlanningNumber='$planningnumber'
                                                                                                                AND Years='$years'");
    while ($r = mysqli_fetch_array($query)) {
        $output8 .= "
                                <tr>
                                    <td style='border: 1px solid black;text-align:center'>" . $i . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . date('H:i', strtotime($r['Jam'])) . "</td>
                                    <td style='border: 1px solid black'>" . $r['Keterangan'] . "</td>
                                    <td style='border: 1px solid black'><img src='../../../asset/galery/analisa_pengemasan_primer/" . $r['GambarSachet'] . "' style='width:10%'></td>
                                </tr>
        ";
        $i += 1;
    }
    $output8 .= "
                                </tbody>
                            </thead>
                        </table>
                    </td>  
                </tr>
                <tr style='border: 1px solid black'>
                    <td colspan=8><b style='font-weight:bold'>JUMLAH CONTOH PER FREKUENSI PENGAMBILAN CONTOH</b>: " . $jmlcontohfrek . " sachet setiap " . $schsetiap . " menit dari " . $menitdarimesin . " mesin</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td colspan=8 style='font-weight:bold'>KESIMPULAN HASIL ANALISA</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td colspan=8>Hasil analisa dinyatakan LULUS jika total jumlah contoh yang tidak sesuai sama dengan atau kurang dari nilai 'LULUS' yang ditetapkan</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td colspan=8>Hasil analisa dinyatakan TOLAK jika total jumlah contoh yang tidak sesuai sama dengan atau lebih dari nilai 'TOLAK' yang ditetapkan</td>
                </tr>
                <tr style='border: 1px solid black;font-weight:bold'>
                    <td colspan=8 style='font-weight:bold'>A. ANALISA VISUAL SACHET DAN BOBOT STANDAR MUTU</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td colspan=2>Kerapian sachet</td>
                    <td colspan=2>: Sachet harus rapi dan simentris</td>
                    <td colspan=2 style='text-align:right'>Eyecut</td>
                    <td colspan=2>: Eye cut pada sachet harus ada dan posisinya tepat</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td colspan=2>Cetakan Rotogravure</td>
                    <td colspan=2>: Cetakan Rotogravure tidak misregister</td>
                    <td colspan=2 style='text-align:right'>Kode Produk</td>
                    <td colspan=2>: Kode produk harus tercantum, terbaca jelas, posisinya tepat dan tidak salah</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td colspan=2>Embos sachet</td>
                    <td colspan=6>: Embos mesin pada sachet harus ada, posisinya tepat dan tercetak jelas angkanya</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td colspan=2>Tingkat kekembungan sachet</td>
                    <td colspan=6>: Tingkat kekembungan sachet harus sesuai (tidak kurang dan tidak lebih)</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td colspan=2>Ketajaman pisau potong sachet</td>
                    <td colspan=6>: Memotong sachet dengan sempurna (mudah untuk disobek dan tidak meninggalkan sisa kemasan dalam sachet)</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td colspan=2>Bobot</td>
                    <td colspan=2>: Range Bobot " . $range_bobot . " gr</td>
                    <td colspan=2 style='text-align:right'>Kondisi seal sachet</td>
                    <td colspan=2>: Seal pada sachet harus benar-benar ngeseal dan tidak halus</td>
                </tr>
                <tr style='border: 1px solid black;font-weight:bold'>
                    <td colspan=8 style='font-weight:bold'>RINCIAN HASIL ANALISA</td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td colspan=8>
                        <table style='margin-bottom:1px;border: 1px solid black' cellpadding=2 cellspacing=0>
                            <thead>
                                <tr style='margin-bottom:1px;border: 1px solid black'>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Jam</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Tgl<br>FBD</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>No<br>Mesin<br>DM</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>No<br>DM</th>
                                    <th rowspan=2 style='writing-mode: vertical-lr;transform: rotate(180deg);border: 1px solid black;text-align:center'>Pemasok/No Roll</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Sch<br>Tdk<br>Rapi</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Mis<br>Regist<br>r</th>
                                    <th colspan=2 style='border: 1px solid black;text-align:center'>Eye Cut</th>
                                    <th colspan=4 style='border: 1px solid black;text-align:center'>Kode Produk</th>
                                    <th colspan=3 style='border: 1px solid black;text-align:center'>Embos Sachet</th>
                                    <th colspan=2 style='border: 1px solid black;text-align:center'>Tingkat<br>Kekembungan<br>Sachet</th>
                                    <th colspan=2 style='border: 1px solid black;text-align:center'>Kodisi Seal<br>Sachet</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Pisau<br>Potong<br>Sch Tdk<br>Tajam</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Bobot<br>-/+</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Catatan<br>Ketidakse<br>sesuaian dan<br>Tindakan<br>Perbaikan</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Paraf</th>
                                </tr>
                                <tr style='margin-bottom:1px;border: 1px solid black'>
                                    <th style='border: 1px solid black;text-align:center'>Tdk<br>ada</th>
                                    <th style='border: 1px solid black;text-align:center'>Posisi<br>salah</th>
                                    <th style='border: 1px solid black;text-align:center'>Tdk<br>ada</th>
                                    <th style='border: 1px solid black;text-align:center'>Posisi<br>salah</th>
                                    <th style='border: 1px solid black;text-align:center'>Salah</th>
                                    <th style='border: 1px solid black;text-align:center'>Mis<br>print</th>
                                    <th style='border: 1px solid black;text-align:center'>Tdk<br>ada</th>
                                    <th style='border: 1px solid black;text-align:center'>Posisi<br>salah</th>
                                    <th style='border: 1px solid black;text-align:center'>Tdk<br>jelas</th>
                                    <th style='border: 1px solid black;text-align:center'>Kurang</th>
                                    <th style='border: 1px solid black;text-align:center'>Lebih</th>
                                    <th style='border: 1px solid black;text-align:center'>Tdk<br>ngeseal</th>
                                    <th style='border: 1px solid black;text-align:center'>Halus</th>
                                </tr>
                            </thead>
                            <tbody>";
    $query = mysqli_query($conn, "SELECT * FROM qc_analisapengemasanprimer_one_detail WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                                            AND PlanningNumber='$planningnumber'
                                                                                                            AND Years='$years'");
    while ($r = mysqli_fetch_array($query)) {
        $output8 .= "
                                <tr style='border: 1px solid black'>
                                    <td style='border: 1px solid black;text-align:center'>" . date('H:i', strtotime($r['Jam']))  . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . date('d-m-Y', strtotime($r['TglFBD'])) . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['NoMesinDM'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['NoDM'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['PemasokNoroll'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Schtdkrapi'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Misregister'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Eyecut_tdkada'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Eyecut_posisisalah'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Kodeproduk_tdkada'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Kodeproduk_posisisalah'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Kodeproduk_salah'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Kodeproduk_misprint'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Embos_tdkada'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Embos_posisisalah'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Embos_tdkjelas'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Kekembungan_kurang'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Kekembungan_lebih'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Ngeseal_tdkngeseal'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Ngeseal_halus'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['PisauPotong'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Bobot'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Catatan'] . "</td>
                                </tr>
                            ";
    }
    $output8 .= "               <tr style='border: 1px solid black'>
                                    <td colspan=5 style='border: 1px solid black'>Jumlah</td>
                                    <td colspan=19></td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td colspan=5 style='border: 1px solid black'>Total Jumlah Contoh</td>
                                    <td colspan=19></td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td colspan=24 style='border: 1px solid black'>Catatan : Pemasok Kemasan 1: DNP 2:MP Rotogravure 3:Putra Mandiri Intipack 4: Samudra Montaz 5: Supernova 6: Penjalindo</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td colspan=24 style='border: 1px solid black;font-weight:bold'>KESIMPULAN: LULUS / TOLAK</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td colspan=24 style='border: 1px solid black;font-weight:bold'>B. ANALISA TINGKAT KEBOCORAN MESIN SACHET<br>STANDAR MUTU</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td colspan=24 style='border: 1px solid black'>Sachet tidak bocor pada setiap frekuensi analisa, tidak ada kontaminan dalam serbuk pada setiap frekuensi analisa</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td colspan=24 style='border: 1px solid black;font-weight:bold'>RINCIAN HASIL ANALISA</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr style='border: 1px solid black'>
                    <td colspan=6 style='vertical-align:top'>
                        <table style='margin-bottom:1px;border: 1px solid black' cellpadding=2 cellspacing=0>
                            <thead>
                                <tr style='border: 1px solid black'>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Jam</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Top</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Vert1</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Vert2</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Hori</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Centre</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>L.J</th>
                                    <th colspan=2 style='border: 1px solid black;text-align:center'>Cek Kontaminan</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Catatan<br>Ketidaksesuaian &<br>Tindakan Perbaikan</th>
                                    <th rowspan=2 style='border: 1px solid black;text-align:center'>Paraf<br>Koord<br>Shift</th>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <th style='border: 1px solid black;text-align:center'>Ada</th>
                                    <th style='border: 1px solid black;text-align:center'>#Ada</th>
                                </tr>
                            </thead>
                            <tbody>";
    $query = mysqli_query($conn, "SELECT * FROM qc_analisapengemasanprimer_two_detail WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                                            AND PlanningNumber='$planningnumber'
                                                                                                            AND Years='$years'");
    while ($r = mysqli_fetch_array($query)) {
        $output8 .= "
                                <tr style='border: 1px solid black'>
                                    <td style='border: 1px solid black;text-align:center'>" . date('H:i', strtotime($r['Jam']))  . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Tops'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Vert1'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Vert2'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Hori'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Centre'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Lj'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['AdaKontaminan'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['TdkAdaKontaminan'] . "</td>
                                    <td style='border: 1px solid black;text-align:center'>" . $r['Catatan'] . "</td>
                                </tr>";
    }
    $output8 .= "
                            </tbody>
                        </table>
                    </td>
                    <td colspan=6 style='vertical-align:top'>
                        <table style='border: 1px solid black' cellpadding=2 cellspacing=0>
                            <thead>
                                <tr style='border: 1px solid black;'>
                                    <td colspan=6 style='border: 1px solid black;padding-bottom:3rem'>Lain-lain</td>
                                </tr>
                                <tr style='border: 1px solid black;'>
                                    <td colspan=4 style='border: 1px solid black'>Diperiksa Oleh,</td>
                                    <td colspan=2 style='border: 1px solid black'>Diketahui Oleh,</td>
                                </tr>
                                <tr>
                                    <td colspan=2 style='padding-bottom: 3rem'></td>
                                    <td colspan=2 style='border-right: 1px solid black; padding-bottom: 3rem'></td>
                                    <td colspan=2 style='padding-bottom: 3rem'></td>
                                </tr>
                                <tr style='border: 1px solid black;'>
                                    <td style='border: 1px solid black'>Nama</td>
                                    <td style='border: 1px solid black'>" . Getdata('EmployeeName', 'pa001', 'PersonnelNumber ', $ass_qc) . "</td>
                                    <td style='border: 1px solid black'>Nama</td>
                                    <td style='border: 1px solid black'>" . $qc . "</td>
                                    <td style='border: 1px solid black'>Nama</td>
                                    <td style='border: 1px solid black'>" . Getdata('EmployeeName', 'pa001', 'PersonnelNumber ', $koor_qc) . "</td>
                                </tr>
                                <tr style='border: 1px solid black;'>
                                    <td style='border: 1px solid black'>Jabatan</td>
                                    <td style='border: 1px solid black'>" . $jabatan_assqc . "</td>
                                    <td style='border: 1px solid black'>Jabatan</td>
                                    <td style='border: 1px solid black'>" . $jabatan_qc . "</td>
                                    <td style='border: 1px solid black'>Jabatan</td>
                                    <td style='border: 1px solid black'>" . $jabatan_koor . "</td>
                                </tr>
                            </thead>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        </tbody>
    </table>
    ";
} else {
    $output8 = false;
}
// *****************************************************************
// // ------> ANALISA PENGEMASAN SEKUNDER <------
// *****************************************************************
if ($pengemasansekunder == 'X') {
    $query = mysqli_query($conn, "SELECT * FROM qc_pengemasansekunder_header WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                            AND PlanningNumber='$planningnumber'
                                                                                            AND Years='$years'");
    if (mysqli_num_rows($query) != 0) {
        $r = mysqli_fetch_array($query);
        $roll_ins = $r['Roll_ins'];
        $roll_tpk = $r['Roll_tpk'];
        $roll_cth = $r['Roll_cth'];
        $roll_msn = $r['Roll_msn'];
        $roll_lt = $r['Roll_lt'];
        $box_ins = $r['Box_ins'];
        $box_tpk = $r['Box_tpk'];
        $box_cth = $r['Box_cth'];
        $box_msn = $r['Box_msn'];
        $box_lt = $r['Box_lt'];
        $shift = $r['ShiftID'];
        $nomesin = $r['NoMesin'];

        $roll_ud = $r['Roll_UD'];
        if ($roll_ud == 'lulus') {
            $roll_ud = 'LULUS/<s>TOLAK</s>';
        } else {
            $roll_ud = 'TOLAK/<s>LULUS</s>';
        }
        $roll_jml = $r['Roll_JmlCthFrekuensi'];
        $roll_frek = $r['Roll_MntFrekuensi'];
        $box_ud = $r['Box_UD'];
        if ($box_ud == 'lulus') {
            $box_ud = 'LULUS/<s>TOLAK</s>';
        } else {
            $box_ud = 'TOLAK/<s>LULUS</s>';
        }
        $box_jml = $r['Box_JmlCthFrekuensi'];
        $box_frek = $r['Box_MntFrekuensi'];
        $day = getdayformat3($r['CreatedOn']);
        $createdon = $day . ' / ' . date('d-m-Y', strtotime($r['CreatedOn']));
        $createdby = $r['CreatedBy'];
        $qc = Getnamakaryawan($createdby);
        $pernr = Getpernrbyname($qc);
        $jabatan_qc = Getdata('PositionID', 'pa001', 'PersonnelNumber', $pernr);
        $koor = Getdata('EmployeeName', 'pa001', 'PersonnelNumber ', $r['Koor_IPC']);
        $jabatan_koor = Getdata('PositionID', 'pa001', 'PersonnelNumber', $r['Koor_IPC']);
    }

    $output9 = "
    <!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='../../../asset/css/css_report.css'>
    </head>";

    $output9 .= "
    <body>
        <div class='container'>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%'><center><img src='../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                        <td style='border: 1px solid black;font-weight:bold;width:60%;vertical-align:top' rowspan=3>LAPORAN ANALISA PROSES PENGEMASAN SEKUNDER - AKHIR<br>MESIN KORIN<br>(SERBUK INSTAN DAN SEDIAAN PANGAN)</td>
                        <td>No. Form</td>
                        <td>: FM-031000-15-01-019</td>    
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center'>PENGAWASAN MUTU</td>
                        <td>Revisi</td>
                        <td>: 02</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center'>IPC</td>
                        <td>Tanggal Berlaku</td>
                        <td>: 25 Maret 2024</td>
                    </tr>
                </tbody>
            </table>
            <table style='margin-bottom:1px ; !important' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;width:15%'>Hari/Tanggal</td>
                        <td colspan=2 style='border: 1px solid black'>" . $createdon . "</td>
                        <td style='border: 1px solid black;font-weight:bold'>RINCIAN HASIL ANALISA</td>    
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:10%;border: 1px solid black'>Shift</td>
                        <td colspan=2 style='width:10%;border: 1px solid black'>" . $shift . "</td>
                        <td style='border: 1px solid black;vertical-align:top' rowspan=34>
                            <table style='font-size:1px !important' cellpadding=2 cellspacing=0>
                                <thead style='text-align:center;'>
                                    <tr style='border: 1px solid black'>
                                        <td rowspan=4 style='border: 1px solid black ;font-weight:bold'>Jam</td>
                                        <td rowspan=4 style='border: 1px solid black ;font-weight:bold'>Kode<br>sachet</td>
                                        <td colspan=5 style='border: 1px solid black ;font-weight:bold'>Outer Roll/Tanpa Roll</td>
                                        <td colspan=11 style='border: 1px solid black ;font-weight:bold'>Box</td>
                                        <td rowspan=4 style='border: 1px solid black ;font-weight:bold'>Keterang<br>an</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td rowspan=3 style='border: 1px solid black;font-weight:bold'>Jml<br>Sct #<br>Sesuai</td>
                                        <td rowspan=3 style='border: 1px solid black;font-weight:bold'>Sachet<br>bocor</td>
                                        <td colspan=2 style='border: 1px solid black;font-weight:bold'>Outer Roll</td>
                                        <td rowspan=3 style='border: 1px solid black;font-weight:bold'>Brosur<br>#ada</td>
                                        <td rowspan=3 style='border: 1px solid black;font-weight:bold'>Jml<br>O R/Sct<br>T.O.R #<br>Sesuai</td>
                                        <td colspan=4 style='border: 1px solid black;font-weight:bold'>Kodifikasi</td>
                                        <td rowspan=3 style='border: 1px solid black;font-weight:bold'>Jam</td>
                                        <td rowspan=3 style='border: 1px solid black;font-weight:bold'>No<br>Box</td>
                                        <td rowspan=3 style='border: 1px solid black;font-weight:bold'>Jml<br>Samp<br>el</td>
                                        <td colspan=3 style='border: 1px solid black;font-weight:bold'>Seal Tape</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td rowspan=2 style='border: 1px solid black;font-weight:bold'>Bocor</td>
                                        <td rowspan=2 style='border: 1px solid black;font-weight:bold'># Rapi</td>
                                        <td rowspan=2 style='border: 1px solid black;font-weight:bold'>Ket<br>Produk</td>
                                        <td rowspan=2 style='border: 1px solid black;font-weight:bold'>Brosur<br>Kode<br>produksi</td>
                                        <td rowspan=2 style='border: 1px solid black;font-weight:bold'>ED/<br>BC</td>
                                        <td rowspan=2 style='border: 1px solid black;font-weight:bold'>Opr</td>
                                        <td rowspan=2 style='border: 1px solid black;font-weight:bold'>#melekat<br>sempurn<br>a pada<br>posisinya</td>
                                        <td colspan=2 style='border: 1px solid black;font-weight:bold'>Panjang seal tape #<br>5-6cm</td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black;font-weight:bold'>Samping<br>atas</td>
                                        <td style='border: 1px solid black;font-weight:bold'>Samping<br>bawah</td>
                                    </tr>
                                </thead>
                                <tbody>";
    $query = mysqli_query($conn, "SELECT * FROM qc_pengemasansekunder WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                            AND PlanningNumber='$planningnumber'
                                                                                            AND Years='$years'");
    while ($r = mysqli_fetch_array($query)) {
        $output9 .= "
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>" . date('H:i', strtotime($r['Jam']))  . "</td>
                                        <td style='border: 1px solid black'>" . $r['KodeSachet'] . "</td>
                                        <td style='border: 1px solid black'>" . $r['Roll_JmlSct'] . "</td>
                                        <td style='border: 1px solid black'>" . $r['Roll_Sachet_Bocor'] . "</td>
                                        <td style='border: 1px solid black'>" . $r['Roll_Bocor'] . "</td>
                                        <td style='border: 1px solid black'>" . $r['Roll_Rapi'] . "</td>
                                        <td style='border: 1px solid black'>" . $r['Roll_Brosur'] . "</td>
                                        <td style='border: 1px solid black'>" . $r['Box_JmlSct'] . "</td>
                                        <td style='border: 1px solid black'>" . $r['Box_KetProduk'] . "</td>
                                        <td style='border: 1px solid black'>" . $r['Box_KodeProd'] . "</td>
                                        <td style='border: 1px solid black'>" . $r['Box_EdBc'] . "</td>
                                        <td style='border: 1px solid black'>" . $r['Box_Opr'] . "</td>
                                        <td style='border: 1px solid black'>" . date('H:i', strtotime($r['Box_Jam'])) . "</td>
                                        <td style='border: 1px solid black'>" . $r['Box_NoBox	'] . "</td>
                                        <td style='border: 1px solid black'>" . $r['Box_JmlSampel'] . "</td>
                                        <td style='border: 1px solid black'>" . $r['Box_mlkt'] . "</td>
                                        <td style='border: 1px solid black'>" . $r['Box_atas'] . "</td>
                                        <td style='border: 1px solid black'>" . $r['Box_bawah'] . "</td>
                                        <td style='border: 1px solid black'>" . $r['Ket'] . "</td>
                                    </tr>";
    }
    $query = mysqli_query($conn, "SELECT * FROM qc_pengemasansekunder WHERE Plant='$plant' AND UnitCode='$unitcode'
                                                                                            AND PlanningNumber='$planningnumber'
                                                                                            AND Years='$years'");
    $nums = mysqli_num_rows($query);
    for ($i = 0; $i < (30 - $nums); $i++) {
        $output9 .= "
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                        <td style='border: 1px solid black'>&nbsp;</td>
                                    </tr>";
    }
    $output9 .= "
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black;font-weight:bold;'>Jml</td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black;font-weight:bold;'>Jml</td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black;font-weight:bold;'>Jml Cth</td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td colspan=2 style='border: 1px solid black;font-weight:bold;'>Jml Cth</td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                        <td style='border: 1px solid black'></td>
                                    </tr>
                                    <tr style='border: 1px solid black'>
                                        <td colspan=2 style='border: 1px solid black;font-weight:bold;'>Kesimpulan</td>
                                        <td colspan=5 style='border: 1px solid black;font-weight:bold;'>" . $roll_ud . "</td>
                                        <td colspan=12 style='border: 1px solid black;font-weight:bold;'>" . $box_ud . "</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>    
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Produk</td>
                        <td colspan=2 style='border: 1px solid black'>" . $productid . "</td> 
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>No Mesin</td>
                        <td colspan=2 style='border: 1px solid black'>" . $nomesin . "</td> 
                    </tr>
                     <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black'>MET. RENC. PENGAMBILAN<br>CONTOH MIL STD:</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'>Outer Roll</td>
                        <td style='border: 1px solid black'>Box</td> 
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Tkt ins</td>
                        <td style='border: 1px solid black'>" . $roll_ins . "</td>
                        <td style='border: 1px solid black'>" . $box_ins . "</td> 
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>TPK</td>
                        <td style='border: 1px solid black'>" . $roll_tpk . "</td>
                        <td style='border: 1px solid black'>" . $box_tpk . "</td> 
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Jml Cth</td>
                        <td style='border: 1px solid black'>" . $roll_cth . "</td>
                        <td style='border: 1px solid black'>" . $box_cth . "</td> 
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>jml mesin</td>
                        <td style='border: 1px solid black'>" . $roll_msn . "</td>
                        <td style='border: 1px solid black'>" . $box_msn . "</td> 
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>L/T</td>
                        <td style='border: 1px solid black'>" . $roll_lt . "</td>
                        <td style='border: 1px solid black'>" . $box_lt . "</td> 
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black;font-weight:bold'>JML CTH/FREKUENSI<br>PENGAMBILAN CTH</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Outer Roll</td>
                        <td style='border: 1px solid black'>" . $roll_jml . " Setiap</td>
                        <td style='border: 1px solid black'>" . $roll_frek . " Menit</td> 
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Box</td>
                        <td style='border: 1px solid black'>" . $box_jml . " Setiap</td>
                        <td style='border: 1px solid black'>" . $box_frek . " Menit</td> 
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black;font-weight:bold'>STANDAR MUTU</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black;font-weight:bold'>OUTER ROLL</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black'>Jml Sct per Outer roll harus sesuai</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black'>Sachet tidak bocor</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black'>Outer roll tidak bocor, harus rapi, tidak sobek</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black'>Brosur harus ada (khusus program bonus gelas/sachet)</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black;font-weight:bold'>BOX</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black'>Jml outer roll/sachet tanpa outer roll per</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black'>box harus sesuai</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black'>Keterangan produk yang dikemas harus sesuai</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black'>Kode produksi posisinya harus sesuai dan terbaca jelas</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black'>ED/BC posisinya harus sesuai dan terbaca jelas</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black'>Operator mesin carton sealer posisinya harus sesuai dan terbaca jelas</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black'>Seal tape harus melekat sempurna pada posisinya</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black'>Panjang seal tape sisi samping atas & bawah</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black'>harus 5-6cm</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black;font-weight:bold'>KESIMPULAN HSL ANALISA</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black'>Hasil analisa LULUS jika jumlah contoh</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black'>yang tidak sesuai standar mutu sama</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black'>atau kurang dari nilai LULUS yang ditetapkan</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black'>Hasil analisa TOLAK jika jumlah contoh</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black'>yang tidak sesuai standar mutu sama atau</td>
                        <td rowspan=8 style='border: 1px solid black;vertical-align:top'>
                            <table>
                                <tr style='border: 1px solid black'>
                                    <td rowspan=4 style='border: 1px solid black;width:50%'></td>
                                    <td colspan=2 style='border: 1px solid black'>Diperiksa Oleh,</td>
                                    <td colspan=2 style='border: 1px solid black'>Diketahui Oleh,</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td colspan=2 style='border: 1px solid black;padding-bottom:3rem'></td>
                                    <td colspan=2 style='border: 1px solid black;padding-bottom:3rem'></td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td style='border: 1px solid black'>Nama</td>
                                    <td style='border: 1px solid black'>" . $qc . "</td>
                                    <td style='border: 1px solid black'>Nama</td>
                                    <td style='border: 1px solid black'>" . $koor . "</td>
                                </tr>
                                <tr style='border: 1px solid black'>
                                    <td style='border: 1px solid black'>Jabatan</td>
                                    <td style='border: 1px solid black'>" . $jabatan_qc . "</td>
                                    <td style='border: 1px solid black'>Jabatan</td>
                                    <td style='border: 1px solid black'>" . $jabatan_koor . "</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=3 style='border: 1px solid black'>lebih dari nilai TOLAK yang ditetapkan</td>
                    </tr>
                </tbody>
            </table>
        </div>
    <body>";
} else {
    $output9 = false;
}

// *****************************************************************
// // ------> LAMPIRAN <------
// *****************************************************************

$query = mysqli_query($conn, "SELECT * FROM planning_pengolahan_subdetail WHERE Plant='$plant' AND 
                                                                                UnitCode='$unitcode' AND 
                                                                                ProductID='$productid' AND 
                                                                                BatchNumber='$batch' AND 
                                                                                NoProses='1'");
if (mysqli_num_rows($query) <> 0) {
    $output10 = "
    <!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body>";

    $r = mysqli_fetch_array($query);
    // $noproses = 1;
    $productid = $r['ProductID'];
    $batchnumber = $r['BatchNumber'];
    $planningnumber_10 = $r['PlanningNumber'];
    $plan_years = $r['Years'];
    $sql = mysqli_query($conn, "SELECT * FROM tb_detailbahanpengolahan WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND 
                                                                            PlanningNumber='$planningnumber_10' AND
                                                                            Years='$plan_years' AND
                                                                            ProductID='$productid' AND
                                                                            BatchNumber='$batchnumber' AND
                                                                            NoProses=1");
    if (mysqli_num_rows($sql) <> 0) {
        $output10 .= "
            <p class='fw-bold' style='text-align:center;font-size:20pt;font-weight:bold'>L A M P I R A N</p>
            <hr style='margin-bottom:3rem;width:50%'>
            <p class='fw-bold' style='font-size:8pt;font-weight:bold'>PROSES I</p>
            <table style='margin-bottom:1px;font-size:4.5pt !important' cellpadding=2 cellspacing=0>              
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
                                                                                                        PlanningNumber='$planningnumber_10' AND
                                                                                                        Years='$plan_years' AND
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
                'noproses' => 2,
                'sh' => $sh,
                'jenisbahan1' => $jenisbahan1,
                'jenisbahan2' => $jenisbahan2,
            );
        }
        $totalscan_proses1 = count($lampiranlabelbahan) - 1;

        for ($i = 0; $i < $totalscan_proses1; $i++) {
            if ($i <= $totalscan_proses1) {
                $Sqrcode = new QrCode($lampiranlabelbahan[$i]['barcode']);
                $qrcode = new Output\Svg();
                $show_qrcode = $qrcode->output($Sqrcode, 60, 'white', 'black');
                $output10 .= "                  
                        <tr>   
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
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan[$i]['nokantong'] . "/" . $totalkantong . "</td>
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
                $output10 .= "
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
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan[$i]['nokantong'] . "/" . $totalkantong . "</td>
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
                $output10 .= "
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
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan[$i]['nokantong'] . "/" . $totalkantong . "</td>
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
            $output10 .= "</tr>";
        }
        $output10 .= "
                </table>
                ";

        // ----No Proses 2
        $sql = mysqli_query($conn, "SELECT * FROM tb_detailbahanpengolahan WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND 
                                                                            PlanningNumber='$planningnumber_10' AND
                                                                            Years='$plan_years' AND
                                                                            ProductID='$productid' AND
                                                                            BatchNumber='$batchnumber' AND
                                                                            NoProses=2");
        if (mysqli_num_rows($sql) <> 0) {
            $output11 = "
                <p class='fw-bold' style='font-size:8pt;font-weight:bold;margin-top:3rem'>PROSES II</p>
                <table style='margin-bottom:1px;font-size:4.5pt' cellpadding=2 cellspacing=0>             
                ";
            $lampiranlabelbahan2 = array();
            while ($q = mysqli_fetch_array($sql)) {
                $kodebahan = $q['KodeBahan'];
                $batchlabel = $q['BatchLabel'];
                $nokantong = $q['NoKantong'];
                $sh = $q['SH'];
                $jenisbahan1 = $q['JenisBahan1'];
                $jenisbahan2 = $q['JenisBahan2'];
                $query = mysqli_query($conn, "SELECT TotalKantong FROM tb_headerbahanpengolahan  WHERE Plant='$plant' AND 
                                                                                                        UnitCode='$unitcode' AND 
                                                                                                        PlanningNumber='$planningnumber_10' AND
                                                                                                        Years='$plan_years' AND
                                                                                                        ProductID='$productid' AND
                                                                                                        BatchNumber='$batchnumber' AND
                                                                                                        BatchLabel='$batchlabel' AND
                                                                                                        NoProses=2 AND
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
                    'jenisbahan2' => $jenisbahan2,
                );
            }
            $totalscan_proses2 = count($lampiranlabelbahan2);
            for ($i = 0; $i < $totalscan_proses2; $i++) {
                if ($i < $totalscan_proses2) {
                    $Sqrcode = new QrCode($lampiranlabelbahan2[$i]['barcode']);
                    $qrcode = new Output\Svg();
                    $show_qrcode = $qrcode->output($Sqrcode, 60, 'white', 'black');

                    $output11 .= "                  
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
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan2[$i]['nokantong'] . "/" . $totalkantong . "</td>
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
                    $output11 .= "
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
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan2[$i]['nokantong'] . "/" . $totalkantong . "</td>
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
                $i = $i + 1;
                if ($i < $totalscan_proses2) {
                    $Sqrcode = new QrCode($lampiranlabelbahan2[$i]['barcode']);
                    $qrcode = new Output\Svg();
                    $show_qrcode = $qrcode->output($Sqrcode, 60, 'white', 'black');
                    $output11 .= "
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
                                        <td style='border: 1px solid black;text-align:center'>" . $lampiranlabelbahan2[$i]['nokantong'] . "/" . $totalkantong . "</td>
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
                $output11 .= "</tr>";
            }
            $output11 .= "
</table>";
        }
        $output11 .= "
</div>
</body>
";
    }
} else {
    $output10 = '';
    $output11 = '';
}

$mpdf = new \Mpdf\Mpdf();
// $mpdf->setFooter('{PAGENO}');
// QA approval
$mpdf->AddPage('P', '', '', '', '', 5, 5, 5, 5, 10, 10);
$mpdf->WriteHTML($output1);
// Prepare, Proses, Organo QC proses 1.
if ($output2 != false) {
    $mpdf->AddPage('P', '', '', '', '', 5, 5, 5, 5, 10, 10);
    $mpdf->WriteHTML($output2);
    $mpdf->AddPage('P', '', '', '', '', 5, 5, 5, 5, 10, 10);
    $mpdf->WriteHTML($output3);
    # code...
}
// // Prepare, Proses, Organo QC proses 2.
if ($output2_1 != false) {
    $mpdf->AddPage('P', '', '', '', '', 5, 5, 5, 5, 10, 10);
    $mpdf->WriteHTML($output2_1);
    $mpdf->AddPage('P', '', '', '', '', 5, 5, 5, 5, 10, 10);
    $mpdf->WriteHTML($output3_1);
}
// // Proses Hoper
if ($output4 != false) {
    $mpdf->AddPage('P', '', '', '', '', 5, 5, 5, 5, 10, 10);
    $mpdf->WriteHTML($output4);
}
// // // Proses Topack & Rekon Topack
if ($output5 != false) {
    $mpdf->AddPage('P', '', '', '', '', 5, 5, 5, 5, 10, 10);
    $mpdf->WriteHTML($output5);
}
// // // Prepare Pillow
if ($output6 != false) {
    $mpdf->AddPage('P', '', '', '', '', 5, 5, 5, 5, 10, 10);
    $mpdf->WriteHTML($output6);
}
// // // Rekon Pillow
if ($output7 != false) {
    $mpdf->AddPage('P', '', '', '', '', 5, 5, 5, 5, 10, 10);
    $mpdf->WriteHTML($output7);
}
// // Pengemasan Primer
if ($output8 != false) {
    // $mpdf = new \Mpdf\Mpdf(['orientation' => 'L', 'format' => 'A4-L']);
    $mpdf->AddPage('L', '', '', '', '', 5, 5, 5, 5, 10, 10);
    $mpdf->WriteHTML($output8);
}
// // Pengemasan Sekunder
if ($output9 != false) {
    // $mpdf = new \Mpdf\Mpdf(['orientation' => 'L', 'format' => 'A4-L']);
    $mpdf->AddPage('P', '', '', '', '', 5, 5, 5, 5, 10, 10);
    $mpdf->WriteHTML($output9);
}
// Lampiran
if ($output10 != false) {
    // $mpdf = new \Mpdf\Mpdf(['orientation' => 'L', 'format' => 'A4-L']);
    $mpdf->AddPage('P', '', '', '', '', 5, 5, 5, 5, 10, 10);
    $mpdf->WriteHTML($output10);
    $mpdf->AddPage('P', '', '', '', '', 5, 5, 5, 5, 10, 10);
    $mpdf->WriteHTML($output11);
}
$mpdf->SetTitle($title);
$mpdf->Output($filename, 'I');
