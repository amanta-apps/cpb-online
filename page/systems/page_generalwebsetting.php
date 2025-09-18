<div class="container">
    <h6 class="fw-bold mt-3 text-start">GENERAL WEB SETTING</h6>
    <hr class="w-50 mb-3">
    <!-- <div class="form-group row mb-0">
        <label for="personalnumberemployee" class="col-sm-2 col-form-label">Unit Code</label>
        <div class="col-sm-2">
            <div class="input-group mb-4">
                <input type="text" class="form-control" placeholder="Planning Number" aria-label="Recipient's username" aria-describedby="button-addon2" id="unitgeneralsetting">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#searchunitgeneralsetting"><span><img src="../asset/icon/cari.png"></span></button>
            </div>
        </div>
    </div> -->
    <div class="accordion" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                    Basic Data
                </button>
            </h2>
            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                <div class="accordion-body">
                    <h6 class="fw-bold badge bg-dark col-12 mt-2 text-start">Dasboard</h6>
                    <div class="form-group row mb-1">
                        <label for="titledashboarddatasetting" class="col-sm-2 col-form-label">Title</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" id="titledashboarddatasetting" value="<?= Getdata('DashboardTitle', 'general_setting_web', 'UnitCode', 'S001') ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="contentdashboarddatasetting" class="col-sm-2 col-form-label">Content</label>
                        <div class="col-sm-10 mb-1">
                            <textarea class="form-control form-control-sm" id="contentdashboarddatasetting" cols="90" rows="3"><?= Getdata('DashboardContent', 'general_setting_web', 'UnitCode', 'S001') ?></textarea>
                        </div>
                        <br>
                        <!-- <label for="contentdashboarddatasetting" class="col-sm-2 col-form-label fw-bold">Note</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-sm bg-transparent border-0" value="<br> : Untuk menentukan baris baru" readonly>
                        </div> -->
                    </div>
                    <!-- <div class="form-group row">
                        <label for="contentdashboarddatasetting" class="col-sm-2 col-form-label fw-bold"></label>
                        <div class="col-sm-10">
                            <input type=" text" class="form-control form-control-sm bg-transparent border-0" value="<hr> : Untuk memberikan garis dibawah kalimat" readonly>
                        </div>
                    </div> -->
                    <h6 class="fw-bold badge bg-dark col-4 mt-2 text-start">Create User</h6>
                    <h6 class="fw-bold badge bg-dark col-4 offset-3  mt-2 text-start">Master Data</h6>
                    <div class="form-group row mb-1">
                        <label for="useriddatasetting" class="col-sm-2 col-form-label">User ID Code</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="useriddatasetting" value="<?= Getdata('UserIDCode', 'general_setting_web', 'UnitCode', 'S001') ?>" maxlength="7">
                        </div>
                        <label for="shiftcodedatasetting" class="col-sm-2 offset-3 col-form-label">Shift Code</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="shiftcodedatasetting" value="<?= Getdata('ShiftCode', 'general_setting_web', 'UnitCode', 'S001') ?>" maxlength="2">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="rolecodedatasetting" class="col-sm-2 col-form-label">Role Code</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="rolecodedatasetting" value="<?= Getdata('RoleCode', 'general_setting_web', 'UnitCode', 'S001') ?>">
                        </div>
                        <label for="mainresourcedatasetting" class="col-sm-2 offset-3 col-form-label">Main Resource Code</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="mainresourcedatasetting" value="<?= Getdata('MainResourceCode', 'general_setting_web', 'UnitCode', 'S001') ?>" maxlength="4">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="passdatasetting" class="col-sm-2 col-form-label">Password Default Code</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="passdatasetting" value="<?= Getdata('PassCode', 'general_setting_web', 'UnitCode', 'S001') ?>" maxlength="8">
                        </div>
                        <label for="primaryresource" class="col-sm-2 offset-3 col-form-label">Primary Resource Code</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="primaryresourcedatasetting" value="<?= Getdata('PrimaryResourceCode', 'general_setting_web', 'UnitCode', 'S001') ?>" maxlength="3">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="secondaryresourcedatasetting" class="col-sm-2 offset-7 col-form-label">Secondary Resource Code</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="secondaryresourcedatasetting" value="<?= Getdata('SecondaryResourceCode', 'general_setting_web', 'UnitCode', 'S001') ?>" maxlength="2">
                        </div>
                    </div>
                    <!-- <div class="form-group row mb-1">

                    </div>
                    <div class="form-group row mb-1">

                    </div>
                    <div class="form-group row mb-1">

                    </div> -->
                    <div class="form-group row mb-1">
                        <label for="mixingresourcedatasetting" class="col-sm-2 offset-7 col-form-label">Mixing Resource Code</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="mixingresourcedatasetting" value="<?= Getdata('MixingResourceCode', 'general_setting_web', 'UnitCode', 'S001') ?>" maxlength="4">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="supplierdatasetting" class="col-sm-2 offset-7 col-form-label">Supplier</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="supplierdatasetting" value="<?= Getdata('KodeSupplier', 'general_setting_web', 'UnitCode', 'S001') ?>" maxlength="4">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-11 text-end">
                            <button type="button" class="btn btn-outline-success btn-sm" onclick="simpangeneralsettingweb()"><img src="../asset/icon/save.png"> Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>