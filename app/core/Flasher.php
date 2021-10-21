<?php
class Flasher
{

    // Buat method static agar tidak perlu instansiasi kelas
    public static function setFlash($nama_data, $pesan, $aksi, $tipe, $detail_message = [])
    {
        $_SESSION['flash'] = [
            'nama_data' => $nama_data,
            'pesan' => $pesan,
            'aksi' => $aksi,
            'tipe' => $tipe,
            'detail_message' => $detail_message
        ];
    }

    public static function flash()
    {
        // cek apakah ada session yang sudah diset?
        if (isset($_SESSION['flash'])) {
            echo '<div class="alert alert-' . $_SESSION['flash']['tipe'] . ' alert-dismissible fade show" role="alert">
            ' . $_SESSION['flash']['nama_data'] . ' <strong>' . $_SESSION['flash']['pesan'] . '</strong> ' . $_SESSION['flash']['aksi'] . '<br>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>';
            unset($_SESSION['flash']);
        }
    }
}
