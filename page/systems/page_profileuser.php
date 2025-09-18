<?php
$client = '300';
if ($_SESSION['client'] == 'db_sisp_100') {
    $client = '100';
}
?>
<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/profile.png"> Profile</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <label for="setplanningnumberproseshoper" class="col-sm-2 col-form-label">Client</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm" id="setplanningnumberproseshoper" value="<?= $client  ?>" readonly>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="setplanningnumberproseshoper" class="col-sm-2 col-form-label">Company Code</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm" id="setplanningnumberproseshoper" value="<?= $_SESSION['plant'] . ' - ' . $_SESSION['unitcode'] ?>" readonly>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="setplanningnumberproseshoper" class="col-sm-2 col-form-label">User ID</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm" id="setplanningnumberproseshoper" value="<?= $_SESSION['userid'] ?>" readonly>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="setplanningnumberproseshoper" class="col-sm-2 col-form-label">Pernr</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm" id="setplanningnumberproseshoper" value="<?= $_SESSION['personnelnumber'] ?>" readonly>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="setplanningnumberproseshoper" class="col-sm-2 col-form-label">Username</label>
        <div class="col-sm-4">
            <input type="text" class="form-control form-control-sm" id="setplanningnumberproseshoper" value="<?= $_SESSION['employeename'] ?>" readonly>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="setplanningnumberproseshoper" class="col-sm-2 col-form-label">Position</label>
        <div class="col-sm-1">
            <input type="text" class="form-control form-control-sm" id="setplanningnumberproseshoper" value="<?= $_SESSION['positionid'] ?>" readonly>
        </div>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm" id="setplanningnumberproseshoper" value="<?= $_SESSION['jabatan'] ?>" readonly>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="setplanningnumberproseshoper" class="col-sm-2 col-form-label">Last Login</label>
        <div class="col-sm-4">
            <input type="text" class="form-control form-control-sm" id="setplanningnumberproseshoper" value="<?= $_SESSION['logintime'] ?>" readonly>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="setplanningnumberproseshoper" class="col-sm-2 col-form-label">DB</label>
        <div class="col-sm-4">
            <input type="text" class="form-control form-control-sm" id="setplanningnumberproseshoper" value="<?= md5($_SESSION['client']) ?>" readonly>
        </div>
    </div>
</div>