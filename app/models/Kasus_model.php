<?php
class Kasus_model
{
    private $db;
    private $columns;
    private $threshold;
    private $range_atribut;
    public function __construct()
    {
        $this->db = new Database;
        $this->columns = $this->initializeColumns();
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

    /*
    FUNCTION untuk memisahkan label dan value dari kasus baru
    */
    public function splitLabelValue($case)
    {
        $kasusbaru_original = array();
        $kasusbaru_transform = array();
        foreach ($this->columns as $column) {
            $input = explode("*", $case[$column]);
            $kasusbaru_transform[$column] = $input[0];
            if (count($input) == 2) {
                //kolom kategori
                $kasusbaru_original[$column] = $input[1];
            } else {
                //kolom numerik
                $kasusbaru_original[$column] = $input[0];
            }
        }
        return array($kasusbaru_transform, $kasusbaru_original);
    }
    public function findMaxMinColumn($column, $data_obesitas)
    {
        $min = 999;
        $max = 0;
        foreach ($data_obesitas as $indeks_kasus  => $kasus) {
            $val = floatval($kasus[$column]);
            if ($val < $min) {
                $min = $val;
            }
            if ($val > $max) {
                $max = $val;
            }
        }
        return array($max, $min);
    }
    public function preprocessingKasus($kasusbaru_transform, $data_obesitas)
    {
        /*
        x' = x - min(x) / max(x) - min(x)
        */
        $columns_nominal_biner = array(
            'gender', 'MTRANS', 'FHO', 'FCVC', 'SMOKE', 'SCC'
        );
        foreach ($this->columns as $column) {
            if (!in_array($column, $columns_nominal_biner)) {
                //cari nilai max-min di setiap kolom pada basis kasus
                list($max, $min) = $this->findMaxMinColumn($column, $data_obesitas);
                $x = $kasusbaru_transform[$column];
                $x_normalized = ($x - $min) / ($max - $min);
                $kasusbaru_transform[$column] = $x_normalized;
            }
        }
        return $kasusbaru_transform;
    }
    public function euclidNorm($vector)
    {
        $sum = 0;
        foreach ($this->columns as $column) {
            $sum += pow($vector[$column], 2);
        }
        $norm_vector = sqrt($sum);
        return $norm_vector;
    }
    public function cosineSimilarity($u, $v)
    {
        $dot_sum = 0;
        //find u.v
        foreach ($this->columns as $column) {
            $dot_sum += $u[$column] * $v[$column];
        }
        //find |u| & |v|
        $norm_u = $this->euclidNorm($u);
        $norm_v = $this->euclidNorm($v);
        //find cosine
        $cosine_distance = $dot_sum / ($norm_u * $norm_v);

        return $cosine_distance;
    }
    public function findClosestCluster($kasusbaru_transform, $centroids)
    {
        $distance_case_to_centroids = array();
        foreach ($centroids as $centroid) {
            $cosine_distance = $this->cosineSimilarity($kasusbaru_transform, $centroid);
            array_push($distance_case_to_centroids, array($centroid['kluster'] => $cosine_distance));
        }
        //cari jarak cosine paling maksimum
        $max = -1;
        $kluster = 0;
        foreach ($distance_case_to_centroids as $indeks  => $cosine_distance) {
            foreach ($cosine_distance as $idx_kluster  => $cos) {
                if ($cos > $max) {
                    $max = $cos;
                    $kluster = $idx_kluster;
                }
            }
        }
        return $kluster;
    }

    public function weightedSum($bobot_fitur)
    {
        $sum = 0;
        foreach ($this->columns as $column) {
            $sum += pow($bobot_fitur[$column], 2);
        }
        return $sum;
    }
    public function findSolution($kasusbaru_transform, $basis_kasus, $bobot_fitur)
    {
        $columns_nominal_biner = array(
            'gender', 'MTRANS', 'FHO', 'FCVC', 'SMOKE', 'SCC'
        );
        $similarity_cases = array();
        $highest_similarity = -1;
        $case_with_highest_similarity = array();
        $weighted_sum = $this->weightedSum($bobot_fitur);
        foreach ($basis_kasus as $indeks_kasus  => $kasus) {
            $sim_case = 0;
            foreach ($this->columns as $column) {
                $source = $kasus[$column];
                $target = $kasusbaru_transform[$column];
                $bobot_kolom = $bobot_fitur[$column];
                //kolom nominal atau biner
                if (in_array($column, $columns_nominal_biner)) {
                    if ($source == $target) {
                        $sim_case += (pow($bobot_kolom, 2) * 1);
                    } else {
                        $sim_case += (pow($bobot_kolom, 2) * 0);
                    }
                } else {
                    // kolom ordinal atau numerik
                    $sim_case += pow($bobot_kolom, 2) * (1 - (abs($source - $target)));
                }
            }
            $sim_case = sqrt($sim_case / $weighted_sum);
            array_push($similarity_cases, array($kasus['id_obesitas'] => $sim_case));
            //cari nilai sim_case terbesar
            if ($sim_case > $highest_similarity) {
                $highest_similarity = $sim_case;
                $case_with_highest_similarity = $kasus;
            }
        }
        $case_with_highest_similarity['similarity'] = $highest_similarity;
        return $case_with_highest_similarity;
    }
    public function embeddedSolution($kasusbaru_transform, $solution_case)
    {
        $kasusbaru_transform['id_obesitas'] = $solution_case['id_obesitas'];
        $kasusbaru_transform['Obesity'] = $solution_case['Obesity'];
        $kasusbaru_transform['similarity'] = $solution_case['similarity'];
        $kasusbaru_transform['kluster'] = $solution_case['kluster'];
        return $kasusbaru_transform;
    }

    //DATABASE
    public function getSpecificKasusBaru($table, $id_kasusbaru_original)
    {
        $query = "SELECT * FROM $table WHERE id_kasusbaru_original=:id_kasusbaru_original";
        $this->db->query($query);
        $this->db->bind_param("id_kasusbaru_original", $id_kasusbaru_original);
        $this->db->execute();
        return $this->db->single();
    }
    public function insertKasusBaruOriginal($kasusbaru_original)
    {
        $query = "INSERT INTO kasusbaru_original VALUES ('',:gender,:age,:height,:weight,:FHO,:FAVC,:FCVC,:NCP,:CAEC,:SMOKE,:CH2O,:SCC,:FAF,:TUE,:CALC,:MTRANS,:revise)";
        $this->db->query($query);
        $this->db->bind_param("gender", $kasusbaru_original['gender']);
        $this->db->bind_param("age", $kasusbaru_original['age']);
        $this->db->bind_param("height", $kasusbaru_original['height']);
        $this->db->bind_param("weight", $kasusbaru_original['weight']);
        $this->db->bind_param("FHO", $kasusbaru_original['FHO']);
        $this->db->bind_param("FAVC", $kasusbaru_original['FAVC']);
        $this->db->bind_param("FCVC", $kasusbaru_original['FCVC']);
        $this->db->bind_param("NCP", $kasusbaru_original['NCP']);
        $this->db->bind_param("CAEC", $kasusbaru_original['CAEC']);
        $this->db->bind_param("SMOKE", $kasusbaru_original['SMOKE']);
        $this->db->bind_param("CH2O", $kasusbaru_original['CH2O']);
        $this->db->bind_param("SCC", $kasusbaru_original['SCC']);
        $this->db->bind_param("FAF", $kasusbaru_original['FAF']);
        $this->db->bind_param("TUE", $kasusbaru_original['TUE']);
        $this->db->bind_param("CALC", $kasusbaru_original['CALC']);
        $this->db->bind_param("MTRANS", $kasusbaru_original['MTRANS']);
        $this->db->bind_param("revise", "Success");
        $this->db->execute();
        $last_id = $this->db->lastID();
        return array($this->db->rowCount(), $last_id);
    }
    public function insertKasusBaruTransform($kasusbaru_transform, $id_kasusbaru_original)
    {
        $query = "INSERT INTO kasusbaru_transform VALUES ('',:gender,:age,:height,:weight,:FHO,:FAVC,:FCVC,:NCP,:CAEC,:SMOKE,:CH2O,:SCC,:FAF,:TUE,:CALC,:MTRANS,:Obesity,:kluster,:id_kasusbaru_original,:id_obesitas,:similarity)";
        $this->db->query($query);
        $this->db->bind_param("gender", $kasusbaru_transform['gender']);
        $this->db->bind_param("age", $kasusbaru_transform['age']);
        $this->db->bind_param("height", $kasusbaru_transform['height']);
        $this->db->bind_param("weight", $kasusbaru_transform['weight']);
        $this->db->bind_param("FHO", $kasusbaru_transform['FHO']);
        $this->db->bind_param("FAVC", $kasusbaru_transform['FAVC']);
        $this->db->bind_param("FCVC", $kasusbaru_transform['FCVC']);
        $this->db->bind_param("NCP", $kasusbaru_transform['NCP']);
        $this->db->bind_param("CAEC", $kasusbaru_transform['CAEC']);
        $this->db->bind_param("SMOKE", $kasusbaru_transform['SMOKE']);
        $this->db->bind_param("CH2O", $kasusbaru_transform['CH2O']);
        $this->db->bind_param("SCC", $kasusbaru_transform['SCC']);
        $this->db->bind_param("FAF", $kasusbaru_transform['FAF']);
        $this->db->bind_param("TUE", $kasusbaru_transform['TUE']);
        $this->db->bind_param("CALC", $kasusbaru_transform['CALC']);
        $this->db->bind_param("MTRANS", $kasusbaru_transform['MTRANS']);
        $this->db->bind_param("Obesity", $kasusbaru_transform['Obesity']);
        $this->db->bind_param("id_kasusbaru_original", $id_kasusbaru_original);
        $this->db->bind_param("kluster", $kasusbaru_transform['kluster']);
        $this->db->bind_param("id_obesitas", $kasusbaru_transform['id_obesitas']);
        $this->db->bind_param("similarity", $kasusbaru_transform['similarity']);
        $this->db->execute();
        return $this->db->rowCount();
    }
    public function deleteDataById($table, $id_column, $value_id_column)
    {
        $query = 'DELETE FROM ' . $table . ' WHERE ' . $id_column . '=' . $value_id_column;
        $this->db->query($query);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
