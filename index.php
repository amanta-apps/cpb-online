<?php
// include "function/koneksi.php";
session_start();
error_reporting(0);
if (isset($_SESSION['userid'])) {
    header('Location: page/mainpage?p=dashboard');
}
if (empty($_SESSION['client'])) {
    $_SESSION['client'] = 'db_sisp';
}
// echo $_SESSION['client'];
include 'function/getvalue.php';
$captcha = GetdataII('Captcha', 'tb_configlogin', 'Plant', 'SM', 'UnitCode', 'S001');
$plant = GetdataII('Splant', 'tb_configlogin', 'Plant', 'SM', 'UnitCode', 'S001');
$unitcode = GetdataII('Sunitcode', 'tb_configlogin', 'Plant', 'SM', 'UnitCode', 'S001');
if ($captcha == null) {
    $captcha = 'hidden';
}
if ($plant == null) {
    $plant = 'hidden';
}
if ($unitcode == null) {
    $unitcode = 'hidden';
}
$random_code = rand(9999, 1000);
// $sql = mysqli_query($conn, "SELECT Unit,Descriptions FROM T001w ORDER Unit ASC");
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="asset/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="asset/css/mycss.css">
    <link rel="shortcut icon" href="asset/img/sm.png">
    <title>CPB Online</title>
</head>

<body>
    <div class="container">
        <div class="row align-items-center" style="margin: 50px auto;">
            <div class="col-sm-4 offset-2">
                <h3><img src="asset/img/s100.png" style="width: 100%;"></h3>
            </div>
            <div class="col-sm-4">
                <div class="card shadow-lg" id="cardcolor" style="border:none">
                    <div class="card-body">
                        <div class="form-inline mb-1">
                            <h6 class="font-weight-bold ml-2 text-dark text-center fw-bold"><img src="asset/img/cpbonline.png"></h6>
                        </div>
                        <div class="form-group row mb-1" <?= $plant ?>>
                            <div class="col-sm-12">
                                <select class="form-select form-select-sm" id="plantdatalogin">
                                    <option value="SM">Sido Muncul</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <div class="col-sm-6" <?= $unitcode ?>>
                                <select class="form-select form-select-sm" id="unitcodedatalogin">
                                    <option value="S001">Unit SISP</option>
                                    <!-- <option value="S002" disabled>Unit KBE</option> -->
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <select class="form-select form-select-sm" id="clientkoneksi" onchange="getkoneksi(this.value)">
                                    <?php
                                    if ($_SESSION['client'] == 'db_sisp_100') { ?>
                                        <option value="db_sisp_100" selected>Client 100</option>
                                        <option value="db_sisp">Client 300</option>
                                    <?php  } else { ?>
                                        <option value="db_sisp_100">Client 100</option>
                                        <option value="db_sisp" selected>Client 300</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-outline mb-1">
                            <input class="form-control form-control-sm" placeholder="Personal Number or User ID" type="text" id="personalnumberdatalogin">
                        </div>
                        <div class="form-outline mb-1">
                            <!-- <input type="password" id="passworddatalogin" placeholder="Password" class="form-control form-control-sm" onkeypress="validasiloginenter()"> -->
                            <div class="input-group mb-1">
                                <input type="password" id="passworddatalogin" placeholder="Password" class="form-control form-control-sm" onkeypress="validasiloginenter()">
                                <button class="btn btn-sm btn-dark" type="button" id="btnpasswordlogin" onclick="showpassword()" onmouseleave="hidepassword()"><img src="asset/icon/eyewhite.png"></button>
                            </div>
                        </div>
                        <div class="form-group row mb-1" <?= $captcha ?>>
                            <div class="col-sm-5">
                                <div class="form-outline mb-1">
                                    <input type="text" id="chaptchadatalogin" class="form-control form-control-sm" placeholder="Input captcha" onkeypress="validasiloginenter()">
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="form-outline mb-1">
                                    <input type="text" id="getrandomcodedatalogin" class="form-control form-control-sm bg-dark text-warning text-center" value="<?= $random_code ?>">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="form-outline mb-1 ml-4">
                            <label class="form-check-label" for="flexCheckDefault">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" onchange="showpassword(this.checked)">
                                Show Password
                            </label>
                        </div> -->
                        <div class="form-group row px-3">
                            <button type="submit" style="width: 100%;" class="btn btn-dark btn-sm text-left" id="btnlogindatalogin" onclick="validasilogin()"><img src="asset/icon/login2.png" alt=""> Login</button>
                        </div>
                        <div class="form-group row mt-3 text-center">
                            <a href="#" class="text-decoration-none"><img src="asset/icon/forgot.png"> Lupa Kata Sandi</a>
                        </div>
                        <div class="form-group row text-center">
                            <label class="bg-transparent">Since 2022</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="OKe">

    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="asset/js/bootstrap.bundle.min.js"></script>
    <script src="asset/js/jquery-3.2.1.min.js"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!-- My Javascript -->
    <script src="asset/js/myjavascript.js"></script>
    <script src="asset/sweet/sweet.all.min.js"></script>
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>