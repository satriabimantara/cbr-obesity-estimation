<?php
// Database Wrapper
class Database
{
    private $db_host = DB_HOST;
    private $db_user = DB_USER;
    private $db_pass = DB_PASS;
    private $db_name = DB_NAME;

    private $dbh; //database handler
    private $stmt; //statement query

    public function __construct()
    {
        // Setiap instansiasi lakukan koneksi ke database dahulu
        // data source name
        $dsn = 'mysql:host=' . $this->db_host . ';dbname=' . $this->db_name;
        // Option
        $option = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        try {
            $this->dbh = new PDO($dsn, $this->db_user, $this->db_pass);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }
    public function bind_param($param, $value, $type = null)
    {
        // Tujuan bind_param untuk menghindari dari adanya sql injection
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        $this->stmt->execute();
    }
    public function lastID()
    {
        return $this->dbh->lastInsertId();
    }

    // Mendapatkan seluruh data
    public function result_set()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Mendapatkan hanya satu data
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Menghitung jumlah row yang masuk atau diedit
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}
