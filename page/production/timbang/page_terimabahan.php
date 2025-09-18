<div class="container">
    <h6 class="fw-bold mt-3 text-start"><img src="../asset/icon/express.png"> Terima bahan (Palet)</h6>
    <hr class="w-50 mb-3">
    <div class="form-group row mb-0">
        <label for="scanbarcodeterimabahan" class="col-sm-2 col-form-label">Scan Barcode</label>
        <div class="col-sm-4">
            <input type="text" class="form-control form-control-sm" id="scanbarcodeterimabahan" placeholder="Barcode Label pallet" autofocus onkeypress="submitterimabahan(event)">
        </div>
    </div>
    <div class="form-group row mb-0">
        <div class="col-sm-12 offset-2">
            <input type="text" class="form-control form-control-sm border-0 bg-transparent text-danger fw-bold" id="infobarcodeterimabahan" readonly hidden>
            <button class="btn btn-sm btn-primary zoom" id="tombolterimabahan" hidden onclick="simpanterimabahan()"><img src="../asset/icon/sent.png" title="terima"> Terima Bahan</button> <span><label id="infoterimabahan" class="text-primary fw-bold"></label></span>
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
                <button class="nav-link btn-sm text-dark fw-bold" id="pills-kirim-tab" data-bs-toggle="pill" data-bs-target="#pills-kirim" type="button" role="tab" aria-controls="pills-kirim" aria-selected="false">Informasi Pengiriman</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-basicdata" role="tabpanel" aria-labelledby="pills-basicdata-tab">
                <div class="form-group row mb-0">
                    <label for="productidterimabahan" class="col-sm-2 col-form-label">ProductID</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="productidterimabahan" readonly>
                    </div>
                    <label for="plantterimabahan" class="col-sm-2 offset-4 col-form-label">Plant</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="plantterimabahan" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="proddescterimabahan" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="proddescterimabahan" readonly>
                    </div>
                    <label for="unitcodeterimabahan" class="col-sm-2 offset-1 col-form-label">Unit Code</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="unitcodeterimabahan" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="batchterimabahan" class="col-sm-2 col-form-label">Batch/ED</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="batchterimabahan" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="expdateterimabahan" class="col-sm-2 col-form-label">Exp Date</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="expdateterimabahan" readonly>
                    </div>
                </div>
                <hr class="w-50">
                <div class="form-group row mb-0">
                    <label for="planningnumberterimabahan" class="col-sm-2 col-form-label">Planning Number</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="planningnumberterimabahan" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="planningyearsterimabahan" class="col-sm-2 col-form-label">Planning Years</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="planningyearsterimabahan" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="prosesterimabahan" class="col-sm-2 col-form-label">Proses</label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control form-control-sm" id="prosesterimabahan" readonly>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="form-group row mb-0">
                    <label for="nopalletterimabahan" class="col-sm-2 col-form-label">No Pallet</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="nopalletterimabahan" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="totalberatterimabahan" class="col-sm-2 col-form-label">Total Berat</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="totalberatterimabahan" readonly>
                    </div>
                    <div class="col-sm-1">
                        <input type="text" class="form-control form-control-sm" id="satuanterimabahan" readonly>
                    </div>
                </div>

                <div class="form-group row mb-0 mt-3">
                    <h6 class="fw-bold text-start"><u>INFORMASI BERAT</u> </h6>
                    <div id="informasiberat1terimabahan" class="col-sm-6"></div>
                    <div id="informasiberat2terimabahan" class="col-sm-6"></div>
                </div>
            </div>
            <div class="tab-pane fade show" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="form-group row mb-0">
                    <label for="inspetionlotterimabahan" class="col-sm-2 col-form-label">Inspection Lot</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="inspetionlotterimabahan" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="inspyearsterimabahan" class="col-sm-2 col-form-label">Insp. Years</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="inspyearsterimabahan" readonly>
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
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent" id="noproses1terimabahan" readonly></td>
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent" id="udcode1terimabahan" readonly></td>
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold fs-6" id="uddesc1terimabahan" readonly></td>
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent" id="uddate1terimabahan" readonly></td>
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent" id="udbyterimabahan" readonly></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group row mb-0 mt-1">
                    <!-- <div class="col-sm-8">
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
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent" id="noproses2terimabahan" readonly></td>
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent" id="udcode2terimabahan" readonly></td>
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold fs-6" id="uddesc2terimabahan" readonly></td>
                                    <td><input type="text" class="form-control form-control-sm border-0 bg-transparent" id="uddate2terimabahan" readonly></td>
                                </tr>
                            </tbody>
                        </table>
                    </div> -->
                    <!-- <div class="col-sm-12">
                        <label for="udcode1terimabahan" class="col-sm-2 col-form-label">UD Code</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="udcode1terimabahan" readonly>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="uddesc2terimabahan" readonly>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label for="udcode2terimabahan" class="col-sm-2 col-form-label">UD Code</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="udcode2terimabahan" readonly>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="uddesc2terimabahan" readonly>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="tab-pane fade show" id="pills-kirim" role="tabpanel" aria-labelledby="pills-kirim-tab">
                <div class="form-group row mb-0">
                    <label for="tglkirimterimabahan" class="col-sm-2 col-form-label">Tanggal Kirim</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="tglkirimterimabahan" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="jamkirimterimabahan" class="col-sm-2 col-form-label">Jam Kirim</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="jamkirimterimabahan" readonly>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="pengirimterimabahan" class="col-sm-2 col-form-label">Pengirim</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control form-control-sm" id="pengirimterimabahan" readonly>
                    </div>

                </div>
                <div class="form-group row mb-0">
                    <div class="col-sm-6 offset-2">
                        <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="namapengirimterimabahan" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>