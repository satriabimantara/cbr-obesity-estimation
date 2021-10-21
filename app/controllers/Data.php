<?php
class Data extends Controller
{
    private $data;
    public function __construct()
    {
        $this->data = array();
        $this->data['title_web'] = "Data";
        $this->data['nav_list'] = $this->model("Navbar_list_model")->page_data();
        $this->data['daftar_data'] = $this->model("Data_model")->getAllData("obesitas_transform");
        $this->data['daftar_kolom'] = $this->model("Data_model")->getAllColumns();
        $this->data['jumlah_basis_kasus'] = $this->model("Data_model")->getAmountData("basis_kasus");
        $this->data['jumlah_kasus_uji'] = $this->model("Data_model")->getAmountData("kasus_uji");
    }
    public function index()
    {
        $this->view("templates/header", $this->data);
        $this->view("data/index", $this->data);
        $this->view("modals/data_modals");
        $this->view("templates/footer");
    }
    public function data_original()
    {
        $this->data['daftar_data'] = $this->model("Data_model")->getAllData("obesitas_original");

        $this->view("templates/header", $this->data);
        $this->view("data/data-original", $this->data);
        $this->view("modals/data_modals");
        $this->view("templates/footer");
    }
    public function data_normalisasi()
    {
        $this->view("templates/header", $this->data);
        $this->view("data/data-normalisasi", $this->data);
        $this->view("modals/data_modals");
        $this->view("templates/footer");
    }
    public function splitting_data()
    {
        if (isset($_POST)) {
            $error = $this->model("Data_model")->splittingData($_POST, $this->data['daftar_data']);
            if ($error['ifError'] == 0) {
                Flasher::setFlash("Pembagian Data Set", "berhasil", "dilakukan", "success");
            } else {
                Flasher::setFlash("Pembagian Data Set", "gagal", "dilakukan", "danger", $error['messages']);
            }
            header("Location: " . BASEURL . "data/");
            exit;
        }
    }
    public function basis_kasus()
    {
        $this->data['daftar_data'] = $this->model("Data_model")->getAllData("basis_kasus");
        $this->data['title_web'] = "Basis Kasus";
        $this->view("templates/header", $this->data);
        $this->view("data/basis_kasus", $this->data);
        $this->view("modals/data_modals");
        $this->view("templates/footer");
    }
    public function kasus_uji()
    {
        $this->data['daftar_data'] = $this->model("Data_model")->getAllData("kasus_uji");
        $this->data['title_web'] = "Basis Kasus";
        $this->view("templates/header", $this->data);
        $this->view("data/kasus_uji", $this->data);
        $this->view("modals/data_modals");
        $this->view("templates/footer");
    }
    public function kasus_baru()
    {
        $this->data['daftar_data'] = $this->model("Data_model")->getAllDataKasusBaru();
        $this->data['title_web'] = "Kasus Baru";
        array_push($this->data['daftar_kolom'], "similarity");
        array_push($this->data['daftar_kolom'], "revise");

        $this->view("templates/header", $this->data);
        $this->view("data/kasus_baru", $this->data);
        $this->view("modals/data_modals");
        $this->view("templates/footer");
    }
    public function getKasusBaru()
    {
        echo json_encode($this->model('Data_model')->getAllDataKasusBaruById($_POST['id']));
    }
    public function revise()
    {
        if (isset($_POST)) {
            $id_kasusbaru_original  = $_POST['id_kasusbaru_original'];
            $Obesity  = $_POST['Obesity'];
            $updateKasusBaruOriginal = $this->model("Data_model")->updateTable("kasusbaru_original", array("revise"), array("Success"), "id_kasusbaru_original", $id_kasusbaru_original);
            $updateKasusBaruTransform = $this->model("Data_model")->updateTable("kasusbaru_transform", array("Obesity"), array($Obesity), "id_kasusbaru_original", $id_kasusbaru_original);

            if ($updateKasusBaruTransform > 0) {
                Flasher::setFlash("Kasus baru", "berhasil", "direvise", "success");
            } else {
                Flasher::setFlash("Kasus baru", "gagal", "direvise", "danger");
            }
            header("Location: " . BASEURL . "data/kasus_baru");
            exit;
        }
    }
    public function hapus_kasusbaru()
    {
        //rtrim url
        $urls = $_GET['url'];
        $id = $this->model("Metode_model")->findLastNumberURL($urls);
        if ($id == 0) {
            //return back to home and get message
            Flasher::setFlash("Proses", "diinterupsi", "URL Abort", "danger");
            header("Location: " . BASEURL . "data/");
            exit;
        } else {
            //delete kasus baru
            $rowDeleteKasusBaruOriginal = $this->model("Kasus_model")->deleteDataById("kasusbaru_original", "id_kasusbaru_original", $id);
            $rowDeleteKasusBaruTransform = $this->model("Kasus_model")->deleteDataById("kasusbaru_transform", "id_kasusbaru_original", $id);
            if ($rowDeleteKasusBaruOriginal > 0 && $rowDeleteKasusBaruTransform > 0) {
                //berhasil delete
                Flasher::setFlash("Kasus baru", "berhasil", "dihapus", "success");
            } else {
                //gagal delete
                Flasher::setFlash("Kasus baru", "gagal", "dihapus", "success");
            }
            header("Location: " . BASEURL . "data/kasus_baru");
            exit;
        }
    }
}
