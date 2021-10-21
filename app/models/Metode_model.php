<?php
class Metode_model
{
    private $k;
    private $db;
    private $table_columns;
    private $max_loop;
    private $centroids;

    public function __construct()
    {
        $this->db = new Database;
        // KMeans Parameter
        $this->table_columns = $this->initializeColumns();
        $this->max_loop = 1000;
        $this->centroids = array();
    }

    public function initializeColumns()
    {
        $columns = array(
            'gender',
            'age',
            'height',
            'weight',
            'FHO',
            'FAVC',
            'FCVC',
            'NCP',
            'CAEC',
            'SMOKE',
            'CH2O',
            'SCC',
            'FAF',
            'TUE',
            'CALC',
            'MTRANS',
        );
        return $columns;
    }
    public function initializeCentroids($numberK, $data)
    {
        $centroids = array();
        for ($i = 0; $i < $numberK; $i++) {
            array_push($centroids, $data[rand(0, count($data) - 1)]);
        }
        return $centroids;
    }
    /*
    ====================
    KMEANS
    ===================
    */
    public function euclideanDistance($data, $centroid)
    {
        $centroid_distance = array();
        foreach ($data as $indeks_data  => $sample) {
            $sum = 0;
            foreach ($this->table_columns as $column) {
                $sum += pow(($sample[$column] - $centroid[$column]), 2);
            }
            $dist = sqrt($sum);
            array_push($centroid_distance, $dist);
        }
        return $centroid_distance;
    }
    public function findClusterData($data, $centroids_distance)
    {
        // indeks kluster dimulai dari 1,2,...,k, sehingga indeks_centroid+1
        foreach ($data as $indeks_data  => $sample) {
            $min = 999999;
            foreach ($centroids_distance as $indeks_centroid  => $centroid_distance) {
                if ($centroid_distance[$indeks_data] < $min) {
                    $min = $centroid_distance[$indeks_data];
                    $data[$indeks_data]["kluster"] = $indeks_centroid + 1;
                }
            }
        }
        return $data;
    }
    public function findNewCentroid($data_with_same_kluster)
    {
        $n_data = count($data_with_same_kluster);
        $new_centroid = array();
        if ($n_data == 0) {
            $n_data = 1;
        }
        // inisialisasi array dengan nol sesuai kolom yang ada
        foreach ($this->table_columns as $column) {
            $new_centroid[$column] = 0;
        }
        foreach ($data_with_same_kluster as $sample) {
            foreach ($this->table_columns as $column) {
                $new_centroid[$column] += $sample[$column];
            }
        }
        foreach ($this->table_columns as $column) {
            $new_centroid[$column] /= $n_data;
        }
        return $new_centroid;
    }
    public function checkConvergentCentroids($centroids, $new_centroids)
    {
        $selisih_centroid = array();
        $epsilon = 0.00000001;
        for ($indeks_kluster = 0; $indeks_kluster < $this->k; $indeks_kluster++) {
            $ifSame = 1;
            $selisih_centroid[$indeks_kluster] = array();
            foreach ($this->table_columns as $column) {
                if (round($centroids[$indeks_kluster][$column], 20) != round($new_centroids[$indeks_kluster][$column], 20)) {
                    $ifSame = 0;
                }
                array_push($selisih_centroid[$indeks_kluster], abs($centroids[$indeks_kluster][$column] - $new_centroids[$indeks_kluster][$column]));
            }
        }
        return array($ifSame, $selisih_centroid);
    }
    public function calculateSSE($data_with_same_kluster, $centroids)
    {
        $centroids_distance = array();
        $sum_of_sse = 0;
        for ($indeks_kluster = 0; $indeks_kluster < $this->k; $indeks_kluster++) {
            array_push($centroids_distance, $this->euclideanDistance($data_with_same_kluster[$indeks_kluster], $centroids[$indeks_kluster]));
            // kuadratkan hasil perhitungan
            foreach ($centroids_distance[$indeks_kluster] as $indeks => $value) {
                $centroids_distance[$indeks_kluster][$indeks] = pow($centroids_distance[$indeks_kluster][$indeks], 2);
                $sum_of_sse += $centroids_distance[$indeks_kluster][$indeks];
            }
        }
        return $sum_of_sse;
    }
    public function KMeans($data, $k)
    {
        $this->k = $k;
        $all_sse = array();
        $this->centroids = $this->initializeCentroids($this->k, $data);
        $centroids = $this->centroids;

        for ($indeks_looping = 0; $indeks_looping < $this->max_loop; $indeks_looping++) {
            /*
            Menghitung jarak data ke-i dengan semua centroid
            */
            $centroids_distance = array();
            for ($i = 0; $i < $this->k; $i++) {
                array_push($centroids_distance, $this->euclideanDistance($data, $centroids[$i]));
            }

            /*
            Cari jarak minimum data ke-i dengan k-kluster. Kluster dengan jarak
            minimum akan menjadi kluster bagi data ke-i, diperoleh data baru yang sudah diberi label kluster
            */
            $new_data = $this->findClusterData($data, $centroids_distance);

            /*
            Perbarui nilai centroids
            */
            $new_centroids = array();
            $data_with_same_cluster = array();
            for ($indeks_kluster = 0; $indeks_kluster < $this->k; $indeks_kluster++) {
                $data_with_same_cluster[$indeks_kluster] = array();
                foreach ($new_data as $indeks_data  => $sample) {
                    if ($sample['kluster'] == $indeks_kluster + 1) {
                        array_push($data_with_same_cluster[$indeks_kluster], $sample);
                    }
                }
                array_push($new_centroids, $this->findNewCentroid($data_with_same_cluster[$indeks_kluster]));
            }
            /*
            Cek kekonvergenan centroid lama dan new_centroid. Jika centroid_lama = new_centroid, break. Jika tidak lanjut iterasi berikutnya
            */
            list($ifKonvergen, $selisih_centroid) = $this->checkConvergentCentroids($centroids, $new_centroids);
            if ($ifKonvergen) {
                $sse = $this->calculateSSE($data_with_same_cluster, $centroids);
                array_push($all_sse, $sse);
                break;
            } else {
                $centroids = $new_centroids;
            }
        }
        /*
        return value berupa:
        - basis kasus terindeks
        - centroid optimal
        - nilai sse di setiap K
        */
        return array($new_data, $centroids, $all_sse);
    }
    /*
    ====================
    END KMEANS
    ===================
    */

    /*
    ====================
    ELBOW
    ===================
    */
    public function calculateElbow($data, $postData)
    {
        $SSE_allK = array();
        $selisih_SSE = array();
        $minK = $postData['inputJumlahMinimumKluster'];
        $maxK = $postData['inputJumlahMaksimumKluster'];
        $array_k = array();
        for ($indeks_kluster = $minK; $indeks_kluster <= $maxK; $indeks_kluster++) {
            array_push($array_k, $indeks_kluster);
            $SSE_allK[$indeks_kluster] = array();
            $selisih_SSE[$indeks_kluster] = array();
            list($new_data, $centroid_optimal, $all_sse) = $this->KMeans($data, $indeks_kluster);
            array_push($SSE_allK[$indeks_kluster], $all_sse[0]);
            // Hitung selisih
            if ($indeks_kluster == $minK) {
                array_push($selisih_SSE[$indeks_kluster], 0);
            } else {
                $now = $SSE_allK[$indeks_kluster][0];
                $before = $SSE_allK[$indeks_kluster - 1][0];
                array_push($selisih_SSE[$indeks_kluster], abs($now - $before));
            }
        }
        return array($SSE_allK, $selisih_SSE, $array_k);
    }
    /*
    ====================
    END ELBOW
    ===================
    */
    /*
    ====================
    UTILS
    ===================
    */
    public function findLastNumberURL($urls)
    {
        $urls = rtrim($urls, '/');
        $urls = filter_var($urls, FILTER_SANITIZE_URL);
        $urls = explode('/', $urls);
        if (count($urls) > 3) {
            while (count($urls) > 3) {
                array_pop($urls);
            }
        }
        $number = $urls[count($urls) - 1];
        if (ord($number) >= 49 && ord($number) <= 57) {
            //number without '0'
            return $number;
        } else {
            return 0;
        }
    }
}
