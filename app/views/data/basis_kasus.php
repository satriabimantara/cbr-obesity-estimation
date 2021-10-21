<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">Basis Kasus</h4>
</div>
<div class="container">
    <div class="row mt-3">
        <div class="col">
            <table class="table table-striped" id="table_basis_kasus">
                <thead>
                    <tr>
                        <th scope="col">Nomor</th>
                        <?php foreach ($data['daftar_kolom'] as $kolom) : ?>
                            <th scope="col"><?= $kolom; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['daftar_data'] as $index => $obesity) : ?>
                        <tr>
                            <th scope="row"><?= $index + 1; ?></th>
                            <?php foreach ($data['daftar_kolom'] as $kolom) : ?>
                                <td><?= $obesity[$kolom]; ?></td>
                            <?php endforeach; ?>
                            <!-- <td>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-warning btn-sm btn-ubahDataOriginal" title="Edit Data" data-toggle="modal" data-target="#modalDataOriginal" data-id="<?= $review['id_reviews'] ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a class="btn btn-danger btn-sm" href="<?= BASEURL; ?>data/hapus_data_original/<?= $review['id_reviews'] ?>" onclick="return confirm('Hapus data ini?');" title="Hapus Data">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td> -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>