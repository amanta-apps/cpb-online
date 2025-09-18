<?php
include '../../../function/koneksi.php';
require '../../../function/getdata.php';
require_once '../../../function/getvalue.php';
require_once __DIR__ . '/../../../asset/vendor/autoload.php';
// ob_get_clean();
// session_start();
$laporan = str_replace("'", "", $_GET['v']);
$planningnumber = str_replace("'", "", $_GET['n']);
$years = str_replace("'", "", $_GET['y']);
$plant = $_SESSION['plant'];
$unitcode = $_SESSION['unitcode'];
$filename = 'Rekap Transaksi  ' . $planningnumber . '.pdf';
loguser('Show Report ' . $laporan);

$planning_prod_header = mysqli_query($conn, "SELECT * FROM planning_prod_header WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                    AND PlanningNumber='$planningnumber'
                                                                                    AND Years='$years'");
if (mysqli_num_rows($planning_prod_header) > 0) {
    $row = mysqli_fetch_array($planning_prod_header);
    $produkid = $row['ProductID'];
    $produkname = Getdata('ProductDescriptions', 'mara_product', 'ProductID', $produkid);
    $expdate = strtoupper('ED.' . date('M y', strtotime($row['ExpiredDate'])));
    $batch = strtoupper($row['BatchNumber']);
    $namamesin = $row['ResourceIDMix'];
    // $packingdate = $row['PackingDate'];
    $packingdate = date('d/m', strtotime($row['PackingDate']));
    $mixingdate = $row['MixingDate'];
    $uom = $row['UnitOfMeasures'];
    $resourceid = $row['ResourceID'];
    $shiftid = $row['ShiftID'];
    if ($produkid == 'KJ') {
        $batch = $batch . ' ' . 'BC';
    }
}
// Initial
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

if ($laporan == 'preparehoper') {

    $sql = mysqli_query($conn, "SELECT * FROM proses_prepare WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                    AND PlanningNumber='$planningnumber'
                                                                                    AND Years='$years' 
                                                                                    AND Types='Hoper'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_array($sql);
        $operator1 = explode(' ', $row['Operator1']);
        $operator1 = $operator1[0];
        $operator2 = explode(' ', $row['Operator2']);
        $operator2 = $operator2[0];
        $pp = explode(' ', $row['PengawasProduksi']);
        $pp = $pp[0];
        $par_1 = $row['Parameter_1'];
        $par_2 = $row['Parameter_2'];
        $par_2_1 = $row['Parameter_2_1'];
        $par_3 = $row['Parameter_3'];
        $par_4 = $row['Parameter_4'];
        $par_5 = $row['Parameter_5'];
        $par_5_1 = $row['Sub_parameter_5_1'];
        $par_5_2 = $row['Sub_parameter_5_2'];
        $par_5_3 = $row['Sub_parameter_5_3'];
        // $par_5_4 = $row['Sub_parameter_5_4'];
        $par_5_4 = strtoupper('ED.' . date('M y', strtotime($row['Sub_parameter_5_4'])));
        $par_6 = $row['Parameter_6'];
        $par_7 = $row['Parameter_7'];
        $par_8 = $row['Parameter_8'];
        $createon_proses = date('d/m/Y', strtotime($row['CreatedOn']));
    }
    $sql = mysqli_query($conn, "SELECT * FROM qc_result WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                AND PlanningNumber='$planningnumber' 
                                                                                AND Years='$years' 
                                                                                AND Types='Hoper'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_array($sql);
        $qc_name = explode(' ', Getnamakaryawan($row['CreatedBy']));
        $qc_name = $qc_name[0];
    }
    $sql = mysqli_query($conn, "SELECT * FROM frm_approval WHERE UnitCode='" . $_SESSION["unitcode"] . "' AND FormTypes ='preparehoper'");
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

    $output = "
    <!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='../../../asset/css/css_report.css'>
    </head>";
    $output .= "
    <body>
        <div class='container'>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%'><center><img src='../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                        <td style='border: 1px solid black; text-align:center' rowspan=3>CATATAN PENGEMASAN BETS <br> PRIMER - SEKUNDER</td>
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
                    <tr style='border:1px solid black'>
                        <td rowspan=22 style='border: 1px solid black;width:15%;vertical-align: text-top;'>1. Daftar Periksa<br> Kesiapan Jalur<br> Pengemasan Primer <br><br> Tgl: " . $packingdate . "</td>
                        <td colspan=4 style='border: 1px solid black'>Nama Produk</td>
                        <td colspan=3 style='border: 1px solid black'>ED/No Bets</td>
                        <td colspan=4 style='border: 1px solid black'>Nama Operator</td>
                        <td colspan=5 style='border: 1px solid black'>No Mesin</td>
                    </tr>
                    <tr style='border:1px solid black'>
                        <td colspan=4 style='border: 1px solid black;padding-bottom:1rem;text-align:center'>" . $produkname . "</td>
                        <td colspan=3 style='border: 1px solid black;padding-bottom:1rem;text-align:center'>" . $expdate . ' / ' . $batch . "</td>
                        <td colspan=4 style='border: 1px solid black;padding-bottom:1rem;text-align:center'>" . $operator1 . " <br> " . $operator2 . "</td>
                        <td colspan=5 style='border: 1px solid black;padding-bottom:1rem;text-align:center'>" . Getdata('PrimaryResourceID', 'crhd', 'ResourceID', $resourceid) . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=16 style='border: 1px solid black;font-weight:bold'>CATATAN: DALAM RUANGAN TIDAK ADA PRODUK SELAIN YANG AKAN DIKERJAKAN</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;width:4%;text-align:center'>No</td>
                        <td colspan=7 style='border: 1px solid black;text-align:center;width:36%'>Uraian Pemeriksaan</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center;width:20%'>Hasil Periksa</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center;width:20%'>Pelaksana</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center;width:20%'>Pemeriksa</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>1</td>
                        <td colspan=7 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 1) . "</td>
                        <td colspan=2 style='border: 1px solid black'>" . $par_1 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $operator1 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border-right:1px solid black'>
                        <td style='border: 1px solid black; vertical-align: text-top;text-align:center'>2</td>
                        <td colspan=7 style='border: 1px solid black'>
                            " . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 2) . " <br> 
                            Syarat
                        </td>
                        <td colspan=2 style='border: 1px solid black'></td>
                        <td colspan=3 style='border: 1px solid black'></td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border-right:1px solid black'>
                        <td style='border: 1px solid black; vertical-align: text-top;text-align:center'></td>
                        <td colspan=7 style='border: 1px solid black'>
                            Suhu : " . Getdata('Nilai', 'qc_characteristic', 'KodeProses', 'HP01') . " " . Getdata('UnitOfMeasures', 'qc_characteristic', 'KodeProses', 'HP01') . "
                        </td>
                        <td colspan=2 style='border: 1px solid black'>Suhu: " . $par_2 . " " . Getdata('UnitOfMeasures', 'qc_characteristic', 'KodeProses', 'HP01') . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $qc_name . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border-right:1px solid black'>
                        <td style='border: 1px solid black; vertical-align: text-top;text-align:center'></td>
                        <td colspan=7 style='border: 1px solid black'>
                            RH: " . Getdata('Nilai', 'qc_characteristic', 'KodeProses', 'HP02') . " " . Getdata('UnitOfMeasures', 'qc_characteristic', 'KodeProses', 'HP02') . "
                        </td>
                        <td colspan=2 style='border: 1px solid black'>RH: " . $par_2_1 . " " . Getdata('UnitOfMeasures', 'qc_characteristic', 'KodeProses', 'HP02') . "</td>
                        <td colspan=3 style='border: 1px solid black'></td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>3</td>
                        <td colspan=7 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 3) . "</td>
                        <td colspan=2 style='border: 1px solid black'>" . $par_3 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $operator1 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>4</td>
                        <td colspan=7 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 4) . "</td>
                        <td colspan=2 style='border: 1px solid black'>" . $par_4 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $operator1 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border:1px solid black'>
                        <td style='border: 1px solid black; vertical-align: text-top;text-align:center'>5</td>
                        <td colspan=7 style='border: 1px solid black'>
                            " . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 5) . "
                        </td>
                        <td colspan=2 style='border: 1px solid black'></td>
                        <td colspan=3 style='border: 1px solid black'></td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border-right:1px solid black'>
                        <td style='border: 1px solid black; vertical-align: text-top'></td>
                        <td colspan=7 style='border: 1px solid black'>
                            - " . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 51) . "
                        </td>
                        <td colspan=2 style='border: 1px solid black'>" . $par_5_1 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $operator1 . "</td>                        
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border-right:1px solid black'>
                        <td style='border: 1px solid black; vertical-align: text-top'></td>
                        <td colspan=7 style='border: 1px solid black'>
                            - " . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 52) . "
                        </td>
                        <td colspan=2 style='border: 1px solid black'>" . $par_5_2 . "</td>
                        <td colspan=3 style='border: 1px solid black'></td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border-right:1px solid black'>
                        <td style='border: 1px solid black; vertical-align: text-top'></td>
                        <td colspan=7 style='border: 1px solid black'>
                            - " . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 53) . "
                        </td>
                        <td colspan=2 style='border: 1px solid black'>" . $par_5_3 . "</td>
                        <td colspan=3 style='border: 1px solid black'></td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border-right:1px solid black'>
                        <td style='border: 1px solid black; vertical-align: text-top'></td>
                        <td colspan=7 style='border: 1px solid black'>
                            - " . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 54) . "
                        </td>
                        <td colspan=2 style='border: 1px solid black'>" . $par_5_4 . "</td>
                        <td colspan=3 style='border: 1px solid black'></td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>6</td>
                        <td colspan=7 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 6) . "</td>
                        <td colspan=2 style='border: 1px solid black'>" . $par_6 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $operator1 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border:1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>7</td>
                        <td colspan=7>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 7) . "</td>
                        <td colspan=2 style='border: 1px solid black'>" . $par_7 . "</td>
                        <td colspan=3 style='text-align:center'>" . $operator1 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>8</td>
                        <td colspan=7>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparehoper', 'Item', 8) . "</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>" . $par_8 . "</td>
                        <td colspan=3 style='text-align:center'>" . $operator1 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border-right:1px solid black'>
                        <td colspan=16 style='font-weight:bold'>LAMPIRAN LABEL STATUS ALAT BERSIH & LABEL RUANG BERSIH*</td>
                    </tr>
                    <tr style='border-right:1px solid black'>
                        <td style='border: 1px solid black;padding:210px' colspan=16>
                            <table style='padding:100%; border:1px solid black' >
                                <td style='border: 1px solid black'></td>  
                            </table> 
                        </td>                                       
                    </tr>
                    <tr style='border-right:1px solid black;border-bottom:1px solid black'>
                        <td colspan=16 style='font-weight:bold'>Keterangan: *Apabila produksi setelah pembersihan total ruangan/area produksi</td>
                    </tr>          
                </tbody>
            </table>
        </div>
    </body>
";
    // <------ proses hoper
} elseif ($laporan == 'proseshoper') {

    $sql = mysqli_query($conn, "SELECT * FROM transaksi_hoper WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                    AND PlanningNumber='$planningnumber' 
                                                                                    AND Years='$years'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_array($sql);
        $operator = Getnamakaryawan($row['CreatedBy']);
        $tanggal = date('d/m', strtotime($row['CreatedOn']));
        $operator_preparehoper1 = GetdataV('Operator1', 'proses_prepare', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $planningnumber, 'Years', $years, 'Types', 'Hoper');
        $operator_preparehoper2 = GetdataV('Operator2', 'proses_prepare', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $planningnumber, 'Years', $years, 'Types', 'Hoper');
        $operator_preparehoper = $operator_preparehoper1 . ', ' . $operator_preparehoper2;
        $pp = explode(' ', $row['PengawasProduksi']);
        $pp = $pp[0];

        $createby_proseshoper = Getdata('PersonnelNumber', 'usr02', 'UserID', $row['CreatedBy']);
        $createby_proseshoper = Getdata('EmployeeName', 'pa001', 'PersonnelNumber ', $createby_proseshoper);
        $createby_proseshoper = explode(' ', $createby_proseshoper);
        $createby_proseshoper = $createby_proseshoper[0];
    }
    $sql_loop = mysqli_query($conn, "SELECT * FROM transaksi_hoper WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                        AND PlanningNumber='$planningnumber'
                                                                                        AND Years='$years'");
    $sql = mysqli_query($conn, "SELECT * FROM frm_approval WHERE UnitCode='" . $_SESSION["unitcode"] . "' AND FormTypes ='proseshoper'");
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
    $output = "
    <!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='../../../asset/css/css_report.css'>
    </head>";
    $output .= "
    <body>
        <div class='container'>
            <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%'><center><img src='../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                        <td style='border: 1px solid black; text-align:center' rowspan=3>CATATAN PENGEMASAN BETS <br> PRIMER - SEKUNDER</td>
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
                        <td colspan=2 style='border: 1px solid black; padding-bottom:5rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:5rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:5rem'></td>
                        <td colspan=2 style='border: 1px solid black; padding-bottom:5rem'></td>
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
                        <td style='border: 1px solid black' rowspan=5 style='width:15%;border: 1px solid black'>II. Catatan Penuanangan Produk Ruahan<br>Tgl: " . $packingdate . "</td>
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
                        <td style='vertical-align: text-top'>Perhatian</td>
                        <td colspan=4 >
                            <li> Apabila terjadi penyimpangan terhadap suatu ketetapan dilaporkan dan tangani sesuai prosedur tindakan perbaikan dan pencegahan No PS-020000-01-00-004</li>
                            <li>Gunakan APD sesuai standar pelindung pernapasan (masker), sarung tangan wol dan sarung tangan karet diperiksa oleh .......... (paraf).......</li>
                        </td>
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
                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>Tgl PCM</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>Jam</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>No Proses</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>No Tong</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>Berat (Kg)</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>No Mixer</td>
                        <td rowspan=2 style='border: 1px solid black;text-align:center;font-weight:bold'>Kondisi Ayakan</td>
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
        $output .= "
                        <tr style='border: 1px solid black'>
                            <td style='border: 1px solid black;text-align:center;width:5%'> " . date('d/m', strtotime(GetdataIV('MixingDate', 'planning_prod_header', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $planningnumber, 'Years', $years))) . "</td>
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
                            <td style='border: 1px solid black;text-align:center;width:10%'>" . $q['PengawasProduksi'] . "</td>
                        </tr>";
    }
    $output .= "
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
        </div>";
} elseif ($laporan == 'preparetopack') {
    $sql = mysqli_query($conn, "SELECT * FROM proses_prepare WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                    AND PlanningNumber='$planningnumber' 
                                                                                    AND Years='$years' 
                                                                                    AND Types='Topack'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_array($sql);
        $operator1 = explode(' ', $row['Operator1']);
        $operator1 = $operator1[0];
        $operator2 = explode(' ', $row['Operator2']);
        $operator2 = $operator2[0];
        $pp = explode(' ', $row['PengawasProduksi']);
        $pp = $pp[0];
        $par_1 = $row['Parameter_1'];
        $par_2 = $row['Parameter_2'];
        $par_2_1 = $row['Parameter_2_1'];
        $par_3 = $row['Parameter_3'];
        $par_4 = $row['Parameter_4'];
        $par_5 = $row['Parameter_5'];
        $par_5_1 = $row['Sub_parameter_5_1'];
        $par_5_2 = $row['Sub_parameter_5_2'];
        $par_5_3 = $row['Sub_parameter_5_3'];
        $par_5_4 = $row['Sub_parameter_5_4'];
        $par_6 = $row['Parameter_6'];
        $par_7 = $row['Parameter_7'];
        $par_8 = $row['Parameter_8'];
    }
    $sql = mysqli_query($conn, "SELECT * FROM qc_result WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                AND PlanningNumber='$planningnumber' 
                                                                                AND Years='$years' 
                                                                                AND Types='Topack'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_array($sql);
        $qc_name = explode(' ', Getnamakaryawan($row['CreatedBy']));
        $qc_name = $qc_name[0];
    }
    $sql = mysqli_query($conn, "SELECT * FROM frm_approval WHERE UnitCode='$unitcode' AND FormTypes ='preparetopack'");
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
    $output = "
    <!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='../../../asset/css/css_report.css'>
    </head>";
    $output .= "
    <body>
        <div class='container'>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%'><center><img src='../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                        <td style='border: 1px solid black; text-align:center' rowspan=3>CATATAN PENGEMASAN BETS <br> PRIMER - SEKUNDER</td>
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
                    <tr style='border:1px solid black'>
                        <td rowspan=22 style='border: 1px solid black;width:15%;vertical-align: text-top;'>1. Daftar Periksa<br> Kesiapan Jalur<br> Pengemasan Primer <br><br> Tgl: " . $packingdate . "</td>
                        <td colspan=4 style='border: 1px solid black'>Nama Produk</td>
                        <td colspan=3 style='border: 1px solid black'>ED/No Bets</td>
                        <td colspan=4 style='border: 1px solid black'>Nama Operator</td>
                        <td colspan=5 style='border: 1px solid black'>No Mesin</td>
                    </tr>
                    <tr style='border-right: 1px solid black'>
                        <td colspan=4 style='border: 1px solid black;padding-bottom:1rem;text-align:center'>" . $produkname . "</td>
                        <td colspan=3 style='border: 1px solid black;padding-bottom:1rem;text-align:center'>" . $expdate . ' / ' . $batch . "</td>
                        <td colspan=4 style='border: 1px solid black;padding-bottom:1rem;text-align:center'>" . $operator1 . " <br> " . $operator2 . "</td>
                        <td colspan=5 style='border: 1px solid black;padding-bottom:1rem;text-align:center'>" . Getdata('SecondaryResourceID', 'crhd', 'ResourceID', $resourceid) . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=16 style='border: 1px solid black;font-weight:bold'>CATATAN: DALAM RUANGAN TIDAK ADA PRODUK SELAIN YANG AKAN DIKERJAKAN</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;width:4%;text-align:center'>No</td>
                        <td colspan=7 style='border: 1px solid black;text-align:center;width:36%'>Uraian Pemeriksaan</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center;width:20%'>Hasil Periksa</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center;width:20%'>Pelaksana</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center;width:20%'>Pemeriksa</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>1</td>
                        <td colspan=7 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparetopack', 'Item', 1) . "</td>
                        <td colspan=2 style='border: 1px solid black'>" . $par_1 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $operator1 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border-right: 1px solid black'>
                        <td style='border: 1px solid black; vertical-align: text-top;text-align:center'>2</td>
                        <td colspan=7 style='border: 1px solid black'>
                            " . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparetopack', 'Item', 2) . " <br> 
                            Syarat
                        </td>
                        <td colspan=2 style='border: 1px solid black'></td>
                        <td colspan=3 style='border: 1px solid black'></td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border-right: 1px solid black'>
                        <td style='border: 1px solid black; vertical-align: text-top;text-align:center'></td>
                        <td colspan=7 style='border: 1px solid black'>
                            Suhu : " . Getdata('Nilai', 'qc_characteristic', 'KodeProses', 'TP01') . " " . Getdata('UnitOfMeasures', 'qc_characteristic', 'KodeProses', 'TP01') . "
                        </td>
                        <td colspan=2 style='border: 1px solid black'>Suhu: " . $par_2 . " " . Getdata('UnitOfMeasures', 'qc_characteristic', 'KodeProses', 'TP01') . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $qc_name . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border-right: 1px solid black'>
                        <td style='border: 1px solid black; vertical-align: text-top;text-align:center'></td>
                        <td colspan=7 style='border: 1px solid black'>
                            RH: " . Getdata('Nilai', 'qc_characteristic', 'KodeProses', 'TP02') . " " . Getdata('UnitOfMeasures', 'qc_characteristic', 'KodeProses', 'TP02') . "
                        </td>
                        <td colspan=2 style='border: 1px solid black'>RH: " . $par_2_1 . " " . Getdata('UnitOfMeasures', 'qc_characteristic', 'KodeProses', 'TP02') . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'></td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>3</td>
                        <td colspan=7 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparetopack', 'Item', 3) . "</td>
                        <td colspan=2 style='border: 1px solid black'>" . $par_3 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $operator1 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>4</td>
                        <td colspan=7 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparetopack', 'Item', 4) . "</td>
                        <td colspan=2 style='border: 1px solid black'>" . $par_4 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $operator1 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border-right: 1px solid black'>
                        <td style='border: 1px solid black; vertical-align: text-top;text-align:center'>5</td>
                        <td colspan=7 style='border: 1px solid black'>
                            " . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparetopack', 'Item', 5) . "
                        </td>
                        <td colspan=2 style='border: 1px solid black'></td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'></td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border-right: 1px solid black'>
                        <td style='border: 1px solid black; vertical-align: text-top'></td>
                        <td colspan=7 style='border: 1px solid black'>
                            - " . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparetopack', 'Item', 51) . "
                        </td>
                        <td colspan=2 style='border: 1px solid black'>" . $par_5_1 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $operator1 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border-right: 1px solid black'>
                        <td style='border: 1px solid black; vertical-align: text-top'></td>
                        <td colspan=7 style='border: 1px solid black'>
                            - " . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparetopack', 'Item', 52) . "
                        </td>
                        <td colspan=2 style='border: 1px solid black'>" . $par_5_2 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'></td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border-right: 1px solid black'>
                        <td style='border: 1px solid black; vertical-align: text-top'></td>
                        <td colspan=7 style='border: 1px solid black'>
                            - " . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparetopack', 'Item', 53) . "
                        </td>
                        <td colspan=2 style='border: 1px solid black'>" . $par_5_3 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'></td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border-right: 1px solid black'>
                        <td style='border: 1px solid black; vertical-align: text-top'></td>
                        <td colspan=7 style='border: 1px solid black'>
                            - " . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparetopack', 'Item', 54) . "
                        </td>
                        <td colspan=2 style='border: 1px solid black'>" . $par_5_4 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'></td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>6</td>
                        <td colspan=7 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparetopack', 'Item', 6) . "</td>
                        <td colspan=2 style='border: 1px solid black'>" . $par_6 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $operator1 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border-right: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>7</td>
                        <td colspan=7>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparetopack', 'Item', 7) . "</td>
                        <td colspan=2 style='border: 1px solid black'>" . $par_7 . "</td>
                        <td colspan=3 style='text-align:center'>" . $operator1 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>8</td>
                        <td colspan=7>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'preparetopack', 'Item', 8) . "</td>
                        <td colspan=2 style='border: 1px solid black'>" . $par_8 . "</td>
                        <td colspan=3 style='text-align:center'>" . $operator1 . "</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>" . $pp . "</td>
                    </tr>
                    <tr style='border-right: 1px solid black'>
                        <td colspan=16 style='font-weight:bold'>LAMPIRAN LABEL STATUS ALAT BERSIH & LABEL RUANG BERSIH*</td>
                    </tr>
                    <tr style='border-right: 1px solid black'>
                        <td style='border: 1px solid black;padding:200px' colspan=16>
                            <table style='padding:100%'>
                                <td style='border: 1px solid black'></td>  
                            </table> 
                        </td>                                       
                    </tr>
                    <tr style='border-right: 1px solid black;border-bottom: 1px solid black'>
                        <td colspan=16 style='font-weight:bold'>Keterangan: *Apabila produksi setelah pembersihan total ruangan/area produksi</td>
                    </tr>          
                </tbody>
            </table>
        </div>
    </body>
";
} elseif ($laporan == 'prosestopack') {
    $sql = mysqli_query($conn, "SELECT * FROM machine_engine WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                    AND PlanningNumber='$planningnumber' 
                                                                                    AND Years='$years'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_array($sql);
        $starttime = $row['Starttimes'];
    }
    $sql = mysqli_query($conn, "SELECT * FROM transaksi_topack WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                    AND PlanningNumber='$planningnumber'
                                                                                    AND Years='$years'");
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
        $createdon = $row['CreatedOn'];
        $createdby = $row['CreatedBy'];
    }
    $operator_preparetopack = GetdataV('Operator1', 'proses_prepare', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $planningnumber, 'Years', $years, 'Types', 'Topack');
    if ($operator_preparetopack == '') {
        $operator_preparetopack = GetdataV('Operator2', 'proses_prepare', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $planningnumber, 'Years', $years, 'Types', 'Topack');
    }
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

    $sql = mysqli_query($conn, "SELECT * FROM transaksi_topack WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                    AND PlanningNumber='$planningnumber' 
                                                                                    AND Years='$years'");
    $transaksi_topack = mysqli_fetch_array($sql);
    $output = "
    <!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='../../../asset/css/css_report.css'>
        <link href='../../../../asset/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'>
    </head>";
    $output .= "
    <body>
        <div class='container'>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%'><center><img src='../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                        <td style='border: 1px solid black; text-align:center' rowspan=3>CATATAN PENGEMASAN BETS <br> PRIMER - SEKUNDER</td>
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
                        <td colspan=2 rowspan=2 style='border: 1px solid black;width:15%'>" . $produkname . "</td>
                        <td colspan=2 style='border: 1px solid black;'>" . $expdate . ' / ' . $batch . "</td>
                        <td colspan=2 style='border: 1px solid black;'>" . $operator_preparetopack . "</td>
                        <td colspan=2 rowspan=2 style='border: 1px solid black;'>" . $resourceid . "</td>
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
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black;'>
                        <td colspan=8>2. Setting mesin sesuai dengan parameter berikut ini:</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black;'>
                        <td rowspan=2 style='border: 1px solid black;text-align:center'>Standard</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>Horizontal</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>Pre-Heater</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>Stop/Run(Vertical)</td>
                        <td style='border: 1px solid black;text-align:center'>Speed</td>
                        <td rowspan=3 style='border: 1px solid black;text-align:center'></td>
                        <td rowspan=3 style='border: 1px solid black;text-align:center'></td>
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
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black;'>
                        <td colspan=8>4. Setting mesin untuk pengisian serbuk  ke dalam sachet dengan berat sesuai <br> Berat serbuk/sch: .... g</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black;'>
                        <td colspan=8>5. Lakukan pemeriksaan terhadap fisik sachet, ED/No Bets, bobot dan kebocoran sachet pada awal pengemasan dan selama proses pengemasan </td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black;'>
                        <td colspan=8>6. Jika ada sachet yang tidak memenuhi syarat, lakukan pengguntingan dan isikan kembali kedalam mesin (lewatkan pada ayakan sebelum masuk ke hopper)</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black;'>
                        <td colspan=8>7. Catat hasil pemeriksaan keseragaman bobot dalam tabel dibawah ini</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                    </tr>
                    <tr style='border: 1px solid black;'>
                        <td colspan=8>8. Bersihkan mesin sesuai intruksi kerja pembersihan mesin</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'></td>
                    </tr>
                </tbody>
            </table>
            <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;width:5%;text-align:center'>No</td>
                        <td style='border: 1px solid black;width:20%;text-align:center'>No Bets/No Proses</td>
                        <td style='border: 1px solid black;width:20%;text-align:center'>Jam Tmbg</td>
                        <td style='border: 1px solid black;text-align:center'>Bobot (gram/sachet)</td>
                    </tr>";
    $sql = mysqli_query($conn, "SELECT * FROM sampling_transaksi_topack WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                                AND PlanningNumber ='$planningnumber'
                                                                                                AND Years='$years'");
    $s = 1;
    while ($row = mysqli_fetch_array($sql)) {
        $output .= "<tr style='border: 1px solid black'>
        <td style='border: 1px solid black;text-align:center'>" . $s . "</td>
        <td style='border: 1px solid black;text-align:center'>" . GetdataIV('BatchNumber', 'planning_prod_header', 'Plant', $plant, 'UnitCode', $unitcode, 'Years', $years, 'PlanningNumber', $planningnumber) . "</td>
        <td style='border: 1px solid black;text-align:center'>" . $row['JamTimbang'] . "</td>
        <td style='border: 1px solid black;text-align:center'>" . $row['BobotTimbang'] . "</td>";
        $output .= "</tr>";
        $s += 1;
    }
    $output .= "
                </tbody>
            </table>
            <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;width:5%;text-align:center'>Jam</td>
                        <td style='border: 1px solid black;width:15%;text-align:center'>Permasalahan</td>
                        <td style='border: 1px solid black;width:15%;text-align:center'>Tindakan</td>
                        <td style='border: 1px solid black;width:15%;text-align:center'>Hasil</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>-</td>
                        <td style='border: 1px solid black;text-align:center'>-</td>
                        <td style='border: 1px solid black;text-align:center'>-</td>
                        <td style='border: 1px solid black;text-align:center'>-</td>
                    </tr>
                </tbody>
            </table>
            <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;width:15%;text-align:center'>Hasil counter mesin (sach)</td>
                        <td style='border: 1px solid black;width:15%;text-align:center'>Jumlah Hasil (sach)</td>
                        <td style='border: 1px solid black;width:15%;text-align:center'>Rusak (sach)</td>
                        <td style='border: 1px solid black;width:15%;text-align:center'>Jml litho terpakai (roll)</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>" . $countermesin . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $transaksi_topack['CounterPrinter'] . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $transaksi_topack['rejectedsch'] . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $usedlistho . "</td>
                    </tr>
                </tbody>
            </table>";
    $output .= "
            <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td rowspan=14 style='border: 1px solid black;width:10%; font-weight:bold'>VI. Rekonsiliasi Pengemasan Primer<br> Tgl: " . date('d/m') . "</td>
                        <td colspan=13 style='border: 1px solid black;width:20%;'>Berat serbuk per sachet: .... gr</td>
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
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>Tgl</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>Konversi Sachet</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
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
                        <td colspan=9><ul><li>Bila hasil nyata diluar batas hasil tersebut diatas laporkan kepada pengawas dan lakukan 'Penyelidikan terhadap kegagalan'</li></ul></td>
                        <td colspan=2><span style='font-size:20px;color:rgb(0, 0, 0);font-style:normal;font-weight:normal;'>&#11036;</span>OK</td>
                        <td colspan=2><span style='font-size:20px;color:rgb(0, 0, 0);font-style:normal;font-weight:normal;'>&#11036;</span>Tidak OK</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=7 style='border: 1px solid black;text-align:center'>Dibuat Oleh</td>r
                        <td colspan=7 style='border: 1px solid black;text-align:center'>Diperiksa Oleh</td>
                    </tr>
                </tbody>
            </table>
            ";
    $outputnon .= "
            <table style='width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr>
                        <td style='font-weight:bold'>&nbsp;DAFTAR PRODUK</td>
                    </tr>
                </tbody>
            </table>
            <table style='width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border:1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>Nama Produk</td>
                        <td style='border: 1px solid black;text-align:center'>Berat/sachet</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'>Nama Produk</td>
                        <td style='border: 1px solid black;text-align:center'>Berat/sachet</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'>Nama Produk</td>
                        <td style='border: 1px solid black;text-align:center'>Berat/sachet</td>
                        <td style='border: 1px solid black;text-align:center'></td>
                        <td style='border: 1px solid black;text-align:center'>Nama Produk</td>
                        <td style='border: 1px solid black;text-align:center'>Berat/sachet</td>
                    </tr>
                    <tr style='border:1px solid black'>
                        <td style='border: 1px solid black'>Kunyit Asam</td>
                        <td style='border: 1px solid black'>23.0 - 24.0 g</td>
                        <td ></td>
                        <td style='border: 1px solid black'>Kopi Energi</td>
                        <td style='border: 1px solid black'>20.5 - 21.5 g</td>
                        <td ></td>
                        <td style='border: 1px solid black'>ALF Jeruk</td>
                        <td style='border: 1px solid black'>9.5 - 10.0 g</td>
                        <td></td>
                        <td style='border: 1px solid black'>JW Komplit</td>
                        <td style='border: 1px solid black'>5.5 - 6.1 g</td>
                    </tr>
                    <tr style='border:1px solid black'>
                        <td style='border: 1px solid black'>KA Sirih</td>
                        <td style='border: 1px solid black'>23.0 - 24.0 g</td>
                        <td></td>
                        <td style='border: 1px solid black'>SJ & SJ Coklat</td>
                        <td style='border: 1px solid black'>25.0 - 26.0 g</td>
                        <td></td>
                        <td style='border: 1px solid black'>Tejamu</td>
                        <td style='border: 1px solid black'>23.0 - 24.0 g</td>
                        <td></td>
                        <td style='border: 1px solid black'>BK Komplit</td>
                        <td style='border: 1px solid black'>7.8 - 8.2 g</td>
                    </tr>
                    <tr style='border:1px solid black'>
                        <td style='border: 1px solid black'>KA Fiber</td>
                        <td style='border: 1px solid black'>11.0 - 12.0 g</td>
                        <td></td>
                        <td style='border: 1px solid black'>SJ Merah</td>
                        <td style='border: 1px solid black'>19.0 - 20.0 g</td>
                        <td></td>
                        <td style='border: 1px solid black'>Jahe Wangi</td>
                        <td style='border: 1px solid black'>23.0 - 24.0 g</td>
                        <td></td>
                        <td style='border: 1px solid black'>Konsentrat (alt)</td>
                        <td style='border: 1px solid black'>285 - 300 g</td>
                    </tr>
                    <tr style='border:1px solid black'>
                        <td style='border: 1px solid black'>Kopi Jahe</td>
                        <td style='border: 1px solid black'>25.0 - 26.5 g</td>
                        <td></td>
                        <td style='border: 1px solid black'>BK Minuman</td>
                        <td style='border: 1px solid black'>23.0 - 23.5g</td>
                        <td></td>
                        <td style='border: 1px solid black'>STMJ (alt)</td>
                        <td style='border: 1px solid black'>27.0 - 29.0 g</td>
                        <td></td>
                        <td style='border: 1px solid black'>Sukar</td>
                        <td style='border: 1px solid black'>20.2 - 21.6 g</td>
                    </tr>
                    <tr style='border:1px solid black'>
                        <td style='border: 1px solid black'>Kopi Jahe RG</td>
                        <td style='border: 1px solid black'>19.2 - 20.2 g</td>
                        <td></td>
                        <td style='border: 1px solid black'>Abak Sehat (alt)</td>
                        <td style='border: 1px solid black'>6.4 - 7.0 g</td>
                        <td></td>
                        <td style='border: 1px solid black'>Jamu Instan (alt)</td>
                        <td style='border: 1px solid black'>13.0 - 13.5 g</td>
                        <td></td>
                        <td style='border: 1px solid black'>Colamilk</td>
                        <td style='border: 1px solid black'>24.5 - 26.0 g</td>
                    </tr>
                    <tr style='border:1px solid black'>
                        <td style='border: 1px solid black'>Kopi Gingseng</td>
                        <td style='border: 1px solid black'>29.0 - 30.5 g</td>
                        <td></td>
                        <td style='border: 1px solid black'>ALH</td>
                        <td style='border: 1px solid black'>14.2 - 15.2 g</td>
                        <td></td>
                        <td style='border: 1px solid black'>Serbuk Telur</td>
                        <td style='border: 1px solid black'>4.5 - 5.1 g</td>
                        <td></td>
                        <td style='border: 1px solid black'>Colatrend</td>
                        <td style='border: 1px solid black'>14.7 - 15.2 g</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
";
} elseif ($laporan == 'rekontopack') {

    $sql = mysqli_query($conn, "SELECT * FROM transaksi_topack WHERE Plant='$plant' AND UnitCode='$unitcode' 
                                                                                    AND PlanningNumber ='$planningnumber'
                                                                                    AND Years='$years'");
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
        $createdon = $row['CreatedOn'];
        $createdby = $row['CreatedBy'];
    }
    $sql = mysqli_query($conn, "SELECT * FROM frm_approval WHERE UnitCode='$unitcode' AND FormTypes ='rekontopack'");
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
    $output = "
    <!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='../../../asset/css/css_report.css'>
    </head>";
    $output .= "
    <body>
        <div class='container'>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%'><center><img src='../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                        <td style='border: 1px solid black; text-align:center' rowspan=3>CATATAN PENGEMASAN BETS <br> PRIMER - SEKUNDER</td>
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
                        <td>Perhatian</td>
                        <td colspan=9>
                            Apabila terjadi penyimpangan terhadap suatu ketetapan laporkan dan tangani sesuai prosedur tindakan perbaikan dan pencegahan No PS-020000-01-00-004
                        </td>
                    </tr>
                    <tr style='border: 1px solid black;border-bottom:none !important'>
                        <td rowspan=28 style='border:1px solid black;vertical-align:text-top;font-weight:bold;width:10%'>IV. Penerimaan dan rekonsiliasi Bahan Pengemas Primer <br><br><br> V.Kodifikasi kemasan roll</td>
                        <td colspan=5 style='border:1px solid black;text-align:center'>Jenis Kemasan Roll (litho)</td>
                        <td colspan=2 style='border:1px solid black;text-align:center'>Produksi</td>
                        <td colspan=2 style='border:1px solid black;text-align:center'>Gudang</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=5 style='border:1px solid black;text-align:center'>Jumlah Roll</td>
                        <td colspan=2 rowspan=2 style='border:1px solid black'></td>
                        <td colspan=2 rowspan=2 style='border:1px solid black'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border:1px solid black;text-align:center'>Kebutuhan</td>
                        <td style='border:1px solid black;text-align:center'>Tambahan</td>
                        <td style='border:1px solid black;text-align:center'>Pemakaian</td>
                        <td colspan=2 style='border:1px solid black;text-align:center'>Pengembalian</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td rowspan=3 style='border:1px solid black;text-align:center'></td>
                        <td rowspan=3 style='border:1px solid black;text-align:center'></td>
                        <td rowspan=3 style='border:1px solid black;text-align:center'></td>
                        <td style='border:1px solid black;text-align:center'>Cacat Supplier</td>
                        <td style='border:1px solid black;text-align:center'>Kelebihan</td>
                        <td style='border:1px solid black;width:10%'>Nama</td>
                        <td style='border:1px solid black'></td>
                        <td style='border:1px solid black'>Nama</td>
                        <td style='border:1px solid black'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td rowspan=2 style='border:1px solid black;text-align:center'></td>
                        <td rowspan=2 style='border:1px solid black;text-align:center'></td>
                        <td style='border:1px solid black'>Jabatan</td>
                        <td style='border:1px solid black'></td>
                        <td style='border:1px solid black'>Jabatan</td>
                        <td style='border:1px solid black'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border:1px solid black'>Tgl</td>
                        <td style='border:1px solid black'>" . date('d-m-Y') . "</td>
                        <td style='border:1px solid black'>Tgl</td>
                        <td style='border:1px solid black'>" . date('d-m-Y') . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=4 style='border:1px solid black'>Nama Produk</td>
                        <td colspan=3 style='border:1px solid black'>ED/No Bets</td>
                        <td colspan=2 style='border:1px solid black'>Nama & No Mesin</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=4 style='border:1px solid black'>" . $produkname . "</td>
                        <td colspan=3 style='border:1px solid black'>" . $expdate . "/" . $batch . "</td>
                        <td colspan=2 style='border:1px solid black'>" . $namamesin . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=9 style='border:1px solid black'>
                            <li>Gunakan APD sesuai standar, pelindung pernapasan (masker) dan pelindung telinga (sesuai rambu APD). Diperiksa oleh ...... (paraf)...... </li>
                            <li>Periksa kebersihan ruangan, peralatan dan wadah sebelum melakukan kodifikasi kemasan</li>
                        </td>
                    </tr>
                    <tr style='border-right: 1px solid black'>
                        <td rowspan=2 colspan=3 style='font-weight:bold'>PENCETAKAN KODE KEMASAN ROLL</td>
                        <td rowspan=8></td>
                        <td colspan=5>Cetak No Bets dan Tgl Kadaluarsa pada sisi yang sudah ditentukan</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border:1px solid black'>Tanggal Cetak</td>
                        <td colspan=2></td>
                        <td colspan=2 style='border:1px solid black'></td>
                    </tr>
                    <tr style='border-right: 1px solid black'>
                        <td colspan=3>Sebelumnya digunakan untuk</td>
                        <td style='border:1px solid black'>Nama Operator</td>
                        <td colspan=2></td>
                        <td colspan=2 style='border:1px solid black'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Produk</td>
                        <td colspan=2 style='border:1px solid black'>" . $produkid . "</td>
                        <td style='border:1px solid black'>Nama Produk</td>
                        <td colspan=2>" . $produkid . "</td>
                        <td colspan=2 style='border:1px solid black'></td>
                    </tr>

                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>No Bets</td>
                        <td colspan=2 style='border:1px solid black'></td>
                        <td style='border:1px solid black'>No Bets</td>
                        <td colspan=2>" . $batch . "</td>
                        <td colspan=2 style='border:1px solid black'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Tgl Kadaluarsa</td>
                        <td colspan=2 style='border:1px solid black'></td>
                        <td style='border:1px solid black'>Tgl Kadaluarsa</td>
                        <td colspan=2>" . $expdate . "</td>
                        <td colspan=2 style='border:1px solid black'></td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-bottom:1px solid black'>
                        <td style='border: 1px solid black'>Operator</td>
                        <td colspan=2 style='border:1px solid black'>" . $createdby . "</td>
                        <td style='border:1px solid black'>Jam Mulai/Selesai</td>
                        <td colspan=2>" . $starttime . "/" . $endtime . "</td>
                        <td colspan=2 style='border:1px solid black'></td>
                    </tr>
                    <tr style='border-right:1px solid black;border-bottom:1px solid black'>
                        <td colspan=3></td>
                        <td style='border:1px solid black'>Pemeriksa/paraf</td>
                        <td colspan=2 style='border-right:1px solid black'></td>
                        <td colspan=2></td>
                    </tr>
                    <tr style='border-right: 1px solid black'>
                        <td colspan=9><ul><li>Periksakan hasil percetakan kepada pengawas pengemasan sekunder dan lampirkan 1 lembar kemasan dos yang telah tercetak pada lembar sebaliknya</li></ul></td>
                    </tr>
                    <tr style='border-right:1px solid black'>
                        <td colspan=9 style='font-weight:bold;font-size:10pt'>Rekonsiliasi Hasil Cetak</td>
                    </tr>
                    <tr style='border-right:1px solid black'>
                        <td colspan=3>(a) Jumlah yang diterima dari gudang</td>
                        <td>=</td>
                        <td></td>
                        <td>Lmbr</td>
                        <td colspan=3 style='font-weight:bold'>Keterangan perhitungan</td>
                    </tr>
                    <tr style='border-right:1px solid black'>
                        <td colspan=3>(b) Jumlah yang dikembalikan</td>
                        <td>=</td>
                        <td></td>
                        <td>Lmbr</td>
                        <td colspan=3><ul><li>(e) = a-(b+c+d)</li></ul></td>
                    </tr>
                    <tr style='border-right:1px solid black'>
                        <td colspan=3>(c) Jumlah yang dicetak</td>
                        <td>=</td>
                        <td></td>
                        <td>Lmbr</td>
                        <td colspan=3><ul><li>(f) = (e)/(a)x100%</li></ul></td>
                    </tr>
                    <tr style='border-right:1px solid black'>
                        <td colspan=3>(d) Jumlah yang rusak selama percetakan</td>
                        <td>=</td>
                        <td></td>
                        <td>Lmbr</td>
                        <td colspan=3 style='font-weight:bold'>Batas toleransi selisih = 1%</td>
                    </tr>
                    <tr style='border-right:1px solid black'>
                        <td></td>
                        <td colspan=2>(e) Selisih</td>
                        <td>=</td>
                        <td></td>
                        <td colspan=4>Lmbr</td>
                    </tr>
                    <tr style='border-right:1px solid black'>
                        <td></td>
                        <td colspan=2>(f) Presentase</td>
                        <td>=</td>
                        <td></td>
                        <td colspan=4>%</td>
                    </tr>
                    <tr style='border-right:1px solid black'>
                        <td colspan=9><ul><li>Bila hasil diluar batas hasil tersebut diatas, laporkan kepada pengawas dan lakukan 'Penyelidikan terhadap kegagalan'</li></ul></td>
                    </tr>
                    <tr style='border-right:1px solid black'>
                        <td colspan=9 style='font-weight:bold;font-size:10pt'>Hasil Penyelidikan</td>
                    </tr>
                    <tr style='border-right:1px solid black'>
                        <td colspan=3>Keputusan:</td>
                        <td><span style='font-size:20px;color:rgb(0, 0, 0);font-style:normal;font-weight:normal;'>&#11036;</span>OK</td>
                        <td colspan=2><span style='font-size:20px;color:rgb(0, 0, 0);font-style:normal;font-weight:normal;'>&#11036;</span>Tidak OK</td>
                        <td colspan=3>(Lampirkan dokumen berkaitan)</td>
                    </tr>
                </tbody>
            </table>
            <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td rowspan=14 style='border: 1px solid black;width:10%; font-weight:bold'>VI. Rekonsiliasi Pengemasan Primer<br> Tgl: " . date('d/m') . "</td>
                        <td colspan=13 style='border: 1px solid black;width:20%;'>Berat serbuk per sachet: .... gr</td>
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
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>Tgl</td>
                        <td colspan=3 style='border: 1px solid black;text-align:center'>Konversi Sachet</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
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
                        <td colspan=9><ul><li>Bila hasil nyata diluar batas hasil tersebut diatas laporkan kepada pengawas dan lakukan 'Penyelidikan terhadap kegagalan'</li></ul></td>
                        <td colspan=2><span style='font-size:20px;color:rgb(0, 0, 0);font-style:normal;font-weight:normal;'>&#11036;</span>OK</td>
                        <td colspan=2><span style='font-size:20px;color:rgb(0, 0, 0);font-style:normal;font-weight:normal;'>&#11036;</span>Tidak OK</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=7 style='border: 1px solid black;text-align:center'>Dibuat Oleh</td>r
                        <td colspan=7 style='border: 1px solid black;text-align:center'>Diperiksa Oleh</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
";
} elseif ($laporan == 'preparepillow') {

    function gethasilperiksa_preparepillow($planningnumber, $parameter, $years)
    {
        include '../../../function/koneksi.php';
        $return = '';
        $plant = $_SESSION['plant'];
        $unitcode = $_SESSION['unitcode'];
        $values = GetdataIV($parameter, 'proses_prepare_pillow', 'Plant', $plant, 'UnitCode', $unitcode, 'PlanningNumber', $planningnumber, 'Years', $years);
        if ($values == 'true') {
            $return = 'OK';
        } else {
            $return = $values;
        }
        return $return;
    }
    // Sampai disini
    $sql = mysqli_query($conn, "SELECT * FROM transaksi_pillow WHERE Plant='$plant' AND UnitCode='$unitcode' AND PlanningNumber ='$planningnumber' AND Years='$years'");
    $transaksi = mysqli_fetch_array($sql);
    $sql = mysqli_query($conn, "SELECT * FROM reject_lulus_rekonsiliasipillow WHERE PlanningNumber =" . $planningnumber . " AND Years='$years'");
    $jumlah_reject = 0;
    if (mysqli_num_rows($sql) != 0) {
        while ($reject_pillow = mysqli_fetch_array($sql)) {
            $jumlah_reject = $jumlah_reject + $reject_pillow['Jumlah'];
        }
    }

    $sql = mysqli_query($conn, "SELECT * FROM transaksi_rekon_pillow WHERE PlanningNumber =" . $planningnumber . " AND Years='$years'");
    $recon_pillow = mysqli_fetch_array($sql);
    $jml_kemasan_terpakai = '';
    if (mysqli_num_rows($sql) != 0) {
        if ($recon_pillow['Dus'] != 0) {
            $jml_kemasan_terpakai =  $recon_pillow['Dus'] . ' Dus';
        }
        if ($recon_pillow['Brosur'] != 0) {
            $jml_kemasan_terpakai = $jml_kemasan_terpakai . ' ' . $recon_pillow['Brosur'] . ' Brosur';
        }
        if ($recon_pillow['Hanger'] != 0) {
            $jml_kemasan_terpakai = $jml_kemasan_terpakai . ' ' . $recon_pillow['Hanger'] . ' Brosur';
        }
        if ($recon_pillow['Stiker'] != 0) {
            $jml_kemasan_terpakai = $jml_kemasan_terpakai . ' ' . $recon_pillow['Stiker'] . ' Stiker';
        }
        if ($recon_pillow['Tbox'] != 0) {
            $jml_kemasan_terpakai = $jml_kemasan_terpakai . ' ' . $recon_pillow['Tbox'] . ' Box';
        }
        if ($recon_pillow['Plastik'] != 0) {
            $jml_kemasan_terpakai = $jml_kemasan_terpakai . ' ' . $recon_pillow['Plastik'] . ' Plastik';
        }
    }

    $sql = mysqli_query($conn, "SELECT * FROM frm_approval WHERE UnitCode='" . $_SESSION["unitcode"] . "' AND FormTypes ='preparepillow'");
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
    $sql = mysqli_query($conn, "SELECT * FROM proses_prepare_pillow WHERE PlanningNumber =" . $planningnumber . " AND Years='$years'");
    $row = mysqli_fetch_array($sql);

    $output = "
    <!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='../../../asset/css/css_report.css'>
    </head>";
    $output .= "
    <body>
        <div class='container'>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%'><center><img src='../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                        <td style='border: 1px solid black; text-align:center' rowspan=3>CATATAN PENGEMASAN BETS <br> PRIMER - SEKUNDER</td>
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
                        <td colspan=2 rowspan=2 style='border: 1px solid black; text-align:center'>$produkname</td>
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
                        <td colspan=12 style='border: 1px solid black;font-weight:bold'>VII. DAFTAR PERIKSA KESIAPAN JALUR PENGEMASAN SEKUNDER</td>
                    </tr>
                </tbody>
            </table>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;font-weight:bold;text-align:center'>No</td>
                        <td colspan=6 style='border: 1px solid black;font-weight:bold;text-align:center;width:50%'>Uraian Pemeriksaan</td>
                        <td style='border: 1px solid black;font-weight:bold;text-align:center'>Hasil Periksa</td>
                        <td style='border: 1px solid black;font-weight:bold;text-align:center'>Pelaksana</td>
                        <td style='border: 1px solid black;font-weight:bold;text-align:center'>Pemeriksa</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>1</td>
                        <td colspan=6 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', 1) . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_preparepillow($planningnumber, 'Parameter_1', $years) . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $row['FirstOperator'] . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $row['PengawasProduksi'] . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>2</td>
                        <td colspan=6 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', 2) . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_preparepillow($planningnumber, 'Parameter_2', $years) . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $row['FirstOperator'] . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $row['PengawasProduksi'] . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td rowspan=3 style='border: 1px solid black;text-align:center'>3</td>
                        <td colspan=6 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', 3) . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_preparepillow($planningnumber, 'Parameter_3', $years) . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $row['FirstOperator'] . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $row['PengawasProduksi'] . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=6 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', 31) . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_preparepillow($planningnumber, 'Parameter_3', $years) . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $row['FirstOperator'] . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $row['PengawasProduksi'] . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=6 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', 32) . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_preparepillow($planningnumber, 'Parameter_3', $years) . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $row['FirstOperator'] . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $row['PengawasProduksi'] . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td rowspan=5 style='border: 1px solid black;text-align:center'>4</td>
                        <td colspan=6 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', 4) . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_preparepillow($planningnumber, 'Parameter_4', $years) . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $row['FirstOperator'] . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $row['PengawasProduksi'] . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_preparepillow($planningnumber, 'Satuan_1', $years) . "</td>
                        <td style='border: 1px solid black'>" . gethasilperiksa_preparepillow($planningnumber, 'Qty_1', $years) . "</td>
                        <td style='border: 1px solid black'>" . gethasilperiksa_preparepillow($planningnumber, 'Satuan_3', $years) . "</td>
                        <td style='border: 1px solid black'>" . gethasilperiksa_preparepillow($planningnumber, 'Qty_3', $years) . "</td>
                        <td style='border: 1px solid black'>" . gethasilperiksa_preparepillow($planningnumber, 'Satuan_5', $years) . "</td>
                        <td style='border: 1px solid black'>" . gethasilperiksa_preparepillow($planningnumber, 'Qty_5', $years) . "</td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_preparepillow($planningnumber, 'Satuan_2', $years) . "</td>
                        <td style='border: 1px solid black'>" . gethasilperiksa_preparepillow($planningnumber, 'Qty_1', $years) . "</td>
                        <td style='border: 1px solid black'>" . gethasilperiksa_preparepillow($planningnumber, 'Satuan_4', $years) . "</td>
                        <td style='border: 1px solid black'>" . gethasilperiksa_preparepillow($planningnumber, 'Qty_4', $years) . "</td>
                        <td style='border: 1px solid black'>" . gethasilperiksa_preparepillow($planningnumber, 'Satuan_6', $years) . "</td>
                        <td style='border: 1px solid black'>" . gethasilperiksa_preparepillow($planningnumber, 'Qty_6', $years) . "</td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>No Bets</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>Tgl Pencampuran</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>Tgl Kadaluarsa</td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>$batch</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>$mixingdate</td>
                        <td colspan=2 style='border: 1px solid black;text-align:center'>$expdate</td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                        <td style='border: 1px solid black'></td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td rowspan=5 style='border: 1px solid black;text-align:center'>5</td>
                        <td colspan=6 style='border: 1px solid black'>" . GetdataII('Descriptions', 'text_sys', 'JenisProses', 'pillowpack', 'Item', 5) . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_preparepillow($planningnumber, 'Parameter_5', $years) . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $row['FirstOperator'] . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $row['PengawasProduksi'] . "</td>
                    </tr>
                </tbody>
            </table>
            <table style='margin-bottom:1px;border: 1px solid black' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td colspan=9 style='border: 1px solid black;font-weight:bold'>VII. PENGEMASAN SEKUNDER</td>
                        <td style='border: 1px solid black;font-weight:bold;text-align:center'>Pelaksana</td>
                        <td style='border: 1px solid black;font-weight:bold;text-align:center'>Pemeriksa</td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td colspan=9 style='border: 1px solid black;font-weight:bold'>B. RENTENG DAN HANGER (5,10)*</td>
                        <td rowspan=4 style='border: 1px solid black;text-align:center'>" . $row['FirstOperator'] . "</td>
                        <td rowspan=4 style='border: 1px solid black;text-align:center'>" . $row['PengawasProduksi'] . "</td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td>1</td>
                        <td colspan=8>Masukan setiap renteng dan hanger (bila ada) kedalam plastik ukuran</td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td>2</td>
                        <td colspan=8>Masukan setiap (12,18,20,24,60)* plastik pada point 1 ke dalam box dan segel box dengan carton sealer</td>
                    </tr>
                    <tr style='border-right: 1px solid black;border-left:1px solid black'>
                        <td style='vertical-align:text-top'>3</td>
                        <td colspan=8>Timbang tiap box dan cetak spesifikasi pada box <br> (kode produk, tanggal kemas,shift,jam,kode operator, ED,Nomor Line,nomor untuk kemas,bobot)</td>
                    </tr>
                </tbody>
            </table>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td colspan=10 style='border: 1px solid black;font-weight:bold'>IX. HASIL PENGEMASAN SEKUNDER</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;font-weight:bold;text-align:center'>Hasil Pengemasan</td>
                        <td style='border: 1px solid black;font-weight:bold;text-align:center'>Hsl Counter Mesin</td>
                        <td style='border: 1px solid black;font-weight:bold;text-align:center'>Jumlah Kemasan Terpakai</td>
                        <td colspan=7 style='border: 1px solid black;font-weight:bold;text-align:center'>Tidak Lulus/Reject</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;text-align:center'>" . $recon_pillow['HasilPengemasan'] . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $recon_pillow['CounterMesin'] . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $jml_kemasan_terpakai . "</td>
                        <td colspan=7 style='border: 1px solid black;text-align:center'>" . $jumlah_reject . "</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
";
} elseif ($laporan == 'tinjauanqa') {

    $sql = mysqli_query($conn, "SELECT * FROM proses_review_quality WHERE PlanningNumber =" . $planningnumber . " AND ReviewQA='X'");
    $row = mysqli_fetch_array($sql);
    function gethasilperiksa_reviewqa($planningnumber, $parameter)
    {
        include '../../../function/koneksi.php';
        $return = '';
        $values = Getdata($parameter, 'proses_review_quality', 'PlanningNumber', $planningnumber);
        if ($values == 'true') {
            $return = '&#10004';
        } else {
            $return = '&#x2212;';
        }
        return $return;
    }
    function gethasilud_reviewqa($planningnumber, $parameter, $default)
    {
        include '../../../function/koneksi.php';
        $return = '';
        $values = Getdata($parameter, 'proses_review_quality', 'PlanningNumber', $planningnumber);
        if ($values == $default) {
            $return = '&#9745;';
        }
        return $return;
    }
    $query  = mysqli_query($conn, "SELECT CreatedOn FROM proses_prepare_pillow WHERE PlanningNumber='$planningnumber'");
    $q = mysqli_fetch_array($query);
    $tanggalpacking = strtotime($q['CreatedOn']);
    $tanggalpacking = date('d M Y', $tanggalpacking);
    $query  = mysqli_query($conn, "SELECT HasilPengemasan FROM transaksi_rekon_pillow WHERE PlanningNumber='$planningnumber'");
    $q = mysqli_fetch_array($query);
    $hasilkemas = number_format($q['HasilPengemasan'], 0, ",", ".");;
    $query  = mysqli_query($conn, "SELECT HasilNyata FROM transaksi_topack WHERE PlanningNumber='$planningnumber'");
    $q = mysqli_fetch_array($query);
    $hasilnyata = number_format($q['HasilNyata'], 0, ",", ".");
    $output = "
    <!doctype html>
    <html lang='en'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='../../../asset/css/bootstrap.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='../../../asset/css/css_report.css'>
    </head>";
    $output .= "
    <body>
        <div class='container'>
            <table style='margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%'><center><img src='../../../asset/img/sidomuncul.png' style='width:10%'></center></td>
                        <td style='border: 1px solid black; text-align:center' rowspan=3>TINJAUAN QA <br> CATATAN PENGEMASAN BETS</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center'>PEMASTIAN MUTU</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='width:15%; text-align:center'></td>
                    </tr>
                </tbody>
            </table>
            <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black;width:15%;'>No Dokumen</td>
                        <td style='border: 1px solid black;width:20%;'>FM-020000-01-00-022</td>
                        <td style='border: 1px solid black;width:15%;'>No Revisi</td>
                        <td style='border: 1px solid black;width:10%;'>01</td>
                        <td style='border: 1px solid black;width:15%;'>Tanggal Berlaku</td>
                        <td style='border: 1px solid black;width:25%;'>17 Februari 2020</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border: 1px solid black'>Mengganti No</td>
                        <td style='border: 1px solid black'>FM-020000-01-00-022</td>
                        <td style='border: 1px solid black'>No Revisi</td>
                        <td style='border: 1px solid black'>00</td>
                        <td style='border: 1px solid black'>Tanggal Berlaku</td>
                        <td style='border: 1px solid black'>03 Oktober 2016</td>
                    </tr>
                </tbody>
            </table>
            <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                    <tr>
                        <td rowspan=24 style='width:5%'></td>
                        <td colspan=8 style='text-align:right;padding-bottom:1rem'>Rujukan: Dokumen Produksi Induk No DP-021020.08.12.028</td>
                    </tr>
                    <tr>
                        <td style='width:10%'>Kode Produk</td>
                        <td colspan=6>: " . $produkid . "</td>
                        <td rowspan=23 style='width:5%'></td>
                    </tr>
                    <tr>
                        <td style='width:10%'>No Bets</td>
                        <td colspan=5>: " . $expdate . "/" . $batch . "</td>
                    </tr>
                    <tr style='padding-bottom:2rem'>
                        <td style='width:10%'>Ukuran Bets</td>
                        <td colspan=5 >: " . $hasilnyata . " " . $uom . "</td>
                    </tr>
                    <tr>
                        <td style='padding-bottom:1rem'></td>
                    </tr>
                    <tr>
                        <td colspan=7 style='font-weight:bold'>REKONSILIASI HASIL PACKING</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td style='border-left: 1px solid black;text-align:center'>Tgl Packing</td>
                        <td style='border: 1px solid black;text-align:center'>Jumlah</td>
                        <td style='border: 1px solid black;text-align:center'>Jenis kemasan</td>
                    </tr> 
                    <tr style='border: 1px solid black'>
                        <td style='border-left: 1px solid black;text-align:center'>" . $tanggalpacking . "</td>
                        <td style='border: 1px solid black;text-align:center'>" . $hasilkemas . "</td>
                        <td style='border: 1px solid black;text-align:center'>Carton</td>
                    </tr>
                    <tr>
                        <td style='padding-bottom:1rem'></td>
                    </tr>
                    <tr>
                        <td colspan=7 style='font-weight:bold'>TINJAUAN QA</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border-left: 1px solid black;text-align:center'>Kodifikasi</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_reviewqa($planningnumber, 'Var_1') . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border-left: 1px solid black;text-align:center'>Rekonsiliasi Bahan Pengemas</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_reviewqa($planningnumber, 'Var_2') . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border-left: 1px solid black;text-align:center'>Rekonsiliasi Bahan Kemas</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_reviewqa($planningnumber, 'Var_2') . "</td>
                    </tr>    
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border-left: 1px solid black;text-align:center'>Rekonsiliasi Produk Jadi</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_reviewqa($planningnumber, 'Var_3') . "</td>
                    </tr>  
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border-left: 1px solid black;text-align:center'>Kebenaran Kemasan</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_reviewqa($planningnumber, 'Var_4') . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border-left: 1px solid black;text-align:center'>Jalur Pengemasan (Line Clearance)</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_reviewqa($planningnumber, 'Var_5') . "</td>
                    </tr>
                    <tr>
                        <td style='padding-bottom:1rem'></td>
                    </tr>
                    <tr>
                        <td colspan=7 style='font-weight:bold'>KEBENARAN INFORMASI</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border-left: 1px solid black;text-align:center'>Kemasan Primer (sachet,strip,botol)</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_reviewqa($planningnumber, 'Var_6') . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border-left: 1px solid black;text-align:center'>Kemasan Sekunder (dus,hanger,shrink,etiket)</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_reviewqa($planningnumber, 'Var_7') . "</td>
                    </tr>
                    <tr style='border: 1px solid black'>
                        <td colspan=2 style='border-left: 1px solid black;text-align:center'>Insert Brosur</td>
                        <td style='border: 1px solid black;text-align:center'>" . gethasilperiksa_reviewqa($planningnumber, 'Var_8') . "</td>
                    </tr>    
                    <tr>
                        <td style='padding-bottom:1rem'></td>
                    </tr>
                    <tr>
                        <td colspan=8 style='font-weight:bold'>CATATAN</td>
                    </tr> 
                    <tr>
                        <td>Hasil</td>
                        <td>" . gethasilud_reviewqa($planningnumber, 'UsageDecision', 'Lulus') . " Lulus</td>
                        <td>" . gethasilud_reviewqa($planningnumber, 'UsageDecision', 'Tidak Lulus') . " Tidak Lulus</td>
                    </tr>
                    <tr>
                        <td style='padding-bottom:1rem'></td>
                    </tr>               
                </tbody>
            </table>
            <table style='border: 1px solid black; width:100%; margin-bottom:1px' cellpadding=2 cellspacing=0>
                <tbody>
                <tr>
                <td colspan=4 style='text-align:center'>Pemeriksaan Catatan Pengemasan Bets</td>
                <td colspan=4 style='text-align:center'>Peninjauan Catatan Pengemasan Bets</td>
                </tr> 
                <tr>
                    <td colspan=4 style='text-align:center'>Kepala Produksi/Tgl</td>
                    <td colspan=4 style='text-align:center'>Manajer Pemastian Mutu/Tgl</td>
                </tr>
                <tr>
                    <td colspan=4 style='padding-bottom:4rem'></td>
                    <td colspan=4 style='padding-bottom:4rem'></td>
                </tr>
                <tr>
                    <td colspan=4 style='text-align:center'>(T. Maya H) / " . date('d m Y') . "</td>
                    <td colspan=4 style='text-align:center'>(Dwi W) / " . date('d m Y') . "</td>
                </tr>
                </tbody>
            </table>
        </div>
    </body>
";
}


$mpdf = new \Mpdf\Mpdf();
// left,right,top,bottom.
$mpdf->AddPage('P', '', '', '', '', 5, 5, 5, 5, 10, 10);
$mpdf->WriteHTML($output);
$mpdf->SetTitle($filename);
$mpdf->Output($filename, 'I');
