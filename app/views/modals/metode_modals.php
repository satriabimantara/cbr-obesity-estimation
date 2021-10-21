<!-- Modal Cari kluster optimal -->
<form action="<?= BASEURL; ?>metode/elbow" method="post">
    <div class="modal fade" id="modalCariKlusterOptimal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalCariKlusterOptimalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCariKlusterOptimalLabel">Cari Jumlah Kluster Optimal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-6">
                            <label for="inputJumlahMinimumKluster">Minimum Kluster</label>
                            <input type="number" class="form-control" id="inputJumlahMinimumKluster" name="inputJumlahMinimumKluster" aria-describedby="minimumKHelp" min="1" max="1" value="" required="true">
                            <small id="minimumKHelp" class="form-text text-muted">Jumlah kluster minimum adalah 1</small>
                        </div>
                        <div class="col-6">
                            <label for="inputJumlahMaksimumKluster">Maksimum Kluster</label>
                            <input type="number" class="form-control" id="inputJumlahMaksimumKluster" name="inputJumlahMaksimumKluster" aria-describedby="maksimumKHelp" max="<?= $data['amount_data']; ?>" min="3" value="" required="true">
                            <small id="maksimumKHelp" class="form-text text-muted">Jumlah kluster maksimum sebesar <?= $data['amount_data']; ?></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-success" value="" name="btnCariJumlahKlusterOptimal" id="btnCariJumlahKlusterOptimal">Cari</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal K-Means -->
<form action="<?= BASEURL; ?>metode/kmeans" method="post">
    <div class="modal fade" id="modalKMeans" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalKMeansLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalKMeansLabel">Indexing K-Means</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="jumlahKOptimal">Jumlah Kluster</label>
                        <input type="number" class="form-control" id="jumlahKOptimal" name="jumlahKOptimal" required="true" min="1" max="<?= $data['amount_data']; ?>" value="" aria-describedby="jumlahKHelp">
                        <small id="jumlahKHelp" class="form-text text-muted">Jumlah kluster maksimum sebesar <?= $data['amount_data']; ?></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-info" value="" name="btnKMeans" id="btnKMeans">Indexing KMeans</button>
                </div>
            </div>
        </div>
    </div>
</form>