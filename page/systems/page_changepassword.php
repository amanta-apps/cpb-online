<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/password.png"> Change Password</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <label for="useridchangepassword" class="col-sm-2 col-form-label">User ID</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm" id="useridchangepassword" value="<?= $_SESSION['userid'] ?>" readonly>
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="currentpasswordchangepassword" class="col-sm-2 col-form-label">Current Password</label>
        <div class="col-sm-2">
            <input type="password" class="form-control form-control-sm" id="currentpasswordchangepassword" placeholder="********">
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="newpasswordchangepassword" class="col-sm-2 col-form-label">New Password</label>
        <div class="col-sm-2">
            <input type="password" class="form-control form-control-sm" id="newpasswordchangepassword" placeholder="********">
        </div>
    </div>
    <div class="form-group row mb-0">
        <label for="renewpasswordchangepassword" class="col-sm-2 col-form-label">Re-entry Password</label>
        <div class="col-sm-2">
            <input type="password" class="form-control form-control-sm" id="renewpasswordchangepassword" placeholder="********">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-2 offset-2">
            <button type="button" class="btn btn-outline-success btn-sm" onclick="savechangepassword()"><img src="../asset/icon/save.png">Save</button>
        </div>
    </div>
</div>