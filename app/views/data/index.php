<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <?php Flasher::flash(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="jumbotron">
                <h1 class="display-4">Data Penelitian</h1>
                <p class="lead">
                    Estimation of Obesity Levels Based On Eating Habits and Physical Condition Data Set (UCI Machine Learning Repository)
                </p>
                <hr class="my-4">
                <p>
                    Data set termasuk data estimasi level obesitas seseorang dari negara Meksiko, Peru dan Kolombia, berdasarkan kebiasaan makan dan kondisi fisik mereka. Data mengandung 17 atribut dan 2111 baris data. Kelas target diberi label <strong>"NObesity"</strong> dengan 7 label target, yaitu <strong>Insufficient Weight</strong>,<strong>Normal Weight</strong>,<strong>Overweight Level 1</strong>,<strong>Overweight Level 2</strong>,<strong>Obesity Type 1</strong>,<strong>Obesity Type 2</strong>,<strong>Obesity Type 3</strong>
                </p>
                <p>
                    Jumlah basis kasus <strong><?= $data['jumlah_basis_kasus']; ?></strong><br>
                    Jumlah kasus uji <strong><?= $data['jumlah_kasus_uji']; ?></strong>
                </p>
            </div>
        </div>
    </div>
</div>