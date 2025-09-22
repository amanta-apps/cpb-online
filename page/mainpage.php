<?php
// include '../function/session.php';
include '../function/getvalue.php';
session_start();
$plant = $_SESSION['plant'];
$unitcode = $_SESSION['unitcode'];
$pernr = $_SESSION['personnelnumber'];
if (!isset($_SESSION['userid'])) {
    header('Location: ../');
}
$client = '300';
if ($_SESSION['client'] == 'db_sisp_100') {
    $client = '100';
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="../asset/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/mycss.css">
    <link rel="shortcut icon" href="../asset/img/sm.png">
    <!-- Data Table -->
    <link rel="stylesheet" href="../asset/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../asset/datatable/bootstrap.min.css">
    <link rel="stylesheet" href="../asset/css/tagify.css">
    <script type="text/javascript" src="../asset/js/loader.js"></script>
    <!-- <xsl:output method="text" version="1.0" encoding="UTF-8" omit-xml-declaration="yes" /> -->
    <!-- End -->
    <title>CPB Online</title>
</head>

<body tabindex="0" onload="Accesprogram('<?= $_SESSION['userid'] ?>')">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand text-primary fw-bold" href="#" onclick="showversionaplikasi()"><img src="../asset/icon/cpb2.png"><span style="font-size: 10pt;">CPB</span>
                <sup style="font-size: 10pt;"><span class="badge bg-transparent text-warning text_glowing">v1.09</span></sup>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="main_nav">
                <ul class="navbar-nav">
                    <li class="nav-item active"> <a class="nav-link text-white" id="menudashboard" href="mainpage?p=dashboard" hidden>Dashboard </a> </li>
                    <li class="nav-item dropdown" id="myDropdown">
                        <a class="nav-link dropdown-toggle text-white" id="menumasterdata" href="#" data-bs-toggle="dropdown" hidden> Master Data </a>
                        <ul class="dropdown-menu">
                            <li> <a class="dropdown-item" id="submenuproduct" href="mainpage?p=product" hidden> Product </a></li>
                            <li> <a class="dropdown-item" id="submenushift" href="#" hidden> Shift &raquo; </a>
                                <ul class="submenu dropdown-menu">
                                    <li><a class="dropdown-item" id="subsubmenushift" href="mainpage?p=shift" hidden>Shift</a></li>
                                    <li><a class="dropdown-item" id="subsubmenushiftrangetime" href="mainpage?p=shiftrangetime" hidden>Shift Range Time</a></li>
                                </ul>
                            </li>
                            <li> <a class="dropdown-item" id="submenuresources" href="#" hidden> Resources &raquo; </a>
                                <ul class="submenu dropdown-menu">
                                    <li><a class="dropdown-item" id="subsubmenumainresources" href="mainpage?p=mainresources" hidden>Main Resources</a></li>
                                    <li><a class="dropdown-item" id="subsubmenuprimaryresources" href="mainpage?p=primaryresources" hidden>Primary Resources</a></li>
                                    <li><a class="dropdown-item" id="subsubmenusecondaryresources" href="mainpage?p=secondaryresources" hidden>Secondary Resources</a></li>
                                    <li><a class="dropdown-item" id="subsubmenumixingresources" href="mainpage?p=mixingresources" hidden>Mixing Resources</a></li>
                                </ul>
                            </li>
                            <li> <a class="dropdown-item" id="submenuprofiles" href="#" hidden> Profiles &raquo; </a>
                                <ul class="submenu dropdown-menu">
                                    <li><a class="dropdown-item" id="subsubmenuemployee" href="mainpage?p=employee" hidden>Employee</a></li>
                                    <li><a class="dropdown-item" id="subsubmenuuserauth" href="mainpage?p=userauth" hidden>User Authorization</a></li>
                                    <li><a class="dropdown-item" id="subsubmenujobposition" href="mainpage?p=jobposition" hidden>Job Positions</a></li>
                                </ul>
                            </li>
                            <li> <a class="dropdown-item" id="submenusupplier" href="mainpage?p=supplier" hidden> Supplier </a></li>
                            <li> <a class="dropdown-item" id="submenureviewer" href="mainpage?p=reviewer" hidden> Reviewer </a></li>
                            <li> <a class="dropdown-item" id="submenumappingtimbangan" href="mainpage?p=mappingtimbangan" hidden> Mapping Timbangan </a></li>
                            <li> <a class="dropdown-item" id="submenumic" href="#" hidden> Master of Inspection &raquo; </a>
                                <ul class="submenu dropdown-menu">
                                    <li><a class="dropdown-item" id="subsubmenucreatemic" href="mainpage?p=createmic" hidden>Create Master insp. char</a></li>
                                    <li><a class="dropdown-item" id="subsubmenuassignmic" href="mainpage?p=assignmic" hidden>Assign Master insp. char</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown" id="myDropdown">
                        <a class="nav-link dropdown-toggle text-white" id="menuproduction" href="#" data-bs-toggle="dropdown" hidden> Production </a>
                        <ul class="dropdown-menu">
                            <li> <a class="dropdown-item" id="submenuplanning" href="#" hidden> Planning &raquo; </a>
                                <ul class="submenu dropdown-menu">
                                    <li><a class="dropdown-item" id="subsubmenucreateplanningpengolahan" href="mainpage?p=createplanningpengolahan" hidden>Create Planning Pengolahan</a></li>
                                    <li><a class="dropdown-item" id="subsubmenucreateplanning" href="mainpage?p=createplanning" hidden>Create Planning Pengemasan</a></li>
                                    <li><a class="dropdown-item" id="subsubmenustartdisplayplanning" href="#" hidden>Change/Display &raquo; </a>
                                        <ul class="submenu dropdown-menu">
                                            <li><a class="dropdown-item" id="subsubsubmenudisplaydatapengolahan" href="mainpage?p=displaydatapengolahan" hidden>Data Pengolahan</a></li>
                                            <li><a class="dropdown-item" id="subsubsubmenudisplaydatapengemasan" href="mainpage?p=displaydatapengemasan" hidden>Data Pengemasan</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="dropdown-item" id="subsubmenuapprovalplanning" href="mainpage?p=approvalplanning" hidden>Approval Planning</a></li>
                                    <li><a class="dropdown-item" id="subsubmenudisplaydata" href="mainpage?p=displaydata" hidden>Display Data</a></li>
                                    <li><a class="dropdown-item" id="subsubmenuprintworkorder" href="mainpage?p=printworkorder" hidden>Print Work Order</a></li>
                                    <li><a class="dropdown-item" id="subsubmenuprintlabelbahan" href="mainpage?p=printlabelbahan">Print Label bahan </a></li>
                                    <li><a class="dropdown-item" id="subsubmenunomorlot" href="mainpage?p=nomorlot" hidden>Set Up Nomor Lot</a></li>
                                    <li><a class="dropdown-item" id="subsubmenulacakbatch" href="mainpage?p=lacakbatch" hidden>Lacak Batch Planning</a></li>
                                    <li><a class="dropdown-item" id="subsubmenuchecklistmesin" href="mainpage?p=checklistmesin" hidden>Checklist Mesin</a></li>
                                </ul>
                            </li>
                            <li> <a class="dropdown-item" id="submenupreparing" href="#" hidden>Preparing Process &raquo; </a>
                                <ul class="submenu dropdown-menu">
                                    <li><a class="dropdown-item" id="subsubmenupreparepengolahan" href="mainpage?p=persiapanpengolahan" hidden>Mixer</a></li>
                                    <li><a class="dropdown-item" id="subsubmenuhoper" href="mainpage?p=persiapanhoper" hidden>Hoper</a></li>
                                    <li><a class="dropdown-item" id="subsubmenutopack" href="mainpage?p=persiapantopack" hidden>Topack</a></li>
                                    <li><a class="dropdown-item" id="subsubmenupillowpack" href="mainpage?p=persiapanpillow" hidden>Pillow Pack</a></li>
                                </ul>
                            </li>
                            <!-- <li> <a class="dropdown-item" id="submenuexecutionmixer" href="mainpage?p=executionmixer" hidden> Execution Mixer</a></li>
                            <li> <a class="dropdown-item" id="submenuexecutionhopper" href="mainpage?p=executionhoper" hidden> Execution Hopper</a></li> -->
                            <!-- <li> <a class="dropdown-item" id="submenuexecutiontopack" href="#" hidden>Execution Topack &raquo; </a>
                                <ul class="submenu dropdown-menu">
                                    <li><a class="dropdown-item" id="subsubmenutopackengineset" href="mainpage?p=topackengineset" hidden>Engine Set</a></li>
                                    <li><a class="dropdown-item" id="subsubmenutopackproductionsampling" href="mainpage?p=topackproductionsampling" hidden>Production Sampling</a></li>
                                    <li><a class="dropdown-item" id="subsubmenutopackreconciles" href="mainpage?p=topackreconciles" hidden>Reconciliation Topack</a></li>
                                </ul>
                            </li>
                            <li> <a class="dropdown-item" id="submenuexecutionpillowpack" href="#" hidden>Execution Pillow Pack &raquo; </a>
                                <ul class="submenu dropdown-menu">
                                    <li><a class="dropdown-item" id="subsubmenupillowproductionsampling" href="mainpage?p=prosespillow" hidden>Proses Pillow Pack</a></li>
                                    <li><a class="dropdown-item" id="subsubmenupillowreconciles" href="mainpage?p=pillowpackreconciles" hidden>Reconciliation Pillow Pack</a></li>
                                </ul>
                            </li> -->
                            <li> <a class="dropdown-item" id="submenuprosesexecution" href="#">Proses Execution &raquo; </a>
                                <ul class="submenu dropdown-menu">
                                    <li> <a class="dropdown-item" id="submenuexecutionhopper" href="mainpage?p=executionhoper" hidden> Execution Hopper</a></li>
                                    <li> <a class="dropdown-item" id="submenuexecutiontopack" href="#" hidden>Execution Topack &raquo; </a>
                                        <ul class="submenu dropdown-menu">
                                            <li><a class="dropdown-item" id="subsubmenutopackengineset" href="mainpage?p=topackengineset" hidden>Engine Set</a></li>
                                            <li><a class="dropdown-item" id="subsubmenutopackproductionsampling" href="mainpage?p=topackproductionsampling" hidden>Production Sampling</a></li>
                                            <li><a class="dropdown-item" id="subsubmenutopackreconciles" href="mainpage?p=topackreconciles" hidden>Reconciliation Topack</a></li>
                                        </ul>
                                    </li>
                                    <li> <a class="dropdown-item" id="submenuexecutionpillowpack" href="#" hidden>Execution Pillow Pack &raquo; </a>
                                        <ul class="submenu dropdown-menu">
                                            <li><a class="dropdown-item" id="subsubmenupillowproductionsampling" href="mainpage?p=prosespillow" hidden>Proses Pillow Pack</a></li>
                                            <li><a class="dropdown-item" id="subsubmenupillowreconciles" href="mainpage?p=pillowpackreconciles" hidden>Reconciliation Pillow Pack</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li> <a class="dropdown-item" id="submenuapprovalproses" href="mainpage?p=approvalproses" hidden> Approval Proses </a></li>
                            <li> <a class="dropdown-item" id="submenuprosestimbang" href="#" hidden>Proses Timbang &raquo; </a>
                                <ul class="submenu dropdown-menu">
                                    <li><a class="dropdown-item" id="subsubmenutimbangbahan" href="mainpage?p=timbangbahan" hidden>Timbang Bahan</a></li>
                                    <li><a class="dropdown-item" id="subsubmenuhistorytimbang" href="mainpage?p=historytimbang" hidden>History Timbang</a></li>
                                    <li><a class="dropdown-item" id="subsubmenulabelpalet" href="mainpage?p=labelpalet" hidden>Print Label Palet</a></li>
                                    <li><a class="dropdown-item" id="subsubmenukirimbahan" href="mainpage?p=kirimbahan" hidden>Kirim Bahan (Pallet)</a></li>
                                    <li><a class="dropdown-item" id="subsubmenuterimabahan" href="mainpage?p=terimabahan" hidden>Terima Bahan (Pallet)</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item"> <a class="nav-link text-white" id="submenumanajemenstok" href="mainpage?p=manajemenstok" hidden>Manajemen Stok </a> </li>
                    <li class=" nav-item dropdown" id="myDropdown">
                        <a class="nav-link dropdown-toggle text-white" id="menuquality" href="#" data-bs-toggle="dropdown" hidden>Quality</a>
                        <ul class="dropdown-menu">
                            <li> <a class="dropdown-item" id="submenuanalisaqc" href="#" hidden>Analisa Quality &raquo;</a>
                                <ul class="submenu dropdown-menu">
                                    <li> <a class="dropdown-item" id="submenuorganoleptis" href="mainpage?p=organoleptis" hidden>Analisa Organoleptis</a></li>
                                    <li> <a class="dropdown-item" id="submenurh_suhu" href="mainpage?p=rh_suhu" hidden>Analisa Rh & Suhu</a></li>
                                    <li> <a class="dropdown-item" id="submenuanalisapengemasanprimer" href="mainpage?p=analisapengemasanprimer" hidden>Analisa Kemas Primer</a></li>
                                    <li> <a class="dropdown-item" id="submenuanalisapengemasansekunder" href="mainpage?p=analisapengemasansekunder" hidden>Analisa Kemas Sekunder</a></li>
                                </ul>
                            </li>
                            <li> <a class="dropdown-item" id="submenureviewquality" href="mainpage?p=reviewquality" hidden>Review Quality</a></li>
                            <li> <a class="dropdown-item" id="submenucekstatusqc" href="mainpage?p=cekstatusqc" hidden>Cek Status QC</a></li>
                            <li> <a class="dropdown-item" id="submenuprintlabelambilsample" href="mainpage?p=printlabelambilsample" hidden>Print Label</a></li>
                            <li> <a class="dropdown-item" id="submenukarantina" href="mainpage?p=karantina" hidden>Karantina</a></li>
                        </ul>
                    </li>
                    <li class=" nav-item dropdown" id="myDropdown">
                        <a class="nav-link dropdown-toggle text-white" id="menureport" href="#" data-bs-toggle="dropdown" hidden>Report</a>
                        <ul class="dropdown-menu">
                            <li> <a class="dropdown-item" id="submenureportpengolahan" href="mainpage?p=reportpengolahan" hidden>Report Pengolahan</a></li>
                            <li> <a class="dropdown-item" id="submenureportpengemasan" href="mainpage?p=reportpengemasan" hidden>Report Pengemasan</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown" id="myDropdown">
                        <a class="nav-link dropdown-toggle text-white" id="menusystems" href="#" data-bs-toggle="dropdown" hidden>System</a>
                        <ul class="dropdown-menu">
                            <li> <a class="dropdown-item" id="submenuprofile" href="mainpage?p=profile" hidden>Profile</a></li>
                            <li> <a class="dropdown-item" id="submenuchangepassword" href="mainpage?p=changepassword" hidden>Change Password</a></li>
                            <li> <a class="dropdown-item" id="submenusettings" href="#" hidden>Setting &raquo; </a>
                                <ul class="submenu dropdown-menu">
                                    <li><a class="dropdown-item" id="subsubmenudaftarmenu" href="mainpage?p=daftarmenu" hidden>Daftar Menu</a></li>
                                    <li><a class="dropdown-item" id="subsubmenuroles" href="mainpage?p=roles" hidden>Roles</a></li>
                                    <li><a class="dropdown-item" id="subsubmenuassignrole" href="mainpage?p=assignrole" hidden>Roles Assigning</a></li>
                                    <li><a class="dropdown-item" id="subsubmenuobject" href="mainpage?p=object" hidden>Roles Object</a></li>
                                    <li><a class="dropdown-item" id="subsubmenugeneralsetting" href="mainpage?p=generalsetting" hidden>General Setting</a></li>
                                    <li><a class="dropdown-item" id="subsubmenuconfiguration" href="mainpage?p=configuration" hidden>Configuration</a></li>
                                    <li><a class="dropdown-item" id="subsubmenureviewercpb" href="mainpage?p=reviewercpb" hidden>Reviewer CPB</a></li>
                                    <li><a class="dropdown-item" id="subsubmenuuserlog" href="mainpage?p=userlog" hidden>User Log</a></li>
                                    <li><a class="dropdown-item" id="subsubmenusistemmanagemen" href="mainpage?p=sistemmanagemen" hidden>Sistem Managemen</a></li>
                                </ul>
                            </li>
                            <li> <a class="dropdown-item" id="submenulogout" href="#" onclick="logoutsystem()" hidden>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page">
        <?php
        include "../function/getdata.php";
        include "../function/getdata2.php"; ?>
    </div>
    <div id="footer">
        <h6 class="mb-0 p-2 fw-bold" style="font-size: 8pt !important">© 2022-<?= date('Y') ?> CPB Online</h6>
        <!-- <h6 class="m-2 text-start fw-bold opacity-50" style="font-size: 9pt !important;">Database: <?= $_SESSION['client']; ?></h6>
        <h6 class="m-2 text-end fw-bold opacity-50" style="font-size: 9pt !important;"><?= $_SESSION['personnelnumber'] . "/" . $_SESSION['employeename']; ?></h6> -->
    </div>
    <!-- <script src="../asset/js/dropdown.js"> </script> -->

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="../asset/js/bootstrap.bundle.min.js"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!-- My Javascript -->
    <script src="../asset/js/myjavascript.js"></script>
    <!-- Data Table -->
    <!-- <script src="../asset/datatable/jquery.dataTables.min.js"></script> -->
    <!-- <script src="../asset/datatable/dataTables.bootstrap5.min.js"></script> -->
    <script src="../asset/datatable/jquery-3.5.1.js"></script>
    <!-- End Data Table -->
    <!-- My Data Table -->
    <script src="../asset/js/mydatatable.js"></script>
    <script src="../asset/datatable/jquery.dataTables.min.js"></script>
    <script src="../asset/datatable/dataTables.bootstrap5.min.js"></script>
    <!-- End Data Table -->

    <!-- Sweet Alert -->
    <script src="../asset/sweet/sweet.all.min.js"></script>
    <!-- End Sweet Alert -->

    <!-- Multi Input -->
    <script src="../asset/js/script.js"></script>
    <script src="../asset/js/tagify.min.js"></script>
    <script src="../asset/js/tagify.polyfills.min.js"></script>

    <link href="../asset/css/select2.min.css" rel="stylesheet" />
    <script src="../asset/js/select2.min.js"></script>
</body>

</html>

<script>
    var intervaltime = setInterval(() => {
        $.ajax({
            url: "../function/getdata.php",
            type: "POST",
            cache: false,
            data: {
                prosesceksession: 1
            },
            success: function(data) {
                if (data == 1) {
                    clearInterval(intervaltime);
                    Swal.fire({
                        title: '😜',
                        text: "You got kicked from app by admin",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = '../index';
                        }
                    });
                } else {
                    return;
                }
            }
        });
    }, 3000)

    // var intervalman = setInterval(() => {
    //     $.ajax({
    //         url: "../function/getdata.php",
    //         dataType: "JSON",
    //         type: "POST",
    //         cache: false,
    //         data: {
    //             prosescekmessage: 1
    //         },
    //         success: function(data) {
    //             //alert(data.a)
    //             if (data.return === true) {
    //                 clearInterval(intervalman);
    //                 Swal.fire({
    //                     title: '⚠️Maintenance',
    //                     text: "Perkiraan waktu " + data.timeleft + " WIB",
    //                     footer: '<b>Note: ' + data.text + '</b>',
    //                     showConfirmButton: true,
    //                     allowOutsideClick: false,
    //                     allowEscapeKey: false,
    //                 })
    //             }
    //         }
    //     });
    // }, 3000)
</script>
<!-- Modal -->
<div class="modal fade" id="versionaplikasi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Version Aplikasi</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <div>
                    <p>Pembaharuan</p>
                    <ul>
                        <li><b>Beta Version</b>
                            <p>New Development</p>
                        </li>
                        <li><b>V1.00</b>
                            <p>
                                ~ Penambahan parameter range hasil uji suhu & RH pada Halaman Qc Result<br>
                                ~ Display output hasil uji suhu & RH pada proses prepare topack & hopper di perjelas<br>
                                ~ Penambahan feature print Work Order<br>
                                ~ Validasi Print/tidak setelah planning number terbentuk<br>
                                ~ Insert data log print work order (nama, tanggal, waktu, dll)<br>
                                ~ Penambahan feature maintenance User, Lock User.
                            </p>
                        </li>
                        <li><b>V1.01</b>
                            <p>
                                ~ Bug Fixing (Prepare Hoper, Prepare Topack)<br>
                            </p>
                        </li>
                        <li><b>V1.02</b>
                            <p>
                                ~ Bug Fixing (Report Prepare,Proses, Hoper & Topack, Pillow)<br>
                            </p>
                        </li>
                        <li><b>V1.03</b>
                            <p>
                                ~ Bug Fixing (Report Prepare,Proses, Hoper & Topack, Pillow)<br>
                                ~ Multi Client
                            </p>
                        </li>
                        <li><b>V1.04 <span style="font-size: 6pt;">04/10/2023</span></b>
                            <p>
                                ~ New Proses "Analisa Pengemasan Sekunder"<br>
                                ~ New Flow Sistem Approval<br>
                                ~ Fixing Review Quality
                            </p>
                        </li>
                        <li><b>V1.05 <span style="font-size: 6pt;">26/10/2023</span></b>
                            <p>
                                ~ New Reviewer "Analisa Pengemasan Sekunder"<br>
                                ~ New menu "Analisa Pengemasan Sekunder"<br>
                                ~ Add field & fixing transksi hopper<br>
                                ~ Fixing Planning<br>
                                ~ Fixing Transaksi Topack<br>
                                ~ Add field (horizontal - topack engine set)<br>
                                ~ Add Field UD "Analisa Pengemasan Sekunder"<br>
                                ~ Remove report rekon topack
                            </p>
                        </li>
                        <li><b>V1.06<span style="font-size: 6pt;">16/12/2023</span></b>
                            <p>
                                ~ Add field "Created For" Analisa RH & Suhu & Create Planning<br>
                                ~ Remove field persiapan hopper<br>
                                ~ Add field "Approval By" Approval planning<br>
                                ~ Add field "Plant, UnitCode, Years" All Menu<br>
                                ~ New feature "Downtime" Rekonsiliasi topack<br>
                                ~ New menu "Timbang Bahan" Connect Timbangan<br>
                                ~ New Feture "Captcha" Multiple login<br>
                            </p>
                        </li>
                        <li><b>V1.07<span style="font-size: 6pt;">13/02/2024</span></b>
                            <p>
                                ~ New menu Proses Pengolahan<br>
                                ~ New menu Master insp. Char<br>
                                ~ New menu Mapping Timbangan<br>
                                ~ New menu Reviewer<br>
                                ~ New menu Analisa Organoleptis<br>
                                ~ New menu History Timbang<br>
                                ~ New menu "Cek Status QC"<br>
                                ~ New menu "Print Label Ambil Sample Manual & Otomatis"<br>
                                ~ New GUI menu dashboard for approval planning<br>
                                ~ Fix Proses timbang<br>
                                ~ Fix Proses Hoper with Scanner<br>
                            </p>
                        </li>
                        <li><b>V1.08 <span style="font-size: 6pt;">21/06/2024</span></b>
                            <p>
                                ~ New Menu Change/Display data pengolahan & Pengemasan<br>
                                ~ New Menu Upload Nomor Lot<br>
                                ~ New Menu Karantina<br>
                                ~ New Feature Apporve All Proses<br>
                                ~ Add Feature MD Produk<br>
                            </p>
                        </li>
                        <li><b>V1.09 <img src="../asset/img/new.png"><span style="font-size: 6pt;">11/09/2024</span></b>
                            <p>
                                ~ New Menu Prepare Mixing (Mobile Apps)<br>
                                ~ New Menu Proses Mixing (Mobile Apps)<br>
                                ~ New Menu Tracking Batch<br>
                                ~ New Menu Print Label Bahan Manual<br>
                                ~ New Feature Analisis RH & Suhu Mixing<br>
                                ~ New Feature Reject Planning Pengolahan<br>
                                ~ New Feature Manajemen Stok<br>
                                ~ New Feature Configuration Stok<br>
                                ~ New GUI Analisa Pengemasan Primer & Sekunder<br>
                                ~ Fix Report CPB<br>
                                ~ New Feature Print Label Palet<br>
                                ~ New Feature kirim Bahan (Pallet)<br>
                                ~ New Feature Terima Bahan (Pallet)<br>
                                ~ New Feature Master data Supplier<br>
                                ~ New Feature Lacak Batch Planning<br>
                                ~ New Feature Checklist Mesin<br>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>