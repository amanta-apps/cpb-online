<div class="container">
    <h6 class="fw-bold mt-3 text-start">Sistem Managemen</h6>
    <hr class="w-50 mb-3">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark active" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1" aria-selected="true">Message Maintenance</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-2" type="button" role="tab" aria-controls="pills-2" aria-selected="false">Unlock User</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
            <div class="form-group row mb-0">
                <label for="unitsistemmanagemen" class="col-sm-2 col-form-label">Unit</label>
                <div class="col-sm-2">
                    <select class="form-select form-select-sm" id="unitsistemmanagemen">
                        <option></option>
                        <?php
                        $sql = mysqli_query($conn, "SELECT * FROM t001w");
                        while ($r = mysqli_fetch_array($sql)) { ?>
                            <option value="<?= $r['Unit'] ?>"><?= $r['Unit'] . ' - ' . $r['Descriptions'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-0">
                <label for="setplanningnumberproseshoper" class="col-sm-2 col-form-label">Time</label>
                <div class="col-sm-2">
                    <input type="time" class="form-control form-control-sm" id="timefromsistemmanagemen" value="<?= date('H:i:s') ?>">
                </div>
                <label for="setplanningnumberproseshoper" class="col-sm-2 col-form-label">Estimasi Time</label>
                <div class="col-sm-2">
                    <input type="time" class="form-control form-control-sm" id="timetosistemmanagemen" value="<?= date('H:i:s') ?>">
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="form-floating col-sm-6 offset-2">
                    <textarea class="form-control" placeholder="Leave a comment here" id="keterangansistemmanagemen" style="height: 100px"></textarea>
                    <label for="floatingTextarea2" class="p-3">Keterangan</label>
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-sm-10 offset-2">
                    <p class="text-danger">*User akan di keluarkan paksa & di kunci dari sistem selama proses maintenance</p>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3 offset-2">
                    <button type="button" class="btn btn-outline-success btn-sm" onclick="simpanmessagemaintenance()"><img src="../asset/icon/save.png"> Submit</button>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
            <div class="container">
                <div class="form-group row mt-5">
                    <label for="unitsistemmanagemen2" class="col-sm-2 col-form-label">Unit</label>
                    <div class="col-sm-2">
                        <select class="form-select form-select-sm" id="unitsistemmanagemen2">
                            <option></option>
                            <?php
                            $sql = mysqli_query($conn, "SELECT * FROM t001w");
                            while ($r = mysqli_fetch_array($sql)) { ?>
                                <option value="<?= $r['Unit'] ?>"><?= $r['Unit'] . ' - ' . $r['Descriptions'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="offset-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="locksistemmanagemen" checked>
                        <label class="form-check-label" for="inlineRadio1">Lock User</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="unlocksistemmanagemen">
                        <label class="form-check-label" for="inlineRadio2">Unlock User</label>
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <div class="col-sm-3 offset-2">
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="simpanusermanagemen()"><img src="../asset/icon/save.png"> Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>