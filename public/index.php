<?php
// Cek jika belum ada session_id maka jalankan session
if (!session_id()) {
    session_start();
}

// Panggil init.php dari folder app, dimana init.php berisi semua file core
require_once '../app/init.php';
$app = new App();
