<div class="alert alert-secondary" role="alert">
    <h4 class="alert-heading">Kasus Baru</h4>
</div>
<div class="row">
    <div class="col-lg-6">
        <?php Flasher::flash(); ?>
    </div>
</div>
<div class="container">
    <div class="row mt-3">
        <div class="col">
            <table class="table table-striped" id="table_kasus_baru">
                <thead>
                    <tr>
                        <th scope="col">Nomor</th>
                        <?php foreach ($data['daftar_kolom'] as $kolom) : ?>
                            <th scope="col"><?= $kolom; ?></th>
                        <?php endforeach; ?>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['daftar_data'] as $index => $obesity) : ?>
                        <tr>
                            <th scope="row"><?= $index + 1; ?></th>
                            <?php foreach ($data['daftar_kolom'] as $kolom) : ?>
                                <td><?= $obesity[$kolom]; ?></td>
                            <?php endforeach; ?>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-warning btn-sm btn-reviseKasusBaru mr-3" title="Edit Kasus Baru" data-toggle="modal" data-target="#modalReviseKasusBaru" data-id="<?= $obesity['id_kasusbaru_original']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a class="btn btn-danger btn-sm" href="<?= BASEURL; ?>data/hapus_kasusbaru/<?= $obesity['id_kasusbaru_original']; ?>" onclick="return confirm('Hapus Kasus ini?');" title="Hapus Kasus Baru">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>