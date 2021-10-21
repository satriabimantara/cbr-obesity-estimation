<?php
class Navbar_list_model
{
    private $data;
    public function __construct()
    {
        $this->data = array();
    }
    public function page_data()
    {
        $this->data['nav_list'] = array(
            'nav-item-1' => ' <li class="nav-item"><a class="nav-link" href="' . BASEURL . 'data/data_original">Data Asli</a></li>',
            'nav-item-2' => ' <li class="nav-item"><a class="nav-link" href="' . BASEURL . 'data/data_normalisasi">Data Hasil Normalisasi</a></li>',
            'nav-item-3' => ' <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#modalSplittingData" href="' . BASEURL . 'data/">Pembagian Data Set</a></li>',
            'nav-item-4' => ' <li class="nav-item"><a class="nav-link" href="' . BASEURL . 'data/basis_kasus">Basis Kasus</a></li>',
            'nav-item-5' => ' <li class="nav-item"><a class="nav-link" href="' . BASEURL . 'data/kasus_uji">Kasus Uji</a></li>',
            'nav-item-6' => ' <li class="nav-item"><a class="nav-link" href="' . BASEURL . 'data/kasus_baru">Kasus Baru</a></li>',

        );
        return $this->data['nav_list'];
    }
    public function page_metode()
    {
        $this->data['nav_list'] = array(
            'nav-item-1' => ' <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#modalCariKlusterOptimal" href="' . BASEURL . 'metode/">Cari Kluster Optimal</a></li>',
            'nav-item-2' => ' <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#modalKMeans" href="' . BASEURL . 'metode/">Indexing K-Means</a></li>',
        );
        return $this->data['nav_list'];
    }
    public function page_pengujian()
    {
        $this->data['nav_list'] = array(
            'nav-item-1' => ' <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#modalPengujianKasusBaru" href="' . BASEURL . 'pengujian/">Kasus Baru</a></li>',
            'nav-item-2' => ' <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#modalPengujianKasusUji" href="' . BASEURL . 'pengujian/kasus_uji">Kasus Uji</a></li>',
        );
        return $this->data['nav_list'];
    }
}
