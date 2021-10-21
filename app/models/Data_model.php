<?php
class Data_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllData($tables)
    {
        $query = "SELECT * FROM $tables";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->result_set();
    }
    public function getAmountData($table)
    {
        $query = "SELECT COUNT(*) AS amount FROM $table";
        $this->db->query($query);
        $this->db->execute();
        $data = $this->db->single();
        return $data['amount'];
    }
    public function getAllBasisKasusPerKluster($kluster)
    {
        $query = "SELECT * FROM basis_kasus WHERE kluster=:kluster";
        $this->db->query($query);
        $this->db->bind_param("kluster", $kluster);
        $this->db->execute();
        return $this->db->result_set();
    }
    public function getBobotFitur($kode)
    {
        $query = "SELECT * FROM bobot_fitur WHERE kode=:kode";
        $this->db->query($query);
        $this->db->bind_param("kode", $kode);
        $this->db->execute();
        return $this->db->single();
    }
    public function getAllColumns()
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
            'Obesity',
            'kluster'
        );
        return $columns;
    }
    public function getSpecificKasus($table, $id_obesitas)
    {
        $query = "SELECT * FROM $table WHERE id_obesitas=:id_obesitas";
        $this->db->query($query);
        $this->db->bind_param("id_obesitas", $id_obesitas);
        $this->db->execute();
        return $this->db->single();
    }
    public function getAllDataKasusBaru()
    {
        $query = "SELECT * FROM kasusbaru_transform INNER JOIN kasusbaru_original USING(id_kasusbaru_original)";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->result_set();
    }
    public function getAllDataKasusBaruById($id_kasusbaru_original)
    {
        $query = "SELECT * FROM kasusbaru_transform INNER JOIN kasusbaru_original USING(id_kasusbaru_original) WHERE id_kasusbaru_original=:id_kasusbaru_original";
        $this->db->query($query);
        $this->db->bind_param("id_kasusbaru_original", $id_kasusbaru_original);
        $this->db->execute();
        return $this->db->result_set();
    }
    public function insertNewKasus($data, $table)
    {
        if ($table == "kasus_uji") {
            $query = "INSERT INTO " . $table . " VALUES (:id_obesitas,:gender,:age,:height,:weight,:FHO,:FAVC,:FCVC,:NCP,:CAEC,:SMOKE,:CH2O,:SCC,:FAF,:TUE,:CALC,:MTRANS,:Obesity,:kluster,:solusi_cbr,:solusi_cbrkmeans,:similarity_cbr,:similarity_cbrkmeans)";
            $this->db->query($query);
            $this->db->bind_param("solusi_cbr", null);
            $this->db->bind_param("solusi_cbrkmeans", null);
            $this->db->bind_param("similarity_cbr", 0);
            $this->db->bind_param("similarity_cbrkmeans", 0);
        } else {
            $query = "INSERT INTO " . $table . " VALUES (:id_obesitas,:gender,:age,:height,:weight,:FHO,:FAVC,:FCVC,:NCP,:CAEC,:SMOKE,:CH2O,:SCC,:FAF,:TUE,:CALC,:MTRANS,:Obesity,:kluster)";
            $this->db->query($query);
        }
        $this->db->bind_param("id_obesitas", $data['id_obesitas']);
        $this->db->bind_param("gender", $data['gender']);
        $this->db->bind_param("age", $data['age']);
        $this->db->bind_param("height", $data['height']);
        $this->db->bind_param("weight", $data['weight']);
        $this->db->bind_param("FHO", $data['FHO']);
        $this->db->bind_param("FAVC", $data['FAVC']);
        $this->db->bind_param("FCVC", $data['FCVC']);
        $this->db->bind_param("NCP", $data['NCP']);
        $this->db->bind_param("CAEC", $data['CAEC']);
        $this->db->bind_param("SMOKE", $data['SMOKE']);
        $this->db->bind_param("CH2O", $data['CH2O']);
        $this->db->bind_param("SCC", $data['SCC']);
        $this->db->bind_param("FAF", $data['FAF']);
        $this->db->bind_param("TUE", $data['TUE']);
        $this->db->bind_param("CALC", $data['CALC']);
        $this->db->bind_param("MTRANS", $data['MTRANS']);
        $this->db->bind_param("Obesity", $data['Obesity']);
        $this->db->bind_param("kluster", $data['kluster']);
        $this->db->execute();
        return $this->db->rowCount();
    }
    public function insertNilaiCentroidOptimal($centroids)
    {
        $delete_error = 0;
        //check kalau tabel pusat_kluster tidak kosong
        if ($this->getAmountData("pusat_kluster") != 0) {
            // Bersihkan tabel pusat_kluster
            $num_delete_1 = $this->deleteAllData("pusat_kluster");
            if ($num_delete_1 <= 0) {
                $delete_error = 1;
            }
        }
        $row_count = array();
        foreach ($centroids as $indeks_centroid => $centroid) {
            $query = "INSERT INTO pusat_kluster VALUES (:gender,:age,:height,:weight,:FHO,:FAVC,:FCVC,:NCP,:CAEC,:SMOKE,:CH2O,:SCC,:FAF,:TUE,:CALC,:MTRANS,:kluster)";
            $this->db->query($query);
            $this->db->bind_param("gender", $centroid['gender']);
            $this->db->bind_param("age", $centroid['age']);
            $this->db->bind_param("height", $centroid['height']);
            $this->db->bind_param("weight", $centroid['weight']);
            $this->db->bind_param("FHO", $centroid['FHO']);
            $this->db->bind_param("FAVC", $centroid['FAVC']);
            $this->db->bind_param("FCVC", $centroid['FCVC']);
            $this->db->bind_param("NCP", $centroid['NCP']);
            $this->db->bind_param("CAEC", $centroid['CAEC']);
            $this->db->bind_param("SMOKE", $centroid['SMOKE']);
            $this->db->bind_param("CH2O", $centroid['CH2O']);
            $this->db->bind_param("SCC", $centroid['SCC']);
            $this->db->bind_param("FAF", $centroid['FAF']);
            $this->db->bind_param("TUE", $centroid['TUE']);
            $this->db->bind_param("CALC", $centroid['CALC']);
            $this->db->bind_param("MTRANS", $centroid['MTRANS']);
            $this->db->bind_param("kluster", ($indeks_centroid + 1));
            $this->db->execute();
            array_push($row_count, $this->db->rowCount());
        }
        if (in_array(0, $row_count) || $delete_error == 1) {
            //occurs error
            return 0;
        } else {
            return 1;
        }
    }

    public function updateSolusiKasusUji($kasus_uji, $columns, $values_columns)
    {
        $row_count = array();
        $concate_columns = "";
        for ($indeks_kolom = 0; $indeks_kolom < count($columns); $indeks_kolom++) {
            if ($indeks_kolom == count($columns) - 1) {
                $concate_columns .= $columns[$indeks_kolom];
                $concate_columns .= "=:";
                $concate_columns .= $columns[$indeks_kolom];
            } else {
                $concate_columns .= $columns[$indeks_kolom];
                $concate_columns .= "=:";
                $concate_columns .= $columns[$indeks_kolom];
                $concate_columns .= ",";
            }
        }
        $query = "UPDATE kasus_uji SET
                    $concate_columns
                WHERE id_obesitas=:id_obesitas";
        $this->db->query($query);
        foreach ($columns as $indeks_column  => $column) {
            $this->db->bind_param($column, $values_columns[$indeks_column]);
        }
        $this->db->bind_param("id_obesitas", $kasus_uji['id_obesitas']);
        $this->db->execute();
        $row = $this->db->rowCount();
        array_push($row_count, $row);
        if (in_array(0, $row_count)) {
            //occurs error
            return 0;
        } else {
            return 1;
        }
    }
    public function updateTable($table, $columns, $values_columns, $id_condition, $value_id_condition)
    {
        $row_count = array();
        $concate_columns = "";
        for ($indeks_kolom = 0; $indeks_kolom < count($columns); $indeks_kolom++) {
            if ($indeks_kolom == count($columns) - 1) {
                $concate_columns .= $columns[$indeks_kolom];
                $concate_columns .= "=:";
                $concate_columns .= $columns[$indeks_kolom];
            } else {
                $concate_columns .= $columns[$indeks_kolom];
                $concate_columns .= "=:";
                $concate_columns .= $columns[$indeks_kolom];
                $concate_columns .= ",";
            }
        }
        $where_statement = $id_condition . "=:" . $id_condition;
        $query = "UPDATE $table SET
                    $concate_columns
                WHERE $where_statement";
        $this->db->query($query);
        foreach ($columns as $indeks_column  => $column) {
            $this->db->bind_param($column, $values_columns[$indeks_column]);
        }
        $this->db->bind_param($id_condition, $value_id_condition);
        $this->db->execute();
        $row = $this->db->rowCount();
        array_push($row_count, $row);
        if (in_array(0, $row_count)) {
            //occurs error
            return 0;
        } else {
            return 1;
        }
    }
    public function updateKlusterBasisKasus($basisKasus)
    {
        $row_count = array();
        foreach ($basisKasus as $indeks_kasus  => $kasus) {
            $query = "UPDATE basis_kasus SET
                    kluster = :kluster
                WHERE id_obesitas=:id_obesitas";
            $this->db->query($query);
            $this->db->bind_param("kluster", $kasus['kluster']);
            $this->db->bind_param("id_obesitas", $kasus['id_obesitas']);
            $this->db->execute();
            $row = $this->db->rowCount();
            array_push($row_count, $row);
        }
        if (in_array(0, $row_count)) {
            //occurs error
            return 0;
        } else {
            return 1;
        }
    }
    public function deleteAllData($table)
    {
        $query = "DELETE FROM $table";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->rowCount();
    }
    public function resetColumns($columns, $table, $values)
    {
        $concate_columns = "";
        for ($indeks_kolom = 0; $indeks_kolom < count($columns); $indeks_kolom++) {
            if ($indeks_kolom == count($columns) - 1) {
                $concate_columns .= $columns[$indeks_kolom];
                $concate_columns .= "=:";
                $concate_columns .= $columns[$indeks_kolom];
            } else {
                $concate_columns .= $columns[$indeks_kolom];
                $concate_columns .= "=:";
                $concate_columns .= $columns[$indeks_kolom];
                $concate_columns .= ",";
            }
        }
        $query = "UPDATE $table SET $concate_columns";
        $this->db->query($query);
        foreach ($columns as $indeks_column  => $column) {
            $this->db->bind_param($column, $values[$indeks_column]);
        }
        $this->db->execute();
        return $this->db->rowCount();
    }


    public function splittingData($postData, $data)
    {
        $persenBasisKasus = $postData['inputJumlahDataLatih'];
        $persenKasusUji = $postData['inputJumlahDataUji'];
        $amount_data = $this->getAmountData("obesitas_transform");
        $error = array(
            'ifError' => 0,
            'messages' => array()
        );
        //check kalau tabel basis kasus dan kasus uji tidak kosong
        if ($this->getAmountData("basis_kasus") != 0) {
            // Bersihkan tabel basis kasus
            $num_delete_1 = $this->deleteAllData("basis_kasus");
            if ($num_delete_1 <= 0) {
                $error['ifError'] = 1;
                array_push($error['messages'], "Terjadi kesalahan saat menghapus data basis kasus");
            }
        }
        if ($this->getAmountData("kasus_uji") != 0) {
            // Bersihkan tabel kasus uji
            $num_delete_2 = $this->deleteAllData("kasus_uji");
            if ($num_delete_2 <= 0) {
                array_push($error['messages'], "Terjadi kesalahan saat menghapus data uji");
            }
        }
        for ($i = 0; $i < 2111; $i++) {
            shuffle($data);
        }
        // splitting data
        $n_basis_kasus = round($amount_data * $persenBasisKasus / 100);
        $n_kasus_uji = $amount_data - $n_basis_kasus;
        for ($indeks_kasus = 0; $indeks_kasus < $n_basis_kasus; $indeks_kasus++) {
            //masukkan ke basis kasus
            if ($this->insertNewKasus($data[$indeks_kasus], "basis_kasus") <= 0) {
                // error happens
                $error['ifError'] = 1;
                array_push($error['messages'], "Terjadi kesalahan saat menginput data ke basis kasus");
                break;
            }
        }
        for ($indeks_kasus = $n_basis_kasus; $indeks_kasus < $amount_data; $indeks_kasus++) {
            if ($this->insertNewKasus($data[$indeks_kasus], "kasus_uji") <= 0) {
                //error happens
                $error['ifError'] = 1;
                array_push($error['messages'], "Terjadi kesalahan saat menginput data ke kasus uji");
                break;
            };
        }
        return $error;
    }
}
