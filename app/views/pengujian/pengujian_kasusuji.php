<div class="row">
    <div class="col-lg-6">
        <?php Flasher::flash(); ?>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <h5 class="card-header">Hasil Pengujian Kasus Uji</h5>
                <div class="card-body">
                    <h5 class="card-title">CBR-KMeans </h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Waktu Komputasi = <?= $data['waktu_cbrkmeans']; ?></li>
                        <li class="list-group-item">Akurasi = <span class="font-weight-bolder"><?= $data['akurasi_cbrkmeans']; ?>%</span></li>
                    </ul>
                    <h5 class="card-title">CBR</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Waktu Komputasi = <?= $data['waktu_cbr']; ?></li>
                        <li class="list-group-item">Akurasi = <span class="font-weight-bolder"><?= $data['akurasi_cbr']; ?>%</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <table class="table table-striped" id="table_pengujian_kasusuji">
                <thead>
                    <tr>
                        <th scope="col">ID Kasus</th>
                        <th scope="col">Label Obesitas</th>
                        <th scope="col">Solusi CBR</th>
                        <th scope="col">Similarity CBR</th>
                        <th scope="col">Solusi CBR-KMeans</th>
                        <th scope="col">Similarity CBR-KMeans</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['kasus_uji'] as $kasus) : ?>
                        <tr>
                            <th scope="row"><?= $kasus['id_obesitas']; ?></th>
                            <td><?= $kasus['Obesity']; ?></td>
                            <td><?= $kasus['solusi_cbr']; ?></td>
                            <td><?= $kasus['similarity_cbr']; ?></td>
                            <td><?= $kasus['solusi_cbrkmeans']; ?></td>
                            <td><?= $kasus['similarity_cbrkmeans']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>