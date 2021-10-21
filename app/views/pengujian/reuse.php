<div class="container-fluid mb-5">
    <div class="row">
        <div class="col-lg-6">
            <?php Flasher::flash(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="alert alert-secondary" role="alert">
                <h4 class="alert-heading">Similarity = <?= $data['kasusbaru_transform']['similarity']; ?></h4>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <div class="card border-light mb-3">
                <h5 class="card-header">Kasus Baru</h5>
                <div class="card-body">
                    <h5 class="card-title"><?= $data['kasusbaru_transform']['Obesity']; ?></h5>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($data['kolom_kasusbaru'] as $column) : ?>
                            <li class="list-group-item">
                                <strong><?= $column; ?></strong> = <?= $data['kasusbaru_original'][$column]; ?> = <?= $data['kasusbaru_transform'][$column]; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-light mb-3">
                <h5 class="card-header">Basis Kasus [<?= $data['basis_kasus']['id_obesitas']; ?>]</h5>
                <div class="card-body">
                    <h5 class="card-title"><?= $data['basis_kasus']['Obesity']; ?></h5>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($data['kolom_basiskasus'] as $column) : ?>
                            <li class="list-group-item">
                                <strong><?= $column; ?></strong> = <?= $data['basis_kasus'][$column]; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>