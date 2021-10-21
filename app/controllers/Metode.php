<?php
class Metode extends Controller
{
    private $data;
    public function __construct()
    {
        $this->data = array();
        $this->data['title_web'] = "Metode Penelitian";
        $this->data['nav_list'] = $this->model("Navbar_list_model")->page_metode();
        // Retrieve data
        $this->data['dataset'] = $this->model("Data_model")->getAllData("basis_kasus");
        $this->data['amount_data'] = $this->model("Data_model")->getAmountData("basis_kasus");

        // Variabel untuk perhitungan Elbow
        $this->data['sse_elbow'] = array();
        $this->data['selisih_sse'] = array();
    }
    public function index()
    {

        $this->view("templates/header", $this->data);
        $this->view("metode/index");
        $this->view("modals/metode_modals", $this->data);
        $this->view("templates/footer");
    }

    public function elbow()
    {
        if (isset($_POST)) {
            list($this->data['sse_elbow'], $this->data['selisih_sse'], $this->data['array_k']) = $this->model("Metode_model")->calculateElbow($this->data['dataset'], $_POST);
        }
        $this->data['title_web'] = "Kluster Optimal";
        $this->view("templates/header", $this->data);
        $this->view("metode/kluster_optimal", $this->data);
        $this->view("modals/metode_modals", $this->data);
        $this->view("templates/footer");
    }

    public function kmeans()
    {
        if (isset($_POST)) {
            $k = $_POST['jumlahKOptimal'];
            //reset kluster basis kasus
            $resetKlusterBasisKasus = $this->model("Data_model")->resetColumns(array("kluster"), "basis_kasus", array(0));

            if ($resetKlusterBasisKasus > 0) {
                $this->data['dataset'] = $this->model("Data_model")->getAllData("basis_kasus");
            }
            list($basisKasusTerindeks, $centroids, $sse) = $this->model("Metode_model")->KMeans($this->data['dataset'], $k);

            //update basis kasus yang sudah berisi indeks
            $updateKlusterBasisKasus =  $this->model("Data_model")->updateKlusterBasisKasus($basisKasusTerindeks);
            //simpan nilai centroid optimal
            $saveCentroid = $this->model("Data_model")->insertNilaiCentroidOptimal($centroids);

            if (($updateKlusterBasisKasus > 0) && ($saveCentroid > 0)) {
                Flasher::setFlash("Update Indeks Basis Kasus dan Simpan Centroid", "berhasil", "dilakukan", "success");
            } else {
                //error updating
                Flasher::setFlash("Update Indeks Basis Kasus dan Simpan Centroid", "gagal", "dilakukan", "danger");
            }
            header("Location: " . BASEURL . "metode/");
            exit;
        }
    }
}
