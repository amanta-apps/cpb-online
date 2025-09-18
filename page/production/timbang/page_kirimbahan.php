<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/express.png"> Kirim bahan (Palet)</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <div class="col-sm-12 offset-2">
            <input type="text" class="form-control form-control-sm border-0 bg-transparent text-danger fw-bold" id="infobarcodekirimbahan" readonly hidden>
            <button class="btn btn-sm btn-success zoom" id="tombolkirimbahan" hidden onclick="simpankirimbahan()"><img src="../asset/icon/sent.png" title="kirim"> Kirim Bahan</button> <span><label id="infokirimbahan" class="text-success fw-bold"></label></span>
        </div>
    </div>

    <div class="form-group row mb-0 mt-5" id="cardcolor">
        <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link btn-sm text-dark fw-bold active" id="pills-basicdata-tab" data-bs-toggle="pill" data-bs-target="#pills-basicdata" type="button" role="tab" aria-controls="pills-basicdata" aria-selected="true">Basic Data</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link btn-sm text-dark fw-bold" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Informasi Pallet</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link btn-sm text-dark fw-bold" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Informasi Quality</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link btn-sm text-dark fw-bold" id="pills-label-tab" data-bs-toggle="pill" data-bs-target="#pills-label" type="button" role="tab" aria-controls="pills-label" aria-selected="false">Informasi Label</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-basicdata" role="tabpanel" aria-labelledby="pills-basicdata-tab">
                <div class="form-group row mb-0">
                    <label for="productidkirimbahan" class="col-sm-2 col-form-label">ProductID</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="productidkirimbahan" readonly>
                    </div>
                    <label for="plantkirimbahan" class="col-sm-2 offset-4 col-form-label">Plant</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="plantkirimbahan" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="scanbarcodekirimbahan" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="proddesckirimbahan" readonly>
                    </div>
                    <label for="unitcodekirimbahan" class="col-sm-2 offset-1 col-form-label">Unit Code</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="unitcodekirimbahan" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="batchkirimbahan" class="col-sm-2 col-form-label">Batch/ED</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="batchkirimbahan" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="expdatekirimbahan" class="col-sm-2 col-form-label">Exp Date</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="expdatekirimbahan" readonly>
                    </div>
                </div>
                <hr class="w-50">
                <div class="form-group row mb-0">
                    <label for="planningnumberkirimbahan" class="col-sm-2 col-form-label">Planning Number</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="planningnumberkirimbahan" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="planningyearskirimbahan" class="col-sm-2 col-form-label">Planning Years</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="planningyearskirimbahan" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="noproseskirimbahan" class="col-sm-2 col-form-label">Proses</label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control form-control-sm" id="noproseskirimbahan" readonly>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="form-group row mb-0">
                    <label for="nopalletkirimbahan" class="col-sm-2 col-form-label">No Pallet</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="nopalletkirimbahan" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="totalberatkirimbahan" class="col-sm-2 col-form-label">Total Berat</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="totalberatkirimbahan" readonly>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="satuankirimbahan" readonly>
                    </div>
                </div>

                <div class="form-group row mb-0 mt-3">
                    <h6 class="fw-bold text-start"><u>INFORMASI BERAT</u> </h6>
                    <div id="informasiberat1kirimbahan" class="col-sm-6"></div>
                    <div id="informasiberat2kirimbahan" class="col-sm-6"></div>
                </div>
            </div>
            <div class="tab-pane fade show" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="form-group row mb-0">
                    <label for="inspetionlotkirimbahan" class="col-sm-2 col-form-label">Inspection Lot</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="inspetionlotkirimbahan" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="inspyearskirimbahan" class="col-sm-2 col-form-label">Insp. Years</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="inspyearskirimbahan" readonly>
                    </div>
                </div>
                <!-- <div class="form-group row mb-0">
                    <div class="col-sm-6 fw-bold">No Proses #1</div>
                    <div class="col-sm-6 fw-bold">No Proses #2</div>
                </div> -->
                <div class="form-group row mb-0 mt-3">
                    <div class="col-sm-8">
                        <table class="table table-sm table-bordered">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>No Proses</th>
                                    <th>UD Code</th>
                                    <th>Descriptions</th>
                                    <th>UD Date</th>
                                    <th>UD By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent" id="noproses1kirimbahan" readonly></td>
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent" id="udcode1kirimbahan" readonly></td>
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold fs-6" id="uddesc1kirimbahan" readonly></td>
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent" id="uddate1kirimbahan" readonly></td>
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent" id="udbykirimbahan" readonly></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- <div class="form-group row mb-0 mt-1">
                    <div class="col-sm-8">
                        <table class="table table-sm table-bordered">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>No Proses</th>
                                    <th>UD Code</th>
                                    <th>Descriptions</th>
                                    <th>UD Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent" id="noproses2kirimbahan" readonly></td>
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent" id="udcode2kirimbahan" readonly></td>
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold fs-6" id="uddesc2kirimbahan" readonly></td>
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent" id="uddate2kirimbahan" readonly></td>
                                </tr>
                            </tbody>
                        </table>
                    </div> -->
                <!-- <div class="col-sm-12">
                        <label for="udcode1kirimbahan" class="col-sm-2 col-form-label">UD Code</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="udcode1kirimbahan" readonly>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="uddesc2kirimbahan" readonly>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label for="udcode2kirimbahan" class="col-sm-2 col-form-label">UD Code</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="udcode2kirimbahan" readonly>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="uddesc2kirimbahan" readonly>
                        </div>
                    </div> -->
            </div>
            <div class="tab-pane fade show" id="pills-label" role="tabpanel" aria-labelledby="pills-label-tab">
                <div class="form-group row mb-0">
                    <label for="printlabelkirimbahan" class="col-sm-2 col-form-label">Print Label</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="printlabelkirimbahan" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="diprintolehkirimbahan" class="col-sm-2 col-form-label">Di Print Oleh</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="diprintolehkirimbahan" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


</div>