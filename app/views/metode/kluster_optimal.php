<div class="alert alert-info" role="alert">
    <h4 class="alert-heading">Hasil SSE Setiap Kluster</h4>
</div>
<div class="row">
    <div class="col-lg-6">
        <?php Flasher::flash(); ?>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <table class="table table-striped" id="table_nilai_sse">
                <thead>
                    <tr>
                        <th scope="col">Jumlah K</th>
                        <th scope="col">Nilai SSE</th>
                        <th scope="col">Selisih SSE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sse_elbow = array();
                    $selisih_sse = array();
                    ?>
                    <?php foreach ($data['sse_elbow'] as $kluster => $sse) : ?>
                        <tr>
                            <td><?= $kluster; ?></td>
                            <?php foreach ($sse as $index => $value) : ?>
                                <?php array_push($sse_elbow, $value); ?>
                                <td><?= $value; ?></td>
                            <?php endforeach; ?>
                            <?php array_push($selisih_sse, $data['selisih_sse'][$kluster][0]); ?>
                            <td><?= $data['selisih_sse'][$kluster][0]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-10">
            <div>
                <canvas id="grafikElbow"></canvas>
            </div>
        </div>
    </div>
</div>

<?php
$array_k = json_encode($data['array_k']);
$sse_elbow = json_encode($sse_elbow);
$selisih_sse = json_encode($selisih_sse);
?>
<script>
    const ctx = document.getElementById("grafikElbow").getContext('2d');
    const grafikElbow = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo $array_k; ?>,
            datasets: [{
                    label: 'SSE',
                    backgroundColor: 'rgb(255, 0, 0)',
                    borderColor: 'rgb(255, 0, 0)',
                    fill: false,
                    data: <?php echo $sse_elbow; ?>
                },
                {
                    label: 'Selisih SSE',
                    backgroundColor: 'rgb(0, 0, 255)',
                    borderColor: 'rgb(0, 0, 255)',
                    fill: false,
                    data: <?php echo $selisih_sse; ?>
                }
            ]
        },
        options: {
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Jumlah K'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'SSE'
                    }
                }]
            },
        }
    });
</script>