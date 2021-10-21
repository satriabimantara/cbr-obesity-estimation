<?php
class Pengujian extends Controller
{
    private $data;
    private $threshold;
    public function __construct()
    {
        $this->data = array();
        $this->data['nav_list'] = $this->model("Navbar_list_model")->page_pengujian();
        $this->data['data_obesitas'] = $this->model("Data_model")->getAllData("obesitas_label");
        $this->data['centroids'] = $this->model("Data_model")->getAllData("pusat_kluster");
        $this->data['bobot_fitur'] = $this->model("Data_model")->getBobotFitur("Korelasi Pearson");
        $this->threshold = 0.8;
        $this->data['amount_data_uji'] = $this->model("Data_model")->getAmountData("kasus_uji");
    }
    public function index()
    {
        $this->data['title_web'] = "Pengujian";
        $this->view("templates/header", $this->data);
        $this->view("pengujian/index");
        $this->view("modals/pengujian_modals", $this->data);
        $this->view("templates/footer");
    }
    public function kasus_baru()
    {
        if (isset($_POST)) {
            $this->data['type_cbr'] = $_POST['methodType'];

            //pisahkan antara label encoder dan valuenya
            list($this->data['kasusbaru_transform'], $this->data['kasusbaru_original']) = $this->model("Kasus_model")->splitLabelValue($_POST);

            // normalisasi kasus baru yang berisi label (dalam bentuk angka)
            $this->data['kasusbaru_transform']  = $this->model("Kasus_model")->preprocessingKasus($this->data['kasusbaru_transform'], $this->data['data_obesitas']);


            if ($this->data['type_cbr'] == "CBR-KMeans") {
                //cari kluster terdekat 
                $indeks_kluster = $this->model("Kasus_model")->findClosestCluster($this->data['kasusbaru_transform'], $this->data['centroids']);
                $basis_kasus = $this->model("Data_model")->getAllBasisKasusPerKluster($indeks_kluster);
            } elseif ($this->data['type_cbr'] == "CBR") {
                $basis_kasus = $this->model("Data_model")->getAllData("basis_kasus");
            }

            //cari solusi kasus_baru
            $this->data['solution_case'] = $this->model("Kasus_model")->findSolution($this->data['kasusbaru_transform'], $basis_kasus, $this->data['bobot_fitur']);

            //embedded kasusbaru_transform dengan solusi yang diperoleh
            $this->data['kasusbaru_transform'] = $this->model("Kasus_model")->embeddedSolution($this->data['kasusbaru_transform'], $this->data['solution_case']);

            //cek threshold
            if ($this->data['kasusbaru_transform']['similarity'] < $this->threshold) {
                $this->data['kasusbaru_transform']['Obesity'] = "?";
                $this->data['kasusbaru_transform']['kluster'] = 0;
            }
            // input kasus_baru_original
            list($rowCountInsertKasusBaruOriginal, $lastID) = $this->model("Kasus_model")->insertKasusBaruOriginal($this->data['kasusbaru_original']);

            // input kasus_baru_transform
            $rowCountInsertKasusBaruTransform = $this->model("Kasus_model")->insertKasusBaruTransform($this->data['kasusbaru_transform'], $lastID);

            if ($rowCountInsertKasusBaruOriginal > 0 && $rowCountInsertKasusBaruTransform > 0) {
                if ($this->data['kasusbaru_transform']['similarity'] >= $this->threshold) {
                    //reuse
                    Flasher::setFlash("Solusi kasus baru", "berhasil", "ditemukan", "success");
                    header("Location: " . BASEURL . "pengujian/reuse/" . $lastID);
                    exit;
                } else {
                    //revise
                    Flasher::setFlash("Solusi kasus baru", "gagal", "ditemukan", "danger");
                    header("Location: " . BASEURL . "pengujian/revise/" . $lastID);
                    exit;
                }
            } else {
                //error occurs when inserting kasus baru into database
                Flasher::setFlash("Kasus baru", "gagal", "disimpan", "warning");
                header("Location: " . BASEURL . "pengujian/");
                exit;
            }
        }
    }
    public function kasus_uji()
    {
        if (isset($_POST)) {
            $this->data['kasus_uji'] = $this->model("Data_model")->getAllData("kasus_uji");
            /*
            Pengujian Kasus Uji CBR-KMeans
            */
            //reset kolom solusi_cbrkmeans pada kasus_uji
            $resetKolomKasusUji = $this->model("Data_model")->resetColumns(array("kluster", "solusi_cbrkmeans", "solusi_cbr", "similarity_cbrkmeans", "similarity_cbr"), "kasus_uji", array(0, "", "", 0, 0));

            if ($resetKolomKasusUji > 0) {
                $start_time_cbr_kmeans = time();
                foreach ($this->data['kasus_uji'] as $kasus_uji) {
                    $indeks_kluster = $this->model("Kasus_model")->findClosestCluster($kasus_uji, $this->data['centroids']);
                    $basis_kasus = $this->model("Data_model")->getAllBasisKasusPerKluster($indeks_kluster);

                    //cari solusi kasus_uji
                    $this->data['solution_case'] = $this->model("Kasus_model")->findSolution($kasus_uji, $basis_kasus, $this->data['bobot_fitur']);

                    //update kasus_uji untuk kolom kluster, solusi_cbrkmeans, similarity_cbrkmeans
                    $kluster = $this->data['solution_case']['kluster'];
                    $solusi_cbrkmeans = $this->data['solution_case']['Obesity'];
                    $similarity_cbrkmeans = $this->data['solution_case']['similarity'];
                    $rowUpdateKasusUjiCBRKMeans = $this->model("Data_model")->updateSolusiKasusUji($kasus_uji, array("kluster", "solusi_cbrkmeans", "similarity_cbrkmeans"), array($kluster, $solusi_cbrkmeans, $similarity_cbrkmeans));

                    if ($rowUpdateKasusUjiCBRKMeans == 0) {
                        //error, return to homepage
                        echo "ERROR";
                        break;
                    }
                }
                $end_time_cbr_kmeans = time();
                Session::setSession("waktu_cbrkmeans", gmdate("H:i:s", ($end_time_cbr_kmeans - $start_time_cbr_kmeans)));

                // pengujian kasus uji cbr
                $start_time_cbr = time();
                foreach ($this->data['kasus_uji'] as $kasus_uji) {
                    $basis_kasus = $this->model("Data_model")->getAllData("basis_kasus");

                    //cari solusi kasus_uji
                    $this->data['solution_case'] = $this->model("Kasus_model")->findSolution($kasus_uji, $basis_kasus, $this->data['bobot_fitur']);

                    //update kasus_uji untuk kolom kluster, solusi_cbrkmeans
                    $kluster = $this->data['solution_case']['kluster'];
                    $solusi_cbr = $this->data['solution_case']['Obesity'];
                    $similarity_cbr = $this->data['solution_case']['similarity'];
                    $rowUpdateKasusUjiCBR = $this->model("Data_model")->updateSolusiKasusUji($kasus_uji, array("kluster", "solusi_cbr", "similarity_cbr"), array($kluster, $solusi_cbr, $similarity_cbr));

                    if ($rowUpdateKasusUjiCBR == 0) {
                        //error, return to homepage
                        echo "ERROR";
                        break;
                    }
                }
                $end_time_cbr = time();
                Session::setSession("waktu_cbr", gmdate("H:i:s", ($end_time_cbr - $start_time_cbr)));
                Flasher::setFlash("Pengujian kasus uji", "berhasil", "dilakukan", "info");

                header("Location: " . BASEURL . "pengujian/pengujian_kasusuji");
                exit;
            } else {
                echo "ERROR RESET Kolom";
            }
        } else {
            //return to index, restricted from url
        }
    }

    public function reuse()
    {
        //rtrim url
        $urls = $_GET['url'];
        $lastID = $this->model("Metode_model")->findLastNumberURL($urls);
        if ($lastID == 0) {
            //return back to home and get message
            Flasher::setFlash("Fase Reuse", "diinterupsi", "URL Abort", "success");
            header("Location: " . BASEURL . "pengujian/");
            exit;
        } else {
            // ambil data kasus baru yang baru disimpan
            $this->data['kasusbaru_original'] = $this->model("Kasus_model")->getSpecificKasusBaru("kasusbaru_original", $lastID);
            $this->data['kasusbaru_transform'] = $this->model("Kasus_model")->getSpecificKasusBaru("kasusbaru_transform", $lastID);
            //ambil data basis kasus yang bersesuaian
            $this->data['basis_kasus'] = $this->model("Data_model")->getSpecificKasus("basis_kasus", $this->data['kasusbaru_transform']['id_obesitas']);
            $this->data['kolom_kasusbaru'] = $this->model("Kasus_model")->initializeColumns();
            $this->data['kolom_basiskasus'] = $this->model("Data_model")->getAllColumns();

            $this->data['title_web'] = "Solusi Kasus Baru";
            $this->view("templates/header", $this->data);
            $this->view("pengujian/reuse", $this->data);
            $this->view("modals/pengujian_modals", $this->data);
            $this->view("templates/footer");
        }
    }
    public function pengujian_kasusuji()
    {
        $this->data['kasus_uji'] = $this->model("Data_model")->getAllData("kasus_uji");
        $this->data['title_web'] = "Pengujian Kasus Uji";
        $this->data['waktu_cbrkmeans'] = Session::getSession("waktu_cbrkmeans");
        $this->data['waktu_cbr'] = Session::getSession("waktu_cbr");
        $this->data['akurasi_cbrkmeans'] = $this->model("Pengujian_model")->findAccuracy($this->data['kasus_uji'], "Obesity", "solusi_cbrkmeans");
        $this->data['akurasi_cbr'] = $this->model("Pengujian_model")->findAccuracy($this->data['kasus_uji'], "Obesity", "solusi_cbr");

        $this->view("templates/header", $this->data);
        $this->view("pengujian/pengujian_kasusuji", $this->data);
        $this->view("modals/pengujian_modals", $this->data);
        $this->view("templates/footer");
    }
    public function revise()
    {
        //rtrim url
        $urls = $_GET['url'];
        $lastID = $this->model("Metode_model")->findLastNumberURL($urls);
        if ($lastID == 0) {
            //return back to home and get message
            Flasher::setFlash("Fase Reuse", "diinterupsi", "URL Abort", "success");
            header("Location: " . BASEURL . "pengujian/");
            exit;
        } else {
            // ambil data kasus baru yang baru disimpan
            $this->data['kasusbaru_original'] = $this->model("Kasus_model")->getSpecificKasusBaru("kasusbaru_original", $lastID);
            $this->data['kasusbaru_transform'] = $this->model("Kasus_model")->getSpecificKasusBaru("kasusbaru_transform", $lastID);

            //ambil data basis kasus yang bersesuaian
            $this->data['basis_kasus'] = $this->model("Data_model")->getSpecificKasus("basis_kasus", $this->data['kasusbaru_transform']['id_obesitas']);
            $this->data['kolom_kasusbaru'] = $this->model("Kasus_model")->initializeColumns();
            $this->data['kolom_basiskasus'] = $this->model("Data_model")->getAllColumns();
            $this->data['id_kasusbaru_original'] = $lastID;

            //update kasusbaru_original untuk kolom revise
            $ifUpdateSuccess = $this->model("Data_model")->updateTable("kasusbaru_original", array("revise"), array("revise"), "id_kasusbaru_original", $lastID);

            if ($ifUpdateSuccess > 0) {
                $this->data['title_web'] = "Revise Kasus Baru";
                $this->view("templates/header", $this->data);
                $this->view("pengujian/revise", $this->data);
                $this->view("modals/pengujian_modals", $this->data);
                $this->view("templates/footer");
            } else {
                Flasher::setFlash("Update revise", "gagal", "dilakukan", "warning");
                header("Location: " . BASEURL . "pengujian/");
                exit;
            }
        }
    }
}
