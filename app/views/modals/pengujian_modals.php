<!-- Modal kasus baru -->
<form action="<?= BASEURL; ?>pengujian/kasus_baru" method="post">
    <div class="modal fade" id="modalPengujianKasusBaru" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalPengujianKasusBaruLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPengujianKasusBaruLabel">Pengujian Kasus Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender" required="true">
                            <option value="">- Answer -</option>
                            <option value="0*Female">Female</option>
                            <option value="1*Male">Male</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" class="form-control" id="age" name="age" id="age" required="true" min="14" max="61" value="" aria-describedby="ageHelp">
                        <small id="ageHelp" class="form-text text-muted">Interval age 14 - 61</small>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col">
                            <label for="height">Height</label>
                            <input type="number" class="form-control" id="height" name="height" id="height" required="true" min="145" max="198" value="" aria-describedby="heightHelp" step="0.1">
                            <small id="heightHelp" class="form-text text-muted">Interval height 145 - 198</small>
                        </div>
                        <div class="col">
                            <label for="weight">Weight</label>
                            <input type="number" class="form-control" id="weight" name="weight" id="weight" required="true" min="39" max="173" value="" step="0.1" aria-describedby="weightHelp">
                            <small id="weightHelp" class="form-text text-muted">Interval weight 39 - 173</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="FHO">Family History With Overweight</label>
                        <select class="form-control" id="FHO" name="FHO" required="true">
                            <option value="">- Answer -</option>
                            <option value="0*No">No</option>
                            <option value="1*Yes">Yes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="FAVC">Frequent consumption of high caloric food</label>
                        <select class="form-control" id="FAVC" name="FAVC" required="true">
                            <option value="">- Answer -</option>
                            <option value="0*No">No</option>
                            <option value="1*Yes">Yes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="FCVC">Frequency of consumption of vegetables</label>
                        <select class="form-control" id="FCVC" name="FCVC" required="true">
                            <option value="">- Answer -</option>
                            <option value="1*Never">Never</option>
                            <option value="2*Sometimes">Sometimes</option>
                            <option value="3*Always">Always</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="NCP">Number of main meals</label>
                        <select class="form-control" id="NCP" name="NCP" required="true">
                            <option value="">- Answer -</option>
                            <option value="1*1">1</option>
                            <option value="2*2">2</option>
                            <option value="3*3">3</option>
                            <option value="4*More than 3">More than 3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="CAEC">Consumption of food between meals</label>
                        <select class="form-control" id="CAEC" name="CAEC" required="true">
                            <option value="">- Answer -</option>
                            <option value="1*No">No</option>
                            <option value="2*Sometimes">Sometimes</option>
                            <option value="3*Frequently">Frequently</option>
                            <option value="4*Always">Always</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="SMOKE">Smoking</label>
                        <select class="form-control" id="SMOKE" name="SMOKE" required="true">
                            <option value="">- Answer -</option>
                            <option value="0*No">No</option>
                            <option value="1*Yes">Yes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="CH2O">Consumption of water daily</label>
                        <select class="form-control" id="CH2O" name="CH2O" required="true">
                            <option value="">- Answer -</option>
                            <option value="1*Less than a liter">Less than a liter</option>
                            <option value="2*Between 1 and 2 Liter">Between 1 and 2 Liter</option>
                            <option value="3*More than 2 Liter">More than 2 Liter</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="SCC">Calories consumption monitoring</label>
                        <select class="form-control" id="SCC" name="SCC" required="true">
                            <option value="">- Answer -</option>
                            <option value="0*No">No</option>
                            <option value="1*Yes">Yes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="FAF">Physical activity frequency</label>
                        <select class="form-control" id="FAF" name="FAF" required="true">
                            <option value="">- Answer -</option>
                            <option value="1*I do not have">I do not have</option>
                            <option value="2*1 or 2 days">1 or 2 days</option>
                            <option value="3*2 or 4 days">2 or 4 days</option>
                            <option value="4*4 or 5 days">4 or 5 days</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="TUE">Time using technology</label>
                        <select class="form-control" id="TUE" name="TUE" required="true">
                            <option value="">- Answer -</option>
                            <option value="1*0–2 hours">0–2 hours</option>
                            <option value="2*3–5 hours">3–5 hours</option>
                            <option value="3*More than 5 hours">More than 5 hours</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="CALC">Consumption of alcohol</label>
                        <select class="form-control" id="CALC" name="CALC" required="true">
                            <option value="">- Answer -</option>
                            <option value="1*No">No</option>
                            <option value="2*Sometimes">Sometimes</option>
                            <option value="3*Frequently">Frequently</option>
                            <option value="4*Always">Always</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="MTRANS">Transportation used</label>
                        <select class="form-control" id="MTRANS" name="MTRANS" required="true">
                            <option value="">- Answer -</option>
                            <option value="1*Automobile">Automobile</option>
                            <option value="2*Motorbike">Motorbike</option>
                            <option value="3*Bike">Bike</option>
                            <option value="4*Public Transportation">Public Transportation</option>
                            <option value="5*Walking">Walking</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="methodType" id="CBRKMeans" value="CBR-KMeans" checked>
                            <label class="form-check-label" for="CBRKMeans">CBR-KMeans Clustering</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="methodType" id="CBR" value="CBR">
                            <label class="form-check-label" for="CBR">CBR</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-success" value="" name="btnCariSolusiKasusBaru" id="btnCariSolusiKasusBaru">Solusi</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal kasus uji -->
<form action="<?= BASEURL; ?>pengujian/kasus_uji" method="post">
    <div class="modal fade" id="modalPengujianKasusUji" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalPengujianKasusUjiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPengujianKasusUjiLabel">Pengujian Kasus Uji</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="">
                        Proses pengujian akan menggunakan <span class="font-weight-bold"><?= $data['amount_data_uji']; ?></span> kasus uji. Metode <span class="font-weight-bold">CBR-KMeans</span> dan <span class="font-weight-bold">CBR</span> akan dibandingkan keduanya. Proses perhitungan mungkin membutuhkan waktu beberapa menit.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-success" value="" name="btnCariSolusiKasusUji" id="btnCariSolusiKasusUji">Uji</button>
                </div>
            </div>
        </div>
    </div>
</form>