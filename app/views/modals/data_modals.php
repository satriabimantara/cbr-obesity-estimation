<!-- Modals for splitting basis kasus dan kasus uji -->
<form action="<?= BASEURL; ?>data/splitting_data" method="post">
    <div class="modal fade" id="modalSplittingData" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalSplittingDataLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSplittingDataLabel">Pembagian Data Set</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-6">
                            <label for="inputJumlahDataLatih">Persentase Basis Kasus</label>
                            <input type="number" class="form-control" id="inputJumlahDataLatih" name="inputJumlahDataLatih" aria-describedby="dataLatihHelp" min="70" max="100" value="" required="true">
                            <small id="dataLatihHelp" class="form-text text-muted">Persentase data latih minimum 70%</small>
                        </div>
                        <div class="col-6">
                            <label for="inputJumlahDataUji">Persentase Kasus Uji</label>
                            <input type="number" class="form-control" id="inputJumlahDataUji" name="inputJumlahDataUji" aria-describedby="dataUjiHelp" max="30" min="10" id="inputJumlahDataUji" value="" readonly="true">
                            <small id="dataUjiHelp" class="form-text text-muted">Persentase data uji maksimum 30%</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-success" value="" name="btnSplittingDataSet" id="btnSplittingDataSet">Bagi</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modals for Revise Kasus Baru -->
<form action="<?= BASEURL; ?>data/revise" method="post">
    <div class="modal fade" id="modalReviseKasusBaru" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalReviseKasusBaruLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalReviseKasusBaruLabel">Revise Kasus Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="" name="id_kasusbaru_original" id="id_kasusbaru_original">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender" required="true" disabled>
                            <option value="">- Answer -</option>
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" class="form-control" id="age" name="age" id="age" required="true" min="14" max="61" value="" aria-describedby="ageHelp" readonly="true">
                        <small id="ageHelp" class="form-text text-muted">Interval age 14 - 61</small>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col">
                            <label for="height">Height</label>
                            <input type="number" class="form-control" id="height" name="height" id="height" required="true" min="145" max="198" value="" aria-describedby="heightHelp" step="0.1" readonly="true">
                            <small id="heightHelp" class="form-text text-muted">Interval height 145 - 198</small>
                        </div>
                        <div class="col">
                            <label for="weight">Weight</label>
                            <input type="number" class="form-control" id="weight" name="weight" id="weight" required="true" min="39" max="173" value="" step="0.1" aria-describedby="weightHelp" readonly="true">
                            <small id="weightHelp" class="form-text text-muted">Interval weight 39 - 173</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="FHO">Family History With Overweight</label>
                        <select class="form-control" id="FHO" name="FHO" required="true" disabled>
                            <option value="">- Answer -</option>
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="FAVC">Frequent consumption of high caloric food</label>
                        <select class="form-control" id="FAVC" name="FAVC" required="true" disabled>
                            <option value="">- Answer -</option>
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="FCVC">Frequency of consumption of vegetables</label>
                        <select class="form-control" id="FCVC" name="FCVC" required="true" disabled>
                            <option value="">- Answer -</option>
                            <option value="Never">Never</option>
                            <option value="Sometimes">Sometimes</option>
                            <option value="Always">Always</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="NCP">Number of main meals</label>
                        <select class="form-control" id="NCP" name="NCP" required="true" disabled>
                            <option value="">- Answer -</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="More than 3">More than 3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="CAEC">Consumption of food between meals</label>
                        <select class="form-control" id="CAEC" name="CAEC" required="true" disabled>
                            <option value="">- Answer -</option>
                            <option value="No">No</option>
                            <option value="Sometimes">Sometimes</option>
                            <option value="Frequently">Frequently</option>
                            <option value="Always">Always</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="SMOKE">Smoking</label>
                        <select class="form-control" id="SMOKE" name="SMOKE" required="true" disabled>
                            <option value="">- Answer -</option>
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="CH2O">Consumption of water daily</label>
                        <select class="form-control" id="CH2O" name="CH2O" required="true" disabled>
                            <option value="">- Answer -</option>
                            <option value="Less than a liter">Less than a liter</option>
                            <option value="Between 1 and 2 Liter">Between 1 and 2 Liter</option>
                            <option value="More than 2 Liter">More than 2 Liter</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="SCC">Calories consumption monitoring</label>
                        <select class="form-control" id="SCC" name="SCC" required="true" disabled>
                            <option value="">- Answer -</option>
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="FAF">Physical activity frequency</label>
                        <select class="form-control" id="FAF" name="FAF" required="true" disabled>
                            <option value="">- Answer -</option>
                            <option value="I do not have">I do not have</option>
                            <option value="1 or 2 days">1 or 2 days</option>
                            <option value="2 or 4 days">2 or 4 days</option>
                            <option value="4 or 5 days">4 or 5 days</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="TUE">Time using technology</label>
                        <select class="form-control" id="TUE" name="TUE" required="true" disabled>
                            <option value="">- Answer -</option>
                            <option value="0–2 hours">0–2 hours</option>
                            <option value="3–5 hours">3–5 hours</option>
                            <option value="More than 5 hours">More than 5 hours</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="CALC">Consumption of alcohol</label>
                        <select class="form-control" id="CALC" name="CALC" required="true" disabled>
                            <option value="">- Answer -</option>
                            <option value="No">No</option>
                            <option value="Sometimes">Sometimes</option>
                            <option value="Frequently">Frequently</option>
                            <option value="Always">Always</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="MTRANS">Transportation used</label>
                        <select class="form-control" id="MTRANS" name="MTRANS" required="true" disabled>
                            <option value="">- Answer -</option>
                            <option value="Automobile">Automobile</option>
                            <option value="Motorbike">Motorbike</option>
                            <option value="Bike">Bike</option>
                            <option value="Public Transportation">Public Transportation</option>
                            <option value="Walking">Walking</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Obesity">Obesity Level</label>
                        <select class="form-control" id="Obesity" name="Obesity" required="true">
                            <option value="">- Answer -</option>
                            <option value="Insufficient Weight ">Insufficient Weight </option>
                            <option value="Normal Weight">Normal Weight</option>
                            <option value="Overweight Level I">Overweight Level I</option>
                            <option value="Overweight Level II">Overweight Level II</option>
                            <option value="Obesity Type I">Obesity Type I</option>
                            <option value="Obesity Type II">Obesity Type II</option>
                            <option value="Obesity Type III">Obesity Type III</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-success" value="" name="btnReviseKasusBaru" id="btnReviseKasusBaru">Revise</button>
                </div>
            </div>
        </div>
    </div>
</form>