<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= BASEURL; ?>css/bootstrap.css">
    <!-- Custom scrollbar -->
    <link rel="stylesheet" href="<?= BASEURL; ?>css/jquery-mCustomScrollbar.css">
    <!-- Connect to our style css -->
    <link rel="stylesheet" href="<?= BASEURL; ?>css/style.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>css/sidebar.css">

    <!-- Data Tabel -->
    <link rel="stylesheet" href="<?= BASEURL; ?>css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>css/buttons.bootstrap4.min.css">

    <!-- Fontawesom -->
    <script src="<?= BASEURL; ?>js/font-awesome-solid.js"></script>
    <script src="<?= BASEURL; ?>js/font-awesome.js"></script>
    <!-- Adding Chart.js -->
    <script type="text/javascript" src="<?= BASEURL; ?>js/Chart.js"></script>
    <title><?= $data['title_web'] ?></title>
</head>

<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>CBR Estimasi Level Obesitas</h3>
                <strong>CBR</strong>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="<?= BASEURL; ?>Home/">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?= BASEURL; ?>data/">
                        <i class="fas fa-database"></i>
                        <span>Data</span>
                    </a>
                </li>
                <li>
                    <a href="<?= BASEURL; ?>metode/">
                        <i class="fas fa-book"></i>
                        <span>Metode</span>
                    </a>
                </li>
                <li>
                    <a href="<?= BASEURL; ?>pengujian/">
                        <i class="fas fa-file-code"></i>
                        <span>Pengujian</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-list"></i>
                    </button>
                    <button class="btn btn-info d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <?php
                            if (isset($data['nav_list'])) {
                                foreach ($data['nav_list'] as $nav) {
                                    echo $nav;
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </nav>